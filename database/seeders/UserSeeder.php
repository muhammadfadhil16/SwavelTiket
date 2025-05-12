<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Jalankan seeder untuk mengisi data pengguna.
     *
     * @return void
     */
    public function run()
    {
        // Membuat data pengguna Admin
        User::factory()->create([
            'name_user' => 'Admin2',
            'email_user' => 'admin2@gmail.com',
            'password' => bcrypt('admin123'), // Menggunakan bcrypt untuk hashing password
            'role' => 'Admin'
        ]);

        // Membuat data pengguna User
        User::factory()->create([
            'name_user' => 'User2',
            'email_user' => 'user2@gmail.com',
            'password' => bcrypt('user123'), // Menggunakan bcrypt untuk hashing password
            'role' => 'User'
        ]);
    }
}
