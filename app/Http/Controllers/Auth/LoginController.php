<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Socialite;
use App\User;
use Google_Client;
use Google_Service_Classroom;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Redirect the user to the provider authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider($driver)
    {
        return Socialite::driver('google')
            ->scopes(['openid', 'profile', 'email', Google_Service_Classroom::CLASSROOM_COURSES, Google_Service_Classroom::CLASSROOM_TOPICS])
            ->redirect();
    }

    /**
     * Obtain the user information from provider.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback($driver)
    {
        try {
            $user = Socialite::driver($driver)->user();
        } catch (Exception $e) {
            return redirect()->route('login');
        }
        // Set token for the Google API PHP Client
        $google_client_token = [
            'access_token' => $user->token,
            'refresh_token' => $user->refreshToken,
            'expires_in' => $user->expiresIn
        ];
        /*
        $client = new Google_Client();
        $client->setApplicationName('Skilltree');
        $client->setScopes(Google_Service_Classroom::CLASSROOM_COURSES);
        $client->setAccessToken($google_client_token);
        $service = new Google_Service_Classroom($client);
        dd($service->courses->listCourses());
*/
        $existingUser = User::where('email', $user->getEmail())->first();

        if ($existingUser) {
            $attributes = [
                'g_token' => json_encode($google_client_token)
            ];
            $existingUser->update($attributes);
            auth()->login($existingUser, true);
        } else {

            $findme   = 'elev';
            $pos = strpos($user->getEmail(), $findme);

            $newUser                    = new User;
            $newUser->provider_name     = $driver;
            $newUser->provider_id       = $user->getId();
            $newUser->teacher           = $pos === false ? true : false;
            $newUser->g_token           = json_encode($google_client_token);
            $newUser->name              = $user->getName();
            $newUser->email             = $user->getEmail();
            $newUser->email_verified_at = now();
            $newUser->avatar            = $user->getAvatar();
            $newUser->save();

            auth()->login($newUser, true);
        }
        return redirect($this->redirectPath());
    }
}
