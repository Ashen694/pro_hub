<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Freelancer;  

class DashboardController extends Controller
{
    
    public function index()
    {
        $employeeCount = Employee::count();
        $freelancerCount = Freelancer::count();  

        return view('dashboard', [
            'employeeCount' => $employeeCount,
            'freelancerCount' => $freelancerCount  
        ]);
    }
}