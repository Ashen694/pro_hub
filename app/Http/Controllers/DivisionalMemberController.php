<?php

namespace App\Http\Controllers;

use App\Models\DivisionalMember;
use Illuminate\Http\Request;

class DivisionalMemberController extends Controller
{
    public function index()
    {
        $members = DivisionalMember::orderBy('name')->paginate(20);
        return view('reference-data.divisional-members.index', compact('members'));
    }

    public function create()
    {
        return view('reference-data.divisional-members.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'division' => 'nullable|string|max:255',
            'email' => 'nullable|email',
            'position' => 'nullable|string',
        ]);

        DivisionalMember::create($data);
        return redirect()->route('reference-data.divisional-members.index')->with('success', 'Member added.');
    }

    public function edit(DivisionalMember $divisionalMember)
    {
        return view('reference-data.divisional-members.edit', ['member' => $divisionalMember]);
    }

    public function update(Request $request, DivisionalMember $divisionalMember)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'division' => 'nullable|string|max:255',
            'email' => 'nullable|email',
            'position' => 'nullable|string',
        ]);

        $divisionalMember->update($data);
        return redirect()->route('reference-data.divisional-members.index')->with('success', 'Member updated.');
    }

    public function destroy(DivisionalMember $divisionalMember)
    {
        $divisionalMember->delete();
        return redirect()->route('reference-data.divisional-members.index')->with('success', 'Member deleted.');
    }
}
