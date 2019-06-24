<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Skill;
use App\Task;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function it_belongs_to_a_skill()
    {
        $task = factory(Task::class)->create();
        $this->assertInstanceOf(Skill::class, $task->skill);
    }

    /** @test */
    function it_has_a_path()
    {
        //        $this->withoutExceptionHandling();
        $task = factory(Task::class)->create();
        $this->assertEquals('/skilltrees/' . $task->skill->skilltree->id . '/skills/' . $task->skill->id . '/tasks/' . $task->id, $task->path());
    }
}
