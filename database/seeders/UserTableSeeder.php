<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Buat peran
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'user']);

        // Buat pengguna admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'), // Ganti 'password' dengan kata sandi yang Anda inginkan
            'role_id' => 1, // admin
        ]);

        // Buat pengguna biasa
        User::create([
            'name' => 'User',
            'email' => 'user@example.com',
            'password' => bcrypt('password'), // Ganti 'password' dengan kata sandi yang Anda inginkan
            'role_id' => 2, // user
        ]);
    }
}
