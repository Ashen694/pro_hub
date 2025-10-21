@extends('layouts.app')
@section('page-title','Members')
@section('content')
<div class="container">
    <div class="row mb-2">
        <div class="col-6">
            <a href="{{ route('reference-data.divisional-members.create') }}" class="btn btn-primary btn-sm">Create New</a>
            <a href="#" class="ms-3">Divisional Members</a>
            <a href="#" class="ms-2">View Only Users</a>
        </div>
        <div class="col-6 text-end">
            <form method="GET" class="d-inline-block">
                <label class="me-2 small">Show</label>
                <select name="perPage" class="form-select form-select-sm d-inline-block" style="width:80px; color:#000;" onchange="this.form.submit()">
                    <option value="10" @if(request('perPage')==10) selected @endif>10</option>
                    <option value="25" @if(request('perPage')==25) selected @endif>25</option>
                </select>
                <label class="ms-2 small">entries</label>
            </form>
            <form method="GET" class="d-inline-block ms-3">
                <label class="small me-2">Search</label>
                <input type="search" name="q" value="{{ request('q') }}" class="form-control form-control-sm d-inline-block" style="width:200px;">
            </form>
        </div>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th style="color:#000;">Full Name</th>
                <th style="color:#000;">Email</th>
                <th style="color:#000;">Contact Mobile Number</th>
                <th style="color:#000;"></th>
            </tr>
        </thead>
        <tbody>
            @forelse($members as $m)
                <tr>
                    <td style="color:#000;">{{ $m->name }}</td>
                    <td style="color:#000;">{{ $m->email }}</td>
                    <td style="color:#000;">{{ $m->contact_mobile ?? '' }}</td>
                    <td class="text-end" style="color:#000;"><a href="#">Edit</a></td>
                </tr>
            @empty
                <tr><td colspan="4">No members</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="d-flex justify-content-between">
        <div class="small text-muted">Showing {{ $members->firstItem() ?? 0 }} to {{ $members->lastItem() ?? 0 }} of {{ $members->total() }} entries</div>
        <div>{{ $members->links() }}</div>
    </div>
</div>
@endsection
