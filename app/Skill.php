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
        return $this->hasMany(Task::class);
    }

    /**
     * Add a task to the skill.
     * 
     * @param string $body
     */
    public function addTask($body)
    {
        return $this->tasks()->updateOrCreate(compact('body'));
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
