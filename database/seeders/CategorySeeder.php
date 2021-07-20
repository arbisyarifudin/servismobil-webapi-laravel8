<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        \App\Models\Category::insert([
            [
                'name' => 'Suku Cadang',
                'about' => $faker->text(50)
            ],
            [
                'name' => 'Aksesories',
                'about' => $faker->text(50)
            ],
            [
                'name' => 'Oli',
                'about' => $faker->text(50)
            ]
        ]);
    }
}
