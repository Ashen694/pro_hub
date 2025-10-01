@extends('layouts.app')

@section('page-title', 'Consumer Service Platforms')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Consumer Service Platforms</h3>
    </div>
    
    <!-- Filter Section -->
    <div class="card-body border-bottom py-3">
        <div class="d-flex">
            <div class="text-muted">
                Show
                <div class="mx-2 d-inline-block">
                    <select class="form-select form-select-sm">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50" selected>50</option>
                    </select>
                </div>
                entries
            </div>
            <div class="ms-auto text-muted">
                Search:
                <div class="ms-2 d-inline-block">
                    <input type="text" class="form-control form-control-sm" aria-label="Search...">
                </div>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table card-table table-vcenter text-nowrap datatable">
            <thead>
                <tr>
                    <th>Application Name</th>
                    <th>Developed By</th>
                    <th>Application End Users</th>
                    <th>Solution Value</th>
                    <th>SDLC Phase</th>
                    <th></th> <!-- For Details link -->
                </tr>
            </thead>
            <tbody>
                @forelse ($platforms as $platform)
                <tr>
                    <td>{{ $platform->application_name }}</td>
                    <td>{{ $platform->developed_by }}</td>
                    <td>{{ $platform->application_end_users }}</td>
                    <td>{{ $platform->solution_value }}</td>
                    <td>{{ $platform->sdlc_phase }}</td>
                    <td><a href="#">Details</a></td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">No consumer service platforms found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="card-footer d-flex align-items-center">
         <div class="ms-auto">
            {{ $platforms->links() }}
        </div>
    </div>
</div>
@endsection