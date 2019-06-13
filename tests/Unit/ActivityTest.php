<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Facades\Tests\Setup\SkilltreeFactory;

class ActivityTest extends TestCase
{
    use RefreshDatabase;

    /** @test **/
    function it_has_a_user()
    {
        $user = $this->signIn();

        $skilltree = SkilltreeFactory::ownedBy($user)->create();

        $this->assertEquals($user->id, $skilltree->activity->first()->user->id);
    }
}
