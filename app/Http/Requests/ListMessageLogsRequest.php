<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ListMessageLogsRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Allow all users to make this request, adjust if needed
    }

    public function rules()
    {
        return [
            'category' => 'nullable|exists:categories,id',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'message' => 'nullable|string',
            'status' => 'nullable|in:queued,sent,failed',
            'channel' => 'nullable|exists:channels,name',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
        ];
    }

    public function data(): array
    {
        return [
            'category' => $this->input('category'),
            'email' => $this->input('email'),
            'phone' => $this->input('phone'),
            'message' => $this->input('message'),
            'status' => $this->input('status'),
            'channel' => $this->input('channel'),
            'start_date' => $this->input('start_date'),
            'end_date' => $this->input('end_date'),
        ];
    }
}

