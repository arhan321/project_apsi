<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use Socialite;
use Illuminate\Http\Request;

class GoogleUserSsoController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

        // Check if the user with the given email exists in the database
        $user = User::where('email', $googleUser->getEmail())->first();

        if ($user) {
            // Update user details
            $user->provider = 'google';
            $user->provider_id = $googleUser->getId();
            $user->name = $googleUser->getName();
            $user->photo = $googleUser->getAvatar();
            $user->email_verified_at = now();
            $user->status = 'active';
            $user->save();
        } else {
            // Create new user if not exist
            $user = User::create([
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'photo' => $googleUser->getAvatar(),
                'provider_id' => $googleUser->getId(),
                'provider' => 'google',
                'role' => 'user', 
                'status' => 'active',
                'email_verified_at' => now(),
            ]);
        }

        // Log the user in
        Auth::login($user, true);

        // Redirect based on user role
        if ($user->role == 'admin') {
            return redirect('/admin')->with('success', 'You are logged in as admin from Google.');
        } else {
            return redirect('/')->with('success', 'You are logged in from Google.');
        }
    }
}
