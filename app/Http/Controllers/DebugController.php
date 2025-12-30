<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DebugController extends Controller
{
    /**
     * Check current user info
     */
    public function userInfo()
    {
        if (!Auth::check()) {
            return response()->json([
                'authenticated' => false,
                'message' => 'User is not authenticated'
            ]);
        }

        $user = Auth::user();
        return response()->json([
            'authenticated' => true,
            'user_id' => $user->user_id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
        ]);
    }

    /**
     * Check all users
     */
    public function allUsers()
    {
        $users = \App\Models\User::all(['user_id', 'name', 'email', 'role']);
        return response()->json($users);
    }

    /**
     * Test route
     */
    public function test()
    {
        return response()->json(['message' => 'Debug routes working!']);
    }
}
