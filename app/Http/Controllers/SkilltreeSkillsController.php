<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Skilltree;
use App\Skill;
use App\Task;

class SkilltreeSkillsController extends Controller
{
    public function store(Skilltree $skilltree)
    {
        $this->authorize('update', $skilltree);
        $skilltree->addSkill($this->validateRequest());

        if (request()->wantsJson()) {
            return ['message' => $skilltree->path()];
        }

        return redirect($skilltree->path());
    }

    public function update(Skilltree $skilltree, Skill $skill, Task $task)
    {
        $this->authorize('update', $skill->skilltree);

        if ($tasks = request('skill_tasks')) {
            $skill->addTasks($tasks);
        }

        $skill->update($this->validateRequest());

        if (request()->wantsJson()) {
            return ['message' => $skilltree->path()];
        }

        return redirect($skilltree->path());
    }

    public function destroy(Skilltree $skilltree, Skill $skill)
    {
        $this->authorize('manage', $skill->skilltree);

        $skill->delete();

        if (request()->wantsJson()) {
            return ['message' => $skilltree->path()];
        }

        return redirect($skilltree->path());
    }

    protected function validateRequest()
    {
        return request()->validate([
            'skill_title' => 'required|min:3',
            'skill_description' => 'sometimes|min:3'
        ]);
    }
}
