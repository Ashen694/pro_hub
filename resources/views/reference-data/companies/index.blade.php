@extends('layouts.app')

@section('page-title', 'Companies')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Companies</h3>
        <a href="{{ route('reference-data.companies.create') }}" class="btn btn-primary">New Company</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Type</th>
                <th>Contact Email</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse($companies as $company)
                <tr>
                    <td>{{ $company->name }}</td>
                    <td>{{ $company->type }}</td>
                    <td>{{ $company->contact_email }}</td>
                    <td class="text-end">
                        <a href="{{ route('reference-data.companies.edit', $company) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                        <form action="{{ route('reference-data.companies.destroy', $company) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Delete this company?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4">No companies found.</td></tr>
            @endforelse
        </tbody>
    </table>

    {{ $companies->links() }}
</div>
@endsection
