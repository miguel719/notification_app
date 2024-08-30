<?php

namespace App\Services\Channels;

use App\Interfaces\NotificationInterface;

class EmailService
{
    public function send($user, $message): bool
    {
        return (bool) random_int(0, 1);
    }
}
