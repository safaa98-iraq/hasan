<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class,
            PageSeeder::class,
            PlaceSeeder::class,
            JourneySeeder::class,
            CategorySeeder::class,
            ApproachPointSeeder::class,
        ]);
    }
}