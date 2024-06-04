<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleDetail;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SaleDetail>
 */
class SaleDetailFactory extends Factory
{
    protected $model = SaleDetail::class;

    public function definition()
    {

        // Desabilita temporalmente las restricciones de llave foranea
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        $quantity = $this->faker->numberBetween(1, 10);
        $product = Product::find($this->faker->numberBetween(1, 30));

        return [
            'quantity_product' => $quantity,
            'sale_id' => fake()->numberBetween(1, 30),
            'product_id' => $product->id,
            'sale_detail_total' => $product->product_price * $quantity,
            'updated_at' => now(),
            'created_at' => now(),
        ];

        // HAbilita nevamente las restricciones de llaves foraneas
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
