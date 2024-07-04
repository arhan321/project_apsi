<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use Socialite;
use Illuminate\Http\Request;

class GoogleSsoController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

        // Check if the user exists
        $user = User::where('email', $googleUser->getEmail())->first();

        if ($user) {
            // Update user details
            $user->name = $googleUser->getName();
            $user->photo = $googleUser->getAvatar();
            $user->email_verified_at = now();
            $user->status = 'active';
            $user->save();

            // Log the user in
            Auth::login($user, true);

            // Redirect to user dashboard
            return redirect('/admin'); // Adjust the redirection as needed
        } else {
            // Redirect to login page with an error
            return redirect('/login')->withErrors(['email' => 'Email not registered. Please contact support.']);
        }
    }
}
