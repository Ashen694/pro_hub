<?php

namespace App\Http\Controllers;

use App\Models\ExternalIssue;
use App\Models\ExternalPlatform;
use App\Models\Employee;
use App\Models\CustomerContact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 

class ExternalIssueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $issues = ExternalIssue::join('external_platforms', 'external_issues.Platform_ID', '=', 'external_platforms.platform_id')
                    ->select('external_issues.*', 'external_platforms.platform_name')
                    ->latest('external_issues.ID')
                    ->get();

        return view('report-incidents.external.index', compact('issues'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $platforms = ExternalPlatform::orderBy('platform_name')->get();
        $employees = Employee::orderBy('Emp_Name')->get();
        $contacts = CustomerContact::orderBy('name')->get();

        return view('report-incidents.external.create', compact('platforms', 'employees', 'contacts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'Issue_Start_Time' => 'required|date',
            'Platform_ID' => 'required|exists:external_platforms,platform_id',
            'Reported_By' => 'required|string',
            'Description' => 'required|string',
            'Criticality' => 'required|string',
            'Assigned_To' => 'required|string',
            'Assigned_By' => 'required|string',
            'Assigned_Time' => 'nullable|date',
            'Status' => 'required|string',
            'Action_Taken' => 'nullable|string',
            'Issue_Closed_Time' => 'nullable|date',
        ]);

        $validated['Entered_By'] = Auth::user()->name;

        ExternalIssue::create($validated);

        return redirect()->route('incidents.external.index')->with('success', 'External issue added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $issue = ExternalIssue::join('external_platforms', 'external_issues.Platform_ID', '=', 'external_platforms.platform_id')
            ->select('external_issues.*', 'external_platforms.platform_name')
            ->where('external_issues.ID', $id)
            ->firstOrFail();

        return view('report-incidents.external.show', compact('issue'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $issue = ExternalIssue::findOrFail($id);
        $platforms = ExternalPlatform::orderBy('platform_name')->get();
        $employees = Employee::orderBy('Emp_Name')->get();
        $contacts = CustomerContact::orderBy('name')->get();

        return view('report-incidents.external.edit', compact('issue', 'platforms', 'employees', 'contacts'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'Issue_Start_Time' => 'required|date',
            'Platform_ID' => 'required|exists:external_platforms,platform_id',
            'Reported_By' => 'required|string',
            'Description' => 'required|string',
            'Criticality' => 'required|string',
            'Assigned_To' => 'required|string',
            'Assigned_By' => 'required|string',
            'Assigned_Time' => 'nullable|date',
            'Status' => 'required|string',
            'Action_Taken' => 'nullable|string',
            'Issue_Closed_Time' => 'nullable|date',
        ]);

        $issue = ExternalIssue::findOrFail($id);
        $issue->update($validated);

        return redirect()->route('incidents.external.index')->with('success', 'External issue updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $issue = ExternalIssue::findOrFail($id);
        $issue->delete();

        return redirect()->route('incidents.external.index')->with('success', 'External issue deleted successfully!');
    }
}