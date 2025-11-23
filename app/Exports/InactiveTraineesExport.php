<?php

namespace App\Exports;

use App\Models\Trainee;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class InactiveTraineesExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Trainee::inactive()->orderBy('Trainee_ID', 'desc')->get();
    }

    /**
     * @return array
     */
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

    /**
     * @param mixed $trainee
     * @return array
     */
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
            ucfirst($trainee->status ?? 'inactive'),
        ];
    }

    /**
     * @return array
     */
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

    /**
     * @param Worksheet $sheet
     * @return array
     */
    public function styles(Worksheet $sheet)
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
}
