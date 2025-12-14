<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InventorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $inventoryItems = [
            [
                'item_name' => 'Standard Wooden Casket',
                'category' => 'Casket',
                'stock_quantity' => 15,
                'min_threshold' => 5,
            ],
            [
                'item_name' => 'Premium Oak Casket',
                'category' => 'Casket',
                'stock_quantity' => 7,
                'min_threshold' => 7,
            ],
            [
                'item_name' => 'Luxury Mahogany Casket',
                'category' => 'Casket',
                'stock_quantity' => 4,
                'min_threshold' => 5,
            ],
            [
                'item_name' => 'Embalming Fluid (per liter)',
                'category' => 'Chemical',
                'stock_quantity' => 48,
                'min_threshold' => 10,
            ],
            [
                'item_name' => 'White Burial Gown',
                'category' => 'Clothing',
                'stock_quantity' => 10,
                'min_threshold' => 10,
            ],
            [
                'item_name' => 'Blue Burial Suit',
                'category' => 'Clothing',
                'stock_quantity' => 22,
                'min_threshold' => 10,
            ],
            [
                'item_name' => 'Rose Flower Arrangement',
                'category' => 'Flowers',
                'stock_quantity' => 18,
                'min_threshold' => 10,
            ],
            [
                'item_name' => 'Lily Flower Arrangement',
                'category' => 'Flowers',
                'stock_quantity' => 0,
                'min_threshold' => 10,
            ],
            [
                'item_name' => 'Memorial Cards (100pcs)',
                'category' => 'Stationery',
                'stock_quantity' => 48,
                'min_threshold' => 10,
            ],

            [
                'item_name' => 'Embalming Tools Set',
                'category' => 'Equipment',
                'stock_quantity' => 5,
                'min_threshold' => 2,
            ],
        ];

        foreach ($inventoryItems as $item) {
            DB::table('inventories')->insert([
                'item_name' => $item['item_name'],
                'category' => $item['category'],
                'stock_quantity' => $item['stock_quantity'],
                'min_threshold' => $item['min_threshold'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}