<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    public function index(Request $r)
    {
        $q = $r->q;

        $services = Service::with(['artist','category'])
            ->orderBy('created_at','desc');

        if ($q) {
            $services->where(function($x) use ($q) {
                $x->where('title','like',"%{$q}%")
                  ->orWhere('description','like',"%{$q}%");
            });
        }

        $services = $services->paginate(12)->withQueryString();

        return view('services.index', compact('services'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('services.create', compact('categories'));
    }

    public function store(Request $r)
    {
        $r->validate([
            'title'=>'required|string|max:255',
            'description'=>'nullable|string',
            'base_price'=>'required|numeric|min:0',
            'expected_duration'=>'nullable|string|max:255',
            'category_id'=>'nullable|exists:categories,category_id',
        ]);

        Service::create([
            'user_id'=>Auth::id(),
            'category_id'=>$r->category_id,
            'title'=>$r->title,
            'description'=>$r->description,
            'base_price'=>$r->base_price,
            'expected_duration'=>$r->expected_duration,
            'status'=>$r->status ?? 'active',
        ]);

        return redirect()->route('services.index')->with('success','Service created.');
    }

    public function show(Service $service)
    {
        return view('services.show', compact('service'));
    }

    public function edit(Service $service)
    {
        if (!Auth::check() || (Auth::user()->role !== 'admin' && Auth::id() !== $service->user_id)) {
            abort(403);
        }

        $categories = Category::all();
        return view('services.edit', compact('service','categories'));
    }

    public function update(Request $r, Service $service)
    {
        if (!Auth::check() || (Auth::user()->role !== 'admin' && Auth::id() !== $service->user_id)) {
            abort(403);
        }

        $r->validate([
            'title'=>'required|string|max:255',
            'description'=>'nullable|string',
            'base_price'=>'required|numeric|min:0',
            'expected_duration'=>'nullable|string|max:255',
            'category_id'=>'nullable|exists:categories,category_id',
            'status'=>'required|in:active,inactive',
        ]);

        $service->update([
            'category_id'=>$r->category_id,
            'title'=>$r->title,
            'description'=>$r->description,
            'base_price'=>$r->base_price,
            'expected_duration'=>$r->expected_duration,
            'status'=>$r->status,
        ]);

        return redirect()->route('services.index')->with('success','Service updated.');
    }

    public function destroy(Service $service)
    {
        if (!Auth::check() || (Auth::user()->role !== 'admin' && Auth::id() !== $service->user_id)) {
            abort(403);
        }

        $service->delete();

        return back()->with('success','Service deleted.');
    }
}
