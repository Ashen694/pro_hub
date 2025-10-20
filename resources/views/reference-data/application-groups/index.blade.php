@extends('layouts.app')
@section('page-title','Application Groups')
@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Application Groups</h3>
        <a href="#" class="btn btn-primary">New Group</a>
    </div>
    <table class="table">
        <thead><tr><th>Name</th><th>Description</th></tr></thead>
        <tbody>
            @forelse($groups as $g)
                <tr><td>{{ $g->name }}</td><td>{{ $g->description }}</td></tr>
            @empty
                <tr><td colspan="2">No groups</td></tr>
            @endforelse
        </tbody>
    </table>
    {{ $groups->links() }}
</div>
@endsection
