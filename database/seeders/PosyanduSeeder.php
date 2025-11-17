<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PosyanduSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('posyandus')->insert([
            [
                'nama_posyandu' => 'Posyandu Melati 1',
                'rw' => '01',
                'kelurahan' => 'Kelurahan Contoh',
                'kecamatan' => 'Kecamatan Contoh',
                'alamat' => 'Jl. Melati No. 1, RW 01',
                'ketua' => 'Ibu Siti',
                'phone' => '081234567890',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_posyandu' => 'Posyandu Mawar 2',
                'rw' => '02',
                'kelurahan' => 'Kelurahan Contoh',
                'kecamatan' => 'Kecamatan Contoh',
                'alamat' => 'Jl. Mawar No. 2, RW 02',
                'ketua' => 'Ibu Ani',
                'phone' => '081234567891',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
