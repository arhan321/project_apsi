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

        // Find or create the user
        $user = User::firstOrNew(
            [
                'email' => $googleUser->getEmail()
            ],
            [
                'provider' => 'google',
                'provider_id' => $googleUser->getId()
            ]
        );

        // Update user details
        $user->name = $googleUser->getName();
        $user->photo = $googleUser->getAvatar();
        $user->email_verified_at = now();
        $user->role = 'admin'; // Set the role to admin
        $user->status = 'active';
        $user->save();

        // Log the user in
        Auth::login($user, true);

        // Redirect to admin dashboard
        return redirect('/admin');
    }
}
