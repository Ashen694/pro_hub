{{-- index.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="container mx-auto mt-6">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="text-xl font-bold">Partners</h1>
            <a href="{{ route('partners.create') }}" class="btn btn-primary">Create Partner</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($partners->count())
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Organization Name</th>
                    <th>Contact Person Title</th>
                    <th>Contact Person Name</th>
                    <th>Email</th>
                    <th>Phone 1</th>
                    <th>Actions</th> {{-- Combined Actions Column --}}
                </tr>
                </thead>
                <tbody>
                @foreach($partners as $partner)
                    <tr>
                        <td>{{ $partner->organization_name }}</td>
                        <td>{{ $partner->contact_person_title }} </td>
                        <td>{{ $partner->contact_person_name }}</td>
                        <td>{{ $partner->contact_person_email }}</td>
                        <td>{{ $partner->contact_person_phone_1 }}</td>
                        {{-- <td>{{ $partner->contact_person_phone_2 }}</td> --}}
                        {{-- <td>{{ $partner->contact_person_designation}}</td> --}}

                        {{-- NEW ACTIONS COLUMN --}}
                        <td>
                            <div class="d-flex">
                                {{-- VIEW BUTTON --}}
                                <a href="{{ route('partners.show', $partner) }}" class="btn btn-sm btn-info me-1">View</a>

                                {{-- EDIT BUTTON --}}
                                <a href="{{ route('partners.edit', $partner) }}" class="btn btn-sm btn-warning me-1">Edit</a>

                                {{-- DELETE BUTTON (using standard route) --}}
                                <form action="{{ route('partners.destroy', $partner) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this partner?')">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <div class="mt-3">{{ $partners->links() }}</div>
        @else
            <p>No partners found.</p>
        @endif
    </div>
@endsection
