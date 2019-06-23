<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Skilltree;

class SkilltreesController extends Controller
{
    public function index()
    {
        $skilltrees = auth()->user()->accessibleSkilltrees();
        return view('skilltrees.index', compact('skilltrees'));
    }

    public function store()
    {
        $skilltree = auth()->user()->skilltrees()->create($this->validateRequest());

        if ($skills = request('skills')) {
            $skilltree->addSkills($skills);
        }
        if (request()->wantsJson()) {
            return ['message' => $skilltree->path()];
        }
        return redirect($skilltree->path());
    }

    public function show(Skilltree $skilltree)
    {
        $this->authorize('update', $skilltree);
        return view('skilltrees.show', compact('skilltree'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('skilltrees.create');
    }

    public function edit(Skilltree $skilltree)
    {
        $this->authorize('update', $skilltree);
        return view('skilltrees.edit', compact('skilltree'));
    }

    public function update(Skilltree $skilltree)
    {
        $this->authorize('update', $skilltree);
        $skilltree->update($this->validateRequest());
        return redirect($skilltree->path());
    }

    public function destroy(Skilltree $skilltree)
    {
        $this->authorize('manage', $skilltree);
        $skilltree->delete();
        return redirect('/skilltrees');
    }

    protected function validateRequest()
    {
        return request()->validate([
            'title' => 'required|min:3',
            'description' => 'required|min:3'
        ]);
    }
}
