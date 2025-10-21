<?php

namespace App\Http\Controllers;

use App\Models\FieldOfSpecialization;
use Illuminate\Http\Request;

class FieldOfSpecializationController extends Controller
{
    public function index()
    {
        $items = FieldOfSpecialization::orderBy('name')->paginate(20);
        return view('reference-data.fields-of-specializations.index', compact('items'));
    }

    public function create()
    {
        return view('reference-data.fields-of-specializations.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'notes' => 'nullable|string',
        ]);

        FieldOfSpecialization::create($data);
        return redirect()->route('reference-data.fields-of-specializations.index')->with('success', 'Saved.');
    }

    public function edit(FieldOfSpecialization $fieldsOfSpecialization)
    {
        return view('reference-data.fields-of-specializations.edit', ['item' => $fieldsOfSpecialization]);
    }

    public function show(FieldOfSpecialization $fieldsOfSpecialization)
    {
        return view('reference-data.fields-of-specializations.show', ['item' => $fieldsOfSpecialization]);
    }

    public function update(Request $request, FieldOfSpecialization $fieldsOfSpecialization)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $fieldsOfSpecialization->update($data);
        return redirect()->route('reference-data.fields-of-specializations.index')->with('success', 'Updated.');
    }

    public function destroy(FieldOfSpecialization $fieldsOfSpecialization)
    {
        $fieldsOfSpecialization->delete();
        return redirect()->route('reference-data.fields-of-specializations.index')->with('success', 'Deleted.');
    }
}
