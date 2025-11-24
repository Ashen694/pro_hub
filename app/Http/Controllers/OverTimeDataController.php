<?php

namespace App\Http\Controllers;

use App\Models\OverTimeData;
use App\Models\Employee;  
use App\Models\User;      
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
                      $userQuery->where('name', 'like', '%' . $searchTerm . '%');  
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
        $employees = Employee::orderBy('Emp_Name')->get();
        return view('project-activities.overtime.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'date' => 'required|date',
            'no_of_hours' => 'required|numeric|min:0.01',
            'work_description' => 'required|string|max:2000',
            'approval_for' => 'required|exists:Employee,Emp_ID',
        ]);

        try {
            OverTimeData::create([
                'Created_By' => Auth::id(), 
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
            'Comment'       => 'nullable|string|max:2000',
            'Approved_By'   => 'nullable|exists:Employee,Emp_ID', 
            'Approved_Date' => 'nullable|date',                   
        ]);

        try {
            $overtime->update([
                'Comment'       => $validatedData['Comment'],
                'Approved_By'   => $validatedData['Approved_By'],
                'Approved_Date' => $validatedData['Approved_Date'],
            ]);

            return redirect()->route('project-activities.overtime.index')
                            ->with('success', 'Overtime record updated successfully.');

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