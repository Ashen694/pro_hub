@extends('layouts.app')

@section('page-title', $title ?? 'External Solution Details')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ $solution->platform_name }}</h3>
    </div>
    <div class="card-body">
        <table class="table">
            <tbody>
                <tr><th>Platform Name</th><td>{{ $solution->platform_name }}</td></tr>
                <tr><th>Platform Type</th><td>{{ $solution->platform_type }}</td></tr>
                <tr><th>Platform Owner (Customer)</th><td>{{ $solution->platform_owner }}</td></tr>
                <tr><th>Developed By</th><td>{{ $solution->developed_by }}</td></tr>
                <tr><th>Start Date</th><td>{{ optional($solution->start_date)->format('Y-m-d') }}</td></tr>
                <tr><th>Launched Date</th><td>{{ optional($solution->launched_date)->format('Y-m-d') }}</td></tr>
                <tr><th>One Time Charge (OTC)</th><td>{{ $solution->platform_otc }}</td></tr>
                <tr><th>Monthly Recurring Charge (MRC)</th><td>{{ $solution->platform_mrc }}</td></tr>
                <tr><th>Software Value</th><td>{{ number_format($solution->software_value, 2) }}</td></tr>
            </tbody>
        </table>
        <a href="{{ route('external-solutions.edit', ['externalSolution' => $solution->platform_id]) }}" class="btn btn-primary">Edit</a>
        <a href="{{ route('external-solutions.index', ['status' => $solution->status ?? 'operational']) }}" class="btn btn-link">Back</a>
    </div>
</div>
@endsection