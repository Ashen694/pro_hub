@extends('layouts.app')
@section('page-title','Details')
@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">Field Of Specialization</div>
        <div class="card-body">
            <div class="mb-2"><strong>Name:</strong> {{ $item->name }}</div>
            @if($item->notes)
                <div class="mb-2"><strong>Description:</strong> {{ $item->notes }}</div>
            @endif
            <a href="{{ route('reference-data.fields-of-specializations.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>
</div>
@endsection

