<?php

namespace App\Http\Controllers;

use App\Models\CustomerContact;
use App\Models\Company;
use App\Models\ExternalPlatform;
use Illuminate\Http\Request;

class CustomerContactController extends Controller
{
    public function index(Request $request)
    {
        $perPage = (int) $request->get('perPage', 10);
        $search = trim((string) $request->get('q', ''));

        $query = CustomerContact::with(['company', 'externalPlatform']);

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('role', 'like', "%{$search}%");
            })->orWhereHas('company', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        $contacts = $query->paginate($perPage)->appends($request->query());

        return view('reference-data.customer-contacts.index', compact('contacts'));
    }

    public function create()
    {
        $companies = Company::orderBy('name')->get();
        $externalPlatforms = ExternalPlatform::orderBy('platform_name')->get();
        return view('reference-data.customer-contacts.create', compact('companies', 'externalPlatforms'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'company_id' => 'required|exists:companies,id',
            'external_platform_id' => 'nullable|exists:external_platforms,platform_id',
            'title' => 'required|string|max:10',
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
        $externalPlatforms = ExternalPlatform::orderBy('platform_name')->get();
        return view('reference-data.customer-contacts.edit', ['contact' => $customerContact, 'companies' => $companies, 'externalPlatforms' => $externalPlatforms]);
    }

    public function show(CustomerContact $customerContact)
    {
        return view('reference-data.customer-contacts.show', ['contact' => $customerContact]);
    }

    public function update(Request $request, CustomerContact $customerContact)
    {
        $data = $request->validate([
            'company_id' => 'required|exists:companies,id',
            'external_platform_id' => 'nullable|exists:external_platforms,platform_id',
            'title' => 'required|string|max:10',
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

    /**
     * Get external platforms for a specific company (AJAX endpoint)
     */
    public function getExternalPlatformsByCompany(Request $request)
    {
        $companyId = $request->get('company_id');
        
        if (!$companyId) {
            return response()->json([]);
        }

        $platforms = ExternalPlatform::where('company_id', $companyId)
            ->orderBy('platform_name')
            ->select('platform_id', 'platform_name')
            ->get();

        return response()->json($platforms);
    }
}
