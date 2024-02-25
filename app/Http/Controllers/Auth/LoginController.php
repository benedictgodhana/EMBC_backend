<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;


class LoginController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->user();
        
        // Find or create the user in your database based on the $googleUser data
        $user = User::firstOrCreate(['email' => $googleUser->getEmail()], [
            'name' => $googleUser->getName(),
            // Add more fields as needed
        ]);

        // Generate authentication tokens and return them to the frontend
        $accessToken = $user->createToken('Token Name')->accessToken;
        return response()->json(['access_token' => $accessToken]);
    }

    public function login(Request $request)
    {
        // Validate the incoming request data
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Attempt to authenticate the user
        if (Auth::attempt($credentials)) {
            // Authentication was successful
            $user = Auth::user();
            $token = $user->createToken('authToken')->plainTextToken;
            $role =$user->roles->first()->name;

            return response()->json([
                'user' => $user, 
                'token' => $token,
                'role'=>$role,
                ]
                , 200);
        } else {
            // Authentication failed
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
    }

    public function logout(Request $request)
    {
        request->$user()->tokens()->delete();
         return response()->json([
            'message'=> 'Successfully logged out'
         ]);
    }



}
