@extends('layouts.app')

@section('page-title', $title)

@push('styles')
<style>
    /* Centering for action buttons */
    .btn-icon-sm {
        width: 2rem;
        height: 2rem;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0;
    }
    /* Styles for the new details modal */
    .modal-details .detail-item {
        margin-bottom: 1rem;
    }
    .modal-details .detail-label {
        color: #626976;
        font-weight: 600;
        display: flex;
        align-items: center;
        font-size: 0.8rem;
    }
    .modal-details .detail-label .icon {
        margin-right: 8px;
    }
    .modal-details .detail-value {
        font-weight: 500;
        word-break: break-all;
    }
    .modal-details .hr-text {
        margin-top: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .btn-action {
        width: 36px;
        height: 36px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        border: none;
        transition: all 0.2s ease-in-out;
    }

    .btn-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }
    
    /* View Button (Blue) */
    .btn-action-view {
        background-color: #e7f5ff;  
        color: #1c7ed6;             
    }
    .btn-action-view:hover {
        background-color: #d0ebff;
        color: #1971c2;
    }

    /* Edit Button (Green) */
    .btn-action-edit {
        background-color: #e6fcf5;  
        color: #2f9e44;            
    }
    .btn-action-edit:hover {
        background-color: #c3fae8;
        color: #2b8a3e;
    }

    /* Delete Button (Red) */
    .btn-action-delete {
        background-color: #fff5f5;  
        color: #e03131;             
    }
    .btn-action-delete:hover {
        background-color: #ffc9c9;
        color: #c92a2a;
    }

    /* Documents Button (Gray) */
    .btn-action-docs {
        background-color: #f8f9fa;  
        color: #868e96;            
    }
    .btn-action-docs:hover {
        background-color: #e9ecef;
        color: #495057;
    }

    /* Change Request Button (Orange) */
    .btn-action-cr {
        background-color: #fff4e6;  
        color: #f76707;            
    }
    .btn-action-cr:hover {
        background-color: #ffe8cc;
        color: #d9480f;
    }    

</style>
@endpush

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