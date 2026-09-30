<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

use Lunar\Models\Collection;
use Lunar\Models\CollectionGroup;
use Lunar\Models\Language;
use Lunar\FieldTypes\Text;
use Lunar\FieldTypes\Number;
use Lunar\FieldTypes\TranslatedText;
use App\Models\Woo;


use Lunar\Models\Attribute;
use Lunar\Models\AttributeGroup;


class ImportTreeCommand extends Command
{
    /*
     * php artisan app:import filename:export-prodotti.xlsx
     */
    protected $signature = 'app:import-tree';

    private $_collection_group = 'principale4';

    /**
     * La descrizione del comando.
     */
    protected $description = 'Legge da woos e popola la collection per creare l\'alberatura';

    public function handle(): int
    {
        $defaultLanguage = Language::getDefault();
        
        /*
         * crea la collection group 
         * */
        $group = CollectionGroup::where('handle', $this->_collection_group)->first();
        if(empty($group)) {
            $group = CollectionGroup::create([
                    'name' => ucfirst($this->_collection_group),
                    'handle' => $this->_collection_group,
            ]);
        }

        $woos = Woo::whereNull('parent_post_id')
                                  //  ->where('id', '=', 1)  // DEBUG DEBUG DEBUG DEBUG DEBUG DEBUG DEBUG DEBUG 
                                    ->get(); // ->toRawSql();
        $this->info("Totale righe: " . $woos->count());
        try {
            foreach ($woos as $numResult => $woo) {
                
                $this->info("Elaboro riga: " . ($numResult + 1) . " name [$woo->name] id [$woo->id]");

                DB::transaction(function () use ($woo, $group, $defaultLanguage) {

                    if(empty($woo->tree))
                        return;

                    $trees = explode(',', $woo->tree);
                    foreach($trees as $tree) {
                        $tree = trim($tree);
                        $items = explode('>', $tree);
                        $this->info(""); 
                        $this->info("Elaboro l'alberatura [$tree]"); 
                        foreach($items as $numItem => $item) {

                            $item = trim($item);

                            $parent_name = null;     
                            $parent_parent_name = null;                            
                            if($numItem>0 && array_key_exists(($numItem-1), $items)) {
                                $parent_name = trim($items[($numItem-1)]);
                                $this->info("[{$item}] ha come parent_name [$parent_name]"); 
                            }
                            if($numItem===2 && array_key_exists(($numItem-2), $items)) {
                                $parent_parent_name = trim($items[($numItem-2)]);
                                $this->info("[{$item}] ha come parent_parent_name [$parent_parent_name]"); 
                            }

                            /*
                            * verifico se e' stata gia' creata
                            * ricerco per nome ed esentuale parent (ci sono nomi duplicati)
                            * */                            
                            $exists = Collection::where('collection_group_id', $group->id)
                                                ->where("attribute_data->name->value->{$defaultLanguage->code}", $item);
                            if(!empty($parent_name))
                                $exists = $exists->where("attribute_data->parent_name->value", $parent_name);
                            
                            $exists = $exists->exists();
                            if (!$exists) {
                                
                                /*
                                * recupero parent
                                * */
                                $parentCollection = null; 
                                if($numItem>0) {
                                    $parentCollection = Collection::where('collection_group_id', $group->id);
                                    if(!empty($parent_name)) {
                                        $parentCollection = $parentCollection->where("attribute_data->name->value->{$defaultLanguage->code}", $parent_name);
                                    }

                                    if(!empty($parent_parent_name)) {
                                        $parentCollection = $parentCollection->where("attribute_data->parent_name->value", $parent_parent_name);
                                    }
                                    
                                    $this->info($parentCollection->toRawSql()); 
                                    $parentCollection = $parentCollection->first();      
                                }

                                if(empty($parentCollection)) {
                                    $this->info("Collection [$item] NON esiste => la creo come ROOT"); 
                                    
                                }
                                else {
                                    $this->info("Collection [$item] NON esiste => la creo figlio di [".$parentCollection->attr('name')."] ({$parentCollection->id})"); 
                                }

                                $datas = ['collection_group_id' => $group->id,
                                          'attribute_data' => [
                                            'name' => new TranslatedText([
                                                'it' => new Text($item)]),
                                            'parent_name' => new Text($parent_name)
                                         ]];

                                $this->info(json_encode($datas, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

                                if (1==1) {
                                    $collection = Collection::create($datas, $parentCollection);
                                }
                            }
                            else {
                                if(!empty($parent_name))
                                    $this->info("Collection [$item] esiste già con parent_name [{$parent_name}] => salto");
                                else
                                    $this->info("Collection [$item] esiste già con ROOT => salto");
                            }

                        } // end foreach($items as $item) 

                    } // end foreach($trees as $tree)
                    
                });            
            } // end foreach ($woos as $numResult => $woo)
        } catch (\Throwable $e) {
            $this->error("Errore durante l'elaborazione alla riga con id {$woo->id}: " . $e->getMessage());
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    } 
}
