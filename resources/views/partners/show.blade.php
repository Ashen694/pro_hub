@extends('layouts.app')

@push('styles')
<style>
    .partners-content-wrapper {
        background-color: #ffffff;
        border: 1px solid #e0e0e0;
        padding: 24px;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }
    .partners-content-wrapper h1, .partners-content-wrapper h2, .partners-content-wrapper h3, .partners-content-wrapper h5, .partners-content-wrapper p, .partners-content-wrapper strong {
        color: #212529 !important;
    }
    .partners-content-wrapper hr {
        border-top: 1px solid #dee2e6; /* light grey line */
    }
    .partners-content-wrapper .card {
        background-color: transparent !important;
        border: none !important;
    }
    .partners-content-wrapper .card-header {
        border-bottom: 1px solid #dee2e6 !important;
        padding-left: 0;
    }
     .partners-content-wrapper .card-body {
        padding-left: 0;
        padding-right: 0;
    }
</style>
@endpush

@section('page-title', 'View Partner')

@section('content')
<div class="partners-content-wrapper">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>View Partner</h2>
        <div>
            <a href="{{ route('reference-data.partners.edit', $partner) }}" class="btn btn-warning">Edit</a>
            <a href="{{ route('reference-data.partners.index') }}" class="btn btn-secondary">Back to List</a>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3>{{ $partner->organization_name }}</h3>
        </div>
        <div class="card-body">
            <h5 class="card-title">Contact Person</h5>
            <p>
                <strong>Name:</strong>
                {{ $partner->contact_person_title }} {{ $partner->contact_person_name }}
            </p>
            <p>
                <strong>Designation:</strong>
                {{ $partner->contact_person_designation ?? 'N/A' }}
            </p>

            <hr>

            <h5 class="card-title">Contact Details</h5>
            <p>
                <strong>Email:</strong>
                {{ $partner->contact_person_email }}
            </p>
            <p>
                <strong>Phone 1:</strong>
                {{ $partner->contact_person_phone_1 ?? 'N/A' }}
            </p>
            <p>
                <strong>Phone 2:</strong>
                {{ $partner->contact_person_phone_2 ?? 'N/A' }}
            </p>
        </div>
    </div>
</div>
@endsection
