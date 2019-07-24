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
        $this->authorize('update', $skilltree);

        $user = User::whereEmail(request('email'))->first();

        if (!$user) {
            $user = User::create(['email' => request('email')]);
        }

        $skilltree->invite($user);

        if (request()->wantsJson()) {
            return ['message' => $skilltree->path()];
        }

        return redirect($skilltree->path());
    }

    public function classStore(Skilltree $skilltree)
    {
        $this->authorize('manage', $skilltree);

        $emails = explode(",", request('studentEmails'));

        if (request()->wantsJson()) {
            return ['message' => $emails];
        }

        foreach ($emails as $email) {
            $user = User::whereEmail($email)->first();

            if (!$user) {
                $user = User::create(['email' => $email]);
            }

            $skilltree->invite($user);
        }
    }

    public function destroy(Skilltree $skilltree, SkilltreeInvitationRequest $request)
    {
        $this->authorize('manage', $skilltree);

        $user = User::whereEmail(request('email'))->first();

        $skilltree->uninvite($user);

        if (request()->wantsJson()) {
            return ['message' => "User detached"];
        }
    }
}
