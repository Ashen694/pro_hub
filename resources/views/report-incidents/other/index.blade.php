@extends('layouts.app')

@section('page-title', 'Recent Issues (Last 3 Months)')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Recent Issues Reported on All Solutions</h3>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Issue Start Date/Time</th>
                        <th>System Name</th>
                        <th>Incident Description</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($recentIssues as $issue)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($issue->Issue_Start_Time)->format('Y-m-d h:i A') }}</td>
                            <td>{{ $issue->system_name }}</td>
                            <td>{{ Str::limit($issue->Description, 100) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center">No issues found in the last 3 months.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection