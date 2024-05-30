<?php

namespace Database\Factories;

use App\Models\Sale;
use App\Models\SaleDetail;
use Illuminate\Database\Eloquent\Factories\Factory;

class SaleFactory extends Factory
{
    protected $model = Sale::class;

    public function definition()
    {
        // Crea venta falsa con valores iniciales
        $saleFalse = [
            'sale_subtotal' => 0,
            'sale_total' => 0,
            'user_id' => 1, 
        ];

        // Inserta venta falsa en la BD y obtiene su ID
        $saleId = Sale::create($saleFalse)->id;

        // Crea al menos un SaleDetail asociado a esta venta
        SaleDetail::factory()->create([
            'sale_id' => $saleId,
        ]);

        // Calcula subtotal de saleDetail asociados
        $subtotal = SaleDetail::where('sale_id', $saleId)->sum('sale_detail_total');

        // Calcula total con impuestos
        $total = $subtotal * 1.19;

        // Define datos reales
        $realSale = [
            'sale_subtotal' => $subtotal,
            'sale_total' => $total,
            'user_id' => $this->faker->numberBetween(1, 10),
            'updated_at' => now(),
            'created_at' => now(),
        ];

        // Actualiza venta con datos reales
        Sale::where('id', $saleId)->update($realSale);

        return $realSale;
    }
}
