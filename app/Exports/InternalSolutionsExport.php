<?php

namespace App\Exports;

use App\Models\InternalPlatform;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class InternalSolutionsExport implements FromQuery, WithHeadings, WithMapping, WithStyles
{
    /**
    * @return \Illuminate\Database\Query\Builder
    */
    public function query()
    {
    
        return InternalPlatform::query()->orderBy('App_Name', 'asc');
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        // These will be the column headers in the Excel file.
        return [
            'ID',
            'Application Name',
            'Application Category',
            'Application Group',
            'SDLC Phase',
            'Developed By',
            'Developed Team',
            'Business Owner',
            'Start Date',
            'Target Date',
            'Launched Date',
            'Solution Value (Price)',
            'Status',
            'Application URL',
        ];
    }

    /**
     * @param mixed $solution
     * @return array
     */
    public function map($solution): array
    {
        // This maps each record from the database to a row in the Excel file.
        // The order MUST match the headings() array.
        return [
            $solution->ID,
            $solution->App_Name,
            $solution->App_Category,
            $solution->parentProject->ParentProjectGroup ?? 'N/A',  
            $solution->SDLCPhase ?? 'N/A',
            $solution->Developed_By ?? 'N/A',
            $solution->Developed_Team ?? 'N/A',
            $solution->Bus_Owner ?? 'N/A',
            $solution->StartDate,
            $solution->TargetDate,
            $solution->LaunchedDate,
            $solution->Price,  
            $solution->Status ?? 'N/A',
            $solution->App_URL ?? 'N/A',
        ];
    }

    /**
     * @param Worksheet $sheet
     * @return array
     */
    public function styles(Worksheet $sheet)
    {
        // This makes the first row (the headings) bold.
        return [
            1    => ['font' => ['bold' => true]],
        ];
    }
}