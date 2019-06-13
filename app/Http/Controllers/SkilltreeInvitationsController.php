<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class SkilltreeInvitationsController extends Controller
{
    public function store(Skilltree $skilltree, SkilltreeInvitationRequest $request)
    {
        $user = User::whereEmail(request('email'))->first();

        $skilltree->invite($user);

        return redirect($skilltree->path());
    }
}
