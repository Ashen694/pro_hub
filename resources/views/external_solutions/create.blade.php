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
            <input type="hidden" name="status" value="operational">

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Application/Platform Name</label>
                        <input type="text" name="platform_name" value="{{ old('platform_name') }}" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Company/Customer</label>
                        <select name="company_id" class="form-control">
                            <option value="">Please select</option>
                            @foreach($companies ?? [] as $company)
                                <option value="{{ $company->id }}" @if(old('company_id') == $company->id) selected @endif>{{ $company->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Developed By</label>
                        <select name="developed_by" class="form-control">
                            <option value="">Please select</option>
                            @foreach($employees ?? [] as $employee)
                                <option value="{{ $employee->Emp_Name }}" @if(old('developed_by') == $employee->Emp_Name) selected @endif>
                                    {{ $employee->Emp_Name }}
                                </option>
                            @endforeach
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
                            @foreach($sdlc_stages ?? [] as $stage)
                                <option value="{{ $stage->Phase }}" @if(old('sdlc_stage') == $stage->Phase) selected @endif>
                                    {{ $stage->Phase }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Percentage Done</label>
                        <input type="text" name="percentage_done" value="{{ old('percentage_done') }}" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">BitBucket Repository Name</label>
                        <input type="text" name="bit_bucket_repo" value="{{ old('bit_bucket_repo') }}" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Sales Team Involved</label>
                        <select name="sales_team_involved" class="form-control">
                            <option value="">Please select</option>
                            <option value="Government Business" @if(old('sales_team_involved') == 'Government Business') selected @endif>Government Business</option>
                            <option value="Enterprise Business" @if(old('sales_team_involved') == 'Enterprise Business') selected @endif>Enterprise Business</option>
                            <option value="Carrier Business" @if(old('sales_team_involved') == 'Carrier Business') selected @endif>Carrier Business</option>
                            <option value="Region Business" @if(old('sales_team_involved') == 'Region Business') selected @endif>Region Business</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Sales Account Manager</label>
                        <input type="text" name="sales_am" value="{{ old('sales_am') }}" class="form-control">
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
                        <input type="number" step="0.01" name="platform_otc" value="{{ old('platform_otc') }}" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Monthly Recurrent Charge (MRC)</label>
                        <input type="number" step="0.01" name="platform_mrc" value="{{ old('platform_mrc') }}" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Value of the Software (Out Of Total Solution Value)</label>
                        <input type="number" step="0.01" name="software_value" value="{{ old('software_value') }}" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Contract Period (Years)</label>
                        <input type="text" name="contract_period" value="{{ old('contract_period') }}" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Support Availability</label>
                        <select name="support_availability" class="form-control">
                            <option value="">Please select</option>
                            <option value="24x7" @if(old('support_availability') == '24x7') selected @endif>24x7</option>
                            <option value="24x5" @if(old('support_availability') == '24x5') selected @endif>24x5</option>
                            <option value="8x5" @if(old('support_availability') == '8x5') selected @endif>8x5</option>
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