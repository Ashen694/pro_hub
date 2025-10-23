@extends('layouts.app')

@section('page-title', 'External Solution Details')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ $solution->application_name }}</h3>
    </div>
    <div class="card-body">
        <table class="table">
            <tbody>
                <tr><th>Company/Customer</th><td>{{ $solution->company_customer }}</td></tr>
                <tr><th>Developed By</th><td>{{ $solution->developed_by }}</td></tr>
                <tr><th>Started</th><td>{{ $solution->start_date }}</td></tr>
                <tr><th>Launched</th><td>{{ $solution->launched_date }}</td></tr>
                    <tr><th>One Time Charge</th><td>{{ $solution->one_time_charge }}</td></tr>
                    <tr><th>Monthly Recurrent Charge (MRC)</th><td>{{ $solution->monthly_recurring_charge }}</td></tr>
                    <tr><th>Value of the Software (Out Of Total Solution Value)</th><td>{{ $solution->value_of_software }}</td></tr>
            </tbody>
        </table>
        <a href="{{ route('external-solutions.edit', $solution->id) }}" class="btn btn-primary">Edit</a>
        <a href="{{ route('external-solutions.index', ['status' => 'operational']) }}" class="btn btn-link">Back</a>
    </div>
</div>
@endsection
