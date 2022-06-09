<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TodoTask extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'task_id', 'todo', 'status',
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
