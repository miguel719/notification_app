<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\NotificationService;
use App\Services\Channels\SmsService;
use App\Services\Channels\EmailService;
use App\Services\Channels\PushNotificationService;
use Mockery;
use InvalidArgumentException;

class NotificationServiceTest extends TestCase
{
    protected $notificationService;
    protected $smsServiceMock;
    protected $emailServiceMock;
    protected $pushNotificationServiceMock;

    protected function setUp(): void
    {
        parent::setUp();

        // Create mocks for each channel service
        $this->smsServiceMock = Mockery::mock(SmsService::class);
        $this->emailServiceMock = Mockery::mock(EmailService::class);
        $this->pushNotificationServiceMock = Mockery::mock(PushNotificationService::class);

        // Instantiate the NotificationService with the mocked dependencies
        $this->notificationService = new NotificationService(
            $this->smsServiceMock,
            $this->emailServiceMock,
            $this->pushNotificationServiceMock
        );
    }

    public function test_send_sms_notification()
    {
        // Arrange: Set up expectations for the smsService mock
        $this->smsServiceMock->shouldReceive('send')
            ->once()
            ->with(Mockery::type('User'), Mockery::type('Message'))
            ->andReturn(true);

        $user = Mockery::mock('User');
        $message = Mockery::mock('Message');

        // Act: Call the send method with 'sms' channel
        $result = $this->notificationService->send('sms', $user, $message);

        // Assert: Ensure the result is true as mocked
        $this->assertTrue($result);
    }

    public function test_send_email_notification()
    {
        // Arrange: Set up expectations for the emailService mock
        $this->emailServiceMock->shouldReceive('send')
            ->once()
            ->with(Mockery::type('User'), Mockery::type('Message'))
            ->andReturn(true);

        $user = Mockery::mock('User');
        $message = Mockery::mock('Message');

        // Act: Call the send method with 'email' channel
        $result = $this->notificationService->send('email', $user, $message);

        // Assert: Ensure the result is true as mocked
        $this->assertTrue($result);
    }

    public function test_send_push_notification()
    {
        // Arrange: Set up expectations for the pushNotificationService mock
        $this->pushNotificationServiceMock->shouldReceive('send')
            ->once()
            ->with(Mockery::type('User'), Mockery::type('Message'))
            ->andReturn(true);

        $user = Mockery::mock('User');
        $message = Mockery::mock('Message');

        // Act: Call the send method with 'push_notification' channel
        $result = $this->notificationService->send('push_notification', $user, $message);

        // Assert: Ensure the result is true as mocked
        $this->assertTrue($result);
    }

    public function test_send_with_invalid_channel()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Notification channel [invalid_channel] is not supported.');

        $user = Mockery::mock('User');
        $message = Mockery::mock('Message');

        // Act: Call the send method with an invalid channel
        $this->notificationService->send('invalid_channel', $user, $message);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
