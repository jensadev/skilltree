<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

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
        $skill = $skilltree->addSkill('Test skill');

        $this->assertCount(1, $skilltree->skills);
        $this->assertTrue($skilltree->skills->contains($skill));
    }
}
