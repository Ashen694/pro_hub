@extends('layouts.app')
@section('page-title','Customer Contacts')
@section('content')
<style>
    /* Page-scoped overrides: headers and labels white to match dark theme */
    .customer-contacts-table thead th { color: #fff !important; background:transparent !important; }
    .customer-contacts-table tbody td { color: #fff !important; }
    .customer-contacts-table { background: transparent; }
</style>
<div class="container">
    <div class="row mb-2">
        <div class="col-6">
            <a href="{{ route('reference-data.customer-contacts.create') }}">Create New</a>
        </div>
        <div class="col-6 text-end">
            <form method="GET" class="d-inline-block">
                Show
                <select name="perPage" onchange="this.form.submit()">
                    <option value="10" @if(request('perPage')==10) selected @endif>10</option>
                    <option value="25" @if(request('perPage')==25) selected @endif>25</option>
                    <option value="50" @if(request('perPage')==50) selected @endif>50</option>
                </select>
                entries
            </form>
            <form method="GET" class="d-inline-block ms-3">
                <label>Search: <input type="search" name="q" value="{{ request('q') }}"></label>
            </form>
        </div>
    </div>

    <table class="table table-bordered customer-contacts-table">
        <thead>
            <tr>
                <th style="color:#000;">Contact Person's Title</th>
                <th style="color:#000;">Contact Person's Name</th>
                <th style="color:#000;">Contact Person's Phone 1</th>
                <th style="color:#000;">Contact Person's Company</th>
                <th style="color:#000;">External Platform/Solution</th>
                <th style="color:#000;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($contacts as $contact)
                <tr>
                    <td style="color:#000;">{{ $contact->title }}</td>
                    <td style="color:#000;">{{ $contact->name }}</td>
                    <td style="color:#000;">{{ $contact->phone }}</td>
                    <td style="color:#000;">{{ optional($contact->company)->name }}</td>
                    <td style="color:#000;">{{ $contact->external_platform }}</td>
                    <td>
                        <a href="{{ route('reference-data.customer-contacts.edit', $contact) }}">Edit</a> |
                        <form action="{{ route('reference-data.customer-contacts.destroy', $contact) }}" method="POST" style="display:inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-link p-0">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6">No contacts</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="d-flex justify-content-between">
        <div>
            Showing {{ $contacts->firstItem() ?? 0 }} to {{ $contacts->lastItem() ?? 0 }} of {{ $contacts->total() }} entries
        </div>
        <div>
            {{ $contacts->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@endsection
