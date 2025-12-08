<?php

namespace App\Http\Controllers;

use App\Models\Artwork;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ArtworkController extends Controller
{
    public function index(Request $r)
    {
        $q = $r->q;

        $arts = Artwork::with(['artist', 'category'])
            ->orderBy('created_at', 'desc');

        if ($q) {
            $arts->where(function ($x) use ($q) {
                $x->where('title', 'like', "%{$q}%")
                  ->orWhere('description', 'like', "%{$q}%");
            });
        }

        $arts = $arts->paginate(12)->withQueryString();

        return view('artworks.index', compact('arts'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('artworks.create', compact('categories'));
    }

    public function store(Request $r)
    {
        $r->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|max:8192',
            'category_id' => 'nullable|exists:categories,category_id',
        ]);

        $path = $r->file('image')->store('artworks', 'public');

        Artwork::create([
            'user_id' => Auth::id(),
            'title' => $r->title,
            'description' => $r->description,
            'image_url' => $path,
            'category_id' => $r->category_id,
        ]);

        return redirect()->route('artworks.index')->with('success', 'Artwork uploaded.');
    }

    public function show(Artwork $artwork)
    {
        return view('artworks.show', compact('artwork'));
    }

    public function edit(Artwork $artwork)
    {
        if (!Auth::check() || (Auth::user()->role !== 'admin' && Auth::id() !== $artwork->user_id)) {
            abort(403);
        }

        $categories = Category::all();
        return view('artworks.edit', compact('artwork', 'categories'));
    }

    public function update(Request $r, Artwork $artwork)
    {
        if (!Auth::check() || (Auth::user()->role !== 'admin' && Auth::id() !== $artwork->user_id)) {
            abort(403);
        }

        $r->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:8192',
            'category_id' => 'nullable|exists:categories,category_id',
        ]);

        if ($r->hasFile('image')) {
            if ($artwork->image_url) {
                Storage::disk('public')->delete($artwork->image_url);
            }
            $artwork->image_url = $r->file('image')->store('artworks', 'public');
        }

        $artwork->title = $r->title;
        $artwork->description = $r->description;
        $artwork->category_id = $r->category_id;
        $artwork->save();

        return redirect()->route('artworks.index')->with('success', 'Artwork updated.');
    }

    public function destroy(Artwork $artwork)
    {
        if (!Auth::check() || (Auth::user()->role !== 'admin' && Auth::id() !== $artwork->user_id)) {
            abort(403);
        }

        if ($artwork->image_url) {
            Storage::disk('public')->delete($artwork->image_url);
        }

        $artwork->delete();

        return back()->with('success', 'Artwork deleted.');
    }
}
