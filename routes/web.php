<?php

use App\Http\Controllers\SkilltreeClassroomsController;

/**
 * |--------------------------------------------------------------------------
 * | Web Routes
 * |--------------------------------------------------------------------------
 * |
 * | Here is where you can register web routes for your application. These
 * | routes are loaded by the RouteServiceProvider within a group which
 * | contains the "web" middleware group. Now create something great!
 * |
 */

Route::group(
    ['middleware' => 'auth'],
    function () {
        Route::get('/', 'SkilltreesController@index');
        Route::resource('skilltrees', 'SkilltreesController');

        // Progress
        Route::get('/user/{user}/progress', 'UserProgressController@index');
        Route::get('/user/{user}/progress/{progress}', 'UserProgressController@show');
        Route::post('/user/{user}/progress/{task}', 'UserProgressController@store');
        Route::patch('/user/{user}/progress/{progress}', 'UserProgressController@update');

        // invitations
        Route::post('skilltrees/{skilltree}/invitation', 'SkilltreeInvitationsController@store');
        Route::post('skilltrees/{skilltree}/invitations', 'SkilltreeInvitationsController@classStore');
        Route::patch('skilltrees/{skilltree}/invitation/{user}', 'SkilltreeInvitationsController@update');
        Route::delete('skilltrees/{skilltree}/invitation/{user}', 'SkilltreeInvitationsController@destroy');
        Route::post('skilltrees/{skilltree}/classroom/invitations', 'SkilltreeInvitationsController@classroomStore');

        // skills
        Route::post('/skilltrees/{skilltree}/skills', 'SkilltreeSkillsController@store');
        Route::patch('/skilltrees/{skilltree}/skills/{skill}', 'SkilltreeSkillsController@update');
        Route::delete('/skilltrees/{skilltree}/skills/{skill}', 'SkilltreeSkillsController@destroy');

        // skill positions
        Route::get('/skilltrees/{skilltree}/pos', 'SkilltreePositionsController@show');
        Route::post('/skilltrees/{skilltree}/pos', 'SkilltreePositionsController@store');

        // tasks
        Route::post('/skilltrees/{skilltree}/skills/{skill}/tasks', 'SkillTasksController@store');
        Route::patch('/skilltrees/{skilltree}/skills/{skill}/tasks/{task}', 'SkillTasksController@update');
        Route::delete('/skilltrees/{skilltree}/skills/{skill}/tasks/{task}', 'SkillTasksController@destroy');

        // classroom controller routes
        Route::post('skilltrees/{skilltree}/classroom/course', 'SkilltreeClassroomsController@connect');
        Route::delete('skilltrees/{skilltree}/classroom/course', 'SkilltreeClassroomsController@disconnect');
        Route::post('skilltrees/{skilltree}/classroom/topics', 'SkilltreeClassroomsController@showTopics');

        // classroom API routes
        Route::get('/classroom/courses', 'ClassroomController@listCourses');
        Route::get('/classroom/courses/{courseid}/students', 'ClassroomController@listCourseStudents');
        Route::get('/classroom/courses/{courseid}/topics', 'ClassroomController@listTopics');
        Route::get('/classroom/courses/{courseid}/courseworks', 'ClassroomController@listCourseWorks');
        Route::get('/classroom/courses/{courseid}/coursework/{courseworkid}', 'ClassroomController@getCourseWork');
    }
);

Route::get('/help', function () {
    return view('skilltrees.help');
});

Auth::routes(['register' => false]);

Route::get('redirect/{driver}', 'Auth\LoginController@redirectToProvider')
    ->name('login.provider')
    ->where('driver', implode('|', config('auth.socialite.drivers')));

Route::get('{driver}/callback', 'Auth\LoginController@handleProviderCallback')
    ->name('login.callback')
    ->where('driver', implode('|', config('auth.socialite.drivers')));

Route::get('/home', 'HomeController@index')->name('home');
