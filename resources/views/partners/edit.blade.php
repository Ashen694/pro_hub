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
    .partners-content-wrapper h1, .partners-content-wrapper h2, .partners-content-wrapper h3, .partners-content-wrapper label, .partners-content-wrapper p {
        color: #212529 !important;
    }
    .partners-content-wrapper .form-control,
    .partners-content-wrapper .form-select {
        background-color: #ffffff !important;
        border: 1px solid #ced4da !important;
        color: #212529 !important;
    }
</style>
@endpush

@section('page-title', 'Edit Partner')

@section('content')
<div class="partners-content-wrapper">
    <h2>Edit Partner: {{ $partner->organization_name }}</h2>

    <form method="POST" action="{{ route('reference-data.partners.update', $partner) }}" class="mt-4">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Organization Name</label>
            <input type="text" class="form-control" name="organization_name"
                   value="{{ old('organization_name', $partner->organization_name) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Contact Person Title</label>
            <select class="form-select" name="contact_person_title">
                <option value="">Select</option>
                @foreach($titles as $title)
                    <option value="{{ $title }}"
                            @if(old('contact_person_title', $partner->contact_person_title) == $title) selected @endif>
                        {{ $title }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Contact Person Name</label>
            <input type="text" class="form-control" name="contact_person_name"
                   value="{{ old('contact_person_name', $partner->contact_person_name) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Contact Person Email</label>
            <input type="email" class="form-control" name="contact_person_email"
                   value="{{ old('contact_person_email', $partner->contact_person_email) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Phone 1</label>
            <input type="text" class="form-control" name="contact_person_phone_1"
                   value="{{ old('contact_person_phone_1', $partner->contact_person_phone_1) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Phone 2</label>
            <input type="text" class="form-control" name="contact_person_phone_2"
                   value="{{ old('contact_person_phone_2', $partner->contact_person_phone_2) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Designation</label>
            <input type="text" class="form-control" name="contact_person_designation"
                   value="{{ old('contact_person_designation', $partner->contact_person_designation) }}">
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('reference-data.partners.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection