<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected $fillable = [
        'event_id', 'user_id', 'name', 'start_time', 'end_time', 'link',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
