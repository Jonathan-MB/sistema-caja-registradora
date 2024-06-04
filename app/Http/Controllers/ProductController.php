<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Psy\Readline\Hoa\Console;

class ProductController extends Controller
{


    public function index(Request $request)
    {
        try {

            $search = $request->input('search');

    $products = DB::table('products')
        ->when($search, function ($query, $search) {
            return $query->where('product_name', 'like', "%".$search."%")
                         ->orWhere('product_code', 'like',"%".$search."%");
        })
        ->paginate(10);  

    return view('layouts.productsIndex', compact('products'));
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

            return view('layouts.productCreate');
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
            $productCode = $request->input('productCode');
            $product = DB::table('products')->where('product_code', $productCode)->first();

            if ($product != null) {
                // Para activar alerta 
                return redirect()->back()->with('error', 'El producto ya existe')->withInput();
            } else {
                // Validar la información es correcta
                $validator = Validator::make($request->all(), [
                    'productName' => 'required|string|max:45|unique:products,product_name',
                    'productCode' => 'required|string|max:40|unique:products,product_code',
                    'productPrice' => 'required|numeric|min:0',
                    'productStock' => 'required|integer|min:0',
                ]);

                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }

                // Crear Producto
                $newProduct = DB::table('products')->insert([
                    'product_name' => $request->input('productName'),
                    'product_code' => $request->input('productCode'),
                    'product_price' => $request->input('productPrice'),
                    'product_stock' => $request->input('productStock'),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $productID = DB::table('products')->where('product_code', $productCode)->value('id');
                // Ver Producto creado
                return redirect()->route('product.show', ['product' => $productID]);
            }
        } catch (\Throwable $ex) {
            // Registrar error en el log
            Log::error('Error en ProductController@store: ' . $ex->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Se produjo un error en el servidor'
            ], 500);
        }
    }





    public function show($id)
    {
        try {
            $product = DB::table('products')->find($id);

            if ($product) {

                return view('layouts.productShow', ['product' => $product]);
            } else {
                // Redirecciona si no hay producto 
                return redirect()->route('product.index')->with('error', 'El producto no se encontró');
            }
        } catch (\Throwable $ex) {
            // Registrar error en el log
            Log::error('Error en ProductController@show: ' . $ex->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Se produjo un error en el servidor'
            ], 500);
        }
    }





    public function edit($id)
    {
        $product = DB::table('products')->find($id);

        if (!$product) {
            return redirect()->route('product.index')->with('error', 'Producto no encontrado.');
        }

        return view('layouts.productEdit', compact('product'));
    }





    public function update(Request $request, $id)
    {
        try {
            $product = DB::table('products')->find($id);

            if (!$product) {
                return redirect()->route('product.index')->with('error', 'Producto no encontrado.');
            }

            $validator = Validator::make($request->all(), [
                'productName' => 'required|string|max:45|unique:products,product_name,' . $id,
                'productCode' => 'required|string|max:40|unique:products,product_code,' . $id,
                'productPrice' => 'required|numeric|min:0',
                'productStock' => 'required|integer|min:0',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            DB::table('products')
                ->where('id', $id)
                ->update([
                    'product_name' => $request->input('productName'),
                    'product_code' => $request->input('productCode'),
                    'product_price' => $request->input('productPrice'),
                    'product_stock' => $request->input('productStock'),
                    'updated_at' => now(),
                ]);

            return redirect()->route('product.show', ['product' => $id])->with('success', 'Producto actualizado exitosamente.');
        } catch (\Throwable $ex) {
            Log::error('Error en ProductController@update: ' . $ex->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Se produjo un error en el servidor'
            ], 500);
        }
    }
}
