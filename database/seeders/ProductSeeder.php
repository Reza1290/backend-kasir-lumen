<?php

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Buat data dummy produk
        $products = [
            [
                'name' => 'Product 1',
                'description' => 'Description of Product 1',
                'is_active' => true,
                'price' => 10.99,
            ],
            [
                'name' => 'Product 2',
                'description' => 'Description of Product 2',
                'is_active' => false,
                'price' => 20.50,
            ],
            [
                'name' => 'Product 3',
                'description' => 'Description of Product 3',
                'is_active' => true,
                'price' => 15.75,
            ],
        ];

        // Loop through each product data and create records in database
        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
