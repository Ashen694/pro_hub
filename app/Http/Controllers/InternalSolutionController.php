<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InternalSolutionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($status)
    {
        // We will create dummy data for now
        $solutions = $this->getDummyData($status);
        
        // Change the page title based on the status from the URL
        $title = 'Internal Solutions - ' . ucfirst($status);

        // Decide which table partial to show based on the status
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

            default: // This will handle 'operational' and any other status
                $viewPartial = '_table_operational';
                break;
        }

        // We will pass the title, status, partial name, and data to the view
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
        return view('internal_solutions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return redirect()->route('internal-solutions.index', ['status' => 'operational'])
                         ->with('success', 'New internal solution added successfully!');
    }
    
    /**
     * A helper function to create some dummy data.
     * In a real application, this data would come from the database.
     */
    // This is the correct, updated function that accepts a parameter
    private function getDummyData($status)
    {
        $data = [];
        $groups = ['BILLING SUPPORT', 'CUSTOMER EXPERIENCE', 'PROCESS AUTOMATION', 'ENTERPRISE PORTAL'];
        for ($i = 1; $i <= 15; $i++) {
            $data[] = (object)[
                // Data for operational view
                'application_group' => $groups[array_rand($groups)],
                'application_name' => 'Dummy Solution ' . $i,
                'developed_by' => 'In-house Team',
                'va_date' => now()->subMonths($i)->addDays(10)->format('Y-m-d'),
                
                // Data for retired view
                'launched_date' => now()->subMonths($i)->format('Y-m-d'),
                'sdlc_phase' => 'Retired',
                'solution_value' => rand(10000, 50000),
                'comment' => 'This is a test comment.'
            ];
        }
        return new \Illuminate\Pagination\LengthAwarePaginator(collect($data), count($data), 10, 1);
    }

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

        // Reverse the array to show the most recent year at the bottom, like in the screenshot
        $yearlyData = array_reverse($yearlyData);

        return view('internal_solutions.yearly_contribution', [
            'yearlyData' => $yearlyData
        ]);
    }

}