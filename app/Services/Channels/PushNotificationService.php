<?php

namespace App\Services\Channels;

use App\Interfaces\NotificationInterface;

class PushNotificationService
{
    public function send($user, $message): bool
    {
        return (bool) random_int(0, 1);
    }
}
