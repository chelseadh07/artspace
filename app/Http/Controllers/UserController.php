<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(Request $r)
    {
        $q = $r->q;
        $users = User::query();

        if ($q) {
            $users->where(function($x) use ($q) {
                $x->where('name','like',"%{$q}%")
                  ->orWhere('email','like',"%{$q}%");
            });
        }

        $users = $users->orderBy('created_at','desc')->paginate(10)->withQueryString();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $r)
    {
        $r->validate([
            'name'=>'required|string|max:255',
            'email'=>'required|email|unique:users,email',
            'password'=>'required|min:6|confirmed',
            'role'=>'required|in:admin,artist,client',
            'bio'=>'nullable|string',
            'avatar'=>'nullable|image|max:4096'
        ]);

        $avatar = null;
        if ($r->hasFile('avatar')) {
            $avatar = $r->file('avatar')->store('avatars','public');
        }

        User::create([
            'name'=>$r->name,
            'email'=>$r->email,
            'password'=>Hash::make($r->password),
            'role'=>$r->role,
            'bio'=>$r->bio,
            'avatar'=>$avatar,
        ]);

        return redirect()->route('users.index')->with('success','User created.');
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $r, User $user)
    {
        // Only admin or the owner can update
        if (!Auth::check() || (Auth::user()->role !== 'admin' && Auth::id() !== $user->id)) {
            abort(403);
        }

        $r->validate([
            'name'=>'required|string|max:255',
            'email'=>"required|email|unique:users,email,{$user->id}",
            'password'=>'nullable|min:6|confirmed',
            'role'=>'required|in:admin,artist,client',
            'bio'=>'nullable|string',
            'avatar'=>'nullable|image|max:4096'
        ]);

        if ($r->hasFile('avatar')) {
            if ($user->avatar) Storage::disk('public')->delete($user->avatar);
            $user->avatar = $r->file('avatar')->store('avatars','public');
        }

        $user->name = $r->name;
        $user->email = $r->email;
        if ($r->filled('password')) {
            $user->password = Hash::make($r->password);
        }
        $user->role = $r->role;
        $user->bio = $r->bio;
        $user->save();

        return redirect()->route('users.index')->with('success','User updated.');
    }

    public function destroy(User $user)
    {
        if (!Auth::check() || (Auth::user()->role !== 'admin' && Auth::id() !== $user->id)) {
            abort(403);
        }

        if ($user->avatar) Storage::disk('public')->delete($user->avatar);
        $user->delete();

        return back()->with('success','User deleted.');
    }
}
