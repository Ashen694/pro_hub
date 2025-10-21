@extends('layouts.app')
@section('page-title','Fields Of Specializations')
@section('content')
<style>
    .fos-table thead th { color:#fff !important; background:transparent !important; }
    .fos-table tbody td { color:#fff !important; }
    .fos-table { background: transparent; }
    .link-details { color: #0dcaf0; }
</style>
<div class="container">
    <div class="row mb-2">
        <div class="col-6">
            <a href="{{ route('reference-data.fields-of-specializations.create') }}">Create New</a>
        </div>
        <div class="col-6 text-end">
            <!-- reserved for future filters -->
        </div>
    </div>

    <table class="table table-bordered fos-table">
        <thead>
        <tr>
            <th>Field Of Specialization</th>
            <th>Description</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @forelse($items as $i)
            <tr>
                <td style="text-transform:uppercase;">{{ $i->name }}</td>
                <td>{{ $i->notes }}</td>
                <td>
                    <a href="{{ route('reference-data.fields-of-specializations.edit', $i) }}">Edit</a> |
                    <a href="{{ route('reference-data.fields-of-specializations.show', $i) }}" class="link-details">Details</a> |
                    <form action="{{ route('reference-data.fields-of-specializations.destroy', $i) }}" method="POST" style="display:inline" onsubmit="return confirm('Are you sure you want to delete this field of specialization?');">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-link p-0 text-danger">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="3">No items</td></tr>
        @endforelse
        </tbody>
    </table>

    <div class="d-flex justify-content-between">
        <div>
            Showing {{ $items->firstItem() ?? 0 }} to {{ $items->lastItem() ?? 0 }} of {{ $items->total() }} entries
        </div>
        <div>
            {{ $items->links() }}
        </div>
    </div>
</div>
@endsection
