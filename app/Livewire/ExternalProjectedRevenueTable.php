<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ExternalPlatform as ExternalSolution;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ExternalProjectedRevenueTable extends Component
{
    public function render()
    {
        // Fetch operational external solutions
        $solutions = ExternalSolution::where('status', 'operational')
            ->where(function($q) {
                $q->whereNotNull('platform_otc')->orWhereNotNull('platform_mrc');
            })->get();

        $revenueByYear = [];
        $years = [];

        foreach ($solutions as $solution) {
            // Determine launch date
            $launchDateRaw = $solution->billing_date ?? $solution->launched_date ?? $solution->created_at;
            try {
                $launchDate = $launchDateRaw instanceof Carbon ? $launchDateRaw : Carbon::parse($launchDateRaw);
            } catch (\Exception $e) {
                $launchDate = Carbon::now();
            }

            $year = $launchDate->format('Y');

            if (!isset($revenueByYear[$year])) {
                $revenueByYear[$year] = [
                    'otc_total' => 0,
                    'mrc_total' => 0,
                ];
                $years[] = $year;
            }

            // OTC
            if (!empty($solution->platform_otc)) {
                $revenueByYear[$year]['otc_total'] += (float) $solution->platform_otc;
            }

            // MRC total for project life
            if (!empty($solution->platform_mrc)) {
                $mrc = (float) $solution->platform_mrc;
                $contract = (int) ($solution->contract_period ?? 1);
                $revenueByYear[$year]['mrc_total'] += ($mrc * 12) * max(1, $contract);
            }
        }

        sort($years);

        // Fill continuous year range if needed
        if (!empty($years)) {
            $min = (int) min($years);
            $max = (int) max($years);
            $complete = [];
            for ($y = $min; $y <= $max; $y++) {
                $complete[] = (string) $y;
                if (!isset($revenueByYear[$y])) {
                    $revenueByYear[$y] = ['otc_total' => 0, 'mrc_total' => 0];
                }
            }
            $years = $complete;
        }

        return view('livewire.external-projected-revenue-table', [
            'years' => $years,
            'revenueByYear' => $revenueByYear,
            'solutions' => $solutions,
        ]);
    }
}
