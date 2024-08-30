<?php

namespace App\Services;

use App\Services\Channels\SmsService;
use App\Services\Channels\EmailService;
use App\Services\Channels\PushNotificationService;

class NotificationService
{
    protected $smsService;
    protected $emailService;
    protected $pushNotificationService;

    public function __construct(SmsService $smsService, EmailService $emailService, PushNotificationService $pushNotificationService)
    {
        $this->smsService = $smsService;
        $this->emailService = $emailService;
        $this->pushNotificationService = $pushNotificationService;
    }

    public function send(string $channelCode, $user, $message): bool
    {
        switch ($channelCode) {
            case 'sms':
                return $this->smsService->send($user, $message);
            case 'email':
                return $this->emailService->send($user, $message);
            case 'push_notification':
                return $this->pushNotificationService->send($user, $message);
            default:
                throw new \InvalidArgumentException("Notification channel [{$channelCode}] is not supported.");
        }
    }
}
