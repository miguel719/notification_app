<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = ['content', 'category_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function messageLogs()
    {
        return $this->hasMany(MessageLog::class);
    }
}