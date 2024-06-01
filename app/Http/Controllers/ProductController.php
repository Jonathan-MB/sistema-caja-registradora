<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Psy\Readline\Hoa\Console;

class ProductController extends Controller
{


    public function index()
    {
        try {
        } catch (\Throwable $ex) {

            //registro error Log
            Log::error('Error en ProductController@index: ' . $ex->getMessage());

            return response()->json(
                [
                    'status' => false,
                    'message' => 'Se produjo un error en el servidor'
                ],
                500
            );
        }
    }
    public function search(Request $request)
    {
        try {
            if ($request->ajax()) {
                $query = $request->get('query');
                if ($query != '') {
                    $data = DB::table('products')
                        ->where(function ($q) use ($query) {
                            $q->where('product_name', 'like', '%' . $query . '%')
                                ->orWhere('product_code', 'like', '%' . $query . '%');
                        })
                        ->where('product_stock', '>', 0)
                        ->select('product_name', 'product_code', 'product_price', 'product_stock')
                        ->get();
                } else {
                    $data = DB::table('products')
                        ->orderBy('id', 'desc')
                        ->select('product_name', 'product_code')
                        ->get();
                }

                return response()->json($data);
            }
        } catch (\Throwable $ex) {
            Log::error('Error en ProductController@search: ' . $ex->getMessage());

            return response()->json(
                [
                    'status' => false,
                    'message' => 'Se produjo un error en el servidor'
                ],
                500
            );
        }
    }


    public function check(Request $request)
{
    try {
        $productoCode = $request->get('productoCode');
        $cantidadProducto = $request->get('cantidadProducto');

        $producto = DB::table('products')
            ->where('product_code', $productoCode)
            ->first();

        if ($producto) {
            $stockDisponible = $producto->product_stock;
            $enoughStock = $cantidadProducto <= $stockDisponible;

            return response()->json([
                'exists' => true,
                'enoughStock' => $enoughStock,
                'stockDisponible' => $stockDisponible
            ]);
        } else {
            return response()->json([
                'exists' => false
            ]);
        }
    } catch (\Throwable $ex) {
        Log::error('Error en ProductController@check: ' . $ex->getMessage());
        return response()->json([
            'error' => 'Se produjo un error en el servidor'
        ], 500);
    }
}



public function getPrice(Request $request)
{
    try {
        $productoCode = $request->get('productoCode');

        // Realiza una consulta para obtener el precio del producto basado en el código recibido
        $product = Product::where('product_code', $productoCode)->first();

        if ($product) {
            // Si se encuentra el producto, devolver el precio en formato JSON
            return response()->json(['product_price' => $product->product_price]);
        } else {
            // Si no se encuentra el producto, devuelve un error
            return response()->json(['error' => 'Producto no encontrado'], 404);
        }
    } catch (\throwable $ex) {
        // Manejar cualquier excepción que pueda ocurrir
        return response()->json(['error' => 'Error al obtener el precio del producto'], 500);
    }
}



    public function create()
    {
        try {
        } catch (\Throwable $ex) {

            //registro error Log
            Log::error('Error en ProductController@create: ' . $ex->getMessage());

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
            Log::error('Error en ProductController@store: ' . $ex->getMessage());

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