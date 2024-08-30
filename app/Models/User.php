<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'phone'];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'user_category');
    }

    public function channels()
    {
        return $this->belongsToMany(Channel::class, 'user_channel');
    }

    public function messageLogs()
    {
        return $this->hasMany(MessageLog::class);
    }
}
