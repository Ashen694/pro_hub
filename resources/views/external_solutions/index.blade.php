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