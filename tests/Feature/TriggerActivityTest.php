<?php

namespace Tests\Feature;

use Tests\TestCase;
use Facades\Tests\Setup\SkilltreeFactory;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TriggerActivityTest extends TestCase
{
    use RefreshDatabase;

    /** @test **/
    function creating_a_skilltree()
    {
        $this->withoutExceptionhandling();

        $skilltree = SkilltreeFactory::create();

        $this->assertCount(1, $skilltree->activity);

        tap($skilltree->activity->last(), function ($activity) {
            $this->assertEquals('created_skilltree', $activity->description);
            $this->assertNull($activity->changes);
        });
    }

    /** @test **/
    function updating_a_skilltree()
    {
        $skilltree = SkilltreeFactory::create();
        $originalTitle = $skilltree->title;

        $skilltree->update(['title' => 'Changed']);

        $this->assertCount(2, $skilltree->activity);

        tap($skilltree->activity->last(), function ($activity) use ($originalTitle) {
            $this->assertEquals('updated_skilltree', $activity->description);

            $expected = [
                'before' => ['title' => $originalTitle],
                'after' => ['title' => 'Changed']
            ];

            $this->assertEquals($expected, $activity->changes);
        });
    }

    /** @test **/
    function creating_a_new_skill()
    {
        $skilltree = SkilltreeFactory::create();
        $skilltree->addSkill('Some skill');
        $this->assertCount(2, $skilltree->activity);
        tap($skilltree->activity->last(), function($activity) {
            $this->assertEquals('created_skill', $activity->description);
            $this->assertInstanceOf(Skill::class, $activity->subject);
            $this->assertEquals('Some skill', $activity->subject->body);
        });
    }

    /** @test **/
    function deleting_a_skill()
    {
        $skilltree = SkilltreeFactory::withSkills(1)->create() ;

        $skilltree->skills[0]->delete();

        $this->assertCount(3, $skilltree->activity);
    }
}
