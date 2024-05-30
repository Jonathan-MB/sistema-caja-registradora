<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // creacion predefinida  tipos de usario
        $types = [
            [
                'type_name' => 'persona natural',
                'updated_at' => now(),
                'created_at' => now(),
            ],
            [
                'type_name' => 'Empresa',
                'updated_at' => now(),
                'created_at' => now(),
            ]
        ];

        
        DB::table('types')->insert($types);
    }
}
