<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Skilltree;
use App\Skill;
use App\Task;
use Appstract\Meta\Metable;

class SkilltreeSkillsController extends Controller
{
    use Metable;

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

        $skill->update($this->validateRequest());

        if (request()->wantsJson()) {
            return ['message' => $skilltree->path()];
        }

        return redirect($skilltree->path());
    }

    public function destroy(Skilltree $skilltree, Skill $skill)
    {
        $this->authorize('update', $skill->skilltree);

        $skill->deleteAllMeta();

        $skill->delete();

        if (request()->wantsJson()) {
            return ['message' => $skilltree->path()];
        }

        return redirect($skilltree->path());
    }

    protected function validateRequest()
    {
        return request()->validate([
            'name' => 'required|min:3|string',
            'description' => 'nullable|min:3',
            'icon' => 'nullable|string|max:30',
            'course_id' => 'nullable|numeric',
            'topic_id' => 'nullable|numeric'
        ]);
    }
}
