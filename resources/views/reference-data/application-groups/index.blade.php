@extends('layouts.app')

@push('styles')
<style>
    .ag-content-wrapper {
        background-color: #ffffff;
        border: 1px solid #e0e0e0;
        padding: 24px;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }

    .ag-content-wrapper h1, 
    .ag-content-wrapper label, 
    .ag-content-wrapper p, 
    .ag-content-wrapper th, 
    .ag-content-wrapper td {
        color: #212529 !important;
    }

    .ag-content-wrapper .table {
        --bs-table-bg: #ffffff;
        --bs-table-striped-color: #212529;
        --bs-table-striped-bg: #f8f9fa;
        --bs-table-hover-color: #212529;
        --bs-table-hover-bg: #f1f3f5;
        color: #212529;
    }

    .ag-content-wrapper .page-link {
        background-color: #ffffff !important;
        border-color: #dee2e6 !important;
        color: #0057FF !important;
    }
    .ag-content-wrapper .page-item.active .page-link {
        background-color: #0057FF !important;
        border-color: #0057FF !important;
        color: #ffffff !important;
    }

    .action-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        border-radius: 8px;
        text-decoration: none !important;
        text-decoration: none;
        transition: all 0.2s ease-in-out;
        border: none;
    }
    .action-btn i {
        font-size: 16px;
    }
    .action-btn-edit {
        background-color: #e6f0ff;
    }
    .action-btn-edit i {
        color: #0057ff;
    }
    .action-btn-edit:hover {
        background-color: #cce0ff;
    }
    .action-btn-view {
        background-color: #e3f9e5;
    }
    .action-btn-view i {
        color: #28a745;
    }
    .action-btn-view:hover {
        background-color: #c1f2c6;
    }
    .action-btn-delete {
        background-color: #ffe6e6;
        cursor: pointer;
    }
    .action-btn-delete i {
        color: #dc3545;
    }
    .action-btn-delete:hover {
        background-color: #ffcccc;
    }
    .action-btn:hover {
    text-decoration: none !important;  
    }
</style>
@endpush

@section('page-title', 'Application Groups')

@section('content')
<div class="container">
    <div class="ag-content-wrapper">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Application Groups</h1>
            <a href="{{ route('reference-data.application-groups.create') }}" class="btn btn-primary">Create New</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th>Application Group</th>
                    <th>Description</th>
                    <th class="text-center">Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse($groups as $g)
                    <tr>
                        <td style="text-transform:uppercase;">{{ $g->name }}</td>
                        <td>{{ $g->description }}</td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('reference-data.application-groups.show', $g) }}" class="action-btn action-btn-view" title="Details">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('reference-data.application-groups.edit', $g) }}" class="action-btn action-btn-edit" title="Edit">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                                <form action="{{ route('reference-data.application-groups.destroy', $g) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this group?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-btn action-btn-delete" title="Delete">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center">No groups found.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        @if ($groups->hasPages())
            <div class="mt-3">
                {{ $groups->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
