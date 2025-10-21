@extends('layouts.app')

@section('page-title', 'Consumer Service Platforms')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Consumer Service Platforms</h3>
    </div>
    
    {{-- Load the Livewire component here --}}
    @livewire('consumer-platforms-table')

</div>
@endsection