<?php

namespace App\Exports;

use App\Models\WeeklyPlan;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class WeeklyPlansExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
{
    public function query()
    {
        // Controller already restricts this to admins
        return WeeklyPlan::query()
            ->with(['employee','externalPlatforms','internalPlatforms'])
            ->orderByDesc('start_date');
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
}
