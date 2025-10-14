<?php

namespace App\Http\Controllers;

// --- Imports ---
// Make sure to import all necessary models and the Request class
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
     * This function now handles the "Operational without CR" filter.
     */
    public function index(Request $request, $status)
    {
        // Eager load relationships to prevent performance issues (N+1 problem)
        $query = InternalPlatform::with(['parentProject', 'mainApplicationParent']);

        switch ($status) {
            case 'operational':
                $query->where('SDLCPhase', 'Maintenance');
                
                // NEW LOGIC: Check for the "?filter=without_cr" in the URL
                if ($request->get('filter') === 'without_cr') {
                    $query->where('App_Category', 'Main Application');
                }
                break;

            case 'in-progress':
            case 'recently-launched':
                $inProgressPhases = [
                    'Proposal Preparation',
                    'Proposal Submitted',
                    'Requirement Gathering and Analysis',
                    'Design',
                    'Coding or Implementation',
                    'Testing',
                    'Deployment'
                ];
                $query->whereIn('SDLCPhase', $inProgressPhases);
                break;

            case 'retired':
                $query->where('SDLCPhase', 'Retired');
                break;

            case 'abandoned':
                $query->where('SDLCPhase', 'Abandoned');
                break;
            
            default:
                $query->whereRaw('1 = 0'); // Ensures no results for unknown statuses
                break;
        }

        $solutions = $query->latest('created_at')->paginate(10);

        $title = 'Internal Solutions - ' . ucfirst($status);

        $viewPartial = '';
        switch ($status) {
            case 'retired':
            case 'abandoned':
                $viewPartial = '_table_retired';
                break;
            
            case 'in-progress':
            case 'recently-launched':
                $viewPartial = '_table_inprogress';
                break;

            default: 
                $viewPartial = '_table_operational';
                break;
        }

        return view('internal_solutions.index', [
            'title' => $title,
            'status' => $status,
            'viewPartial' => $viewPartial,
            'solutions' => $solutions
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * This function now fetches Application Groups from the ParentProject table.
     */
    public function create()
    {
        $mainApplications = InternalPlatform::orderBy('App_Name')->get();
        $employees = Employee::orderBy('Emp_Name')->get();
        $sdlcPhases = SDLCphase::orderBy('OrderSeq')->get(); 
        // NEW: Fetch groups from the database instead of hard-coding
        $applicationGroups = ParentProject::orderBy('ParentProjectGroup')->get();

        return view('internal_solutions.create', [
            'mainApplications' => $mainApplications,
            'employees' => $employees,
            'sdlcPhases' => $sdlcPhases,
            'applicationGroups' => $applicationGroups, // Pass the new data to the view
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * This function now saves data with the correct logic for App_Category and MainAppID.
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

        // CORRECTED DATA SAVING LOGIC
        InternalPlatform::create([
            // 1. Save 'Main Application' or 'Change Request' to App_Category
            'App_Category' => $request->input('application_category'),
            
            // 2. Save the Group ID to ParentProjectID
            'ParentProjectID' => $request->input('application_group'),
            
            // 3. Save the parent application's ID to MainAppID ONLY for Change Requests
            'MainAppID' => $request->input('application_category') === 'Change Request' ? $request->input('parent_application') : null,
            
            // All other fields from the form
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
     * (This function is unchanged)
     */
    public function yearlyContribution()
    {
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

        return view('internal_solutions.yearly_contribution', [
            'yearlyData' => $yearlyData
        ]);
    }

    /**
     * Display a list of change requests for a specific main application.
     */
    public function showChangeRequests(InternalPlatform $solution)
    {
        // We use the 'changeRequests' relationship we just defined in the model
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
        // Eager load relationships for the details page
        $solution->load(['parentProject', 'mainApplicationParent']);

        return view('internal_solutions.show', [
            'solution' => $solution
        ]);
    }

    public function destroy(InternalPlatform $solution)
    {
        // IMPORTANT LOGIC: Check if this is a Main Application and if it has any associated Change Requests.
        if ($solution->App_Category == 'Main Application' && $solution->changeRequests()->exists()) {
            return redirect()->back()->with('error', 'Cannot delete this Main Application because it has associated Change Requests. Please delete them first.');
        }

        // If the check passes, delete the record.
        $solution->delete();

        // Redirect back to the previous page with a success message.
        return redirect()->back()->with('success', 'Solution deleted successfully!');
    }

}