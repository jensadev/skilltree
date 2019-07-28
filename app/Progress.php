<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Task;

class Progress extends Model
{
    protected $guarded = [];

    public function progressable()
    {
        return $this->morphTo();
    }

    public function owner()
    {
        // $this->morphedByMany('App\User', 'progress');
        return $this->belongsTo('App\User');
    }

    public function task()
    {
        return $this->belongsTo('App\Task');
    }

    public function complete()
    {
        $this->update(['completed' => true]);
        //$this->where('owner_id', $user->id)->where('task_id', $task->id)->update(['completed' => true]);
    }

    public function incomplete()
    {
        $this->update(['completed' => false]);
        //$this->where('owner_id', $user->id)->where('task_id', $task->id)->update(['completed' => false]);
    }
}
