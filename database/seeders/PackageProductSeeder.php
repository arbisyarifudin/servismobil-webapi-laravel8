<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PackageProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        \App\Models\PackageProduct::insert([
            [
                'package_id' => 1,
                'product_id' => 1
            ],
            [
                'package_id' => 1,
                'product_id' => 2
            ],
            [
                'package_id' => 2,
                'product_id' => 2
            ],
            [
                'package_id' => 2,
                'product_id' => 3
            ],
            [
                'package_id' => 3,
                'product_id' => 1
            ],
        ]);
    }
}
