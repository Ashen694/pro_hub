@extends('layouts.app')
@section('page-title','Application Groups')
@section('content')
<div class="container">
    <div class="mb-3">
        <a href="{{ route('reference-data.application-groups.create') }}">Create New</a>
    </div>

    <div class="list-group">
        <div class="list-group-item list-group-item-action active" style="background:#fff;color:#000;border:0;padding:12px 16px;font-weight:700">Application Group
        </div>
        @forelse($groups as $g)
            <div class="list-group-item d-flex justify-content-between align-items-center" style="border-top:1px solid #e9ecef">
                <div style="text-transform:uppercase;color:#000;">{{ $g->name }}</div>
                <div><a href="{{ route('reference-data.application-groups.edit', $g) }}">Edit</a></div>
            </div>
        @empty
            <div class="list-group-item">No groups</div>
        @endforelse
    </div>

    <div class="mt-3 small text-muted">
        {{ $groups->links() }}
    </div>
</div>
@endsection
