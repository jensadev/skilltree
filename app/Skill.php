<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Appstract\Meta\Metable;
use App\User;
use App\Skills;
use App\Skilltree;

class Skill extends Model
{
    use Metable;

    protected $guarded = [];

    public function skilltree()
    {
        return $this->belongsTo(Skilltree::class);
    }

    public function path()
    {
        return "/skilltrees/{$this->skilltree->id}/skills/{$this->id}";
    }
}


/*
$book = Book::find(1);

$book->addMeta('someKey', 'someValue');

$book->getMeta('someKey');

$book->hasMeta('someKey');

$book->updateMeta('someKey', 'anotherValue');

$book->addOrUpdateMeta('someKey', 'someValue');

$book->deleteMeta('someKey');

$book->getAllMeta();

$book->deleteAllMeta();

*/
