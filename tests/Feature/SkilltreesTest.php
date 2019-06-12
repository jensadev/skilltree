<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Skilltree;
use Facades\Tests\Setup\SkilltreeFactory;

class SkilltreesTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    function a_user_can_create_a_skilltree()
    {
        $this->withoutExceptionHandling();
        $this->signIn();
        $this->get('/skilltrees/create')->assertStatus(200);
        $this->followingRedirects()
            ->post('/skilltrees', $attributes = factory(Skilltree::class)->raw())
            ->assertSee($attributes['title'])
            ->assertSee($attributes['description']);
    }

    /** @test */
    function a_user_can_view_their_skilltree()
    {
        $skilltree = SkilltreeFactory::create();

        $this->actingAs($skilltree->owner)
            ->get($skilltree->path())
            ->assertSee($skilltree->title)
            ->assertSee($skilltree->description);
    }

    /** @test */
    function only_authenticated_users_can_create_skilltrees()
    {
        $attributes = factory('App\Skilltree')->raw();
        $this->post('/skilltrees', $attributes)->assertRedirect('/login');
    }

    /** @test */
    function only_authenticated_users_can_view_skilltrees()
    {
        $this->get('/skilltrees')->assertRedirect('/login');
    }

    /** @test */
    function guests()
    {
        $skilltree = factory('App\Skilltree')->create();
        $this->get($skilltree->path())->assertRedirect('/login');
    }

    /** @test */
    function a_skilltree_requires_a_title()
    {
        $this->signIn();
        $attributes = factory('App\Skilltree')->raw(['title' => '']);
        $this->post('/skilltrees', $attributes)->assertSessionHasErrors('title');
    }

    /** @test */
    function a_skilltree_requires_a_description()
    {
        $this->signIn();
        $attributes = factory('App\Skilltree')->raw(['description' => '']);
        $this->post('/skilltrees', $attributes)->assertSessionHasErrors('description');
    }
}
