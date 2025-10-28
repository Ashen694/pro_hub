@extends('layouts.app')

@push('styles')
<style>
    .partners-content-wrapper {
        background-color: #ffffff;
        border: 1px solid #e0e0e0;
        padding: 24px;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }
    .partners-content-wrapper h1, .partners-content-wrapper h2, .partners-content-wrapper h3, .partners-content-wrapper label, .partners-content-wrapper p, .partners-content-wrapper th, .partners-content-wrapper td {
        color: #212529 !important;
    }
    .partners-content-wrapper .table {
        --bs-table-bg: #ffffff;
        --bs-table-striped-color: #212529;
        --bs-table-striped-bg: #f8f9fa;
        --bs-table-hover-color: #212529;
        --bs-table-hover-bg: #f1f3f5;
        color: #212529;
    }
    .partners-content-wrapper .page-link {
        background-color: #ffffff !important;
        border-color: #dee2e6 !important;
        color: #0057FF !important;
    }
    .partners-content-wrapper .page-item.active .page-link {
        background-color: #0057FF !important;
        border-color: #0057FF !important;
        color: #ffffff !important;
    }

    /* --- New Styles for Action Buttons --- */
    .action-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        border-radius: 8px;
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
</style>
@endpush

@section('page-title', 'Partners')

@section('content')
<div class="partners-content-wrapper">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Partners</h1>
        <a href="{{ route('reference-data.partners.create') }}" class="btn btn-primary">Create Partner</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($partners->count())
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th>Organization Name</th>
                    <th>Contact Person</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th class="text-center">Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($partners as $partner)
                    <tr>
                        <td>{{ $partner->organization_name }}</td>
                        <td>{{ $partner->contact_person_title }} {{ $partner->contact_person_name }}</td>
                        <td>{{ $partner->contact_person_email }}</td>
                        <td>{{ $partner->contact_person_phone_1 }}</td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('reference-data.partners.show', $partner) }}" class="action-btn action-btn-view" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('reference-data.partners.edit', $partner) }}" class="action-btn action-btn-edit" title="Edit">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                                <form action="{{ route('reference-data.partners.destroy', $partner) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this partner?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-btn action-btn-delete" title="Delete">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-3">{{ $partners->links() }}</div>
    @else
        <p>No partners found.</p>
    @endif
</div>
@endsection