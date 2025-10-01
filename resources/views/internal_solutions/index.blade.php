@extends('layouts.app')

@section('page-title', $title)

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ $title }}</h3>
        {{-- Show Create New button only for certain statuses --}}
        @if($status == 'operational' || $status == 'in-progress')
            <div class="card-options">
                <a href="{{ route('internal-solutions.create') }}" class="btn btn-primary">Create New</a>
            </div>
        @endif
    </div>
    
    <!-- Filter Section -->
        <div class="card-body border-bottom py-3">

            {{-- Show special filters ONLY for in-progress/recently-launched pages --}}
            @if($status == 'in-progress' || $status == 'recently-launched')
            <div class="d-flex mb-3">
                <div class="btn-group" role="group">
                    <a href="#" class="btn btn-primary">Level 1</a>
                    <a href="#" class="btn">Others</a>
                </div>
            </div>
            @endif

            <div class="d-flex align-items-center">
                <div class="text-muted">
                    Show
                    <div class="mx-2 d-inline-block">
                        <input type="text" class="form-control form-control-sm" value="10" size="3">
                    </div>
                    entries
                </div>

                {{-- Show Abandoned/Retired filters ONLY for their pages --}}
                @if($status == 'retired' || $status == 'abandoned')
                <div class="ms-auto d-flex">
                    <div class="btn-group" role="group">
                        <a href="{{ route('internal-solutions.index', ['status' => 'abandoned']) }}" 
                        class="btn {{ $status == 'abandoned' ? 'btn-primary' : '' }}">Abandoned</a>
                        <a href="{{ route('internal-solutions.index', ['status' => 'retired']) }}" 
                        class="btn {{ $status == 'retired' ? 'btn-primary' : '' }}">Retired</a>
                    </div>
                </div>
                @endif

                <div class="ms-auto text-muted">
                    Search:
                    <div class="ms-2 d-inline-block">
                        <input type="text" class="form-control form-control-sm">
                    </div>
                </div>
            </div>
        </div>


    {{-- Dynamically Include the Correct Table Partial --}}
    @include('internal_solutions.partials.' . $viewPartial)



<!-- Pagination and Footer -->
    <div class="card-footer d-flex align-items-center">
        {{-- Show Export button for multiple statuses --}}
        @if(in_array($status, ['retired', 'abandoned', 'in-progress', 'recently-launched']))
            <a href="#" class="btn btn-outline-primary">Export All Details to Excel</a>
        @endif

        <div class="ms-auto">
            {{ $solutions->links() }}
        </div>
    </div>
</div>
@endsection