<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Collection;
use Facades\Tests\Setup\SkilltreeFactory;
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

    /** @test **/
    function a_teacher_has_accessible_skilltrees()
    {
        $this->withoutExceptionHandling();

        $john = $this->signInTeacher();

        $this->assertEquals($john['email'], 'teacher@ga.ntig.se');

        SkilltreeFactory::ownedBy($john)->create();

        $this->assertCount(1, $john->accessibleSkilltrees());

        $sally = factory(User::class)->create(['email' => 'sally@ga.ntig.se', 'teacher' => true]);
        $nick = factory(User::class)->create(['email' => 'nick@ga.ntig.se', 'teacher' => true]);

        $skilltree = tap(SkilltreeFactory::ownedBy($sally)->create())->invite($nick);

        $this->assertCount(1, $john->accessibleSkilltrees());

        $skilltree->invite($john);

        $this->assertCount(2, $john->accessibleSkilltrees());
    }

    /** @test */
    function teacher_status_is_decided_by_email_at_creation()
    {
        //$this->withoutExceptionHandling();
        $user = factory('App\User')->create();
        $pos = strpos($user['email'], 'elev');
        $this->assertEquals($user['teacher'], $pos === false  ? true : false);
    }
}
