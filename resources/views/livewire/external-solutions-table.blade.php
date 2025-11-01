<div>
    @push('styles')
    <style>
        .action-btn { display: inline-flex; align-items: center; justify-content: center; width: 36px; height: 36px; border-radius: 8px; text-decoration: none !important; transition: all 0.2s ease-in-out; border: none; cursor: pointer; }
        .action-btn i { font-size: 16px; }
        .action-btn-view { background-color: #e3f9e5; } .action-btn-view i { color: #28a745; } .action-btn-view:hover { background-color: #c1f2c6; }
        .action-btn-edit { background-color: #e6f0ff; } .action-btn-edit i { color: #0057ff; } .action-btn-edit:hover { background-color: #cce0ff; }
        .action-btn-delete { background-color: #ffe6e6; } .action-btn-delete i { color: #dc3545; } .action-btn-delete:hover { background-color: #ffcccc; }
        .action-btn-docs { background-color: #f1f3f5; } .action-btn-docs i { color: #495057; } .action-btn-docs:hover { background-color: #e9ecef; }
        .modal-details .detail-label { color: #626976; font-weight: 600; }
        .modal-details .detail-value { font-weight: 500; }
    </style>
    @endpush

    <div class="card-body border-bottom py-3">
        <div class="d-flex">
            {{-- Tabs for Prospective/In-Progress OR Retired/Abandoned --}}
            @if ($status === 'prospective')
                <div class="btn-group" role="group">
                    <button type="button" wire:click="setSubStatus('prospective')" class="btn {{ $subStatus == 'prospective' ? 'btn-primary' : 'btn-outline-secondary' }}">Prospective</button>
                    <button type="button" wire:click="setSubStatus('in-progress')" class="btn {{ $subStatus == 'in-progress' ? 'btn-primary' : 'btn-outline-secondary' }}">In-Progress</button>
                </div>
            @elseif (in_array($status, ['retired', 'abandoned']))
                <div class="btn-group" role="group">
                    <a href="{{ route('external-solutions.index', ['status' => 'abandoned']) }}" class="btn {{ $status == 'abandoned' ? 'btn-primary' : 'btn-outline-secondary' }}">Abandoned</a>
                    <a href="{{ route('external-solutions.index', ['status' => 'retired']) }}" class="btn {{ $status == 'retired' ? 'btn-primary' : 'btn-outline-secondary' }}">Retired</a>
                </div>
            @endif

            {{-- NEW: Search and Filter Section --}}
            <div class="ms-auto text-muted">
                <div class="ms-2 d-inline-block">
                    <select wire:model.live="filterDevelopedBy" class="form-select form-select-sm">
                        <option value="">All Developers</option>
                        @foreach($developers as $developer)
                            <option value="{{ $developer }}">{{ $developer }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="ms-2 d-inline-block">
                    <input type="text" wire:model.live.debounce.300ms="search" class="form-control form-control-sm" placeholder="Search...">
                </div>
            </div>
        </div>
    </div>

    {{-- Table Section --}}
    <div class="table-responsive">
        <div wire:loading class="p-4 text-center">Loading data...</div>
        <table class="table card-table table-vcenter text-nowrap datatable" wire:loading.remove>
            <thead>
                <tr>
                    {{-- All Headers based on status --}}
                    @if ($status === 'operational')
                        <th>Application Name</th><th>Developed By</th><th>Launched Billed On</th><th>OTC/MRC</th><th>Contr. Period</th><th>Revenue SW.Value</th><th>Billed</th><th>DPO Handover Date</th><th>Action</th>
                    @elseif ($status === 'prospective' && $subStatus === 'prospective')
                        <th>Application Name</th><th>Company/Customer</th><th>Developed By</th><th>SDLC Stage</th><th>Start Date</th><th>Action</th>
                    @elseif ($status === 'prospective' && $subStatus === 'in-progress')
                        <th>Application Name</th><th>Company/Customer</th><th>Developed By</th><th>SDLC Stage</th><th>Start Date</th><th>DPO Handover Date</th><th>Action</th>
                    @elseif ($status === 'retired')
                        <th>Application Name</th><th>Developed By</th><th>Launched Billed On</th><th>OTC/MRC</th><th>Contr. Period</th><th>Revenue</th><th>Billed</th><th>Sales Team</th><th>Proposal Uploaded</th><th>DPO Handover Date</th><th>Action</th>
                    @elseif ($status === 'abandoned')
                        <th>Application Name</th><th>Company/Customer</th><th>Developed By</th><th>SDLC Stage</th><th>Start Date</th><th>DPO Handover Date</th><th>Action</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse ($solutions as $solution)
                <tr wire:key="{{ $solution->platform_id }}">
                    {{-- All Body rows based on status --}}
                    @if ($status === 'operational')
                        <td>{{ $solution->platform_name }}</td><td>{{ $solution->developed_by }}</td><td>{{ optional($solution->billing_date)->format('Y-m-d') }}</td><td>{{ $solution->platform_otc ?? '-' }}/{{ $solution->platform_mrc ?? '-' }}</td><td>{{ $solution->contract_period }}</td><td>{{ number_format($solution->software_value, 2) }}</td><td>{{-- Billed --}}</td><td>{{ optional($solution->dpo_handover)->format('Y-m-d') }}</td>
                    @elseif ($status === 'prospective' && $subStatus === 'prospective')
                        <td>{{ $solution->platform_name }}</td><td>{{ $solution->platform_owner }}</td><td>{{ $solution->developed_by }}</td><td>{{ $solution->sdlc_stage }}</td><td>{{ optional($solution->start_date)->format('Y-m-d') }}</td>
                    @elseif ($status === 'prospective' && $subStatus === 'in-progress')
                         <td>{{ $solution->platform_name }}</td><td>{{ $solution->platform_owner }}</td><td>{{ $solution->developed_by }}</td><td>{{ $solution->sdlc_stage }}</td><td>{{ optional($solution->start_date)->format('Y-m-d') }}</td><td>{{ optional($solution->dpo_handover)->format('Y-m-d') }}</td>
                    @elseif ($status === 'retired')
                        <td>{{ $solution->platform_name }}</td><td>{{ $solution->developed_by }}</td><td>{{ optional($solution->billing_date)->format('Y-m-d') }}</td><td>{{ $solution->platform_otc ?? '-' }}/{{ $solution->platform_mrc ?? '-' }}</td><td>{{ $solution->contract_period }}</td><td>{{ number_format($solution->software_value, 2) }}</td><td>{{-- Billed --}}</td><td>{{ $solution->sales_am }}</td><td>{{-- Proposal --}}</td><td>{{ optional($solution->dpo_handover)->format('Y-m-d') }}</td>
                    @elseif ($status === 'abandoned')
                        <td>{{ $solution->platform_name }}</td><td>{{ $solution->platform_owner }}</td><td>{{ $solution->developed_by }}</td><td>{{ $solution->sdlc_stage }}</td><td>{{ optional($solution->start_date)->format('Y-m-d') }}</td><td>{{ optional($solution->dpo_handover)->format('Y-m-d') }}</td>
                    @endif
                    
                    {{-- Action Buttons --}}
                    <td>
                        <div class="d-flex justify-content-start gap-2">
                            <button type="button" class="action-btn action-btn-view" data-bs-toggle="modal" data-bs-target="#details-modal-{{ $solution->platform_id }}" title="View Details"><i class="fas fa-eye"></i></button>
                            @if(!in_array($status, ['retired', 'abandoned']))
                                <a href="{{ route('external-solutions.edit', $solution->platform_id) }}" class="action-btn action-btn-edit" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                <a href="{{ route('dms.index', ['type' => 'external']) }}?solution_id={{ $solution->platform_id }}" class="action-btn action-btn-docs" title="Documents"><i class="fas fa-file-alt"></i></a>
                                <button type="button" class="action-btn action-btn-delete" data-bs-toggle="modal" data-bs-target="#delete-modal-{{ $solution->platform_id }}" title="Delete"><i class="fas fa-trash-alt"></i></button>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="11" class="text-center py-5"><h3>No Solutions Found</h3></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($solutions->hasPages())<div class="card-footer d-flex align-items-center"><div class="ms-auto">{{ $solutions->links() }}</div></div>@endif
    @foreach($solutions as $solution)
        {{-- Modals for each solution (Details & Delete) --}}
        @include('livewire.partials.external-solution-modals')
    @endforeach
</div>