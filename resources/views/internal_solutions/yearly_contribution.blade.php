@extends('layouts.app')

@section('page-title', 'Internal Solutions - Yearly Contribution')

@push('styles')
<style>
    .report-table {
        border-collapse: collapse;
        width: 100%;
    }
    .report-table th, .report-table td {
        border: 1px solid #dee2e6;
        padding: 0.75rem;
        vertical-align: middle; 
        text-align: right;     
    }
    .report-table thead th {
        vertical-align: bottom;
        border-bottom-width: 2px;
        font-size: 0.9rem;
        text-align: center;
    }
    .report-table .year-column, .report-table .details-column {
        font-weight: bold;
        text-align: center;  
    }
    .report-table .year-column {
        width: 80px;
    }
</style>
@endpush

@section('content')
<div class="card">
    <div class="card-header">
        <div>
            <h3 class="card-title">Internal Solutions - Yearly Contribution</h3>
            <p class="card-subtitle">for all the internal projects currently active</p>
        </div>
    </div>
    
    <div class="table-responsive">
        <table class="table card-table table-vcenter report-table">
            <thead>
                <tr>
                    <th class="year-column">Year</th>
                    <th>Total Solution Value <br><small class="text-muted">(From projects launched on the year)</small></th>
                    <th>Total Value of Maintenance Effort <br><small class="text-muted">(From projects launched in previous years)</small></th>
                    <th>Grand Total</th>
                    <th class="details-column"></th>  
                </tr>
            </thead>
            <tbody>
                @forelse ($yearlyData as $data)
                <tr>
                    {{-- Highlight the row if the mouse is over it, like in the image --}}
                    <td class="year-column">{{ $data->year }}</td>
                    <td>{{ number_format($data->new_solutions_value, 2) }}</td> 
                    <td>{{ number_format($data->maintenance_value, 2) }}</td>
                    <td>{{ number_format($data->grand_total, 2) }}</td>
                    <td class="details-column"><a href="{{ route('internal-solutions.yearly-contribution.details', ['year' => $data->year]) }}">Details</a></td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">No active projects with launch dates and prices found.</td>
                </tr>
                @endforelse 
            </tbody>
        </table>
    </div>

    <div class="card-footer">
    </div>
</div>
@endsection