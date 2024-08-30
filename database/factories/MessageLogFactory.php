<?php

namespace Database\Factories;

use App\Models\MessageLog;
use App\Models\Message;
use App\Models\User;
use App\Models\Category;
use App\Models\Channel;
use Illuminate\Database\Eloquent\Factories\Factory;

class MessageLogFactory extends Factory
{
    protected $model = MessageLog::class;

    public function definition()
    {
        return [
            'message_id' => Message::factory(),
            'user_id' => User::factory(),
            'category_id' => Category::factory(),
            'channel_id' => Channel::inRandomOrder()->first()->id, // Reuse pre-created channels
            'status' => $this->faker->randomElement(['queued', 'sent', 'failed']),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
