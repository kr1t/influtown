<?php

use Illuminate\Database\Seeder;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::insert([
            [
                'email' => 'admin@influ.town',
                'password' => bcrypt('123456'),
                'first_name' => 'admin',
                'last_name' => 'influtown',
                'tel' => '0900000000',
                'zipcode' => '01000',
                'address' => '-',
                'city' => '-',
                'province' => '-'
            ]
        ]);
    }
}