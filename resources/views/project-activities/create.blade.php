@extends('layouts.app')

@section('page-title', $pageTitle ?? 'Create Activity')

@push('styles')
<style>
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
        <form action="{{ route('project-activities.store', ['type' => $type]) }}" method="POST">
            @csrf

            {{-- Display validation errors if any --}}
            @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                    <h4 class="alert-title">Errors Found</h4>
                    <div class="text-muted">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <div class="row">
                <div class="col-lg-8 offset-lg-2">


                    <div class="mb-3">
                        <label class="form-label">Platform</label>
                        @php
                            // Determine the correct Platform ID and Name based on the URL type
                            $platformId = ($type == 'internal') ? 1 : 2;
                            $platformName = $platforms->firstWhere('ID', $platformId)->Platforms ?? ucfirst($type) . ' Solution';
                        @endphp
                        
                        {{-- This hidden input sends the actual ID when the form is submitted --}}
                        <input type="hidden" name="Platform_ID" value="{{ $platformId }}">
                        
                        {{-- This visible text input is disabled and just for display purposes --}}
                        <input type="text" class="form-control" value="{{ $platformName }}" disabled>
                    </div>

                    <div class="mb-3">
                        <label class="form-label required">Solution</label>
                        <select class="form-select" name="Solution_ID" id="tom-select-solution" required>
                             <option value="">Select a solution...</option>
                            @foreach ($solutions as $solution)
                                <option value="{{ $solution->ID ?? $solution->platform_id }}" {{ old('Solution_ID') == ($solution->ID ?? $solution->platform_id) ? 'selected' : '' }}>
                                    {{ $solution->App_Name ?? $solution->platform_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label required">Description</label>
                        <textarea class="form-control" name="Description" rows="5" placeholder="Enter activity description..." required>{{ old('Description') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Created By</label>
                        <input type="text" class="form-control" value="{{ Auth::user()->name }}" disabled>
                    </div>

                    <div class="mb-3">
                        <label class="form-label required">Assigned To</label>
                        <select class="form-select" name="Assigned_To" id="tom-select-assigned" required>
                             <option value="">Select a user...</option>
                            @foreach ($employees as $employee)
                                <option value="{{ $employee->Emp_ID }}" {{ old('Assigned_To') == $employee->Emp_ID ? 'selected' : '' }}>
                                    {{ $employee->Emp_Name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label required">Target Date</label>
                        <input type="date" class="form-control" name="Target_Date" value="{{ old('Target_Date') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <input type="text" class="form-control" value="Open" disabled>
                    </div>
                    
                    <div class="form-footer d-flex justify-content-between">
                         <a href="{{ route('project-activities.index', ['type' => $type]) }}" class="btn btn-link">Back to List</a>
                        <button type="submit" class="btn btn-primary">Create</button>
                    </div>

                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
{{-- TomSelect for searchable dropdowns --}}
<script>
    document.addEventListener("DOMContentLoaded", function () {
        new TomSelect('#tom-select-solution',{
            create: false,
            sortField: { field: "text", direction: "asc" }
        });
        new TomSelect('#tom-select-assigned',{
            create: false,
            sortField: { field: "text", direction: "asc" }
        });
    });
</script>
@endpush