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
        return $user->progress;
    }

    public function store(User $user, Task $task)
    {
        $progress = Progress::create([
            'owner_id' => $user->id,
            'task_id' => $task->id
        ]);

        return $progress;
    }

    public function update(User $user, Progress $progress)
    {
        request('completed') ?  $progress->complete() : $progress->incomplete();

        return response('', 200);
    }
}
