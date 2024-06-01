<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SaleDetailController extends Controller
{





    public function store(Request $request)
    {
        try {

        } catch (\Throwable $ex) {

            //registro error Log
            Log::error('Error en SaleDetailController@store: ' . $ex->getMessage());

            return response()->json(
                [
                    'status' => false,
                    'message' => 'Se produjo un error en el servidor'

                ],
                500
            );
        }
    }

}