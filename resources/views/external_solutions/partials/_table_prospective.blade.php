<div class="table-responsive">
    <table class="table card-table table-vcenter text-nowrap datatable">
        <thead>
            <tr>
                <th>Platform Name</th>
                <th>Platform Owner (Customer)</th>
                <th>Developed By</th>
                <th>SDLC Stage</th>
                <th>Start Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($solutions as $solution)
            <tr>
                <td>{{ $solution->platform_name }}</td>
                <td>{{ $solution->platform_owner }}</td>
                <td>{{ $solution->developed_by }}</td>
                <td>{{ $solution->sdlc_stage }}</td>
                <td>{{ optional($solution->start_date)->format('Y-m-d') ?? '-' }}</td>
                <td>
                    <a href="{{ route('external-solutions.edit', $solution->platform_id) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                    <a href="{{ route('external-solutions.show', $solution->platform_id) }}" class="btn btn-sm btn-outline-info">View</a>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="text-center">No prospective solutions found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>