<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $r)
    {
        $q = $r->q;
        $cats = Category::query();
        if ($q) $cats->where('name','like',"%{$q}%");
        $cats = $cats->orderBy('name')->paginate(10)->withQueryString();
        return view('categories.index', compact('cats'));
    }

    public function create(){ return view('categories.create'); }

    public function store(Request $r)
    {
        $r->validate(['name'=>'required|string|max:255','description'=>'nullable|string']);
        Category::create($r->only(['name','description']));
        return redirect()->route('categories.index')->with('success','Category added.');
    }

    public function show(Category $category){ return view('categories.show', compact('category'));}

    public function edit(Category $category){ return view('categories.edit', compact('category'));}

    public function update(Request $r, Category $category)
    {
        $r->validate(['name'=>'required|string|max:255','description'=>'nullable|string']);
        $category->update($r->only(['name','description']));
        return redirect()->route('categories.index')->with('success','Category updated.');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return back()->with('success','Category deleted.');
    }
}
