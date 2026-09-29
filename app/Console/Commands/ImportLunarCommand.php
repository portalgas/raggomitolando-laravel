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

class ImportLunarCommand extends Command
{
    /*
     * php artisan app:import filename:export-prodotti.xlsx
     */
    protected $signature = 'app:import-lunar';

    /**
     * La descrizione del comando.
     */
    protected $description = 'Legge da woos e popola le diverse tabelle';

    public function handle(): int
    {
        $defaultLanguage = Language::getDefault();
        $productType = ProductType::first() ?? ProductType::create(['name' => 'Generale']);
        $currency    = Currency::getDefault();
        $taxClass    = TaxClass::getDefault();
        $colorOption = ProductOption::where('handle', 'colour')->first();

        $product = null;
        $woo_child = null;
        $woos = Woo::whereNull('parent_post_id')
                                    ->where('id', '=', 1)  // DEBUG DEBUG DEBUG DEBUG DEBUG DEBUG DEBUG DEBUG 
                                    ->get();
        $this->info("Totale righe: " . $woos->count());
        try {
            foreach ($woos as $numResult => $woo) {
                
                $this->info("Elaboro riga: " . ($numResult + 1) . " name [$woo->name] id [$woo->id]");

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

                    $this->_setCollections($woo->tree, $product);

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
                    $this->info("cerco i figli con parent_post_id [$woo->post_id]");
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
            dump($product);
            dump($woo);
            dump($woo_child);
            $this->error("Errore durante l'elaborazione alla riga con id {$woo->id}: " . $e->getMessage());
            return Command::FAILURE;
        }

        return Command::SUCCESS;
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
            $this->info("Associo {$product->attr('name')} al tag [{$tag}]");

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

    private function _setCollections($tree, $product) {

        if(empty($tree))
            return true;
          
        $trees = explode(',', $tree);
        foreach($trees as $tree) {
            $tree = trim($tree);
            $items = explode('>', $tree);
            $handle = trim(end($items));
        
            $this->info("Associo {$product->attr('name')} alla collection [{$handle}]");

            $url = Url::where('element_type', 'collection')
                    ->where('slug', $handle)
                    ->first();
            $collection = $url?->element;
            
            if(!empty($collection)) 
                $product->collections()->syncWithoutDetaching([$collection->id]);
            else 
                $this->error("Collection [{$handle}] non trovata!");
        }

        return true;
    }
}
