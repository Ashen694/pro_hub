@extends('layouts.app')
@section('page-title','Details')
@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">Customer Contact</div>
        <div class="card-body">
            <div class="mb-2"><strong>Name:</strong> {{ $contact->name }}</div>
            <div class="mb-2"><strong>Title:</strong> {{ $contact->title }}</div>
            <div class="mb-2"><strong>Email:</strong> {{ $contact->email }}</div>
            <div class="mb-2"><strong>Phone:</strong> {{ $contact->phone }}</div>
            <div class="mb-2"><strong>Company:</strong> {{ optional($contact->company)->name }}</div>
            <div class="mb-2"><strong>Role:</strong> {{ $contact->role }}</div>
            <a href="{{ route('reference-data.customer-contacts.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>
</div>
@endsection

