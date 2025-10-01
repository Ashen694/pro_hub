<div class="table-responsive">
    <table class="table card-table table-vcenter text-nowrap datatable">
        <thead>
            <tr>
                <th>Application Group</th>
                <th>Application Name</th>
                <th>Developed By</th>
                <th>SDLC Phase</th>
                <th>Start</th>
                <th>Target</th>
                <th>UD</th>
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
                <td>{{ $solution->sdlc_phase }}</td>
                <td>{{-- start_date goes here --}}</td>
                <td>{{-- target_date goes here --}}</td>
                <td>{{-- UD value goes here --}}</td>
                <td>{{ $solution->solution_value }}</td>
                <td>
                    <div class="d-flex">
                        <a href="#" class="btn btn-ghost-primary btn-sm" title="Edit">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg>
                        </a>
                        <a href="#" class="btn btn-ghost-info btn-sm" title="View Details">
                           <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2" /><rect x="9" y="3" width="6" height="4" rx="2" /><path d="M9 12v-1h6v1" /><path d="M12 11v6" /><path d="M11 17h2" /></svg>
                        </a>
                        <a href="#" class="btn btn-ghost-dark btn-sm" title="Documents">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 4h3l2 2h5a2 2 0 0 1 2 2v7a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-9a2 2 0 0 1 2 -2" /><path d="M17 17v2a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-9a2 2 0 0 1 2 -2h2" /></svg>
                        </a>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="9" class="text-center">No in-progress solutions found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>