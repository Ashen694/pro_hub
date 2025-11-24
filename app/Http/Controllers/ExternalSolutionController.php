<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExternalPlatform as ExternalSolution;
use App\Models\Company;
use Illuminate\Validation\Rule;
use App\Models\Employee;
use App\Models\SDLCphase;

class ExternalSolutionController extends Controller
{
    public function index($status)
    {
        $validStatuses = ['prospective', 'operational', 'retired', 'abandoned'];
        if (!in_array($status, $validStatuses)) {
            abort(404);
        }
        $title = 'External Solutions - ' . ucfirst($status);
        return view('external_solutions.index', compact('title', 'status'));
    }

    public function show($id)
    {
        $solution = ExternalSolution::findOrFail($id);
        $title = 'Details for ' . $solution->platform_name;
        return view('external_solutions.show', compact('solution', 'title'));
    }

    public function edit($id)
    {
        $solution = ExternalSolution::findOrFail($id);
        $title = 'Edit External Solution: ' . $solution->platform_name;
        return view('external_solutions.edit', compact('solution', 'title'));
    }

    public function update(Request $request, $id)
    {
        $solution = ExternalSolution::findOrFail($id);
        
        $data = $request->validate([
            'platform_name' => 'required|string|max:200',
            'platform_type' => 'nullable|string|max:150',
            'start_date' => 'nullable|date',
            'target_date' => 'nullable|date',
            'developed_by' => 'nullable|string|max:200',
            'developed_team' => 'nullable|string|max:200',
            'bitbucket' => 'nullable|string|max:200',
            'bit_bucket_repo' => 'nullable|string|max:300',
            'sdlc_stage' => 'nullable|string|max:100',
            'percentage_done' => 'nullable|integer|min:0|max:100',
            'status' => ['required', Rule::in(['prospective', 'operational', 'retired', 'abandoned'])],
            'status_date' => 'nullable|date',
            'company_id' => 'nullable|integer',  
            'sales_am' => 'nullable|string|max:200',
            'sales_manager' => 'nullable|string|max:200',
            'sales_engineer' => 'nullable|string|max:200',
            'uat_date' => 'nullable|date',
            'va_date' => 'nullable|date',
            'launched_date' => 'nullable|date',
            'platform_owner' => 'nullable|string|max:200',
            'app_op_owner' => 'nullable|string|max:200',
            'platform_otc' => 'nullable|string|max:100',
            'platform_mrc' => 'nullable|string|max:100',
            'contract_period' => 'nullable|string|max:100',
            'software_value' => 'nullable|numeric',
            'backup_officer_1' => 'nullable|string|max:200',
            'backup_officer_2' => 'nullable|string|max:200',
        ]);

        $solution->update($data);

        return redirect()->route('external-solutions.index', ['status' => $solution->status])
            ->with('success', 'External solution updated successfully.');
    }

    public function destroy($id)
    {
        $solution = ExternalSolution::findOrFail($id);
        $status = $solution->status;
        $solution->delete();
        return redirect()->route('external-solutions.index', ['status' => $status])
            ->with('success', 'External solution deleted.');
    }

    public function create()
    {
        $title = 'Add New External Solution';
        
        $companies = Company::orderBy('name')->get();
        $employees = Employee::orderBy('Emp_Name')->get(); 

        $sdlc_stages = SDLCphase::orderBy('OrderSeq', 'asc')->get();

        return view('external_solutions.create', compact('title', 'companies', 'employees', 'sdlc_stages'));
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'platform_name' => 'required|string|max:200',
            'platform_type' => 'nullable|string|max:150',
            'start_date' => 'nullable|date',
            'target_date' => 'nullable|date',
            'developed_by' => 'nullable|string|max:200',
            'developed_team' => 'nullable|string|max:200',
            'bitbucket' => 'nullable|string|max:200',
            'bit_bucket_repo' => 'nullable|string|max:300',
            'sdlc_stage' => 'nullable|string|max:100',
            'percentage_done' => 'nullable|integer|min:0|max:100',
            'status' => ['required', Rule::in(['prospective', 'operational', 'retired', 'abandoned'])],
            'status_date' => 'nullable|date',
            'company_id' => 'nullable|integer',
            'sales_am' => 'nullable|string|max:200',
            'sales_manager' => 'nullable|string|max:200',
            'sales_engineer' => 'nullable|string|max:200',
            'uat_date' => 'nullable|date',
            'va_date' => 'nullable|date',
            'launched_date' => 'nullable|date',
            'platform_owner' => 'nullable|string|max:200',
            'app_op_owner' => 'nullable|string|max:200',
            'platform_otc' => 'nullable|string|max:100',
            'platform_mrc' => 'nullable|string|max:100',
            'contract_period' => 'nullable|string|max:100',
            'software_value' => 'nullable|numeric',
            'backup_officer_1' => 'nullable|string|max:200',
            'backup_officer_2' => 'nullable|string|max:200',
        ]);

        ExternalSolution::create($data);

        return redirect()->route('external-solutions.index', ['status' => $request->status ?? 'operational'])
            ->with('success', 'External solution added successfully.');
    }
}