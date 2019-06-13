<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Skilltree;

class SkilltreeSkillsController extends Controller
{
    public function store(Skilltree $skilltree)
    {
        $this->authorize('update', $skilltree);
        request()->validate(['title' => 'required|min:3']);
        $skilltree->addSkill(request('title'));
        return redirect($skilltree->path());
    }
}
