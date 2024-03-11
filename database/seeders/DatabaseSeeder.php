<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductStock;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use ProductSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call('UsersTableSeeder');
        // User::create([
        //     'username' => "reza",
        //     'email' => "test@g.com",
        //     'password' => Hash::make('password'),
        // ]);
        // $products = [
        //     [
        //         'name' => 'Product 1',
        //         'description' => 'Description of Product 1',
        //         'is_active' => true,
        //         'price' => 10.99,
        //     ],
        //     [
        //         'name' => 'Product 2',
        //         'description' => 'Description of Product 2',
        //         'is_active' => false,
        //         'price' => 20.50,
        //     ],
        //     [
        //         'name' => 'Product 3',
        //         'description' => 'Description of Product 3',
        //         'is_active' => true,
        //         'price' => 15.75,
        //     ],
        // ];

        // // Loop through each product data and create records in database
        // foreach ($products as $product) {
        //     Product::create($product);
        // }
        // $products = Product::all();

        // // Buat data dummy stok produk
        // foreach ($products as $product) {
        //     ProductStock::create([
        //         'id_product' => $product->id,
        //         'units' => rand(0, 100), // Stok produk diacak antara 0 dan 100
        //     ]);
        // }


        $categories = [
            [
                'name' => 'Electronics',
                'description' => 'Electronic devices and gadgets',
            ],
            [
                'name' => 'Clothing',
                'description' => 'Clothing and fashion accessories',
            ],
            [
                'name' => 'Books',
                'description' => 'Books and literature',
            ],
        ];

        // Loop through each category data and create records in database
        foreach ($categories as $category) {
            ProductCategory::create($category);
        }
    }
}
