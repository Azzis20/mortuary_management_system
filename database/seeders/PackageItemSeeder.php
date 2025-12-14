<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PackageItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $packageItems = [
            // Package 1 - Basic Package
            [
                'package_id' => 1,
                'service_name' => 'Body Retrieval',
                'description' => 'Pick-up service from hospital or residence',
            ],
            [
                'package_id' => 1,
                'service_name' => 'Basic Embalming',
                'description' => 'Preservation and sanitization of the body',
            ],
            [
                'package_id' => 1,
                'service_name' => 'Basic Dressing',
                'description' => 'Dressing and grooming the body with simple attire',
            ],
            [
                'package_id' => 1,
                'service_name' => 'Chapel Use (4 hours)',
                'description' => '4-hour viewing period in mortuary chapel',
            ],
            [
                'package_id' => 1,
                'service_name' => 'Body Storage',
                'description' => 'Temporary refrigeration/storage until release',
            ],

            [
                'package_id' => 2,
                'service_name' => 'Priority Body Retrieval',
                'description' => 'Faster pick-up service from hospital or residence',
            ],
            [
                'package_id' => 2,
                'service_name' => 'Professional Embalming',
                'description' => 'Comprehensive preservation and sanitization of the body',
            ],
            [
                'package_id' => 2,
                'service_name' => 'Dressing & Grooming',
                'description' => 'Professional dressing and light makeup',
            ],
            [
                'package_id' => 2,
                'service_name' => 'Chapel Use (8 hours)',
                'description' => '8-hour viewing period in mortuary chapel',
            ],
            [
                'package_id' => 2,
                'service_name' => 'Body Storage',
                'description' => 'Refrigerated storage until release',
            ],
            [
                'package_id' => 2,
                'service_name' => 'Viewings Management',
                'description' => 'Scheduling and supervising family viewings',
            ],
            
            [
                
                'package_id' => 3,
                'service_name' => 'VIP Body Retrieval',
                'description' => 'Priority pick-up with dedicated escort',
            ],
            [
                'package_id' => 3,
                'service_name' => 'Full Embalming Service',
                'description' => 'Complete preservation, restoration, and sanitization',
            ],
            [
                'package_id' => 3,
                'service_name' => 'Premium Dressing & Grooming',
                'description' => 'High-quality clothing and professional makeup',
            ],
            [
                'package_id' => 3,
                'service_name' => 'Chapel Use (24 hours)',
                'description' => 'Full-day viewing period in mortuary chapel',
            ],
            [
                'package_id' => 3,
                'service_name' => 'Body Storage',
                'description' => 'Premium refrigeration and storage until release',
            ],
            [
                'package_id' => 3,
                'service_name' => 'Viewings Management',
                'description' => 'Scheduling, supervising, and logging family viewings',
            ],
            [
                'package_id' => 3,
                'service_name' => 'Record Keeping & Reports',
                'description' => 'Detailed documentation of mortuary procedures and releases',
            ],




        ];

        foreach ($packageItems as $item) {
            DB::table('package_items')->insert([
                'package_id' => $item['package_id'],
                'service_name' => $item['service_name'],
                'description' => $item['description'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}