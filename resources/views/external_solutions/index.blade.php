@extends('layouts.app')

@section('page-title', $title)

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title mb-0">{{ $title }}</h3>
        <a href="{{ route('external-solutions.create') }}" class="btn btn-primary">Create New</a>
    </div>

    <!-- Tabs and Filters -->
    <div class="card-body border-bottom py-3">
        <div class="d-flex">
            <div class="btn-group w-100">
                <a href="{{ route('external-solutions.index', ['status' => 'operational']) }}" class="btn {{ $status == 'operational' ? 'btn-primary' : '' }}">Operational</a>
                <a href="{{ route('external-solutions.index', ['status' => 'prospective']) }}" class="btn {{ $status == 'prospective' ? 'btn-primary' : '' }}">Prospective</a>
                <a href="{{ route('external-solutions.index', ['status' => 'retired']) }}" class="btn {{ $status == 'retired' ? 'btn-primary' : '' }}">Retired</a>
                <a href="{{ route('external-solutions.index', ['status' => 'abandoned']) }}" class="btn {{ $status == 'abandoned' ? 'btn-primary' : '' }}">Abandoned</a>
            </div>
        </div>
    </div>

    {{-- Dynamically Include the Correct Table Partial --}}
    @include('external_solutions.partials.' . $viewPartial)

    <!-- Pagination -->
    @if ($solutions->hasPages())
    <div class="card-footer d-flex align-items-center">
        <div class="ms-auto">
            {{ $solutions->links() }}
        </div>
    </div>
    @endif
</div>
@endsection