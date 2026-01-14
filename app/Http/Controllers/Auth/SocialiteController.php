<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }


    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

   
   


    public function handleGoogleCallback()
{
    try {
        $user = Socialite::driver('google')->user();
        return $this->createOrLoginUser($user); 
    } catch (\Exception $e) {
        \Log::error('Google login error: '.$e->getMessage());
        return redirect()->route('login')->withErrors('Failed to log in with Google.');
    }
}

public function handleFacebookCallback()
{
    try {
        $user = Socialite::driver('facebook')->user();
        return $this->createOrLoginUser($user); 
    } catch (\Exception $e) {
        \Log::error('Facebook login error: '.$e->getMessage());
        \Log::error('Exception Trace: ' . $e->getTraceAsString());
        return redirect()->route('login')->withErrors('Failed to log in with Facebook.');
    }
}

private function createOrLoginUser($socialUser)
{
    $email = $socialUser->getEmail();
    if (!$email) {
        return redirect()->route('login')->withErrors('No email provided by the social account.');
    }

    $user = User::firstOrCreate(
        ['email' => $email],
        [
            'name' => $socialUser->getName(),
            'password' => bcrypt(uniqid()),
            'email_verified_at' => now(),
            'last_login_at' => now(),
            'role' => 'private_seller',
        ]
    );

    $user->update(['last_login_at' => now()]);
    Auth::login($user);

    return redirect()->intended(
        $user->phone_number === null
            ? route('private_seller')
            : route('dashboard')
    );
}

}

