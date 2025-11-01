@extends('layouts.app')

@section('title', 'Weekly Plan')

{{-- FIX #1: We are ADDING BACK the 'page-title' section to feed the layout's header --}}
@section('page-title', 'Weekly Plan')

@push('styles')
    @vite(['resources/css/weekly-index.css'])
    <style>
        /* We keep these styles to make the content area look correct */
        .page-body { padding: 0 !important; }
    </style>
@endpush

@push('scripts')
    @vite(['resources/js/weekly-index.js'])
@endpush

@section('content')
    @php
        $canCreate = Auth::check();
    @endphp
    

    <div class="slt-container max-w-7xl mx-auto sm:px-6 lg:px-8" style="position: relative; z-index: 1; padding: 1.5rem 0.75rem;">       
        @if(session('ok'))
            <div class="slt-alert-success mb-4 px-4 py-3" id="slt-alert" style="background: rgba(237,251,234,.9);">
                {{ session('ok') }}
                <button class="slt-alert-close" type="button" aria-label="Close" onclick="this.parentElement.remove()">&times;</button>
            </div>
        @endif

        <div class="slt-action-bar-wrapper">
            <div class="slt-action-buttons">
                @if($canCreate)
                    <a href="{{ route('my-work.weekly.create') }}" class="slt-btn slt-btn-primary"><i class="ti ti-plus" aria-hidden="true"></i> Create New</a>
                @endif
                <a href="{{ route('my-work.weekly.report') }}" class="slt-btn slt-btn-outline"><i class="ti ti-file-text"></i> Weekly Plan Report</a>
                <a href="{{ route('my-work.backup-matrix') }}" class="slt-btn slt-btn-outline"><i class="ti ti-grid-dots"></i> Backup Matrix</a>
            </div>
            <div class="slt-action-right">
                <form method="GET" action="{{ route('my-work.weekly.update') }}">
                    @if(!empty($q))<input type="hidden" name="q" value="{{ $q }}">@endif
                    <select name="per_page" class="slt-per-page-select" onchange="this.form.submit()">
                        @foreach([10,20,30,40,50] as $opt)<option value="{{ $opt }}" @selected((int)($perPage ?? 10) === $opt)>{{ $opt }} Rows</option>@endforeach
                    </select>
                </form>
                <form method="GET" action="{{ route('my-work.weekly.update') }}" class="slt-search-form">
                    @if(request('per_page'))<input type="hidden" name="per_page" value="{{ request('per_page') }}">@endif
                    <input name="q" value="{{ $q ?? '' }}" placeholder="Search…" class="slt-search-input">
                    <button class="slt-btn slt-btn-outline" type="submit">Search</button>
                    @if(!empty($q))<a href="{{ route('my-work.weekly.update', ['per_page'=>request('per_page')]) }}" class="slt-btn slt-btn-outline">Clear</a>@endif
                </form>
            </div>
        </div>

        <div class="slt-surface">
            <div class="slt-table-container">
                <table class="slt-table" id="weeklyTable">
                    <thead>
                        <tr>
                            <th class="px-4 py-3 text-left">Week</th>
                            <th class="px-4 py-3 text-left">External Platform/Solution</th>
                            <th class="px-4 py-3 text-left">Internal Platform/Solution</th>
                            <th class="px-4 py-3 text-left">Work Plan Details</th>
                            <th class="px-4 py-3 text-left">Updated By</th>
                            <th class="px-4 py-3 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($plans as $p)
                            @php
                                $weekStart = optional($p->start_date)->format('d/m/Y');
                                $weekEnd   = optional($p->end_date)->format('d/m/Y');
                                $extText = $p->externalPlatforms->pluck('platform_name')->implode(', ') ?: '—';
                                $intText = $p->internalPlatforms->pluck('App_Name')->implode(', ') ?: '—';
                                $byName  = optional($p->employee)->Emp_Name ?? optional($p->employee)->Emp_Email ?? $p->updated_by;
                                $updatedAt = optional($p->updated_at)->timezone('Asia/Colombo')->format('d/m/Y h:i A');
                            @endphp
                            <tr class="slt-divider border-t">
                                <td class="px-4 py-3">{{ $weekStart }} - {{ $weekEnd }}</td>
                                <td class="px-4 py-3">{{ $extText }}</td>
                                <td class="px-4 py-3">{{ $intText }}</td>
                                <td class="px-4 py-3">{{ Str::limit($p->workplan_desc, 80) }}</td>
                                <td class="px-4 py-3">{{ $byName }}</td>
                                <td class="px-4 py-3 slt-actions">
                                    <div class="slt-actions-group">
                                        <a href="{{ route('my-work.weekly.edit', $p) }}" class="btn-action btn-edit" title="Edit"><i class="ti ti-pencil"></i></a>
                                        <button type="button" class="btn-action btn-view slt-details-btn" title="View" data-week="{{ $weekStart }} - {{ $weekEnd }}" data-external="{{ e($extText) }}" data-internal="{{ e($intText) }}" data-details="{{ e($p->workplan_desc) }}" data-updated-by="{{ e($byName) }}" data-updated-at="{{ e($updatedAt) }}"><i class="ti ti-eye"></i></button>
                                        <form action="{{ route('my-work.weekly.destroy', $p) }}" method="POST" class="inline slt-delete-form">
                                            @csrf @method('DELETE')
                                            {{-- FIX #1: ADDED ALL THE MISSING data-* ATTRIBUTES TO THE DELETE BUTTON --}}
                                            <button type="button"
                                                    class="btn-action btn-del slt-delete-btn"
                                                    title="Delete"
                                                    data-week="{{ $weekStart }} - {{ $weekEnd }}"
                                                    data-external="{{ e($extText) }}"
                                                    data-internal="{{ e($intText) }}"
                                                    data-details="{{ e($p->workplan_desc) }}"
                                                    data-updated-by="{{ e($byName) }}"
                                                    data-updated-at="{{ e($updatedAt) }}">
                                                <i class="ti ti-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="slt-empty-state" colspan="6" style="background: white; color: #6b7a8a;">
                                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="margin:0 auto 1rem;opacity:.4">
                                        <circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line>
                                    </svg>
                                    <p style="font-weight:600">No weekly plans found.</p>
                                    <p style="font-size:.875rem;margin-top:.5rem">Create your first plan to get started!</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($plans->hasPages())<div class="slt-pagination mt-4">{{ $plans->links() }}</div>@endif
        @if(isset($lastUpdatedPlan) && $lastUpdatedPlan)<div class="slt-bottom-meta" style="color: rgba(255,255,255,0.8);">Last updated: <strong>{{ optional($lastUpdatedPlan->updated_at)->timezone('Asia/Colombo')->format('d/m/Y h:i A') }}</strong></div>@endif
    </div>

    {{-- Details Modal --}}
    <div class="slt-modal-backdrop" id="sltModalBackdrop" aria-hidden="true">
        <div class="slt-modal" role="dialog" aria-modal="true" aria-labelledby="sltModalTitle">
            <div class="slt-modal-header"><h3 class="slt-modal-title" id="sltModalTitle">Weekly Plan Details</h3><button class="slt-modal-close" type="button" aria-label="Close" onclick="closeSltModal()">&times;</button></div>
            <div class="slt-modal-body"><div class="slt-modal-grid">
                <div class="slt-modal-label">Week</div><div class="slt-modal-value" id="sltModalWeek">—</div>
                <div class="slt-modal-label">External Platform</div><div class="slt-modal-value" id="sltModalExternal">—</div>
                <div class="slt-modal-label">Internal Platform</div><div class="slt-modal-value" id="sltModalInternal">—</div>
                <div class="slt-modal-label">Details</div><div class="slt-modal-value" id="sltModalDetails" style="white-space: pre-wrap;">—</div>
                <div class="slt-modal-label">Updated By</div><div class="slt-modal-value" id="sltModalUpdatedBy">—</div>
                <div class="slt-modal-label">Last Updated</div><div class="slt-modal-value" id="sltModalUpdatedAt">—</div>
            </div></div>
        </div>
    </div>

    {{-- Delete Warning Modal --}}
    <div class="slt-modal-backdrop" id="sltDeleteBackdrop" aria-hidden="true">
        <div class="slt-modal slt-modal-danger" role="dialog" aria-modal="true" aria-labelledby="sltDeleteTitle">
            <div class="slt-modal-header"><h3 class="slt-modal-title" id="sltDeleteTitle">Delete Weekly Plan</h3><button class="slt-modal-close" type="button" aria-label="Close" onclick="closeDeleteModal()">&times;</button></div>
            <div class="slt-modal-body">
                <div class="slt-warning" style="margin-bottom:12px;"><strong>Confirm delete?</strong> This action cannot be undone.</div>
                {{-- FIX #2: CHANGED THE IDs to match the JavaScript (`delWeek`, `delExternal`, etc.) --}}
                <div class="slt-modal-grid">
                    <div class="slt-modal-label">Week</div><div class="slt-modal-value" id="delWeek">—</div>
                    <div class="slt-modal-label">External Platform</div><div class="slt-modal-value" id="delExternal">—</div>
                    <div class="slt-modal-label">Internal Platform</div><div class="slt-modal-value" id="delInternal">—</div>
                    <div class="slt-modal-label">Details</div><div class="slt-modal-value" id="delDetails" style="white-space:pre-wrap;">—</div>
                    <div class="slt-modal-label">Updated By</div><div class="slt-modal-value" id="delUpdatedBy">—</div>
                    <div class="slt-modal-label">Last Updated</div><div class="slt-modal-value" id="delUpdatedAt">—</div>
                </div>
                <div style="display:flex;gap:.5rem;justify-content:flex-end;margin-top:16px;">
                    <button type="button" class="slt-btn slt-btn-outline" onclick="closeDeleteModal()">Cancel</button>
                    <button type="button" class="slt-btn slt-btn-danger" id="sltConfirmDeleteBtn">Delete</button>
                </div>
            </div>
        </div>
    </div>
@endsection