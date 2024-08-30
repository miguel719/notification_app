<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\MessagesLogsService;
use App\Models\MessageLog;
use App\Models\Message;
use App\Models\User;
use App\Models\Category;
use App\Models\Channel;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MessagesLogsServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $messagesLogsService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->messagesLogsService = new MessagesLogsService();
    
        // Pre-create necessary records to ensure foreign key constraints are met
        $channelEmail = Channel::factory()->create(['code' => 'email']);
        $channelSms = Channel::factory()->create(['code' => 'sms']);
        $channelPush = Channel::factory()->create(['code' => 'push_notification']);
        
        $category = Category::factory()->create(['name' => 'Sports']);
        
        // Create a user with a specific email
        $userWithSpecificEmail = User::factory()->create(['email' => 'test@example.com']);
    
        $message = Message::factory()->create(['category_id' => $category->id]);
    
        // Ensure user, category, and message relationships are set up correctly
        $userWithSpecificEmail->categories()->attach($category->id);
        $userWithSpecificEmail->channels()->attach([$channelEmail->id, $channelSms->id, $channelPush->id]);
    
        // Create 15 message logs for pagination, 10 for the first page and 5 for the second page
        MessageLog::factory()->count(10)->create([
            'user_id' => $userWithSpecificEmail->id,
            'message_id' => $message->id,
            'category_id' => $category->id,
            'channel_id' => $channelEmail->id,
            'status' => 'sent', // Ensure these have a different status
        ]);
    
        MessageLog::factory()->count(5)->create([
            'user_id' => $userWithSpecificEmail->id,
            'message_id' => $message->id,
            'category_id' => $category->id,
            'channel_id' => $channelSms->id,
            'status' => 'sent', // Ensure these have a different status
        ]);
    
        // Create a specific message log with status 'failed' for the status filter test
        MessageLog::factory()->create([
            'user_id' => $userWithSpecificEmail->id,
            'message_id' => $message->id,
            'category_id' => $category->id,
            'channel_id' => $channelPush->id,
            'status' => 'failed',
        ]);
    }
    

    public function test_get_messages_logs_without_filters()
    {
        // Act: Call the service without filters
        $logs = $this->messagesLogsService->getMessagesLogs([]);

        // Assert: Check the count of logs returned (should be 10 due to pagination)
        $this->assertCount(10, $logs);
        $this->assertEquals(16, $logs->total()); // Ensure total count is correct
    }

    public function test_get_messages_logs_with_category_filter()
    {
        // Act: Call the service with a category filter
        $logs = $this->messagesLogsService->getMessagesLogs(['category' => 'Sports']);

        // Assert: Check that only logs with the 'Sports' category are returned
        $this->assertCount(10, $logs); // First page of results
        $this->assertEquals(16, $logs->total()); // Ensure total count is correct
        $this->assertEquals('Sports', $logs->first()->category->name);
    }

    public function test_get_messages_logs_with_email_filter()
    {
        // Act: Call the service with an email filter
        $logs = $this->messagesLogsService->getMessagesLogs(['email' => 'test@example.com']);

        // Assert: Check that only logs for the specified email are returned
        $this->assertCount(10, $logs); // First page of results (if pagination is set to 10)
        $this->assertEquals(16, $logs->total()); // Ensure total count is correct
        $this->assertEquals('test@example.com', $logs->first()->user->email);
    }

    public function test_get_messages_logs_with_phone_filter()
    {
        // Arrange: Create a user with a specific phone number
        $userWithPhone = User::factory()->create(['phone' => '1234567890']);
        $category = Category::first(); // Use an existing category
        $message = Message::factory()->create(['category_id' => $category->id]);
        
        // Link user with phone to categories and channels
        $userWithPhone->categories()->attach($category->id);
        $userWithPhone->channels()->attach(Channel::all()->pluck('id')->toArray());

        // Create logs for this user
        MessageLog::factory()->count(3)->create([
            'user_id' => $userWithPhone->id,
            'message_id' => $message->id,
            'category_id' => $category->id,
            'channel_id' => Channel::first()->id, // Reuse any channel
        ]);

        // Act: Call the service with a phone filter
        $logs = $this->messagesLogsService->getMessagesLogs(['phone' => '1234567890']);

        // Assert: Check that only logs for the specified phone number are returned
        $this->assertCount(3, $logs);
        $this->assertEquals('1234567890', $logs->first()->user->phone);
    }

    public function test_get_messages_logs_with_status_filter()
    {
        // Act: Call the service with a status filter
        $logs = $this->messagesLogsService->getMessagesLogs(['status' => 'failed']);
    
        // Debugging print statement
        echo "Total Logs with Status 'failed': " . count($logs) . "\n";
    
        // Assert: Check that only logs with the 'failed' status are returned
        $this->assertCount(1, $logs); // Expecting 1 log with 'failed' status
        $this->assertEquals('failed', $logs->first()->status);
    }

    public function test_get_messages_logs_with_channel_filter()
    {
        // Act: Call the service with a channel filter
        $logs = $this->messagesLogsService->getMessagesLogs(['channel' => 'email']);

        // Assert: Check that only logs for the specified channel are returned
        $this->assertCount(10, $logs);
        $this->assertEquals('email', $logs->first()->channel->code);
    }
}
