@extends('layouts.app')

@section('page-title', $title ?? 'Edit External Solution')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ $title ?? 'Edit External Solution' }}</h3>
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

        <form action="{{ route('external-solutions.update', $externalSolution->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Application/Platform Name</label>
                        <input type="text" name="application_name" value="{{ old('application_name', $externalSolution->application_name) }}" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Sales Team Involved</label>
                        <select name="sales_team_involved" class="form-control">
                    <div class="mb-3">
                        <label>SDLC Stage</label>
                        <select name="sdlc_stage" class="form-control">
                            <option value="">Please select</option>
                            @foreach(['Proposal/Preparation','Requirement Gathering','Development'] as $stage)
                                <option value="{{ $stage }}" {{ old('sdlc_stage', old('dplo_stage', $externalSolution->sdlc_stage ?? $externalSolution->dplo_stage))==$stage ? 'selected' : '' }}>{{ $stage }}</option>
                            @endforeach
                        </select>
                    </div>
                        <select name="support_availability" class="form-control">
                            <option value="">Please select</option>
                            @foreach(['24x7','24x5','8x5'] as $opt)
                                <option value="{{ $opt }}" {{ old('support_availability', $externalSolution->support_availability)==$opt ? 'selected' : '' }}>{{ $opt }}</option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Add more fields as needed, similar to create.blade.php -->
                </div>
            </div>

            <div class="mt-3">
                <button class="btn btn-primary">Save</button>
                <a href="{{ route('external-solutions.index', ['status' => 'operational']) }}" class="btn btn-link">Back to List</a>
            </div>
        </form>
    </div>
</div>
@endsection
