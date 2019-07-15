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

    /** @test **/
    public function guests_cannot_add_skills_to_skilltrees()
    {
        $skilltree = factory('App\Skilltree')->create();
        $this->post($skilltree->path() . '/skills')->assertRedirect('login');
    }

    /** @test */
    function a_skilltree_can_have_skills()
    {
        $this->withoutExceptionHandling();
        $skilltree = SkilltreeFactory::create();

        $this->actingAs($skilltree->owner)
            ->post($skilltree->path() . '/skills', ['name' => 'Test skill']);

        $this->get($skilltree->path())
            ->assertSee('Test skill');
    }

    /** @test */
    function a_skill_can_be_updated()
    {
        $skilltree = SkilltreeFactory::withSkills(1)->create();

        $this->actingAs($skilltree->owner)
            ->patch($skilltree->skills[0]->path(), [
                'name' => 'changed'
            ]);

        $this->assertDatabaseHas('skills', [
            'name' => 'changed'
        ]);
    }

    /** @test */
    function a_user_can_delete_a_skill()
    {
        $this->withoutExceptionHandling();
        $this->signIn();
        $skilltree = factory('App\Skilltree')->create();
        $skill = $skilltree->addSkill(["name" => "delete me"]);

        $this->actingAs($skilltree->owner)
            ->delete($skill->path())
            ->assertRedirect($skilltree->path());

        $this->assertDatabaseMissing('skills', $skill->only('id'));
    }

    /** @test **/
    function only_the_owner_of_a_skilltree_may_add_skills()
    {
        $this->signIn();
        $skilltree = factory('App\Skilltree')->create();
        $this->post($skilltree->path() . '/skills', ['name' => 'Test skill'])
            ->assertStatus(403);

        $this->assertDatabaseMissing('skills', ['name' => 'Test skill']);
    }

    /** @test **/
    public function only_the_owner_of_a_skilltree_may_update_a_skill()
    {
        $this->signIn();

        $skilltree = SkilltreeFactory::withSkills(1)->create();

        $this->patch($skilltree->skills[0]->path(), ['name' => 'changed'])
            ->assertStatus(403);

        $this->assertDatabaseMissing('skills', ['name' => 'changed']);
    }

    /** @test **/
    function a_skill_requires_a_title()
    {
        $skilltree = SkilltreeFactory::create();

        $attributes = factory('App\Skill')->raw(['name' => '']);
        $this->actingAs($skilltree->owner)
            ->post($skilltree->path() . '/skills', $attributes)
            ->assertSessionHasErrors('name');
    }

    /** @test **/
    function a_skill_can_have_a_description()
    {
        $skilltree = SkilltreeFactory::create();

        $attributes = factory('App\Skill')->raw(['name' => 'Test', 'description' => 'Some text']);
        $this->actingAs($skilltree->owner)
            ->post($skilltree->path() . '/skills', $attributes);

        $this->assertDatabaseHas('skills', ['description' => 'Some text']);
    }
}
