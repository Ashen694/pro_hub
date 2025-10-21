@push('styles')
<style>
    .card-table td, .card-table th { font-size: .875rem; padding: 1rem; vertical-align: middle; }
    .btn-icon { width: 2.2rem; height: 2.2rem; }
    .cr-link { font-size: 0.75rem; font-style: italic; }
    /* make select text visible on dark background */
    .white-select, .white-select option { color: #fff !important; background: transparent !important; }
</style>
@endpush

<div class="card-body border-bottom py-3">
    <div class="d-flex">
        <div class="btn-group" role="group">
            <a href="{{ route('internal-solutions.index', ['status' => 'operational']) }}" 
               class="btn {{ !request()->get('filter') ? 'btn-primary' : 'btn-outline-secondary' }}">
               Operational
            </a>
            <a href="{{ route('internal-solutions.index', ['status' => 'operational', 'filter' => 'without_cr']) }}" 
               class="btn {{ request()->get('filter') === 'without_cr' ? 'btn-primary' : 'btn-outline-secondary' }}">
               Operational without CR
            </a>
        </div>
        <div class="ms-auto text-muted">
             <button class="btn btn-outline-primary" type="button" data-bs-toggle="collapse" data-bs-target="#filter-card">
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
                <label class="form-label" style="color:#fff;">Application Group</label>
                <select class="form-select white-select">
                        <option value="">All Groups</option>
                        <option>ENTERPRISE PORTAL</option>
                        <option>BILLING SUPPORT</option>
                </select>
            </div>
      <div class="col-md-3">
        <label class="form-label">Developed By</label>
        <select class="form-select">
            <option value="">Any Developer</option>
            <option>Ashen Kavindu</option>
            <option>Nimal Perera</option>
            <option>Sunil Shantha</option>
        </select>
      </div>
      <div class="col-md-3">
        <label class="form-label">VA Date Range</label>
        <input type="text" class="form-control" placeholder="Select date range...">
      </div>
      <div class="col-12 text-end">
        <a href="#" class="btn btn-link">Reset</a>
        <a href="#" class="btn btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-search" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path><path d="M21 21l-6 -6"></path></svg>
            Search
        </a>
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
                <th class="fw-bold text-uppercase text-muted" style="font-size: 0.75rem;">VA Date</th>
                <th class="fw-bold text-uppercase text-muted" style="font-size: 0.75rem;">Solution Value</th>
                <th class="fw-bold text-uppercase text-muted text-center" style="font-size: 0.75rem;">Actions</th> 
            </tr>
        </thead>
        <tbody>
            @forelse ($solutions as $solution)
            <tr>
                <td><span class="badge bg-blue-lt">{{ $solution->parentProject->ParentProjectGroup ?? 'N/A' }}</span></td>
                <td>
                    <strong>{{ $solution->App_Name }}</strong>
                    @if ($solution->App_Category == 'Change Request' && $solution->mainApplicationParent)
                        <div class="cr-link">
                            <a href="{{ route('internal-solutions.show', $solution->mainApplicationParent->ID) }}">CR of {{ $solution->mainApplicationParent->App_Name }}</a>
                        </div>
                    @endif
                </td>
                <td>{{ $solution->Developed_By }}</td>
                <td>{{ $solution->VADate }}</td>
                <td>{{ number_format($solution->Price, 2) }}</td> 
                <td class="text-center">
                    <div class="btn-list flex-nowrap justify-content-center">
                        <a href="{{ route('internal-solutions.show', $solution->ID) }}" class="btn btn-icon btn-outline-info" data-bs-toggle="tooltip" title="View Details"><svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" /></svg></a>
                        <a href="#" class="btn btn-icon btn-outline-primary" data-bs-toggle="tooltip" title="Edit"><svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4" /><path d="M13.5 6.5l4 4" /></svg></a>
                        <a href="#" class="btn btn-icon btn-outline-secondary" data-bs-toggle="tooltip" title="Documents"><svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" /></svg></a>
                        @if ($solution->App_Category == 'Main Application')
                        <a href="{{ route('internal-solutions.change-requests', $solution->ID) }}" class="btn btn-icon btn-outline-warning" data-bs-toggle="tooltip" title="Change Requests"><svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" /><path d="M12 11l-1 1l1 1l-1 1l1 1" /><path d="M9 11l1 1l-1 1l1 1l-1 1" /></svg></a>
                        @endif
                        <button class="btn btn-icon btn-outline-danger" data-bs-toggle="modal" data-bs-target="#delete-modal-{{ $solution->ID }}" data-bs-toggle="tooltip" title="Delete"><svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg></button>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center py-5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-database-off" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12.984 8.978c3.956 .45 7.016 3.478 7.016 6.522c0 3.866 -4.477 7 -10 7c-1.636 0 -3.152 -.42 -4.432 -1.14m-2.24 -2.227c-.847 -1.405 -1.328 -3.08 -1.328 -4.793c0 -3.866 4.477 -7 10 -7c1.785 0 3.463 .477 4.81 1.323" /><path d="M4 6v6" /><path d="M4 12v6" /><path d="M20 6.75v3.25" /><path d="M3 3l18 18" /></svg>
                    <h3 class="mt-3">No Operational Solutions Found</h3>
                    <p class="text-muted">There are no records matching your current filters.</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- This part is crucial for the delete modals to work. --}}
{{-- It loops through the solutions again to create a unique modal for each row. --}}
@foreach($solutions as $solution)
<div class="modal modal-blur fade" id="delete-modal-{{ $solution->ID }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-status bg-danger"></div>
            <div class="modal-body text-center py-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-danger icon-lg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 9v2m0 4v.01" /><path d="M5 19h14a2 2 0 0 0 1.84 -2.75l-7.1 -12.25a2 2 0 0 0 -3.5 0l-7.1 12.25a2 2 0 0 0 1.75 2.75" /></svg>
                <h3>Are you sure?</h3>
                <div class="text-muted">Do you really want to delete <strong>{{ $solution->App_Name }}</strong>? This action cannot be undone.</div>
            </div>
            <div class="modal-footer">
                <div class="w-100">
                    <div class="row">
                        <div class="col"><a href="#" class="btn w-100" data-bs-dismiss="modal">Cancel</a></div>
                        <div class="col">
                            <form action="{{ route('internal-solutions.destroy', $solution->ID) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger w-100">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
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