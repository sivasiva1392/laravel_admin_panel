<?php

namespace App\Http\Controllers;

use App\Models\AmazonSubCategory;
use App\Models\AmazonCategory;
use Illuminate\Http\Request;

class AmazonSubCategoryController extends Controller
{
    public function index()
    {
        $subCategories = AmazonSubCategory::with('category')
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);
        return view('backend.amazon.sub-categories.index', compact('subCategories'));
    }

    public function create()
    {
        $categories = AmazonCategory::where('user_id', auth()->id())
            ->where('status', 'active')
            ->pluck('category_name', 'id');
        return view('backend.amazon.sub-categories.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'amazon_category_id' => 'required|exists:amazon_categories,id',
            'sub_category_name' => 'required|string|max:255',
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

        AmazonSubCategory::create(array_merge($data, ['user_id' => auth()->id()]));

        return redirect()->route('amazon-sub-categories.index')
            ->with('success', 'Amazon Sub-Category created successfully!');
    }

    public function show($id)
    {
        $subCategory = AmazonSubCategory::with('category')
            ->where('user_id', auth()->id())
            ->findOrFail($id);
        return view('backend.amazon.sub-categories.show', compact('subCategory'));
    }

    public function edit($id)
    {
        $subCategory = AmazonSubCategory::where('user_id', auth()->id())
            ->findOrFail($id);
        $categories = AmazonCategory::where('user_id', auth()->id())
            ->where('status', 'active')
            ->pluck('category_name', 'id');
        return view('backend.amazon.sub-categories.edit', compact('subCategory', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'amazon_category_id' => 'required|exists:amazon_categories,id',
            'sub_category_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048'
        ]);

        $subCategory = AmazonSubCategory::where('user_id', auth()->id())
            ->findOrFail($id);

        $data = $request->except('image');
        
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($subCategory->image && file_exists(public_path('uploads/amazon/' . $subCategory->image))) {
                unlink(public_path('uploads/amazon/' . $subCategory->image));
            }
            
            $file = $request->file('image');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/amazon'), $fileName);
            $data['image'] = $fileName;
        }

        $subCategory->update($data);

        return redirect()->route('amazon-sub-categories.index')
            ->with('success', 'Amazon Sub-Category updated successfully!');
    }

    public function destroy($id)
    {
        $subCategory = AmazonSubCategory::where('user_id', auth()->id())
            ->findOrFail($id);

        // Delete image if exists
        if ($subCategory->image && file_exists(public_path('uploads/amazon/' . $subCategory->image))) {
            unlink(public_path('uploads/amazon/' . $subCategory->image));
        }

        $subCategory->delete();

        return redirect()->route('amazon-sub-categories.index')
            ->with('success', 'Amazon Sub-Category deleted successfully!');
    }

    public function toggleStatus($id)
    {
        $subCategory = AmazonSubCategory::where('user_id', auth()->id())
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
