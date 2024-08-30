<?php

namespace App\Services;

use App\Models\MessageLog;

class MessagesLogsService
{
    public function getMessagesLogs(array $data)
    {
        $query = MessageLog::with(['message', 'user', 'category', 'channel']);

        if (isset($data['category'])) {
            $query->whereHas('category', function ($q) use ($data) {
                $q->where('name', 'LIKE', '%' . $data['category'] . '%');
            });
        }

        if (isset($data['email'])) {
            $query->whereHas('user', function ($q) use ($data) {
                $q->where('email', 'LIKE', '%' . $data['email'] . '%');
            });
        }

        if (isset($data['phone'])) {
            $query->whereHas('user', function ($q) use ($data) {
                $q->where('phone', 'LIKE', '%' . $data['phone'] . '%');
            });
        }

        if (isset($data['status'])) {
            $query->where('status', $data['status']);
        }

        if (isset($data['channel'])) {
            $query->whereHas('channel', function ($q) use ($data) {
                $q->where('code', $data['channel']);
            });
        }

        $limit = isset($data['limit']) ? $data['limit'] : 10;

        return $query->orderBy('created_at', 'desc')->paginate($limit);
    }
}
