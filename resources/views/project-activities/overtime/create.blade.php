@extends('layouts.app')

@section('page-title', 'Create OverTime Entry')
@push('styles')<style>.form-control:disabled,.form-control[readonly]{cursor:not-allowed;background-color:#f5f7fb}</style>@endpush

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header"><h3 class="card-title">Create New OverTime Entry</h3><div class="card-actions"><a href="{{ route('project-activities.overtime.index') }}" class="btn btn-secondary"><i class="ti ti-arrow-left me-1"></i> Back to List</a></div></div>
            <div class="card-body">
                <form action="{{ route('project-activities.overtime.store') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="created_by" class="form-label">Created By</label>
                            {{-- THIS IS THE KEY CHANGE --}}
                            <input type="text" id="created_by" class="form-control" value="{{ Auth::user()?->name ?? 'Unknown User' }}" disabled>
                            {{-- END OF CHANGE --}}
                        </div>
                        <div class="col-md-6">
                            <label for="work_date" class="form-label required">Work Date</label>
                            <input type="date" id="work_date" name="date" class="form-control @error('date') is-invalid @enderror" value="{{ old('date') }}" required>
                             @error('date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-12">
                            <label for="no_of_hours" class="form-label required">No Of Hours</label>
                            <input type="number" step="0.01" min="0.01" id="no_of_hours" name="no_of_hours" class="form-control @error('no_of_hours') is-invalid @enderror" placeholder="e.g., 2.5" value="{{ old('no_of_hours') }}" required>
                             @error('no_of_hours') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-12">
                            <label for="work_description" class="form-label required">Work Description</label>
                            <textarea id="work_description" name="work_description" class="form-control @error('work_description') is-invalid @enderror" rows="4" required>{{ old('work_description') }}</textarea>
                             @error('work_description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-12">
                            <label for="approval_for" class="form-label required">Approval For</label>
                            <select id="approval_for" name="approval_for" class="form-select @error('approval_for') is-invalid @enderror" required>
                                <option value="" selected disabled>Select an employee...</option>
                                @foreach($employees as $employee)
                                    <option value="{{ $employee->Emp_ID }}" {{ old('approval_for') == $employee->Emp_ID ? 'selected' : '' }}>
                                        {{ $employee->Emp_Name }}
                                    </option>
                                @endforeach
                            </select>
                             @error('approval_for') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="mt-4 text-end">
                        <button type="submit" class="btn btn-primary"><i class="ti ti-device-floppy me-1"></i> Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection