{{-- show.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>View Partner</h2>
            <div>
                <a href="{{ route('partners.edit', $partner) }}" class="btn btn-warning">Edit</a>
                <a href="{{ route('partners.index') }}" class="btn btn-secondary">Back to List</a>
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
