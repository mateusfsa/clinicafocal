<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use phpDocumentor\Reflection\DocBlock\Tags\See;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Seeder::call([
            MenuItemSeeder::class,
            UserSeeder::class,
            HeroSeeder::class,
            AboutSeeder::class,
            ServiceSeeder::class,
            SettingSeeder::class,
        ]);
    }
}
