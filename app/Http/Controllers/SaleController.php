<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SaleController extends Controller
{


    public function index()
    {

        $sales = Sale::with(['user', 'saleDetail.product'])->get();
        return view('layouts.facturasLista');
    }
    public function info()
    {

        $sales = Sale::with(['user.type'])->get();

        // Mapear los datos necesarios
        $formattedData = $sales->map(function ($sale) {
            return [
                'sales_subtotal' => $sale->sale_subtotal,
                'id' => $sale->id,
                'sales_total' => $sale->sale_total,
                'user_name' => $sale->user->user_name,
                'user_cc_nit' => $sale->user->user_cc_nit,
                'user_type' => $sale->user->type->type_name, 
                'details' => $sale->saleDetail->map(function ($detail) {
                    return [
                        'product_id' => $detail->product_id,
                        'product_name' => $detail->product->product_name,
                        'quantity_product' => $detail->quantity_product,
                    ];
                }),
            ];
        });

        // Retornar los datos en formato JSON
        return response()->json($formattedData);
    }





    public function create()
    {
        try {
            $productos = Product::all();
            return view('inicio', compact('productos'));;
        } catch (\Throwable $ex) {

            //registro error Log
            Log::error('Error en SaleController@create: ' . $ex->getMessage());

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