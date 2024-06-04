<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;


class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        return [
            'product_name' => $this->faker->unique()->word,
            'product_code' => $this->faker->unique()->ean8,
            'product_price' => $this->faker->numberBetween(1000, 1000000),
            'product_stock' => $this->faker->numberBetween(0, 100),
        ];
    }
}
