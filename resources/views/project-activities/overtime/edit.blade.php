@extends('layouts.app')

@section('page-title', 'Edit OverTime Entry')

@push('styles')
    <style>
        .form-control:disabled, 
        .form-control[readonly],
        textarea:disabled {
            cursor: not-allowed;
            background-color: #f5f7fb;
        }
    </style>
@endpush

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Edit OverTime Entry</h3>
                <div class="card-actions">
                    <a href="{{ route('project-activities.overtime.index') }}" class="btn btn-secondary">
                        <i class="ti ti-arrow-left me-1"></i> Back to List
                    </a>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('project-activities.overtime.update', $overtime->ID) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Created Date</label>
                            <input type="text" class="form-control" value="{{ $overtime->Created_Date->format('Y-m-d H:i:s') }}" disabled>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Created By</label>
                            <input type="text" class="form-control" value="{{ $overtime->creator->name ?? 'N/A' }}" disabled>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label">Work Date</label>
                            <input type="text" class="form-control" value="{{ $overtime->Date->format('Y-m-d') }}" disabled>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label">No Of Hours</label>
                            <input type="text" class="form-control" value="{{ number_format($overtime->No_Of_Hours, 2) }}" disabled>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Work Description</label>
                            <textarea class="form-control" rows="4" disabled>{{ $overtime->Work_Description }}</textarea>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Approval For</label>
                            <input type="text" class="form-control" value="{{ $overtime->approvalForUser->Emp_Name ?? 'N/A' }}" disabled>
                        </div>

                        <div class="col-md-12">
                            <label for="comment" class="form-label">Comment</label>
                            <textarea id="comment" name="Comment" class="form-control @error('Comment') is-invalid @enderror" rows="3" placeholder="Add approval or rejection comments here...">{{ old('Comment', $overtime->Comment) }}</textarea>                            @error('comment')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label">Approved By</label>
                            <input type="text" class="form-control" value="{{ $overtime->approver->Emp_Name ?? '-' }}" disabled>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label">Approved Date</label>
                            <input type="text" class="form-control" value="{{ $overtime->Approved_Date ? $overtime->Approved_Date->format('Y-m-d H:i:s') : '-' }}" disabled>
                        </div>
                    </div>

                    <div class="mt-4 text-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-device-floppy me-1"></i> Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection