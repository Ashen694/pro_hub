@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h2>Create Partner</h2>

        <form method="POST" action="{{ route('partners.store') }}">
            @csrf

            <div class="mb-3">
                <label>Organization Name</label>
                <input type="text" class="form-control" name="organization_name" required>
            </div>

            <div class="mb-3">
                <label>Contact Person Title</label>
                <select class="form-select" name="contact_person_title">
                    <option value="">Select</option>
                    @foreach($titles as $title)
                        <option value="{{ $title }}">{{ $title }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label>Contact Person Name</label>
                <input type="text" class="form-control" name="contact_person_name" required>
            </div>

            <div class="mb-3">
                <label>Contact Person Email</label>
                <input type="email" class="form-control" name="contact_person_email" required>
            </div>

            <div class="mb-3">
                <label>Phone 1</label>
                <input type="text" class="form-control" name="contact_person_phone_1">
            </div>

            <div class="mb-3">
                <label>Phone 2</label>
                <input type="text" class="form-control" name="contact_person_phone_2">
            </div>

            <div class="mb-3">
                <label>Designation</label>
                <input type="text" class="form-control" name="contact_person_designation">
            </div>

            <button type="submit" class="btn btn-primary">Create</button>
            <a href="{{ route('partners.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection
