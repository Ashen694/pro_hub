@extends('layouts.app')

@section('page-title', $pageTitle ?? 'Internal Activities')

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
        <h3 class="card-title">{{ $pageTitle ?? 'Internal Activities' }}</h3>
        <div class="ms-auto">
            <a href="{{ route('project-activities.create', ['type' => $type]) }}" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M12 5l0 14"></path><path d="M5 12l14 0"></path></svg>
                Create New
            </a>
        </div>
    </div>
    <div class="card-body border-bottom py-3">
        <form action="{{ route('project-activities.index', ['type' => $type]) }}" method="GET">
             <div class="d-flex">
                <div class="text-muted">Show<div class="mx-2 d-inline-block"><input type="text" class="form-control form-control-sm" value="{{ $activities->perPage() }}" size="3" disabled></div>entries</div>
                <div class="ms-auto d-flex align-items-center">
                    <div class="text-muted me-2">Search:</div>
                    <input type="text" name="search" class="form-control form-control-sm" value="{{ request('search') }}" placeholder="Search description, user...">
                    <button type="submit" class="btn btn-sm btn-primary ms-2">Search</button>
                    <a href="{{ route('project-activities.index', ['type' => $type]) }}" class="btn btn-sm btn-secondary ms-2">Reset</a>
                </div>
            </div>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table card-table table-vcenter text-nowrap datatable">
            <thead>
                <tr>
                    <th>Solution</th>
                    <th>Created Time</th>
                    <th>Created By</th>
                    <th>Target Date</th>
                    <th>Assigned To</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Updated Date</th>
                    <th>Updated By</th>
                    <th>Comment</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($activities as $activity)
                <tr>
                    <td>
                        @if($activity->Platform_ID == 1 && $activity->internalSolution)
                            {{-- If platform is Internal (ID 1) and the relationship exists --}}
                            {{ $activity->internalSolution->App_Name }}
                        @elseif($activity->Platform_ID == 2 && $activity->externalSolution)
                            {{-- If platform is External (ID 2) and the relationship exists --}}
                            {{ $activity->externalSolution->platform_name }}
                        @else
                            {{-- Fallback in case the solution was deleted or there's an issue --}}
                            <span class="text-muted">N/A</span>
                        @endif
                    </td>
                    <td>{{ \Carbon\Carbon::parse($activity->Created_Time)->format('Y-m-d H:i') }}</td>
                    <td>{{ $activity->creator->name ?? 'N/A' }}</td>
                    <td>{{ \Carbon\Carbon::parse($activity->Target_Date)->format('Y-m-d') }}</td>
                    <td>{{ $activity->assignee->Emp_Name ?? 'N/A' }}</td>
                    <td class="text-truncate" style="max-width: 200px;" title="{{ $activity->Description }}">{{ Str::limit($activity->Description, 40) }}</td>
                    <td><span class="badge bg-secondary">{{ $activity->Status }}</span></td>
                    <td>{{ $activity->Updated_Date ? \Carbon\Carbon::parse($activity->Updated_Date)->format('Y-m-d H:i') : '-' }}</td>
                    <td>{{ $activity->updater->name ?? '-' }}</td>
                    <td class="text-truncate" style="max-width: 150px;" title="{{ $activity->comments->last()->Comment ?? '' }}">{{ Str::limit($activity->comments->last()->Comment ?? '-', 30) }}</td>
                    <td class="text-center">
                        <div class="btn-list flex-nowrap justify-content-center">
                            {{-- VIEW BUTTON --}}
                            <button class="action-btn action-btn-view" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#viewModal" 
                                    data-url="{{ route('project-activities.show', $activity->ID) }}" 
                                    title="View Details">
                                <i class="ti ti-eye"></i>
                            </button>
                            
                            {{-- EDIT BUTTON --}}
                            <a href="{{ route('project-activities.edit', $activity->ID) }}" class="action-btn action-btn-edit" title="Edit"><i class="ti ti-pencil"></i></a>

                            {{-- DELETE BUTTON --}}
                            <button class="action-btn action-btn-delete" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#deleteModal" 
                                    data-id="{{ $activity->ID }}" 
                                    data-url="{{ route('project-activities.destroy', $activity->ID) }}"
                                    title="Delete">
                                <i class="ti ti-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="11" class="text-center py-5"><h3>No Data Available in Table</h3></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="card-footer d-flex align-items-center">
        @if($activities->total() > 0)
            <p class="m-0 text-muted">Showing <span>{{ $activities->firstItem() }}</span> to <span>{{ $activities->lastItem() }}</span> of <span>{{ $activities->total() }}</span> entries</p>
        @endif
        <div class="ms-auto">{{ $activities->links() }}</div>
    </div>
</div>


{{-- View Details Modal --}}
<div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewModalLabel">Activity Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="activity-details-content">
                {{-- Details will be loaded here via JavaScript --}}
                <div class="text-center p-5">
                    <div class="spinner-border" role="status"></div>
                    <p class="mt-2">Loading...</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

{{-- Delete Confirmation Modal --}}
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteModalLabel">Delete Activity Record</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger" role="alert">
                    <h4 class="alert-title">Confirm Deletion</h4>
                    <div class="text-muted">This action cannot be undone.</div>
                </div>
                <p class="mt-3">Are you sure you want to permanently delete the following record?</p>
                
                {{-- Details will be loaded here via JavaScript --}}
                <div id="delete-activity-details">
                    <div class="text-center p-4">
                        <div class="spinner-border spinner-border-sm" role="status"></div>
                        <span class="ms-2">Loading record details...</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <form id="delete-form" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Yes, Delete This Record</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // --- View Modal Logic  ---
    const viewModal = document.getElementById('viewModal');
    if (viewModal) {
        viewModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const url = button.getAttribute('data-url');
            const modalBody = document.getElementById('activity-details-content');
            modalBody.innerHTML = `<div class="text-center p-5"><div class="spinner-border" role="status"></div><p class="mt-2">Loading...</p></div>`;

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    modalBody.innerHTML = `
                        <dl class="row">
                            <dt class="col-sm-4">Activity ID</dt><dd class="col-sm-8">ACT-${data.id}</dd>
                            <dt class="col-sm-4">Solution</dt><dd class="col-sm-8">${data.solution_name}</dd>
                            <dt class="col-sm-4">Status</dt><dd class="col-sm-8"><span class="badge bg-secondary">${data.status}</span></dd>
                            <hr class="my-2"><dt class="col-sm-4">Created By</dt><dd class="col-sm-8">${data.created_by}</dd>
                            <dt class="col-sm-4">Created Time</dt><dd class="col-sm-8">${data.created_time}</dd>
                            <hr class="my-2"><dt class="col-sm-4">Assigned To</dt><dd class="col-sm-8">${data.assigned_to}</dd>
                            <dt class="col-sm-4">Target Date</dt><dd class="col-sm-8">${data.target_date}</dd>
                            <hr class="my-2"><dt class="col-sm-4">Last Updated By</dt><dd class="col-sm-8">${data.updated_by}</dd>
                            <dt class="col-sm-4">Last Updated Date</dt><dd class="col-sm-8">${data.updated_date}</dd>
                            <hr class="my-2"><dt class="col-sm-12">Description</dt>
                            <dd class="col-sm-12"><div class="card card-body bg-light mt-1 p-2">${data.description}</div></dd>
                        </dl>`;
                })
                .catch(error => {
                    console.error('Error fetching activity details:', error);
                    modalBody.innerHTML = '<p class="text-danger">Failed to load details. Please try again.</p>';
                });
        });
    }

    
    // --- Delete Modal Logic ---
    const deleteModal = document.getElementById('deleteModal');
    if (deleteModal) {
        deleteModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const actionUrl = button.getAttribute('data-url');
            const detailsUrl = actionUrl.replace('project-activities', 'project-activities').replace(/\/$/, '') + '/show'; // Construct the 'show' URL

            const deleteForm = document.getElementById('delete-form');
            const detailsContainer = document.getElementById('delete-activity-details');

            // Set the form action immediately
            deleteForm.action = actionUrl;

            // Set loading state for details
            detailsContainer.innerHTML = `<div class="text-center p-4"><div class="spinner-border spinner-border-sm" role="status"></div><span class="ms-2">Loading record details...</span></div>`;

            // Fetch details to display in the modal body
            fetch(detailsUrl)
                .then(response => response.json())
                .then(data => {
                    // Build the details card
                    detailsContainer.innerHTML = `
                        <div class="card card-sm bg-light mt-2">
                            <div class="card-body">
                                <dl class="row mb-0">
                                    <dt class="col-5">Record ID:</dt><dd class="col-7">ACT-${data.id}</dd>
                                    <dt class="col-5">Solution:</dt><dd class="col-7">${data.solution_name}</dd>
                                    <dt class="col-5">Created By:</dt><dd class="col-7">${data.created_by}</dd>
                                    <dt class="col-5">Target Date:</dt><dd class="col-7">${data.target_date}</dd>
                                </dl>
                            </div>
                        </div>`;
                })
                .catch(error => {
                    console.error('Error fetching details for delete modal:', error);
                    detailsContainer.innerHTML = '<p class="text-danger text-center">Could not load record details.</p>';
                });
        });
    }
});
</script>
@endpush