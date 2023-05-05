<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Faker\Factory as FakerFactory;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $faker = FakerFactory::create('tr_TR');

        // for ($i = 1; $i <= 1020; $i++) {
        //     User::create([
        //         'name' => $username = $faker->firstName() . $faker->lastName(),
        //         'email' => $faker->unique()->safeEmail(),
        //         'password' => Hash::make('password'),
        //     ]);
        // }
    }
}