<div class="table-responsive">
    <table class="table card-table table-vcenter text-nowrap datatable">
        <thead>
            <tr>
                <th>Platform Name</th>
                <th>Developed By</th>
                <th>Launched On</th>
                <th>Software Value</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($solutions as $solution)
            <tr>
                <td>{{ $solution->platform_name }}</td>
                <td>{{ $solution->developed_by }}</td>
                <td>{{ optional($solution->launched_date)->format('Y-m-d') ?? '-' }}</td>
                <td>{{ $solution->software_value ? number_format($solution->software_value, 2) : '-' }}</td>
                <td>
                    <a href="{{ route('external-solutions.edit', $solution->platform_id) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                    <a href="{{ route('external-solutions.show', $solution->platform_id) }}" class="btn btn-sm btn-outline-info">View</a>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="text-center">No operational solutions found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>