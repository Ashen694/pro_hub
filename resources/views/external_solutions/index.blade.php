@extends('layouts.app')

@section('page-title', $title)

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title mb-0">{{ $title }}</h3>
    <a href="{{ route('external-solutions.create', ['status' => $status]) }}" class="btn btn-primary">Create New</a>
    </div>

    <!-- Filter Section -->
    <div class="card-body border-bottom py-3">
        <div class="d-flex align-items-center">
            {{-- Filter / Tabs --}}
            <div>
                @if($status == 'operational')
                    <a href="{{ route('external-solutions.index', ['status' => 'operational']) }}" class="btn btn-primary">Operational</a>
                @elseif($status == 'prospective')
                    <a href="{{ route('external-solutions.index', ['status' => 'prospective']) }}" class="btn btn-primary">Prospective</a>
                @endif
            </div>

            <div class="ms-auto d-flex align-items-center">
                <form method="GET" action="{{ route('external-solutions.index', ['status' => $status]) }}" class="d-flex align-items-center">
                    <label class="me-2 mb-0 text-muted">Search:</label>
                    <input type="text" name="q" value="{{ request('q') }}" class="form-control form-control-sm" style="width:180px;" aria-label="Search...">
                    <button class="btn btn-sm btn-outline-primary ms-2" type="submit">Search</button>
                </form>
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