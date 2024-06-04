<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SaleDetailController extends Controller
{

    
    public function index()
    {
        try {
        } catch (\Throwable $ex) {

            //registro error Log
            Log::error('Error en SaleDetailController@index: ' . $ex->getMessage());

            return response()->json(
                [
                    'status' => false,
                    'message' => 'Se produjo un error en el servidor'
                ],
                500
            );
        }
    }




    public function create()
    {
        try {
        } catch (\Throwable $ex) {

            //registro error Log
            Log::error('Error en SaleDetailController@create: ' . $ex->getMessage());

            return response()->json(
                [
                    'status' => false,
                    'message' => 'Se produjo un error en el servidor'

                ],
                500
            );
        }
    }


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





    public function show($id)
    {
        try {


          
        } catch (\Throwable $ex) {

            //registro error Log
            Log::error('Error en SaleDetailController@show: ' . $ex->getMessage());

            return response()->json(
                [
                    'status' => false,
                    'message' => 'Se produjo un error en el servidor'
                ],
                500
            );
        }
    }


    public function edit(Request $request, $id)
    {

        try {


        } catch (\Throwable $ex) {

            //registro error Log
            Log::error('Error en SaleDetailController@edit: ' . $ex->getMessage());

            return response()->json(
                [
                    'status' => false,
                    'message' => 'Se produjo un error en el servidor'

                ],
                500
            );
        }
    }


    public function update(Request $request, $id)
    {

        try {

            
        } catch (\Throwable $ex) {

            //registro error Log
            Log::error('Error en SaleDetailController@update: ' . $ex->getMessage());

            return response()->json(
                [
                    'status' => false,
                    'message' => 'Se produjo un error en el servidor'

                ],
                500
            );
        }
    }




    public function destroy($id)
    {
        try {
        } catch (\Throwable $ex) {

            //registro error Log
            Log::error('Error en SaleDetailController@destroy: ' . $ex->getMessage());

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
