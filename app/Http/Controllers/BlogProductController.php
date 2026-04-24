<?php

namespace App\Http\Controllers;

use App\Models\BlogProduct;
use App\Models\BlogCategory;
use App\Models\BlogSubCategory;
use Illuminate\Http\Request;

class BlogProductController extends Controller
{
    public function index()
    {
        $products = BlogProduct::with(['category', 'subCategory'])
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);
        return view('backend.blog.products.index', compact('products'));
    }

    public function create()
    {
        $categories = BlogCategory::where('status', 'active')
            ->where('user_id', auth()->id())
            ->get();
        return view('backend.blog.products.create_with_dynamic', compact('categories'));
    }

    public function import()
    {
        $categories = BlogCategory::where('status', 'active')
            ->where('user_id', auth()->id())
            ->get();
        return view('backend.blog.products.import_with_dynamic', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'blog_category_id' => 'required|exists:blog_categories,id',
            'blog_sub_category_id' => 'nullable|exists:blog_sub_categories,id',
            'product_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'short_description' => 'nullable|string|max:500',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048',
            'image_url' => 'nullable|url|max:500',
            'link' => 'nullable|url|max:500',
            'affiliate_url' => 'nullable|url|max:500',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:255'
        ]);

        $data = $request->except('image');
        $data['status'] = 'active'; // Set default status
        
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/blog'), $fileName);
            $data['image'] = $fileName;
        }

        BlogProduct::create(array_merge($data, ['user_id' => auth()->id()]));
        return redirect()->route('blog-products.index')
            ->with('success', 'Blog Product created successfully.');
    }

    public function importStore(Request $request)
    {
        $request->validate([
            'blog_category_id' => 'required|exists:blog_categories,id',
            'blog_sub_category_id' => 'nullable|exists:blog_sub_categories,id',
            'csv_file' => 'required|file|mimes:csv,txt|max:10240'
        ]);

        $file = $request->file('csv_file');
        $path = $file->getRealPath();
        $categoryId = $request->blog_category_id;
        $subCategoryId = $request->blog_sub_category_id;
        
        $imported = 0;
        $skipped = 0;
        $errors = [];

        try {
            $csvData = array_map('str_getcsv', file($path));
            $headers = array_shift($csvData); // Remove header row
            
            foreach ($csvData as $row) {
                if (count($row) >= 2) {
                    $productName = trim($row[0]);
                    $description = trim($row[1] ?? '');
                    $link = trim($row[2] ?? '');
                    $metaTitle = trim($row[3] ?? '');
                    $metaDescription = trim($row[4] ?? '');
                    $metaKeywords = trim($row[5] ?? '');
                    $status = trim($row[6] ?? 'active');
                    
                    if (!empty($productName)) {
                        // Check if product already exists in the same category/subcategory
                        $existingProduct = BlogProduct::where('product_name', $productName)
                            ->where('blog_category_id', $categoryId)
                            ->when($subCategoryId, function($query, $subCategoryId) {
                                return $query->where('blog_sub_category_id', $subCategoryId);
                            })
                            ->where('user_id', auth()->id())
                            ->first();
                        
                        if (!$existingProduct) {
                            BlogProduct::create([
                                'blog_category_id' => $categoryId,
                                'blog_sub_category_id' => $subCategoryId,
                                'product_name' => $productName,
                                'description' => $description,
                                'link' => $link,
                                'meta_title' => $metaTitle,
                                'meta_description' => $metaDescription,
                                'meta_keywords' => $metaKeywords,
                                'status' => in_array($status, ['active', 'inactive']) ? $status : 'active',
                                'user_id' => auth()->id()
                            ]);
                            $imported++;
                        } else {
                            $skipped++;
                        }
                    }
                }
            }
            
            return redirect()->route('blog-products.index')
                ->with('success', "Import completed! {$imported} products imported, {$skipped} skipped (duplicates).");
                
        } catch (\Exception $e) {
            return redirect()->route('blog-products.import')
                ->with('error', 'Error importing file: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $product = BlogProduct::with(['category', 'subCategory'])
            ->where('user_id', auth()->id())
            ->findOrFail($id);
        return view('backend.blog.products.show', compact('product'));
    }

    public function edit($id)
    {
        $product = BlogProduct::where('user_id', auth()->id())->findOrFail($id);
        $categories = BlogCategory::where('status', 'active')
            ->where('user_id', auth()->id())
            ->get();
        $subCategories = $product->blog_category_id ? 
            BlogSubCategory::where('blog_category_id', $product->blog_category_id)
                ->where('status', 'active')
                ->get() : [];
        return view('backend.blog.products.edit_with_dynamic', compact('product', 'categories', 'subCategories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'blog_category_id' => 'required|exists:blog_categories,id',
            'blog_sub_category_id' => 'nullable|exists:blog_sub_categories,id',
            'product_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'short_description' => 'nullable|string|max:500',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048',
            'image_url' => 'nullable|url|max:500',
            'link' => 'nullable|url|max:500',
            'affiliate_url' => 'nullable|url|max:500',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:255'
        ]);

        $product = BlogProduct::where('user_id', auth()->id())->findOrFail($id);
        $data = $request->except('image');
        $data['status'] = 'active'; // Set default status
        
        if ($request->hasFile('image')) {
            // Delete old image
            if ($product->image && file_exists(public_path('uploads/blog/' . $product->image))) {
                unlink(public_path('uploads/blog/' . $product->image));
            }
            
            $file = $request->file('image');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/blog'), $fileName);
            $data['image'] = $fileName;
        }

        $product->update(array_merge($data, ['user_id' => auth()->id()]));
        return redirect()->route('blog-products.index')
            ->with('success', 'Blog Product updated successfully.');
    }

    public function toggleStatus($id)
    {
        $product = BlogProduct::where('user_id', auth()->id())->findOrFail($id);
        $product->status = $product->status === 'active' ? 'inactive' : 'active';
        $product->save();
        
        return response()->json([
            'success' => true,
            'status' => $product->status,
            'message' => 'Blog Product status updated successfully.'
        ]);
    }

    public function destroy($id)
    {
        $product = BlogProduct::where('user_id', auth()->id())->findOrFail($id);
        
        // Delete image
        if ($product->image && file_exists(public_path('uploads/blog/' . $product->image))) {
            unlink(public_path('uploads/blog/' . $product->image));
        }
        
        $product->delete();
        return redirect()->route('blog-products.index')
            ->with('success', 'Blog Product deleted successfully.');
    }
}
