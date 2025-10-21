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

    </div>

    {{-- The Livewire component is loaded here, which contains the alerts, filters, and table --}}
    @livewire('internal-solutions-table', ['status' => $status])
    
</div>
@endsection

@push('scripts')
<script>
      document.addEventListener('livewire:navigated', () => {
         var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
         var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) { return new bootstrap.Tooltip(tooltipTriggerEl) });
    });
</script>
@endpush