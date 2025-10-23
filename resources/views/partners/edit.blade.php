{{-- edit.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h2>Edit Partner: {{ $partner->organization_name }}</h2>

        {{-- Form points to the UPDATE route and uses PUT method --}}
        <form method="POST" action="{{ route('partners.update', $partner) }}">
            @csrf
            @method('PUT') {{-- <-- IMPORTANT for updates --}}

            <div class="mb-3">
                <label>Organization Name</label>
                {{-- We add the 'value' attribute to show existing data --}}
                <input type="text" class="form-control" name="organization_name"
                       value="{{ old('organization_name', $partner->organization_name) }}" required>
            </div>

            <div class="mb-3">
                <label>Contact Person Title</label>
                <select class="form-select" name="contact_person_title">
                    <option value="">Select</option>
                    @foreach($titles as $title)
                        {{-- We add 'selected' if the title matches the partner's title --}}
                        <option value="{{ $title }}"
                                @if(old('contact_person_title', $partner->contact_person_title) == $title) selected @endif>
                            {{ $title }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label>Contact Person Name</label>
                <input type="text" class="form-control" name="contact_person_name"
                       value="{{ old('contact_person_name', $partner->contact_person_name) }}" required>
            </div>

            <div class="mb-3">
                <label>Contact Person Email</label>
                <input type="email" class="form-control" name="contact_person_email"
                       value="{{ old('contact_person_email', $partner->contact_person_email) }}" required>
            </div>

            <div class="mb-3">
                <label>Phone 1</label>
                <input type="text" class="form-control" name="contact_person_phone_1"
                       value="{{ old('contact_person_phone_1', $partner->contact_person_phone_1) }}">
            </div>

            <div class="mb-3">
                <label>Phone 2</label>
                <input type="text" class="form-control" name="contact_person_phone_2"
                       value="{{ old('contact_person_phone_2', $partner->contact_person_phone_2) }}">
            </div>

            <div class="mb-3">
                <label>Designation</label>
                <input type="text" class="form-control" name="contact_person_designation"
                       value="{{ old('contact_person_designation', $partner->contact_person_designation) }}">
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('partners.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection
