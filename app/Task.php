<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Appstract\Meta\Metable;
use App\User;

class Task extends Model
{
    use Metable;
    /**
     * The guarded attributes for form submission
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Define relation with skill
     *
     * @return eloquent model
     */
    public function skill()
    {
        return $this->belongsTo(Skill::class);
    }

    public function progress()
    {
        return $this->hasMany(Progress::class, 'task_id');
        //return $this->morphMany('App\Progress', 'progress');
    }

    public function userProgress()
    {
        return $this->hasMany(Progress::class, 'task_id')
            ->where('owner_id', auth()->user()->id);
        //return $this->morphMany('App\Progress', 'progress');
    }

    /**
     * Handle for task path
     *
     * @return task path url
     */
    public function path()
    {
        return "/skilltrees/{$this->skill->skilltree->id}/skills/{$this->skill->id}/tasks/{$this->id}";
    }
}
