<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // VALIDASI
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // CEK USER
        $user = User::where('email', $request->email)->first();

        // CEK PASSWORD
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Email atau password salah'
            ], 401);
        }

        // SUCCESS
        return response()->json([
            'message' => 'Login berhasil',
            'user' => $user
        ]);
    }
}