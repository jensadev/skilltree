<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Progress;

class UserProgressTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function a_user_can_create_progresses()
    {
        //$this->signIn();
        $user = factory('App\User')->create();
        $attributes = [
            'owner_id' => $user->id,
            'task_id' => factory('App\Task')->create()->id,
        ];

        Progress::create($attributes);

        $this->assertDatabaseHas('progresses',  $attributes);
    }

    /** @test */
    function a_authorized_user_can_fetch_progresses()
    {
        $this->signIn();
        $user = factory('App\User')->create();
        $task = factory('App\Task')->create();

        $progress = Progress::create(['owner_id' => $user->id, 'task_id' => $task->id]);

        $this->get('/user/' . $user->id . "/progress")
            ->assertStatus(200);
    }

    /** @test */
    function an_authorized_user_can_post_progress()
    {
        $this->signIn();
        //$this->withoutExceptionHandling();
        $user = factory('App\User')->create();
        $task = factory('App\Task')->create();

        $this->post('/user/' . $user->id . '/progress/' . $task->id);

        $this->get('/user/' . $user->id . '/progress')
            ->assertSee($task->id);

        $this->assertDatabaseHas('progresses',  ['completed' => false]);
    }


    /** @test */
    function a_authrorized_user_can_complete_and_incomplete_tasks()
    {
        $this->signIn();
        //$this->withoutExceptionHandling();
        $user = factory('App\User')->create();
        $task = factory('App\Task')->create();

        $progress = Progress::create(['owner_id' => $user->id, 'task_id' => $task->id]);
        //$progress = $this->post('/user/' . $user->id . '/task/' . $task->id . '/progress');
        $this->get('/user/' . $user->id . '/progress')
            ->assertSee($task->id);
        $this->assertDatabaseHas('progresses',  ['completed' => false]);

        // //        $progress->complete();
        $this->patch('/user/' . $progress->owner_id . '/progress/' . $progress->id, ['completed' => true]);
        //     ->assertStatus(200);
        // $this->get('/user/' . $user->id . '/progress')
        //     ->assertSee("completed\":1");

        $this->assertDatabaseHas('progresses',  ['completed' => true]);

        // // //        $progress->incomplete();
        $this->patch('/user/' . $progress->owner_id . '/progress/' . $progress->id, ['completed' => false]);
        //     ->assertStatus(200);
        // $this->get('/user/' . $user->id . '/progress')
        //     ->assertSee("completed\":0");
        $this->assertDatabaseHas('progresses',  ['completed' => false]);
    }
}
