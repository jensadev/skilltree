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
}
