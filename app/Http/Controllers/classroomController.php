<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Google_Client;
use Google_Service_Classroom;
use Illuminate\Http\Request;

class ClassroomController extends Controller
{
    protected $service;
    protected $client;
    protected $optParams;

    public function __construct()
    {
        $this->optParams = [
            'courseStates' => 'ACTIVE',
            'teacherId' => `"me" `
        ];
    }

    public function getCourses()
    {
        $user = Auth::user();
        $this->client = new Google_Client();
        $this->client->setApplicationName('Skilltree');
        $this->client->setAuthConfig('../credentials.json');
        $this->client->setAccessType('offline');
        $this->client->setPrompt('select_account consent');
        $this->client->setAccessToken($user->g_token);

        $this->service = new Google_Service_Classroom($this->client);

        $coursesResult = $this->service->courses->listCourses($this->optParams);
        $dump = [];
        foreach ($coursesResult->getCourses() as $course) {
            array_push($dump, $course);
        }

        if (request()->wantsJson()) {
            return ['message' => $dump];
        }

        return $dump;
    }

    public function getTopics()
    {
        $user = Auth::user();
        $this->client = new Google_Client();
        $this->client->setApplicationName('Skilltree');
        $this->client->setAuthConfig('../credentials.json');
        $this->client->setAccessType('offline');
        $this->client->setPrompt('select_account consent');
        $this->client->setAccessToken($user->g_token);

        $this->service = new Google_Service_Classroom($this->client);

        $coursesResult = $this->service->courses->listCourses($this->optParams);
        $topicsResult = $this->service->courses_topics;

        $dump = [];
        foreach ($coursesResult->getCourses() as $course) {
            $id = $course->getId();
            array_push($dump, $topicsResult->listCoursesTopics($id));
        }
        return $dump;
    }
}
