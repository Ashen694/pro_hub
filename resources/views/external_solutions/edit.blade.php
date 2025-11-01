@extends('layouts.app')

@section('page-title', $title ?? 'Edit External Solution')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ $title }}</h3>
    </div>
    <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-danger"><ul class="mb-0">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
        @endif

        <form action="{{ route('external-solutions.update', $solution->platform_id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3"><label class="form-label">Platform Name</label><input type="text" name="platform_name" value="{{ old('platform_name', $solution->platform_name) }}" class="form-control" required></div>
                    <div class="mb-3"><label class="form-label">Platform Type</label><input type="text" name="platform_type" value="{{ old('platform_type', $solution->platform_type) }}" class="form-control"></div>
                    <div class="mb-3"><label class="form-label">Developed By</label><input type="text" name="developed_by" value="{{ old('developed_by', $solution->developed_by) }}" class="form-control"></div>
                    <div class="mb-3"><label class="form-label">Developed Team</label><input type="text" name="developed_team" value="{{ old('developed_team', $solution->developed_team) }}" class="form-control"></div>
                    <div class="mb-3"><label class="form-label">Start Date</label><input type="date" name="start_date" value="{{ old('start_date', optional($solution->start_date)->format('Y-m-d')) }}" class="form-control"></div>
                    <div class="mb-3"><label class="form-label">Target Date</label><input type="date" name="target_date" value="{{ old('target_date', optional($solution->target_date)->format('Y-m-d')) }}" class="form-control"></div>
                    <div class="mb-3"><label class="form-label">SDLC Stage</label><input type="text" name="sdlc_stage" value="{{ old('sdlc_stage', $solution->sdlc_stage) }}" class="form-control"></div>
                    <div class="mb-3"><label class="form-label">Percentage Done</label><input type="number" name="percentage_done" value="{{ old('percentage_done', $solution->percentage_done) }}" class="form-control"></div>
                     <div class="mb-3"><label class="form-label">Status</label>
                        <select name="status" class="form-select" required>
                            <option value="operational" {{ old('status', $solution->status) == 'operational' ? 'selected' : '' }}>Operational</option>
                            <option value="prospective" {{ old('status', $solution->status) == 'prospective' ? 'selected' : '' }}>Prospective</option>
                            <option value="retired" {{ old('status', $solution->status) == 'retired' ? 'selected' : '' }}>Retired</option>
                            <option value="abandoned" {{ old('status', $solution->status) == 'abandoned' ? 'selected' : '' }}>Abandoned</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3"><label class="form-label">Platform Owner (Customer)</label><input type="text" name="platform_owner" value="{{ old('platform_owner', $solution->platform_owner) }}" class="form-control"></div>
                    <div class="mb-3"><label class="form-label">Operations Owner</label><input type="text" name="app_op_owner" value="{{ old('app_op_owner', $solution->app_op_owner) }}" class="form-control"></div>
                    <div class="mb-3"><label class="form-label">Sales AM</label><input type="text" name="sales_am" value="{{ old('sales_am', $solution->sales_am) }}" class="form-control"></div>
                    <div class="mb-3"><label class="form-label">Launched Date</label><input type="date" name="launched_date" value="{{ old('launched_date', optional($solution->launched_date)->format('Y-m-d')) }}" class="form-control"></div>
                    <div class="mb-3"><label class="form-label">One-Time Charge (OTC)</label><input type="text" name="platform_otc" value="{{ old('platform_otc', $solution->platform_otc) }}" class="form-control"></div>
                    <div class="mb-3"><label class="form-label">Monthly Recurring Charge (MRC)</label><input type="text" name="platform_mrc" value="{{ old('platform_mrc', $solution->platform_mrc) }}" class="form-control"></div>
                    <div class="mb-3"><label class="form-label">Software Value</label><input type="number" step="0.01" name="software_value" value="{{ old('software_value', $solution->software_value) }}" class="form-control"></div>
                    <div class="mb-3"><label class="form-label">Backup Officer #1</label><input type="text" name="backup_officer_1" value="{{ old('backup_officer_1', $solution->backup_officer_1) }}" class="form-control"></div>
                    <div class="mb-3"><label class="form-label">Backup Officer #2</label><input type="text" name="backup_officer_2" value="{{ old('backup_officer_2', $solution->backup_officer_2) }}" class="form-control"></div>
                </div>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Save Changes</button>
                <a href="{{ route('external-solutions.index', ['status' => $solution->status]) }}" class="btn btn-link">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection