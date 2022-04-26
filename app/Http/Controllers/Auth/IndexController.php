<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use App\Models\User;

use App\Http\Requests\Auth\{
    RegisterRequest,
    LoginRequest
};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{
    Auth,
    Hash
};

class IndexController extends Controller
{

    public function register(RegisterRequest $request)
    {

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function login(LoginRequest $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Favor verificar os dados informados!!'
            ], 401);
        }

        $user = User::where('email', $request['email'])->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function me(Request $request)
    {
        return $request->user();
    }

    public function logout(Request $request)
    {

        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Logout realizado com sucesso!!'
        ]);
    }
}
