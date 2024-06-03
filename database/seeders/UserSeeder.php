<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        User::create([
            'name' => 'Section 1',
            'role' => 4,
            'email' => 'section_1@gmail.com',
            'password' => Hash::make('password'),
            'nrp' => 1,
        ]);

        User::create([
            'name' => 'Section 2',
            'role' => 4,
            'email' => 'section_2@gmail.com',
            'password' => Hash::make('password'),
            'nrp' => 5,
        ]);

        User::create([
            'name' => 'Section 3',
            'role' => 4,
            'email' => 'section_3@gmail.com',
            'password' => Hash::make('password'),
            'nrp' => 6,
        ]);


        User::create([
            'name' => 6,
            'role' => 6,
            'email' => 'div_head@gmail.com',
            'password' => Hash::make('password'),
            'nrp' => 2,
        ]);


        User::create([
            'name' => 'Div Head 2',
            'role' => 6,
            'email' => 'div_head_2@gmail.com',
            'password' => Hash::make('password'),
            'nrp' => 22,
        ]);

        User::create([
            'name' => 'Dept',
            'role' => 5,
            'email' => 'dept@gmail.com',
            'password' => Hash::make('password'),
            'nrp' => 3,
        ]);

        User::create([
            'name' => 'Dept 3',
            'role' => 5,
            'email' => 'dept_3@gmail.com',
            'password' => Hash::make('password'),
            'nrp' => 33,
        ]);

        User::create([
            'name' => 'Supplier',
            'role' => 'Supplier',
            'email' => 'Supplier@gmail.com',
            'password' => Hash::make('password'),
            'nrp' => 4,
        ]);
    }
}
