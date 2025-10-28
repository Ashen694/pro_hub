<?php

namespace App\Http\Controllers;

use App\Models\DivisionalMember;
use Illuminate\Http\Request;

class DivisionalMemberController extends Controller
{
    public function index()
    {
        $perPage = request('perPage', 10);
        $search = request('q');
        
        $query = DivisionalMember::orderBy('name');
        
        if ($search) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('contact_mobile', 'like', "%{$search}%")
                  ->orWhere('division', 'like', "%{$search}%")
                  ->orWhere('position', 'like', "%{$search}%");
        }
        
        $members = $query->paginate($perPage)->withQueryString();
        
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
            'contact_mobile' => 'nullable|string|max:20',
            'position' => 'nullable|string',
        ]);

        DivisionalMember::create($data);
        return redirect()->route('reference-data.divisional-members.index')->with('success', 'Member added.');
    }

    public function show(DivisionalMember $divisionalMember)
    {
        return view('reference-data.divisional-members.show', ['member' => $divisionalMember]);
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
            'contact_mobile' => 'nullable|string|max:20',
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
