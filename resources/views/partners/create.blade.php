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
    .partners-content-wrapper .form-control.is-invalid,
    .partners-content-wrapper .form-select.is-invalid {
        border-color: #dc3545 !important;
    }
</style>
@endpush

@section('page-title', 'Create Partner')

@section('content')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const phone1 = document.getElementById("contact_person_phone_1");
            const phone2 = document.getElementById("contact_person_phone_2");
            const email = document.getElementById("contact_person_email");
            const form = document.querySelector("form");

            // Allow only digits, max length 10
            [phone1, phone2].forEach(input => {
                input.addEventListener("input", function(e) {
                    this.value = this.value.replace(/\D/g, ''); // remove non-digits
                    if (this.value.length > 10) this.value = this.value.slice(0, 10);
                });
            });

            // Form validation before submit
            form.addEventListener("submit", function(e) {
                let errors = [];

                if (phone1.value && phone1.value.length !== 10) {
                    errors.push("Phone 1 must be exactly 10 digits.");
                }
                if (phone2.value && phone2.value.length !== 0 && phone2.value.length !== 10) {
                    errors.push("Phone 2 must be exactly 10 digits or empty.");
                }
                if (phone1.value && phone1.value === phone2.value && phone2.value !== "") {
                    errors.push("Phone 1 and Phone 2 cannot be the same.");
                }
                if (!email.value.includes("@")) {
                    errors.push("Email must contain '@'.");
                }

                if (errors.length > 0) {
                    e.preventDefault();
                    alert(errors.join("\n"));
                }
            });
        });
    </script>

    <div class="partners-content-wrapper">
    <h2>Create Partner</h2>

    <form method="POST" action="{{ route('reference-data.partners.store') }}" class="mt-4">
        @csrf

        <div class="mb-3">
            <label for="organization_name" class="form-label">Organization Name</label>
            <input type="text" class="form-control @error('organization_name') is-invalid @enderror" id="organization_name" name="organization_name" value="{{ old('organization_name') }}" required>
            @error('organization_name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="contact_person_title" class="form-label">Contact Person Title</label>
            <select class="form-select @error('contact_person_title') is-invalid @enderror" id="contact_person_title" name="contact_person_title">
                <option value="">Select</option>
                @foreach($titles as $title)
                    <option value="{{ $title }}" {{ old('contact_person_title') == $title ? 'selected' : '' }}>{{ $title }}</option>
                @endforeach
            </select>
            @error('contact_person_title')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="contact_person_name" class="form-label">Contact Person Name</label>
            <input type="text" class="form-control @error('contact_person_name') is-invalid @enderror" id="contact_person_name" name="contact_person_name" value="{{ old('contact_person_name') }}" required>
            @error('contact_person_name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="contact_person_email" class="form-label">Contact Person Email</label>
            <input type="email" class="form-control @error('contact_person_email') is-invalid @enderror" id="contact_person_email" name="contact_person_email" value="{{ old('contact_person_email') }}" required>
            @error('contact_person_email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="contact_person_phone_1" class="form-label">Phone 1</label>
            <input type="text" class="form-control @error('contact_person_phone_1') is-invalid @enderror" id="contact_person_phone_1" name="contact_person_phone_1" value="{{ old('contact_person_phone_1') }}">
            @error('contact_person_phone_1')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="contact_person_phone_2" class="form-label">Phone 2</label>
            <input type="text" class="form-control @error('contact_person_phone_2') is-invalid @enderror" id="contact_person_phone_2" name="contact_person_phone_2" value="{{ old('contact_person_phone_2') }}">
            @error('contact_person_phone_2')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="contact_person_designation" class="form-label">Designation</label>
            <input type="text" class="form-control @error('contact_person_designation') is-invalid @enderror" id="contact_person_designation" name="contact_person_designation" value="{{ old('contact_person_designation') }}">
            @error('contact_person_designation')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Create</button>
        <a href="{{ route('reference-data.partners.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
