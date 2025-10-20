<?php

namespace App\Http\Controllers;

use App\Models\CustomerContact;
use App\Models\Company;
use Illuminate\Http\Request;

class CustomerContactController extends Controller
{
    public function index()
    {
        $contacts = CustomerContact::with('company')->paginate(20);
        return view('reference-data.customer-contacts.index', compact('contacts'));
    }

    public function create()
    {
        $companies = Company::orderBy('name')->get();
        return view('reference-data.customer-contacts.create', compact('companies'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'company_id' => 'required|exists:companies,id',
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'role' => 'nullable|string',
        ]);

        CustomerContact::create($data);
        return redirect()->route('reference-data.customer-contacts.index')->with('success', 'Contact added.');
    }

    public function edit(CustomerContact $customerContact)
    {
        $companies = Company::orderBy('name')->get();
        return view('reference-data.customer-contacts.edit', ['contact' => $customerContact, 'companies' => $companies]);
    }

    public function update(Request $request, CustomerContact $customerContact)
    {
        $data = $request->validate([
            'company_id' => 'required|exists:companies,id',
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'role' => 'nullable|string',
        ]);

        $customerContact->update($data);
        return redirect()->route('reference-data.customer-contacts.index')->with('success', 'Contact updated.');
    }

    public function destroy(CustomerContact $customerContact)
    {
        $customerContact->delete();
        return redirect()->route('reference-data.customer-contacts.index')->with('success', 'Contact deleted.');
    }
}
