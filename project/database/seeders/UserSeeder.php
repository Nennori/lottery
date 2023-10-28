<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->count(20)->create(['password' => '123456a!']);
        User::factory()->count(1)->create(['is_admin' => true, 'password' => '123456a!', 'email' => 'admin@mail.com']);
    }
}
