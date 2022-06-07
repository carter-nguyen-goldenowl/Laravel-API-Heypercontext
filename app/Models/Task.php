<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'priority', 'user_id', 'user_name', 'start_date', 'end_date', 'user_tag', 'status', 'hash_tag', 'description',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function todotasks()
    {
        return $this->hasMany(TodoTask::class);
    }

    public function toDoTaskDones()
    {
        return $this->hasMany(TodoTask::class)->where('status', 1);
    }
}
