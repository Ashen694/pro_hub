@push('styles')
<style>
    .card-table td, .card-table th {
        font-size: .875rem;
        padding: 1rem;
        vertical-align: middle;
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
                <th class="fw-bold text-uppercase text-muted text-center" style="font-size: 0.75rem;"></th>
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
                    <a href="#" class="btn btn-sm" title="View Details">
                        View Archive
                    </a>
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