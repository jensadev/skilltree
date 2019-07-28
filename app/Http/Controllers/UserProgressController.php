<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Progress;
use App\User;
use App\Task;

class UserProgressController extends Controller
{
    public function index(User $user)
    {
        if (request()->wantsJson()) {
            return ['message' => $user->progress];
        }

        return $user->progress;
    }

    public function store(User $user, Task $task)
    {
        $progress = Progress::create([
            'owner_id' => $user->id,
            'task_id' => $task->id
        ]);

        if (request()->wantsJson()) {
            return ['message' => $progress];
        }

        //return $progress;
    }

    public function update(User $user, Progress $progress)
    {
        request('completed') ?  $progress->complete() : $progress->incomplete();

        if (request()->wantsJson()) {
            return ['message' => $progress->completed];
        }
    }
}
