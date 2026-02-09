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
                        $existingCategory = AmazonCategory::where('category_name', $categoryName)->first();
                        
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
        $category = AmazonCategory::findOrFail($id);
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
        $category = AmazonCategory::findOrFail($id);
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
