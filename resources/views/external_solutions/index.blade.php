@extends('layouts.app')

@section('page-title', $title)

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title mb-0">{{ $title }}</h3>
        <a href="{{ route('external-solutions.create') }}" class="btn btn-primary">Create New</a>
    </div>
    
    <!-- Filter Section -->
    <div class="card-body border-bottom py-3">
        <div class="d-flex align-items-center">
            
            {{-- Show different filter TABS based on the page --}}
            @if($status == 'operational')
                <div class="btn-group" role="group">
                     <a href="{{ route('external-solutions.index', ['status' => 'operational']) }}" class="btn btn-primary">Operational</a>
                </div>
            @elseif($status == 'prospective')
                 <div class="btn-group" role="group">
                     <a href="{{ route('external-solutions.index', ['status' => 'prospective']) }}" class="btn btn-primary">Prospective</a>
                     <a href="#" class="btn">In-Progress</a> {{-- Link this to the correct route later --}}
                </div>
            @endif

            <div class="ms-auto text-muted">
                Search:
                <div class="ms-2 d-inline-block">
                    <input type="text" class="form-control form-control-sm" aria-label="Search...">
                </div>
            </div>
        </div>
    </div>

    {{-- Dynamically Include the Correct Table Partial --}}
    @include('external_solutions.partials.' . $viewPartial)

    <!-- Pagination and Footer -->
    <div class="card-footer d-flex align-items-center">
        <a href="#" class="btn btn-outline-primary">Export All Details to Excel</a>
        <div class="ms-auto">
            {{ $solutions->links() }}
        </div>
    </div>
</div>
@endsection