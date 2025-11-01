@extends('layouts.app')

@section('title', 'Create Weekly Plan')
@section('page-title', 'Add – Next Week Plan')

@push('styles')
    @vite(['resources/css/weekly-create.css'])
    {{-- No extra styles are needed here --}}
@endpush

@push('scripts')
    @vite(['resources/js/weekly-create.js'])
@endpush

@section('content')
    <div class="slt-form-card">

        @if ($errors->any())
            <div class="slt-alert slt-alert-error">
                <strong>Fix the following:</strong>
                <ul class="slt-alert-list">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </div>
        @endif
        @if (session('ok'))<div class="slt-alert slt-alert-ok">{{ session('ok') }}</div>@endif

        <form method="POST" action="{{ route('my-work.weekly.store') }}" class="space-y-5">
            @csrf
            <div>
                <label class="slt-label block mb-2">Week Period</label>
                <div class="slt-week-lock"><div class="slt-week-chip"><input type="text" name="week_start" value="{{ $week_start }}" readonly class="slt-week-input"><span class="slt-week-arrow">→</span><input type="text" name="week_end" value="{{ $week_end }}" readonly class="slt-week-input"></div></div>
            </div>
            <div>
                <label class="slt-label block mb-2">External Platform/Solution</label>
                <div class="slt-dd" data-dd="ext">
                    <button class="slt-dd__btn" type="button"><span style="color:#6b7280">Choose external solutions</span><svg class="slt-dd__caret" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#2258a7" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg></button>
                    <div id="ext-panel" class="slt-dd__panel">
                        @foreach($externalOptions as $opt)
                            <label class="slt-dd__row"><input class="slt-check" type="checkbox" name="external_platform_id[]" value="{{ $opt->platform_id }}" data-name="{{ $opt->platform_name }}" @checked(in_array($opt->platform_id, (array)old('external_platform_id',[])))><span class="slt-dd__name">{{ $opt->platform_name }}</span></label>
                        @endforeach
                    </div>
                    <small class="slt-dd__hint">Tick one or more external platforms.</small>
                </div>
                @error('external_platform_id')<div class="slt-error">{{ $message }}</div>@enderror
            </div>
            <div>
                <label class="slt-label block mb-2">Internal Platform/Solution</label>
                <div class="slt-dd" data-dd="int">
                     <button class="slt-dd__btn" type="button"><span style="color:#6b7280">Choose internal apps</span><svg class="slt-dd__caret" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#2258a7" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg></button>
                    <div id="int-panel" class="slt-dd__panel">
                        @foreach($internalOptions as $opt)
                            <label class="slt-dd__row"><input class="slt-check" type="checkbox" name="internal_platform_id[]" value="{{ $opt->ID }}" data-name="{{ $opt->App_Name }}" @checked(in_array($opt->ID, (array)old('internal_platform_id',[])))><span class="slt-dd__name">{{ $opt->App_Name }}</span></label>
                        @endforeach
                    </div>
                    <small class="slt-dd__hint">Tick one or more internal platforms.</small>
                </div>
                @error('internal_platform_id')<div class="slt-error">{{ $message }}</div>@enderror
            </div>
            <div>
                <label class="slt-label block mb-2" for="details">Work Plan Details</label>
                <textarea name="details" id="details" rows="5" class="slt-textarea @error('details') is-invalid @enderror" placeholder="Describe your work plan..." required>{{ old('details') }}</textarea>
                <small class="slt-dd__hint">Tip: selecting platforms will auto-add line items here.</small>
                @error('details')<div class="slt-error">{{ $message }}</div>@enderror
            </div>
            <div>
                <label class="slt-label block mb-2">Updated By</label>
                <div class="slt-user-badge">{{ auth()->user()->name ?? auth()->user()->email }}</div>
            </div>
            <div class="slt-btn-group flex gap-2 pt-2">
                <button type="submit" class="slt-btn slt-btn-primary">Create Plan</button>
                <a href="{{ route('my-work.weekly.update') }}" class="slt-btn slt-btn-secondary">Back to List</a>
            </div>
        </form>
    </div>
@endsection