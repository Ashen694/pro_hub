@extends('layouts.app')
@section('page-title','Fields Of Specializations')
@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Fields Of Specializations</h3>
        <a href="#" class="btn btn-primary">New Field</a>
    </div>
    <table class="table">
        <thead><tr><th>Name</th><th>Notes</th></tr></thead>
        <tbody>
            @forelse($items as $i)
                <tr><td>{{ $i->name }}</td><td>{{ $i->notes }}</td></tr>
            @empty
                <tr><td colspan="2">No items</td></tr>
            @endforelse
        </tbody>
    </table>
    {{ $items->links() }}
</div>
@endsection
