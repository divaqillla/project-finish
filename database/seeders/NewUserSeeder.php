<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class NewUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'John Doe',
                'email' => 'john.doe@gmail.com',
                'password' => Hash::make('password'),
                'nrp' => '9999',
                'role' => 6,
                'photo' => 'default.png',
                'seksi' => 'Test Develop',
                'departemen' => 'Test Develop',
                'divisi' => 'Test Develop',
                'status' => 'ENABLED',
        ]);
    }
}
