<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Skilltree;
use App\Skill;

class SkilltreeSkillsController extends Controller
{

    public function store(Skilltree $skilltree)
    {
        $this->authorize('update', $skilltree);
        $request = request()->validate(['skill_title' => 'required|min:3']);
        $skilltree->addSkill(request('skill_title'));

        if (request()->wantsJson()) {
            return ['message' => $skilltree->path()];
        }

        return redirect($skilltree->path());
    }

    public function update(Skilltree $skilltree, Skill $skill)
    {
        $this->authorize('update', $skill->skilltree);

        $skill->update(request()->validate(['skill_title' => 'required|min:3']));

        return redirect($skilltree->path());
    }
}
