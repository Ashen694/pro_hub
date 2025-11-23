<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Employee;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;  

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = DB::table('users')
            ->join('Employee', 'users.email', '=', 'Employee.Emp_Email')
            ->select('users.id as user_id', 'users.name', 'users.email', 'users.role', 'Employee.*')
            ->get();

        return view('employees.index', compact('employees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            
            'email' => 'required|email|unique:users,email|unique:Employee,Emp_Email',
            'role' => 'required|string',
            'phone' => 'nullable|string',
        ]);

        
        $tempName = explode('@', $request->email)[0]; 

        try {
            
            DB::transaction(function () use ($request, $tempName) {
                
                User::create([
                    'name' => $tempName,  
                    'email' => $request->email,
                    'role' => $request->role,
                    'password' => Hash::make(Str::random(60)),
                ]);

                Employee::create([
                    'Emp_Name' => $tempName,  
                    'Emp_Email' => $request->email,
                    'Emp_Phone' => $request->phone,
                    'Calling_Name' => $request->calling_name,
                    'DOB' => $request->dob,
                    'Gender' => $request->gender,
                    'Section' => $request->section,
                ]);
            });

            return redirect()->route('employees.index')->with('success', 'Employee registered successfully!');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Registration failed: ' . $e->getMessage());
        }
    }

     public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $employee = Employee::where('Emp_Email', $user->email)->first();

     
        $isActive = ($request->role === 'Inactive_user') ? 0 : 1;

        try {
            DB::transaction(function () use ($request, $user, $employee, $isActive) {
                // Update User Table
                $user->update([
                    'name' => $request->name,
                    'role' => $request->role,
                    'is_active' => $isActive, 
                ]);

                // Update Employee Table
                if($employee) {
                    $employee->update([
                        'Emp_Name' => $request->name,
                        'Emp_Phone' => $request->phone,
                        'Calling_Name' => $request->calling_name,
                        'DOB' => $request->dob,
                        'Gender' => $request->gender,
                        'Section' => $request->section,
                    ]);
                }
            });

            return redirect()->route('employees.index')->with('success', 'Employee updated successfully!');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Update failed: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $email = $user->email;

        try {
            DB::transaction(function () use ($user, $email) {
                $user->delete();
                Employee::where('Emp_Email', $email)->delete();
            });

            return redirect()->route('employees.index')->with('success', 'Employee deleted successfully!');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Deletion failed: ' . $e->getMessage());
        }
    }
}