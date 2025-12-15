<?php

namespace App\Exports;

use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

class BackupMatrixExport implements
    FromQuery,
    WithHeadings,
    WithMapping,
    ShouldAutoSize,
    WithStyles,
    WithEvents
{
    public function __construct(
        protected Builder $builder,
        protected string $scope = 'mine',
        protected string $requestedBy = ''
    ) {}

    /** Stream only the needed columns */
    public function query()
    {
        return $this->builder
            ->select([
                'App_Name',         
                'BackupOfficer_1', 
                'BackupOfficer_2',  
            ])
            ->orderBy('App_Name');  
    }

    public function headings(): array
    {
        return [
            'Application',
            'Backup #1',
            'Backup #2',
        ];
    }

    public function map($row): array
    {
        return [
            (string) ($row->App_Name ?? ''),        
            (string) ($row->BackupOfficer_1 ?? ''), 
            (string) ($row->BackupOfficer_2 ?? ''), 
        ];
    }

    /** Header & base styles */
    public function styles(Worksheet $sheet)
    {
        $highestColumn = $sheet->getHighestColumn(); 

        // Bold header
        $sheet->getStyle("A1:{$highestColumn}1")->getFont()->setBold(true);

        // Header fill (light blue)
        $sheet->getStyle("A1:{$highestColumn}1")->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFE8F0FF');

        // Bottom border for header
        $sheet->getStyle("A1:{$highestColumn}1")->getBorders()->getBottom()
            ->setBorderStyle(Border::BORDER_THIN);

        // Wrap text for all data columns
        $sheet->getStyle("A:{$highestColumn}")->getAlignment()->setWrapText(true);

        // Vertical-align top for all cells
        return [
            "A:{$highestColumn}" => [
                'alignment' => [
                    'vertical' => Alignment::VERTICAL_TOP,
                ],
            ],
        ];
    }

    /** Freeze header + AutoFilter */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // Freeze header row
                $event->sheet->freezePane('A2');

                // Auto filter on the header row
                $highestColumn = $event->sheet->getHighestColumn();
                $event->sheet->getDelegate()->setAutoFilter("A1:{$highestColumn}1");

                // Default row height for wrapped text
                $event->sheet->getDelegate()->getDefaultRowDimension()->setRowHeight(18);
            },
        ];
    }
}