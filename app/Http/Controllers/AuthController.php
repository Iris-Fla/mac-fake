<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserData;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        $user = UserData::where('email', $credentials['email'])->first();

        if ($user && $user->password === $credentials['password']) {
            Auth::login($user);
            $request->session()->regenerate();
            return redirect()->intended('/menu');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.'
        ]);
    }
}