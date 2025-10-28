<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InternalPlatform;
use App\Models\ParentProject;
use App\Models\Employee;
use App\Models\SDLCphase;
use Illuminate\Support\Facades\Validator;

use App\Models\TargetEndUser;  
use App\Models\InternalProjectComment;  
use Illuminate\Support\Facades\Auth;  

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\InternalSolutionsExport;

use Carbon\Carbon;

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
        $endUserTypes = TargetEndUser::orderBy('EndUserType')->get();

        return view('internal_solutions.create', [
            'mainApplications' => $mainApplications,
            'employees' => $employees,
            'sdlcPhases' => $sdlcPhases,
            'applicationGroups' => $applicationGroups,
            'endUserTypes' => $endUserTypes,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validation rules from your original code
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
            'App_Users' => $request->input('end_users'), // Assuming 'App_Users' and 'EndUserType' can use the same input
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
            'Status' => 'Level 01', 
        ]);

        return redirect()->route('internal-solutions.index', ['status' => 'in-progress'])
                         ->with('success', 'New internal solution added successfully!');
    }

     /**
     * Show the form for editing the specified resource.
     */
    public function edit(InternalPlatform $solution)
    {
        $mainApplications = InternalPlatform::where('App_Category', 'Main Application')->orderBy('App_Name')->get();
        $employees = Employee::orderBy('Emp_Name')->get();
        $sdlcPhases = SDLCphase::orderBy('OrderSeq')->get();
        $applicationGroups = ParentProject::orderBy('ParentProjectGroup')->get();
        $endUserTypes = TargetEndUser::orderBy('EndUserType')->get(); // <-- Fetch end user types
        
        // Fetch the latest comment for the solution
        $latestComment = $solution->comments()->first();

        return view('internal_solutions.edit', [
            'solution' => $solution,
            'mainApplications' => $mainApplications,
            'employees' => $employees,
            'sdlcPhases' => $sdlcPhases,
            'applicationGroups' => $applicationGroups,
            'endUserTypes' => $endUserTypes, 
            'latestComment' => $latestComment,  
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, InternalPlatform $solution)
    {
         $validatedData = $request->validate([
            'application_name' => 'required|string|max:255',
            'developed_by' => 'nullable|string|max:255',
            'developed_team' => 'nullable|string|max:255',
            'backup_person_primary' => 'nullable|string|max:255',
            'backup_person_secondary' => 'nullable|string|max:255',
            'start_date' => 'nullable|date',
            'target_date' => 'nullable|date|after_or_equal:start_date',
            'sdlc_phase' => 'nullable|string|max:255',
            'priority_level' => 'nullable|string|max:255',  
            'percentage_done' => 'nullable|integer|min:0|max:100',
            'integrated_applications' => 'nullable|string',
            'bitbucket_repo' => 'nullable|string|max:255',
            'dr_availability' => 'nullable|string|max:255',
            'server_ip' => 'nullable|string|max:255',
            'application_url' => 'nullable|url|max:255',
            'business_owner' => 'nullable|string|max:255',
            'end_users' => 'nullable|string|max:255',
            'user_specific_section' => 'nullable|string|max:255',
            'uat_date' => 'nullable|date',
            'va_date' => 'nullable|date',
            'launched_date' => 'nullable|date',
            'exposed_through_waf' => 'nullable|string|max:255',
            'solution_value' => 'nullable|numeric',
            'support_availability' => 'nullable|string|max:255',
            'comment' => 'nullable|string',  
        ]);
        
         
        $updateData = [];  
        
        // Map form names to database column names
        $updateData['App_Name'] = $request->input('application_name');
        $updateData['Developed_By'] = $request->input('developed_by');
        $updateData['Developed_Team'] = $request->input('developed_team');
        $updateData['BackupOfficer_1'] = $request->input('backup_person_primary');
        $updateData['BackupOfficer_2'] = $request->input('backup_person_secondary');
        $updateData['StartDate'] = $request->input('start_date');
        $updateData['TargetDate'] = $request->input('target_date');
        $updateData['SDLCPhase'] = $request->input('sdlc_phase');
        $updateData['PercentageDone'] = $request->input('percentage_done');
        $updateData['Integrated_apps'] = $request->input('integrated_applications');
        $updateData['BIT_bucket_repo'] = $request->input('bitbucket_repo');
        $updateData['DR'] = $request->input('dr_availability');
        $updateData['App_IP'] = $request->input('server_ip');
        $updateData['App_URL'] = $request->input('application_url');
        $updateData['Bus_Owner'] = $request->input('business_owner');
        $updateData['EndUserType'] = $request->input('end_users');
        $updateData['UserSpecificSection'] = $request->input('user_specific_section');
        $updateData['UATDate'] = $request->input('uat_date');
        $updateData['VADate'] = $request->input('va_date');
        $updateData['LaunchedDate'] = $request->input('launched_date');
        $updateData['WAF'] = $request->input('exposed_through_waf');
        $updateData['Price'] = $request->input('solution_value');
        $updateData['SLA'] = $request->input('support_availability');

         if ($request->filled('priority_level')) {
            $updateData['Status'] = $request->input('priority_level');
        }
        
        $solution->update($updateData);

        // Handle the comment
        if ($request->filled('comment')) {
            InternalProjectComment::create([
                'Solution_ID' => $solution->ID,
                'Comment' => $request->input('comment'),
                'Updated_By' => Auth::user()->name, // Assumes user is logged in and has a name
                'Updated_Time' => now(),
            ]);
        }

        // Redirect back to the index page of the current status
        $currentStatus = $solution->fresh()->SDLCPhase; // Get the potentially updated SDLC Phase
        $statusRoute = 'in-progress'; // default
        if (in_array($currentStatus, ['Maintenance'])) {
            $statusRoute = 'operational';
        } elseif (in_array($currentStatus, ['Retired'])) {
            $statusRoute = 'retired';
        } elseif (in_array($currentStatus, ['Abandoned'])) {
            $statusRoute = 'abandoned';
        }
        
        return redirect()->route('internal-solutions.index', ['status' => $statusRoute])->with('success', 'Solution updated successfully!');
    }

    /**
     * Show yearly contribution summary.
     */
    public function yearlyContribution()
    {
        // 1. Get all currently active projects.
        // We assume 'active' means they are in the 'Maintenance' phase, 
        // have a launch date, and have a price greater than zero.
        $activeProjects = InternalPlatform::where('SDLCPhase', 'Maintenance')
                                          ->whereNotNull('LaunchedDate')
                                          ->where('Price', '>', 0)
                                          ->orderBy('LaunchedDate', 'asc')
                                          ->get(['LaunchedDate', 'Price']);

        // If there are no active projects, return the view with empty data.
        if ($activeProjects->isEmpty()) {
            return view('internal_solutions.yearly_contribution', ['yearlyData' => []]);
        }

        // 2. Determine the year range for the report.
        $firstYear = Carbon::parse($activeProjects->first()->LaunchedDate)->year;
        $lastYear = Carbon::now()->year; // Report runs up to the current year.

        $yearlyData = [];
        $cumulativeValue = 0.00; // This will track the total value of projects from previous years.

        // 3. Loop through each year and calculate the values.
        for ($year = $firstYear; $year <= $lastYear; $year++) {
            
            // a) Calculate the total value of solutions launched IN THIS specific year.
            $newSolutionsValue = $activeProjects->filter(function ($project) use ($year) {
                return Carbon::parse($project->LaunchedDate)->year == $year;
            })->sum('Price');

            // b) Calculate the maintenance effort (10%) based on the cumulative value from ALL PREVIOUS years.
            $maintenanceValue = $cumulativeValue * 0.10;

            // c) Calculate the grand total for the year.
            $grandTotal = $newSolutionsValue + $maintenanceValue;

            // d) Add the calculated data for the year to our results array.
            $yearlyData[] = (object)[
                'year' => $year,
                'new_solutions_value' => $newSolutionsValue,
                'maintenance_value' => $maintenanceValue,
                'grand_total' => $grandTotal,
            ];

            // e) IMPORTANT: Add this year's new solution value to the cumulative total 
            //    so it can be used for the NEXT year's maintenance calculation.
            $cumulativeValue += $newSolutionsValue;
        }

        // 4. Send the data to the view. We reverse it to show the most recent year first.
        return view('internal_solutions.yearly_contribution', [
            'yearlyData' => collect($yearlyData) // It's already sorted ascending by year, no need to reverse if you want chronological order. Let's keep it chronological like the image.
        ]);
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

    public function yearlyContributionDetails($year)
    {
        // 1. Validate that the year is a valid number.
        if (!is_numeric($year) || $year < 1900 || $year > 2100) {
            abort(404, 'Invalid year provided.');
        }

        // 2. Fetch all active projects launched in or before the selected year.
        $projects = InternalPlatform::where('SDLCPhase', 'Maintenance')
                                    ->whereNotNull('LaunchedDate')
                                    ->where('Price', '>', 0)
                                    ->whereYear('LaunchedDate', '<=', $year) // Get projects launched up to this year
                                    ->orderBy('LaunchedDate', 'asc')
                                    ->get();

        // 3. Process the collection to add calculated values for the view.
        $projectsForYear = $projects->map(function ($project) use ($year) {
            $launchedYear = Carbon::parse($project->LaunchedDate)->year;

            // a) Value for the year (only if launched in the selected year)
            $project->value_for_the_year = ($launchedYear == $year) ? $project->Price : 0;

            // b) Maintenance effort (10% only if launched in a previous year)
            $project->maintenance_effort = ($launchedYear < $year) ? ($project->Price * 0.10) : 0;
            
            // Add launched year for easy display
            $project->launched_year = $launchedYear;

            return $project;
        });

        // 4. Pass the data to the new view file.
        return view('internal_solutions.yearly_contribution_details', [
            'year' => $year,
            'projects' => $projectsForYear,
        ]);
    }


    /**
     * Handle the export of all internal solutions to an Excel file.
     */
    public function exportAll()
    {
        
        return Excel::download(new InternalSolutionsExport, 'internal-solutions-all.xlsx');
    }

}