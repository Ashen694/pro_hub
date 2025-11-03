@extends('layouts.app')

@section('page-title', 'Internal Solution Issues')

@push('styles')
    <style>
        /* Action Buttons Styles */
        .action-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            border-radius: 8px;
            text-decoration: none !important;
            transition: all 0.2s ease-in-out;
            border: none;
            cursor: pointer;
            margin: 0 2px;
        }
        .action-btn i { font-size: 16px; }
        .action-btn-view { background-color: #e3f9e5; }
        .action-btn-view i { color: #28a745; }
        .action-btn-view:hover { background-color: #c1f2c6; }
        .action-btn-edit { background-color: #e6f0ff; }
        .action-btn-edit i { color: #0057ff; }
        .action-btn-edit:hover { background-color: #cce0ff; }
        .action-btn-delete { background-color: #ffe6e6; }
        .action-btn-delete i { color: #dc3545; }
        .action-btn-delete:hover { background-color: #ffcccc; }
        
        /* Modal Details Styles */
        .modal-details .detail-label { color: #626976; font-weight: 600; margin-bottom: 0.25rem; }
        .modal-details .detail-value { font-weight: 500; word-break: break-word; margin-bottom: 1rem; }
        #deleteConfirmationModal .modal-header { background-color: #d9534f; color: white; border-bottom: none; }
        #deleteConfirmationModal .btn-close-white { filter: invert(1) grayscale(100%) brightness(200%); }
    </style>
@endpush

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title mb-0">Issues Reported on Internal Solutions</h3>
        <a href="{{ route('incidents.internal.create') }}" class="btn btn-primary">+ Create New Issue</a>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="d-flex align-items-center">
                <label for="entries" class="form-label me-2 mb-0">Show</label>
                <select id="entries" class="form-select form-select-sm" style="width: auto;">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                </select>
                <span class="ms-2">entries</span>
            </div>
            <div class="d-flex align-items-center">
                <input type="search" class="form-control form-control-sm" placeholder="Search...">
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>REF ID</th>
                        <th>START TIME</th>
                        <th>PLATFORM/SOLUTION</th>
                        <th>DESCRIPTION</th>
                        <th>STATUS</th>
                        <th>ASSIGNED TO</th>
                        <th class="text-center">ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($issues as $issue)
                        <tr>
                            <td>INT-{{ str_pad($issue->ID, 4, '0', STR_PAD_LEFT) }}</td>
                            <td>{{ \Carbon\Carbon::parse($issue->Issue_Start_Time)->format('Y-m-d h:i A') }}</td>
                            <td>{{ $issue->Internal_APP_ID }}</td>
                            <td>{{ Str::limit($issue->Description, 40) }}</td>
                            <td><span class="badge bg-secondary">{{ $issue->Status }}</span></td>
                            <td>{{ $issue->Assigned_To }}</td>
                            <td class="text-center d-flex justify-content-center">
                                <!-- View Button (Modal Trigger) -->
                                <button type="button" class="action-btn action-btn-view" data-bs-toggle="modal" data-bs-target="#issueDetailsModal" 
                                    data-ref-id="INT-{{ str_pad($issue->ID, 4, '0', STR_PAD_LEFT) }}"
                                    data-start-time="{{ \Carbon\Carbon::parse($issue->Issue_Start_Time)->format('F d, Y h:i A') }}"
                                    data-platform="{{ $issue->Internal_APP_ID }}"
                                    data-reported-by="{{ $issue->Reported_By }}"
                                    data-contact="{{ $issue->Reporting_Person_ContactNo ?? 'N/A' }}"
                                    data-description="{{ $issue->Description }}"
                                    data-criticality="{{ $issue->Criticality }}"
                                    data-status="{{ $issue->Status }}"
                                    data-assigned-to="{{ $issue->Assigned_To }}"
                                    data-assigned-by="{{ $issue->Assigned_By }}"
                                    data-action-taken="{{ $issue->Action_Taken ?? 'No action recorded yet.' }}">
                                    <i class="ti ti-eye"></i>
                                </button>
                                
                                <!-- Edit Button -->
                                <a href="{{ route('incidents.internal.edit', $issue->ID) }}" class="action-btn action-btn-edit">
                                    <i class="ti ti-pencil"></i>
                                </a>

                                <!-- Delete Button (Modal Trigger) -->
                                <button type="button" class="action-btn action-btn-delete" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#deleteConfirmationModal"
                                    data-ref-id="INT-{{ str_pad($issue->ID, 4, '0', STR_PAD_LEFT) }}"
                                    data-platform="{{ $issue->Internal_APP_ID }}"
                                    data-start-time="{{ \Carbon\Carbon::parse($issue->Issue_Start_Time)->format('Y-m-d h:i A') }}"
                                    data-delete-url="{{ route('incidents.internal.destroy', $issue->ID) }}">
                                    <i class="ti ti-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center">No internal issues found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- View Details Modal -->
<div class="modal fade" id="issueDetailsModal" tabindex="-1" aria-labelledby="issueDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="issueDetailsModalLabel">Issue Details: <span id="modalRefId"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body modal-details">
                <div class="row">
                    <div class="col-md-6"><div class="detail-label">Platform/Solution</div><div class="detail-value" id="modalPlatform"></div></div>
                    <div class="col-md-6"><div class="detail-label">Issue Start Time</div><div class="detail-value" id="modalStartTime"></div></div>
                    <div class="col-md-6"><div class="detail-label">Status</div><div class="detail-value"><span class="badge" id="modalStatus"></span></div></div>
                    <div class="col-md-6"><div class="detail-label">Criticality</div><div class="detail-value" id="modalCriticality"></div></div>
                    <div class="col-md-6"><div class="detail-label">Reported By</div><div class="detail-value" id="modalReportedBy"></div></div>
                    <div class="col-md-6"><div class="detail-label">Reporter Contact</div><div class="detail-value" id="modalContact"></div></div>
                    <div class="col-12"><div class="detail-label">Incident Description</div><div class="detail-value p-2 bg-light rounded" id="modalDescription"></div></div>
                    <hr class="my-3">
                    <div class="col-md-6"><div class="detail-label">Assigned To</div><div class="detail-value" id="modalAssignedTo"></div></div>
                    <div class="col-md-6"><div class="detail-label">Assigned By</div><div class="detail-value" id="modalAssignedBy"></div></div>
                    <div class="col-12"><div class="detail-label">Action Taken</div><div class="detail-value p-2 bg-light rounded" id="modalActionTaken"></div></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Delete Issue</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <strong>Confirm delete?</strong> This action cannot be undone.
                </div>
                <div class="modal-details mt-3">
                    <div class="detail-label">Ref ID</div><div class="detail-value" id="modalDeleteRefId"></div>
                    <div class="detail-label">Platform</div><div class="detail-value" id="modalDeletePlatform"></div>
                    <div class="detail-label">Issue Start Time</div><div class="detail-value" id="modalDeleteStartTime"></div>
                </div>
            </div>
            <div class="modal-footer">
                <form id="deleteForm" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // View Modal Script
        var issueDetailsModal = document.getElementById('issueDetailsModal');
        issueDetailsModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            // ... (populate all view modal fields) ...
            var modalTitle = issueDetailsModal.querySelector('.modal-title #modalRefId');
            modalTitle.textContent = button.getAttribute('data-ref-id');
            issueDetailsModal.querySelector('#modalPlatform').textContent = button.getAttribute('data-platform');
            issueDetailsModal.querySelector('#modalStartTime').textContent = button.getAttribute('data-start-time');
            issueDetailsModal.querySelector('#modalReportedBy').textContent = button.getAttribute('data-reported-by');
            issueDetailsModal.querySelector('#modalContact').textContent = button.getAttribute('data-contact');
            issueDetailsModal.querySelector('#modalDescription').textContent = button.getAttribute('data-description');
            issueDetailsModal.querySelector('#modalCriticality').textContent = button.getAttribute('data-criticality');
            issueDetailsModal.querySelector('#modalAssignedTo').textContent = button.getAttribute('data-assigned-to');
            issueDetailsModal.querySelector('#modalAssignedBy').textContent = button.getAttribute('data-assigned-by');
            issueDetailsModal.querySelector('#modalActionTaken').textContent = button.getAttribute('data-action-taken');

            var modalStatus = issueDetailsModal.querySelector('#modalStatus');
            modalStatus.textContent = button.getAttribute('data-status');
            modalStatus.className = 'badge'; // Reset classes
            var status = button.getAttribute('data-status').toLowerCase();
            if (status === 'solved') { modalStatus.classList.add('bg-success'); }
            else if (status === 'attending') { modalStatus.classList.add('bg-warning'); }
            else if (status === 'open') { modalStatus.classList.add('bg-danger'); }
            else { modalStatus.classList.add('bg-secondary'); }
        });

        // Delete Modal Script
        var deleteConfirmationModal = document.getElementById('deleteConfirmationModal');
        deleteConfirmationModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var deleteUrl = button.getAttribute('data-delete-url');
            var deleteForm = deleteConfirmationModal.querySelector('#deleteForm');
            deleteForm.setAttribute('action', deleteUrl);
            
            deleteConfirmationModal.querySelector('#modalDeleteRefId').textContent = button.getAttribute('data-ref-id');
            deleteConfirmationModal.querySelector('#modalDeletePlatform').textContent = button.getAttribute('data-platform');
            deleteConfirmationModal.querySelector('#modalDeleteStartTime').textContent = button.getAttribute('data-start-time');
        });
    });
</script>
@endpush