<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use Faker\Factory as FakerFactory;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = FakerFactory::create('tr_TR');

        for ($i = 1; $i <= 100; $i++) {
            Order::create([
                'uuid' => $faker->uuid(),
                'email' => $faker->email(),
                'user_id' => rand(1, 350),
                'shipping_address_id' => 1,
                'shipping_type_id' => rand(1, 4),
                'subtotal' => rand(750, 16500),
                'placed_at' => $faker->dateTimeBetween('-2 months', 'now'),
                'packaged_at' => $faker->dateTimeBetween('-1 months', 'now'),
                'shipped_at' => $faker->dateTimeBetween('-1 months', 'now'),
            ]);
        }
    }
}