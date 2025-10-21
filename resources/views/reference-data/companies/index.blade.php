@extends('layouts.app')

@section('page-title', 'Companies/Customers')

@section('content')
<style>
    /* Page-scoped: dark table like other lists */
    .companies-page table thead th { color:#fff !important; background:transparent !important; }
    .companies-page table tbody td { color:#fff !important; }
    .companies-page .link-details { color:#0dcaf0 !important; } /* match Details color used elsewhere */
</style>
<div class="container companies-page">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <div>
            <div class="mt-2">
                <a href="{{ route('reference-data.companies.create') }}" class="btn btn-primary btn-sm">Create New</a>
            </div>
        </div>
        <div class="text-end">
            {{-- right-side Create New removed per design; left 'Create New' link is primary --}}
        </div>
    </div>
    <div class="row mb-2 align-items-center">
        <div class="col-md-6">
            <div class="d-flex align-items-center">
                <label class="me-2 small">Show</label>
                <form id="perPageForm" method="GET">
                    <input type="hidden" name="q" value="{{ $q }}" />
                    <select name="perPage" onchange="document.getElementById('perPageForm').submit()" class="form-select form-select-sm" style="width:80px; display:inline-block; color:#000;">
                        <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                        <option value="25" {{ $perPage == 25 ? 'selected' : '' }}>25</option>
                        <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                        <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100</option>
                    </select>
                    <label class="ms-2 small">entries</label>
                </form>
            </div>
        </div>
        <div class="col-md-6 text-end">
            <form method="GET" class="d-inline-block">
                <input type="hidden" name="perPage" value="{{ $perPage }}" />
                <label class="small me-2">Search:</label>
                <input type="text" name="q" value="{{ $q }}" class="form-control form-control-sm d-inline-block" style="width:200px; display:inline-block;" />
                <button class="btn btn-sm btn-secondary ms-2" type="submit">Go</button>
            </form>
        </div>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th style="width:70%">Company_Name</th>
                <th style="width:30%"></th>
            </tr>
        </thead>
        <tbody>
            @forelse($companies as $company)
                <tr>
                    <td style="min-height:150px; vertical-align:top">&nbsp;{{ $company->name }}</td>
                    <td class="align-top">
                        <div class="small">
                            <div><a href="{{ route('reference-data.companies.edit', $company) }}">Edit</a></div>
                            <div><a href="#" class="link-details">Details</a></div>
                            <div>
                                <form action="{{ route('reference-data.companies.destroy', $company) }}" method="POST" onsubmit="return confirm('Delete this company?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-link p-0 text-danger">Delete</button>
                                </form>
                            </div>
                            <div><a href="#">Customer Contacts</a></div>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="2">No companies found.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="d-flex justify-content-between align-items-center">
        <?php
            $from = ($companies->currentPage() - 1) * $companies->perPage() + 1;
            $to = min($companies->currentPage() * $companies->perPage(), $companies->total());
        ?>
    <div class="small text-muted">Showing {{ $from }} to {{ $to }} of {{ $companies->total() }} entries</div>
        <div>
            <?php $current = $companies->currentPage(); $last = $companies->lastPage(); ?>
            <nav aria-label="Page navigation">
                <ul class="pagination mb-0">
                    <li class="page-item {{ $current == 1 ? 'disabled' : '' }}"><a class="page-link" href="{{ $companies->url(max(1, $current - 1)) }}">Previous</a></li>
                    @for ($p = 1; $p <= min(4, $last); $p++)
                        <li class="page-item {{ $p == $current ? 'active' : '' }}"><a class="page-link" href="{{ $companies->url($p) }}">{{ $p }}</a></li>
                    @endfor
                    <li class="page-item {{ $current == $last ? 'disabled' : '' }}"><a class="page-link" href="{{ $companies->url(min($last, $current + 1)) }}">Next</a></li>
                </ul>
            </nav>
        </div>
    </div>
</div>
@endsection
