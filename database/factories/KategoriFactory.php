<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;

class KategoriFactory extends Factory // <-- Pastikan ini KategoriFactory, bukan CategoryFactory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement([
                'Elektronik', 'Fashion', 'Makanan & Minuman', 
                'Kesehatan', 'Otomotif', 'Perabotan', 'Olahraga'
            ]),
            'product_id' => Product::all()->random()->id,
        ];
    }
}