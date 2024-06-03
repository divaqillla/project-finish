<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SupplierPTSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('suppliers')->insert([
            [
                'username' => 'supplier_gpu',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'pt' => 'PT Gpu',
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'supplier_dm_indo',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'pt' => 'PT Dm Indonesia',
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'supplier_menara_adi',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'pt' => 'PT Menara Adi Cipta',
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'supplier_kurnia_manunggal',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'pt' => 'PT Kurnia Manunggal Sejahtera',
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'supplier_perdana',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'pt' => 'PT Rachmat Perdana Adhimetal',
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
