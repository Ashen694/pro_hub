{{-- resources/views/internal_solutions/partials/_table_operational.blade.php --}}
<div class="table-responsive">
    <table class="table card-table table-vcenter text-nowrap datatable">
        <thead>
            <tr>
                <th>Application Group</th>
                <th>Application Name</th>
                <th>Developed By</th>
                <th>VA Date</th>
                <th>Solution Value</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($solutions as $solution)
            <tr>
                <td>{{ $solution->application_group }}</td>
                <td>{{ $solution->application_name }}</td>
                <td>{{ $solution->developed_by }}</td>
                <td>{{ $solution->va_date }}</td>
                <td>{{ $solution->solution_value }}</td>
                <td class="text-end">
                    <a href="#" class="btn btn-sm btn-info">View</a>
                    <a href="#" class="btn btn-sm btn-primary">Edit</a>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="text-center">No solutions found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>