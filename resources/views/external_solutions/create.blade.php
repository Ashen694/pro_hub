@extends('layouts.app')

@section('page-title', $title ?? 'Add New External Solution')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ $title ?? 'Add New External Solution' }}</h3>
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

        <form action="{{ route('external-solutions.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Application/Platform Name</label>
                        <input type="text" name="application_name" value="{{ old('application_name') }}" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Company/Customer</label>
                        <select name="company_customer" class="form-control">
                            <option value="">Please select</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Developed By</label>
                        <select name="developed_by" class="form-control">
                            <option value="">Please select</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Developed Team</label>
                        <input type="text" name="developed_team" value="{{ old('developed_team') }}" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Start Date</label>
                        <input type="date" name="start_date" value="{{ old('start_date') }}" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Target Date</label>
                        <input type="date" name="target_date" value="{{ old('target_date') }}" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">SDLC Stage</label>
                        <select name="sdlc_stage" class="form-control">
                            <option value="">Please select</option>
                            <option value="Proposal Preparation">Proposal Preparation</option>
                            <option value="Requirement Gathering">Requirement Gathering</option>
                            <option value="Development">Development</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Percentage Done</label>
                        <input type="text" name="percentage_done" value="{{ old('percentage_done') }}" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">BitBucket Repository Name</label>
                        <input type="text" name="bitbucket_repository_name" value="{{ old('bitbucket_repository_name') }}" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Sales Team Involved</label>
                        <select name="sales_team_involved" class="form-control">
                            <option value="">Please select</option>
                            <option value="Government Business">Government Business</option>
                            <option value="Enterprise Business">Enterprise Business</option>
                            <option value="Carrier Business">Carrier Business</option>
                            <option value="Region Business">Region Business</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Sales Account Manager</label>
                        <input type="text" name="sales_account_manager" value="{{ old('sales_account_manager') }}" class="form-control">
                    </div>

                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Sales Manager</label>
                        <input type="text" name="sales_manager" value="{{ old('sales_manager') }}" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Sales Engineer</label>
                        <input type="text" name="sales_engineer" value="{{ old('sales_engineer') }}" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">UAT Date</label>
                        <input type="date" name="uat_date" value="{{ old('uat_date') }}" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Launched Date</label>
                        <input type="date" name="launched_date" value="{{ old('launched_date') }}" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">One Time Charge (OTC)</label>
                        <input type="number" step="0.01" name="one_time_charge" value="{{ old('one_time_charge') }}" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Monthly Recurrent Charge (MRC)</label>
                        <input type="number" step="0.01" name="monthly_recurring_charge" value="{{ old('monthly_recurring_charge') }}" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Value of the Software (Out Of Total Solution Value)</label>
                        <input type="number" step="0.01" name="value_of_software" value="{{ old('value_of_software') }}" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Contract Period (Years)</label>
                        <input type="number" name="contract_period_years" value="{{ old('contract_period_years') }}" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Support Availability</label>
                        <select name="support_availability" class="form-control">
                            <option value="">Please select</option>
                            <option value="24x7">24x7</option>
                            <option value="24x5">24x5</option>
                            <option value="8x5">8x5</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">DPO Handover Date</label>
                        <input type="date" name="dpo_handover_date" value="{{ old('dpo_handover_date') }}" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">DPO Handover Comments</label>
                        <textarea name="dpo_handover_comments" class="form-control">{{ old('dpo_handover_comments') }}</textarea>
                    </div>

                </div>
            </div>

            <div class="mt-3">
                <button class="btn btn-primary">Create</button>
                <a href="{{ route('external-solutions.index', ['status' => 'operational']) }}" class="btn btn-link">Back to List</a>
            </div>
        </form>
    </div>
</div>
@endsection
