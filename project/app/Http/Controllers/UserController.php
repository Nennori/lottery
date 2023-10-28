<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $this->validate($request, User::STORE_VALIDATION_RULES);

        User::createUser($request->only('first_name', 'last_name', 'password', 'email'));

        return response()->json(['message' => 'Success', 'data' => []]);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $this->validate($request, User::UPDATE_VALIDATION_RULES);

        User::updateUser($id, $request->only('first_name', 'last_name', 'email', 'old_password', 'new_password'));

        return response()->json(['message' => 'Success', 'data' => []]);
    }

    public function delete(int $id): JsonResponse
    {
        User::deleteUser($id);

        return response()->json(['message' => 'Success', 'data' => []]);
    }

    public function index(): JsonResponse
    {
        return response()->json(['message' => 'Success', 'data' => User::all()]);
    }
}
