<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function loginPage()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($data)) {
            $request->session()->regenerate();
            $user = Auth::user();

            if (($user->role ?? null) === 'admin') {
                return redirect()->route('admin.dashboard');
            }
            if (($user->role ?? null) === 'artist') {
                return redirect()->route('artist.dashboard');
            }
            // buyers are stored with role 'client' in the users table
            return redirect()->route('buyer.dashboard');
        }

        return back()->withErrors(['email' => 'Credentials not match'])->onlyInput('email');
    }

    public function registerBuyerPage()
    {
        return view('auth.register_buyer');
    }

    public function registerBuyer(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'client',
        ]);

        Auth::login($user);
        return redirect()->route('buyer.dashboard');
    }

    public function registerArtistPage()
    {
        return view('auth.register_artist');
    }

    public function registerArtist(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'artist',
        ]);

        Auth::login($user);
        return redirect()->route('artist.dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('landing');
    }

}
    