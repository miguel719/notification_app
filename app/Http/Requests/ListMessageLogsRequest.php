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
            'category' => 'nullable|string', // Change to string for partial match search
            'email' => 'nullable|string',
            'phone' => 'nullable|string', // No length or format restriction to allow partial match
            'message' => 'nullable|string',
            'status' => 'nullable|in:queued,sent,failed', // Validate specific statuses
            'channel' => 'nullable|string', // Change to string to allow partial match
            'start_date' => 'nullable|date', // Ensure it's a valid date
            'end_date' => 'nullable|date|after_or_equal:start_date', // Ensure end date is after start date
            'page' => 'nullable|integer|min:1', // Pagination: must be an integer, at least 1
            'limit' => 'nullable|integer|min:1|max:100', // Limit: must be between 1 and 100
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
            'page' => $this->input('page', 1), // Default to 1 if not provided
            'limit' => $this->input('limit', 10), // Default to 10 if not provided
        ];
    }
}
