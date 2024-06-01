<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TypeController extends Controller
{

    
    public function index()
    {
        try {

            return ('hola');

        } catch (\Throwable $ex) {

            //registro error Log
            Log::error('Error en TypeController@index: ' . $ex->getMessage());

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