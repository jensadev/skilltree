<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Skills;

class Skilltree extends Model
{
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

    public function addSkill($name)
    {
        return $this->skills()->create(compact('name'));
    }
}
