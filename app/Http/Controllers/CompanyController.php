<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = Company::orderBy('name')->paginate(15);
        return view('reference-data.companies.index', compact('companies'));
    }

    public function create()
    {
        return view('reference-data.companies.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'nullable|string|max:100',
            'contact_email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
        ]);

        Company::create($data);

        return redirect()->route('reference-data.companies.index')->with('success', 'Company created.');
    }

    public function edit(Company $company)
    {
        return view('reference-data.companies.edit', compact('company'));
    }

    public function update(Request $request, Company $company)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'nullable|string|max:100',
            'contact_email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
        ]);

        $company->update($data);

        return redirect()->route('reference-data.companies.index')->with('success', 'Company updated.');
    }

    public function destroy(Company $company)
    {
        $company->delete();
        return redirect()->route('reference-data.companies.index')->with('success', 'Company deleted.');
    }
}
