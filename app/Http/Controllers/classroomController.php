<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Socialite;
use Google_Client;
use Google_Service_Classroom;
use Google_Service_Drive;
use Illuminate\Http\Request;

class classroomController extends Controller
{
    public function test()
    {
        $user = Auth::user();
        $client = new Google_Client();
        $client->setApplicationName('Skilltree');
        //$client->setScopes(Google_Service_Classroom::CLASSROOM_COURSES);
        //$client->addScope(['https://www.googleapis.com/auth/classroom.courses']);
        $client->setAuthConfig('../credentials.json');
        $client->setAccessType('offline');
        $client->setPrompt('select_account consent');
        $client->setAccessToken($user->g_token);

        $service = new Google_Service_Classroom($client);
        //dd($service->courses->listCourses());
        $optParams = [
            'courseStates' => 'ACTIVE',
            'teacherId' => `"me"`
        ];
        $results = $service->courses->listCourses();

        $courses = [];
        //return $results->getCourses();
        foreach ($results->getCourses() as $course) {
            //var_dump(json_encode($course));
            //            $id = $course->getId();
            //            echo $course->listCoursestopics($id);
            array_push($courses, $course);
        }
        return $courses;
        //dd($results->getCourses());
    }
}
