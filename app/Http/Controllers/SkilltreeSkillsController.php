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
        /*        $id = $skilltree->addSkill(request('title'))->id;
        $skill = Skill::find($id);
        $skill->addMeta('left', rand(200, 800));
        $skill->addMeta('top', rand(200,800));
        */
        return redirect($skilltree->path());
    }

    public function update(Skilltree $skilltree, Skill $skill)
    {
        $this->authorize('update', $skill->skilltree);

        $skill->update(request()->validate(['skill_title' => 'required|min:3']));

        //request('target') ==  $skill->addMeta('target', request('target'));

        return redirect($skilltree->path());
    }
}
