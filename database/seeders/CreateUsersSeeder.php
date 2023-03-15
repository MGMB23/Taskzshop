<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class CreateUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = [
            [
                'name'      =>'Admin',
                'email'     =>'admin@gmail.com',
                'usertype'  =>'admin',
                'phone'     =>'0678564534',
                'password'  => bcrypt('admin@gmail.com'),
            ],
        ];

        foreach ($user as $key => $value) {
            User::create($value);
        }
    }
}
