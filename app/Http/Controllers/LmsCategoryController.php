<?php

namespace App\Http\Controllers;

use App\Models\LmsCategory;
use Illuminate\Http\Request;

class LmsCategoryController extends Controller
{
    public function index()
    {
        $categories = LmsCategory::where('user_id', auth()->id())->latest()->paginate(10);
        return view('backend.lms.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('backend.lms.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|string|max:255',
            'status' => 'required|in:active,inactive'
        ]);

        LmsCategory::create(array_merge($request->all(), ['user_id' => auth()->id()]));
        return redirect()->route('lms-categories.index')
            ->with('success', 'Category created successfully.');
    }

    public function show($id)
    {
        $category = LmsCategory::where('user_id', auth()->id())->findOrFail($id);
        return view('backend.lms.categories.show', compact('category'));
    }

    public function edit($id)
    {
        $category = LmsCategory::where('user_id', auth()->id())->findOrFail($id);
        return view('backend.lms.categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'category_name' => 'required|string|max:255',
            'status' => 'required|in:active,inactive'
        ]);

        $category = LmsCategory::where('user_id', auth()->id())->findOrFail($id);
        $category->update(array_merge($request->all(), ['user_id' => auth()->id()]));
        
        return redirect()->route('lms-categories.index')
            ->with('success', 'Category updated successfully.');
    }

    public function destroy($id)
    {
        $category = LmsCategory::where('user_id', auth()->id())->findOrFail($id);
        $category->delete();
        
        return redirect()->route('lms-categories.index')
            ->with('success', 'Category deleted successfully.');
    }
}
