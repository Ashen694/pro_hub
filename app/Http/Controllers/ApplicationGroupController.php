<?php

namespace App\Http\Controllers;

use App\Models\ParentProject;        
use Illuminate\Http\Request;

class ApplicationGroupController extends Controller
{
    public function index()
    {
        $groups = ParentProject::orderBy('ParentProjectGroup')->paginate(20);
        return view('reference-data.application-groups.index', compact('groups'));
    }

    public function create()
    {
        return view('reference-data.application-groups.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        ParentProject::create([
            'ParentProjectGroup' => $data['name'],
            'OperationScope' => $data['description']
        ]);

        return redirect()->route('reference-data.application-groups.index')->with('success', 'Group added.');
    }

    public function edit(ParentProject $applicationGroup)
    {
        return view('reference-data.application-groups.edit', ['group' => $applicationGroup]);
    }

    public function show(ParentProject $applicationGroup)
    {
        return view('reference-data.application-groups.show', ['group' => $applicationGroup]);
    }

    public function update(Request $request, ParentProject $applicationGroup)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        
        $applicationGroup->update([
            'ParentProjectGroup' => $data['name'],
            'OperationScope' => $data['description']
        ]);

        return redirect()->route('reference-data.application-groups.index')->with('success', 'Group updated.');
    }

    public function destroy(ParentProject $applicationGroup)
    {
        $applicationGroup->delete();
        return redirect()->route('reference-data.application-groups.index')->with('success', 'Group deleted.');
    }
}