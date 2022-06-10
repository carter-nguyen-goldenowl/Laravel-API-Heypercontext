<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    use HasFactory;

    protected $fillable = [
        'meeting_id', 'user_id', 'topic', 'start_at', 'duration', 'password', 'start_url', 'join_url',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
