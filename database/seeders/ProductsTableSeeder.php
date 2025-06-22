<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $products = [
            [
                'name' => 'Digital Camera',
                'price' => 299.99,
                'quantity' => 15,
                'image' => 'camera.jpg',
                'description' => 'High-resolution digital camera with 4K video recording'
            ],
            [
                'name' => 'Gaming Console',
                'price' => 499.99,
                'quantity' => 0,
                'image' => 'console.jpg',
                'description' => 'Next-gen gaming console with 1TB storage'
            ],
            [
                'name' => 'Wireless Earphones',
                'price' => 129.99,
                'quantity' => 25,
                'image' => 'earphones.jpg',
                'description' => 'Premium wireless earphones with noise cancellation'
            ],
            [
                'name' => 'Over-Ear Headphones',
                'price' => 199.99,
                'quantity' => 12,
                'image' => 'headphones.jpg',
                'description' => 'Professional studio headphones with deep bass'
            ],
            [
                'name' => 'Wireless Headphones',
                'price' => 179.99,
                'quantity' => 18,
                'image' => 'headphones2.jpg',
                'description' => 'Bluetooth headphones with 30-hour battery life'
            ],
            [
                'name' => 'Smartphone',
                'price' => 999.99,
                'quantity' => 10,
                'image' => 'iphone.jpg',
                'description' => 'Flagship smartphone with advanced camera system'
            ],
            [
                'name' => 'Ultrabook Laptop',
                'price' => 1299.99,
                'quantity' => 6,
                'image' => 'laptop.jpg',
                'description' => 'Thin and light laptop with powerful performance'
            ],
            [
                'name' => 'Wireless Mouse',
                'price' => 49.99,
                'quantity' => 30,
                'image' => 'mouse.jpg',
                'description' => 'Ergonomic wireless mouse with precision tracking'
            ],
            [
                'name' => 'Smart Watch',
                'price' => 249.99,
                'quantity' => 20,
                'image' => 'watch.jpg',
                'description' => 'Fitness tracker with heart rate monitoring'
            ]
        ];

        foreach ($products as $product) {
            DB::table('products')->insert([
                'name' => $product['name'],
                'price' => $product['price'],
                'quantity' => $product['quantity'],
                'image' => $product['image'],
                'description' => $product['description'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
