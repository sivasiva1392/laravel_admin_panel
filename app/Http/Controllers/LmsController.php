<?php

namespace App\Http\Controllers;

use App\Models\Lms;
use App\Models\LmsCategory;
use Illuminate\Http\Request;

class LmsController extends Controller
{
    public function index()
    {
        $documents = Lms::with('category')->latest()->paginate(10);
        return view('backend.lms.documents.index', compact('documents'));
    }

    public function create()
    {
        $categories = LmsCategory::where('status', 'active')->pluck('category_name', 'id');
        return view('backend.lms.documents.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'lms_category_id' => 'required|exists:lms_categories,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'document' => 'required|mimes:pdf,doc,docx,xls,xlsx|max:10240',
            'status' => 'required|in:active,inactive'
        ]);

        $data = $request->except('document');
        
        if ($request->hasFile('document')) {
            $file = $request->file('document');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/lms'), $fileName);
            $data['document'] = $fileName;
        }

        Lms::create(array_merge($data, ['user_id' => auth()->id()]));
        return redirect()->route('lms.index')
            ->with('success', 'Document uploaded successfully.');
    }

    public function show($id)
    {
        $document = Lms::with('category')->findOrFail($id);
        return view('backend.lms.documents.show', compact('document'));
    }

    public function edit($id)
    {
        $document = Lms::findOrFail($id);
        $categories = LmsCategory::where('status', 'active')->pluck('category_name', 'id');
        return view('backend.lms.documents.edit', compact('document', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'lms_category_id' => 'required|exists:lms_categories,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'document' => 'nullable|mimes:pdf,doc,docx,xls,xlsx|max:10240',
            'status' => 'required|in:active,inactive'
        ]);

        $document = Lms::findOrFail($id);
        $data = $request->except('document');
        
        if ($request->hasFile('document')) {
            // Delete old file
            if ($document->document && file_exists(public_path('uploads/lms/' . $document->document))) {
                unlink(public_path('uploads/lms/' . $document->document));
            }
            
            $file = $request->file('document');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/lms'), $fileName);
            $data['document'] = $fileName;
        }

        $document->update(array_merge($data, ['user_id' => auth()->id()]));
        return redirect()->route('lms.index')
            ->with('success', 'Document updated successfully.');
    }

    public function destroy($id)
    {
        $document = Lms::findOrFail($id);
        
        // Delete file
        if ($document->document && file_exists(public_path('uploads/lms/' . $document->document))) {
            unlink(public_path('uploads/lms/' . $document->document));
        }
        
        $document->delete();
        return redirect()->route('lms.index')
            ->with('success', 'Document deleted successfully.');
    }
}
