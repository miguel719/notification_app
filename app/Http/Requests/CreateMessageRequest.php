<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateMessageRequest extends FormRequest
{
    public function authorize()
    {
        return true; // No auth
    }

    public function rules()
    {
        return [
            'message' => 'required|string',
            'category_id' => 'required|exists:categories,id',
        ];
    }

    public function messages()
    {
        return [
            'message.required' => 'The message field is required.',
            'category_id.required' => 'The category field is required.',
            'category_id.exists' => 'The selected category is invalid.',
        ];
    }

    public function data(): array
    {
        return [
            'message' => $this->input('message'),
            'category_id' => $this->input('category_id'),
        ];
    }
}
