@extends('layouts.app')
@section('page-title','Details')
@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">Application Group</div>
        <div class="card-body">
            <div class="mb-2"><strong>Name:</strong> {{ $group->name }}</div>
            @if($group->description)
                <div class="mb-2"><strong>Description:</strong> {{ $group->description }}</div>
            @endif
            <a href="{{ route('reference-data.application-groups.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>
</div>
@endsection

