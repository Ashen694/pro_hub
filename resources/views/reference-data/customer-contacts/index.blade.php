@extends('layouts.app')
@section('page-title','Customer Contacts')
@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Customer Contacts</h3>
        <a href="#" class="btn btn-primary">New Contact</a>
    </div>
    <table class="table">
        <thead><tr><th>Company</th><th>Name</th><th>Email</th><th>Phone</th><th>Role</th></tr></thead>
        <tbody>
            @forelse($contacts as $c)
                <tr>
                    <td>{{ optional($c->company)->name }}</td>
                    <td>{{ $c->name }}</td>
                    <td>{{ $c->email }}</td>
                    <td>{{ $c->phone }}</td>
                    <td>{{ $c->role }}</td>
                </tr>
            @empty
                <tr><td colspan="5">No contacts</td></tr>
            @endforelse
        </tbody>
    </table>
    {{ $contacts->links() }}
</div>
@endsection
