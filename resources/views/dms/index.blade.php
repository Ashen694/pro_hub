@extends('layouts.app')

@section('page-title', $title)

@push('styles')
    <style>
    /* --- New Styles for Action Buttons --- */
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
    }
    .action-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.12);
    }
    .action-btn i {
        font-size: 16px;
    }
    .action-btn-edit {
        background-color: #e6f0ff;
    }
    .action-btn-edit i {
        color: #0057ff;
    }
    .action-btn-edit:hover {
        background-color: #cce0ff;
    }
    .action-btn-view {
        background-color: #e3f9e5;
    }
    .action-btn-view i {
        color: #28a745;
    }
    .action-btn-view:hover {
        background-color: #c1f2c6;
    }
    .action-btn-delete {
        background-color: #ffe6e6;
        cursor: pointer;
    }
    .action-btn-delete i {
        color: #dc3545;
    }
    .action-btn-delete:hover {
        background-color: #ffcccc;
    }
</style>

@endpush

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ $title }}</h3>
        <div class="ms-auto">
            <a href="{{ route('dms.create', ['type' => $type]) }}" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M12 5l0 14"></path><path d="M5 12l14 0"></path></svg>
                Create New
            </a>
        </div>
    </div>

     <div class="card-body border-bottom py-3">
        <style>
            /* --- Modern Filter Section Styles --- */
            .filter-container {
                display: flex;
                flex-wrap: wrap;
                align-items: center;
                justify-content: space-between;
                background: #f8f9fa;
                border-radius: 12px;
                padding: 15px 20px;
                box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
                gap: 1rem;
            }

            .filter-left {
                display: flex;
                align-items: center;
                font-size: 14px;
                color: #495057;
                gap: 0.5rem;
            }

            .filter-left input {
                width: 60px;
                text-align: center;
                border-radius: 8px;
            }

            .filter-right {
                display: flex;
                align-items: center;
                gap: 1rem;
            }

            .filter-select label {
                font-size: 13px;
                font-weight: 500;
                color: #555;
                margin-right: 4px;
            }

            .filter-select select {
                border-radius: 8px;
                padding: 6px 10px;
                font-size: 13px;
            }

            .filter-search input {
                border-radius: 8px;
                padding: 6px 10px;
                font-size: 13px;
                border: 1px solid #ced4da;
            }

            .filter-search input:focus {
                border-color: #228be6;
                box-shadow: 0 0 0 3px rgba(34, 139, 230, 0.2);
            }

            .filter-btn {
                border-radius: 8px;
                font-size: 13px;
                padding: 6px 14px;
            }

            @media (max-width: 768px) {
                .filter-container {
                    flex-direction: column;
                    align-items: stretch;
                }
                .filter-right {
                    flex-direction: column;
                    align-items: stretch;
                }
            }
        </style>

        <form action="{{ route('dms.index', ['type' => $type]) }}" method="GET">
            <div class="filter-container">
                <div class="filter-left">
                    Show
                    <input type="text" class="form-control form-control-sm" value="{{ $documents->perPage() }}" size="3" disabled>
                    entries
                </div>

                <div class="filter-right">
                    <div class="filter-select">
                        <label>Solution</label>
                        <select class="form-select form-select-sm" name="solution_id" onchange="this.form.submit()">
                            <option value="">All Solutions</option>
                            @foreach($solutions as $solution)
                                <option value="{{ $type === 'internal' ? $solution->ID : $solution->id }}" 
                                        {{ request('solution_id') == ($type === 'internal' ? $solution->ID : $solution->id) ? 'selected' : '' }}>
                                    {{ $type === 'internal' ? $solution->App_Name : $solution->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="filter-search d-flex align-items-center">
                        <label class="me-2 text-muted">Search:</label>
                        <input type="text" name="search" class="form-control form-control-sm" value="{{ request('search') }}">
                    </div>

                    <button type="submit" class="btn btn-sm btn-primary filter-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon me-1" width="16" height="16" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8" />
                            <line x1="21" y1="21" x2="16.65" y2="16.65" />
                        </svg>
                        Search
                    </button>
                </div>
            </div>
        </form>
    </div>


    <div class="table-responsive">
        <table class="table card-table table-vcenter text-nowrap datatable">
            <thead>
                <tr>
                    <th>Solution</th>
                    <th>Document Name</th>
                    <th>Uploaded Time</th>
                    <th>Uploaded By</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($documents as $doc)
                <tr>
                    <td>
                        @if($doc->internalSolution)
                            {{ $doc->internalSolution->App_Name }}
                        @else
                            N/A
                        @endif
                    </td>
                    <td>{{ $doc->Doc_Name }}</td>
                    <td>{{ \Carbon\Carbon::parse($doc->Created_Time)->format('Y-m-d H:i') }}</td>
                    <td>{{ $doc->uploader->name ?? 'N/A' }}</td>
                    <td class="text-center">
                        <div class="btn-list flex-nowrap justify-content-center">
                            <!-- View Button (Triggers Modal) -->
                            <button class="action-btn action-btn-view" data-bs-toggle="modal" data-bs-target="#view-modal-{{ $doc->ID }}" title="View Details">
                                <i class="ti ti-eye"></i>
                            </button>

                            <!-- Edit Button -->
                            <a href="{{ route('dms.edit', $doc->ID) }}" class="action-btn action-btn-edit" title="Edit">
                                <i class="ti ti-pencil"></i>
                            </a>

                            <!-- Download Button -->
                            <a href="{{ route('dms.download', $doc->ID) }}" class="action-btn" style="background-color: #f1f3f5;" title="Download">
                                <i class="ti ti-download" style="color:#6c757d;"></i>
                            </a>

                            <!-- Delete Button -->
                            <button class="action-btn action-btn-delete" data-bs-toggle="modal" data-bs-target="#delete-modal-{{ $doc->ID }}" title="Delete">
                                <i class="ti ti-trash"></i>
                            </button>

                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-5">
                        <h3>No Documents Found</h3>
                        <p class="text-muted">There are no documents matching your current filters.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="card-footer d-flex align-items-center">
        <div class="ms-auto">{{ $documents->appends(request()->query())->links() }}</div>
    </div>
</div>

@foreach($documents as $doc)

<!-- View Details Modal -->
<div class="modal modal-blur fade" id="view-modal-{{ $doc->ID }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Document Details: {{ $doc->Doc_Name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">Platform</label>
                        <div class="form-control-plaintext">{{ $doc->Platform_ID == 1 ? 'Internal' : 'External' }}</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">Solution</label>
                        <div class="form-control-plaintext">{{ $doc->internalSolution->App_Name ?? 'N/A' }}</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">Document Name</label>
                        <div class="form-control-plaintext">{{ $doc->Doc_Name }}</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">Uploaded By</label>
                        <div class="form-control-plaintext">{{ $doc->uploader->name ?? 'N/A' }}</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">Uploaded Time</label>
                        <div class="form-control-plaintext">{{ \Carbon\Carbon::parse($doc->Created_Time)->format('Y-m-d H:i:s') }}</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">Document Type</label>
                        <div class="form-control-plaintext">{{ $doc->Doc_Type ?? '-' }}</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">Document Classification</label>
                        <div class="form-control-plaintext">{{ $doc->Doc_classification ?? '-' }}</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">Confidentiality</label>
                        <div class="form-control-plaintext">{{ $doc->Confidential ?? '-' }}</div>
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label text-muted">Tags</label>
                        <div class="form-control-plaintext">{{ $doc->Tags ?? '-' }}</div>
                    </div>
                     <div class="col-12 mb-3">
                        <label class="form-label text-muted">Document URL (Path)</label>
                        <div class="form-control-plaintext">{{ $doc->Doc_URL ?? '-' }}</div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal modal-blur fade" id="delete-modal-{{ $doc->ID }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-status bg-danger"></div>
            <div class="modal-body text-center py-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-danger icon-lg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 9v2m0 4v.01" /><path d="M5 19h14a2 2 0 0 0 1.84 -2.75l-7.1 -12.25a2 2 0 0 0 -3.5 0l-7.1 12.25a2 2 0 0 0 1.75 2.75" /></svg>
                <h3>Are you sure?</h3>
                <div class="text-muted">Do you really want to delete <strong>{{ $doc->Doc_Name }}</strong>? This process cannot be undone.</div>
            </div>
            <div class="modal-footer">
                <div class="w-100">
                    <div class="row">
                        <div class="col"><a href="#" class="btn w-100" data-bs-dismiss="modal">Cancel</a></div>
                        <div class="col">
                            <form action="{{ route('dms.destroy', $doc->ID) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger w-100">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach

@endsection