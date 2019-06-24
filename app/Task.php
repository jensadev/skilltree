<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
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
