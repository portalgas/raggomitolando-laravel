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

    private $_collection_group = 'principale';

    /**
     * La descrizione del comando.
     */
    protected $description = 'Legge da woos e popola la collection per creare l\'alberatura';

    public function handle(): int
    {
        $defaultLanguage = Language::getDefault();
        
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
                        $this->info("tree [$tree]"); 
                        foreach($items as $numResult2 => $item) {

                            $item = trim($item);
                            
                            $exists = Collection::where('collection_group_id', $group->id)
                                                ->where("attribute_data->name->value->{$defaultLanguage->code}", $item)
                                                ->exists();

                            if (!$exists) {

                                /*
                                 * recupero parent
                                 * */
                                $parentCollection = null;
                                $parent_name = null;
                                $parentCollection = Collection::where('collection_group_id', $group->id);
                                if (array_key_exists(($numResult2-1), $items)) {
                                    $parent_name = trim($items[($numResult2-1)]);
                                    $parentCollection = $parentCollection->where("attribute_data->name->value->{$defaultLanguage->code}", $parent_name);
                                    $this->info("parent_name [$parent_name]"); 
                                }

                                if (array_key_exists(($numResult2-2), $items)) {
                                    $parent_parent_name = trim($items[($numResult2-2)]);
                                    $parentCollection = $parentCollection->where("attribute_data->parent_name->value", $parent_parent_name);
                                    $this->info("parent_parent_name [$parent_parent_name]"); 
                                }
                                $this->info($parentCollection->toRawSql()); 
                                $parentCollection = $parentCollection->first();  

                                if(empty($parentCollection)) {
                                    $this->info("Collection [$item] NON esiste => la creo"); 
                                    
                                }
                                else {
                                    $this->info("Collection [$item] NON esiste => la creo figlio di ".$parentCollection->attr('name')." ({$parentCollection->id})"); 
                                    $parent_id = $parentCollection->id;
                                }

                                $collection = Collection::create([
                                    'collection_group_id' => $group->id,
                                    'attribute_data' => [
                                        'name' => new TranslatedText([
                                            'it' => new Text($item),
                                        ]),
                                        'parent_name' => new Text($parent_name)
                                    ],
                                ], $parentCollection);
                            }
                            else {
                                $this->info("Collection [$item] esiste già => salto");
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
