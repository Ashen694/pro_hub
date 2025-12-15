<div>
    @push('styles')
    <style>
        .table-header-bold { font-weight: 600; }
        .text-right { text-align: right; }
    </style>
    @endpush

    <div class="table-responsive">
        <table class="table card-table table-vcenter datatable">
            <thead>
                <tr>
                    <th>Year</th>
                    <th class="text-right">OTC Total</th>
                    <th class="text-right">MRC Total for project life time</th>
                    <th class="text-right">Grand Total</th>
                    <th>Details</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($years as $year)
                <tr wire:key="revenue-{{ $year }}">
                    <td><strong>{{ $year }}</strong></td>
                    <td class="text-right">{{ number_format($revenueByYear[$year]['otc_total'] ?? 0, 2) }}</td>
                    <td class="text-right">{{ number_format($revenueByYear[$year]['mrc_total'] ?? 0, 2) }}</td>
                    <td class="text-right"><strong>{{ number_format(($revenueByYear[$year]['otc_total'] ?? 0) + ($revenueByYear[$year]['mrc_total'] ?? 0), 2) }}</strong></td>
                    <td>
                        <a href="#" class="text-primary" data-bs-toggle="modal" data-bs-target="#revenue-details-{{ $year }}" title="View Details">Details</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-5">
                        <h3>No projected revenue data available</h3>
                        <p class="text-muted">Operational solutions with OTC/MRC charges will appear here.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Detail modals --}}
    @foreach($years as $year)
        <div class="modal modal-blur fade" id="revenue-details-{{ $year }}" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="modal-header">
                        <h3 class="modal-title">Revenue Details for {{ $year }}</h3>
                    </div>
                    <div class="modal-body">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Application/Platform Name</th>
                                    <th class="text-right">OTC</th>
                                    <th class="text-right">MRC (Monthly)</th>
                                    <th class="text-right">Contract Period</th>
                                    <th class="text-right">MRC Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $yearSolutions = $solutions->filter(function($solution) use ($year) {
                                        $launchDateRaw = $solution->billing_date ?? $solution->launched_date ?? $solution->created_at;
                                        try { $launchDate = \Carbon\Carbon::parse($launchDateRaw); } catch (\Exception $e) { $launchDate = \Carbon\Carbon::now(); }
                                        return $launchDate->format('Y') == $year;
                                    });
                                @endphp

                                @forelse($yearSolutions as $solution)
                                <tr>
                                    <td>{{ $solution->platform_name }}</td>
                                    <td class="text-right">{{ number_format($solution->platform_otc ?? 0, 2) }}</td>
                                    <td class="text-right">{{ number_format($solution->platform_mrc ?? 0, 2) }}</td>
                                    <td class="text-right">{{ $solution->contract_period ?? '-' }}</td>
                                    <td class="text-right">
                                        @php
                                            $mrcTotal = 0;
                                            if ($solution->platform_mrc && $solution->contract_period) {
                                                $mrcTotal = ((float)$solution->platform_mrc * 12) * (int)$solution->contract_period;
                                            } elseif ($solution->platform_mrc) {
                                                $mrcTotal = ((float)$solution->platform_mrc * 12);
                                            }
                                        @endphp
                                        {{ number_format($mrcTotal, 2) }}
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">No solutions launched in this year</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-link" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
