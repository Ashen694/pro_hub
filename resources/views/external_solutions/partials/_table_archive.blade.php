<div class="table-responsive">
    <table class="table card-table table-vcenter text-nowrap datatable">
        <thead>
            <tr>
                <th>Platform Name</th>
                <th>Developed By</th>
                <th>Status</th>
                <th>Launched On</th>
                <th>OTC / MRC</th>
                <th>Software Value</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($solutions as $solution)
            <tr>
                <td>{{ $solution->platform_name }}</td>
                <td>{{ $solution->developed_by }}</td>
                <td><span class="badge bg-secondary">{{ ucfirst($solution->status) }}</span></td>
                <td>{{ optional($solution->launched_date)->format('Y-m-d') ?? '-' }}</td>
                <td>{{ $solution->platform_otc ?? '-' }} / {{ $solution->platform_mrc ?? '-' }}</td>
                <td>{{ $solution->software_value ? number_format($solution->software_value, 2) : '-' }}</td>
                <td>
                    <a href="{{ route('external-solutions.edit', $solution->platform_id) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                    <a href="{{ route('external-solutions.show', $solution->platform_id) }}" class="btn btn-sm btn-outline-info">View</a>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" class="text-center">No archived records found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>