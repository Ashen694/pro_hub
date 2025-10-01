@extends('layouts.app')

@section('page-title', 'Internal Solutions - Yearly Contribution')

@push('styles')
{{-- We are adding custom styles just for this page --}}
<style>
    .report-table {
        border-collapse: collapse;
        width: 100%;
    }
    .report-table th, .report-table td {
        border: 1px solid #dee2e6; /* A slightly softer gray border than pure black */
        padding: 0.75rem;
        vertical-align: top;
    }
    .report-table thead th {
        vertical-align: bottom;
        border-bottom-width: 2px;
        font-size: 0.9rem; /* Making header text a bit smaller to fit */
        text-align: center;
    }
    .report-table .year-column {
        width: 80px;
        font-weight: bold;
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
                    <th></th> <!-- For Details link -->
                </tr>
            </thead>
            <tbody>
                @forelse ($yearlyData as $data)
                <tr>
                    <td class="year-column">{{ $data->year }}</td>
                    <td></td> 
                    <td></td>
                    <td></td>
                    <td><a href="#">Details</a></td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">No data available.</td>
                </tr>
                @endforelse 
            </tbody>
        </table>
    </div>

    <div class="card-footer">
    </div>
</div>
@endsection