<?php

namespace App\Http\Controllers;

use App\Models\AmazonCategory;
use Illuminate\Http\Request;

class AmazonCategoryController extends Controller
{
    public function index()
    {
        $categories = AmazonCategory::latest()->paginate(10);
        return view('backend.amazon.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('backend.amazon.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048'
        ]);

        $data = $request->except('image');
        $data['status'] = 'active'; // Set default status
        
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/amazon'), $fileName);
            $data['image'] = $fileName;
        }

        AmazonCategory::create(array_merge($data, ['user_id' => auth()->id()]));
        return redirect()->route('amazon-categories.index')
            ->with('success', 'Category created successfully.');
    }

    public function show($id)
    {
        $category = AmazonCategory::findOrFail($id);
        return view('backend.amazon.categories.show', compact('category'));
    }

    public function edit($id)
    {
        $category = AmazonCategory::findOrFail($id);
        return view('backend.amazon.categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'category_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048'
        ]);

        $category = AmazonCategory::findOrFail($id);
        $data = $request->except('image');
        $data['status'] = 'active'; // Set default status
        
        if ($request->hasFile('image')) {
            // Delete old image
            if ($category->image && file_exists(public_path('uploads/amazon/' . $category->image))) {
                unlink(public_path('uploads/amazon/' . $category->image));
            }
            
            $file = $request->file('image');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/amazon'), $fileName);
            $data['image'] = $fileName;
        }

        $category->update(array_merge($data, ['user_id' => auth()->id()]));
        
        return redirect()->route('amazon-categories.index')
            ->with('success', 'Category updated successfully.');
    }

    public function toggleStatus($id)
    {
        $category = AmazonCategory::findOrFail($id);
        $category->status = $category->status === 'active' ? 'inactive' : 'active';
        $category->save();
        
        return response()->json([
            'success' => true,
            'status' => $category->status,
            'message' => 'Category status updated successfully.'
        ]);
    }

    public function destroy($id)
    {
        $category = AmazonCategory::findOrFail($id);
        
        // Delete image
        if ($category->image && file_exists(public_path('uploads/amazon/' . $category->image))) {
            unlink(public_path('uploads/amazon/' . $category->image));
        }
        
        $category->delete();
        
        return redirect()->route('amazon-categories.index')
            ->with('success', 'Category deleted successfully.');
    }
}
