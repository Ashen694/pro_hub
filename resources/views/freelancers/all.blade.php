@extends('layouts.app')

{{-- 1. නිවැරදි Page Title එක මෙතනට එකතු කරන්න --}}
@section('page-title', 'All Freelancers')

@section('content')
<!-- Bootstrap Icons CSS link -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>
    .page-header, .create-new-btn {
       color: #e6e6e6 !important;
    }

    .custom-table-design {
        background-color: #ffffff !important; 
        color: #212529 !important; 
        border: 1px solid #dee2e6;
        border-radius: 8px; 
        overflow: hidden; 
    }

    .custom-table-design thead th {
        background-color: #f8f9fa !important; 
        color: #495057 !important;
        border-color: #dee2e6 !important;
    }
     .custom-table-design thead .sub-header-row th {
        background-color: #f8f9fa !important;
    }

    .custom-table-design th,
    .custom-table-design td {
        border-color: #dee2e6 !important;
    }
    
    .table-hover tbody tr:hover {
        background-color: #f5f5f5 !important; 
    }

    .alert-warning {
        color: #664d03 !important;
        background-color: #fff3cd !important;
        border-color: #ffecb5 !important;
    }

    .search-input-group {
        border: 1px solid #2a416b;
        border-radius: 0.25rem;
        background-color: #0c1631;
    }
    .search-input-group .form-control {
        background-color: transparent !important;
        color: #fff !important;
        border: none;
    }
    .search-input-group .btn { color: #6b7a8a; }
    .search-input-group .btn:hover { color: #46b6ef; }
    

    .actions-cell a.text-primary {
        color: #0d6efd !important; /* Standard blue */
    }
     .actions-cell button.text-danger {
        color: #dc3545 !important; /* Standard red */
    }
    .text-muted {
        color: #6c757d!important; 
    }
</style>

<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div></div>
        <div class="d-flex align-items-center">
            <div class="input-group search-input-group me-3">
                <input type="text" class="form-control" placeholder="Search freelancers..." aria-label="Search freelancers">
                <button class="btn" type="button"><i class="bi bi-search"></i></button>
            </div>
            <a href="{{ route('freelancers.create') }}" class="create-new-btn">
                <i class="bi bi-plus-circle"></i> Create New
            </a>
        </div>
    </div>

    @if($freelancers->isEmpty())
        <div class="alert alert-warning">No freelancers have been added yet.</div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered custom-table-design table-hover mb-0">
                <thead>
                    <tr>
                        <th rowspan="2">ID</th> 
                        <th rowspan="2">Name</th> 
                        <th rowspan="2">NIC</th>
                        <th colspan="2">Project</th>
                        <th colspan="2">Amount</th>
                        <th rowspan="2">Start Date</th>
                        <th rowspan="2">End Date</th>
                        <th rowspan="2">Duration</th>
                        <th colspan="3">Tasks</th>
                        <th colspan="4">Payment</th>
                        <th rowspan="2">Actions</th>
                    </tr>
                    <tr class="sub-header-row">
                        <th>Name</th>
                        <th>Scope</th>
                        <th>(Rs)</th>
                        <th>Budget Available</th>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Specification</th>
                        <th>Payment (Rs)</th> 
                        <th>Due Date</th>
                        <th>Status</th>
                        <th>Paid</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($freelancers as $index => $freelancer)
                        @php
                            $task_count = $freelancer->tasks->count() > 0 ? $freelancer->tasks->count() : 1;
                        @endphp

                        @if($freelancer->tasks->isEmpty())
                            <tr>
                                <td class="text-start main-data-cell" style="font-weight: bold;">{{ $freelancer->id }}</td>
                                <td class="text-start main-data-cell">{{ $freelancer->name }}</td>
                                <td class="text-start main-data-cell" style="font-weight: bold;">{{ $freelancer->nic }}</td>
                                <td class="main-data-cell">{{ $freelancer->project_name }}</td>
                                <td class="main-data-cell">{{ $freelancer->project_scope }}</td>
                                <td class="text-end main-data-cell currency-amount">Rs {{ number_format($freelancer->total_amount, 0) }}</td>
                                <td class="text-center main-data-cell">{{ $freelancer->budget_available == 'Yes' ? 'Yes' : 'No' }}</td>
                                <td class="text-center main-data-cell">{{ \Carbon\Carbon::parse($freelancer->start_date)->format('M j, Y') }}</td>
                                <td class="text-center main-data-cell">{{ \Carbon\Carbon::parse($freelancer->end_date)->format('M j, Y') }}</td>
                                <td class="text-center main-data-cell">{{ $freelancer->duration }}</td>
                                <td colspan="7" class="text-center text-muted fst-italic">No tasks assigned</td>
                                <td class="text-center actions-cell">
                                    <a href="{{ route('freelancers.edit', $freelancer->id) }}" class="text-primary me-1" title="Edit Freelancer"><i class="bi bi-pencil-square"></i></a>
                                    <form method="POST" action="{{ route('freelancers.destroy', $freelancer->id) }}" onsubmit="return confirm('Are you sure you want to delete this freelancer?');" class="d-inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-link text-danger p-0 border-0 m-0" title="Delete Freelancer"><i class="bi bi-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @else
                            @foreach($freelancer->tasks as $tIndex => $task)
                                <tr>
                                    @if($tIndex == 0)
                                        <td rowspan="{{ $task_count }}" class="text-start main-data-cell" style="font-weight: bold; vertical-align: middle;">{{ $freelancer->id }}</td>
                                        <td rowspan="{{ $task_count }}" class="text-start main-data-cell" style="vertical-align: middle;">{{ $freelancer->name }}</td>
                                        <td rowspan="{{ $task_count }}" class="text-start main-data-cell" style="font-weight: bold; vertical-align: middle;">{{ $freelancer->nic }}</td>
                                        <td rowspan="{{ $task_count }}" class="main-data-cell" style="vertical-align: middle;">{{ $freelancer->project_name }}</td>
                                        <td rowspan="{{ $task_count }}" class="main-data-cell" style="vertical-align: middle;">{{ $freelancer->project_scope }}</td>
                                        <td rowspan="{{ $task_count }}" class="text-end main-data-cell currency-amount" style="vertical-align: middle;">Rs {{ number_format($freelancer->total_amount, 0) }}</td>
                                        <td rowspan="{{ $task_count }}" class="text-center main-data-cell" style="vertical-align: middle;">{{ $freelancer->budget_available == 'Yes' ? 'Yes' : 'No' }}</td>
                                        <td rowspan="{{ $task_count }}" class="text-center main-data-cell" style="vertical-align: middle;">{{ \Carbon\Carbon::parse($freelancer->start_date)->format('M j, Y') }}</td>
                                        <td rowspan="{{ $task_count }}" class="text-center main-data-cell" style="vertical-align: middle;">{{ \Carbon\Carbon::parse($freelancer->end_date)->format('M j, Y') }}</td>
                                        <td rowspan="{{ $task_count }}" class="text-center main-data-cell" style="vertical-align: middle;">{{ $freelancer->duration }}</td>
                                    @endif

                                    <td class="task-id-cell text-center">{{ $task->id }}</td>
                                    <td class="task-name-cell">{{ $task->task_name }}</td>
                                    <td class="task-spec-cell">{{ $task->specification }}</td>
                                    
                                    <td class="payment-amount-cell text-end currency-amount">Rs {{ number_format($task->payment, 0) }}</td> 
                                    <td class="payment-due-cell text-center">{{ \Carbon\Carbon::parse($task->delivery_due_date)->format('M j, Y') }}</td>
                                    <td class="payment-status-cell text-center">
                                        @php
                                            $statusClass = match($task->status) {
                                                'Completed' => 'bg-success',
                                                'In Progress' => 'bg-warning text-dark',
                                                default => 'bg-secondary',
                                            };
                                        @endphp
                                        <span class="badge rounded-pill text-white status-badge {{ $statusClass }}">{{ $task->status }}</span>
                                    </td>
                                    <td class="payment-paid-cell text-center">{{ $task->paid ? 'Yes' : 'No' }}</td>
                                    
                                    @if($tIndex == 0)
                                        <td rowspan="{{ $task_count }}" class="text-center actions-cell align-middle">
                                            <a href="{{ route('freelancers.edit', $freelancer->id) }}" class="text-primary me-1" title="Edit Freelancer"><i class="bi bi-pencil-square"></i></a>
                                            <form method="POST" action="{{ route('freelancers.destroy', $freelancer->id) }}" onsubmit="return confirm('Are you sure you want to delete this freelancer and all their tasks?');" class="d-inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-link text-danger p-0 border-0 m-0" title="Delete Freelancer"><i class="bi bi-trash"></i></button>
                                            </form>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection