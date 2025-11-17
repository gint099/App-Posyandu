<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Admin Kelurahan',
                'email' => 'admin@posyandu.com',
                'role' => 'admin',
                'phone' => '081234567892',
                'posyandu_id' => null,
                'password' => Hash::make('admin123'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Kader Melati',
                'email' => 'kader1@posyandu.com',
                'role' => 'kader',
                'phone' => '081234567893',
                'posyandu_id' => 1,
                'password' => Hash::make('kader123'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Kader Mawar',
                'email' => 'kader2@posyandu.com',
                'role' => 'kader',
                'phone' => '081234567894',
                'posyandu_id' => 2,
                'password' => Hash::make('kader123'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
