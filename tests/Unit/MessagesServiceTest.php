<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\MessagesService;
use App\Services\NotificationService;
use App\Models\Message;
use App\Models\User;
use App\Models\MessageLog;
use App\Models\Category;
use App\Models\Channel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;

class MessagesServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $messagesService;
    protected $notificationServiceMock;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a mock of NotificationService
        $this->notificationServiceMock = Mockery::mock(NotificationService::class);

        // Inject the mock into the MessagesService
        $this->messagesService = new MessagesService($this->notificationServiceMock);
    }

    public function test_create_message()
    {
        // Arrange: Prepare test data
        $category = Category::factory()->create();
        $messageData = [
            'message' => 'Test message content',
            'category_id' => $category->id,
        ];

        // Act: Call the createMessage method
        $message = $this->messagesService->createMessage($messageData);

        // Assert: Check if the message was created correctly
        $this->assertDatabaseHas('messages', [
            'content' => 'Test message content',
            'category_id' => $category->id,
        ]);

        // Also, check if notifications are sent
        // This assumes the sendNotifications method was called; we need to set up expectations for this
        $this->assertNotNull($message->id);
    }

    public function test_send_notifications()
    {
        // Arrange: Prepare test data
        $category = Category::factory()->create();
        $user = User::factory()->create();
        $user->categories()->attach($category->id);
        $channel = Channel::factory()->create(['code' => 'email']);
        $user->channels()->attach($channel->id);

        $message = Message::factory()->create(['category_id' => $category->id]);

        // Mock the notification service to expect send method to be called
        $this->notificationServiceMock->shouldReceive('send')
            ->once()
            ->with('email', Mockery::type(User::class), Mockery::type(Message::class))
            ->andReturn(true);

        // Act: Call sendNotifications
        $this->messagesService->sendNotifications($message);

        // Assert: Check that a MessageLog was created for the user
        $this->assertDatabaseHas('messages_logs', [
            'message_id' => $message->id,
            'user_id' => $user->id,
            'category_id' => $category->id,
            'channel_id' => $channel->id,
            'status' => 'sent', // Assuming the mock returns true
        ]);
    }

    public function test_notify_user()
    {
        // Arrange: Create test data
        $category = Category::factory()->create();
        $user = User::factory()->create();
        $user->categories()->attach($category->id);
        $channel = Channel::factory()->create(['code' => 'email']);
        $user->channels()->attach($channel->id);

        $message = Message::factory()->create(['category_id' => $category->id]);

        // Mock the notification service to return false for 'failed'
        $this->notificationServiceMock->shouldReceive('send')
            ->once()
            ->with('email', Mockery::type(User::class), Mockery::type(Message::class))
            ->andReturn(false);

        // Act: Manually call notifyUser to check if it logs correctly
        $reflection = new \ReflectionClass(MessagesService::class);
        $method = $reflection->getMethod('notifyUser');
        $method->setAccessible(true);
        $method->invoke($this->messagesService, 'email', $user, $message);

        // Assert: Check that a MessageLog with 'failed' status was created
        $this->assertDatabaseHas('messages_logs', [
            'message_id' => $message->id,
            'user_id' => $user->id,
            'category_id' => $category->id,
            'channel_id' => $channel->id,
            'status' => 'failed',
        ]);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
