<?php

namespace App\Http\Controllers;

use App\Task;
use App\Skill;
use App\Skilltree;
use Illuminate\Http\Request;

class SkillTasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Skilltree $skilltree, Skill $skill)
    {
        $this->authorize('update', $skilltree);
        request()->validate(['body' => 'required|min:3']);
        $skill->addTask(request('body'));

        if (request()->wantsJson()) {
            return ['message' => $skill->skilltree->path()];
        }
        return redirect($skill->skilltree->path());
    }

    public function storeTasks(Skilltree $skilltree, Skill $skill)
    {
        $this->authorize('update', $skilltree);

        foreach (request('tasks') as $value) {
            $skill->addTask($value[1]);
            $skill->addOrUpdateMeta('taskId', (int) $value[0]);
        }

        if (request()->wantsJson()) {
            return ['message' => $skill->skilltree->path()];
        }
        return redirect($skill->skilltree->path());
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        //
    }
}
