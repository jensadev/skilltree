<?php

namespace App\Policies;

use App\User;
use App\Skilltree;
use Illuminate\Auth\Access\HandlesAuthorization;

class SkilltreePolicy
{
    use HandlesAuthorization;

    public function read(User $user, Skilltree $skilltree)
    {
        return $skilltree->students->contains($user);
    }

    public function update(User $user, Skilltree $skilltree)
    {
        return $user->is($skilltree->owner) || $skilltree->members->contains($user);
    }

    public function manage(User $user, Skilltree $skilltree)
    {
        return $user->is($skilltree->owner);
    }
}
