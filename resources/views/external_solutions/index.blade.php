@extends('layouts.app')

@section('page-title', $title)

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title mb-0">{{ $title }}</h3>

        @if(in_array($status, ['retired','abandoned']))
            <div>
                <div class="btn-group btn-group-sm" role="group" aria-label="Archive tabs">
                    <a href="{{ route('external-solutions.index', ['status' => 'abandoned']) }}" class="btn {{ $status == 'abandoned' ? 'btn-primary' : 'btn-outline-secondary' }}">Abandoned</a>
                    <a href="{{ route('external-solutions.index', ['status' => 'retired']) }}" class="btn {{ $status == 'retired' ? 'btn-primary' : 'btn-outline-secondary' }}">Retired</a>
                </div>
            </div>
        @else
            <a href="{{ route('external-solutions.create', ['status' => $status]) }}" class="btn btn-primary">Create New</a>
        @endif
    </div>

    <!-- Tabs and Filters -->
    <div class="card-body border-bottom py-3">
        <div class="row align-items-center">
            @if(in_array($status, ['retired','abandoned']))
                <div class="col-auto">
                    <label class="me-2 mb-0 text-muted">Show</label>
                    <select name="per_page" form="filters-form" class="form-select form-select-sm" style="width:100px; display:inline-block;">
                        @foreach([10,25,50,100] as $p)
                            <option value="{{ $p }}" {{ request('per_page', 50) == $p ? 'selected' : '' }}>{{ $p }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col"></div>

                <div class="col-auto">
                    <form id="filters-form" method="GET" action="{{ route('external-solutions.index', ['status' => $status]) }}" class="d-flex align-items-center">
                        <label class="me-2 mb-0 text-muted">Search:</label>
                        <input type="text" name="q" value="{{ request('q') }}" class="form-control form-control-sm" style="width:180px;" aria-label="Search...">
                        <button class="btn btn-sm btn-outline-primary ms-2" type="submit">Search</button>
                    </form>
                </div>
            @else
                <div class="col-auto">
                    <div class="btn-group" role="group" aria-label="Status tabs">
                        <a href="{{ route('external-solutions.index', ['status' => 'prospective']) }}" class="btn {{ $status == 'prospective' ? 'btn-primary' : 'btn-outline-secondary' }}">Prospective</a>
                        <a href="{{ route('external-solutions.index', ['status' => 'in-progress']) }}" class="btn {{ $status == 'in-progress' ? 'btn-primary' : 'btn-outline-secondary' }}">In-Progress</a>
                    </div>
                </div>

                <div class="col"></div>

                <div class="col-auto">
                    <form method="GET" action="{{ route('external-solutions.index', ['status' => $status]) }}" class="d-flex align-items-center">
                        <label class="me-2 mb-0 text-muted">Show</label>
                        <select name="per_page" class="form-select form-select-sm me-3" style="width:100px;">
                            @foreach([10,25,50,100] as $p)
                                <option value="{{ $p }}" {{ request('per_page', 50) == $p ? 'selected' : '' }}>{{ $p }}</option>
                            @endforeach
                        </select>

                        <label class="me-2 mb-0 text-muted">Search:</label>
                        <input type="text" name="q" value="{{ request('q') }}" class="form-control form-control-sm" style="width:180px;" aria-label="Search...">
                        <button class="btn btn-sm btn-outline-primary ms-2" type="submit">Search</button>
                    </form>
                </div>
            @endif
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