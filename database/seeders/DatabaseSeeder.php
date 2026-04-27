<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Buat User
        User::factory()->create([  
            'name' => 'Fera Istanti',
            'email' => 'fera@example.com',
        ]);

        User::factory(4)->create();

        // 2. Jalankan Factory Product
        Product::factory(10)->create();

        // 3. Jalankan Factory Category
        Category::factory(10)->create();
    }
}