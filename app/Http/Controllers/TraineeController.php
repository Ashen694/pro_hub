<?php

namespace App\Http\Controllers;

use App\Models\Trainee;
use App\Exports\ActiveTraineesExport;
use App\Exports\InactiveTraineesExport;
use App\Exports\PaidTraineesExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class TraineeController extends Controller
{
    /**
     * Display active trainees
     */
    public function index()
    {
        $trainees = Trainee::active()->orderBy('Trainee_ID', 'desc')->get();
        return view('trainees.index', compact('trainees'));
    }

    /**
     * Display inactive trainees
     */
    public function inactive()
    {
        $trainees = Trainee::inactive()->orderBy('Trainee_ID', 'desc')->get();
        return view('trainees.inactive', compact('trainees'));
    }

    /**
     * Display paid trainees
     */
    public function paid()
    {
        $trainees = Trainee::paid()->orderBy('Trainee_ID', 'desc')->get();
        return view('trainees.paid', compact('trainees'));
    }

    /**
     * Store a newly created trainee
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'Trainee_Name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'Trainee_Phone' => 'nullable|regex:/^0[0-9]{9}$/|digits:10',
            'Trainee_NIC' => 'nullable|string|max:50',
            'Trainee_Email' => 'nullable|email:rfc|max:255|regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
            'Training_StartDate' => 'nullable|date',
            'Training_EndDate' => 'nullable|date',
            'Institute' => 'nullable|string|max:255',
            'Languages_known' => 'nullable|string|max:255',
            'Supervisor' => 'nullable|string|max:255',
            'Target_Date' => 'nullable|date',
            'Trainee_HomeAddress' => 'nullable|string',
            'AssignedWork_Description' => 'nullable|string',
            'field_of_specialization' => 'nullable|string|max:255',
        ], [
            'Trainee_Name.regex' => 'Name should contain only letters and spaces',
            'Trainee_Phone.regex' => 'Mobile number must be 10 digits starting with 0',
            'Trainee_Phone.digits' => 'Mobile number must be exactly 10 digits',
            'Trainee_Email.regex' => 'Please enter a valid email address with @',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Create trainee with default active status
            $trainee = Trainee::create($request->all());
            
            // Auto-set status based on training end date
            if ($request->filled('Training_EndDate')) {
                $endDate = \Carbon\Carbon::parse($request->Training_EndDate);
                $today = \Carbon\Carbon::today();
                
                if ($endDate->lte($today)) {
                    // Training has ended, set to inactive
                    $trainee->status = 'inactive';
                    $trainee->terminated_date = $endDate;
                    $trainee->terminated_reason = 'Training period completed';
                    $trainee->save();
                }
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Trainee created successfully',
                'trainee' => $trainee
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create trainee: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified trainee
     */
    public function show($id)
    {
        try {
            $trainee = Trainee::findOrFail($id);
            
            return response()->json([
                'success' => true,
                'trainee' => $trainee
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Trainee not found'
            ], 404);
        }
    }

    /**
     * Update the specified trainee
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'Trainee_Name' => 'sometimes|required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'Trainee_Phone' => 'nullable|regex:/^0[0-9]{9}$/|digits:10',
            'Trainee_NIC' => 'nullable|string|max:50',
            'Trainee_Email' => 'nullable|email:rfc|max:255|regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
            'Training_StartDate' => 'nullable|date',
            'Training_EndDate' => 'nullable|date',
            'Institute' => 'nullable|string|max:255',
            'Languages_known' => 'nullable|string|max:255',
            'Supervisor' => 'nullable|string|max:255',
            'Target_Date' => 'nullable|date',
            'Trainee_HomeAddress' => 'nullable|string',
            'AssignedWork_Description' => 'nullable|string',
            'field_of_specialization' => 'nullable|string|max:255',
            'payment_start_date' => 'nullable|date',
            'payment_end_date' => 'nullable|date',
            'requested_payment_date' => 'nullable|date',
            'absent_Count' => 'nullable|integer|min:0',
            'terminated_date' => 'nullable|date',
            'terminated_reason' => 'nullable|string',
            'status' => 'nullable|in:active,inactive,paid',
        ], [
            'Trainee_Name.regex' => 'Name should contain only letters and spaces',
            'Trainee_Phone.regex' => 'Mobile number must be 10 digits starting with 0',
            'Trainee_Phone.digits' => 'Mobile number must be exactly 10 digits',
            'Trainee_Email.regex' => 'Please enter a valid email address with @',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $trainee = Trainee::findOrFail($id);
            
            // Update basic fields
            $trainee->update($request->all());
            
            // Auto-set status to 'paid' if payment dates are filled
            if ($request->filled('payment_start_date') && $request->filled('payment_end_date')) {
                $trainee->status = 'paid';
            }
            
            // Auto-set terminated_date if Training_EndDate has passed and terminated_date is not manually set
            if ($request->filled('Training_EndDate') && !$request->filled('terminated_date')) {
                $endDate = \Carbon\Carbon::parse($request->Training_EndDate);
                if ($endDate->lte(\Carbon\Carbon::today())) { // Include today's date
                    $trainee->terminated_date = $endDate;
                    if (!$trainee->terminated_reason) {
                        $trainee->terminated_reason = 'Training period completed';
                    }
                    // Set status to inactive if not already paid
                    if ($trainee->status !== 'paid') {
                        $trainee->status = 'inactive';
                    }
                }
            }
            
            $trainee->save();
            
            return response()->json([
                'success' => true,
                'message' => 'Trainee updated successfully',
                'trainee' => $trainee
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update trainee: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified trainee
     */
    public function destroy($id)
    {
        try {
            $trainee = Trainee::findOrFail($id);
            $trainee->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Trainee deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete trainee: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update trainee status
     */
    public function updateStatus(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:active,inactive,paid',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $trainee = Trainee::findOrFail($id);
            $trainee->status = $request->status;
            $trainee->save();
            
            return response()->json([
                'success' => true,
                'message' => 'Trainee status updated successfully',
                'trainee' => $trainee
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update status: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Export active trainees to Excel
     */
    public function exportActive()
    {
        return Excel::download(new ActiveTraineesExport, 'active_trainees_' . date('Y-m-d_H-i-s') . '.xlsx');
    }

    /**
     * Export inactive trainees to Excel
     */
    public function exportInactive()
    {
        return Excel::download(new InactiveTraineesExport, 'inactive_trainees_' . date('Y-m-d_H-i-s') . '.xlsx');
    }

    /**
     * Export paid trainees to Excel
     */
    public function exportPaid()
    {
        return Excel::download(new PaidTraineesExport, 'paid_trainees.xlsx');
    }

    /**
     * Export all trainees as a workbook with 3 sheets: Active, Inactive, Paid
     */
    public function exportAll()
    {
        $export = new class implements \Maatwebsite\Excel\Concerns\WithMultipleSheets {
            public function sheets(): array
            {
                return [
                    'Active' => new ActiveTraineesExport(),
                    'Inactive' => new InactiveTraineesExport(),
                    'Paid' => new PaidTraineesExport(),
                ];
            }
        };

        return Excel::download($export, 'all_trainees_' . date('Y-m-d_H-i-s') . '.xlsx');
    }

    /**
     * Export terminated trainees (terminated_date and terminated_reason are set)
     */
    public function exportTerminated()
    {
        $export = new class implements 
            \Maatwebsite\Excel\Concerns\FromCollection,
            \Maatwebsite\Excel\Concerns\WithHeadings,
            \Maatwebsite\Excel\Concerns\WithMapping,
            \Maatwebsite\Excel\Concerns\WithStyles,
            \Maatwebsite\Excel\Concerns\WithColumnWidths
        {
            public function collection()
            {
                return \App\Models\Trainee::query()
                    ->whereNotNull('terminated_date')
                    ->whereNotNull('terminated_reason')
                    ->orderBy('Trainee_ID', 'desc')
                    ->get();
            }

            public function headings(): array
            {
                return [
                    'Trainee ID',
                    'Name',
                    'Phone',
                    'Email',
                    'Home Address',
                    'NIC',
                    'Training Start Date',
                    'Training End Date',
                    'Institute',
                    'Languages Known',
                    'Field of Specialization',
                    'Supervisor',
                    'Assigned Work',
                    'Target Date',
                    'Payment Start Date',
                    'Payment End Date',
                    'Terminated Date',
                    'Terminated Reason',
                    'Status',
                ];
            }

            public function map($trainee): array
            {
                return [
                    'T' . str_pad($trainee->Trainee_ID, 3, '0', STR_PAD_LEFT),
                    $trainee->Trainee_Name,
                    $trainee->Trainee_Phone ?? '-',
                    $trainee->Trainee_Email ?? '-',
                    $trainee->Trainee_HomeAddress ?? '-',
                    $trainee->Trainee_NIC ?? '-',
                    $trainee->Training_StartDate ? $trainee->Training_StartDate->format('Y-m-d') : '-',
                    $trainee->Training_EndDate ? $trainee->Training_EndDate->format('Y-m-d') : '-',
                    $trainee->Institute ?? '-',
                    $trainee->Languages_known ?? '-',
                    $trainee->field_of_specialization ?? '-',
                    $trainee->Supervisor ?? '-',
                    $trainee->AssignedWork_Description ?? '-',
                    $trainee->Target_Date ? $trainee->Target_Date->format('Y-m-d') : '-',
                    $trainee->payment_start_date ? $trainee->payment_start_date->format('Y-m-d') : '-',
                    $trainee->payment_end_date ? $trainee->payment_end_date->format('Y-m-d') : '-',
                    $trainee->terminated_date ? $trainee->terminated_date->format('Y-m-d') : '-',
                    $trainee->terminated_reason ?? '-',
                    ucfirst($trainee->status ?? '-'),
                ];
            }

            public function columnWidths(): array
            {
                return [
                    'A' => 12,
                    'B' => 20,
                    'C' => 15,
                    'D' => 25,
                    'E' => 25,
                    'F' => 15,
                    'G' => 18,
                    'H' => 18,
                    'I' => 25,
                    'J' => 20,
                    'K' => 25,
                    'L' => 20,
                    'M' => 30,
                    'N' => 18,
                    'O' => 18,
                    'P' => 18,
                    'Q' => 18,
                    'R' => 30,
                    'S' => 12,
                ];
            }

            public function styles(\PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $sheet)
            {
                return [
                    1 => [
                        'font' => ['bold' => true, 'size' => 12],
                        'fill' => [
                            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                            'startColor' => ['rgb' => '667eea'],
                        ],
                        'font' => ['color' => ['rgb' => 'FFFFFF'], 'bold' => true],
                    ],
                ];
            }
        };

        return Excel::download($export, 'terminated_trainees_' . date('Y-m-d_H-i-s') . '.xlsx');
    }

    /**
     * Manually update trainee statuses based on training end dates
     */
    public function updateStatuses()
    {
        try {
            // Get all active trainees whose training has ended
            $expiredTrainees = Trainee::where('status', 'active')
                ->whereNotNull('Training_EndDate')
                ->where('Training_EndDate', '<=', \Carbon\Carbon::today())
                ->get();

            $updatedCount = 0;

            foreach ($expiredTrainees as $trainee) {
                // Skip if already has payment info (should be paid status)
                if ($trainee->payment_start_date && $trainee->payment_end_date) {
                    continue;
                }

                // Update to inactive status
                $trainee->status = 'inactive';
                
                // Set terminated date if not already set
                if (!$trainee->terminated_date) {
                    $trainee->terminated_date = $trainee->Training_EndDate;
                }
                
                // Set terminated reason if not already set
                if (!$trainee->terminated_reason) {
                    $trainee->terminated_reason = 'Training period completed';
                }
                
                $trainee->save();
                $updatedCount++;
            }

            return response()->json([
                'success' => true,
                'message' => "Successfully updated {$updatedCount} trainee(s) to inactive status.",
                'updated_count' => $updatedCount
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update trainee statuses: ' . $e->getMessage()
            ], 500);
        }
    }
}
