<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Project;

class SkilltreesTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    function a_user_can_create_a_skilltree()
    {
        $attributes = factory('App\Skilltree')->raw();
        $this->post('/skilltrees', $attributes)->assertRedirect('/skilltrees');

        $this->assertDatabaseHas('skilltrees', $attributes);

        $this->get('/skilltrees')->assertSee($attributes['title']);
    }

    /** @test */
    function a_user_can_view_a_skilltree()
    {
        $this->withoutExceptionHandling();
        $project = factory('App\Skilltree')->create();

        $this->get($project->path())
            ->assertSee($project->title)
            ->assertSee($project->description);
    }

    /** @test */
    function a_skilltree_requires_a_title()
    {
        $attributes = factory('App\Skilltree')->raw(['title' => '']);
        $this->post('/skilltrees', $attributes)->assertSessionHasErrors('title');
    }

    /** @test */
    function a_skilltree_requires_a_description()
    {
        $attributes = factory('App\Skilltree')->raw(['description' => '']);
        $this->post('/skilltrees', $attributes)->assertSessionHasErrors('description');
    }
}
