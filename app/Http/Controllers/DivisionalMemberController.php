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
        $type = request('type', 'divisional');
        
        $query = DivisionalMember::orderBy('name');
        
        // Filter by member type
        $query->where('member_type', $type);
        
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('contact_mobile', 'like', "%{$search}%")
                  ->orWhere('service_number', 'like', "%{$search}%")
                  ->orWhere('section', 'like', "%{$search}%")
                  ->orWhere('calling_name', 'like', "%{$search}%");
            });
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
            'service_number' => 'nullable|string|max:50',
            'email' => 'nullable|email',
            'contact_mobile' => 'nullable|string|max:20',
            'group_name' => 'nullable|string|max:255',
            'date_of_birth' => 'nullable|date',
            'calling_name' => 'nullable|string|max:255',
            'gender' => 'nullable|in:Male,Female,Other',
            'section' => 'nullable|string|max:255',
            'member_type' => 'required|in:divisional,view_only',
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
            'service_number' => 'nullable|string|max:50',
            'email' => 'nullable|email',
            'contact_mobile' => 'nullable|string|max:20',
            'group_name' => 'nullable|string|max:255',
            'date_of_birth' => 'nullable|date',
            'calling_name' => 'nullable|string|max:255',
            'gender' => 'nullable|in:Male,Female,Other',
            'section' => 'nullable|string|max:255',
            'member_type' => 'required|in:divisional,view_only',
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
