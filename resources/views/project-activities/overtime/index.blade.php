@extends('layouts.app')

@section('page-title', 'OverTime Data')

@push('styles')
    <style>
        .action-btn { display: inline-flex; align-items: center; justify-content: center; width: 36px; height: 36px; border-radius: 8px; text-decoration: none !important; transition: all 0.2s ease-in-out; border: none; }
        .action-btn:hover { transform: translateY(-2px); box-shadow: 0 3px 10px rgba(0, 0, 0, 0.12); }
        .action-btn i { font-size: 16px; }
        .action-btn-edit { background-color: #e6f0ff; } .action-btn-edit i { color: #0057ff; } .action-btn-edit:hover { background-color: #cce0ff; }
        .action-btn-view { background-color: #e3f9e5; } .action-btn-view i { color: #28a745; } .action-btn-view:hover { background-color: #c1f2c6; }
        .action-btn-delete { background-color: #ffe6e6; cursor: pointer; } .action-btn-delete i { color: #dc3545; } .action-btn-delete:hover { background-color: #ffcccc; }
        .modal-header .btn-close-white { filter: invert(1) grayscale(100%) brightness(200%); }
    </style>
@endpush

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">OverTime Data</h3>
        <div class="ms-auto">
            <a href="{{ route('project-activities.overtime.create') }}" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M12 5l0 14"></path><path d="M5 12l14 0"></path></svg>
                Create New
            </a>
        </div>
    </div>
    <div class="card-body border-bottom py-3">
        <form action="{{ route('project-activities.overtime.index') }}" method="GET">
             <div class="d-flex">
                <div class="text-muted">Show<div class="mx-2 d-inline-block"><input type="text" class="form-control form-control-sm" value="{{ $overtimes->perPage() }}" size="3" disabled></div>entries</div>
                <div class="ms-auto d-flex align-items-center">
                    <div class="text-muted me-2">Search:</div>
                    <input type="text" name="search" class="form-control form-control-sm" value="{{ request('search') }}" placeholder="Search by description, name...">
                    <button type="submit" class="btn btn-sm btn-primary ms-2">Search</button>
                    <a href="{{ route('project-activities.overtime.index') }}" class="btn btn-sm btn-secondary ms-2">Reset</a>
                </div>
            </div>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table card-table table-vcenter text-nowrap datatable">
            <thead>
                <tr>
                    <th>Created Date</th><th>Created By</th><th>Work Date</th><th>No Of Hours</th><th>Work Description</th><th>Approval For</th><th>Approved Date</th><th>Approved By</th><th>Comment</th><th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($overtimes as $item)
                <tr>
                    <td>{{ $item->Created_Date->format('Y-m-d H:i') }}</td>
                    <td>{{ $item->creator->name ?? 'N/A' }}</td>
                    <td>{{ $item->Date->format('Y-m-d') }}</td>
                    <td>{{ number_format($item->No_Of_Hours, 2) }}</td>
                    <td class="text-truncate" style="max-width: 200px;" title="{{ $item->Work_Description }}">{{ Str::limit($item->Work_Description, 50) }}</td>
                    <td>{{ $item->approvalForUser->Emp_Name ?? 'N/A' }}</td>
                    <td>{{ $item->Approved_Date ? $item->Approved_Date->format('Y-m-d H:i:s') : '' }}</td>
                    <td>{{ $item->approver->Emp_Name ?? '' }}</td>
                    <td class="text-truncate" style="max-width: 150px;" title="{{ $item->Comment }}">{{ Str::limit($item->Comment, 30) }}</td>
                    <td class="text-center">
                        <div class="btn-list flex-nowrap justify-content-center">
                            <button class="action-btn action-btn-view" data-bs-toggle="modal" data-bs-target="#view-modal-{{ $item->ID }}" title="View Details"><i class="ti ti-eye"></i></button>
                            <a href="{{ route('project-activities.overtime.edit', $item->ID) }}" class="action-btn action-btn-edit" title="Edit"><i class="ti ti-pencil"></i></a>
                            <button class="action-btn action-btn-delete" data-bs-toggle="modal" data-bs-target="#delete-modal-{{ $item->ID }}" title="Delete"><i class="ti ti-trash"></i></button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="10" class="text-center py-5"><h3>No Overtime Data Found</h3><p class="text-muted">Get started by creating a new overtime entry.</p></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="card-footer d-flex align-items-center">
        @if($overtimes->total() > 0)<p class="m-0 text-muted">Showing <span>{{ $overtimes->firstItem() }}</span> to <span>{{ $overtimes->lastItem() }}</span> of <span>{{ $overtimes->total() }}</span> entries</p>@endif
        <div class="ms-auto">{{ $overtimes->links() }}</div>
    </div>
</div>

@foreach($overtimes as $item)
    <div class="modal modal-blur fade" id="view-modal-{{ $item->ID }}" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="ti ti-clock-hour-4 me-2"></i> OverTime Details</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-4">
                    <div class="row g-3">
                        <div class="col-12"><div class="card card-sm"><div class="card-header"><h4 class="card-title"><i class="ti ti-info-circle me-2"></i> General Information</h4></div><div class="card-body"><div class="row row-cards">
                            <div class="col-md-6 mb-2"><label class="form-label text-muted">Created By:</label><p class="form-control-plaintext">{{ $item->creator->name ?? 'N/A' }}</p></div>
                            <div class="col-md-6 mb-2"><label class="form-label text-muted">Created Date:</label><p class="form-control-plaintext">{{ $item->Created_Date->format('Y-m-d H:i:s') }}</p></div>
                            <div class="col-md-6 mb-2"><label class="form-label text-muted">Work Date:</label><p class="form-control-plaintext"><strong>{{ $item->Date->format('Y-m-d') }}</strong></p></div>
                            <div class="col-md-6 mb-2"><label class="form-label text-muted">Number of Hours:</label><p class="form-control-plaintext"><strong>{{ number_format($item->No_Of_Hours, 2) }} hours</strong></p></div>
                            <div class="col-12 mb-2"><label class="form-label text-muted">Work Description:</label><p class="form-control-plaintext" style="white-space: pre-wrap;">{{ $item->Work_Description }}</p></div>
                        </div></div></div></div>
                        <div class="col-12"><div class="card card-sm"><div class="card-header"><h4 class="card-title"><i class="ti ti-user-check me-2"></i> Approval Details</h4></div><div class="card-body"><div class="row row-cards">
                            <div class="col-md-6 mb-2"><label class="form-label text-muted">Approval For:</label><p class="form-control-plaintext">{{ $item->approvalForUser->Emp_Name ?? 'N/A' }}</p></div>
                            <div class="col-md-6 mb-2"><label class="form-label text-muted">Approved By:</label><p class="form-control-plaintext">{{ $item->approver->Emp_Name ?? '-' }}</p></div>
                            <div class="col-md-6 mb-2"><label class="form-label text-muted">Approved Date:</label><p class="form-control-plaintext">{{ $item->Approved_Date ? $item->Approved_Date->format('Y-m-d H:i:s') : '-' }}</p></div>
                            <div class="col-12 mb-2"><label class="form-label text-muted">Comment:</label><p class="form-control-plaintext" style="white-space: pre-wrap;">{{ $item->Comment ?? '-' }}</p></div>
                        </div></div></div></div>
                    </div>
                </div>
                <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button></div>
            </div>
        </div>
    </div>

    <div class="modal modal-blur fade" id="delete-modal-{{ $item->ID }}" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">Delete Overtime Record</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger" role="alert">
                        <h4 class="alert-title">Confirm Deletion</h4>
                        <div class="text-muted">This action cannot be undone.</div>
                    </div>
                    <p class="mt-3">Are you sure you want to permanently delete the following record?</p>
                    <div class="card card-sm bg-light mt-2">
                        <div class="card-body">
                            <dl class="row mb-0">
                                <dt class="col-4">Record ID:</dt><dd class="col-8">OT-{{ $item->ID }}</dd>
                                <dt class="col-4">Created By:</dt><dd class="col-8">{{ $item->creator->name ?? 'N/A' }}</dd>
                                <dt class="col-4">Work Date:</dt><dd class="col-8">{{ $item->Date->format('Y-m-d') }}</dd>
                                <dt class="col-4">Hours:</dt><dd class="col-8">{{ number_format($item->No_Of_Hours, 2) }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form action="{{ route('project-activities.overtime.destroy', $item->ID) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Yes, Delete This Record</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach
@endsection