<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Skilltree;

class SkilltreesController extends Controller
{
    public function index()
    {
        $skilltrees = Skilltree::all();
        return view('skilltrees.index', compact('skilltrees'));
    }

    public function store()
    {
/*        request()->validate([
            'title' => 'required',
            'description' => 'required'
        ]);

        Skilltree::create(request(['title', 'description'])); */
        Skilltree::create($this->validateRequest());

        return redirect('/skilltrees');
    }

    public function show(Skilltree $skilltree)
    {
        return view('skilltrees.show', compact('skilltree'));

    }

    protected function validateRequest()
    {
        return request()->validate([
            'title' => 'required',
            'description' => 'required'
        ]);
    }
}
