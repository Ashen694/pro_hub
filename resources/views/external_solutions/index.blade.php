@extends('layouts.app')

@section('page-title', $title)

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title mb-0">{{ $title }}</h3>
        <a href="{{ route('external-solutions.create') }}" class="btn btn-primary">Create New</a>
    </div>

    {{-- Flash Messages --}}
    @if (session()->has('success'))
        <div class="alert alert-success m-3">{{ session('success') }}</div>
    @endif
    @if (session()->has('error'))
        <div class="alert alert-danger m-3">{{ session('error') }}</div>
    @endif

    @livewire('external-solutions-table', ['status' => $status])
    
</div>
@endsection