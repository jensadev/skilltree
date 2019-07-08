<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function signIn($user = null)
    {
        $user = $user ?: factory('App\User')->create();

        $this->actingAs($user);
        return $user;
    }

    protected function signInTeacher($user = null)
    {
        $user = $user ?: factory('App\User')->create(['email' => 'teacher@ga.ntig.se', 'teacher' => true]);

        $this->actingAs($user);
        return $user;
    }

    protected function signInStudent($user = null)
    {
        $user = $user ?: factory('App\User')->create(['email' => 'student@elev.ga.ntig.se', 'teacher' => false]);

        $this->actingAs($user);
        return $user;
    }
}
