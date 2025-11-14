@extends('layouts.app')

@section('page-title', $pageTitle ?? 'Edit Activity')

@push('styles')
<style>
    /* Style for disabled cursor */
    input[disabled], select[disabled], textarea[disabled] {
        cursor: not-allowed !important;
        background-color: #f6f7f9;
    }
</style>
@endpush

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ $pageTitle }}</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('project-activities.update', $activity->ID) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Error Display --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                </div>
            @endif

            <div class="row">
                <div class="col-lg-8 offset-lg-2">

                    {{-- DISABLED FIELDS --}}
                    <div class="mb-3">
                        <label class="form-label">Platform</label>
                        <input type="text" class="form-control" value="{{ ($type == 'internal') ? 'Internal Solution' : 'External Solution' }}" disabled>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Solution</label>
                        <input type="text" class="form-control" value="{{ $activity->internalSolution->App_Name ?? $activity->externalSolution->platform_name ?? 'N/A' }}" disabled>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" rows="4" disabled>{{ $activity->Description }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Created By</label>
                        <input type="text" class="form-control" value="{{ $activity->creator->name ?? 'N/A' }}" disabled>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Created Time</label>
                        <input type="text" class="form-control" value="{{ \Carbon\Carbon::parse($activity->Created_Time)->format('m/d/Y h:i:s A') }}" disabled>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Assigned To</label>
                        <input type="text" class="form-control" value="{{ $activity->assignee->Emp_Name ?? 'N/A' }}" disabled>
                    </div>

                    <hr class="my-4">

                    {{-- EDITABLE FIELDS --}}
                    <div class="mb-3">
                        <label class="form-label required">Target Date</label>
                        <input type="date" class="form-control" name="Target_Date" value="{{ old('Target_Date', \Carbon\Carbon::parse($activity->Target_Date)->format('Y-m-d')) }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label required">Status</label>
                        <select class="form-select" name="Status" required>
                            @foreach (['Open', 'In Progress', 'Close'] as $status)
                                <option value="{{ $status }}" {{ old('Status', $activity->Status) == $status ? 'selected' : '' }}>
                                    {{ $status }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Comment</label>
                        <textarea class="form-control" name="Comment" rows="4" placeholder="Add an update or comment..."></textarea>
                    </div>

                    <hr class="my-4">
                    
                    
                    <div class="mb-3">
                        <label class="form-label">Updated By</label>
                        <input type="text" class="form-control" value="{{ Auth::user()->name }}" disabled>
                    </div>

                    <div class="form-footer d-flex justify-content-between">
                         <a href="{{ route('project-activities.index', ['type' => $type]) }}" class="btn btn-link">Back to List</a>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
@endpush