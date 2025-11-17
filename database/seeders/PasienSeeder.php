<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PasienSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('pasiens')->insert([
            [
                'nik' => '3201012020000001',
                'no_kk' => '3201010101010001',
                'nama_lengkap' => 'Budi Santoso',
                'jenis_kelamin' => 'L',
                'tanggal_lahir' => '2020-01-15',
                'tempat_lahir' => 'Jakarta',
                'alamat' => 'Jl. Melati No. 10, RW 01',
                'nama_ayah' => 'Santoso',
                'nama_ibu' => 'Siti Nurhaliza',
                'phone_ortu' => '081234567895',
                'posyandu_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nik' => '3201012021000002',
                'no_kk' => '3201010101010002',
                'nama_lengkap' => 'Ani Lestari',
                'jenis_kelamin' => 'P',
                'tanggal_lahir' => '2021-03-20',
                'tempat_lahir' => 'Bogor',
                'alamat' => 'Jl. Mawar No. 15, RW 02',
                'nama_ayah' => 'Ahmad',
                'nama_ibu' => 'Lestari',
                'phone_ortu' => '081234567896',
                'posyandu_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
