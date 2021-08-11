<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MonthSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('months')->insert([
            [
                'number' => 1,
                'name' => 'Januari',
            ],
            [
                'number' => 2,
                'name' => 'Februari',
            ],
            [
                'number' => 3,
                'name' => 'Maret',
            ],
            [
                'number' => 4,
                'name' => 'April',
            ],
            [
                'number' => 5,
                'name' => 'Mei',
            ],
            [
                'number' => 6,
                'name' => 'Juni',
            ],
            [
                'number' => 7,
                'name' => 'Juli',
            ],
            [
                'number' => 8,
                'name' => 'Agustus',
            ],
            [
                'number' => 9,
                'name' => 'September',
            ],
            [
                'number' => 10,
                'name' => 'Oktober',
            ],
            [
                'number' => 11,
                'name' => 'November',
            ],
            [
                'number' => 12,
                'name' => 'Desember',
            ],
        ]);
    }
}
