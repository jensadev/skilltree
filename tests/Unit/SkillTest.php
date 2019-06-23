<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Skill;
use App\Skilltree;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SkillTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function it_belongs_to_a_skilltree()
    {
        $skill = factory(Skill::class)->create();
        $this->assertInstanceOf(Skilltree::class, $skill->skilltree);
    }

    /** @test */
    function it_has_a_path()
    {
        $skill = factory(Skill::class)->create();
        $this->assertEquals('/skilltrees/' . $skill->skilltree->id . '/skills/' . $skill->id, $skill->path());
    }

    /** @test **/
    /*    function it_can_add_a_subskill()
    {
        $this->withoutExceptionhandling();
        $skilltree = factory('App\Skilltree')->create();
        $skill = $skilltree->addSkill('Test skill');
        $skill->addSubskill("Test");

        $this->assertCount(1, $skill->getAllMeta());
        //$this->assertTrue($skill->getMeta("subSkill")->contains($subskill));
    }*/
}
