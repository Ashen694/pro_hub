@extends('layouts.app')

@section('page-title', 'Change Requests of - ' . $mainApplication->App_Name)

@push('styles')
<style>
    .card-table td, .card-table th {
        font-size: .875rem;
        padding: 1rem;
        vertical-align: middle;
    }
</style>
@endpush

@section('content')
<div class="card">
    <div class="card-header">
        <div>
            <h3 class="card-title">Change Requests of - {{ $mainApplication->App_Name }}</h3>
            <p class="text-muted mb-0">A list of all change requests associated with this main application.</p>
        </div>
        <div class="card-options">
            <a href="{{ url()->previous() }}" class="btn btn-outline-primary">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M9 14l-4 -4l4 -4"></path><path d="M5 10h11a4 4 0 0 1 0 8h-1"></path></svg>
                Back to List
            </a>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table card-table table-vcenter text-nowrap table-striped">
            <thead>
                <tr>
                    <th class="fw-bold text-uppercase text-muted" style="font-size: 0.75rem;">Application Name</th>
                    <th class="fw-bold text-uppercase text-muted" style="font-size: 0.75rem;">Developed By</th>
                    <th class="fw-bold text-uppercase text-muted" style="font-size: 0.75rem;">Solution Value</th>
                    <th class="fw-bold text-uppercase text-muted" style="font-size: 0.75rem;">SDLC Phase</th>
                    <th class="fw-bold text-uppercase text-muted" style="font-size: 0.75rem;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($changeRequests as $cr)
                <tr>
                    <td><strong>{{ $cr->App_Name }}</strong></td>
                    <td>{{ $cr->Developed_By }}</td>
                    <td>{{ number_format($cr->Price, 2) }}</td>
                    <td><span class="badge bg-yellow-lt">{{ $cr->SDLCPhase }}</span></td>
                    <td>
                        <a href="{{ route('internal-solutions.show', $cr->ID) }}" class="btn btn-primary btn-sm">
                             <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-clipboard-text" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2"></path><path d="M9 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z"></path><path d="M9 12h6"></path><path d="M9 16h6"></path></svg>
                            View Details
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-off" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 3l18 18" /><path d="M7 3h7l5 5v7m0 4a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-14" /></svg>
                        <h3 class="mt-3">No Change Requests Found</h3>
                        <p class="text-muted">There are no change requests associated with this main application.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer d-flex align-items-center">
        <div class="ms-auto">
            {{ $changeRequests->links() }}
        </div>
    </div>
</div>
@endsection