<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Categorie;

class CreateCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categorie = [
            [
                'namec'=>'Categorie 1',
            ],
            [
                'namec'=>'Categorie 2',
            ],
            [
                'namec'=>'Categorie 3',
            ],
            [
                'namec'=>'Categorie 4',
            ],

        ];

        foreach ($categorie as $key => $value) {
            Categorie::create($value);
        }
    }
}
