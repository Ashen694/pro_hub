<?php

namespace App\Http\Controllers;

use App\Models\Partner; // Make sure to import your Partner model
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    // You already have this
    public function index()
    {
        $partners = Partner::paginate(10); // Or however you get them
        return view('partners.index', compact('partners'));
    }

    // You already have this
    public function create()
    {
        $titles = ['Mr.', 'Mrs.', 'Ms.', 'Dr.']; // Get titles from your source
        return view('partners.create', compact('titles'));
    }

    // You already have this
    public function store(Request $request)
    {
        // Add validation here (good practice)
        $request->validate([
            'organization_name' => 'required|string|max:255',
            'contact_person_name' => 'required|string|max:255',
            'contact_person_email' => 'required|email',

            'contact_person_phone_1' => 'required|numeric|digits:10',
            'contact_person_phone_2' => 'nullable|numeric|digits:10',
            'contact_person_designation' => 'nullable|string',

            // ... add other validation rules
        ]);

        Partner::create($request->all());

        return redirect()->route('partners.index')
            ->with('success', 'Partner created successfully.');
    }

    /**
     * NEW: Show a single partner (View)
     */
    public function show(Partner $partner)
    {
        // $partner is automatically found by Laravel (Route-Model Binding)
        return view('partners.show', compact('partner'));
    }

    /**
     * NEW: Show the form to edit a partner (Edit)
     */
    public function edit(Partner $partner)
    {
        // $partner is automatically found
        $titles = ['Mr.', 'Mrs.', 'Ms.', 'Dr.']; // You need titles for the dropdown
        return view('partners.edit', compact('partner', 'titles'));
    }

    /**
     * NEW: Save the changes (Update)
     */
    public function update(Request $request, Partner $partner)
    {
        // $partner is automatically found
        // Validate the incoming data
        $request->validate([
            'organization_name' => 'required|string|max:255',
            'contact_person_name' => 'required|string|max:255',
            'contact_person_email' => 'required|email',
            // ... add other validation rules
            'contact_person_phone_1' => 'required|numeric|digits:10',
            'contact_person_phone_2' => 'nullable|numeric|digits:10',
            'contact_person_designation' => 'nullable|string',
        ]);

        // Update the partner's data
        $partner->update($request->all());

        // Redirect back to the index page with a success message
        return redirect()->route('partners.index')
            ->with('success', 'Partner updated successfully.');
    }

    // You might already have this
    public function destroy(Partner $partner)
    {
        // $partner is automatically found
        $partner->delete();

        return redirect()->route('partners.index')
            ->with('success', 'Partner deleted successfully.');
    }
}
