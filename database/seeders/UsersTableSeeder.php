<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Category;
use App\Models\Channel;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        // Use faker to generate random data
        $faker = \Faker\Factory::create();

        // Check if there are already users to avoid duplications
        if (User::count() === 0) {
            // Create 10 random users
            for ($i = 0; $i < 10; $i++) {
                $user = User::create([
                    'name' => $faker->name,
                    'email' => $faker->unique()->safeEmail,
                    'phone' => $faker->phoneNumber,
                ]);

                // Assign random categories to the user
                $categories = Category::inRandomOrder()->take(rand(1, 3))->pluck('id');
                $user->categories()->attach($categories);

                // Assign random channels to the user
                $channels = Channel::inRandomOrder()->take(rand(1, 3))->pluck('id');
                $user->channels()->attach($channels);
            }
        }
    }
}
