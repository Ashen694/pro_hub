<div class="table-responsive">
    <table class="table card-table table-vcenter text-nowrap datatable">
        <thead>
            <tr>
                <th>Application Name</th>
                <th>Developed By</th>
                <th>Launched Billed On</th>
                <th>OTC / MRC</th>
                <th>Contr. Period</th>
                <th>Revenue</th>
                <th>Billed</th>
                <th>Sales Team</th>
                <th>Proposal Uploaded</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($solutions as $solution)
            <tr>
                <td>{{ $solution->application_name }}</td>
                <td>{{ $solution->developed_by }}</td>
                <td>{{ optional($solution->launched_date)->format('Y-m-d') ?? '-' }}</td>
                <td>
                    @if($solution->one_time_charge || $solution->monthly_recurring_charge)
                        {{ number_format($solution->one_time_charge ?? 0, 2) }} / {{ number_format($solution->monthly_recurring_charge ?? 0, 2) }}
                    @else
                        -
                    @endif
                </td>
                <td>{{ $solution->contract_period_years ?? '-' }}</td>
                <td>{{ $solution->value_of_software ? number_format($solution->value_of_software, 2) : '-' }}</td>
                <td>{{ $solution->billed ? $solution->billed : '-' }}</td>
                <td>{{ $solution->sales_team_involved }}</td>
                <td>
                    @if(!empty($solution->proposal_uploaded))
                        Yes
                    @else
                        -
                    @endif
                </td>
                <td>
                    <div class="d-flex">
                        <a href="{{ route('external-solutions.edit', $solution->id) }}" class="btn btn-ghost-primary btn-sm" title="Edit">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg>
                        </a>
                        <a href="{{ route('external-solutions.show', $solution->id) }}" class="btn btn-ghost-info btn-sm ms-2" title="View">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2" /><rect x="9" y="3" width="6" height="4" rx="2" /><path d="M9 12v-1h6v1" /><path d="M12 11v6" /><path d="M11 17h2" /></svg>
                        </a>
                        <form action="{{ route('external-solutions.destroy', $solution->id) }}" method="POST" onsubmit="return confirm('Delete this solution?');" class="ms-2">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-ghost-secondary btn-sm" title="Delete">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="10" class="text-center">No records found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
