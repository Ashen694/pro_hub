<div class="table-responsive">
    <table class="table card-table table-vcenter text-nowrap datatable">
        <thead class="table-light">
            <tr>
                <th class="text-muted text-uppercase small">Application Name</th>
                <th class="text-muted text-uppercase small">Developed By</th>
                <th class="text-muted text-uppercase small">Launched Billed On</th>
                <th class="text-muted text-uppercase small">Revenue SW.Value</th>
                <th class="text-muted text-uppercase small">DPO Handover Date</th>
                <th class="text-muted text-uppercase small">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($solutions as $solution)
            <tr>
                <td>{{ $solution->application_name }}</td>
                <td>{{ $solution->developed_by }}</td>
                <td>{{ $solution->launched_billed_on ? \Carbon\Carbon::parse($solution->launched_billed_on)->format('Y-m-d') : '' }}</td>
                <td>{{ $solution->revenue_sw_value }}</td>
                <td>{{ $solution->dpo_handover_date ? \Carbon\Carbon::parse($solution->dpo_handover_date)->format('Y-m-d') : '' }}</td>
                <td>
                    <div class="d-flex align-items-center">
                        <a href="{{ route('external-solutions.show', $solution->id) }}" class="text-primary" title="View">View</a>
                        <a href="{{ route('external-solutions.edit', $solution->id) }}" class="ms-3 text-primary" title="Edit">Edit</a>

                        <form action="{{ route('external-solutions.destroy', $solution->id) }}" method="POST" onsubmit="return confirm('Delete this solution?');" class="ms-3">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="text-center text-muted">No solutions found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>