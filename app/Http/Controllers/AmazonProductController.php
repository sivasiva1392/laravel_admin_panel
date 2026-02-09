<?php

namespace App\Http\Controllers;

use App\Models\AmazonProduct;
use App\Models\AmazonCategory;
use Illuminate\Http\Request;

class AmazonProductController extends Controller
{
    public function index()
    {
        $products = AmazonProduct::with('category')->latest()->paginate(10);
        return view('backend.amazon.products.index', compact('products'));
    }

    public function create()
    {
        $categories = AmazonCategory::where('status', 'active')->pluck('category_name', 'id');
        return view('backend.amazon.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'amazon_category_id' => 'required|exists:amazon_categories,id',
            'product_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048',
            'link' => 'nullable|url|max:500',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:255'
        ]);

        $data = $request->except('image');
        $data['status'] = 'active'; // Set default status
        
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/amazon'), $fileName);
            $data['image'] = $fileName;
        }

        AmazonProduct::create(array_merge($data, ['user_id' => auth()->id()]));
        return redirect()->route('amazon-products.index')
            ->with('success', 'Product created successfully.');
    }

    public function show($id)
    {
        $product = AmazonProduct::with('category')->findOrFail($id);
        return view('backend.amazon.products.show', compact('product'));
    }

    public function edit($id)
    {
        $product = AmazonProduct::findOrFail($id);
        $categories = AmazonCategory::where('status', 'active')->pluck('category_name', 'id');
        return view('backend.amazon.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'amazon_category_id' => 'required|exists:amazon_categories,id',
            'product_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048',
            'link' => 'nullable|url|max:500',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:255'
        ]);

        $product = AmazonProduct::findOrFail($id);
        $data = $request->except('image');
        $data['status'] = 'active'; // Set default status
        
        if ($request->hasFile('image')) {
            // Delete old image
            if ($product->image && file_exists(public_path('uploads/amazon/' . $product->image))) {
                unlink(public_path('uploads/amazon/' . $product->image));
            }
            
            $file = $request->file('image');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/amazon'), $fileName);
            $data['image'] = $fileName;
        }

        $product->update(array_merge($data, ['user_id' => auth()->id()]));
        return redirect()->route('amazon-products.index')
            ->with('success', 'Product updated successfully.');
    }

    public function toggleStatus($id)
    {
        $product = AmazonProduct::findOrFail($id);
        $product->status = $product->status === 'active' ? 'inactive' : 'active';
        $product->save();
        
        return response()->json([
            'success' => true,
            'status' => $product->status,
            'message' => 'Product status updated successfully.'
        ]);
    }

    public function destroy($id)
    {
        $product = AmazonProduct::findOrFail($id);
        
        // Delete image
        if ($product->image && file_exists(public_path('uploads/amazon/' . $product->image))) {
            unlink(public_path('uploads/amazon/' . $product->image));
        }
        
        $product->delete();
        return redirect()->route('amazon-products.index')
            ->with('success', 'Product deleted successfully.');
    }
}
