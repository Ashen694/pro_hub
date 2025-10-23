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
            @if(isset($status) && $status === 'prospective')
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Application Name</label>
                            <input type="text" name="application_name" value="{{ old('application_name') }}" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Company/Customer</label>
                            <input type="text" name="company_customer" value="{{ old('company_customer') }}" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Developed By</label>
                            <input type="text" name="developed_by" value="{{ old('developed_by') }}" class="form-control">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">SDLC Stage</label>
                            <select name="sdlc_stage" class="form-control">
                                <option value="">Please select</option>
                                <option value="Proposal/Preparation" {{ old('sdlc_stage')=='Proposal/Preparation' ? 'selected' : '' }}>Proposal/Preparation</option>
                                <option value="Requirement Gathering" {{ old('sdlc_stage')=='Requirement Gathering' ? 'selected' : '' }}>Requirement Gathering</option>
                                <option value="Development" {{ old('sdlc_stage')=='Development' ? 'selected' : '' }}>Development</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Start Date</label>
                            <input type="date" name="start_date" value="{{ old('start_date') }}" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">DPO Handover Date</label>
                            <input type="date" name="dpo_handover_date" value="{{ old('dpo_handover_date') }}" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="mt-3">
                    <button class="btn btn-primary">Create</button>
                    <a href="{{ route('external-solutions.index', ['status' => 'prospective']) }}" class="btn btn-link">Back to List</a>
                </div>
            @else
                {{-- keep the original full form for operational by default --}}
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Application/Platform Name</label>
                            <input type="text" name="application_name" value="{{ old('application_name') }}" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Company/Customer</label>
                            <input type="text" name="company_customer" value="{{ old('company_customer') }}" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Developed By</label>
                            <input type="text" name="developed_by" value="{{ old('developed_by') }}" class="form-control">
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
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Sales Team Involved</label>
                            <select name="sales_team_involved" class="form-control">
                                <option value="">Please select</option>
                                <option value="Government Business" {{ old('sales_team_involved')=='Government Business' ? 'selected' : '' }}>Government Business</option>
                                <option value="Enterprise Business" {{ old('sales_team_involved')=='Enterprise Business' ? 'selected' : '' }}>Enterprise Business</option>
                                <option value="Carrier Business" {{ old('sales_team_involved')=='Carrier Business' ? 'selected' : '' }}>Carrier Business</option>
                                <option value="Region Business" {{ old('sales_team_involved')=='Region Business' ? 'selected' : '' }}>Region Business</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Sales Account Manager</label>
                            <input type="text" name="sales_account_manager" value="{{ old('sales_account_manager') }}" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Launched Date</label>
                            <input type="date" name="launched_date" value="{{ old('launched_date') }}" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Monthly Recurrent Charge (MRC)</label>
                            <input type="number" step="0.01" name="monthly_recurring_charge" value="{{ old('monthly_recurring_charge') }}" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">DPO Handover Date</label>
                            <input type="date" name="dpo_handover_date" value="{{ old('dpo_handover_date') }}" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="mt-3">
                    <button class="btn btn-primary">Create</button>
                    <a href="{{ route('external-solutions.index', ['status' => 'operational']) }}" class="btn btn-link">Back to List</a>
                </div>
            @endif
        </form>
    </div>
</div>
@endsection
