<?php

namespace App\Http\Controllers;

use App\Models\Type;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{


    public function index(Request $request)
    {
        try {

            $search = $request->input('search');

            $users = DB::table('users')
                ->when($search, function ($query, $search) {
                    return $query->where('user_name', 'like', "%" . $search . "%")
                        ->orWhere('user_cc_nit', 'like', "%" . $search . "%");
                })
                ->paginate(10);

            return view('layouts.userIndex', compact('users'));
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

                $user = DB::table('users')->where('user_cc_nit', $ccNit)->first();
                return view('layouts.facturar', ['user' => $user]);
            } else {


                $user = DB::table('users')->where('user_cc_nit', $ccNit)->first();
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

            return view('layouts.userCreate', ['tiposCliente' => $tiposCliente]);
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

                // Para activar alerta 
                return redirect()->back()->with('error', 'El usuario ya existe')->withInput();
            } else {


                // Valida la informacion es correcta
                $validator = Validator::make($request->all(), [
                    'nombre' => 'required|string|max:45',
                    'ccNit' => 'required|string|max:20|min:9|unique:users,user_cc_nit',
                    'razonSocial' => 'nullable|string|max:45',
                    'tipoClienteSelect' => 'required|exists:types,id',
                ]);

                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }
                // Crea Usuario
                $newUser = DB::table('users')->insert([
                    'user_name' => $request->input('nombre'),
                    'user_cc_nit' => $request->input('ccNit'),
                    'user_business_name' => $request->input('razonSocial'),
                    'type_id' => $request->input('tipoClienteSelect'),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $user = DB::table('users')->where('user_cc_nit', $ccNit)->first();


                // Redireccionar a la ruta de facturación
                return view('layouts.facturar', ['user' => $user]);
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







    public function show($id)
    {
        try {
            $user = DB::table('users')->find($id);

            if ($user) {

                return view('layouts.userShow', ['user' => $user]);
            } else {
                // Redirecciona si no hay usero 
                return redirect()->route('user.index')->with('error', 'El Usuario no se encontró');
            }
        } catch (\Throwable $ex) {
            // Registrar error en el log
            Log::error('Error en UserController@show: ' . $ex->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Se produjo un error en el servidor'
            ], 500);
        }
    }






    public function edit($id)
    {

        $tiposCliente = Type::all();
        $user = DB::table('users')->find($id);

        if (!$user) {
            return redirect()->route('user.index')->with('error', 'usuario no encontrado.');
        }

        return view('layouts.userEdit', compact('user', 'tiposCliente'));
    }





    public function update(Request $request, $id)
    {
        try {
            // Encuentra el usuario por su ID
            $user = DB::table('users')->find($id);

            // Si no se encuentra el usuario, devuelve un error
            if (!$user) {
                return redirect()->back()->with('error', 'El usuario no existe');
            }

            // Valida la información
            $validator = Validator::make($request->all(), [
                'nombre' => 'required|string|max:45',
                'ccNit' => 'required|string|max:20|min:9|unique:users,user_cc_nit,' . $id,
                'razonSocial' => 'nullable|string|max:45',
                'tipoClienteSelect' => 'required|exists:types,id',
            ]);

            // Si la validación falla, devuelve los errores y los datos de entrada
            if ($validator->fails()) {
                return redirect()->route('user.edit', $id)->withErrors($validator)->withInput();
            }
            // Actualiza los datos del usuario
            DB::table('users')
                ->where('id', $id)
                ->update([
                    'user_name' => $request->input('nombre'),
                    'user_cc_nit' => $request->input('ccNit'),
                    'user_business_name' => $request->input('razonSocial'),
                    'type_id' => $request->input('tipoClienteSelect'),
                    'updated_at' => now(),
                ]);

            // Recupera los datos actualizados del usuario
            $updatedUser = DB::table('users')->find($id);


            // Redirecciona a la vista de detalle del usuario
            return view('layouts.userShow', ['user' => $updatedUser]);
            
        } catch (\Throwable $ex) {
            // Registra un error en el log y devuelve un mensaje de error
            Log::error('Error en UserController@update: ' . $ex->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Se produjo un error en el servidor'
            ], 500);
        }
    }
}
