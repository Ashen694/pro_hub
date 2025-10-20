<?php

namespace App\Http\Controllers;

use App\Models\ApplicationGroup;
use Illuminate\Http\Request;

class ApplicationGroupController extends Controller
{
    public function index()
    {
        $groups = ApplicationGroup::orderBy('name')->paginate(20);
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

        ApplicationGroup::create($data);
        return redirect()->route('reference-data.application-groups.index')->with('success', 'Group added.');
    }

    public function edit(ApplicationGroup $applicationGroup)
    {
        return view('reference-data.application-groups.edit', ['group' => $applicationGroup]);
    }

    public function update(Request $request, ApplicationGroup $applicationGroup)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $applicationGroup->update($data);
        return redirect()->route('reference-data.application-groups.index')->with('success', 'Group updated.');
    }

    public function destroy(ApplicationGroup $applicationGroup)
    {
        $applicationGroup->delete();
        return redirect()->route('reference-data.application-groups.index')->with('success', 'Group deleted.');
    }
}
