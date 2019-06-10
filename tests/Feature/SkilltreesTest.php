<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SkilltreesTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    function a_user_can_create_a_skilltree()
    {
        $this->withoutExceptionHandling();
        $attributes = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph
        ];
        $this->post('/skilltrees', $attributes)->assertRedirect('/skilltrees');

        $this->assertDatabaseHas('skilltrees', $attributes);

        $this->get('/skilltrees')->assertSee($attributes['title']);
    }
}
