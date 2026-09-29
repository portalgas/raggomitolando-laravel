<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Lunar\FieldTypes\Text;
use Lunar\FieldTypes\TranslatedText;
use Lunar\Models\Collection;
use Lunar\Models\CollectionGroup;
use Lunar\Models\Attribute;
use Lunar\Models\AttributeGroup;

class CollectionSeeder extends AbstractSeeder
{
    /**
     * Run the database seeds.
     *
     */
    public function run(): void
    {
        // 1. Recupera o crea il gruppo di attributi per le Collection
        $attributeGroup = AttributeGroup::firstOrCreate(
            [
                'attributable_type' => 'collection', 
                'handle' => 'collection_details',
            ],
            [
                'name' => ['it' => 'Dettagli'],
                'position' => 1,
            ]
        );

        // 2. Crea il nuovo attributo
        $attribute = Attribute::firstOrCreate(
            [
                'attribute_type' => 'collection', 
                'handle' => 'parent_name',
            ],
            [
                'attribute_group_id' => $attributeGroup->id,
                'name' => [
                    'it' => 'Parent name'
                ],
                'description' => [
                    'it' => ''
                ],
                'type' => Text::class, // O Text::class, Number::class, Toggle::class
                'required' => false,
                'searchable' => true,
                'filterable' => false,
                'system' => false,
                'position' => 2,
                'configuration' => [
                    'lookups' => [],
                ],
            ]
        );

        /*
         * ora li gestisco con ImportTreeCommand 
         * $this->call(CollectionSeeder::class);        
        $collections = $this->getSeedData('collections');

        $collectionGroup = CollectionGroup::first();
       
        DB::transaction(function () use ($collections, $collectionGroup) {
            foreach ($collections as $collection) {
                Collection::create([
                    'collection_group_id' => $collectionGroup->id,
                    'attribute_data' => [
                        'name' => new TranslatedText([
                            'it' => new Text($collection->name),
                        ]),
                        'description' => new TranslatedText([
                            'it' => new Text($collection->description),
                        ]),
                    ],
                ]);
            }
        });
        */
    }
}
