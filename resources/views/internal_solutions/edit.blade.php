@extends('layouts.app')

@section('page-title', 'Edit - ' . $solution->App_Name)

@push('styles')
<style>
    /* Style for disabled fields */
    .disabled-field {
        background-color: #f8f9fa; /* Light grey background */
        cursor: not-allowed;      /* Disabled cursor icon */
    }

    /* CSS Grid layout for the form */
    .form-grid {
        display: grid;
        grid-template-columns: 1fr; /* Default to single column for mobile */
        gap: 0 1.5rem; /* Gap between columns */
    }

    /* Apply two-column layout on larger screens (desktop) */
    @media (min-width: 768px) {
        .form-grid {
            grid-template-columns: 1fr 1fr;
        }
    }
</style>
@endpush

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Edit - {{ $solution->App_Name }}</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('internal-solutions.update', $solution->ID) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-grid">
                {{-- Fields will now auto-arrange into the grid --}}
                <div class="mb-3">
                    <label class="form-label">Application Category</label>
                    <input type="text" class="form-control disabled-field" value="{{ $solution->App_Category }}" disabled>
                </div>
                <div class="mb-3">
                    <label class="form-label">Main (Parent) Application</label>
                    <input type="text" class="form-control disabled-field" value="{{ $solution->mainApplicationParent->App_Name ?? 'N/A' }}" disabled>
                </div>
                <div class="mb-3">
                    <label class="form-label">Application Group</label>
                    <input type="text" class="form-control disabled-field" value="{{ $solution->parentProject->ParentProjectGroup ?? 'N/A' }}" disabled>
                </div>
                <div class="mb-3">
                    <label class="form-label">Application Name</label>
                    <input type="text" name="application_name" class="form-control" value="{{ old('application_name', $solution->App_Name) }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Developed By</label>
                     <select name="developed_by" class="form-select">
                        <option value="">Please select</option>
                        @foreach ($employees as $employee)
                            <option value="{{ $employee->Emp_Name }}" {{ old('developed_by', $solution->Developed_By) == $employee->Emp_Name ? 'selected' : '' }}>{{ $employee->Emp_Name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Developed Team</label>
                    <input type="text" name="developed_team" class="form-control" value="{{ old('developed_team', $solution->Developed_Team) }}">
                </div>
                 <div class="mb-3">
                    <label class="form-label">Backup Person (Primary)</label>
                    <select name="backup_person_primary" class="form-select">
                         <option value="">Please select</option>
                         @foreach ($employees as $employee)
                            <option value="{{ $employee->Emp_Name }}" {{ old('backup_person_primary', $solution->BackupOfficer_1) == $employee->Emp_Name ? 'selected' : '' }}>{{ $employee->Emp_Name }}</option>
                        @endforeach
                    </select>
                </div>
                 <div class="mb-3">
                    <label class="form-label">Backup Person (Secondary)</label>
                    <select name="backup_person_secondary" class="form-select">
                         <option value="">Please select</option>
                         @foreach ($employees as $employee)
                            <option value="{{ $employee->Emp_Name }}" {{ old('backup_person_secondary', $solution->BackupOfficer_2) == $employee->Emp_Name ? 'selected' : '' }}>{{ $employee->Emp_Name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Start Date</label>
                    <input type="date" name="start_date" class="form-control" value="{{ old('start_date', $solution->StartDate) }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Target Date</label>
                    <input type="date" name="target_date" class="form-control" value="{{ old('target_date', $solution->TargetDate) }}">
                </div>
                 <div class="mb-3">
                    <label class="form-label">SDLC Phase</label>
                    <select name="sdlc_phase" class="form-select">
                        @foreach($sdlcPhases as $phase)
                            <option value="{{ $phase->Phase }}" {{ old('sdlc_phase', $solution->SDLCPhase) == $phase->Phase ? 'selected' : '' }}>{{ $phase->Phase }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Priority Level</label>
                    <select name="priority_level" class="form-select">
                        <option value="">Please select</option>
                        <option value="Level 01" {{ old('priority_level', $solution->Status) == 'Level 01' ? 'selected' : '' }}>Level 01</option>
                        <option value="Level 02" {{ old('priority_level', $solution->Status) == 'Level 02' ? 'selected' : '' }}>Level 02</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Percentage Done</label>
                    <input type="number" name="percentage_done" class="form-control" value="{{ old('percentage_done', $solution->PercentageDone) }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Integrated Applications</label>
                    <input type="text" name="integrated_applications" class="form-control" value="{{ old('integrated_applications', $solution->Integrated_apps) }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">BitBucket Repository Name</label>
                    <input type="text" name="bitbucket_repo" class="form-control" value="{{ old('bitbucket_repo', $solution->BIT_bucket_repo) }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">DR Availability</label>
                    <select name="dr_availability" class="form-select">
                        <option value="Not Set" {{ old('dr_availability', $solution->DR) == 'Not Set' ? 'selected' : '' }}>Not Set</option>
                        <option value="Available" {{ old('dr_availability', $solution->DR) == 'Available' ? 'selected' : '' }}>Available</option>
                        <option value="Not Available" {{ old('dr_availability', $solution->DR) == 'Not Available' ? 'selected' : '' }}>Not Available</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Hosted Server IP/Name</label>
                    <input type="text" name="server_ip" class="form-control" value="{{ old('server_ip', $solution->App_IP) }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Application URL</label>
                    <input type="url" name="application_url" class="form-control" value="{{ old('application_url', $solution->App_URL) }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Business Owner</label>
                    <input type="text" name="business_owner" class="form-control" value="{{ old('business_owner', $solution->Bus_Owner) }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Application End Users</label>
                     <select name="end_users" class="form-select">
                        <option value="">Please select</option>
                        @foreach ($endUserTypes as $userType)
                            <option value="{{ $userType->EndUserType }}" {{ old('end_users', $solution->EndUserType) == $userType->EndUserType ? 'selected' : '' }}>{{ $userType->EndUserType }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">User Specific Section/Division/Group</label>
                    <input type="text" name="user_specific_section" class="form-control" value="{{ old('user_specific_section', $solution->UserSpecificSection) }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">UAT Date</label>
                    <input type="date" name="uat_date" class="form-control" value="{{ old('uat_date', $solution->UATDate) }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">VA Date</label>
                    <input type="date" name="va_date" class="form-control" value="{{ old('va_date', $solution->VADate) }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Launched Date</label>
                    <input type="date" name="launched_date" class="form-control" value="{{ old('launched_date', $solution->LaunchedDate) }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Exposed Through WAF?</label>
                    <select name="exposed_through_waf" class="form-select">
                        <option value="Not Set" {{ old('exposed_through_waf', $solution->WAF) == 'Not Set' ? 'selected' : '' }}>Not Set</option>
                        <option value="Yes" {{ old('exposed_through_waf', $solution->WAF) == 'Yes' ? 'selected' : '' }}>Yes</option>
                        <option value="No" {{ old('exposed_through_waf', $solution->WAF) == 'No' ? 'selected' : '' }}>No</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Solution Value</label>
                    <input type="number" step="0.01" name="solution_value" class="form-control" value="{{ old('solution_value', $solution->Price) }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Support Availability</label>
                     <select name="support_availability" class="form-select">
                        <option value="24x7" {{ old('support_availability', $solution->SLA) == '24x7' ? 'selected' : '' }}>24x7</option>
                        <option value="24x5" {{ old('support_availability', $solution->SLA) == '24x5' ? 'selected' : '' }}>24x5</option>
                        <option value="8x5" {{ old('support_availability', $solution->SLA) == '8x5' ? 'selected' : '' }}>8x5</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Comment</label>
                    <textarea name="comment" class="form-control" rows="3" placeholder="Add a new comment. Old comments will be saved.">{{-- Show the last comment as a placeholder if needed: old('comment', $latestComment->Comment ?? '') --}}</textarea>
                </div>
            </div>

            <div class="form-footer text-end mt-4">
                <a href="{{ url()->previous() }}" class="btn btn-link">Back to List</a>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
</div>
@endsection