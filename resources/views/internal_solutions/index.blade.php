@extends('layouts.app')

@section('page-title', $title)

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ $title }}</h3>
        
        {{-- Show "Create New" button only for relevant pages --}}
        @if($status == 'operational' || $status == 'in-progress')
            <div class="card-options">
                <a href="{{ route('internal-solutions.create') }}" class="btn btn-primary">Create New</a>
            </div>
        @endif
        
        {{-- Show "Abandoned/Retired" toggle only for their pages --}}
        @if($status == 'retired' || $status == 'abandoned')
            <div class="card-options">
                <div class="btn-group" role="group">
                    <a href="{{ route('internal-solutions.index', ['status' => 'abandoned']) }}" 
                       class="btn btn-sm {{ $status == 'abandoned' ? 'btn-primary' : 'btn-outline-secondary' }}">Abandoned</a>
                    <a href="{{ route('internal-solutions.index', ['status' => 'retired']) }}" 
                       class="btn btn-sm {{ $status == 'retired' ? 'btn-primary' : 'btn-outline-secondary' }}">Retired</a>
                </div>
            </div>
        @endif
    </div>

    {{-- The dynamic partial file will now contain its own filter section and the table --}}
    @include('internal_solutions.partials.' . $viewPartial)

    {{-- Pagination and Footer --}}
    <div class="card-footer d-flex align-items-center">
        @if(in_array($status, ['retired', 'abandoned', 'in-progress', 'recently-launched', 'operational']))
            <a href="#" class="btn btn-outline-primary">Export All Details to Excel</a>
        @endif

        <div class="ms-auto">
            {{ $solutions->links() }}
        </div>
    </div>
</div>
@endsection