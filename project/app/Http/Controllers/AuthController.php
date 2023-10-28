<?php

namespace App\Http\Controllers;

use App\Models\User;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    const AUTH_LOGIN_VALIDATION_RULES = [
        'email' => 'required|email|max:255',
        'password' => 'required|max:22',
    ];

    public function login(Request $request)
    {
        $this->validate($request, self::AUTH_LOGIN_VALIDATION_RULES);

        $password = $request->input('password');
        $user = User::where('email', $request->input('email'))->first();

        if (null !== $user && $this->passwordIsCorrect($user, $password)) {
            $token = $this->createToken($user->id);

            return response()->json(['message' => 'Success', 'data'=> ['token' => $token]]);
        }

        return response()->json(['message' => 'Invalid credentials', 'data' => []], 400);
    }

    public function passwordIsCorrect($user, $password): bool
    {
        return Hash::check($password, $user->password);
    }

    public function createToken($userId): string
    {
        $key = env('APP_KEY');
        $time = time();
        $token = [
            'iat' => $time,
            'nbf' => $time,
            'exp' => $time + 7200,
            'data' => [
                'id' => $userId,
            ]
        ];

        return JWT::encode($token, $key, 'HS256');
    }
}
