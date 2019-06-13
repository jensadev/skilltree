<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Skilltree;
use Facades\Tests\Setup\SkilltreeFactory;

class SkilltreeSkillsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function a_skilltree_can_have_skills()
    {
        $skilltree = SkilltreeFactory::create();

        $this->actingAs($skilltree->owner)
            ->post($skilltree->path() . '/skills', ['title' => 'Test skill']);

        $this->get($skilltree->path())
            ->assertSee('Test skill');
    }

    /** @test **/
    function only_the_owner_of_a_skilltree_may_add_skills()
    {
        $this->signIn();
        $skilltree = factory('App\Skilltree')->create();
        $this->post($skilltree->path() . '/skills', ['title' => 'Test skill'])
            ->assertStatus(403);

        $this->assertDatabaseMissing('skills', ['title' => 'Test skill']);
    }

    /** @test **/
    function a_skill_requires_a_title()
    {
        $skilltree = SkilltreeFactory::create();

        $attributes = factory('App\Skill')->raw(['title' => '']);
        $this->actingAs($skilltree->owner)
            ->post($skilltree->path() . '/skills', $attributes)
            ->assertSessionHasErrors('title');
    }
}
