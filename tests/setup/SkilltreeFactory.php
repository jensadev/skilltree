<?php

namespace Tests\Setup;

use App\Skilltree;
use App\User;
use App\Skill;

class SkilltreeFactory
{
    protected $skillsCount = 0;
    protected $user;

    public function withSkills($count)
    {
        $this->skillsCount = $count;

        return $this;
    }

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

        factory(Skill::class, $this->skillsCount)->create([
            'skilltree_id' => $skilltree->id
        ]);

        return $skilltree;
    }
}
