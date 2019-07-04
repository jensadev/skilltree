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

        Route::get('/skilltrees/{skilltree}/pos', 'SkilltreePositionsController@show');
        Route::post('/skilltrees/{skilltree}/pos', 'SkilltreePositionsController@store');

        Route::get('/skilltrees/{skilltree}/classroom', 'SkilltreeClassroomsController@show');
        Route::post('/skilltrees/{skilltree}/classroom', 'SkilltreeClassroomsController@store');

        Route::post('/skilltrees/{skilltree}/skills', 'SkilltreeSkillsController@store');
        Route::post('/skilltrees/{skilltree}/skills/{skill}/tasks', 'SkillTasksController@store');
        Route::patch('/skilltrees/{skilltree}/skills/{skill}', 'SkilltreeSkillsController@update');
        Route::delete('/skilltrees/{skilltree}/skills/{skill}', 'SkilltreeSkillsController@destroy');
        Route::post('skilltrees/{skilltree}/invitations', 'SkilltreeInvitationsController@store');

        Route::post('skilltrees/{skilltree}/classroom/course', 'SkilltreeClassroomsController@connect');
        Route::post('skilltrees/{skilltree}/classroom/topics', 'SkilltreeClassroomsController@topics');

        //classroom test routes
        Route::get('/classroom/courses', 'ClassroomController@getCourses');
        Route::get('/classroom/topics/{courseid}', 'ClassroomController@getTopics');
    }
);



Auth::routes(['register' => false]);

Route::get('redirect/{driver}', 'Auth\LoginController@redirectToProvider')
    ->name('login.provider')
    ->where('driver', implode('|', config('auth.socialite.drivers')));

Route::get('{driver}/callback', 'Auth\LoginController@handleProviderCallback')
    ->name('login.callback')
    ->where('driver', implode('|', config('auth.socialite.drivers')));

Route::get('/home', 'HomeController@index')->name('home');
