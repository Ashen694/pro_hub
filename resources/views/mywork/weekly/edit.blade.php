@extends('layouts.app')

@section('title', 'Edit Weekly Plan')
@section('page-title', 'Edit – Weekly Plan')

@push('styles')
    @vite(['resources/css/weekly-edit.css'])
    <style>
        /* Keep page body padding sane and visible on all viewports */
        .page-body { padding: 1rem !important; }

        /* Make the card responsive even if Tailwind isn’t active */
        .slt-container { width: 100%; margin-left: auto; margin-right: auto; }
        .slt-form-card {
            background: #fff; border-radius: 12px; border: 1px solid #e5e7eb;
            box-shadow: 0 2px 12px rgba(0,0,0,.05);
        }
        .slt-label { font-weight: 600; color: #0f172a; }
        .slt-textarea, .slt-multi-btn {
            width: 100%;
        }
        .slt-check {
            width: 1.25rem; 
            height: 1.25rem; 
            cursor: pointer;
            flex-shrink: 0;  
        }
        .slt-textarea {
            min-height: 140px; border: 1px solid #cbd5e1; border-radius: 8px; padding: .75rem;
        }
        .slt-btn-group { display: flex; gap: .5rem; flex-wrap: wrap; }
        .slt-btn { appearance: none; border-radius: 10px; padding: .6rem .95rem; font-weight: 600; cursor: pointer; }
        .slt-btn-primary { background: #2258a7; color: #fff; border: 1px solid #1d4f97; }
        .slt-btn-secondary { background: #f1f5f9; color: #0f172a; border: 1px solid #e2e8f0; }
        .slt-alert { border-radius: 10px; padding: .75rem 1rem; margin-bottom: 1rem; }
        .slt-alert-error { background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; }
        .slt-alert-ok { background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; }
        .slt-alert-list { margin: .25rem 0 0 1rem; }
        .slt-error { color: #b91c1c; font-size: .9rem; margin-top: .25rem; }
        .slt-week-lock { display: flex; align-items: center; gap: .5rem; flex-wrap: wrap; }
        .slt-week-chip {
            display: inline-flex; align-items: center; gap: .5rem; padding: .5rem .75rem;
            border-radius: 9999px; background: #eef2ff; color: #1e3a8a; border: 1px solid #c7d2fe;
        }
        .slt-week-arrow { opacity: .7; }
        .slt-tagline { display: block; color: #64748b; margin-top: .375rem; }
        .slt-user-badge { display: inline-flex; gap: .5rem; align-items: center; padding: .35rem .6rem; border-radius: 9999px; background: #eff6ff; color: #1d4ed8; }
        .slt-multi { position: relative; }
        .slt-multi-btn {
            display: inline-flex; justify-content: space-between; align-items: center; gap: .5rem;
            background: #fff; border: 1px solid #cbd5e1; padding: .6rem .8rem; border-radius: 10px;
        }
        .slt-panel {
            position: relative; margin-top: .5rem; border: 1px solid #e2e8f0; border-radius: 12px;
            padding: .5rem; background: #fff; max-height: 240px; overflow: auto;
        }
        .slt-row { display: flex; gap: .5rem; align-items: center; padding: .35rem .35rem; border-radius: 8px; }
        .slt-row:hover { background: #f8fafc; }
        .slt-name { flex: 1; }
        /* Helpers if Tailwind not present */
        .py-6 { padding-top: 1.5rem; padding-bottom: 1.5rem; }
        .p-6 { padding: 1.5rem; }
        .space-y-5 > * + * { margin-top: 1.25rem; }
        .max-w-4xl { max-width: 56rem; }
        .mx-auto { margin-left: auto; margin-right: auto; }
        .px-4 { padding-left: 1rem; padding-right: 1rem; }
        @media (min-width: 640px){ .sm\:px-6 { padding-left: 1.5rem; padding-right: 1.5rem; } }
        @media (min-width: 1024px){ .lg\:px-8 { padding-left: 2rem; padding-right: 2rem; } }
    </style>
@endpush

@push('scripts')
    @vite(['resources/js/weekly-edit.js'])
@endpush

@section('content')
    <div class="slt-container py-6 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="slt-form-card p-6">
            {{-- Validation errors --}}
            @if ($errors->any())
                <div class="slt-alert slt-alert-error" role="alert" aria-live="assertive">
                    <strong>Fix the following:</strong>
                    <ul class="slt-alert-list">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Flash OK --}}
            @if (session('ok'))
                <div class="slt-alert slt-alert-ok" role="status" aria-live="polite">
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

                {{-- Week period (locked) --}}
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

                {{-- External platforms --}}
                @php
                    $oldExt = (array) old('external_platform_id', $plan->externalPlatforms->pluck('platform_id')->all());
                @endphp
                <div>
                    <label class="slt-label block mb-2">External Platform/Solution</label>
                    <div class="slt-multi" data-multi="external">
                        <button class="slt-multi-btn" type="button" aria-haspopup="listbox" aria-expanded="true">
                            <span data-label>
                                @if (count($oldExt))
                                    {{ implode(', ', $externalOptions->whereIn('platform_id', $oldExt)->pluck('platform_name')->all()) }}
                                @else
                                    — Select External —
                                @endif
                            </span>
                            <svg class="slt-caret" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#2258a7" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
                        </button>
                        <div class="slt-panel" role="listbox" aria-multiselectable="true">
                            @foreach($externalOptions as $opt)
                                <label class="slt-row">
                                    <input class="slt-check" type="checkbox" name="external_platform_id[]" value="{{ $opt->platform_id }}" data-name="{{ $opt->platform_name }}" @checked(in_array($opt->platform_id, $oldExt))>
                                    <span class="slt-name">{{ $opt->platform_name }}</span>
                                </label>
                            @endforeach
                        </div>
                        <small class="slt-tagline">Tick one or more external platforms.</small>
                    </div>
                    @error('external_platform_id')<div class="slt-error">{{ $message }}</div>@enderror
                </div>

                {{-- Internal platforms --}}
                @php
                    $oldInt = (array) old('internal_platform_id', $plan->internalPlatforms->pluck('ID')->all());
                @endphp
                <div>
                    <label class="slt-label block mb-2">Internal Platform/Solution</label>
                    <div class="slt-multi" data-multi="internal">
                        <button class="slt-multi-btn" type="button" aria-haspopup="listbox" aria-expanded="true">
                            <span data-label>
                                @if (count($oldInt))
                                    {{ implode(', ', $internalOptions->whereIn('ID', $oldInt)->pluck('App_Name')->all()) }}
                                @else
                                    — Select Internal —
                                @endif
                            </span>
                            <svg class="slt-caret" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#2258a7" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
                        </button>
                        <div class="slt-panel" role="listbox" aria-multiselectable="true">
                            @foreach($internalOptions as $opt)
                                <label class="slt-row">
                                    <input class="slt-check" type="checkbox" name="internal_platform_id[]" value="{{ $opt->ID }}" data-name="{{ $opt->App_Name }}" @checked(in_array($opt->ID, $oldInt))>
                                    <span class="slt-name">{{ $opt->App_Name }}</span>
                                </label>
                            @endforeach
                        </div>
                        <small class="slt-tagline">Tick one or more internal platforms.</small>
                    </div>
                    @error('internal_platform_id')<div class="slt-error">{{ $message }}</div>@enderror
                </div>

                {{-- Work plan details --}}
                <div>
                    <label for="details" class="slt-label block mb-2">Work Plan Details</label>
                    <textarea name="details" id="details" rows="5" class="slt-textarea @error('details') is-invalid @enderror" placeholder="Describe your work plan..." required>{{ old('details', $plan->workplan_desc) }}</textarea>
                    <small class="slt-tagline">Tip: selecting platforms will auto-add line items here.</small>
                    @error('details')<div class="slt-error">{{ $message }}</div>@enderror
                </div>

                {{-- Updated by --}}
                <div>
                    <label class="slt-label block mb-2">Updated By</label>
                    <div class="slt-user-badge">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <circle cx="12" cy="7" r="4" stroke="#2258a7" stroke-width="2"></circle>
                            <path d="M4 20c1.8-3.2 5-5 8-5s6.2 1.8 8 5" stroke="#46b6ef" stroke-width="2"></path>
                        </svg>
                        {{ auth()->check() ? (auth()->user()->name ?? auth()->user()->email) : 'Unknown User' }}
                    </div>
                </div>

                {{-- Actions --}}
                <div class="slt-btn-group pt-2">
                    <button class="slt-btn slt-btn-primary" type="submit">Save Changes</button>
                    <a href="{{ route('my-work.weekly.update') }}" class="slt-btn slt-btn-secondary">Back to List</a>
                </div>
            </form>
        </div>
    </div>
@endsection
