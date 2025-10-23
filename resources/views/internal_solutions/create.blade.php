@extends('layouts.app')

@section('page-title', 'Add New Internal Solution')

@push('styles')
<style>
    /* Style for fields that can be disabled */
    .disabled-field {
        background-color: #f8f9fa; /* Light grey background */
        cursor: not-allowed;      /* Disabled cursor icon */
    }
</style>
@endpush

@section('content')
<form action="{{ route('internal-solutions.store') }}" method="POST">
    @csrf
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Add New Internal Solution</h3>
        </div>
        <div class="card-body">
            {{-- CORRECTED: Using a simple two-column layout instead of zigzag --}}
            <div class="row g-3">
                
                {{-- Left Column (12 fields) --}}
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label required">Application Category</label>
                        <select class="form-select" name="application_category">
                            <option value="" selected disabled>Please select</option>
                            <option value="Main Application">Main Application</option>
                            <option value="Change Request">Change Request</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label required">Application Group</label>
                        <select class="form-select" name="application_group">
                            <option value="" selected disabled>Please select</option>
                            @foreach($applicationGroups as $group)
                                <option value="{{ $group->ParentProjectID }}">{{ $group->ParentProjectGroup }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Developed By</label>
                        <select class="form-select" name="developed_by">
                            <option value="" selected disabled>Please select</option>
                            @foreach($employees as $employee)
                                <option value="{{ $employee->Emp_Name }}">{{ $employee->Emp_Name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Start Date</label>
                        <input type="text" class="form-control" id="start_date" name="start_date" placeholder="Select a date">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">SDLC Phase</label>
                        <select class="form-select" name="sdlc_phase">
                            @foreach($sdlcPhases as $phase)
                                <option value="{{ $phase->Phase }}">{{ $phase->Phase }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Integrated Applications</label>
                        <input type="text" class="form-control" name="integrated_applications" placeholder="Comma separated application names">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">DR Availability</label>
                        <select class="form-select" name="dr_availability">
                             <option value="Not Set">Not Set</option>
                             <option value="True">True</option>
                             <option value="False">False</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Business Owner</label>
                        <input type="text" class="form-control" name="business_owner" placeholder="Enter Business Owner name">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">UAT Date</label>
                        <input type="text" class="form-control" id="uat_date" name="uat_date" placeholder="Select a date">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Launched Date</label>
                        <input type="text" class="form-control" id="launched_date" name="launched_date" placeholder="Select a date">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Solution Value</label>
                        <input type="text" class="form-control" name="solution_value" placeholder="Enter solution value">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Support Availability</label>
                        <select class="form-select" name="support_availability">
                             <option value="" selected disabled>Please select</option>
                             <option value="24x7">24x7</option>
                             <option value="24x5">24x5</option>
                             <option value="8x5">8x5</option>
                        </select>
                    </div>
                </div>

                {{-- Right Column (12 fields) --}}
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Main (Parent) Application</label>
                        <select class="form-select" name="parent_application" id="parent_application" disabled>
                            <option value="" selected disabled>Please select</option>
                            @foreach($mainApplications as $app)
                                <option value="{{ $app->ID }}" data-group="{{ $app->ParentProjectID }}">{{ $app->App_Name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label required">Application Name</label>
                        <input type="text" class="form-control" name="application_name" placeholder="Enter Application Name">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Developed Team</label>
                        <input type="text" class="form-control" name="developed_team" placeholder="Enter Team Name">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Target Date</label>
                        <input type="text" class="form-control" id="target_date" name="target_date" placeholder="Select a date">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Percentage Done</label>
                        <input type="number" class="form-control" name="percentage_done" placeholder="e.g., 75" min="0" max="100">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">BitBucket Repository Name</label>
                        <input type="text" class="form-control" name="bitbucket_repo" placeholder="Enter Repository Name">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Hosted Server IP/Name</label>
                        <input type="text" class="form-control" name="server_ip" placeholder="Enter Server IP or Name">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Application URL</label>
                        <input type="url" class="form-control" name="application_url" placeholder="https://example.com">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Application End Users</label>
                         <select class="form-select" name="end_users">
                            <option value="" disabled selected>Please select</option>
                            @foreach ($endUserTypes as $userType)
                                <option value="{{ $userType->EndUserType }}">{{ $userType->EndUserType }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">User Specific Section/Division/Group</label>
                        <input type="text" class="form-control" name="user_specific_section" placeholder="Enter specific user group">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">VA Date</label>
                        <input type="text" class="form-control" id="va_date" name="va_date" placeholder="Select a date">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Exposed Through WAF?</label>
                         <select class="form-select" name="exposed_through_waf">
                             <option value="Not Set">Not Set</option>
                             <option value="True">True</option>
                             <option value="False">False</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer text-end">
            <a href="{{ route('internal-solutions.index', ['status' => 'operational']) }}" class="btn btn-link">Back to List</a>
            <button type="submit" class="btn btn-primary">Create</button>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
  document.addEventListener("DOMContentLoaded", function () {
    const datepickerConfig = {
        buttonText: {
            previousMonth: `<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><polyline points="15 6 9 12 15 18" /></svg>`,
            nextMonth: `<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><polyline points="9 6 15 12 9 18" /></svg>`,
        },
        format: 'YYYY-MM-DD'
    };

    const dateInputIds = ['start_date', 'target_date', 'uat_date', 'va_date', 'launched_date'];
    dateInputIds.forEach(id => { 
        if(document.getElementById(id)) {
            new Litepicker({ element: document.getElementById(id), ...datepickerConfig });
        }
    });
    
    const applicationCategorySelect = document.querySelector('select[name="application_category"]');
    const parentApplicationSelect = document.getElementById('parent_application');
    const applicationGroupSelect = document.querySelector('select[name="application_group"]');

    function toggleParentApplicationField() {
        if (applicationCategorySelect.value === 'Change Request') {
            parentApplicationSelect.disabled = false;
            parentApplicationSelect.classList.remove('disabled-field');
        } else {
            parentApplicationSelect.disabled = true;
            parentApplicationSelect.classList.add('disabled-field');
            parentApplicationSelect.value = '';
        }
    }

    applicationCategorySelect.addEventListener('change', toggleParentApplicationField);
    
    parentApplicationSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const group = selectedOption.getAttribute('data-group');
        
        if (group) {
            applicationGroupSelect.value = group;
        }
    });

    toggleParentApplicationField();
  });
</script>
@endpush