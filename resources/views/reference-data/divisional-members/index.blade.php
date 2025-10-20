@extends('layouts.app')
@section('page-title','Divisional Members')
@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Divisional Members</h3>
        <a href="#" class="btn btn-primary">New Member</a>
    </div>
    <table class="table">
        <thead><tr><th>Name</th><th>Division</th><th>Email</th><th>Position</th></tr></thead>
        <tbody>
            @forelse($members as $m)
                <tr>
                    <td>{{ $m->name }}</td>
                    <td>{{ $m->division }}</td>
                    <td>{{ $m->email }}</td>
                    <td>{{ $m->position }}</td>
                </tr>
            @empty
                <tr><td colspan="4">No members</td></tr>
            @endforelse
        </tbody>
    </table>
    {{ $members->links() }}
</div>
@endsection
