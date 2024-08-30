<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Category;
use App\Models\Channel;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->phoneNumber,
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }

    public function withCategoriesAndChannels()
    {
        return $this->afterCreating(function (User $user) {
            // Attach random categories
            $categories = Category::inRandomOrder()->take(rand(1, 3))->pluck('id');
            $user->categories()->attach($categories);

            // Attach random channels
            $channels = Channel::inRandomOrder()->take(rand(1, 3))->pluck('id');
            $user->channels()->attach($channels);
        });
    }
}
