@extends('layouts.app')

@section('page-title', $title)

@section('content')

{{-- Session messages with the new 'alert-auto-dismiss' class --}}
@if (session('success'))
    <div class="alert alert-success alert-dismissible alert-auto-dismiss" role="alert">
        <div class="d-flex">
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M5 12l5 5l10 -10"></path></svg>
            </div>
            <div>
                <h4 class="alert-title">Success!</h4>
                <div class="text-muted">{{ session('success') }}</div>
            </div>
        </div>
        <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger alert-dismissible alert-auto-dismiss" role="alert">
        <div class="d-flex">
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M12 9v2m0 4v.01"></path><path d="M5 19h14a2 2 0 0 0 1.84 -2.75l-7.1 -12.25a2 2 0 0 0 -3.5 0l-7.1 12.25a2 2 0 0 0 1.75 2.75"></path></svg>
            </div>
            <div>
                <h4 class="alert-title">Error!</h4>
                <div class="text-muted">{{ session('error') }}</div>
            </div>
        </div>
        <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
    </div>
@endif

<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ $title }}</h3>
        
        @if($status == 'operational' || $status == 'in-progress')
            <div class="card-options">
                <a href="{{ route('internal-solutions.create') }}" class="btn btn-primary">Create New</a>
            </div>
        @endif
        
        @if($status == 'retired' || $status == 'abandoned')
            <div class="card-options">
                <div class="btn-group" role="group">
                    <a href="{{ route('internal-solutions.index', ['status' => 'abandoned']) }}" 
                       class="btn btn-sm {{ $status == 'abandoned' ? 'btn-primary' : 'btn-outline-secondary' }}">Abandoned</a>
                    <a href="{{ route('internal-solutions.index', ['status' => 'retired']) }}" 
                       class="btn btn-sm {{ $status == 'retired' ? 'btn-primary' : 'btn-outline-secondary' }}">Retired</a>
                </div>
            </div>
        @endif
    </div>

    @include('internal_solutions.partials.' . $viewPartial)

    <div class="card-footer d-flex align-items-center">
        @if(in_array($status, ['retired', 'abandoned', 'in-progress', 'recently-launched', 'operational']))
            <a href="#" class="btn btn-outline-primary">Export All Details to Excel</a>
        @endif

        <div class="ms-auto">
            {{ $solutions->links() }}
        </div>
    </div>
</div>
@endsection

{{-- New JavaScript section to automatically dismiss alerts --}}
@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const autoDismissAlerts = document.querySelectorAll('.alert-auto-dismiss');

        autoDismissAlerts.forEach(function(alertElement) {
            setTimeout(function() {
                const bsAlert = new bootstrap.Alert(alertElement);
                bsAlert.close();
            }, 3000); // The alert will disappear after 3 seconds
        });
    });
</script>
@endpush