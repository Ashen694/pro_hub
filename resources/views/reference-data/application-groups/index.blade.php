@extends('layouts.app')
@section('page-title','Application Groups')
@section('content')
<style>
    .ag-table thead th { color:#fff !important; background:transparent !important; }
    .ag-table tbody td { color:#fff !important; }
    .ag-table { background: transparent; }
    .link-details { color: #0dcaf0; } /* bootstrap info color */
</style>
<div class="container">
    <div class="row mb-2">
        <div class="col-6">
            <a href="{{ route('reference-data.application-groups.create') }}">Create New</a>
        </div>
        <div class="col-6 text-end">
            <!-- reserved for future filters to match layout -->
        </div>
    </div>

    <table class="table table-bordered ag-table">
        <thead>
        <tr>
            <th>Application Group</th>
            <th>Description</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @forelse($groups as $g)
            <tr>
                <td style="text-transform:uppercase;">{{ $g->name }}</td>
                <td>{{ $g->description }}</td>
                <td>
                    <a href="{{ route('reference-data.application-groups.edit', $g) }}">Edit</a> |
                    <a href="{{ route('reference-data.application-groups.show', $g) }}" class="link-details">Details</a> |
                    <form action="{{ route('reference-data.application-groups.destroy', $g) }}" method="POST" style="display:inline" onsubmit="return confirm('Are you sure you want to delete this group?');">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-link p-0 text-danger">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="3">No groups</td></tr>
        @endforelse
        </tbody>
    </table>

    <div class="d-flex justify-content-between">
        <div>
            Showing {{ $groups->firstItem() ?? 0 }} to {{ $groups->lastItem() ?? 0 }} of {{ $groups->total() }} entries
        </div>
        <div>
            {{ $groups->links() }}
        </div>
    </div>
</div>
@endsection
