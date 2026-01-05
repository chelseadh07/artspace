<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    public function index(Request $r)
    {
        $q = $r->q;

        $services = Service::with(['artist', 'categories'])
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
        // Cek apakah artist sudah mengisi nomor WhatsApp
        if (Auth::user()->role === 'artist' && empty(Auth::user()->whatsapp_link)) {
            return redirect()->route('services.index')
                ->with('error', 'You must add your WhatsApp number in your profile before creating a service. Please complete your profile.');
        }

        return view('services.create');
    }

    public function store(Request $r)
    {
        // Cek apakah artist sudah mengisi nomor WhatsApp
        if (Auth::user()->role === 'artist' && empty(Auth::user()->whatsapp_link)) {
            return redirect()->route('services.index')
                ->with('error', 'You must add your WhatsApp number in your profile before creating a service. Please complete your profile.');
        }

        $r->validate([
            'title'=>'required|string|max:255',
            'description'=>'nullable|string',
            'base_price'=>'required|numeric|min:0',
            'expected_duration'=>'nullable|string|max:255',
            'image'=>'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'categories'=>'nullable|json',
        ]);

        // Handle image upload
        $thumbnail = null;
        if ($r->hasFile('image')) {
            $path = $r->file('image')->store('services', 'public');
            $thumbnail = $path;
        }

        // Buat service terlebih dahulu
        $service = Service::create([
            'user_id'=>Auth::id(),
            'title'=>$r->title,
            'description'=>$r->description,
            'base_price'=>$r->base_price,
            'expected_duration'=>$r->expected_duration,
            'thumbnail'=>$thumbnail,
            'status'=>'active',
        ]);

        // Handle multiple categories dengan harga berbeda
        if ($r->categories) {
            $categoriesData = json_decode($r->categories, true);
            
            if (is_array($categoriesData)) {
                foreach ($categoriesData as $catData) {
                    // Cek atau buat kategori
                    $category = Category::where('name', $catData['name'])->first();
                    if (!$category) {
                        $category = Category::create(['name' => $catData['name']]);
                    }
                    
                    // Attach category dengan harga ke service
                    $service->categories()->attach($category->category_id, [
                        'price' => $catData['price']
                    ]);
                }
            }
        }

        return redirect()->route('services.index')->with('success','Service created.');
    }

    public function show(Service $service)
    {
        $service->load('categories');
        return view('services.show', compact('service'));
    }

    public function edit(Service $service)
    {
        if (!Auth::check() || (Auth::user()->role !== 'admin' && Auth::id() !== $service->user_id)) {
            abort(403);
        }

        $service->load('categories');
        $categories = Category::all();
        return view('services.edit', compact('service', 'categories'));
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
            'image'=>'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'categories'=>'nullable|json',
            'status'=>'required|in:active,inactive',
        ]);

        // Handle image upload
        $thumbnail = $service->thumbnail;
        if ($r->hasFile('image')) {
            // Delete old image if exists
            if ($service->thumbnail) {
                Storage::disk('public')->delete($service->thumbnail);
            }
            
            $path = $r->file('image')->store('services', 'public');
            $thumbnail = $path;
        }

        // Build update data - only include thumbnail if changed
        $updateData = [
            'title'=>$r->title,
            'description'=>$r->description,
            'base_price'=>$r->base_price,
            'expected_duration'=>$r->expected_duration,
            'status'=>$r->status,
        ];
        
        // Only add thumbnail to update if we have image file or if column exists
        if ($r->hasFile('image')) {
            $updateData['thumbnail'] = $thumbnail;
        }

        $service->update($updateData);

        // Update categories jika ada
        if ($r->categories) {
            // Hapus kategori lama
            $service->categories()->detach();
            
            $categoriesData = json_decode($r->categories, true);
            
            if (is_array($categoriesData)) {
                foreach ($categoriesData as $catData) {
                    $category = Category::where('name', $catData['name'])->first();
                    if (!$category) {
                        $category = Category::create(['name' => $catData['name']]);
                    }
                    
                    $service->categories()->attach($category->category_id, [
                        'price' => $catData['price']
                    ]);
                }
            }
        }

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
