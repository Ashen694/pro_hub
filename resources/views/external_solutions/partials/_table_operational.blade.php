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
                    {{-- Action Icons --}}
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="text-center">No solutions found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>