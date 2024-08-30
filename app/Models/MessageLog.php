<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageLog extends Model
{
    use HasFactory;
    protected $table = 'messages_logs';
    protected $fillable = ['message_id', 'user_id', 'category_id', 'channel_id', 'status'];

    public function message()
    {
        return $this->belongsTo(Message::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }
}
