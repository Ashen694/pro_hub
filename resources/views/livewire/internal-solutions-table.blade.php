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
            cursor: pointer;  
        }

        .action-btn i {
            font-size: 16px;
        }

        /* View Button (Green) */
        .action-btn-view {
            background-color: #e3f9e5;
        }
        .action-btn-view i {
            color: #28a745;
        }
        .action-btn-view:hover {
            background-color: #c1f2c6;
        }

        /* Edit Button (Blue) */
        .action-btn-edit {
            background-color: #e6f0ff;
        }
        .action-btn-edit i {
            color: #0057ff;
        }
        .action-btn-edit:hover {
            background-color: #cce0ff;
        }

        /* Delete Button (Red) */
        .action-btn-delete {
            background-color: #ffe6e6;
        }
        .action-btn-delete i {
            color: #dc3545;
        }
        .action-btn-delete:hover {
            background-color: #ffcccc;
        }

        /* Documents Button (Gray) */
        .action-btn-docs {
            background-color: #f1f3f5;
        }
        .action-btn-docs i {
            color: #495057;
        }
        .action-btn-docs:hover {
            background-color: #e9ecef;
        }

        /* Change Request Button (Orange) */
        .action-btn-cr {
            background-color: #fff4e6;
        }
        .action-btn-cr i {
            color: #f76707;
        }
        .action-btn-cr:hover {
            background-color: #ffe8cc;
        } 
        
         /* --- CORRECTED STYLES FOR SCROLLING TABLE --- */

    /* Rule 1: Keep the main card rounded and hide anything that pokes out of IT */
    .card {
      border-radius: 12px !important;
      overflow: hidden;
    }
    
    /* Rule 2: THIS IS THE FIX. Allow the .table-responsive div to scroll horizontally */
    .table-responsive {
      overflow-x: auto !important;
    }

    /* Rule 3: Make the table have its own full width */
    .table {
      border-collapse: separate;
      border-spacing: 0;
      min-width: max-content;   
    }

    /* Rule 4: Style the individual cells */
    .table td, .table th {
        background-color: #fff;  
        border: 1px solid #f0f0f0;
    }

    /* Rule 5: Keep the rounded corners on the first and last cells of each row */
    .table tbody tr td:first-child {
        border-top-left-radius: 8px;
        border-bottom-left-radius: 8px;
    }
    .table tbody tr td:last-child {
        border-top-right-radius: 8px;
        border-bottom-right-radius: 8px;
    }

    /* Style for Retired rows*/
    .tr-retired td:first-child ~ td {
        background-color:rgb(252, 251, 194) !important; /* Light Yellow */
    }

    /* Style for Abandoned rows */
    .tr-abandoned td:first-child ~ td {
        background-color:rgb(204, 250, 248) !important; /* Light Blue */
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
                    class="{{ $solution->SDLCPhase == 'Retired' ? 'tr-retired' : '' }} {{ $solution->SDLCPhase == 'Abandoned' ? 'tr-abandoned' : '' }}">

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
                        <div class="d-flex justify-content-center gap-2">
                            @if(in_array($status, ['retired', 'abandoned']))
                                <!-- View Button -->
                                <button type="button" class="action-btn action-btn-view" data-bs-toggle="modal" data-bs-target="#details-modal-{{ $solution->ID }}" title="View Details">
                                    <i class="fas fa-eye"></i>
                                </button>
                            @else
                                <!-- View Button -->
                                <button type="button" class="action-btn action-btn-view" data-bs-toggle="modal" data-bs-target="#details-modal-{{ $solution->ID }}" title="View Details">
                                    <i class="fas fa-eye"></i>
                                </button>
                                
                                <!-- Edit Button -->
                                <a href="{{ route('internal-solutions.edit', $solution->ID) }}" class="action-btn action-btn-edit" title="Edit">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>

                                <!-- Documents Button -->
                                <button type="button" class="action-btn action-btn-docs" data-bs-toggle="modal" data-bs-target="#documents-modal-{{ $solution->ID }}" title="Documents">
                                    <i class="fas fa-file-alt"></i>
                                </button>

                                <!-- Change Requests Button -->
                                @if ($solution->App_Category == 'Main Application' && in_array($status, ['operational', 'in-progress', 'recently-launched']))
                                    <a href="{{ route('internal-solutions.change-requests', $solution->ID) }}" class="action-btn action-btn-cr" title="Change Requests">
                                        <i class="fas fa-code-branch"></i>
                                    </a>
                                @endif

                                <!-- Delete Button -->
                                <button type="button" class="action-btn action-btn-delete" data-bs-toggle="modal" data-bs-target="#delete-modal-{{ $solution->ID }}" title="Delete">
                                    <i class="fas fa-trash-alt"></i>
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
    <div class="card-footer d-flex align-items-center"><a href="{{ route('internal-solutions.export') }}" class="btn btn-outline-primary">Export All Details to Excel</a><div class="ms-auto">{{ $solutions->links() }}</div></div>
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

         <div class="modal modal-blur fade" id="documents-modal-{{ $solution->ID }}" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Documents for: {{ $solution->App_Name }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-vcenter card-table">
                            <thead>
                                <tr>
                                    <th>Document Name</th>
                                    <th>Uploaded Time</th>
                                    <th>Uploaded By</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($solution->documents as $doc)
                                <tr>
                                    <td>{{ $doc->Doc_Name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($doc->Created_Time)->format('Y-m-d H:i') }}</td>
                                    <td>{{ $doc->uploader->name ?? 'N/A' }}</td>
                                    <td class="text-end">
                                        <a href="{{ route('dms.download', $doc->ID) }}" class="btn btn-sm btn-outline-primary" target="_blank">Download</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">
                                        No documents found for this solution.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>