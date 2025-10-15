@push('styles')
<style>
    .card-table td, .card-table th { font-size: .875rem; padding: 1rem; vertical-align: middle; }
    .btn-icon { width: 2.2rem; height: 2.2rem; }
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
             <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#filter-card">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M4 4h16v2.172a2 2 0 0 1 -.586 1.414l-4.414 4.414v7l-6 2v-8.5l-4.48 -4.928a2 2 0 0 1 -.52 -1.345v-2.227z"></path></svg>
                Advanced Filters
            </button>
        </div>
    </div>
</div>

<div class="collapse" id="filter-card">
  <div class="card card-body">
    <div class="row g-3">
        <div class="col-md-3"><label class="form-label">Application Name</label><input type="text" class="form-control" placeholder="Search by name..."></div>
        <div class="col-md-3"><label class="form-label">SDLC Phase</label><select class="form-select"><option value="">All Phases</option><option>Design</option><option>Testing</option></select></div>
        <div class="col-md-3"><label class="form-label">Developed By</label><select class="form-select"><option value="">Any Developer</option><option>Dayana Katawala</option><option>Nimal Perera</option></select></div>
        <div class="col-md-3"><label class="form-label">Target Date Range</label><input type="text" class="form-control" placeholder="Select date range..."></div>
        <div class="col-12 text-end"><a href="#" class="btn btn-link">Reset</a><a href="#" class="btn btn-primary">Search</a></div>
    </div>
  </div>
</div>

<div class="table-responsive">
    <table class="table card-table table-vcenter text-nowrap">
        <thead>
            <tr>
                <th class="fw-bold text-uppercase text-muted" style="font-size: 0.75rem;">Application Group</th>
                <th class="fw-bold text-uppercase text-muted" style="font-size: 0.75rem;">Application Name</th>
                <th class="fw-bold text-uppercase text-muted" style="font-size: 0.75rem;">Developed By</th>
                <th class="fw-bold text-uppercase text-muted" style="font-size: 0.75rem;">SDLC Phase</th>
                <th class="fw-bold text-uppercase text-muted" style="font-size: 0.75rem;">Start</th>
                <th class="fw-bold text-uppercase text-muted" style="font-size: 0.75rem;">Target</th>
                <th class="fw-bold text-uppercase text-muted" style="font-size: 0.75rem;">Solution Value</th>
                <th class="fw-bold text-uppercase text-muted text-center" style="font-size: 0.75rem;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($solutions as $solution)
            <tr>
                <td><span class="badge bg-green-lt">{{ $solution->parentProject->ParentProjectGroup ?? 'N/A' }}</span></td>
                <td><strong>{{ $solution->App_Name }}</strong></td>
                <td>{{ $solution->Developed_By }}</td>
                <td>{{ $solution->SDLCPhase }}</td>
                <td>{{ $solution->StartDate }}</td>
                <td>{{ $solution->TargetDate }}</td>
                <td>{{ number_format($solution->Price, 2) }}</td>
                <td class="text-center">
                    <div class="btn-list flex-nowrap justify-content-center">
                        <a href="{{ route('internal-solutions.show', $solution->ID) }}" class="btn btn-icon btn-outline-info" data-bs-toggle="tooltip" title="View Details"><svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" /></svg></a>
                        <a href="#" class="btn btn-icon btn-outline-primary" data-bs-toggle="tooltip" title="Edit"><svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4" /><path d="M13.5 6.5l4 4" /></svg></a>
                        <a href="#" class="btn btn-icon btn-outline-secondary" data-bs-toggle="tooltip" title="Documents"><svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" /></svg></a>
                        <button class="btn btn-icon btn-outline-danger" data-bs-toggle="modal" data-bs-target="#delete-modal-{{ $solution->ID }}" data-bs-toggle="tooltip" title="Delete"><svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg></button>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="8" class="text-center py-5"><h3>No In-Progress Solutions Found</h3></td></tr>
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