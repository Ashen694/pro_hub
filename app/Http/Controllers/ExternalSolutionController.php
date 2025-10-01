<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExternalSolutionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($status)
    {
        $solutions = $this->getDummyData($status);
        $title = 'External Solutions - ' . ucfirst($status);

        // Decide which table partial to show based on the status
        $viewPartial = '';
        switch ($status) {
            case 'prospective':
                // We will create a new partial for this view
                $viewPartial = '_table_prospective';
                break;
            
            // Default will handle 'operational' and any other status
            default:
                $viewPartial = '_table_operational';
                break;
        }

        return view('external_solutions.index', [
            'solutions' => $solutions,
            'title' => $title,
            'status' => $status,
            'viewPartial' => $viewPartial,
        ]);
    }

    /**
     * Helper function to create dummy data for different views.
     */
    private function getDummyData($status)
    {
        $data = [];
        for ($i = 1; $i <= 15; $i++) {
            $item = (object)[
                'application_name' => ($status == 'prospective' ? 'Prospective App ' : 'External App ') . $i,
                'developed_by' => 'Vendor ' . chr(65 + $i),
                
                // Data for 'operational' view
                'launched_billed_on' => now()->subMonths($i * 2)->format('Y-m-d'),
                'revenue_sw_value' => number_format(rand(50000, 250000)),
                
                // Data for 'prospective' view
                'company_customer' => 'Customer ' . $i,
                'sdlc_stage' => 'Requirement Gathering',
                'start_date' => now()->addMonths($i)->format('Y-m-d'),
                'dpo_handover_date' => now()->addMonths($i + 1)->format('Y-m-d'),
            ];
            $data[] = $item;
        }
        
        return new \Illuminate\Pagination\LengthAwarePaginator(collect($data), count($data), 10, 1);
    }
}