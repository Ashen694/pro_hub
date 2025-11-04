@push('styles')
<style>
    /* === Card & Table Container === */
    .card {
        border-radius: 14px !important;
        overflow: hidden;
        box-shadow: 0 4px 18px rgba(0, 0, 0, 0.05);
    }

    /* === Collapsible Filter Card === */
    #filter-card.card {
        border-radius: 12px;
        border: 1px solid #e9ecef;
        background-color: #fafafa;
    }

    /* === Table Wrapper === */
    .table-responsive {
        border-radius: 14px;
        overflow: hidden;
    }

    /* === Table Header === */
    .table thead th {
        background-color: #f9fafb;
        color: #495057;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        border-bottom: 2px solid #dee2e6;
        padding: 0.75rem;
    }

    /* Rounded header corners */
    .table thead tr:first-child th:first-child {
        border-top-left-radius: 12px;
    }
    .table thead tr:first-child th:last-child {
        border-top-right-radius: 12px;
    }

    /* === Table Rows === */
    .table tbody tr {
        transition: all 0.2s ease-in-out;
    }
    .table tbody tr:hover {
        background-color: #f8f9fa;
        transform: scale(1.005);
    }

    /* === Table Cells === */
    .table td {
        padding: 0.75rem;
        border-top: 1px solid #f1f3f5;
        vertical-align: middle;
    }

    /* Rounded bottom corners */
    .table tbody tr:last-child td:first-child {
        border-bottom-left-radius: 12px;
    }
    .table tbody tr:last-child td:last-child {
        border-bottom-right-radius: 12px;
    }

    /* === Action Buttons === */
    .btn.btn-outline-primary {
        border-radius: 8px;
        transition: all 0.2s ease;
    }
    .btn.btn-outline-primary:hover {
        background-color: #0056b3;
        color: #fff;
        transform: translateY(-1px);
    }

    /* === Badges === */
    .badge {
        border-radius: 8px;
        font-weight: 500;
        padding: 0.4em 0.75em;
        font-size: 0.75rem;
    }

    /* === Pagination Footer === */
    .card-footer {
        background-color: #f9fafb;
        border-top: 1px solid #e9ecef;
        border-bottom-left-radius: 12px;
        border-bottom-right-radius: 12px;
    }

    /* === Modal Styling === */
    .modal-content {
        border-radius: 14px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        border: none;
    }

    .modal-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid #e9ecef;
        border-top-left-radius: 14px;
        border-top-right-radius: 14px;
        padding: 1.5rem;
    }

    .modal-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: #343a40;
    }

    .modal-body {
        padding: 2rem;
        color: #495057;
    }

    .modal-body strong {
        color: #212529;
        display: block;
        margin-bottom: 0.25rem;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .modal-body p {
        margin-bottom: 1rem;
        font-size: 1rem;
        line-height: 1.5;
    }

    .modal-body .row > div {
        margin-bottom: 1rem; /* Adjust spacing between fields */
    }

    .modal-footer {
        background-color: #f8f9fa;
        border-top: 1px solid #e9ecef;
        border-bottom-left-radius: 14px;
        border-bottom-right-radius: 14px;
        padding: 1rem 1.5rem;
    }

    .modal-footer .btn {
        border-radius: 8px;
    }

    /* Specific styling for the close button within the modal */
    .modal-header .btn-close {
        font-size: 1rem;
        padding: 0.5rem;
        margin: -0.5rem -0.5rem -0.5rem auto;
    }

    /* Style for loading state */
    .modal-body .spinner-border {
        color: #007bff;
    } 
</style>
@endpush


<div>
    {{-- FILTER SECTION --}}
    <div class="card-body border-bottom py-3">
        <div class="d-flex align-items-center">
            <div class="ms-auto">
                 <button class="btn btn-outline-primary" type="button" data-bs-toggle="collapse" data-bs-target="#filter-card">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M4 4h16v2.172a2 2 0 0 1 -.586 1.414l-4.414 4.414v7l-6 2v-8.5l-4.48 -4.928a2 2 0 0 1 -.52 -1.345v-2.227z"></path></svg>
                    Advanced Filters
                </button>
            </div>
        </div>
    </div>

    <div class="collapse" id="filter-card" wire:ignore.self>
      <div class="card card-body">
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label">Application Name</label>
                <input type="text" class="form-control" placeholder="Search by name..." wire:model.live.debounce.300ms="filterAppName">
            </div>
            <div class="col-md-4">
                <label class="form-label">SDLC Phase</label>
                <select class="form-select" wire:model.live="filterSdlcPhase">
                    <option value="">All Phases</option>
                    @foreach($sdlcPhasesList as $phase)
                    <option value="{{ $phase }}">{{ $phase }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Developed By (Vendor)</label>
                <select class="form-select" wire:model.live="filterDevelopedBy">
                    <option value="">Any Vendor</option>
                    @foreach($developers as $developer)
                        <option value="{{ $developer }}">{{ $developer }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12 text-end">
                <button class="btn btn-link" wire:click="resetFilters">Reset</button>
            </div>
        </div>
      </div>
    </div>
    
    {{-- TABLE SECTION --}}
    <div class="table-responsive">
        <table class="table card-table table-vcenter">
            <thead>
                <tr>
                    <th class="fw-bold text-uppercase text-muted" style="font-size: 0.75rem;"><span style="cursor: pointer;" onclick="@this.dispatch('callSortByConsumer', { field: 'App_Name' })">Application Name</span>@if($sortBy === 'App_Name')<span>{{ $sortDirection === 'asc' ? '▲' : '▼' }}</span>@endif</th>
                    <th class="fw-bold text-uppercase text-muted" style="font-size: 0.75rem;"><span style="cursor: pointer;" onclick="@this.dispatch('callSortByConsumer', { field: 'Developed_By' })">Developed By</span>@if($sortBy === 'Developed_By')<span>{{ $sortDirection === 'asc' ? '▲' : '▼' }}</span>@endif</th>
                    <th class="fw-bold text-uppercase text-muted" style="font-size: 0.75rem;"><span style="cursor: pointer;" onclick="@this.dispatch('callSortByConsumer', { field: 'EndUserType' })">Application End Users</span>@if($sortBy === 'EndUserType')<span>{{ $sortDirection === 'asc' ? '▲' : '▼' }}</span>@endif</th>
                    <th class="fw-bold text-uppercase text-muted" style="font-size: 0.75rem;"><span style="cursor: pointer;" onclick="@this.dispatch('callSortByConsumer', { field: 'Price' })">Solution Value</span>@if($sortBy === 'Price')<span>{{ $sortDirection === 'asc' ? '▲' : '▼' }}</span>@endif</th>
                    <th class="fw-bold text-uppercase text-muted" style="font-size: 0.75rem;"><span style="cursor: pointer;" onclick="@this.dispatch('callSortByConsumer', { field: 'SDLCPhase' })">SDLC Phase</span>@if($sortBy === 'SDLCPhase')<span>{{ $sortDirection === 'asc' ? '▲' : '▼' }}</span>@endif</th>
                    <th class="fw-bold text-uppercase text-muted text-center" style="font-size: 0.75rem;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($platforms as $platform)
                {{-- CORRECTED: Using the model's primary key 'ID' --}}
                <tr wire:key="{{ $platform->ID }}">
                    {{-- CORRECTED: Using actual database column names for display --}}
                    <td>{{ $platform->App_Name }}</td>
                    <td>{{ $platform->Developed_By }}</td>
                    <td>{{ $platform->EndUserType }}</td>
                    <td>{{ number_format($platform->Price, 2) }}</td>
                    <td>
                        @if(in_array($platform->SDLCPhase, ['Retired', 'Abandoned']))
                            <span class="badge bg-red-lt">{{ $platform->SDLCPhase }}</span>
                        @else
                            <span class="badge bg-green-lt">{{ $platform->SDLCPhase }}</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn btn-sm btn-outline-primary"
                                wire:click="showDetails({{ $platform->ID }})"
                                data-bs-toggle="modal" data-bs-target="#consumer-details-modal">
                            Details
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-5">
                        <h3>No Platforms Found</h3>
                        <p class="text-muted">There are no records matching your current filters.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="card-footer d-flex align-items-center">
         <div class="ms-auto">
            {{ $platforms->links() }}
        </div>
    </div>

    <!-- Details Modal -->
    <div class="modal modal-blur fade" id="consumer-details-modal" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                @if ($selectedPlatform)
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $selectedPlatform->App_Name }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <strong>Application Name</strong>
                                <p>{{ $selectedPlatform->App_Name }}</p>
                            </div>
                            <div class="col-md-6">
                                <strong>Developed By</strong>
                                <p>{{ $selectedPlatform->Developed_By ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-6">
                                <strong>Business Owner</strong>
                                <p>{{ $selectedPlatform->Bus_Owner ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-6">
                                <strong>Application End Users</strong>
                                <p>{{ $selectedPlatform->EndUserType ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-6">
                                <strong>Launched Date</strong>
                                <p>{{ $selectedPlatform->LaunchedDate ? \Carbon\Carbon::parse($selectedPlatform->LaunchedDate)->format('Y-m-d') : 'N/A' }}</p>
                            </div>
                            <div class="col-md-6">
                                <strong>Application URL</strong>
                                <p>{{ $selectedPlatform->App_URL ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-6">
                                <strong>Solution Value</strong>
                                <p>${{ number_format($selectedPlatform->Price, 2) }}</p>
                            </div>
                            <div class="col-md-6">
                                <strong>SDLC Phase</strong>
                                <p>
                                    @if(in_array($selectedPlatform->SDLCPhase, ['Retired', 'Abandoned']))
                                        <span class="badge bg-red-lt">{{ $selectedPlatform->SDLCPhase }}</span>
                                    @else
                                        <span class="badge bg-green-lt">{{ $selectedPlatform->SDLCPhase }}</span>
                                    @endif
                                </p>
                            </div>
                            {{-- Add more fields as needed --}}
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        {{-- <button type="button" class="btn btn-primary">Edit</button> --}} {{-- Example for an edit button --}}
                    </div>
                @else
                    <div class="modal-body text-center p-5">
                        <div class="spinner-border text-primary mb-3" role="status"></div>
                        <p class="text-muted">Loading application details...</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>