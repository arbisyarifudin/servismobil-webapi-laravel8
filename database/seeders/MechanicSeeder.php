<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MechanicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Mechanic::factory(5)->create();
    }
}
