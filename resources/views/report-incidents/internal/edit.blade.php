@extends('layouts.app')

@section('page-title', 'Edit Internal Issue')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Edit Issue - INT-{{ str_pad($issue->ID, 4, '0', STR_PAD_LEFT) }}</h3>
    </div>
    <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('incidents.internal.update', $issue->ID) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                 <div class="col-md-12 mb-3">
                    <label class="form-label required">Issue Start Date/Time</label>
                    <input type="datetime-local" name="Issue_Start_Time" class="form-control" value="{{ old('Issue_Start_Time', \Carbon\Carbon::parse($issue->Issue_Start_Time)->format('Y-m-d\TH:i')) }}" required>
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label required">Internal Platform/Solution</label>
                    <select name="Internal_APP_ID" class="form-select" required>
                        <option value="" disabled>Please select</option>
                        @foreach($platforms as $platform)
                            <option value="{{ $platform->App_Name }}" {{ old('Internal_APP_ID', $issue->Internal_APP_ID) == $platform->App_Name ? 'selected' : '' }}>
                                {{ $platform->App_Name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label required">Reporting Employee SvcNo/Name</label>
                    <input type="text" name="Reported_By" class="form-control" value="{{ old('Reported_By', $issue->Reported_By) }}" required>
                </div>
                 <div class="col-md-12 mb-3">
                    <label class="form-label">Reporting Person Contact Details</label>
                    <input type="text" name="Reporting_Person_ContactNo" class="form-control" value="{{ old('Reporting_Person_ContactNo', $issue->Reporting_Person_ContactNo) }}">
                </div>
                <div class="col-12 mb-3">
                    <label class="form-label required">Incident Description</label>
                    <textarea name="Description" class="form-control" rows="4" required>{{ old('Description', $issue->Description) }}</textarea>
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label required">Criticality</label>
                     <select name="Criticality" class="form-select" required>
                        <option value="Low" {{ old('Criticality', $issue->Criticality) == 'Low' ? 'selected' : '' }}>Low</option>
                        <option value="Medium" {{ old('Criticality', $issue->Criticality) == 'Medium' ? 'selected' : '' }}>Medium</option>
                        <option value="High" {{ old('Criticality', $issue->Criticality) == 'High' ? 'selected' : '' }}>High</option>
                        <option value="Urgent" {{ old('Criticality', $issue->Criticality) == 'Urgent' ? 'selected' : '' }}>Urgent</option>
                    </select>
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label required">Entered By</label>
                    <input type="text" name="Entered_By" class="form-control" value="{{ old('Entered_By', $issue->Entered_By) }}" required readonly>
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label required">Assigned To</label>
                    <select name="Assigned_To" class="form-select" required>
                        <option value="" disabled>Please select</option>
                        @foreach($employees as $employee)
                            <option value="{{ $employee->Emp_Name }}" {{ old('Assigned_To', $issue->Assigned_To) == $employee->Emp_Name ? 'selected' : '' }}>
                                {{ $employee->Emp_Name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label required">Assigned By</label>
                    <select name="Assigned_By" class="form-select" required>
                        <option value="" disabled>Please select</option>
                        @foreach($employees as $employee)
                            <option value="{{ $employee->Emp_Name }}" {{ old('Assigned_By', $issue->Assigned_By) == $employee->Emp_Name ? 'selected' : '' }}>
                                {{ $employee->Emp_Name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                 <div class="col-md-12 mb-3">
                    <label class="form-label">Assigned Date/Time</label>
                    <input type="datetime-local" name="Assigned_Time" class="form-control" value="{{ old('Assigned_Time', $issue->Assigned_Time ? \Carbon\Carbon::parse($issue->Assigned_Time)->format('Y-m-d\TH:i') : '') }}">
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label required">Status</label>
                     <select name="Status" class="form-select" required>
                        <option value="Open" {{ old('Status', $issue->Status) == 'Open' ? 'selected' : '' }}>Open</option>
                        <option value="Attending" {{ old('Status', $issue->Status) == 'Attending' ? 'selected' : '' }}>Attending</option>
                        <option value="Awaiting_Reply" {{ old('Status', $issue->Status) == 'Awaiting_Reply' ? 'selected' : '' }}>Awaiting Reply</option>
                        <option value="Solved" {{ old('Status', $issue->Status) == 'Solved' ? 'selected' : '' }}>Solved</option>
                    </select>
                </div>
                <div class="col-12 mb-3">
                    <label class="form-label">Action Taken to Resolve the Issue</label>
                    <textarea name="Action_Taken" class="form-control" rows="3">{{ old('Action_Taken', $issue->Action_Taken) }}</textarea>
                </div>
                 <div class="col-md-12 mb-3">
                    <label class="form-label">Issue Closed Date/Time</label>
                    <input type="datetime-local" name="Issue_Closed_Time" class="form-control" value="{{ old('Issue_Closed_Time', $issue->Issue_Closed_Time ? \Carbon\Carbon::parse($issue->Issue_Closed_Time)->format('Y-m-d\TH:i') : '') }}">
                </div>
            </div>
            <div class="form-footer text-center">
                 <a href="{{ route('incidents.internal.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary w-50">Update</button>
            </div>
        </form>
    </div>
</div>
@endsection