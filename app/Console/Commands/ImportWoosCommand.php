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

class ImportWoosCommand extends Command
{
    /*
     * php artisan app:import filename:export-prodotti.xlsx
     */
    protected $signature = 'app:import-excel
                                 {filename : Il nome del file dentro storage/app/temp}
                                {--delimiter=, : Il separatore dei campi (default: virgola ,)}';

    /**
     * La descrizione del comando.
     */
    protected $description = 'Legge un file Excel da storage/app/temp e cicla per ogni riga e lo persiste in woos';

    public function handle(): int
    {
        $filename = $this->argument('filename');
        $delimiter = $this->option('delimiter');
        $relativePath = 'temp/' . $filename;

        $woos = Woo::first();
        if(empty($woos)) {
            
            $this->info("tabella woos non popolata, recupero i dati dal file");

            $handle = $this->_open_file($relativePath);
            if(!$handle)
                return Command::FAILURE;
    
            if(!$this->_woos_insert($handle, $delimiter))
                return Command::FAILURE;
        }
        else {
            $this->info("tabella woos popolata non faccio nulla");
        }

        /*
        Woo::truncate();
        $this->info("woos truncate");
       //  $this->_catalogo_truncate();
        */

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
            $colonnaTree = $row[27] ?? null; // tag
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
            $woo->tree = $colonnaTree;
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
}
