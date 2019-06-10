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
        Skilltree::create(request(['title', 'description']));

        return redirect('/skilltrees');
    }
}
