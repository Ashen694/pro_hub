<?php

namespace App\Exports;

use App\Models\InternalPlatform;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Support\Collection;

class InternalBackupMatrixExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    protected $developers;
    protected $solutions;

    public function __construct()
    {
        // Get all solutions with backup officers
        $this->solutions = InternalPlatform::where(function ($query) {
                $query->whereNotNull('BackupOfficer_1')
                      ->orWhereNotNull('BackupOfficer_2');
            })
            ->orderBy('App_Name', 'asc')
            ->get();

        // Create a unique, sorted list of all developers
        $primaryOfficers = $this->solutions->pluck('BackupOfficer_1');
        $secondaryOfficers = $this->solutions->pluck('BackupOfficer_2');

        $this->developers = $primaryOfficers
            ->merge($secondaryOfficers)
            ->filter() // Remove any null or empty strings
            ->unique()
            ->sort()
            ->values(); // Reset keys to be indexed from 0
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->solutions;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        // The first heading is 'App_Name', followed by all developer names
        return array_merge(['App_Name'], $this->developers->toArray());
    }

    /**
     * @param mixed $solution
     * @return array
     */
    public function map($solution): array
    {
        $row = [$solution->App_Name];

        // For each developer in our headings list, check their role for the current solution
        foreach ($this->developers as $developer) {
            if ($developer === $solution->BackupOfficer_1) {
                $row[] = 'Primary';
            } elseif ($developer === $solution->BackupOfficer_2) {
                $row[] = 'Secondary';
            } else {
                $row[] = ''; // Empty cell if they are not a backup for this app
            }
        }
        return $row;
    }
}