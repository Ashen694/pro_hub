<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    public function index()
    {
        $partners = Partner::latest()->paginate(10);
        return view('partners.index', compact('partners'));
    }

    public function create()
    {
        $titles = ['Mr.', 'Mrs.', 'Ms.', 'Dr.'];
        return view('partners.create', compact('titles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'organization_name' => 'required|string|max:255',
            'contact_person_title' => 'nullable|string|max:255',
            'contact_person_name' => 'required|string|max:255',
            'contact_person_email' => 'required|email|max:255',
            'contact_person_phone_1' => [
                'nullable',
                'digits:10',
                'regex:/^[0-9]{10}$/'
            ],
            'contact_person_phone_2' => [
                'nullable',
                'digits:10',
                'regex:/^[0-9]{10}$/',
                'different:contact_person_phone_1'
            ],
            'contact_person_designation' => 'nullable|string|max:255',
        ], [
            'contact_person_phone_1.regex' => 'Phone number must be 10 digits only.',
            'contact_person_phone_2.regex' => 'Phone number must be 10 digits only.',
            'contact_person_phone_2.different' => 'Phone 2 cannot be the same as Phone 1.',
        ]);

        // Duplicate check by name + email
        $exists = \App\Models\Partner::where('organization_name', $request->organization_name)
            ->where('contact_person_email', $request->contact_person_email)
            ->exists();

        if ($exists) {
            return back()->withErrors(['duplicate' => 'This partner already exists.'])->withInput();
        }

        \App\Models\Partner::create($request->all());

        return redirect()->route('reference-data.partners.index')
            ->with('success', 'Partner created successfully.');
    }


    public function show(Partner $partner)
    {
        return view('partners.show', compact('partner'));
    }

    public function edit(Partner $partner)
    {
        $titles = ['Mr.', 'Mrs.', 'Ms.', 'Dr.'];
        return view('partners.edit', compact('partner', 'titles'));
    }

    public function update(Request $request, Partner $partner)
    {
        $request->validate([
            'organization_name' => 'required|string|max:255',
            'contact_person_title' => 'nullable|string|max:255',
            'contact_person_name' => 'required|string|max:255',
            'contact_person_email' => 'required|email|max:255',
            'contact_person_phone_1' => 'nullable|string|max:20',
            'contact_person_phone_2' => 'nullable|string|max:20',
            'contact_person_designation' => 'nullable|string|max:255',
        ]);

        $partner->update($request->all());

        return redirect()->route('reference-data.partners.index')
            ->with('success', 'Partner updated successfully.');
    }

    public function destroy(Partner $partner)
    {
        $partner->delete();

        return redirect()->route('reference-data.partners.index')
            ->with('success', 'Partner deleted successfully.');
    }
}
