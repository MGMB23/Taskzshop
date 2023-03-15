<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Balance;

class CreateBalancesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $balance = [
            [
                'bal'=>1000
            ]
        ];

        foreach ($balance as $key => $value) {
            Balance::create($value);
        }
    }
}
