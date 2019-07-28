<?php

namespace App\Http\Controllers;

use App\User;
use App\Skilltree;
use Illuminate\Http\Request;
use App\Http\Requests\SkilltreeInvitationRequest;
use App\Progress;

class SkilltreeInvitationsController extends Controller
{
    public function store(Skilltree $skilltree, SkilltreeInvitationRequest $request)
    {
        $this->authorize('manage', $skilltree);

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
        $this->authorize('update', $skilltree);

        $emails = explode(",", request('emails'));

        foreach ($emails as $email) {
            $user = User::whereEmail($email)->first();

            if (!$user) {
                $user = User::create(['email' => $email]);
            }

            $skilltree->invite($user);

            foreach ($skilltree->skills as $skill) {
                foreach ($skill->tasks as $task) {
                    Progress::create([
                        'owner_id' => $user->id,
                        'task_id' => $task->id
                    ]);
                }
            }
        }

        if (request()->wantsJson()) {
            return ['message' => $emails];
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
