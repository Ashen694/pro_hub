<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExternalSolution;
use Illuminate\Validation\Rule;

class ExternalSolutionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($status)
    {
        $title = 'External Solutions - ' . ucfirst($status);

        // Determine view partial based on status
        // Supported statuses: prospective, in-progress, retired, abandoned
        // Map retired/abandoned to the archive partial (same structure)
        if ($status === 'prospective') {
            $viewPartial = '_table_prospective';
        } elseif (in_array($status, ['in-progress', 'operational'])) {
            $viewPartial = '_table_operational';
        } elseif (in_array($status, ['retired', 'abandoned'])) {
            $viewPartial = '_table_archive';
        } else {
            $viewPartial = '_table_operational';
        }

        // Query DB and filter by status
        $query = ExternalSolution::query();
        if ($status === 'prospective') {
            $query->whereNull('launched_date');
        } elseif ($status === 'retired') {
            // For now, treat retired as items that have a launched date
            $query->whereNotNull('launched_date');
        } elseif ($status === 'abandoned') {
            // For now, treat abandoned as items without a launched date
            // (separate from 'prospective' so the page is distinct)
            $query->whereNull('launched_date');
        } else {
            // in-progress/operational and any other status -> launched
            $query->whereNotNull('launched_date');
        }

        // Search filter
        $search = request()->query('q');
        if (!empty($search)) {
            $query->where(function ($sub) use ($search) {
                $sub->where('application_name', 'like', "%{$search}%")
                    ->orWhere('developed_by', 'like', "%{$search}%")
                    ->orWhere('company_customer', 'like', "%{$search}%");
            });
        }

        // Per-page selection
        $allowed = [10,25,50,100];
        $perPage = (int) request()->query('per_page', 50);
        if (!in_array($perPage, $allowed)) {
            $perPage = 50;
        }

        $solutions = $query->orderBy('created_at', 'desc')->paginate($perPage)->withQueryString();

        return view('external_solutions.index', compact('solutions', 'title', 'status', 'viewPartial'));
    }

    /**
     * Display the specified resource.
     */
    public function show(ExternalSolution $externalSolution)
    {
        return view('external_solutions.show', ['solution' => $externalSolution]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ExternalSolution $externalSolution)
    {
        $title = 'Edit External Solution';
        return view('external_solutions.edit', compact('externalSolution', 'title'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ExternalSolution $externalSolution)
    {
        $data = $request->validate([
            'application_name' => 'nullable|string|max:255',
            // (validation rules similar to store)
        ]);

        $externalSolution->update($data);

        return redirect()->route('external-solutions.index', ['status' => 'operational'])
            ->with('success', 'External solution updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ExternalSolution $externalSolution)
    {
        $externalSolution->delete();
        return back()->with('success', 'External solution deleted.');
    }

    /**
     * Show the form for creating a new external solution.
     */
    public function create()
    {
        $title = 'Add New External Solution';
        return view('external_solutions.create', compact('title'));
    }

    /**
     * Store a newly created external solution in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'application_name' => 'nullable|string|max:255',
            'company_customer' => 'nullable|string|max:255',
            'developed_by' => 'nullable|string|max:255',
            'developed_team' => 'nullable|string|max:255',
            'start_date' => 'nullable|date',
            'target_date' => 'nullable|date',
            'dplo_stage' => 'nullable|string|max:255',
            'sdlc_stage' => 'nullable|string|max:255',
            'percentage_done' => 'nullable|string|max:50',
            'bitbucket_repository_name' => 'nullable|string|max:255',
            'sales_team_involved' => ['nullable', Rule::in(['Government Business','Enterprise Business','Carrier Business','Region Business'])],
            'sales_account_manager' => 'nullable|string|max:255',
            'sales_manager' => 'nullable|string|max:255',
            'sales_engineer' => 'nullable|string|max:255',
            'uat_date' => 'nullable|date',
            'launched_date' => 'nullable|date',
            'one_time_charge' => 'nullable|numeric',
            'monthly_recurring_charge' => 'nullable|numeric',
            'value_of_software' => 'nullable|numeric',
            'contract_period_years' => 'nullable|integer',
            'support_availability' => ['nullable', Rule::in(['24x7','24x5','8x5'])],
            'dpo_handover_date' => 'nullable|date',
            'dpo_handover_comments' => 'nullable|string',
        ]);

        ExternalSolution::create($data);

        return redirect()->route('external-solutions.index', ['status' => 'operational'])
            ->with('success', 'External solution added successfully.');
    }

    /**
     * Helper function to create dummy data for different views.
     */
    private function getDummyData($status)
    {
        $data = [];
        for ($i = 1; $i <= 15; $i++) {
            $item = (object)[
                'application_name' => ($status == 'prospective' ? 'Prospective App ' : 'External App ') . $i,
                'developed_by' => 'Vendor ' . chr(65 + $i),
                
                // Data for 'operational' view
                'launched_billed_on' => now()->subMonths($i * 2)->format('Y-m-d'),
                'revenue_sw_value' => number_format(rand(50000, 250000)),
                
                // Data for 'prospective' view
                'company_customer' => 'Customer ' . $i,
                'sdlc_stage' => 'Requirement Gathering',
                'start_date' => now()->addMonths($i)->format('Y-m-d'),
                'dpo_handover_date' => now()->addMonths($i + 1)->format('Y-m-d'),
            ];
            $data[] = $item;
        }
        
        return new \Illuminate\Pagination\LengthAwarePaginator(collect($data), count($data), 10, 1);
    }
}