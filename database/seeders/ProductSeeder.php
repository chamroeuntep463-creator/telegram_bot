<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            ['no' => '1', 'group' => 'CBC', 'product' => 'cbc', 'name' => 'CBC'],
            ['no' => '2', 'group' => 'LITE', 'product' => 'lite', 'name' => 'LITE'],
            ['no' => '3', 'group' => 'CBB', 'product' => 'cbb', 'name' => 'CBB'],
            ['no' => '4', 'group' => 'CBP', 'product' => 'cbp', 'name' => 'CBP'],
            ['no' => '5', 'group' => 'CBSP', 'product' => 'cbsp', 'name' => 'CBSP'],
            ['no' => '6', 'group' => 'CBPL', 'product' => 'cbpl', 'name' => 'CBPL'],
            ['no' => '7', 'group' => 'WKZ', 'product' => 'wkz', 'name' => 'WKZ'],
            ['no' => '8', 'group' => 'WKZ ICE', 'product' => 'wkz_ice', 'name' => 'WKZ ICE'],
            ['no' => '9', 'group' => 'ICY', 'product' => 'icy', 'name' => 'ICY'],
            ['no' => '10', 'group' => 'DAZZ', 'product' => 'dazz', 'name' => 'DAZZ'],
            ['no' => '11', 'group' => 'ED', 'product' => 'ed', 'name' => 'ED'],
            ['no' => '12', 'group' => 'SPORT', 'product' => 'sport', 'name' => 'SPORT'],
            ['no' => '13', 'group' => 'EXPREZ', 'product' => 'exprez_300', 'name' => 'Exprez 300ml'],
            ['no' => '14', 'group' => 'EXPREZ', 'product' => 'exprez_str', 'name' => 'Exprez STR'],
            ['no' => '15', 'group' => 'EXPREZ', 'product' => 'exprez_mel', 'name' => 'Exprez MEL'],
            ['no' => '16', 'group' => 'CB Cola', 'product' => 'cb_250', 'name' => 'CB Cola 250ml'],
            ['no' => '17', 'group' => 'CB Cola', 'product' => 'cb_330', 'name' => 'CB Cola 330ml'],
            ['no' => '18', 'group' => 'IZE CAN ( All )', 'product' => 'ize_can_250', 'name' => 'IZE CAN 250ml'],
            ['no' => '19', 'group' => 'IZE CAN ( All )', 'product' => 'ize_can_330', 'name' => 'IZE CAN 330ml'],
            ['no' => '20', 'group' => 'IZE PET ( All )', 'product' => 'ize_pet_300', 'name' => 'IZE PET 300ml'],
            ['no' => '21', 'group' => 'IZE PET ( All )', 'product' => 'ize_pet_500', 'name' => 'IZE PET 500ml'],
            ['no' => '22', 'group' => 'IZE PET ( All )', 'product' => 'ize_pet_15', 'name' => 'IZE PET 1.5L'],
            ['no' => '23', 'group' => 'WATER', 'product' => 'water_350', 'name' => 'Water 350ml'],
            ['no' => '24', 'group' => 'WATER', 'product' => 'water_500', 'name' => 'Water 500ml'],
            ['no' => '25', 'group' => 'WATER', 'product' => 'water_15', 'name' => 'Water 1.5L'],
        ];

        foreach ($products as $p) {
            Product::firstOrCreate(
                ['product' => $p['product']],
                $p
            );
        }
    }
}
