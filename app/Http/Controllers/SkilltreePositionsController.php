<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Skilltree;

class SkilltreePositionsController extends Controller
{
    public function show(Skilltree $skilltree)
    {
        $this->authorize('update', $skilltree);

        if (request()->wantsJson()) {
            return ['message' => $skilltree->showPositions()];
        }
        return $skilltree->showPositions();
    }

    public function store(Skilltree $skilltree, Request $request)
    {
        $this->authorize('update', $skilltree);
        $skilltree->storePositions($request->positions);
    }
}
