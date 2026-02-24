<?php

namespace App\Http\Controllers;

use App\Models\AmazonCategory;
use App\Models\AmazonSubCategory;
use Illuminate\Http\Request;

class AmazonCategoryController extends Controller
{
    public function index()
    {
        $categories = AmazonCategory::where('user_id', auth()->id())->latest()->paginate(10);
        return view('backend.amazon.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('backend.amazon.categories.create');
    }

    public function import()
    {
        return view('backend.amazon.categories.import');
    }

    public function importStore(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:10240'
        ]);

        $file = $request->file('csv_file');
        $path = $file->getRealPath();
        
        $imported = 0;
        $skipped = 0;
        $errors = [];

        try {
            $csvData = array_map('str_getcsv', file($path));
            $headers = array_shift($csvData); // Remove header row
            
            foreach ($csvData as $row) {
                if (count($row) >= 2) {
                    $categoryName = trim($row[0]);
                    $description = trim($row[1] ?? '');
                    $status = trim($row[2] ?? 'active');
                    
                    if (!empty($categoryName)) {
                        // Check if category already exists
                        $existingCategory = AmazonCategory::where('category_name', $categoryName)
                            ->where('user_id', auth()->id())
                            ->first();
                        
                        if (!$existingCategory) {
                            AmazonCategory::create([
                                'category_name' => $categoryName,
                                'description' => $description,
                                'status' => in_array($status, ['active', 'inactive']) ? $status : 'active',
                                'is_show' => 0, // Set default is_show to 0
                                'user_id' => auth()->id()
                            ]);
                            $imported++;
                        } else {
                            $skipped++;
                        }
                    }
                }
            }
            
            return redirect()->route('amazon-categories.index')
                ->with('success', "Import completed! {$imported} categories imported, {$skipped} skipped (duplicates).");
                
        } catch (\Exception $e) {
            return redirect()->route('amazon-categories.import')
                ->with('error', 'Error importing file: ' . $e->getMessage());
        }
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
        $data['is_show'] = 0; // Set default is_show to 0
        
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
        $category = AmazonCategory::where('user_id', auth()->id())->findOrFail($id);
        return view('backend.amazon.categories.show', compact('category'));
    }

    public function edit($id)
    {
        $category = AmazonCategory::where('user_id', auth()->id())->findOrFail($id);
        return view('backend.amazon.categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'category_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048'
        ]);

        $category = AmazonCategory::where('user_id', auth()->id())->findOrFail($id);
        $data = $request->except('image');
        $data['status'] = 'active'; // Set default status
        $data['is_show'] = $data['is_show'] ?? 0; // Keep existing is_show or set to 0
        
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
        $category = AmazonCategory::where('user_id', auth()->id())->findOrFail($id);
        $category->status = $category->status === 'active' ? 'inactive' : 'active';
        $category->save();
        
        return response()->json([
            'success' => true,
            'status' => $category->status,
            'message' => 'Category status updated successfully.'
        ]);
    }

    public function toggleIsShow($id)
    {
        $category = AmazonCategory::where('user_id', auth()->id())->findOrFail($id);
        $category->is_show = $category->is_show == 1 ? 0 : 1;
        $category->save();
        
        return response()->json([
            'success' => true,
            'is_show' => $category->is_show,
            'message' => 'Category visibility updated successfully.'
        ]);
    }

    public function destroy($id)
    {
        $category = AmazonCategory::where('user_id', auth()->id())->findOrFail($id);
        
        // Delete image
        if ($category->image && file_exists(public_path('uploads/amazon/' . $category->image))) {
            unlink(public_path('uploads/amazon/' . $category->image));
        }
        
        $category->delete();
        
        return redirect()->route('amazon-categories.index')
            ->with('success', 'Category deleted successfully.');
    }

    // Subcategory management methods
    public function subCategories()
    {
        $subCategories = AmazonSubCategory::with('category')
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);
        return view('backend.amazon.subcategories.index', compact('subCategories'));
    }

    public function createSubCategory()
    {
        $categories = AmazonCategory::where('user_id', auth()->id())
            ->where('status', 'active')
            ->get();
        return view('backend.amazon.subcategories.create', compact('categories'));
    }

    public function storeSubCategory(Request $request)
    {
        $request->validate([
            'amazon_category_id' => 'required|exists:amazon_categories,id',
            'sub_category_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048'
        ]);

        $data = $request->except('image');
        $data['status'] = 'active';
        
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/amazon'), $fileName);
            $data['image'] = $fileName;
        }

        AmazonSubCategory::create(array_merge($data, ['user_id' => auth()->id()]));
        
        return redirect()->route('amazon-subcategories.index')
            ->with('success', 'Subcategory created successfully.');
    }

    public function editSubCategory($id)
    {
        $subCategory = AmazonSubCategory::where('user_id', auth()->id())->findOrFail($id);
        $categories = AmazonCategory::where('user_id', auth()->id())
            ->where('status', 'active')
            ->get();
        return view('backend.amazon.subcategories.edit', compact('subCategory', 'categories'));
    }

    public function updateSubCategory(Request $request, $id)
    {
        $request->validate([
            'amazon_category_id' => 'required|exists:amazon_categories,id',
            'sub_category_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048'
        ]);

        $subCategory = AmazonSubCategory::where('user_id', auth()->id())->findOrFail($id);
        $data = $request->except('image');
        
        if ($request->hasFile('image')) {
            // Delete old image
            if ($subCategory->image && file_exists(public_path('uploads/amazon/' . $subCategory->image))) {
                unlink(public_path('uploads/amazon/' . $subCategory->image));
            }
            
            $file = $request->file('image');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/amazon'), $fileName);
            $data['image'] = $fileName;
        }

        $subCategory->update(array_merge($data, ['user_id' => auth()->id()]));
        
        return redirect()->route('amazon-subcategories.index')
            ->with('success', 'Subcategory updated successfully.');
    }

    public function toggleSubCategoryStatus($id)
    {
        $subCategory = AmazonSubCategory::where('user_id', auth()->id())->findOrFail($id);
        $subCategory->status = $subCategory->status === 'active' ? 'inactive' : 'active';
        $subCategory->save();
        
        return response()->json([
            'success' => true,
            'status' => $subCategory->status,
            'message' => 'Subcategory status updated successfully.'
        ]);
    }

    public function destroySubCategory($id)
    {
        $subCategory = AmazonSubCategory::where('user_id', auth()->id())->findOrFail($id);
        
        // Delete image
        if ($subCategory->image && file_exists(public_path('uploads/amazon/' . $subCategory->image))) {
            unlink(public_path('uploads/amazon/' . $subCategory->image));
        }
        
        $subCategory->delete();
        
        return redirect()->route('amazon-subcategories.index')
            ->with('success', 'Subcategory deleted successfully.');
    }

    // API endpoint for dynamic subcategory loading
    public function getSubCategories($categoryId)
    {
        $subCategories = AmazonSubCategory::where('amazon_category_id', $categoryId)
            ->where('status', 'active')
            ->where('user_id', auth()->id())
            ->get(['id', 'sub_category_name']);
            
        return response()->json($subCategories);
    }
}
