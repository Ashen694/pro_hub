@extends('layouts.app')

@section('page-title', $title)

@section('content')

{{-- 
    NOTE: The success/error alert messages are now handled inside the Livewire component 
    (resources/views/livewire/internal-solutions-table.blade.php).
    So, they are no longer needed here. This keeps the main layout cleaner.
--}}

<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ $title }}</h3>
        
        {{-- For operational, in-progress, and recently-launched pages --}}
        @if($status == 'operational' || $status == 'in-progress' || $status == 'recently-launched')
            <div class="card-options">
                <a href="{{ route('internal-solutions.create') }}" class="btn btn-primary">Create New</a>
            </div>
        @endif
        
        {{-- For retired and abandoned pages --}}
        @if($status == 'retired' || $status == 'abandoned')
            <div class="card-options">
                <div class="btn-group" role="group">
                    {{-- Removed btn-sm class to make buttons larger --}}
                    <a href="{{ route('internal-solutions.index', ['status' => 'abandoned']) }}" 
                       class="btn {{ $status == 'abandoned' ? 'btn-primary' : 'btn-outline-secondary' }}">Abandoned</a>
                    <a href="{{ route('internal-solutions.index', ['status' => 'retired']) }}" 
                       class="btn {{ $status == 'retired' ? 'btn-primary' : 'btn-outline-secondary' }}">Retired</a>
                </div>
            </div>
        @endif
    </div>

    {{-- The Livewire component is loaded here, which contains the alerts, filters, and table --}}
    @livewire('internal-solutions-table', ['status' => $status])
    
</div>
@endsection

@push('scripts')
<script>
    // This script re-initializes Bootstrap tooltips after Livewire updates the page.
    // It's important for the action button tooltips to work correctly after sorting/filtering.
    document.addEventListener('livewire:navigated', () => {
         var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
         var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) { return new bootstrap.Tooltip(tooltipTriggerEl) });
    });
</script>
@endpush