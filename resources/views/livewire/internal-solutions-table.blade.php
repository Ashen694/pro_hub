<div>
    @push('styles')
    <style>
        /* Centering for action buttons */
        .btn-icon-sm {
            width: 2rem;
            height: 2rem;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
        }
        /* Styles for the new details modal */
        .modal-details .detail-item {
            margin-bottom: 1rem;
        }
        .modal-details .detail-label {
            color: #626976;
            font-weight: 600;
            display: flex;
            align-items: center;
            font-size: 0.8rem;
        }
        .modal-details .detail-label .icon {
            margin-right: 8px;
        }
        .modal-details .detail-value {
            font-weight: 500;
            word-break: break-all;
        }
        .modal-details .hr-text {
            margin-top: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .btn-action {
            width: 36px;
            height: 36px;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            border: none;
            transition: all 0.2s ease-in-out;
        }

        .btn-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
        
        /* View Button (Blue) */
        .btn-action-view {
            background-color: #e7f5ff;  
            color: #1c7ed6;             
        }
        .btn-action-view:hover {
            background-color: #d0ebff;
            color: #1971c2;
        }

        /* Edit Button (Green) */
        .btn-action-edit {
            background-color: #e6fcf5;  
            color: #2f9e44;            
        }
        .btn-action-edit:hover {
            background-color: #c3fae8;
            color: #2b8a3e;
        }

        /* Delete Button (Red) */
        .btn-action-delete {
            background-color: #fff5f5;  
            color: #e03131;             
        }
        .btn-action-delete:hover {
            background-color: #ffc9c9;
            color: #c92a2a;
        }

        /* Documents Button (Gray) */
        .btn-action-docs {
            background-color: #f8f9fa;  
            color: #868e96;            
        }
        .btn-action-docs:hover {
            background-color: #e9ecef;
            color: #495057;
        }

        /* Change Request Button (Orange) */
        .btn-action-cr {
            background-color: #fff4e6;  
            color: #f76707;            
        }
        .btn-action-cr:hover {
            background-color: #ffe8cc;
            color: #d9480f;
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

            @if(in_array($status, ['retired', 'abandoned']))
                <div class="btn-group me-auto" role="group"> 
                    {{-- Note: 'me-auto' pushes the advanced filter button to the right --}}
                    <a href="{{ route('internal-solutions.index', ['status' => 'abandoned']) }}" class="btn {{ $status == 'abandoned' ? 'btn-primary' : 'btn-outline-secondary' }}">Abandoned</a>
                    <a href="{{ route('internal-solutions.index', ['status' => 'retired']) }}" class="btn {{ $status == 'retired' ? 'btn-primary' : 'btn-outline-secondary' }}">Retired</a>
                </div>
            @endif

            @if($status == 'operational')
            <div class="btn-group" role="group">
                <button type="button" wire:click="toggleWithoutCrFilter(false)" class="btn {{ !$filterWithoutCr ? 'btn-primary' : 'btn-outline-secondary' }}">Operational</button>
                <button type="button" wire:click="toggleWithoutCrFilter(true)" class="btn {{ $filterWithoutCr ? 'btn-primary' : 'btn-outline-secondary' }}">Operational without CR</button>
            </div>
            @endif
            
            @if($status == 'in-progress')  
            <div class="btn-group" role="group">
                <button type="button" wire:click="$set('filterLevel', 'level1')" class="btn {{ $filterLevel === 'level1' ? 'btn-primary' : 'btn-outline-secondary' }}">Level 01</button>
                <button type="button" wire:click="$set('filterLevel', 'others')" class="btn {{ $filterLevel === 'others' ? 'btn-primary' : 'btn-outline-secondary' }}">Others</button>
            </div>
            @endif
            
            @if (in_array($status, ['operational', 'in-progress', 'retired', 'abandoned']))
            <div class="ms-auto">
                 <button class="btn btn-outline-primary" type="button" data-bs-toggle="collapse" data-bs-target="#filter-card">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M4 4h16v2.172a2 2 0 0 1 -.586 1.414l-4.414 4.414v7l-6 2v-8.5l-4.48 -4.928a2 2 0 0 1 -.52 -1.345v-2.227z"></path></svg>
                    Advanced Filters
                </button>
            </div>
            @endif

        </div>
    </div>

    {{-- The collapsible filter section --}}
    @if(in_array($status, ['operational', 'in-progress', 'recently-launched', 'retired', 'abandoned']))
    <div class="collapse {{ $status == 'recently-launched' ? 'show' : '' }}" id="filter-card" wire:ignore.self>
        <div class="card card-body">
            <div class="row g-3">
                <div class="col-md-3"><label class="form-label">Application Name</label><input type="text" class="form-control" placeholder="Search by name..." wire:model.live.debounce.300ms="filterAppName"></div>
                <div class="col-md-3"><label class="form-label">Application Group</label><select class="form-select" wire:model.live="filterAppGroup"><option value="">All Groups</option>@foreach($applicationGroups as $group)<option value="{{ $group->ParentProjectID }}">{{ $group->ParentProjectGroup }}</option>@endforeach</select></div>
                <div class="col-md-3"><label class="form-label">SDLC Phase</label><select class="form-select" wire:model.live="filterSdlcPhase"><option value="">All Phases</option>@foreach($sdlcPhasesList as $phase)<option value="{{ $phase }}">{{ $phase }}</option>@endforeach</select></div>
                <div class="col-md-3"><label class="form-label">Developed By</label><select class="form-select" wire:model.live="filterDevelopedBy"><option value="">Any Developer</option>@foreach($developers as $developer)<option value="{{ $developer }}">{{ $developer }}</option>@endforeach</select></div>
                <div class="col-12 text-end"><button class="btn btn-link" wire:click="resetFilters">Reset</button></div>
            </div>
        </div>
    </div>
    @endif

    
    
    {{-- TABLE SECTION --}}
     <div class="table-responsive">
        <table class="table card-table table-vcenter">
            <thead>
                <tr>
                    @if($status == 'abandoned')
                        <th class="fw-bold text-uppercase text-muted" style="font-size: 0.75rem;"><span onclick="@this.dispatch('callSortBy', { field: 'App_Name' })" style="cursor: pointer;">Application Name</span>@if($sortBy === 'App_Name')<span>{{ $sortDirection === 'asc' ? '▲' : '▼' }}</span>@endif</th>
                        <th class="fw-bold text-uppercase text-muted" style="font-size: 0.75rem;"><span onclick="@this.dispatch('callSortBy', { field: 'Developed_By' })" style="cursor: pointer;">Developed By</span>@if($sortBy === 'Developed_By')<span>{{ $sortDirection === 'asc' ? '▲' : '▼' }}</span>@endif</th>
                        <th class="fw-bold text-uppercase text-muted" style="font-size: 0.75rem;"><span onclick="@this.dispatch('callSortBy', { field: 'SDLCPhase' })" style="cursor: pointer;">SDLC Phase</span>@if($sortBy === 'SDLCPhase')<span>{{ $sortDirection === 'asc' ? '▲' : '▼' }}</span>@endif</th>
                        <th class="fw-bold text-uppercase text-muted" style="font-size: 0.75rem;"><span onclick="@this.dispatch('callSortBy', { field: 'StartDate' })" style="cursor: pointer;">Start Date</span>@if($sortBy === 'StartDate')<span>{{ $sortDirection === 'asc' ? '▲' : '▼' }}</span>@endif</th>
                        <th class="fw-bold text-uppercase text-muted" style="font-size: 0.75rem;">Comment</th>
                    @elseif($status == 'retired')
                        <th class="fw-bold text-uppercase text-muted" style="font-size: 0.75rem;"><span onclick="@this.dispatch('callSortBy', { field: 'App_Name' })" style="cursor: pointer;">Application Name</span>@if($sortBy === 'App_Name')<span>{{ $sortDirection === 'asc' ? '▲' : '▼' }}</span>@endif</th>
                        <th class="fw-bold text-uppercase text-muted" style="font-size: 0.75rem;"><span onclick="@this.dispatch('callSortBy', { field: 'Developed_By' })" style="cursor: pointer;">Developed By</span>@if($sortBy === 'Developed_By')<span>{{ $sortDirection === 'asc' ? '▲' : '▼' }}</span>@endif</th>
                        <th class="fw-bold text-uppercase text-muted" style="font-size: 0.75rem;"><span onclick="@this.dispatch('callSortBy', { field: 'LaunchedDate' })" style="cursor: pointer;">Launched Date</span>@if($sortBy === 'LaunchedDate')<span>{{ $sortDirection === 'asc' ? '▲' : '▼' }}</span>@endif</th>
                        <th class="fw-bold text-uppercase text-muted" style="font-size: 0.75rem;"><span onclick="@this.dispatch('callSortBy', { field: 'SDLCPhase' })" style="cursor: pointer;">SDLC Phase</span>@if($sortBy === 'SDLCPhase')<span>{{ $sortDirection === 'asc' ? '▲' : '▼' }}</span>@endif</th>
                        <th class="fw-bold text-uppercase text-muted" style="font-size: 0.75rem;"><span onclick="@this.dispatch('callSortBy', { field: 'Price' })" style="cursor: pointer;">Solution Value</span>@if($sortBy === 'Price')<span>{{ $sortDirection === 'asc' ? '▲' : '▼' }}</span>@endif</th>
                        <th class="fw-bold text-uppercase text-muted" style="font-size: 0.75rem;">Comment</th>
                    @elseif(in_array($status, ['in-progress', 'recently-launched']))
                        <th class="fw-bold text-uppercase text-muted" style="font-size: 0.75rem;"><span onclick="@this.dispatch('callSortBy', { field: 'ParentProjectID' })" style="cursor: pointer;">Application Group</span>@if($sortBy === 'ParentProjectID')<span>{{ $sortDirection === 'asc' ? '▲' : '▼' }}</span>@endif</th>
                        <th class="fw-bold text-uppercase text-muted" style="font-size: 0.75rem;"><span onclick="@this.dispatch('callSortBy', { field: 'App_Name' })" style="cursor: pointer;">Application Name</span>@if($sortBy === 'App_Name')<span>{{ $sortDirection === 'asc' ? '▲' : '▼' }}</span>@endif</th>
                        <th class="fw-bold text-uppercase text-muted" style="font-size: 0.75rem;"><span onclick="@this.dispatch('callSortBy', { field: 'Developed_By' })" style="cursor: pointer;">Developed By</span>@if($sortBy === 'Developed_By')<span>{{ $sortDirection === 'asc' ? '▲' : '▼' }}</span>@endif</th>
                        <th class="fw-bold text-uppercase text-muted" style="font-size: 0.75rem;"><span onclick="@this.dispatch('callSortBy', { field: 'SDLCPhase' })" style="cursor: pointer;">SDLC Phase</span>@if($sortBy === 'SDLCPhase')<span>{{ $sortDirection === 'asc' ? '▲' : '▼' }}</span>@endif</th>
                        <th class="fw-bold text-uppercase text-muted" style="font-size: 0.75rem;"><span onclick="@this.dispatch('callSortBy', { field: 'StartDate' })" style="cursor: pointer;">Start</span>@if($sortBy === 'StartDate')<span>{{ $sortDirection === 'asc' ? '▲' : '▼' }}</span>@endif</th>
                        <th class="fw-bold text-uppercase text-muted" style="font-size: 0.75rem;"><span onclick="@this.dispatch('callSortBy', { field: 'TargetDate' })" style="cursor: pointer;">Target</span>@if($sortBy === 'TargetDate')<span>{{ $sortDirection === 'asc' ? '▲' : '▼' }}</span>@endif</th>
                        <th class="fw-bold text-uppercase text-muted" style="font-size: 0.75rem;"><span onclick="@this.dispatch('callSortBy', { field: 'UserSpecificSection' })" style="cursor: pointer;">UD</span>@if($sortBy === 'UserSpecificSection')<span>{{ $sortDirection === 'asc' ? '▲' : '▼' }}</span>@endif</th>
                        <th class="fw-bold text-uppercase text-muted" style="font-size: 0.75rem;"><span onclick="@this.dispatch('callSortBy', { field: 'Price' })" style="cursor: pointer;">Solution Value</span>@if($sortBy === 'Price')<span>{{ $sortDirection === 'asc' ? '▲' : '▼' }}</span>@endif</th>
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
                <tr 
                    wire:key="{{ $solution->ID }}" 
                    class="{{ $status == 'retired' ? 'tr-retired' : '' }} {{ $status == 'abandoned' ? 'tr-abandoned' : '' }}">

                    @if($status == 'abandoned')
                        <td><strong>{{ $solution->App_Name }}</strong></td>
                        <td>{{ $solution->Developed_By }}</td>
                        <td><span class="badge bg-red-lt">{{ $solution->SDLCPhase }}</span></td>
                        <td>{{ $solution->StartDate }}</td>
                        <td>{{ $solution->comments->first()->Comment ?? '-' }}</td>
                    @elseif($status == 'retired')
                        <td><strong>{{ $solution->App_Name }}</strong></td>
                        <td>{{ $solution->Developed_By }}</td>
                        <td>{{ $solution->LaunchedDate ?? '-' }}</td>
                        <td><span class="badge bg-red-lt">{{ $solution->SDLCPhase }}</span></td>
                        <td>{{ number_format($solution->Price, 2) }}</td>
                        <td>{{ $solution->comments->first()->Comment ?? '-' }}</td>
                    @elseif(in_array($status, ['in-progress', 'recently-launched']))
                        <td><span class="badge bg-blue-lt">{{ $solution->parentProject->ParentProjectGroup ?? 'N/A' }}</span></td>
                        <td><strong>{{ $solution->App_Name }}</strong> @if ($solution->App_Category == 'Change Request' && $solution->mainApplicationParent)<div style="font-size: 0.75rem; font-style: italic;"><a href="#">CR of {{ $solution->mainApplicationParent->App_Name }}</a></div>@endif</td>
                        <td>{{ $solution->Developed_By }}</td>
                        <td>{{ $solution->SDLCPhase }}</td>
                        <td>{{ $solution->StartDate }}</td>
                        <td>{{ $solution->TargetDate }}</td>
                        <td>{{ $solution->UserSpecificSection ?? '-' }}</td>
                        <td>{{ number_format($solution->Price, 2) }}</td>    
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
                        <td><strong>{{ $solution->App_Name }}</strong> @if ($solution->App_Category == 'Change Request' && $solution->mainApplicationParent)<div style="font-size: 0.75rem; font-style: italic;"><a href="#">CR of {{ $solution->mainApplicationParent->App_Name }}</a></div>@endif</td>
                        <td>{{ $solution->Developed_By }}</td>
                        <td>{{ $solution->LaunchedDate }}</td>
                        <td>{{ $solution->VADate }}</td>
                        <td>{{ number_format($solution->Price, 2) }}</td>
                    @endif

                    <td class="text-center">
                        <div class="btn-list flex-nowrap justify-content-center">
                            @if(in_array($status, ['retired', 'abandoned']))
                                <!-- View Button -->
                                <button class="btn btn-action btn-action-view" data-bs-toggle="modal" data-bs-target="#details-modal-{{ $solution->ID }}" title="View Details">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-eye" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" /></svg>
                                </button>
                            @else
                                <!-- View Button -->
                                <button class="btn btn-action btn-action-view" data-bs-toggle="modal" data-bs-target="#details-modal-{{ $solution->ID }}" title="View Details">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-eye" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" /></svg>
                                </button>
                                
                                <!-- Edit Button -->
                                <a href="{{ route('internal-solutions.edit', $solution->ID) }}" class="btn btn-action btn-action-edit" title="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-pencil" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4" /><path d="M13.5 6.5l4 4" /></svg>
                                </a>

                                <!-- Documents Button -->
                                <a href="#" class="btn btn-action btn-action-docs" title="Documents">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-text" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" /><path d="M9 9l1 0" /><path d="M9 13l6 0" /><path d="M9 17l6 0" /></svg>
                                </a>

                                <!-- Change Requests Button -->
                                @if ($solution->App_Category == 'Main Application' && in_array($status, ['operational', 'in-progress', 'recently-launched']))
                                    <a href="{{ route('internal-solutions.change-requests', $solution->ID) }}" class="btn btn-action btn-action-cr" title="Change Requests">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-git-pull-request" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 18m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M6 6m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M18 18m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M6 8l0 8" /><path d="M11 6h5a2 2 0 0 1 2 2v8" /><path d="M14 9l-3 -3l3 -3" /></svg>
                                    </a>
                                @endif

                                <!-- Delete Button -->
                                <button class="btn btn-action btn-action-delete" data-bs-toggle="modal" data-bs-target="#delete-modal-{{ $solution->ID }}" title="Delete">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
                                </button>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    @php
                        $colspan = 7; if (in_array($status, ['in-progress', 'recently-launched'])) $colspan = 9; if ($status == 'operational' && $filterWithoutCr) $colspan = 9; if (in_array($status, ['retired', 'abandoned'])) $colspan = 7;
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
        {{-- Delete Modal (This is unchanged) --}}
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

       {{-- ======================================================= --}}
        {{-- NEW: Details Modal for each solution is added here --}}
        {{-- ======================================================= --}}
        <div class="modal modal-blur fade" id="details-modal-{{ $solution->ID }}" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $solution->App_Name }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body modal-details">
                        <div class="row">
                            <div class="col-md-6">
                                @if($solution->App_Category == 'Change Request')
                                    <span class="badge bg-yellow-lt mb-3">Change Request</span>
                                @else
                                    <span class="badge bg-blue-lt mb-3">Main Application</span>
                                @endif
                            </div>
                            <div class="col-md-6 text-md-end">
                                <span class="badge bg-purple-lt mb-3">{{ $solution->SDLCPhase ?? '-' }}</span>
                            </div>
                        </div>
                        
                        <div class="hr-text">Key Details</div>
                        <div class="row">
                            <div class="col-md-6 detail-item">
                                <div class="detail-label"><svg xmlns="http://www.w3.org/2000/svg" class="icon text-primary" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M11 3l9 9a1.5 1.5 0 0 1 0 2l-6 6a1.5 1.5 0 0 1 -2 0l-9 -9v-4a2 2 0 0 1 2 -2h4" /><circle cx="9" cy="9" r="2" /></svg>Application Group</div>
                                <div class="detail-value">{{ $solution->parentProject->ParentProjectGroup ?? 'N/A' }}</div>
                            </div>
                            <div class="col-md-6 detail-item">
                                <div class="detail-label"><svg xmlns="http://www.w3.org/2000/svg" class="icon text-success" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><rect x="3" y="4" width="18" height="16" rx="3" /><circle cx="9" cy="10" r="2" /><line x1="15" y1="8" x2="17" y2="8" /><line x1="15" y1="12" x2="17" y2="12" /><line x1="7" y1="16" x2="17" y2="16" /></svg>Business Owner</div>
                                <div class="detail-value">{{ $solution->Bus_Owner ?? '-' }}</div>
                            </div>
                            <div class="col-md-6 detail-item">
                                <div class="detail-label"><svg xmlns="http://www.w3.org/2000/svg" class="icon text-info" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="7" r="4" /><path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" /></svg>Developed By</div>
                                <div class="detail-value">{{ $solution->Developed_By ?? '-' }}</div>
                            </div>
                            <div class="col-md-6 detail-item">
                                <div class="detail-label"><svg xmlns="http://www.w3.org/2000/svg" class="icon text-orange" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="9" cy="7" r="4" /><path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" /><path d="M16 3.13a4 4 0 0 1 0 7.75" /><path d="M21 21v-2a4 4 0 0 0 -3 -3.85" /></svg>Developed Team</div>
                                <div class="detail-value">{{ $solution->Developed_Team ?? '-' }}</div>
                            </div>
                        </div>

                        <div class="hr-text">Timeline</div>
                        <div class="row">
                            <div class="col-md-6 detail-item">
                                <div class="detail-label"><svg xmlns="http://www.w3.org/2000/svg" class="icon text-muted" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><rect x="4" y="5" width="16" height="16" rx="2" /><line x1="16" y1="3" x2="16" y2="7" /><line x1="8" y1="3" x2="8" y2="7" /><line x1="4" y1="11" x2="20" y2="11" /><rect x="8" y="15" width="2" height="2" /></svg>Start Date</div>
                                <div class="detail-value">{{ $solution->StartDate ?? '-' }}</div>
                            </div>
                            <div class="col-md-6 detail-item">
                                <div class="detail-label"><svg xmlns="http://www.w3.org/2000/svg" class="icon text-muted" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 5m0 2a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2z" /><path d="M16 3v4" /><path d="M8 3v4" /><path d="M4 11h16" /><path d="M12 16m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" /></svg>Target Date</div>
                                <div class="detail-value">{{ $solution->TargetDate ?? '-' }}</div>
                            </div>
                            <div class="col-md-6 detail-item">
                                <div class="detail-label"><svg xmlns="http://www.w3.org/2000/svg" class="icon text-muted" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M11.5 21h-5.5a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v4" /><path d="M16 3v4" /><path d="M8 3v4" /><path d="M4 11h16" /><path d="M16 19l2 2l4 -4" /><path d="M15 14l-2 2l-2 -2" /></svg>UAT Date</div>
                                <div class="detail-value">{{ $solution->UATDate ?? '-' }}</div>
                            </div>
                            <div class="col-md-6 detail-item">
                                <div class="detail-label"><svg xmlns="http://www.w3.org/2000/svg" class="icon text-muted" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M11.5 21h-5.5a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v6" /><path d="M16 3v4" /><path d="M8 3v4" /><path d="M4 11h16" /><path d="M15 19l2 2l4 -4" /></svg>Launched Date</div>
                                <div class="detail-value">{{ $solution->LaunchedDate ?? '-' }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        @if(!in_array($status, ['retired', 'abandoned']))
                        <a href="{{ route('internal-solutions.edit', $solution->ID) }}" class="btn btn-primary">Edit Full Details</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>