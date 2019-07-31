<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Skilltree;
use Appstract\Meta\Metable;

class Skill extends Model
{
    //use RecordsActivity;
    use Metable;

    protected $with = ['tasks'];

    /**
     * The guarded attributes for form submission
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Class that should be touched
     *
     * @var array
     */
    protected $touches = ['skilltree'];

    /**
     * Events override for RecordsActivity
     *
     * @var array
     */
    protected static $recordableEvents = ['created', 'deleted', 'updated'];

    /**
     * Define relation with skilltree
     *
     * @return eloquent model
     */
    public function skilltree()
    {
        return $this->belongsTo(Skilltree::class);
    }

    public function tasks()
    {
        // tveksamt som fan
        if (!isset(auth()->user()->teacher)) {
            return $this->hasMany(Task::class);
        } elseif (auth()->user()->teacher == true) {
            return $this->hasMany(Task::class);
        } else {
            return $this->hasMany(Task::class)
                ->with('userProgress');
        }
    }

    public function tasksProgress()
    {
        return $this->hasMany(Task::class)
            ->with('userProgress');
        //            ->where('progress.owner_id', auth()->user()->id);
    }

    /**
     * Add a task to the skill.
     * 
     * @param string $body
     */
    public function addTask($task)
    {
        return $this->tasks()->create($task);
    }

    /*
    public function addTasks($tasks)
    {
        return $this->tasks()->updateOrCreate($tasks);
    }
*/
    /**
     * Handle for skill path
     *
     * @return skill path url
     */
    public function path()
    {
        return "/skilltrees/{$this->skilltree->id}/skills/{$this->id}";
    }
    /*
    public function addSubskill($title)
    {
        //return $this->create(compact('title'));
        return $this->addMeta('subSkill', $title);
    }*/
}
