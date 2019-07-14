<?php

namespace Tests\Feature;

use Tests\TestCase;
use Facades\Tests\Setup\SkilltreeFactory;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Skill;
use App\User;

class TriggerActivityTest extends TestCase
{
    use RefreshDatabase;

    /** @test **/
    function creating_a_skilltree()
    {
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
        $skilltree->addSkill(['skill_title' => 'Some skill']);
        $this->assertCount(2, $skilltree->activity);
        tap($skilltree->activity->last(), function ($activity) {
            $this->assertEquals('created_skill', $activity->description);
            $this->assertInstanceOf(Skill::class, $activity->subject);
            $this->assertEquals('Some skill', $activity->subject->skill_title);
        });
    }

    /** @test **/
    function updating_a_skill()
    {
        $skilltree = SkilltreeFactory::create();
        $skill = $skilltree->addSkill(['skill_title' => 'Some skill']);
        $skill->update(['skill_title' => 'Updated skill']);
        $this->assertCount(3, $skilltree->activity);

        tap($skilltree->activity->last(), function ($activity) {
            $this->assertEquals('updated_skill', $activity->description);
            $this->assertInstanceOf(Skill::class, $activity->subject);
            $this->assertEquals('Updated skill', $activity->subject->skill_title);
        });
    }

    /** @test **/
    function deleting_a_skill()
    {
        $skilltree = SkilltreeFactory::withSkills(1)->create();

        $skilltree->skills[0]->delete();

        $this->assertCount(3, $skilltree->activity);
    }

    /** @test **/
    // function inviting_a_user_triggers_acitivty()
    // {
    //     $this->withoutExceptionhandling();
    //     $skilltree = SkilltreeFactory::create();

    //     $userToInvite = factory(User::class)->create();

    //     $this->actingAs($skilltree->owner)
    //         ->post($skilltree->path() . '/invitations', [
    //             'email' => $userToInvite->email
    //         ]);
    //     //     ->assertRedirect($skilltree->path());

    //     // $this->assertTrue($skilltree->members->contains($userToInvite));

    //     $this->assertCount(2, $skilltree->activity);

    //     // tap($skilltree->activity->last(), function ($activity) {
    //     //     $this->assertEquals('invited_user', $activity->description);
    //     //     $this->assertInstanceOf(User::class, $activity->subject);
    //     // });
    // }
}
