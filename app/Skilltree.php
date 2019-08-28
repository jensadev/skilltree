<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Skill;
use App\Activity;
use Appstract\Meta\Metable;

class Skilltree extends Model
{
    //    use RecordsActivity;
    use Metable;

    protected $guarded = [];

    //    protected $with = ['owner'];

    //protected static $recordableEvents = ['invite', 'deleted', 'updated'];

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
     * @param array $skill
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

    public function uninvite(User $user)
    {
        return $this->members()->detach($user);
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'skilltree_members')->withTimestamps()->orderBy('email');
    }

    // public function students()
    // {
    //     return $this->belongsToMany(User::class, 'skilltree_students')->withTimestamps();
    // }

    public function showPositions()
    {
        if ($poscon = $this->getMeta('poscon')) {
            return $poscon;
        }
        return "No positions found";
    }

    public function storePositions($data)
    {
        return $this->addOrUpdateMeta('poscon', $data);
    }

    // public function storeClassroomid($classroomid)
    // {
    //     return $this->addOrUpdateMeta('classroomid', $classroomid);
    // }
}
