<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Admin::insert([
            [
                'name' => 'Admin',
                'username' => 'admin',
                'password' => Hash::make('admin'),
                'level' => 'Admin',
            ],
            [
                'name' => 'Manajer',
                'username' => 'manajer',
                'password' => Hash::make('manajer'),
                'level' => 'Manager',
            ],
            [
                'name' => 'Karyawan 1',
                'username' => 'karyawan',
                'password' => Hash::make('karyawan'),
                'level' => 'Staff',
            ]
        ]);
    }
}
