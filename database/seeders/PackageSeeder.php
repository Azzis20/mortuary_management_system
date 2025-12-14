<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Package;

class PackageSeeder extends Seeder
{
    
    public function run(): void
    {
         $packages = [
            [
                'created_by' => 6,
                'package_name' => 'BASIC',
                'price' => 20000,
                'is_active' => true,
                'description' => 'This is the entry-level option, providing essential and direct services. It includes standard body retrieval, a basic casket, limited 4-hour chapel use, and fundamental transportation to the final location.',
            ],
            [
                'created_by' => 6,
                'package_name' => 'STANDARD',
                'price' => 35000,
                'is_active' => true,
                'description' => 'This package offers a significant upgrade to key services for a more traditional viewing. It includes priority retrieval, a premium oak casket, professional embalming and grooming, extended 8-hour chapel use, and a higher-tier transportation service.',
            ],
            [
                'created_by' => 6,
                'package_name' => 'PREMIUM',
                'price' => 50000,
                'is_active' => true,
                'description' => 'This is the most comprehensive and luxury offering. It features VIP retrieval, a high-end mahogany casket, full restoration services, all-day 24-hour chapel access, and premium amenities like flower arrangements, live streaming, and a luxury hearse convoy.',
            ],
        ];

        foreach ($packages as $package) {
            Package::create($package);
        }
    }
}
