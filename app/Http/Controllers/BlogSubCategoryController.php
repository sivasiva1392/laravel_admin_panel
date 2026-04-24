<?php

namespace App\Http\Controllers;

use App\Models\BlogSubCategory;
use App\Models\BlogCategory;
use Illuminate\Http\Request;

class BlogSubCategoryController extends Controller
{
    public function index()
    {
        $subCategories = BlogSubCategory::with('category')
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);
        return view('backend.blog.sub-categories.index', compact('subCategories'));
    }

    public function create()
    {
        $categories = BlogCategory::where('user_id', auth()->id())
            ->where('status', 'active')
            ->pluck('category_name', 'id');
        return view('backend.blog.sub-categories.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'blog_category_id' => 'required|exists:blog_categories,id',
            'sub_category_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048'
        ]);

        $data = $request->except('image');
        $data['status'] = 'active'; // Set default status
        
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/blog'), $fileName);
            $data['image'] = $fileName;
        }

        BlogSubCategory::create(array_merge($data, ['user_id' => auth()->id()]));

        return redirect()->route('blog-sub-categories.index')
            ->with('success', 'Blog Sub-Category created successfully!');
    }

    public function show($id)
    {
        $subCategory = BlogSubCategory::with('category')
            ->where('user_id', auth()->id())
            ->findOrFail($id);
        return view('backend.blog.sub-categories.show', compact('subCategory'));
    }

    public function edit($id)
    {
        $subCategory = BlogSubCategory::where('user_id', auth()->id())
            ->findOrFail($id);
        $categories = BlogCategory::where('user_id', auth()->id())
            ->where('status', 'active')
            ->pluck('category_name', 'id');
        return view('backend.blog.sub-categories.edit', compact('subCategory', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'blog_category_id' => 'required|exists:blog_categories,id',
            'sub_category_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048'
        ]);

        $subCategory = BlogSubCategory::where('user_id', auth()->id())
            ->findOrFail($id);

        $data = $request->except('image');
        
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($subCategory->image && file_exists(public_path('uploads/blog/' . $subCategory->image))) {
                unlink(public_path('uploads/blog/' . $subCategory->image));
            }
            
            $file = $request->file('image');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/blog'), $fileName);
            $data['image'] = $fileName;
        }

        $subCategory->update($data);

        return redirect()->route('blog-sub-categories.index')
            ->with('success', 'Blog Sub-Category updated successfully!');
    }

    public function destroy($id)
    {
        $subCategory = BlogSubCategory::where('user_id', auth()->id())
            ->findOrFail($id);

        // Delete image if exists
        if ($subCategory->image && file_exists(public_path('uploads/blog/' . $subCategory->image))) {
            unlink(public_path('uploads/blog/' . $subCategory->image));
        }

        $subCategory->delete();

        return redirect()->route('blog-sub-categories.index')
            ->with('success', 'Blog Sub-Category deleted successfully!');
    }

    public function toggleStatus($id)
    {
        $subCategory = BlogSubCategory::where('user_id', auth()->id())
            ->findOrFail($id);
        
        $subCategory->status = $subCategory->status === 'active' ? 'inactive' : 'active';
        $subCategory->save();

        return response()->json([
            'status' => 'success',
            'new_status' => $subCategory->status,
            'message' => 'Status updated successfully!'
        ]);
    }
}
