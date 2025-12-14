<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Admin user
        User::create([
            'name' => 'John Wick',
            'email' => 'admin@test.com',
            'password' => Hash::make('password'),
            'accountType' => 'admin',  
        ]);

        // Client user
        User::create([
            'name' => 'Miguel Chrisostomo',
            'email' => 'client@test.com',
            'password' => Hash::make('password'),
            'accountType' => 'client',
        ]);

        // Driver user 
        User::create([
            'name' => 'Alfonso Douglas',
            'email' => 'driver@test.com',
            'password' => Hash::make('password'),
            'accountType' => 'driver',
        ]);

        // Staff user
        User::create([
            'name' => 'Shellah Mahinay',
            'email' => 'staff@test.com',
            'password' => Hash::make('password'),
            'accountType' => 'staff',
        ]);

        // Embalmer user
        User::create([
            'name' => 'Embalmer User',
            'email' => 'embalmer@test.com',
            'password' => Hash::make('password'),
            'accountType' => 'embalmer',
        ]);
    }
}