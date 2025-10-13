<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InternalPlatform;
use Illuminate\Support\Facades\Validator;

use App\Models\Employee;  
use App\Models\SDLCphase;  

class InternalSolutionController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index($status)
    {
        $query = InternalPlatform::query();

        switch ($status) {
            case 'operational':
                $query->where('SDLCPhase', 'Maintenance');
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
                $query->whereRaw('1 = 0'); // This ensures no results are returned
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
     */
    public function create()
    {
        $mainApplications = InternalPlatform::orderBy('App_Name')->get();
        $employees = Employee::orderBy('Emp_Name')->get();
        $sdlcPhases = SDLCphase::orderBy('OrderSeq')->get(); 

        return view('internal_solutions.create', [
            'mainApplications' => $mainApplications,
            'employees' => $employees,
            'sdlcPhases' => $sdlcPhases,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validation
        $validator = Validator::make($request->all(), [
            'application_category' => 'required|string',
            'application_group' => 'required|string',
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

        // 2. Map form data to database column names and save
        InternalPlatform::create([
            'App_Category' => $request->input('application_group'), // Application Group එක තමයි App_Category
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
            'ParentProjectID' => $request->input('application_category') === 'Change Request'
                ? $request->input('parent_application')
                : null,
            'SLA' => $request->input('support_availability'),
            'UserSpecificSection' => $request->input('user_specific_section'),
            'Status' => 'in-progress', // Default status when creating a new one
        ]);

        // 3. Redirect with success message
        return redirect()->route('internal-solutions.index', ['status' => 'in-progress'])
            ->with('success', 'New internal solution added successfully!');
    }



    /**
     * Show yearly contribution summary.
     */
    public function yearlyContribution()
    {
        $yearlyData = [];
        $currentYear = now()->year;

        // Generate dummy data from 2005 to the current year
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

        // Reverse the array to show the most recent year at the bottom
        $yearlyData = array_reverse($yearlyData);

        return view('internal_solutions.yearly_contribution', [
            'yearlyData' => $yearlyData
        ]);
    }
}
