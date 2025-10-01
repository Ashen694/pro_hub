<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConsumerServicePlatformController extends Controller
{
    /**
     * Display a listing of the consumer service platforms.
     */
    public function index()
    {
        $platforms = $this->getDummyData();

        return view('consumer_service_platforms.index', [
            'platforms' => $platforms
        ]);
    }

    /**
     * Helper function to create dummy data for this specific view.
     */
    private function getDummyData()
    {
        $data = [];
        $phases = ['Maintenance', 'Retired', 'Coding or Implementation', 'Abandoned', 'Deployment'];
        $endUsers = ['Public', 'SLT Employees'];

        for ($i = 1; $i <= 20; $i++) {
            $data[] = (object)[
                'application_name' => 'Consumer Platform ' . $i,
                'developed_by' => 'Vendor ' . chr(64 + $i), // Vendor A, Vendor B etc.
                'application_end_users' => $endUsers[array_rand($endUsers)],
                'solution_value' => rand(50000, 100000),
                'sdlc_phase' => $phases[array_rand($phases)],
            ];
        }
        
        return new \Illuminate\Pagination\LengthAwarePaginator(collect($data), count($data), 10, 1);
    }
}