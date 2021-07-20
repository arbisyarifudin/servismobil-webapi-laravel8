<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Customer::create([
            'name' => 'Budi',
            'username' => 'budi',
            'email' => 'budi@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make(123456),
            'gender' => "M",
            'phone' => null,
            'address' => null,
            'photo' => null,
        ]);

        \App\Models\Customer::factory(5)->create();
    }
}
