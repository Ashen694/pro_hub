@extends('layouts.app')

@section('title', 'Edit Weekly Plan')
@section('page-title', 'Edit – Weekly Plan')

@push('styles')
    @vite(['resources/css/weekly-edit.css'])
    <style>
        /* .page-header { display: none !important; } */
        
        /* We keep this rule to make the content area look correct */
        .page-body { padding: 0 !important; }
    </style>
@endpush

@push('scripts')
    @vite(['resources/js/weekly-edit.js'])
@endpush

@section('content')
    <div class="slt-container py-6 max-w-3xl mx-auto sm:px-6 lg:px-8" style="position: relative; z-index: 1; padding: 1.5rem 0.75rem;">        
        <div class="slt-form-card p-6">
            @if ($errors->any())
                <div class="slt-alert slt-alert-error">
                    <strong>Fix the following:</strong>
                    <ul class="slt-alert-list">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                </div>
            @endif

            @if (session('ok'))
                <div class="slt-alert slt-alert-ok">
                    {{ session('ok') }}
                </div>
            @endif

            <form method="POST" action="{{ route('my-work.weekly.update.save', $plan) }}" class="space-y-5">
                @csrf
                @method('PUT')

                @php
                    $start = \Illuminate\Support\Carbon::parse($plan->start_date);
                    $end   = \Illuminate\Support\Carbon::parse($plan->end_date);
                @endphp
                <div>
                    <label class="slt-label block mb-2">Week Period</label>
                    <div class="slt-week-lock" aria-live="polite">
                        <div class="slt-week-chip" aria-readonly="true">
                            <span class="slt-week-text" id="weekStartText">{{ $start->format('d/m/Y') }}</span>
                            <span class="slt-week-arrow">→</span>
                            <span class="slt-week-text" id="weekEndText">{{ $end->format('d/m/Y') }}</span>
                        </div>
                        <input type="hidden" name="week_start" id="week_start" value="{{ $start->format('Y-m-d') }}">
                        <input type="hidden" name="week_end"   id="week_end"   value="{{ $end->format('Y-m-d') }}">
                    </div>
                    @error('week_start')<div class="slt-error">{{ $message }}</div>@enderror
                    @error('week_end')  <div class="slt-error">{{ $message }}</div>@enderror
                </div>

                @php $oldExt = (array) old('external_platform_id', $plan->externalPlatforms->pluck('platform_id')->all()); @endphp
                <div>
                    <label class="slt-label block mb-2">External Platform/Solution</label>
                    <div class="slt-multi" data-multi="external">
                        <button class="slt-multi-btn" type="button" aria-haspopup="listbox" aria-expanded="false">
                            <span data-label>— Select External —</span>
                            <svg class="slt-caret" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#2258a7" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
                        </button>
                        <div class="slt-panel" role="listbox">
                            @foreach($externalOptions as $opt)
                                <label class="slt-row"><input class="slt-check" type="checkbox" name="external_platform_id[]" value="{{ $opt->platform_id }}" data-name="{{ $opt->platform_name }}" @checked(in_array($opt->platform_id, $oldExt))><span class="slt-name">{{ $opt->platform_name }}</span></label>
                            @endforeach
                        </div>
                        <small class="slt-tagline">Tick one or more external platforms.</small>
                    </div>
                    @error('external_platform_id')<div class="slt-error">{{ $message }}</div>@enderror
                </div>

                @php $oldInt = (array) old('internal_platform_id', $plan->internalPlatforms->pluck('ID')->all()); @endphp
                <div>
                    <label class="slt-label block mb-2">Internal Platform/Solution</label>
                    <div class="slt-multi" data-multi="internal">
                        <button class="slt-multi-btn" type="button" aria-haspopup="listbox" aria-expanded="false">
                            <span data-label>— Select Internal —</span>
                            <svg class="slt-caret" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#2258a7" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
                        </button>
                        <div class="slt-panel" role="listbox">
                            @foreach($internalOptions as $opt)
                                <label class="slt-row"><input class="slt-check" type="checkbox" name="internal_platform_id[]" value="{{ $opt->ID }}" data-name="{{ $opt->App_Name }}" @checked(in_array($opt->ID, $oldInt))><span class="slt-name">{{ $opt->App_Name }}</span></label>
                            @endforeach
                        </div>
                        <small class="slt-tagline">Tick one or more internal platforms.</small>
                    </div>
                    @error('internal_platform_id')<div class="slt-error">{{ $message }}</div>@enderror
                </div>

                <div>
                    <label for="details" class="slt-label block mb-2">Work Plan Details</label>
                    <textarea name="details" id="details" rows="5" class="slt-textarea @error('details') is-invalid @enderror" placeholder="Describe your work plan..." required>{{ old('details', $plan->workplan_desc) }}</textarea>
                    <small class="slt-tagline">Tip: selecting platforms will auto-add line items here.</small>
                    @error('details')<div class="slt-error">{{ $message }}</div>@enderror
                </div>

                <div>
                    <label class="slt-label block mb-2">Updated By</label>
                    <div class="slt-user-badge"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden="true"><circle cx="12" cy="7" r="4" stroke="#2258a7" stroke-width="2"></circle><path d="M4 20c1.8-3.2 5-5 8-5s6.2 1.8 8 5" stroke="#46b6ef" stroke-width="2"></path></svg>{{ auth()->user()->name ?? auth()->user()->email }}</div>
                </div>

                <div class="slt-btn-group flex gap-2 pt-2">
                    <button class="slt-btn slt-btn-primary" type="submit">Save Changes</button>
                    <a href="{{ route('my-work.weekly.update') }}" class="slt-btn slt-btn-secondary">Back to List</a>
                </div>
            </form>
        </div>
    </div>
@endsection