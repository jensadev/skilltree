<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Skill;
use App\Activity;

class Skilltree extends Model
{
    use RecordsActivity;

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

    public function addSkill($title)
    {
        return $this->skills()->create(compact('title'));
    }

    public function addSkills($skills)
    {
        return $this->skills()->createMany($skills);
    }

    public function activity()
    {
        return $this->hasMany(Activity::class)->latest();
    }

    public function invite(User $user)
    {
        return $this->members()->attach($user);
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'skilltree_members')->withTimestamps();
    }
}
