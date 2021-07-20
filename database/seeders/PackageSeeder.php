<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        \App\Models\Package::insert([
            [
                'name' => 'Ganti Oli A',
                'about' => $faker->text(50)
            ],
            [
                'name' => 'Ganti Oli B',
                'about' => $faker->text(50)
            ],
            [
                'name' => 'Full Servis',
                'about' => $faker->text(50)
            ]
        ]);
    }
}
