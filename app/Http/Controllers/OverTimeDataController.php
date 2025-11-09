<?php

namespace App\Http\Controllers;

use App\Models\OverTimeData;
use App\Models\Employee; // For 'Approval For' dropdown
use App\Models\User;     // To be used by the 'creator' relationship
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class OverTimeDataController extends Controller
{
    public function index(Request $request)
    {
        $query = OverTimeData::with(['creator', 'approvalForUser', 'approver'])
                            ->orderBy('Created_Date', 'desc');

        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('Work_Description', 'like', '%' . $searchTerm . '%')
                  // Search creator's name from 'users' table
                  ->orWhereHas('creator', function($userQuery) use ($searchTerm) {
                      $userQuery->where('name', 'like', '%' . $searchTerm . '%'); // Searches the 'name' column
                  })
                  // Search approver's name from 'Employee' table
                  ->orWhereHas('approvalForUser', function($empQuery) use ($searchTerm) {
                      $empQuery->where('Emp_Name', 'like', '%' . $searchTerm . '%');
                  });
            });
        }

        $overtimes = $query->paginate(10)->withQueryString();
        return view('project-activities.overtime.index', compact('overtimes'));
    }

    public function create()
    {
        // For the dropdown, we only need employees
        $employees = Employee::orderBy('Emp_Name')->get();
        return view('project-activities.overtime.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'date' => 'required|date',
            'no_of_hours' => 'required|numeric|min:0.01',
            'work_description' => 'required|string|max:2000',
            // Validation for 'Approval For' still points to Employee table
            'approval_for' => 'required|exists:Employee,Emp_ID',
        ]);

        try {
            OverTimeData::create([
                'Created_By' => Auth::id(), // This correctly gets the logged-in USER's ID
                'Date' => $validatedData['date'],
                'No_Of_Hours' => $validatedData['no_of_hours'],
                'Work_Description' => $validatedData['work_description'],
                'Approval_For' => $validatedData['approval_for'],
            ]);
            return redirect()->route('project-activities.overtime.index')->with('success', 'Overtime record created successfully.');
        } catch (\Exception $e) {
            Log::error('Overtime Store Error: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Failed to create record. Please try again.');
        }
    }

    // Other methods (edit, update, destroy) remain largely the same, but we'll include them for completeness.

    public function edit(OverTimeData $overtime)
    {
        $employees = Employee::orderBy('Emp_Name')->get();
        return view('project-activities.overtime.edit', compact('overtime', 'employees'));
    }
    
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OverTimeData $overtime)
    {
        $validatedData = $request->validate([
            'Comment' => 'nullable|string|max:2000',
        ]);

        try {
            $overtime->update($validatedData);
            return redirect()->route('project-activities.overtime.index')->with('success', 'Overtime record updated successfully.');

        } catch (\Exception $e) {
            Log::error('Overtime Update Error: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Failed to update record. Please try again.');
        }
    }

    public function destroy(OverTimeData $overtime)
    {
        $overtime->delete();
        return redirect()->route('project-activities.overtime.index')->with('success', 'Overtime record deleted successfully.');
    }
}