@extends('layouts.app')

@section('page-title', 'Internal Solutions - Contribution for Year ' . $year)

@push('styles')
<style>
    .details-table th, .details-table td {
        vertical-align: middle !important;
    }
    .details-table .number-cell {
        text-align: right;
    }
    .details-table tfoot td {
        font-weight: bold;
        border-top: 2px solid #dee2e6 !important;
    }
</style>
@endpush

@section('content')
<div class="card">
    <div class="card-header">
        <div>
            <h3 class="card-title">Internal Solutions - Contribution for Year {{ $year }}</h3>
            <p class="card-subtitle">Detailed breakdown of all active projects contributing to this year's value.</p>
        </div>
        <div class="card-options">
            <a href="{{ route('internal-solutions.yearly-contribution') }}" class="btn btn-outline-primary">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><line x1="5" y1="12" x2="19" y2="12"></line><line x1="5" y1="12" x2="11" y2="18"></line><line x1="5" y1="12" x2="11" y2="6"></line></svg>
                Back to Summary
            </a>
        </div>
    </div>
    
    <div class="table-responsive">
        <table class="table card-table table-vcenter details-table">
            <thead>
                <tr>
                    <th>Project Name</th>
                    <th>Developed By</th>
                    <th>Launched <br>Year</th>
                    <th class="number-cell">Solution Value</th>
                    <th class="number-cell">Value for the year</th>
                    <th class="number-cell">Value of Maintenance Effort for <br> the year (10% of solution value)</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($projects as $project)
                <tr>
                    <td>{{ $project->App_Name }}</td>
                    <td>{{ $project->Developed_By ?? 'N/A' }}</td>
                    <td>{{ $project->launched_year }}</td>
                    <td class="number-cell">{{ number_format($project->Price, 2) }}</td>
                    <td class="number-cell">{{ number_format($project->value_for_the_year, 2) }}</td>
                    <td class="number-cell">{{ number_format($project->maintenance_effort, 2) }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">No project data found for this year.</td>
                </tr>
                @endforelse 
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" class="number-cell"><strong>Totals:</strong></td>
                    <td class="number-cell">{{ number_format($projects->sum('value_for_the_year'), 2) }}</td>
                    <td class="number-cell">{{ number_format($projects->sum('maintenance_effort'), 2) }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
@endsection