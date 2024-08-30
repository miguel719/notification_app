<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChannelsTableSeeder extends Seeder
{
    public function run()
    {
        // Define the channels with both 'name' and 'code'
        $channels = [
            ['name' => 'SMS', 'code' => 'sms'],
            ['name' => 'Email', 'code' => 'email'],
            ['name' => 'Push Notification', 'code' => 'push_notification']
        ];

        // Loop through each channel and update or insert
        foreach ($channels as $channel) {
            DB::table('channels')->updateOrInsert(
                ['code' => $channel['code']], // Check if channel with this code exists
                ['name' => $channel['name'], 'code' => $channel['code']] // Update or insert both name and code
            );
        }
    }
}
