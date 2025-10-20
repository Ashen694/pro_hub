<div class="table-responsive">
    <table class="table card-table table-vcenter text-nowrap datatable">
        <thead>
            <tr>
                <th>Application Name</th>
                <th>Developed By</th>
                <th>Launched Billed On</th>
                <th>Revenue SW.Value</th>
                <th>DPO Handover Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($solutions as $solution)
            <tr>
                <td>{{ $solution->application_name }}</td>
                <td>{{ $solution->developed_by }}</td>
                <td>{{ $solution->launched_billed_on }}</td>
                <td>{{ $solution->revenue_sw_value }}</td>
                <td>{{ $solution->dpo_handover_date }}</td>
                <td>
                    <div class="d-flex">
                        <a href="{{ route('external-solutions.show', $solution->id) }}" class="btn btn-ghost-info btn-sm" title="View">
                            View
                        </a>
                        <a href="{{ route('external-solutions.edit', $solution->id) }}" class="btn btn-ghost-primary btn-sm ms-2" title="Edit">
                            Edit
                        </a>
                        <form action="{{ route('external-solutions.destroy', $solution->id) }}" method="POST" onsubmit="return confirm('Delete this solution?');" class="ms-2">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="text-center">No solutions found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>