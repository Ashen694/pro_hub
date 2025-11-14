<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProjectActivity;
use App\Models\ProjectComment; 
use App\Models\MainPlatform;
use App\Models\InternalPlatform;  
use App\Models\ExternalPlatform;  
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;

class ProjectActivityController extends Controller
{
    

    public function index(Request $request, $type)
    {
        $platformTypeMapping = [
            'internal' => 1,
            'external' => 2,
        ];

        if (!array_key_exists($type, $platformTypeMapping)) {
            abort(404);
        }

        $platformId = $platformTypeMapping[$type];

        // Eager load all relationships
        $query = ProjectActivity::with([
            'creator', 
            'assignee', 
            'updater', 
            'comments', 
            'internalSolution', 
            'externalSolution'
        ])->where('Platform_ID', $platformId);

        // Handle Search Functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('Description', 'like', '%' . $search . '%')
                // Search creator's name from 'users' table via 'creator' relationship
                ->orWhereHas('creator', function($userQuery) use ($search) {
                    $userQuery->where('name', 'like', '%' . $search . '%');  
                })
                // Search assignee's name from 'Employee' table via 'assignee' relationship
                ->orWhereHas('assignee', function($empQuery) use ($search) {
                    $empQuery->where('Emp_Name', 'like', '%' . $search . '%');
                });
            });
        }
        
        $activities = $query->orderBy('Created_Time', 'desc')->paginate(10);

        $pageTitle = ucwords(str_replace('-', ' ', $type)) . ' Activities';
        
        return view("project-activities.{$type}.index", compact('activities', 'pageTitle', 'type'));
    }


    public function create($type)
    {
        $platforms = MainPlatform::all();
        $employees = Employee::orderBy('Emp_Name')->get();
        
        if ($type === 'internal') {
            $solutions = InternalPlatform::orderBy('App_Name')->get(); 
        } else {
            $solutions = ExternalPlatform::orderBy('platform_name')->get();
        }
                
        $pageTitle = 'Create '.ucfirst($type). ' Activity';
        
        return view('project-activities.create', compact('type', 'pageTitle', 'platforms', 'solutions', 'employees'));
    }

 
    public function store(Request $request, $type)
    {
        $request->validate([
            'Platform_ID' => 'required|exists:Main_Platforms,ID',
            'Solution_ID' => 'required|integer',
            'Description' => 'required|string|max:4000',
            'Assigned_To' => 'required|exists:Employee,Emp_ID', 
            'Target_Date' => 'required|date',
        ]);
        
        $activity = new ProjectActivity();
        $activity->Platform_ID = $request->Platform_ID;
        $activity->Solution_ID = $request->Solution_ID;
        $activity->Description = $request->Description;
        
        $activity->Created_By = Auth::id(); 
        
        $activity->Assigned_To = $request->Assigned_To;
        $activity->Target_Date = $request->Target_Date;
        $activity->Status = 'Open';
        
        $activity->save();

        return redirect()->route('project-activities.index', ['type' => $type])
                        ->with('success', 'Activity created successfully.');
    }

    public function show(ProjectActivity $activity)
    {
        // Eager load all necessary relationships
        $activity->load(['creator', 'assignee', 'updater', 'internalSolution', 'externalSolution']);

        // Determine the solution name based on Platform_ID
        $solutionName = 'N/A';
        if ($activity->Platform_ID == 1 && $activity->internalSolution) {
            $solutionName = $activity->internalSolution->App_Name;
        } elseif ($activity->Platform_ID == 2 && $activity->externalSolution) {
            $solutionName = $activity->externalSolution->platform_name;
        }

        // Prepare data for the JSON response
        $data = [
            'id' => $activity->ID,
            'solution_name' => $solutionName,
            'description' => nl2br(e($activity->Description)), 
            'created_by' => $activity->creator->name ?? 'N/A',
            'created_time' => \Carbon\Carbon::parse($activity->Created_Time)->format('Y-m-d h:i A'),
            'assigned_to' => $activity->assignee->Emp_Name ?? 'N/A',
            'target_date' => \Carbon\Carbon::parse($activity->Target_Date)->format('Y-m-d'),
            'status' => $activity->Status,
            'updated_by' => $activity->updater->name ?? 'Not updated yet',
            'updated_date' => $activity->Updated_Date ? \Carbon\Carbon::parse($activity->Updated_Date)->format('Y-m-d h:i A') : 'Not updated yet',
        ];

        return response()->json($data);
    }

    public function edit(ProjectActivity $activity)
    {
        $type = ($activity->Platform_ID == 1) ? 'internal' : 'external';

        // Fetch data for dropdowns 
        $employees = \App\Models\Employee::orderBy('Emp_Name')->get();
        if ($type === 'internal') {
            $solutions = \App\Models\InternalPlatform::orderBy('App_Name')->get(); 
        } else {
            $solutions = \App\Models\ExternalPlatform::orderBy('platform_name')->get();
        }

        $pageTitle = 'Edit ' . ucfirst($type) . ' Activity (ID: ' . $activity->ID . ')';
        
        return view('project-activities.edit', compact('activity', 'type', 'pageTitle', 'solutions', 'employees'));
    }


    public function update(Request $request, ProjectActivity $activity)
    {
        $validated = $request->validate([
            'Target_Date' => 'required|date',
            'Status' => 'required|string|in:Open,In Progress,Completed,On Hold,Close',
            'Comment' => 'nullable|string|max:2000',
        ]);

        $activity->Target_Date = $validated['Target_Date'];
        $activity->Status = $validated['Status'];
        
        $updaterId = auth()->id();
        
        $activity->Updated_By = $updaterId;
        $activity->Updated_Date = now();
        $activity->save();

        if ($request->filled('Comment')) {
            \App\Models\ProjectComment::create([
                'Activity_ID' => $activity->ID,
                'Comment' => $validated['Comment'],
                'Updated_By' => $updaterId, // Use the same User ID for the comment
            ]);
        }
        
        $type = ($activity->Platform_ID == 1) ? 'internal' : 'external';
        return redirect()->route('project-activities.index', ['type' => $type])
                        ->with('success', 'Activity ID: ' . $activity->ID . ' updated successfully.');
    }
   
    public function destroy(ProjectActivity $activity)
    {
        try {
            $activity->delete();
            return redirect()->route('project-activities.index', ['type' => ($activity->Platform_ID == 1 ? 'internal' : 'external')])
                             ->with('success', 'Activity ID: ' . $activity->ID . ' deleted successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete activity. Please try again.');
        }
    }





    
}