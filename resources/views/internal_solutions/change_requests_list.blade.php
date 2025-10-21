@extends('layouts.app')

@section('page-title', 'Change Requests for ' . $mainApplication->App_Name)

@push('styles')
<style>
    /* Re-using modal styles from the main table view */
    .modal-details .detail-item { margin-bottom: 1rem; }
    .modal-details .detail-label { color: #626976; font-weight: 600; display: flex; align-items: center; font-size: 0.8rem; }
    .modal-details .detail-label .icon { margin-right: 8px; }
    .modal-details .detail-value { font-weight: 500; word-break: break-all; }
    .modal-details .hr-text { margin-top: 1.5rem; margin-bottom: 1.5rem; }
</style>
@endpush

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Change Requests for: {{ $mainApplication->App_Name }}</h3>
        <div class="card-options">
            <a href="{{ url()->previous() }}" class="btn btn-outline-primary">Back to List</a>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table card-table table-vcenter">
            <thead>
                <tr>
                    <th class="fw-bold text-uppercase text-muted" style="font-size: 0.75rem;">CR Name</th>
                    <th class="fw-bold text-uppercase text-muted" style="font-size: 0.75rem;">Developed By</th>
                    <th class="fw-bold text-uppercase text-muted" style="font-size: 0.75rem;">Solution Value</th>
                    <th class="fw-bold text-uppercase text-muted" style="font-size: 0.75rem;">SDLC Phase</th>
                    <th class="fw-bold text-uppercase text-muted text-center" style="font-size: 0.75rem;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($changeRequests as $cr)
                <tr>
                    <td><strong>{{ $cr->App_Name }}</strong></td>
                    <td>{{ $cr->Developed_By }}</td>
                    <td>{{ number_format($cr->Price, 2) }}</td>
                    <td><span class="badge bg-yellow-lt">{{ $cr->SDLCPhase }}</span></td>
                    <td class="text-center">
                        {{-- ======================================================= --}}
                        {{-- CORRECTED: Changed link to a button that opens a modal --}}
                        {{-- ======================================================= --}}
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#details-modal-{{ $cr->ID }}">
                             <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-clipboard-text" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2"></path><path d="M9 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z"></path><path d="M9 12h6"></path><path d="M9 16h6"></path></svg>
                            View Details
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-off" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 3l18 18" /><path d="M7 3h7l5 5v7m0 4a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-14" /></svg>
                        <h3 class="mt-3">No Change Requests Found</h3>
                        <p class="text-muted">There are no change requests associated with this main application.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer d-flex align-items-center">
        <div class="ms-auto">
            {{ $changeRequests->links() }}
        </div>
    </div>
</div>

{{-- ================================================== --}}
{{-- NEW: Added modals for each change request record --}}
{{-- ================================================== --}}
@foreach($changeRequests as $cr)
<div class="modal modal-blur fade" id="details-modal-{{ $cr->ID }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $cr->App_Name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body modal-details">
                <div class="row">
                    <div class="col-md-6"><span class="badge bg-yellow-lt mb-3">Change Request</span></div>
                    <div class="col-md-6 text-md-end"><span class="badge bg-purple-lt mb-3">{{ $cr->SDLCPhase ?? '-' }}</span></div>
                </div>
                
                <div class="hr-text">Key Details</div>
                <div class="row">
                    <div class="col-md-6 detail-item">
                        <div class="detail-label"><svg xmlns="http://www.w3.org/2000/svg" class="icon text-primary" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M11 3l9 9a1.5 1.5 0 0 1 0 2l-6 6a1.5 1.5 0 0 1 -2 0l-9 -9v-4a2 2 0 0 1 2 -2h4" /><circle cx="9" cy="9" r="2" /></svg>Application Group</div>
                        <div class="detail-value">{{ $cr->parentProject->ParentProjectGroup ?? 'N/A' }}</div>
                    </div>
                    <div class="col-md-6 detail-item">
                        <div class="detail-label"><svg xmlns="http://www.w3.org/2000/svg" class="icon text-info" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="7" r="4" /><path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" /></svg>Developed By</div>
                        <div class="detail-value">{{ $cr->Developed_By ?? '-' }}</div>
                    </div>
                </div>

                <div class="hr-text">Timeline</div>
                <div class="row">
                    <div class="col-md-6 detail-item">
                        <div class="detail-label"><svg xmlns="http://www.w3.org/2000/svg" class="icon text-muted" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><rect x="4" y="5" width="16" height="16" rx="2" /><line x1="16" y1="3" x2="16" y2="7" /><line x1="8" y1="3" x2="8" y2="7" /><line x1="4" y1="11" x2="20" y2="11" /><rect x="8" y="15" width="2" height="2" /></svg>Start Date</div>
                        <div class="detail-value">{{ $cr->StartDate ?? '-' }}</div>
                    </div>
                    <div class="col-md-6 detail-item">
                        <div class="detail-label"><svg xmlns="http://www.w3.org/2000/svg" class="icon text-muted" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 5m0 2a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2z" /><path d="M16 3v4" /><path d="M8 3v4" /><path d="M4 11h16" /><path d="M12 16m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" /></svg>Target Date</div>
                        <div class="detail-value">{{ $cr->TargetDate ?? '-' }}</div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <a href="{{ route('internal-solutions.edit', $cr->ID) }}" class="btn btn-primary">Edit Full Details</a>
            </div>
        </div>
    </div>
</div>
@endforeach

@endsection