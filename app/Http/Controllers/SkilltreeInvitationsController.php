<?php

namespace App\Http\Controllers;

use App\User;
use App\Skilltree;
use Illuminate\Http\Request;
use App\Http\Requests\SkilltreeInvitationRequest;

class SkilltreeInvitationsController extends Controller
{
    public function store(Skilltree $skilltree, SkilltreeInvitationRequest $request)
    {
        $user = User::whereEmail(request('email'))->first();

        $skilltree->invite($user);

        return redirect($skilltree->path());
    }
}
