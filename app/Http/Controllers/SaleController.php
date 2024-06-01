<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\User;
use Database\Seeders\SaleSeeder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        // Obtener todas las ventas con sus detalles, usuarios y tipos de usuarios asociados
        $sales = Sale::with(['user.type'])->get();

        // Mapear los datos necesarios
        $formattedData = $sales->map(function ($sale) {
            return [
                'sales_subtotal' => $sale->sale_subtotal,
                'id' => $sale->id,
                'sales_total' => $sale->sale_total,
                'user_name' => $sale->user?->user_name,
                'user_cc_nit' => $sale->user?->user_cc_nit,
                'user_type' => $sale->user?->type?->type_name, // Obtener el nombre del tipo de usuario
                'details' => $sale->saleDetail->map(function ($detail) {
                    return [
                        'product_id' => $detail->product_id,
                        'product_name' => $detail->product->product_name,
                        'quantity_product' => $detail->quantity_product,
                    ];
                }),
            ];
        });

        return response()->json($formattedData);
    }

    public function create()
    {
        try {
            $productos = Product::select(
                'product_name',
                'product_code',
                'product_stock',
                'product_price'
            )->get();

            return view('layouts.Facturar', ['productos' => $productos]);
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



    public function store(Request $request)
    {

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        // Crea una nueva venta
        $sale = Sale::create([
            'user_id' => floatval(str_replace(',', '', $request->user_id)),
            'sale_subtotal' => floatval(str_replace(',', '', $request->subtotalcantidadHiden)),
            'sale_total' => floatval(str_replace(',', '', $request->subtotalcantidadHiden)) * 1.19,

        ]);
        $productID = Product::where('product_code', ($request->productoCode))->pluck('id')->first();

        $SaleDetail = SaleDetail::create([
            'sale_id' => $sale->id,
            'product_id' => $productID,
            'quantity_product' => floatval(str_replace(',', '', $request->cantidadProducto)),
            'sale_detail_total' => floatval(str_replace(',', '', $request->subtotalcantidadHiden)) * 1.19,
        ]);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');



        return view('layouts.facturasLista', ['message' => 'Venta creada con éxito', 'sale']);
    }






    public function show($id)
    {
        try {
        } catch (\Throwable $ex) {

            //registro error Log
            Log::error('Error en SaleController@show: ' . $ex->getMessage());

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
            Log::error('Error en SaleController@edit: ' . $ex->getMessage());

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
            Log::error('Error en SaleController@update: ' . $ex->getMessage());

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
            Log::error('Error en SaleController@destroy: ' . $ex->getMessage());

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
