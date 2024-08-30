<?php

namespace App\Services;

use App\Models\MessageLog;

class MessagesLogsService
{
    public function getMessagesLogs(array $data)
    {
        $query = MessageLog::with(['message', 'user', 'category', 'channel']);

        if (isset($data['category'])) {
            $query->where('category_id', $data['category']);
        }

        if (isset($data['email'])) {
            $query->whereHas('user', function ($q) use ($data) {
                $q->where('email', $data['email']);
            });
        }

        if (isset($data['phone'])) {
            $query->whereHas('user', function ($q) use ($data) {
                $q->where('phone', $data['phone']);
            });
        }

        return $query->orderBy('created_at', 'desc')->get();
    }
}