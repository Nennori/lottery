<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function store(Request $request): void
    {
        $this->validate($request, User::STORE_VALIDATION_RULES);

        User::createUser($request->only('first_name', 'last_name', 'password', 'email'));
    }

    public function update(Request $request, int $id): void
    {
        $this->validate($request, User::UPDATE_VALIDATION_RULES);

        User::updateUser($id, $request->only('first_name', 'last_name', 'email', 'old_password', 'new_password'));
    }

    public function delete(int $id): void
    {
        User::deleteUser($id);
    }

    public function index(): Collection
    {
        return User::all();
    }
}
