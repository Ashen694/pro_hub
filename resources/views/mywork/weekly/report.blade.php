@extends('layouts.app')

@section('title', 'Weekly Plan Report')

@section('page-title', 'Weekly Plan – Report')

@push('styles')
    @vite(['resources/css/weekly-report.css'])
    <style>
        /* .page-header { display: none !important; } */
        
        /* We keep this rule to make the content area look correct */
        .page-body { 
            /* You can keep this if you want no padding, or remove it to use the default padding */
            padding-top: 1.5rem; 
        }
    </style>
@endpush

@push('scripts')
    @vite(['resources/js/weekly-report.js'])
@endpush

@section('content')
    @php
        // Your PHP variables setup...
        $authUser = Auth::user();
        $role     = $authUser->role ?? null;
        $empId    = optional($authUser->employee)->Emp_ID ?? null;
        $isAdmin = $role === 'Administrator';
        $owns = fn($plan) => (int)optional($plan->employee)->Emp_ID === (int)$empId;
        $canSee = fn($plan) => $isAdmin || $owns($plan);
        $exportScope = $isAdmin ? 'all' : 'mine';
    @endphp

   <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" style="position: relative; z-index: 1;">

        <div class="slt-card mb-4">
            <form method="GET" action="{{ route('my-work.weekly.report') }}" class="slt-filter">
                <div>
                    <label class="slt-label">Select Week</label>
                    <select name="range" class="slt-select" required>
                        <option value="">-- Choose week --</option>
                        @foreach($weeks as $w)
                            @php
                                $start = \Carbon\Carbon::parse($w->start_date);
                                $end   = \Carbon\Carbon::parse($w->end_date);
                                $v     = $start->format('Y-m-d').'|'.$end->format('Y-m-d');
                                $label = $start->format('d/m/Y').' - '.$end->format('d/m/Y');
                            @endphp
                            <option value="{{ $v }}" @selected(($selected ?? '') === $v)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="slt-filter-actions">
                    <button class="slt-btn slt-btn-primary" type="submit"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="11" cy="11" r="8"></circle><path d="m21 21-4.35-4.35"/></svg>Show</button>
                    @if(!empty($selected))
                        <a class="slt-btn slt-btn-outline" href="{{ route('my-work.weekly.report.export', ['range' => $selected, 'scope' => $exportScope]) }}"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>Export Excel</a>
                    @endif
                    <a class="slt-btn slt-btn-outline" href="{{ route('my-work.weekly.update') }}"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>Back</a>
                </div>
            </form>
        </div>
        <div class="slt-card">
            <div class="slt-table-wrap">
                <table class="slt-table" id="reportTable">
                    <thead>
                        <tr>
                            <th>Week</th><th>Employee Name</th><th>External Platform/Solution</th><th>Internal Platform/Solution</th><th>Work Plan Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $shown = 0; @endphp
                        @forelse($plans as $p)
                            @continue(!$canSee($p))
                            @php
                                $shown++;
                                $weekLabel = \Carbon\Carbon::parse($p->start_date)->format('d/m/Y').' - '.\Carbon\Carbon::parse($p->end_date)->format('d/m/Y');
                                $empName = optional($p->employee)->Emp_Name ?? optional($p->employee)->Emp_Email ?? $p->updated_by;
                                $extText = $p->externalPlatforms->pluck('platform_name')->implode(', ') ?: '—';
                                $intText = $p->internalPlatforms->pluck('App_Name')->implode(', ') ?: '—';
                            @endphp
                            <tr>
                                <td>{{ $weekLabel }}</td><td>{{ $empName }}</td><td>{{ $extText }}</td><td>{{ $intText }}</td><td style="white-space:pre-wrap">{{ $p->workplan_desc }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="slt-empty" style="background: white; color: #6b7a8a;">📊 Select a week and press <b>Show</b> to view data.</td></tr>
                        @endforelse
                        @if($plans->count() && !$shown && !empty($selected))
                            <tr><td colspan="5" class="slt-empty" style="background: white; color: #6b7a8a;">🔒 No results visible for your account.</td></tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection