<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

use Lunar\Models\Brand;
use Lunar\Models\Product;
use Lunar\Models\ProductVariant;
use Lunar\Models\ProductOption;
use Lunar\Models\ProductType;
use Lunar\Models\ProductOptionValue;
use Lunar\Models\Collection;
use Lunar\Models\Url;
use Lunar\Models\Currency;
use Lunar\Models\TaxClass;
use Lunar\Models\Tag;
use Lunar\Models\Language;
use Lunar\FieldTypes\Text;
use Lunar\FieldTypes\TranslatedText;
use App\Models\Woo;

class ImportWoocommerceCommand extends Command
{
    /*
     * php artisan app:import filename:export-prodotti.xlsx
     */
    protected $signature = 'app:import
                                 {filename : Il nome del file dentro storage/app/temp}
                                {--delimiter=, : Il separatore dei campi (default: virgola ,)}';

    /**
     * La descrizione del comando.
     */
    protected $description = 'Legge un file Excel da storage/app/temp e cicla per ogni riga';

    public function handle(): int
    {
        $filename = $this->argument('filename');
        $delimiter = $this->option('delimiter');
        $relativePath = 'temp/' . $filename;

        $woos = Woo::first();
        if(empty($woos)) {
            $handle = $this->_open_file($relativePath);
            if(!$handle)
                return Command::FAILURE;
    
            if(!$this->_woos_insert($handle, $delimiter))
                return Command::FAILURE;
        }

/*
        Woo::truncate();
        $this->info("woos truncate");
       //  $this->_catalogo_truncate();
*/
        $defaultLanguage = Language::getDefault();
        $productType = ProductType::first() ?? ProductType::create(['name' => 'Generale']);
        $currency    = Currency::getDefault();
        $taxClass    = TaxClass::getDefault();
        $colorOption = ProductOption::where('handle', 'colour')->first();

        $woo_child = null;
        $woos = Woo::whereNull('parent_post_id')
                                    ->where('id', '=', 1)
                                    ->get();
        try {
            foreach ($woos as $numResult => $woo) {
                
                $this->info("Elaboro righe: " . ($numResult + 1) . " name [$woo->name] id [$woo->id]");

                DB::transaction(function () use ($woo, $productType, $currency, $taxClass, $colorOption) {
        
                    // Crea il Prodotto principale
                    $product = Product::create([
                        'product_type_id' => $productType->id,
                        'brand_id'   => $this->_getBrandId($woo->name),
                        'status'          => 'published', // 'published' o 'draft'
                        'attribute_data'  => [
                            'name' => new TranslatedText(collect([
                                'it' => new Text($woo->name)
                            ])),
                            'description_intro' => new TranslatedText(collect([
                                'it' => new Text($this->_getDescription($woo->descri_short)),
                            ])),
                            'description' => new TranslatedText(collect([
                                'it' => new Text($this->_getDescription($woo->descri)),
                            ]))
                        ],
                    ]);

                    $this->_setImages($woo->imgs, $product);

                    $this->_setTags($woo->tag, $product);

                    $this->_setCollections($product);

                    /*
                     * lo crea in automatico con il nome
                    $product->urls()->create([
                        'language_id' => $defaultLanguage->id,
                        'slug'        => $woo->slug,
                        'default'     => true
                    ]);
                    */

                    /*
                     * varianti
                     */
                    $woo_childs = Woo::where('parent_post_id', $woo->post_id)->get();
                    if($woo_childs->count()>0) {
                        /*
                        * al prodotto associo l'opzione (colour)
                        */
                        $product->productOptions()->syncWithoutDetaching([$colorOption->id => ['position' => 1]]);

                        $this->info("Trovati {$woo_childs->count()} varianti di [$woo->name] con parent_post_id [$woo->post_id]");
                        foreach ($woo_childs as $numResult2 => $woo_child) {

                            empty($woo_child->stock) ? $stock = 0: $stock = $woo_child->stock;
                            empty($woo_child->sku) ? $sku = '-': $sku = $woo_child->sku;
                            $variant = ProductVariant::create([
                                'product_id'   => $product->id,
                                'sku'          => $sku,
                                'tax_class_id' => $taxClass->id,
                                'stock'        => $stock, 
                                'purchasable'  => 'always',        // 'always', 'in_stock', o 'backorder'
                            ]);
                        
                            // Assegna il Prezzo (N.B. I prezzi in Lunar sono sempre memorizzati in CENTESIMI)
                            $precioInEuro = $woo_child->price;
                            
                            $variant->prices()->create([
                                'price'        => (int) round($precioInEuro * 100), // Converte 29.90 in 2990
                                'currency_id'  => $currency->id,
                                'min_quantity' => 1,
                            ]); 
                            
                            $color = ProductOptionValue::firstOrCreate(
                                ['product_option_id' => $colorOption->id,  'name->it' => $woo_child->varianti],
                                ['name' => new TranslatedText(collect(['it' => new Text($woo_child->varianti)]))]
                            );

                            $variant->values()->attach($color->id);

                            $this->_setImages($woo_child->imgs, $product, $variant);

                        } // end foreach ($woo_childs as $numResult => $woo_child)
                    } // end if($woo_childs->count()>0)
                });            
            } // end foreach ($woos as $numResult => $woo)
        } catch (\Throwable $e) {
            dump($woo_child);
            $this->error("Errore durante l'elaborazione alla riga con id {$woo->id}: " . $e->getMessage());
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }

    private function _open_file($relativePath)
    {
        // 1. Verifica esistenza file tramite il disk 'local'
        if (!Storage::disk('local')->exists($relativePath)) {
            $this->error("Il file '{$relativePath}' non esiste in storage/app/temp/.");
            return Command::FAILURE;
        }

        // 2. Recupera il percorso assoluto
        $fullPath = Storage::disk('local')->path($relativePath);

        $this->info("Apertura file: {$fullPath}");

        // 3. Apre il file in lettura
        $handle = fopen($fullPath, 'r');
        if ($handle === false) {
            $this->error("Impossibile aprire il file CSV.");
            return Command::FAILURE;
        }

        return $handle;
    }

    private function _woos_insert($handle, $delimiter=','): bool
    {
        $rowIndex = 0;
        $headers = [];

        /*
        * leggo dal csv e persisto in woos
        */        
        try {
            while (($row = fgetcsv($handle, 0, $delimiter)) !== false) {
                $rowIndex++;

                // Gestione opzionale dell'intestazione (prima riga)
                if ($rowIndex === 1) {
                    $headers = $row;
                    $this->info("Intestazioni trovate: " . implode(', ', $headers));
                    continue; // Salta alla riga di dati vera e propria
                }

                $this->processRow($row, $headers, $rowIndex);
            }

            fclose($handle);

            $this->newLine();
            $this->info("Lettura completata con successo! Righe elaborate: " . ($rowIndex - 1));

            return Command::SUCCESS;

        } catch (\Throwable $e) {
            if (is_resource($handle)) {
                fclose($handle);
            }

            $this->error("Errore durante l'elaborazione alla riga {$rowIndex}: " . $e->getMessage());
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }

    /**
     * Logica di elaborazione per la singola riga.
     */
    private function processRow(array $row, array $headers, int $rowIndex): bool
    {
        try {
            $woo = new Woo();

            $colonnaPostId = $row[0] ?? null; // id
            $colonnaType = $row[1] ?? null; // tipo variable variation
            $colonnaSku = $row[2] ?? null; // sku
            $colonnaName = $row[4] ?? null; // nome
            $colonnaDeleted = $row[5] ?? null; // publicato
            $colonnaDescriShort = $row[8] ?? null; // descri breve
            $colonnaDescri = $row[9] ?? null; // descri
            $colonnaStock = $row[15] ?? null; // stock
            $colonnaPrice = $row[26] ?? null; // price
            $colonnaTag = $row[28] ?? null; // tag
            $colonnaImgs = $row[30] ?? null; // img
            $colonnaPostParentid = $row[33] ?? null; // parent_id
            $colonnaBrand = $row[43] ?? null; // brand
            $colonnaVarianti = $row[44] ?? null; // variante
      
            $this->line("Elaborata riga {$rowIndex}: [$colonnaName]"); // . implode(' | ', $row));

            $colonnaPostParentid = str_replace('id:', '', $colonnaPostParentid);
            if(empty($colonnaPostParentid)) $colonnaPostParentid = null;

            if(empty($colonnaStock)) $colonnaStock = null;
            if(empty($colonnaPrice)) $colonnaPrice = null; else $colonnaPrice = str_replace(',', '.', $colonnaPrice);
            
            $woo->post_id = $colonnaPostId;
            $woo->parent_post_id = $colonnaPostParentid;
            $woo->name = $colonnaName;
            $woo->sku = $colonnaSku;
            $woo->descri_short = $colonnaDescriShort;
            $woo->descri = $colonnaDescri;
            $woo->stock = $colonnaStock;
            $woo->price = $colonnaPrice;
            $woo->tag = $colonnaTag;
            $woo->imgs = $colonnaImgs;
            $woo->brand = $colonnaBrand;
            $woo->varianti = $colonnaVarianti;

            if($colonnaDeleted==='0') $woo->deleted_at = now(); 
           
            $this->line("Insert woos riga {$rowIndex}: [$colonnaName]");
           
            $woo->save();

        } catch (\Throwable $e) {
            dump($woo);

            $this->error("Errore durante l'elaborazione alla riga {$rowIndex}: " . $e->getMessage());
            return Command::FAILURE;
        }   
        
        return Command::SUCCESS;
    }  
    
    private function _catalogo_truncate() {
        DB::transaction(function () {
            // Carica tutti i prodotti (inclusi eventuali soft-deleted se attivi)
            Product::withTrashed()->get()->each(function ($product) {
                // 1. Elimina i prezzi collegati alle varianti
                $product->variants->each(function ($variant) {
                    $variant->prices()->delete();
                });
        
                // 2. Elimina le varianti
                $product->variants()->delete();
        
                // 3. Stacca le relazioni con Canali e Collezioni
                $product->channels()->detach();
                $product->collections()->detach();
        
                // 4. Elimina definitivamente il prodotto (forceDelete per ignorare SoftDeletes)
                $product->forceDelete();
            });
        });        
    }

    private function _setImages($images, $product, $variant=null) {

        if(empty($images))
            return true;
    
        $urls = [];
        if (str_contains($images, ',')) 
            $urls = explode(',', $images);    
        else 
            $urls[] = $images;

        foreach($urls as $url) {

            $url = trim($url);
            dump($url);
            try {
                $media = $product->addMediaFromUrl($url)
                                ->toMediaCollection('images');
            
            } catch (FileCannotBeAdded $e) {
                $this->error("Impossibile scaricare l'immagine per il prodotto {$product->id}: url [$url]" . $e->getMessage());
            }

            if(!empty($variant))
                $variant->images()->attach($media->id);
        }
    }

    private function _setTags($tags, $product) {

        if(empty($tags))
            return true;
    
        $_tags = [];
        if (str_contains($tags, ',')) 
            $_tags = explode(',', $tags);    
        else 
            $_tags[] = $tags;

        foreach($_tags as $tag) {
            $tag = Tag::firstOrCreate([
                'value' => $tag
            ]);

            $product->tags()->syncWithoutDetaching([$tag->id]);
        }
    }

    private function _getBrandId($name) {

        $brands = [
                'Addì',
                'Adriafil',
                'Borgo de\' Pazzi',
                'Dark Omen Yarn',
                'DMC',
                'Drops', // 'Drops Design',
                'Knit Pro',
                'Laines du nord',
                'Lana Gatto',
                'Pony',
                'Prym',
                'Sesia',
                'Sibillana'                                  
        ];

        $result = null; 
        $name = strtolower($name);
        foreach($brands as $brand) {
            $brand = strtolower($brand);
            if (str_contains($name, $brand)) {
                $result = $brand;
                // dump($result);
                break;
            }
        }
        
        if(!empty($result)) {
            $brand = Brand::firstOrCreate([
                'name' => $result,
            ]);
            
            $result = $brand->id;
        }

        return $result;
    }

    private function _getDescription($description) {
       
        $description = trim($description);

        if(!empty($description))
            $description = str_replace('\n', '', $description);

        return $description;
    }

    private function _setCollections($product) {
        $handle = 'filati';
        $url = Url::where('element_type', 'collection')
                ->where('slug',  $handle)
                ->first();
            
        $collection = $url?->element;

        $product->collections()->syncWithoutDetaching([$collection->id]);
    }
}
