@push('styles')
<style>
    .card-table td, .card-table th {
        font-size: .875rem;
        padding: 1rem;
        vertical-align: middle;
    }
    .btn-icon {
        width: 2.2rem;
        height: 2.2rem;
    }
</style>
@endpush

<div class="card-body border-bottom py-3">
    <div class="d-flex">
        <div class="text-muted">
            Show
            <div class="mx-2 d-inline-block">
                <select class="form-select form-select-sm" style="width: 60px;">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                </select>
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
        <div class="col-md-3">
            <label class="form-label">Application Name</label>
            <input type="text" class="form-control" placeholder="Search by name...">
        </div>
        <div class="col-md-3">
            <label class="form-label">SDLC Phase</label>
            <select class="form-select">
                <option value="">All Phases</option>
                <option>Design</option>
                <option>Testing</option>
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label">Developed By</label>
            <select class="form-select">
                <option value="">Any Developer</option>
                <option>Dayana Katawala</option>
                <option>Nimal Perera</option>
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label">Target Date Range</label>
            <input type="text" class="form-control" placeholder="Select date range...">
        </div>
        <div class="col-12 text-end">
            <a href="#" class="btn btn-link">Reset</a>
            <a href="#" class="btn btn-primary">Search</a>
        </div>
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
                <th class="fw-bold text-uppercase text-muted" style="font-size: 0.75rem;">UD</th>
                <th class="fw-bold text-uppercase text-muted" style="font-size: 0.75rem;">Solution Value</th>
                <th class="fw-bold text-uppercase text-muted text-center" style="font-size: 0.75rem;">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($solutions as $solution)
            <tr>
                <td><span class="badge bg-green-lt">{{ $solution->App_Category }}</span></td>
                <td><strong>{{ $solution->App_Name }}</strong></td>
                <td>{{ $solution->Developed_By }}</td>
                <td>{{ $solution->SDLCPhase }}</td>
                <td>{{ $solution->StartDate }}</td>
                <td>{{ $solution->TargetDate }}</td>
                <td></td>
                <td>{{ number_format($solution->Price, 2) }}</td>
                <td class="text-center">
                    <div class="btn-list flex-nowrap justify-content-center">
                        <a href="#" class="btn btn-icon btn-outline-primary" data-bs-toggle="tooltip" title="Edit"><svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg></a>
                        <a href="#" class="btn btn-icon btn-outline-info" data-bs-toggle="tooltip" title="View Details"><svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2" /><rect x="9" y="3" width="6" height="4" rx="2" /><path d="M9 12v-1h6v1" /><path d="M12 11v6" /><path d="M11 17h2" /></svg></a>
                        <a href="#" class="btn btn-icon btn-outline-secondary" data-bs-toggle="tooltip" title="Documents"><svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 4h3l2 2h5a2 2 0 0 1 2 2v7a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-9a2 2 0 0 1 2 -2" /><path d="M17 17v2a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-9a2 2 0 0 1 2 -2h2" /></svg></a>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="9" class="text-center py-5"><h3>No In-Progress Solutions Found</h3></td></tr>
            @endforelse
        </tbody>
    </table>
</div>

@push('scripts')
<script>
  document.addEventListener("DOMContentLoaded", function () {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl)
    })
  });
</script>
@endpush