@extends('layouts.app')

@section('page-title', $title)

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title mb-0">{{ $title }}</h3>
        <p class="text-muted mb-0">for all the projects launched on a particular year</p>
    </div>

    {{-- Flash Messages --}}
    @if (session()->has('success'))
        <div class="alert alert-success m-3">{{ session('success') }}</div>
    @endif
    @if (session()->has('error'))
        <div class="alert alert-danger m-3">{{ session('error') }}</div>
    @endif

    @livewire('external-projected-revenue-table')
    
</div>
@endsection
