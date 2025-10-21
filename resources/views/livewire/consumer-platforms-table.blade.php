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
                        <a href="#" class="btn btn-sm btn-outline-primary">Details</a>
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
</div>