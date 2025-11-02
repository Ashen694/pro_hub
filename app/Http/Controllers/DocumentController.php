<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;
use App\Models\InternalPlatform;
use App\Models\ExternalPlatform; 
use App\Models\Employee;  
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DocumentController extends Controller
{
    public function index(Request $request, $type)
    {
        if (!in_array($type, ['internal', 'external'])) {
            abort(404);
        }

        $query = Document::query()->with(['uploader', 'internalSolution']);
        
        $platformId = ($type === 'internal') ? 1 : 2;
        $query->where('Platform_ID', $platformId);

        if ($type === 'internal') {
            $solutions = InternalPlatform::orderBy('App_Name')->get();
            $title = 'Internal Solutions Documents';
        } else {
            $solutions = ExternalPlatform::orderBy('platform_name')->get(); // Fetch external platforms
            $title = 'External Solutions Documents';
        }

        if ($request->filled('solution_id')) {
            $query->where('Solution_ID', $request->input('solution_id'));
        }

        if ($request->filled('search')) {
            $query->where('Doc_Name', 'like', '%' . $request->input('search') . '%');
        }

        $documents = $query->latest('Created_Time')->paginate(10);

        return view('dms.index', [
            'documents' => $documents,
            'solutions' => $solutions,
            'type' => $type,
            'title' => $title,
        ]);
    }

    public function create($type)
    {
        if (!in_array($type, ['internal', 'external'])) {
            abort(404);
        }

        $solutions = collect();
        if ($type === 'internal') {
            $solutions = InternalPlatform::orderBy('App_Name')->get();
            $title = 'Add New Internal Document';
        } else {
            $solutions = ExternalPlatform::orderBy('platform_name')->get();  
            $title = 'Add New External Document';
        }

        $currentUser = Auth::user();

        return view('dms.create', [
            'type' => $type,
            'solutions' => $solutions,
            'currentUser' => $currentUser,
            'title' => $title,
        ]);
    }

    public function store(Request $request, $type)
    {
        $validator = Validator::make($request->all(), [
            'solution_id' => 'required|integer',
            'doc_name' => 'required|string|max:255',
            'document_file' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,jpg,jpeg,png|max:10240',
            'doc_classification' => 'nullable|string|max:255',
            'tags' => 'nullable|string|max:255',
            'confidentiality' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $filePath = null;
        $fileExtension = null;

        if ($request->hasFile('document_file')) {
            $file = $request->file('document_file');
            $fileExtension = $file->getClientOriginalExtension();
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs("documents/{$type}", $fileName, 'public');
        }

        $platformId = ($type === 'internal') ? 1 : 2;

        $userId = Auth::id();

        Document::create([
            'Platform_ID' => $platformId,
            'Solution_ID' => $request->solution_id,
            'Doc_Name' => $request->doc_name,
            'Created_Time' => now(),
            'Created_By' => $userId,  
            'Doc_Type' => $fileExtension,
            'Doc_classification' => $request->doc_classification,
            'Doc_URL' => $filePath,
            'Tags' => $request->tags,
            'Confidential' => $request->confidentiality,
        ]);

        return redirect()->route('dms.index', ['type' => $type])
            ->with('success', 'Document uploaded successfully!');


        
    }
    
    public function download(Document $document)
    {
        if (!Storage::disk('public')->exists($document->Doc_URL)) {
            return back()->with('error', 'File not found on the server.');
        }

        $extension = pathinfo($document->Doc_URL, PATHINFO_EXTENSION);

        $documentName = $document->Doc_Name ?? 'Document';   

        $safeDocumentName = preg_replace('/[^A-Za-z0-9\-\_.]/', '', str_replace(' ', '_', $documentName));
        
        $newFileName = $safeDocumentName . '.' . $extension;

        return Storage::disk('public')->download($document->Doc_URL, $newFileName);
    }
    
    public function destroy(Document $document)
    {
        if ($document->Doc_URL && Storage::disk('public')->exists($document->Doc_URL)) {
            Storage::disk('public')->delete($document->Doc_URL);
        }

        $document->delete();

        return back()->with('success', 'Document deleted successfully.');
    }

    public function edit(Document $document)
    {
        $platformType = ($document->Platform_ID == 1) ? 'Internal' : 'External';

        return view('dms.edit', [
            'document' => $document,
            'platformType' => $platformType,
            'title' => 'Edit Document: ' . $document->Doc_Name,
        ]);
    }

    public function update(Request $request, Document $document)
    {
        $validator = Validator::make($request->all(), [
            'Doc_Name' => 'required|string|max:255',
            'Doc_classification' => 'nullable|string|max:255',
            'Tags' => 'nullable|string|max:255',
            'Confidential' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        $updateData = $request->only([
            'Doc_Name', 
            'Doc_classification', 
            'Tags', 
            'Confidential'
        ]);

        $document->update($updateData);

        $type = ($document->Platform_ID == 1) ? 'internal' : 'external';

        return redirect()->route('dms.index', ['type' => $type])
                        ->with('success', 'Document updated successfully!');
    }
}