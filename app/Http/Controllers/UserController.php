<?php

namespace App\Http\Controllers;

use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{


    public function index()
    {
        try {

            return ('index user');
        } catch (\Throwable $ex) {

            //registro error Log
            Log::error('Error en UserController@index: ' . $ex->getMessage());

            return response()->json(
                [
                    'status' => false,
                    'message' => 'Se produjo un error en el servidor'
                ],
                500
            );
        }
    }




    public function validateUser(Request $request)
    {
        try {
            $ccNit = $request->input('ccNitInicio');
            $user = DB::table('users')->where('user_cc_nit', $ccNit)->first();

            if ($user != null) {

                // retorna json con la informacion de usuario 
                return response()->json(
                    [
                        'status' => true,
                        'user' => $user
                    ]
                );
            } else {
                // Usuario no encontrado, redirigir a registro
                return response()->json(
                    [
                        'status' => false
                    ]
                );
            }
        } catch (\Throwable $ex) {
            // Registro de error
            Log::error('Error en UserController@validateUser: ' . $ex->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Se produjo un error en el servidor'
            ], 500);
        }
    }





    public function create()
    {
        try {
            // Envía información de tipos de usuario para el registro 
            $tiposCliente = Type::all();
            return view('layouts.Registro', ['tiposCliente' => $tiposCliente]);
        } catch (\Throwable $ex) {
            // Registro de error
            Log::error('Error en UserController@create: ' . $ex->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Se produjo un error en el servidor'
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $ccNit = $request->input('ccNit');
            $user = DB::table('users')->where('user_cc_nit', $ccNit)->first();
    
            if ($user != null) {
                return redirect()->route('sale.create')->with('error', 'Usuario ya existe');
            } else {
                // Crea Usuario
                DB::table('users')->insert([
                    'user_name' => $request->input('nombre'),
                    'user_cc_nit' => $request->input('ccNit'),
                    'user_business_name' => $request->input('razonSocial'),
                    'type_id' => $request->input('tipoClienteSelect'),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                return redirect()->route('sale.create')->with('success', 'Usuario creado con éxito');
            }
        } catch (\Throwable $ex) {
            Log::error('Error en UserController@store: ' . $ex->getMessage());
            return redirect()->route('sale.create')->with('error', 'Se produjo un error en el servidor');
        }
    }
}