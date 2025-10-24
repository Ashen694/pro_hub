@extends('layouts.app')

@section('page-title', $title)

@push('styles')
    <style>
        .btn-action {
            width: 36px; height: 36px; padding: 0; display: inline-flex;
            align-items: center; justify-content: center; border-radius: 10px;
            border: none; transition: all 0.2s ease-in-out;
        }
        .btn-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
        .btn-action-view { background-color: #e7f5ff; color: #1c7ed6; }
        .btn-action-view:hover { background-color: #d0ebff; color: #1971c2; }
        .btn-action-edit { background-color: #e6fcf5; color: #2f9e44; }
        .btn-action-edit:hover { background-color: #c3fae8; color: #2b8a3e; }
        .btn-action-delete { background-color: #fff5f5; color: #e03131; }
        .btn-action-delete:hover { background-color: #ffc9c9; color: #c92a2a; }
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
                            <button class="btn btn-action btn-action-view" data-bs-toggle="modal" data-bs-target="#view-modal-{{ $doc->ID }}" title="View Details">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-eye" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" /></svg>
                            </button>
                            
                            <!-- Edit Button -->
                            <a href="{{ route('dms.edit', $doc->ID) }}" class="btn btn-action btn-action-edit" title="Edit">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-pencil" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4" /><path d="M13.5 6.5l4 4" /></svg>
                            </a>

                            <!-- Download Button -->
                            <a href="{{ route('dms.download', $doc->ID) }}" class="btn btn-action" style="background-color: #f8f9fa; color: #868e96;" title="Download">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-download" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" /><path d="M7 11l5 5l5 -5" /><path d="M12 4l0 12" /></svg>
                            </a>

                            <!-- Delete Button -->
                            <button class="btn btn-action btn-action-delete" data-bs-toggle="modal" data-bs-target="#delete-modal-{{ $doc->ID }}" title="Delete">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
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