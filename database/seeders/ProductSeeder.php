<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $products = [
            [
                'name' => 'Apple',
                'description' => 'Fresh and juicy red apples',
                'price' => 1.99,
                'quantity' => 100,
                'category' => 'fruit',
                'is_featured' => true
            ],
            [
                'name' => 'Banana',
                'description' => 'Sweet and ripe bananas',
                'price' => 0.99,
                'quantity' => 150,
                'category' => 'fruit',
                'is_featured' => true
            ],
            [
                'name' => 'Carrot',
                'description' => 'Fresh and crunchy carrots',
                'price' => 0.79,
                'quantity' => 200,
                'category' => 'vegetable',
                'is_featured' => true
            ],
            [
                'name' => 'Tomato',
                'description' => 'Juicy and ripe tomatoes',
                'price' => 1.49,
                'quantity' => 120,
                'category' => 'vegetable',
                'is_featured' => true
            ],
            [
                'name' => 'Orange',
                'description' => 'Sweet and tangy oranges',
                'price' => 1.29,
                'quantity' => 90,
                'category' => 'fruit',
                'is_featured' => false
            ],
            [
                'name' => 'Broccoli',
                'description' => 'Fresh and nutritious broccoli',
                'price' => 1.99,
                'quantity' => 80,
                'category' => 'vegetable',
                'is_featured' => false
            ]
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
