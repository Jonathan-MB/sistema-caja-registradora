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
                'user_type' => $sale->user?->type?->type_name,
                'details' => $sale->saleDetail->map(function ($detail) {
                    return [

                        'product_id' => $detail->product_id,
                        'product_id' => $detail->product_id,
                        'product_name' => $detail->product->product_name,
                        'product_price' => $detail->product->product_price,
                        'quantity_product' => $detail->quantity_product,
                        'total_product' => $detail->quantity_product * $detail->product->product_price,
                        'code_product' => $detail->product->product_code


                    ];
                }),
            ];
        });

        return response()->json($formattedData);
    }






    public function infor()
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
        // Desactiva las llaves foráneas
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    
        // Crea una nueva venta
        $sale = Sale::create([
            'user_id' => floatval(str_replace(',', '', $request->user_id)),
            'sale_subtotal' => floatval(str_replace(',', '', $request->subtotalcantidadHiden)),
            'sale_total' => floatval(str_replace(',', '', $request->subtotalcantidadHiden)) * 1.19,
        ]);
        
        $productID = Product::where('product_code', ($request->productoCode))->pluck('id')->first();
    
        // Crea el detalle de la venta
        $SaleDetail = SaleDetail::create([
            'sale_id' => $sale->id,
            'product_id' => $productID,
            'quantity_product' => floatval(str_replace(',', '', $request->cantidadProducto)),
            'sale_detail_total' => floatval(str_replace(',', '', $request->subtotalcantidadHiden)) * 1.19,
        ]);
    
        // Resta la cantidad del inventario
        $product = Product::find($productID);
        if ($product) {
            $product->product_stock = $product->product_stock - $SaleDetail->quantity_product;
            $product->save();
        }
    
        // Reactiva las restricciones de llaves foráneas
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    
        // Limpia la sesión
        $request->session()->flush();
    
        // Redirige con un mensaje de éxito
        return redirect()->route('sale.show', $sale->id)->with('message', 'Venta creada con éxito');
    }
    




    public function show($id)
    {
        try {
            // Fetch the sale with the given ID
            $sale = DB::table('sales')->where('id', $id)->first();
            $user = DB::table('users')->where('id', $sale->user_id)->first();
            
            // If sale does not exist, redirect with an error
            if (!$sale) {
                return redirect()->route('sale.index')->with('error', 'La factura no se encontró');
            }
    
            // Fetch the sale details related to the sale, joined with the products table to get product names
            $saleDetails = DB::table('sale_details')
                ->join('products', 'sale_details.product_id', '=', 'products.id')
                ->where('sale_details.sale_id', $id)
                ->select('sale_details.*', 'products.product_name','products.product_code',)
                ->get();
    
            // Format the sale data to match the view requirements
            $factura = (object) [
                'id' => $sale->id,
                'sales_subtotal' => $sale->sale_subtotal,
                'sales_total' => $sale->sale_total,
                'user_name' => $user->user_name,
                'user_cc_nit' => $user->user_cc_nit,
                'user_type' => $user->type_id,
                'details' => $saleDetails
            ];
    
            // Pass the sale data to the view
            return view('layouts.facturaShow', compact('factura'));
            
        } catch (\Throwable $ex) {
            // Log the error
            Log::error('Error en SaleController@show: ' . $ex->getMessage());
    
            // Return a JSON response indicating an internal server error
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
