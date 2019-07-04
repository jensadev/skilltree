<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Skilltree;
use Appstract\Meta\Metable;
use function GuzzleHttp\json_decode;

class SkilltreeClassroomsController extends Controller
{
    use Metable;
    //
    public function connect(Skilltree $skilltree)
    {
        if ($crid = request('courseId')) {
            $skilltree->addOrUpdateMeta('courseId', (int) $crid);
        }

        if (request()->wantsJson()) {
            return ['message' => $crid];
        }
    }

    public function topics(Skilltree $skilltree)
    {

        //return request('topics');

        foreach (request('topics') as $value) {
            $skill = $skilltree->addSkill(['skill_title' => $value[1]]);
            $skill->addOrUpdateMeta('topicId', (int) $value[0]);
        }

        /*        if ($topics = request('topics')) {
            $skilltree->addSkills($topics);
        }
        */
        if (request()->wantsJson()) {
            return ['message' => $skilltree->path()];
        }
        return $skilltree->path();
    }
}
