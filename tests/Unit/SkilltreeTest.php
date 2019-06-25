<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;

class SkilltreeTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function it_has_a_path()
    {
        $skilltree = factory('App\Skilltree')->create();
        $this->assertEquals('/skilltrees/' .  $skilltree->id, $skilltree->path());
    }

    /** @test **/
    public function it_belongs_to_an_owner()
    {
        $skilltree = factory('App\Skilltree')->create();
        $this->assertInstanceOf('App\User', $skilltree->owner);
    }

    /** @test **/
    function it_can_add_a_skill()
    {
        $skilltree = factory('App\Skilltree')->create();
        $skill = $skilltree->addSkill(['skill_title' => 'Test skill']);

        $this->assertCount(1, $skilltree->skills);
        $this->assertTrue($skilltree->skills->contains($skill));
    }

    /** @test **/
    function it_can_invite_a_user()
    {
        $skilltree = factory('App\Skilltree')->create();

        $skilltree->invite($user = factory(User::class)->create());

        $this->assertTrue($skilltree->members->contains($user));
    }
}
