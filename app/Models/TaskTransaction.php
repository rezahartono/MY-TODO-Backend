<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskTransaction extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'task_id',
        'sub_task_id',
    ];

    public function user()
    {
        return $this->hashMany(User::class);
    }

    public function task()
    {
        return $this->hashMany(Task::class);
    }

    public function subTask()
    {
        return $this->hashMany(SubTask::class);
    }
}
