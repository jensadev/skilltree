<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Skill;
use App\Activity;
use Appstract\Meta\Metable;

class Skilltree extends Model
{
    //use RecordsActivity;
    use Metable;

    protected $guarded = [];

    public function path()
    {
        return '/skilltrees/' . $this->id;
    }

    public function owner()
    {
        return $this->belongsTo(User::class);
    }

    public function skills()
    {
        return $this->hasMany(Skill::class);
    }

    /**
     * Add a skill to the skilltree.
     * 
     * @param string $skill_title
     */
    public function addSkill($skill)
    {
        return $this->skills()->create($skill);
    }

    /**
     * Add skills to the skilltree.
     * 
     * @param array $skills
     */
    public function addSkills($skills)
    {
        return $this->skills()->createMany($skills);
    }

    public function activity()
    {
        return $this->hasMany(Activity::class)->latest()->take(10);
    }

    public function invite(User $user)
    {
        return $this->members()->attach($user);
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'skilltree_members')->withTimestamps();
    }

    public function showPositions()
    {
        if ($this->hasMeta('positions')) {
            return $this->getMeta('positions');
        }
        return "No positions found";
    }

    public function storePositions($positions)
    {
        if ($this->hasMeta('positions')) {
            return $this->updateMeta('positions', $positions);
        }
        return $this->addMeta('positions', $positions);
    }

    public function storeClassroomid($classroomid)
    {
        if ($this->hasMeta('classroomid')) {
            return $this->updateMeta('classroomid', $classroomid);
        }
        return $this->addMeta('classroomid', $classroomid);
    }
}
