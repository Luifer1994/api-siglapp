<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request["limit"] ? $limit = $request["limit"] : $limit = 10;
        $users = User::select('users.*')
            ->where('users.document', 'like', '%' . $request["search"] . '%')
            ->orwhere('users.name', 'like', '%' . $request["search"] . '%')
            ->orwhere('users.email', 'like', '%' . $request["search"] . '%')
            ->with('TypeUser')
            ->paginate($limit);

        return response()->json([
            "res" => true,
            "data" => $users
        ]);
    }
    public function login(LoginRequest $request)
    {
        // Obtenemos al usuario a autenticar
        $user = User::where('email', $request->email)->first();
        // Vemos si las credenciales son erróneas para retornar un mensaje de error
        if ($user && Hash::check($request->password, $user->password)) {
            return response()->json([
                'res'       => true,
                'token'     => $user->createToken('SIGLAPP')->plainTextToken,
                'user'      => $user,
                'message'   => 'Bienvenido al sistema',
            ], 200);
        } else {
            return response()->json([
                'res'       => false,
                'message'   => 'Email o password incorrecto',
            ], 400);
        }
    }
    public function logout()
    {
        //Obtenemos usuario logeado
        $user = Auth::user();
        //Busca todos los token del usuario en la base de datos y los eliminamos;
        $user->tokens->each(function ($token) {
            $token->delete();
        });
        return response()->json([
            'res' => true,
            'message' => 'Hasta la proxima',
        ], 200);
    }

    public function validateSesion()
    {
        if (Auth::check()) {
            return true;
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RegisterUserRequest $request)
    {
        $newUser = new User();
        $newUser->type_document_id      = $request->type_document;
        $newUser->type_user_id          = $request->type_user;
        $newUser->document              = $request->document;
        $newUser->center_operation_id   = $request->center_op;
        $newUser->sellar_id             = $request->seller;
        $newUser->name                  = $request->name;
        $newUser->email                 = $request->email;
        $newUser->password              = Hash::make($request->document);
        if ($newUser->save()) {
            return response()->json([
                'res' => true,
                'message' => 'Registro exitoso'
            ], 200);
        } else {
            return response()->json([
                'res' => false,
                'message' => 'Eror al guardar el registro'
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}