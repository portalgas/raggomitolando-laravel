<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Lunar\Models\Language;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     */
    public function run(): void
    {
        $italian = Language::firstOrCreate(
            ['code' => 'it'],
            [
                'name' => 'Italiano',
                'default' => true,
            ]
        );

        $italian->update(['default' => true]);

        $english = Language::where('code', 'en')->first();

        if ($english) {
            $english->delete();

            // Rimuovi solo il flag di default se desideri conservare il record
            // $english->update(['default' => false]);
        }
    }
}
