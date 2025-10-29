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
                        <a href="{{ route('external-solutions.edit', $solution->id) }}" class="btn btn-action btn-action-edit btn-icon-sm" title="Edit">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="16" height="16" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg>
                        </a>

                        <a href="{{ route('external-solutions.show', $solution->id) }}" class="btn btn-action btn-action-view btn-icon-sm ms-2" title="View">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="16" height="16" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="3" /><path d="M2 12s4 -8 10 -8 10 8 10 8 -4 8 -10 8 -10 -8 -10 -8z"/></svg>
                        </a>

                        <form action="{{ route('external-solutions.destroy', $solution->id) }}" method="POST" onsubmit="return confirm('Delete this solution?');" class="ms-2">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-action btn-action-delete btn-icon-sm" title="Delete">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="14" height="14" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="4" y1="7" x2="20" y2="7" /><line x1="10" y1="11" x2="10" y2="17" /><line x1="14" y1="11" x2="14" y2="17" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
                            </button>
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
