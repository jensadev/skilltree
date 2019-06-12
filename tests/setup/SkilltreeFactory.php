<?php

namespace Tests\Setup;
use App\Skilltree;
use App\User;
use App\Skill;

class SkilltreeFactory
{
    protected $user;

    public function ownedBy($user)
    {
        $this->user = $user;

        return $this;
    }

    public function create()
    {
        $skilltree = factory(Skilltree::class)->create([
            'owner_id' => $this->user ?? factory(User::class)
        ]);

        return $skilltree;
    }
}
