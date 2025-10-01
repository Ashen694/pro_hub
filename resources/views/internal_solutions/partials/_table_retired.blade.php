{{-- resources/views/internal_solutions/partials/_table_retired.blade.php --}}
<div class="table-responsive">
    <table class="table card-table table-vcenter text-nowrap datatable">
        <thead>
            <tr>
                <th>Application Name</th>
                <th>Developed By</th>
                <th>Launched Date</th>
                <th>SDLC Phase</th>
                <th>Solution Value</th>
                <th>Comment</th>
                <th></th> <!-- For action icon -->
            </tr>
        </thead>
        <tbody>
             @forelse ($solutions as $solution)
            <tr>
                <td>{{ $solution->application_name }}</td>
                <td>{{ $solution->developed_by }}</td>
                <td>{{ $solution->launched_date }}</td>
                <td><span class="badge bg-secondary me-1"></span> {{ $solution->sdlc_phase }}</td>
                <td>{{ $solution->solution_value }}</td>
                <td>{{ $solution->comment }}</td>
                <td>
                    <a href="#" title="View Details">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 6l16 0" /><path d="M4 12l16 0" /><path d="M4 18l12 0" /></svg>
                    </a>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" class="text-center">No solutions found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>