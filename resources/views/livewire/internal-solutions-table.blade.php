<div>
    @push('styles')
    <style>
        /* ======================================================================= */
        /* CORRECTED: Using Flexbox to perfectly center the icon inside the button */
        /* ======================================================================= */
        .btn-icon-sm {
            width: 2rem;
            height: 2rem;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0; /* Remove default padding to ensure perfect centering */
        }
    </style>
    @endpush

    {{-- ALERTS SECTION WITH ALPINE.JS --}}
    <div class="px-4 pt-4">
        @if (session()->has('success'))
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="alert alert-success alert-dismissible" role="alert">
                <div class="d-flex">
                    <div><svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M5 12l5 5l10 -10"></path></svg></div>
                    <div><h4 class="alert-title">Success!</h4><div class="text-muted">{{ session('success') }}</div></div>
                </div><a class="btn-close" @click="show = false" aria-label="close"></a>
            </div>
        @endif
        @if (session()->has('error'))
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="alert alert-danger alert-dismissible" role="alert">
                <div class="d-flex">
                    <div><svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M12 9v2m0 4v.01"></path><path d="M5 19h14a2 2 0 0 0 1.84 -2.75l-7.1 -12.25a2 2 0 0 0 -3.5 0l-7.1 12.25a2 2 0 0 0 1.75 2.75"></path></svg></div>
                    <div><h4 class="alert-title">Error!</h4><div class="text-muted">{{ session('error') }}</div></div>
                </div><a class="btn-close" @click="show = false" aria-label="close"></a>
            </div>
        @endif
    </div>

    {{-- FILTER SECTION --}}
    <div class="card-body border-bottom py-3">
        <div class="d-flex align-items-center">
            @if($status == 'operational')
            <div class="btn-group" role="group">
                <button type="button" wire:click="toggleWithoutCrFilter(false)" class="btn {{ !$filterWithoutCr ? 'btn-primary' : 'btn-outline-secondary' }}">Operational</button>
                <button type="button" wire:click="toggleWithoutCrFilter(true)" class="btn {{ $filterWithoutCr ? 'btn-primary' : 'btn-outline-secondary' }}">Operational without CR</button>
            </div>
            @endif
            <div class="ms-auto"><button class="btn btn-outline-primary" type="button" data-bs-toggle="collapse" data-bs-target="#filter-card"><svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M4 4h16v2.172a2 2 0 0 1 -.586 1.414l-4.414 4.414v7l-6 2v-8.5l-4.48 -4.928a2 2 0 0 1 -.52 -1.345v-2.227z"></path></svg> Advanced Filters</button></div>
        </div>
    </div>
    <div class="collapse" id="filter-card" wire:ignore.self>
        <div class="card card-body"><div class="row g-3">
            <div class="col-md-3"><label class="form-label">Application Name</label><input type="text" class="form-control" placeholder="Search by name..." wire:model.live.debounce.300ms="filterAppName"></div>
            <div class="col-md-3"><label class="form-label">Application Group</label><select class="form-select" wire:model.live="filterAppGroup"><option value="">All Groups</option>@foreach($applicationGroups as $group)<option value="{{ $group->ParentProjectID }}">{{ $group->ParentProjectGroup }}</option>@endforeach</select></div>
            <div class="col-md-3"><label class="form-label">SDLC Phase</label><select class="form-select" wire:model.live="filterSdlcPhase"><option value="">All Phases</option>@foreach($sdlcPhasesList as $phase)<option value="{{ $phase }}">{{ $phase }}</option>@endforeach</select></div>
            <div class="col-md-3"><label class="form-label">Developed By</label><select class="form-select" wire:model.live="filterDevelopedBy"><option value="">Any Developer</option>@foreach($developers as $developer)<option value="{{ $developer }}">{{ $developer }}</option>@endforeach</select></div>
            <div class="col-12 text-end"><button class="btn btn-link" wire:click="resetFilters">Reset</button></div>
        </div></div>
    </div>
    
    {{-- TABLE SECTION --}}
    <div class="table-responsive">
        <table class="table card-table table-vcenter">
            <thead>
                <tr>
                    @if(in_array($status, ['in-progress', 'recently-launched']))
                        <th class="fw-bold text-uppercase text-muted" style="font-size: 0.75rem;"><span onclick="@this.dispatch('callSortBy', { field: 'ParentProjectID' })" style="cursor: pointer;">Application Group</span>@if($sortBy === 'ParentProjectID')<span>{{ $sortDirection === 'asc' ? '▲' : '▼' }}</span>@endif</th>
                        <th class="fw-bold text-uppercase text-muted" style="font-size: 0.75rem;"><span onclick="@this.dispatch('callSortBy', { field: 'App_Name' })" style="cursor: pointer;">Application Name</span>@if($sortBy === 'App_Name')<span>{{ $sortDirection === 'asc' ? '▲' : '▼' }}</span>@endif</th>
                        <th class="fw-bold text-uppercase text-muted" style="font-size: 0.75rem;"><span onclick="@this.dispatch('callSortBy', { field: 'Developed_By' })" style="cursor: pointer;">Developed By</span>@if($sortBy === 'Developed_By')<span>{{ $sortDirection === 'asc' ? '▲' : '▼' }}</span>@endif</th>
                        <th class="fw-bold text-uppercase text-muted" style="font-size: 0.75rem;"><span onclick="@this.dispatch('callSortBy', { field: 'SDLCPhase' })" style="cursor: pointer;">SDLC Phase</span>@if($sortBy === 'SDLCPhase')<span>{{ $sortDirection === 'asc' ? '▲' : '▼' }}</span>@endif</th>
                        <th class="fw-bold text-uppercase text-muted" style="font-size: 0.75rem;"><span onclick="@this.dispatch('callSortBy', { field: 'StartDate' })" style="cursor: pointer;">Start</span>@if($sortBy === 'StartDate')<span>{{ $sortDirection === 'asc' ? '▲' : '▼' }}</span>@endif</th>
                        <th class="fw-bold text-uppercase text-muted" style="font-size: 0.75rem;"><span onclick="@this.dispatch('callSortBy', { field: 'TargetDate' })" style="cursor: pointer;">Target</span>@if($sortBy === 'TargetDate')<span>{{ $sortDirection === 'asc' ? '▲' : '▼' }}</span>@endif</th>
                        <th class="fw-bold text-uppercase text-muted" style="font-size: 0.75rem;"><span onclick="@this.dispatch('callSortBy', { field: 'UserSpecificSection' })" style="cursor: pointer;">UD</span>@if($sortBy === 'UserSpecificSection')<span>{{ $sortDirection === 'asc' ? '▲' : '▼' }}</span>@endif</th>
                        <th class="fw-bold text-uppercase text-muted" style="font-size: 0.75rem;"><span onclick="@this.dispatch('callSortBy', { field: 'Price' })" style="cursor: pointer;">Solution Value</span>@if($sortBy === 'Price')<span>{{ $sortDirection === 'asc' ? '▲' : '▼' }}</span>@endif</th>
                    @elseif(in_array($status, ['retired', 'abandoned']))
                        <th class="fw-bold text-uppercase text-muted" style="font-size: 0.75rem;"><span onclick="@this.dispatch('callSortBy', { field: 'App_Name' })" style="cursor: pointer;">Application Name</span>@if($sortBy === 'App_Name')<span>{{ $sortDirection === 'asc' ? '▲' : '▼' }}</span>@endif</th>
                        <th class="fw-bold text-uppercase text-muted" style="font-size: 0.75rem;"><span onclick="@this.dispatch('callSortBy', { field: 'Developed_By' })" style="cursor: pointer;">Developed By</span>@if($sortBy === 'Developed_By')<span>{{ $sortDirection === 'asc' ? '▲' : '▼' }}</span>@endif</th>
                        <th class="fw-bold text-uppercase text-muted" style="font-size: 0.75rem;"><span onclick="@this.dispatch('callSortBy', { field: 'LaunchedDate' })" style="cursor: pointer;">Launched Date</span>@if($sortBy === 'LaunchedDate')<span>{{ $sortDirection === 'asc' ? '▲' : '▼' }}</span>@endif</th>
                        <th class="fw-bold text-uppercase text-muted" style="font-size: 0.75rem;"><span onclick="@this.dispatch('callSortBy', { field: 'SDLCPhase' })" style="cursor: pointer;">SDLC Phase</span>@if($sortBy === 'SDLCPhase')<span>{{ $sortDirection === 'asc' ? '▲' : '▼' }}</span>@endif</th>
                        <th class="fw-bold text-uppercase text-muted" style="font-size: 0.75rem;"><span onclick="@this.dispatch('callSortBy', { field: 'Price' })" style="cursor: pointer;">Solution Value</span>@if($sortBy === 'Price')<span>{{ $sortDirection === 'asc' ? '▲' : '▼' }}</span>@endif</th>
                        <th class="fw-bold text-uppercase text-muted" style="font-size: 0.75rem;">Comment</th>
                    @elseif ($status == 'operational' && $filterWithoutCr)
                        <th class="fw-bold text-uppercase text-muted" style="font-size: 0.75rem;"><span onclick="@this.dispatch('callSortBy', { field: 'ParentProjectID' })" style="cursor: pointer;">Application Group</span>@if($sortBy === 'ParentProjectID')<span>{{ $sortDirection === 'asc' ? '▲' : '▼' }}</span>@endif</th>
                        <th class="fw-bold text-uppercase text-muted" style="font-size: 0.75rem;"><span onclick="@this.dispatch('callSortBy', { field: 'App_Name' })" style="cursor: pointer;">Application Name</span>@if($sortBy === 'App_Name')<span>{{ $sortDirection === 'asc' ? '▲' : '▼' }}</span>@endif</th>
                        <th class="fw-bold text-uppercase text-muted" style="font-size: 0.75rem;"><span onclick="@this.dispatch('callSortBy', { field: 'Developed_By' })" style="cursor: pointer;">Developed By</span>@if($sortBy === 'Developed_By')<span>{{ $sortDirection === 'asc' ? '▲' : '▼' }}</span>@endif</th>
                        <th class="fw-bold text-uppercase text-muted" style="font-size: 0.75rem;"><span onclick="@this.dispatch('callSortBy', { field: 'SDLCPhase' })" style="cursor: pointer;">SDLC Phase</span>@if($sortBy === 'SDLCPhase')<span>{{ $sortDirection === 'asc' ? '▲' : '▼' }}</span>@endif</th>
                        <th class="fw-bold text-uppercase text-muted" style="font-size: 0.75rem;"><span onclick="@this.dispatch('callSortBy', { field: 'StartDate' })" style="cursor: pointer;">Start</span>@if($sortBy === 'StartDate')<span>{{ $sortDirection === 'asc' ? '▲' : '▼' }}</span>@endif</th>
                        <th class="fw-bold text-uppercase text-muted" style="font-size: 0.75rem;"><span onclick="@this.dispatch('callSortBy', { field: 'TargetDate' })" style="cursor: pointer;">Target</span>@if($sortBy === 'TargetDate')<span>{{ $sortDirection === 'asc' ? '▲' : '▼' }}</span>@endif</th>
                        <th class="fw-bold text-uppercase text-muted" style="font-size: 0.75rem;"><span onclick="@this.dispatch('callSortBy', { field: 'UserSpecificSection' })" style="cursor: pointer;">UD</span>@if($sortBy === 'UserSpecificSection')<span>{{ $sortDirection === 'asc' ? '▲' : '▼' }}</span>@endif</th>
                        <th class="fw-bold text-uppercase text-muted" style="font-size: 0.75rem;"><span onclick="@this.dispatch('callSortBy', { field: 'Price' })" style="cursor: pointer;">Solution Value</span>@if($sortBy === 'Price')<span>{{ $sortDirection === 'asc' ? '▲' : '▼' }}</span>@endif</th>
                    @elseif ($status == 'operational' && !$filterWithoutCr)
                        <th class="fw-bold text-uppercase text-muted" style="font-size: 0.75rem;"><span onclick="@this.dispatch('callSortBy', { field: 'ParentProjectID' })" style="cursor: pointer;">Application Group</span>@if($sortBy === 'ParentProjectID')<span>{{ $sortDirection === 'asc' ? '▲' : '▼' }}</span>@endif</th>
                        <th class="fw-bold text-uppercase text-muted" style="font-size: 0.75rem;"><span onclick="@this.dispatch('callSortBy', { field: 'App_Name' })" style="cursor: pointer;">Application Name</span>@if($sortBy === 'App_Name')<span>{{ $sortDirection === 'asc' ? '▲' : '▼' }}</span>@endif</th>
                        <th class="fw-bold text-uppercase text-muted" style="font-size: 0.75rem;"><span onclick="@this.dispatch('callSortBy', { field: 'Developed_By' })" style="cursor: pointer;">Developed By</span>@if($sortBy === 'Developed_By')<span>{{ $sortDirection === 'asc' ? '▲' : '▼' }}</span>@endif</th>
                        <th class="fw-bold text-uppercase text-muted" style="font-size: 0.75rem;"><span onclick="@this.dispatch('callSortBy', { field: 'LaunchedDate' })" style="cursor: pointer;">Launched Date</span>@if($sortBy === 'LaunchedDate')<span>{{ $sortDirection === 'asc' ? '▲' : '▼' }}</span>@endif</th>
                        <th class="fw-bold text-uppercase text-muted" style="font-size: 0.75rem;"><span onclick="@this.dispatch('callSortBy', { field: 'VADate' })" style="cursor: pointer;">VA Date</span>@if($sortBy === 'VADate')<span>{{ $sortDirection === 'asc' ? '▲' : '▼' }}</span>@endif</th>
                        <th class="fw-bold text-uppercase text-muted" style="font-size: 0.75rem;"><span onclick="@this.dispatch('callSortBy', { field: 'Price' })" style="cursor: pointer;">Solution Value</span>@if($sortBy === 'Price')<span>{{ $sortDirection === 'asc' ? '▲' : '▼' }}</span>@endif</th>
                    @endif
                    <th class="fw-bold text-uppercase text-muted text-center" style="font-size: 0.75rem;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($solutions as $solution)
                <tr wire:key="{{ $solution->ID }}">
                    @if(in_array($status, ['in-progress', 'recently-launched']))
                        <td><span class="badge bg-blue-lt">{{ $solution->parentProject->ParentProjectGroup ?? 'N/A' }}</span></td>
                        <td><strong>{{ $solution->App_Name }}</strong> @if ($solution->App_Category == 'Change Request' && $solution->mainApplicationParent)<div style="font-size: 0.75rem; font-style: italic;"><a href="{{ route('internal-solutions.show', $solution->mainApplicationParent->ID) }}">CR of {{ $solution->mainApplicationParent->App_Name }}</a></div>@endif</td>
                        <td>{{ $solution->Developed_By }}</td>
                        <td>{{ $solution->SDLCPhase }}</td>
                        <td>{{ $solution->StartDate }}</td>
                        <td>{{ $solution->TargetDate }}</td>
                        <td>{{ $solution->UserSpecificSection ?? '-' }}</td>
                        <td>{{ number_format($solution->Price, 2) }}</td>
                    @elseif(in_array($status, ['retired', 'abandoned']))
                        <td><strong>{{ $solution->App_Name }}</strong></td>
                        <td>{{ $solution->Developed_By }}</td>
                        <td>{{ $solution->LaunchedDate ?? '-' }}</td>
                        <td><span class="badge bg-red-lt">{{ $solution->SDLCPhase }}</span></td>
                        <td>{{ number_format($solution->Price, 2) }}</td>
                        <td>{{ $solution->Comment ?? '-' }}</td>
                    @elseif ($status == 'operational' && $filterWithoutCr)
                        <td><span class="badge bg-blue-lt">{{ $solution->parentProject->ParentProjectGroup ?? 'N/A' }}</span></td>
                        <td><strong>{{ $solution->App_Name }}</strong></td>
                        <td>{{ $solution->Developed_By }}</td>
                        <td>{{ $solution->SDLCPhase }}</td>
                        <td>{{ $solution->StartDate }}</td>
                        <td>{{ $solution->TargetDate }}</td>
                        <td>{{ $solution->UserSpecificSection ?? '-' }}</td>
                        <td>{{ number_format($solution->Price, 2) }}</td>
                    @elseif ($status == 'operational' && !$filterWithoutCr)
                        <td><span class="badge bg-blue-lt">{{ $solution->parentProject->ParentProjectGroup ?? 'N/A' }}</span></td>
                        <td><strong>{{ $solution->App_Name }}</strong> @if ($solution->App_Category == 'Change Request' && $solution->mainApplicationParent)<div style="font-size: 0.75rem; font-style: italic;"><a href="{{ route('internal-solutions.show', $solution->mainApplicationParent->ID) }}">CR of {{ $solution->mainApplicationParent->App_Name }}</a></div>@endif</td>
                        <td>{{ $solution->Developed_By }}</td>
                        <td>{{ $solution->LaunchedDate }}</td>
                        <td>{{ $solution->VADate }}</td>
                        <td>{{ number_format($solution->Price, 2) }}</td>
                    @endif

                    <td class="text-center">
                        <div class="btn-list flex-nowrap justify-content-center">
                            @if(in_array($status, ['retired', 'abandoned']))
                                <a href="{{ route('internal-solutions.show', $solution->ID) }}" class="btn btn-icon-sm btn-outline-info" data-bs-toggle="tooltip" title="View Details"><svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" /></svg></a>
                            @else
                                <a href="{{ route('internal-solutions.show', $solution->ID) }}" class="btn btn-icon-sm btn-outline-info" data-bs-toggle="tooltip" title="View Details"><svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" /></svg></a>
                                <a href="#" class="btn btn-icon-sm btn-outline-primary" data-bs-toggle="tooltip" title="Edit"><svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4" /><path d="M13.5 6.5l4 4" /></svg></a>
                                <a href="#" class="btn btn-icon-sm btn-outline-secondary" data-bs-toggle="tooltip" title="Documents"><svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" /></svg></a>
                                @if ($solution->App_Category == 'Main Application' && in_array($status, ['operational', 'in-progress', 'recently-launched']))
                                    <a href="{{ route('internal-solutions.change-requests', $solution->ID) }}" class="btn btn-icon-sm btn-outline-warning" data-bs-toggle="tooltip" title="Change Requests"><svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" /><path d="M12 11l-1 1l1 1l-1 1l1 1" /><path d="M9 11l1 1l-1 1l1 1l-1 1" /></svg></a>
                                @endif
                                <button class="btn btn-icon-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#delete-modal-{{ $solution->ID }}" data-bs-toggle="tooltip" title="Delete"><svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg></button>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    @php
                        $colspan = 7;
                        if (in_array($status, ['in-progress', 'recently-launched'])) $colspan = 9;
                        if ($status == 'operational' && $filterWithoutCr) $colspan = 9;
                        if (in_array($status, ['retired', 'abandoned'])) $colspan = 7;
                    @endphp
                    <td colspan="{{ $colspan }}" class="text-center py-5"><h3>No Solutions Found</h3><p class="text-muted">There are no records matching your current status and filters.</p></td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- PAGINATION AND MODALS --}}
    <div class="card-footer d-flex align-items-center"><a href="#" class="btn btn-outline-primary">Export All Details to Excel</a><div class="ms-auto">{{ $solutions->links() }}</div></div>
    @foreach($solutions as $solution)
    <div class="modal modal-blur fade" id="delete-modal-{{ $solution->ID }}" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="modal-status bg-danger"></div>
                <div class="modal-body text-center py-4"><svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-danger icon-lg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 9v2m0 4v.01" /><path d="M5 19h14a2 2 0 0 0 1.84 -2.75l-7.1 -12.25a2 2 0 0 0 -3.5 0l-7.1 12.25a2 2 0 0 0 1.75 2.75" /></svg><h3>Are you sure?</h3><div class="text-muted">Do you really want to delete <strong>{{ $solution->App_Name }}</strong>?</div></div>
                <div class="modal-footer"><div class="w-100"><div class="row">
                    <div class="col"><a href="#" class="btn w-100" data-bs-dismiss="modal">Cancel</a></div>
                    <div class="col"><button type="button" class="btn btn-danger w-100" wire:click="delete({{ $solution->ID }})" data-bs-dismiss="modal">Delete</button></div>
                </div></div></div>
            </div>
        </div>
    </div>
    @endforeach
</div>