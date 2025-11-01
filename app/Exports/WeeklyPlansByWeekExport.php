<?php

namespace App\Exports;

use App\Models\WeeklyPlan;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

class WeeklyPlansByWeekExport implements
    FromQuery,
    WithHeadings,
    WithMapping,
    ShouldAutoSize,
    WithStyles,
    WithEvents
{
    protected Builder $builder;
    protected ?Carbon $startDate;
    protected ?Carbon $endDate;
    protected string $scope;

    /**
     * Accept the already-prepared query from the controller.
     * Example:
     * Excel::download(new WeeklyPlansByWeekExport($q, $startDate, $endDate, $scope), $file);
     */
    public function __construct(Builder $builder, $startDate = null, $endDate = null, string $scope = 'all')
    {
        $this->builder   = $builder;
        $this->startDate = $startDate instanceof Carbon ? $startDate : ($startDate ? Carbon::parse($startDate) : null);
        $this->endDate   = $endDate   instanceof Carbon ? $endDate   : ($endDate   ? Carbon::parse($endDate)   : null);
        $this->scope     = $scope;
    }

    public function query()
    {
        // Controller already applied filters/scope; just ensure relations are eager-loaded.
        return $this->builder->with(['employee','externalPlatforms','internalPlatforms']);
    }

    public function headings(): array
    {
        return [
            'Week',
            'Employee Name',
            'External Platform/Solution',
            'Internal Platform/Solution',
            'Work Plan Details',
        ];
    }

    public function map($plan): array
    {
        $s = Carbon::parse($plan->start_date)->format('d/m/Y');
        $e = Carbon::parse($plan->end_date)->format('d/m/Y');

        $empName = optional($plan->employee)->emp_name
                ?? optional($plan->employee)->emp_email
                ?? ($plan->updated_by ?? '');

        $ext = collect($plan->externalPlatforms)->pluck('platform_name')->filter()->implode(', ');
        $int = collect($plan->internalPlatforms)->pluck('app_name')->filter()->implode(', ');

        return [
            "{$s} - {$e}",
            $empName,
            $ext ?: '—',
            $int ?: '—',
            (string) $plan->workplan_desc,
        ];
    }

    /* ---------------- Styling & Events (same feel as Backup Matrix) ---------------- */

    /** Header & base styles */
    public function styles(Worksheet $sheet)
    {
        // Determine the actual last column (handles future column changes gracefully)
        $highestColumn = $sheet->getHighestColumn(); // likely "E"

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

    /** Freeze header + AutoFilter after sheet creation */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // Freeze header row
                $event->sheet->freezePane('A2');

                // Auto filter on the header row
                $highestColumn = $event->sheet->getHighestColumn();
                $event->sheet->getDelegate()->setAutoFilter("A1:{$highestColumn}1");

                // Reasonable default row height for wrapped text
                $event->sheet->getDelegate()->getDefaultRowDimension()->setRowHeight(18);
            },
        ];
    }
}
