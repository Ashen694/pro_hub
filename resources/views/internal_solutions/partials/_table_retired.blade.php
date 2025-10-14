@push('styles')
<style>
    .card-table td, .card-table th { font-size: .875rem; padding: 1rem; vertical-align: middle; }
</style>
@endpush

<div class="card-body border-bottom py-3">
    <div class="d-flex">
        <div class="text-muted">
            Show
            <div class="mx-2 d-inline-block">
                <select class="form-select form-select-sm" style="width: 60px;"><option>10</option><option>25</option><option>50</option></select>
            </div>
            entries
        </div>
        <div class="ms-auto text-muted">
            Search:
            <div class="ms-2 d-inline-block">
                <input type="text" class="form-control form-control-sm" placeholder="Search...">
            </div>
        </div>
    </div>
</div>

<div class="table-responsive">
    <table class="table card-table table-vcenter text-nowrap">
        <thead>
            <tr>
                <th class="fw-bold text-uppercase text-muted" style="font-size: 0.75rem;">Application Name</th>
                <th class="fw-bold text-uppercase text-muted" style="font-size: 0.75rem;">Developed By</th>
                <th class="fw-bold text-uppercase text-muted" style="font-size: 0.75rem;">Launched Date</th>
                <th class="fw-bold text-uppercase text-muted" style="font-size: 0.75rem;">SDLC Phase</th>
                <th class="fw-bold text-uppercase text-muted" style="font-size: 0.75rem;">Solution Value</th>
                <th class="fw-bold text-uppercase text-muted" style="font-size: 0.75rem;">Comment</th>
                <th class="fw-bold text-uppercase text-muted text-center" style="font-size: 0.75rem;">Actions</th>
            </tr>
        </thead>
        <tbody>
             @forelse ($solutions as $solution)
            <tr>
                <td><strong>{{ $solution->App_Name }}</strong></td>
                <td>{{ $solution->Developed_By }}</td>
                <td>{{ $solution->LaunchedDate ?? '-' }}</td>
                <td><span class="badge bg-red-lt">{{ $solution->SDLCPhase }}</span></td>
                <td>{{ number_format($solution->Price, 2) }}</td>
                <td>{{ $solution->Comment ?? '-' }}</td>
                <td class="text-center">
                    <div class="btn-list flex-nowrap justify-content-center">
                        <a href="{{ route('internal-solutions.show', $solution->ID) }}" class="btn btn-icon btn-outline-info" data-bs-toggle="tooltip" title="View Details"><svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" /></svg></a>
                        <button class="btn btn-icon btn-outline-danger" data-bs-toggle="modal" data-bs-target="#delete-modal-{{ $solution->ID }}" data-bs-toggle="tooltip" title="Delete"><svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg></button>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                @if($status == 'retired')
                    <td colspan="7" class="text-center py-5"><h3>No Retired Solutions Found</h3></td>
                @else
                    <td colspan="7" class="text-center py-5"><h3>No Abandoned Solutions Found</h3></td>
                @endif
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@foreach($solutions as $solution)
<div class="modal modal-blur fade" id="delete-modal-{{ $solution->ID }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-status bg-danger"></div>
            <div class="modal-body text-center py-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-danger icon-lg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 9v2m0 4v.01" /><path d="M5 19h14a2 2 0 0 0 1.84 -2.75l-7.1 -12.25a2 2 0 0 0 -3.5 0l-7.1 12.25a2 2 0 0 0 1.75 2.75" /></svg>
                <h3>Are you sure?</h3>
                <div class="text-muted">Do you really want to delete <strong>{{ $solution->App_Name }}</strong>?</div>
            </div>
            <div class="modal-footer">
                <div class="w-100"><div class="row">
                        <div class="col"><a href="#" class="btn w-100" data-bs-dismiss="modal">Cancel</a></div>
                        <div class="col">
                            <form action="{{ route('internal-solutions.destroy', $solution->ID) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger w-100">Delete</button>
                            </form>
                        </div>
                </div></div>
            </div>
        </div>
    </div>
</div>
@endforeach

@push('scripts')
<script>
  document.addEventListener("DOMContentLoaded", function () {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) { return new bootstrap.Tooltip(tooltipTriggerEl) });
  });
</script>
@endpush