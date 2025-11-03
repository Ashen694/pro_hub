@extends('layouts.app')

@section('page-title', 'Add New Internal Issue')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Add New Internal Issue</h3>
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
        <form action="{{ route('incidents.internal.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-12 mb-3">
                    <label class="form-label required">Issue Start Date/Time</label>
                    <input type="datetime-local" name="Issue_Start_Time" class="form-control" value="{{ old('Issue_Start_Time') }}" required>
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label required">Internal Platform/Solution</label>
                    <select name="Internal_APP_ID" class="form-select" required>
                        <option value="" selected disabled>Please select</option>
                        @foreach($platforms as $platform)
                            <option value="{{ $platform->App_Name }}" {{ old('Internal_APP_ID') == $platform->App_Name ? 'selected' : '' }}>
                                {{ $platform->App_Name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label required">Reporting Employee SvcNo/Name</label>
                    <input type="text" name="Reported_By" class="form-control" placeholder="Enter service number or name" value="{{ old('Reported_By') }}" required>
                </div>
                 <div class="col-md-12 mb-3">
                    <label class="form-label">Reporting Person Contact Details</label>
                    <input type="text" name="Reporting_Person_ContactNo" class="form-control" placeholder="Enter contact details" value="{{ old('Reporting_Person_ContactNo') }}">
                </div>
                <div class="col-12 mb-3">
                    <label class="form-label required">Incident Description</label>
                    <textarea name="Description" class="form-control" rows="4" placeholder="Describe the incident" required>{{ old('Description') }}</textarea>
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label required">Criticality</label>
                     <select name="Criticality" class="form-select" required>
                        <option value="" selected disabled>Please select</option>
                        <option value="Low" {{ old('Criticality') == 'Low' ? 'selected' : '' }}>Low</option>
                        <option value="Medium" {{ old('Criticality') == 'Medium' ? 'selected' : '' }}>Medium</option>
                        <option value="High" {{ old('Criticality') == 'High' ? 'selected' : '' }}>High</option>
                    </select>
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label required">Entered By</label>
                    <input type="text" name="Entered_By" class="form-control" value="{{ Auth::user()->name }}" required readonly>
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label required">Assigned To</label>
                    <select name="Assigned_To" class="form-select" required>
                        <option value="" selected disabled>Please select</option>
                        @foreach($employees as $employee)
                            <option value="{{ $employee->Emp_Name }}" {{ old('Assigned_To') == $employee->Emp_Name ? 'selected' : '' }}>
                                {{ $employee->Emp_Name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label required">Assigned By</label>
                    <select name="Assigned_By" class="form-select" required>
                        <option value="" selected disabled>Please select</option>
                         @foreach($employees as $employee)
                            <option value="{{ $employee->Emp_Name }}" {{ old('Assigned_By') == $employee->Emp_Name ? 'selected' : '' }}>
                                {{ $employee->Emp_Name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                 <div class="col-md-12 mb-3">
                    <label class="form-label">Assigned Date/Time</label>
                    <input type="datetime-local" name="Assigned_Time" class="form-control" value="{{ old('Assigned_Time') }}">
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label required">Status</label>
                     <select name="Status" class="form-select" required>
                        <option value="" selected disabled>Please select</option>
                        <option value="Open" {{ old('Status') == 'Open' ? 'selected' : '' }}>Open</option>
                        <option value="Attending" {{ old('Status') == 'Attending' ? 'selected' : '' }}>Attending</option>
                        <option value="Awaiting_Reply" {{ old('Status') == 'Awaiting_Reply' ? 'selected' : '' }}>Awaiting_Reply</option>
                        <option value="Solved" {{ old('Status') == 'Solved' ? 'selected' : '' }}>Solved</option>
                    </select>
                </div>
                <div class="col-12 mb-3">
                    <label class="form-label">Action Taken to Resolve the Issue</label>
                    <textarea name="Action_Taken" class="form-control" rows="3" placeholder="Describe the action taken">{{ old('Action_Taken') }}</textarea>
                </div>
                 <div class="col-md-12 mb-3">
                    <label class="form-label">Issue Closed Date/Time</label>
                    <input type="datetime-local" name="Issue_Closed_Time" class="form-control" value="{{ old('Issue_Closed_Time') }}">
                </div>
            </div>
            <div class="form-footer text-center">
                <button type="submit" class="btn btn-primary w-100">Create</button>
            </div>
        </form>
    </div>
</div>
@endsection