<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Validation\Rules\Unique;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {


        $type = $this->faker->numberBetween(1, 2);

        // Genera NIT o CC dependiendo del tipo
        $idNumber = $this->faker->unique()->numerify($type == 1 ? '#########' : '##########');

        // Genera nombre de persona o de empresa segun type 
        $name = $this->faker->unique()->numerify($type == 1 ? fake()->name() : fake()->company());

        // Genera un nombre de empresa si el tipo es 2 sino  lo deja como null
        $businessName = $type == 2 ? fake()->Unique()->company(): null;

        return [
            'user_name' => $name,
            'user_cc_nit' => $idNumber,
            'user_business_name' => $businessName,
            'type_id' => $type,
        ];
    }
}
