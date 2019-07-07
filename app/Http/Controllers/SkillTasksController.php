<?php

namespace App\Http\Controllers;

use App\Task;
use App\Skill;
use App\Skilltree;
use Illuminate\Http\Request;
use Appstract\Meta\Metable;

class SkillTasksController extends Controller
{
    use Metable;

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

        $task = $skill->addTask(request('body'));

        if (request('courseWorkId')) {
            $task->addOrUpdateMeta('courseWorkId', (int) request('courseWorkId'));
            $task->addOrUpdateMeta('courseId', (int) request('courseId'));
        }

        if (request()->wantsJson()) {
            return ['message' => $task];
        }
        return redirect($skill->skilltree->path());
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
    public function destroy(Skilltree $skilltree, Skill $skill, Task $task)
    {
        $this->authorize('update', $skilltree);

        $task->deleteAllMeta();

        $task->delete();

        if (request()->wantsJson()) {
            return ['message' => "deleted"];
        }

        //return redirect($skilltree->path());
    }
}
