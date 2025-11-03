<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InternalIssue;
use App\Models\InternalPlatform;
use App\Models\Employee;

class InternalIssueController extends Controller
{
    public function index()
    {
        $issues = InternalIssue::orderBy('ID', 'desc')->get();
        return view('report-incidents.internal.index', compact('issues'));
    }

    public function create()
    {
        $platforms = InternalPlatform::orderBy('App_Name')->get();
        $employees = Employee::orderBy('Emp_Name')->get();
        return view('report-incidents.internal.create', compact('platforms', 'employees'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'Issue_Start_Time' => 'required|date',
            'Internal_APP_ID' => 'required|string',  
            'Reported_By' => 'required|string',
            'Reporting_Person_ContactNo' => 'nullable|string',  
            'Description' => 'required|string',
            'Criticality' => 'required|string',
            'Entered_By' => 'required|string',
            'Assigned_To' => 'required|string',
            'Assigned_By' => 'required|string',
            'Assigned_Time' => 'nullable|date',
            'Status' => 'required|string',
            'Action_Taken' => 'nullable|string',
            'Issue_Closed_Time' => 'nullable|date',
        ]);

        InternalIssue::create($validated);
        return redirect()->route('incidents.internal.index')->with('success', 'Internal issue has been created successfully!');
    }

    public function show($id)
    {
        $issue = InternalIssue::findOrFail($id);
        return view('report-incidents.internal.show', compact('issue'));
    }

    public function edit($id)
    {
        $issue = InternalIssue::findOrFail($id);
        $platforms = InternalPlatform::orderBy('App_Name')->get();
        $employees = Employee::orderBy('Emp_Name')->get();
        return view('report-incidents.internal.edit', compact('issue', 'platforms', 'employees'));
    }

    public function update(Request $request, $id)
    {
        $issue = InternalIssue::findOrFail($id);
        $validated = $request->validate([
            'Issue_Start_Time' => 'required|date',
            'Internal_APP_ID' => 'required|string', 
            'Reported_By' => 'required|string',
            'Reporting_Person_ContactNo' => 'nullable|string',  
            'Description' => 'required|string',
            'Criticality' => 'required|string',
            'Entered_By' => 'required|string',
            'Assigned_To' => 'required|string',
            'Assigned_By' => 'required|string',
            'Assigned_Time' => 'nullable|date',
            'Status' => 'required|string',
            'Action_Taken' => 'nullable|string',
            'Issue_Closed_Time' => 'nullable|date',
        ]);

        $issue->update($validated);
        return redirect()->route('incidents.internal.index')->with('success', 'Internal issue has been updated successfully!');
    }

    public function destroy($id)
    {
        $issue = InternalIssue::findOrFail($id);
        $issue->delete();
        return redirect()->route('incidents.internal.index')->with('success', 'Internal issue has been deleted successfully!');
    }
}