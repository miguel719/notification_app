<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateMessageRequest;
use App\Http\Requests\ListMessageLogsRequest;
use App\Services\MessagesService;
use App\Services\MessagesLogsService;

class MessagesController extends Controller
{
    protected $messagesService;
    protected $messagesLogsService;

    public function __construct(MessagesService $messagesService, MessagesLogsService $messagesLogsService)
    {
        $this->messagesService = $messagesService;
        $this->messagesLogsService = $messagesLogsService;
    }

    public function createMessage(CreateMessageRequest $request)
    {
        // Use validated data from the request
        $messageData = $request->data();

        // Use service to create a message and send notifications
        $message = $this->messagesService->createMessage($messageData);

        return response()->json(['success' => true, 'message' => 'Message created and notifications sent.']);
    }

    public function listMessageLogs(ListMessageLogsRequest $request)
    {
        // Use validated data from the request
        $logsData = $request->data();

        // Fetch logs using data for filters
        $logs = $this->messagesLogsService->getMessagesLogs($logsData);

        return response()->json($logs);
    }
}
