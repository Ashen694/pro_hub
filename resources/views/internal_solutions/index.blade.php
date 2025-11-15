@extends('layouts.app')

@section('page-title', $title)

{{-- Add this section to make the main container wider --}}
@push('styles')
<style>
    /* 
      This targets the main content container of the page layout.
      We are increasing its max-width to 90% of the viewport width.
      The !important rule ensures it overrides the default Bootstrap styles.
    */
    .container-xl {
        max-width: 90% !important;
    }
</style>
@endpush


@section('content')

{{-- We remove the container-fluid from the previous attempt --}}
<div class="card">
    @livewire('internal-solutions-table', ['status' => $status])    
</div>

@endsection

@push('scripts')
<script>
      document.addEventListener('livewire:navigated', () => {
         var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
         var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) { return new bootstrap.Tooltip(tooltipTriggerEl) });
    });
</script>
@endpush