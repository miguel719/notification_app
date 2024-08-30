<?php
namespace App\Services;

use App\Models\Message;
use App\Models\User;
use App\Models\MessageLog;

class MessagesService
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function createMessage(array $data)
    {
        $message = Message::create([
            'content' => $data['message'],
            'category_id' => $data['category_id']
        ]);

        $this->sendNotifications($message);

        return $message;
    }

    public function sendNotifications($message)
    {
        $users = User::whereHas('categories', function ($query) use ($message) {
            $query->where('categories.id', $message->category_id); // Specify 'categories.id'
        })->with('channels')->get();

        foreach ($users as $user) {
            foreach ($user->channels as $channel) {
                $this->notifyUser($channel->code, $user, $message);
            }
        }
    }

    private function notifyUser($channel, $user, $message)
    {
        $status = $this->notificationService->send($channel, $user, $message) ? 'sent' : 'failed';

        MessageLog::create([
            'message_id' => $message->id,
            'user_id' => $user->id,
            'category_id' => $message->category_id,
            'channel_id' => $user->channels->where('code', $channel)->first()->id,
            'status' => $status,
        ]);
    }
}
