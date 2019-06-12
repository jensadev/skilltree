<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Collection;
use Facades\Tests\Setup\ProjectFactory;
use App\User;

class UserTest extends TestCase
{
    use RefreshDatabase;
    /** @test **/
     function a_user_has_skilltrees()
    {
        $user = factory('App\User')->create();
        $this->assertInstanceOf(Collection::class, $user->skilltrees);
    }
}
