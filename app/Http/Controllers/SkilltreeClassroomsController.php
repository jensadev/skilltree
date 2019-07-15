<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Skilltree;
use Appstract\Meta\Metable;
use function GuzzleHttp\json_decode;

class SkilltreeClassroomsController extends Controller
{
    use Metable;

    public function connect(Skilltree $skilltree)
    {
        if ($courseId = request('course_id')) {
            //$skilltree->addOrUpdateMeta('courseId', (int) $crid);
            $skilltree->update(['course_id', $courseId]);
        }

        if (request()->wantsJson()) {
            return ['message' => $courseId];
        }
    }

    public function disconnect(Skilltree $skilltree)
    {
        $skilltree->update(['course_id', null]);

        if (request()->wantsJson()) {
            return ['message' => "removed"];
        }
    }

    public function showTopics(Skilltree $skilltree)
    {

        foreach (request('topics') as $value) {
            $skilltree->addSkill(['skill_title' => $value[2], 'course_id' => $value[0], 'topic_id' => $value[1]]);
            // $skill->addOrUpdateMeta('courseId', (int) $value[0]);
            // $skill->addOrUpdateMeta('topicId', (int) $value[1]);
        }

        if (request()->wantsJson()) {
            return ['message' => $skilltree->path()];
        }
        return $skilltree->path();
    }
}
