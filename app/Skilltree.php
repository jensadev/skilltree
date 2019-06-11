<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Skilltree extends Model
{
    protected $guarded = [];

    public function path()
    {
        return '/skilltrees/' . $this->id;
    }
}
