<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{

    public function run(): void
    {

        $product = [
            'product_name' => 'aaaaa producto prueba cero Stock',
            'product_code' => '0000001',
            'product_price' => 50685.01,
            'product_stock' => 0,
        ];

        
        DB::table('products')->insert($product);


        Product::factory(30)->create();
    }
}
