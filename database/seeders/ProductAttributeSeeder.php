<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Lunar\FieldTypes\TranslatedText;
use Lunar\Models\Attribute;
use Lunar\Models\AttributeGroup;
use Lunar\Models\ProductType;

class ProductAttributeSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Recupera o crea il gruppo di attributi predefinito per i prodotti (es. "Dettagli Prodotto")
        $attributeGroup = AttributeGroup::firstOrCreate(
            ['handle' => 'details'],
            [
                'name' => [
                    'it' => 'Dettagli'
                ],
                'position' => 1,
                'attributable_type' => 'product',
            ]
        );

        // 2. Crea l'attributo 'description_intro' se non esiste già
        $attribute = Attribute::firstOrCreate(
            [
                'handle' => 'description_intro',
                'attribute_type' => 'product',
            ],
            [
                'attribute_group_id' => $attributeGroup->id,
                'name' => [
                    'it' => 'Descrizione Introduttiva'
                ],
                'description' => ['it' => ''],
                'type' => TranslatedText::class,  
                'section' => 'main',
                'searchable' => true,            // Se deve essere cercabile sul sito
                'filterable' => true,           // Se deve fare da filtro
                'required' => true,             // Obbligatorietà nel form
                'system' => false,               // Se true non sarà eliminabile dall'Admin Hub
                'position' => 2,                 // Ordine di visualizzazione nel form
                'configuration' => [             // Impostazioni campo (es. Richtext o Textarea)
                    'richtext' => true,
                ],
            ]
        );

        // 3. Collega l'attributo al Tipo di Prodotto predefinito (ProductType)
        $productType = ProductType::first();

        if ($productType) {
            $productType->mappedAttributes()->syncWithoutDetaching([$attribute->id]);
        }
    }
}