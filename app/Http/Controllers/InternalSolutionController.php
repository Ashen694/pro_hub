<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InternalPlatform;
use App\Models\ParentProject;
use App\Models\Employee;
use App\Models\SDLCphase;
use Illuminate\Support\Facades\Validator;

class InternalSolutionController extends Controller
{
    /**
     * Display a listing of the resource.
     * This function now loads the Livewire component.
     */
    public function index(Request $request, $status)
    {
        $validStatuses = ['operational', 'in-progress', 'recently-launched', 'retired', 'abandoned'];

        if (!in_array($status, $validStatuses)) {
            abort(404);
        }

        $title = 'Internal Solutions - ' . ucfirst(str_replace('-', ' ', $status));

        return view('internal_solutions.index', [
            'title' => $title,
            'status' => $status,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $mainApplications = InternalPlatform::orderBy('App_Name')->get();
        $employees = Employee::orderBy('Emp_Name')->get();
        $sdlcPhases = SDLCphase::orderBy('OrderSeq')->get();
        $applicationGroups = ParentProject::orderBy('ParentProjectGroup')->get();

        return view('internal_solutions.create', [
            'mainApplications' => $mainApplications,
            'employees' => $employees,
            'sdlcPhases' => $sdlcPhases,
            'applicationGroups' => $applicationGroups,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'application_category' => 'required|string',
            'application_group' => 'required|integer|exists:ParentProject,ParentProjectID',
            'application_name' => 'required|string|max:255',
            'parent_application' => 'required_if:application_category,Change Request|nullable|integer',
            'start_date' => 'nullable|date',
            'target_date' => 'nullable|date',
            'uat_date' => 'nullable|date',
            'va_date' => 'nullable|date',
            'launched_date' => 'nullable|date',
            'percentage_done' => 'nullable|integer|min:0|max:100',
            'application_url' => 'nullable|url',
            'solution_value' => 'nullable|numeric',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        InternalPlatform::create([
            'App_Category' => $request->input('application_category'),
            'ParentProjectID' => $request->input('application_group'),
            'MainAppID' => $request->input('application_category') === 'Change Request' ? $request->input('parent_application') : null,
            'App_Name' => $request->input('application_name'),
            'Developed_By' => $request->input('developed_by'),
            'Developed_Team' => $request->input('developed_team'),
            'StartDate' => $request->input('start_date'),
            'TargetDate' => $request->input('target_date'),
            'BIT_bucket_repo' => $request->input('bitbucket_repo'),
            'SDLCPhase' => $request->input('sdlc_phase'),
            'PercentageDone' => $request->input('percentage_done'),
            'Bus_Owner' => $request->input('business_owner'),
            'App_IP' => $request->input('server_ip'),
            'App_URL' => $request->input('application_url'),
            'App_Users' => $request->input('end_users'),
            'UATDate' => $request->input('uat_date'),
            'Integrated_apps' => $request->input('integrated_applications'),
            'DR' => $request->input('dr_availability'),
            'LaunchedDate' => $request->input('launched_date'),
            'VADate' => $request->input('va_date'),
            'WAF' => $request->input('exposed_through_waf'),
            'Price' => $request->input('solution_value'),
            'EndUserType' => $request->input('end_users'),
            'SLA' => $request->input('support_availability'),
            'UserSpecificSection' => $request->input('user_specific_section'),
            'Status' => 'in-progress',
        ]);

        return redirect()->route('internal-solutions.index', ['status' => 'in-progress'])
                         ->with('success', 'New internal solution added successfully!');
    }

    /**
     * Show yearly contribution summary.
     */
    public function yearlyContribution()
    {
        // This function is unchanged
        $yearlyData = [];
        $currentYear = now()->year;
        for ($year = 2005; $year <= $currentYear; $year++) {
            $solutionValue = rand(500000, 2000000);
            $maintenanceEffort = rand(100000, 500000);
            $yearlyData[] = (object)[
                'year' => $year,
                'solution_value' => $solutionValue,
                'maintenance_effort' => $maintenanceEffort,
                'grand_total' => $solutionValue + $maintenanceEffort,
            ];
        }
        $yearlyData = array_reverse($yearlyData);
        return view('internal_solutions.yearly_contribution', ['yearlyData' => $yearlyData]);
    }

    /**
     * Display a list of change requests for a specific main application.
     */
    public function showChangeRequests(InternalPlatform $solution)
    {
        $changeRequests = $solution->changeRequests()->paginate(10);
        return view('internal_solutions.change_requests_list', [
            'mainApplication' => $solution,
            'changeRequests' => $changeRequests
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(InternalPlatform $solution)
    {
        $solution->load(['parentProject', 'mainApplicationParent']);
        return view('internal_solutions.show', ['solution' => $solution]);
    }
}