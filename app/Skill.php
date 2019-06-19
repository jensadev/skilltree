<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Skilltree;
use Appstract\Meta\Metable;

class Skill extends Model
{
    use RecordsActivity, Metable;


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
    protected static $recordableEvents = ['created', 'deleted'];

    /**
     * Define relation with skilltree
     *
     * @return eloquent model
     */
    public function skilltree()
    {
        return $this->belongsTo(Skilltree::class);
    }

    /**
     * Handle for skill path
     *
     * @return skill path url
     */
    public function path()
    {
        return "/skilltrees/{$this->skilltree->id}/skills/{$this->id}";
    }
}
