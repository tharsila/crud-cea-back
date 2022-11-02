<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        return User::get();
    }

    /**
     * Adiciona um usuário
     *
     * @param Request $request
     * @return User
     */
    public function store(Request $request)
    {
        $fields =  $request->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string']
        ]);

        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password'])
        ]);
        
        $token = $user->createToken('JWT')->plainTextToken;

        $response = [
            "user" => $user,
            "token" => $token,
        ];
        return response($response, 201);
        
        /* $userData = $request->all();
        return User::create($userData);

        /* $token = $user->createToken('JWT');
        return response()->json($token->plainTextToken(), 201); */
    }

    public function login(Request $request) 
    {
        $fields = $request->validate([
            "email" => ['required', 'email'],
            "password" => ['required', 'string'],
        ]);

        $user = User::where('email', $fields['email'])->first();

        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return response([
                "message" => "Email ou senha inválidos!"
            ], 401);
        }

        $token = $user->createToken('JWTLogado')->plainTextToken;

        $response = [
            "user" => $user,
            "token" => $token
        ];

        return response($response);
    }

    /**
     * Visualiza um usuário especifico
     *
     * @param [type] $id
     * @return User
     */
    public function show($id)
    {
        return User::findOrFail($id);
    }

    /**
     * Atualiza um usuário especifico
     *
     * @param Request $request
     * @param [type] $id
     * @return void
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->all());

        return $user;
    }
    /**
     * Remove um usuário especifico
     *
     * @param [type] $id
     * @return void
     */
    public function destroy($id)
    {
        return User::destroy($id);
    }
    
}
