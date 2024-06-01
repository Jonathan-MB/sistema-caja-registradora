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
            $ccNit = $request->input('ccNit');
            $user = DB::table('users')->where('user_cc_nit', $ccNit)->first();

            if ($user != null) {

                // Usuario encontrado, redireccionar a facturar (sale.index)
                return redirect()->route('sale.create');
            } else {
                // Usuario no encontrado, redirigir a registro
                return redirect()->route('user.create');
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

                // Guardar variables session
                Session::flash('alert', 'El usuario ya existe en la base de datos.');

                // Usuario 
                return redirect()->back();
            } else {

                // Crea Usuario
                $newUser = DB::table('users')->insert([
                    'user_name' => $request->input('nombre'),
                    'user_cc_nit' => $request->input('ccNit'),
                    'user_business_name' => $request->input('razonSocial'),
                    'type_id' => $request->input('tipoClienteSelect'),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Guardar información del usuario en la sesión
                session(['usuario' => $newUser]);

                // Redireccionar a la ruta de facturación
                return redirect()->route('sale.create');
            }
        } catch (\Throwable $ex) {
            // Registrar error en el log
            Log::error('Error en UserController@store: ' . $ex->getMessage());

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