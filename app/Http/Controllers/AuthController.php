<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
    public function registerApi (Request $request)
    {
        $validate = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email',
            'password' => 'required|min:5'
        ]);

        $user = User::create($request->all());
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer'
        ]);
    }

    public function loginApi(Request $request)
    {
        if (!Auth::attempt($request->all()))
        {
            return response()->json([
                'message' => 'Credenciales incorrectas'
            ]);
        }

        $user = User::where('email', $request->email)->first();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer'
        ]);
    }

    public function infoUser(Request $request)
    {
        return $request->user();
    }
}
