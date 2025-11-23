@extends('layouts.app')

@section('page-title', 'All Trainees')

@section('content')
<style>
    :root {
        --slt-primary: #667eea;
        --slt-primary-600: #5568d3;
        --slt-primary-700: #4c51bf;
        --slt-info: #764ba2;
        --slt-accent: #5fb545;
        --slt-white: #ffffff;
        --slt-ink: #0c1b2a;
        --slt-muted: #6b7a8a;
        --slt-border: #e6eef8;
        --slt-shadow: 0 12px 26px rgba(0, 0, 0, .10);
        --slt-focus: 0 0 0 .25rem rgba(102, 126, 234, .25);
        --slt-radius-lg: 16px;
        --slt-radius-md: 12px;
    }

    

    

    .slt-bg-wrap::after {
        content: "";
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.2);
        pointer-events: none;
        z-index: -1;
    }

    .slt-container {
        position: relative;
        z-index: 10;
    }

    .page-header-trainee {
        background: rgba(255, 255, 255, 0.98);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(102, 126, 234, 0.15);
        border-radius: 20px;
        padding: 35px;
        margin-bottom: 30px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
    }

    .page-title-trainee {
        font-size: 36px;
        font-weight: 800;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin: 0;
        letter-spacing: -0.3px;
    }

    .btn-gradient {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        color: white;
        font-weight: 700;
        padding: 12px 30px;
        border-radius: 12px;
        transition: all 0.3s;
        box-shadow: 0 10px 24px rgba(102, 126, 234, 0.4);
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-gradient:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 30px rgba(102, 126, 234, 0.6);
        color: white;
        filter: brightness(1.05);
    }

    .btn-gradient:active {
        transform: translateY(-1px);
    }

    .filter-card {
        background: rgba(255, 255, 255, 0.98);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(102, 126, 234, 0.15);
        border-radius: 20px;
        padding: 25px;
        margin-bottom: 30px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
        border: none;
    }

    .nav-pills-custom {
        background: #f8f9fa;
        padding: 8px;
        border-radius: 12px;
        display: inline-flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    .nav-pills-custom .nav-link {
        border-radius: 10px;
        padding: 12px 24px;
        font-weight: 700;
        color: #1e293b !important;
        transition: all 0.3s;
        border: none;
        text-decoration: none !important;
    }

    .nav-pills-custom .nav-link.active {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
    }

    .nav-pills-custom .nav-link:hover:not(.active) {
        background: #e2e8f0;
        color: #334155;
    }

    .form-select-custom {
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        padding: 8px 16px;
        font-weight: 600;
        width: auto;
        background: white;
        transition: all 0.2s;
    }

    .form-select-custom:focus {
        border-color: #667eea;
        outline: none;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .search-input-custom {
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        padding: 10px 20px;
        transition: all 0.3s;
        background: white;
        min-width: 250px;
    }

    .search-input-custom:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        outline: none;
    }

    .table-card {
        background: rgba(255, 255, 255, 0.98);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(102, 126, 234, 0.15);
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
        border: none;
    }

    .slt-table-container {
        background: rgba(255, 255, 255, 0.78);
        backdrop-filter: blur(4px);
        -webkit-backdrop-filter: blur(4px);
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .table-card .table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        margin-bottom: 0;
        min-width: 1200px;
    }

    .table-card .table thead {
        background: linear-gradient(0deg, rgba(242, 247, 255, 0.92), rgba(249, 251, 255, 0.92));
    }

    .table-card .table thead th {
        color: #334155;
        font-weight: 800;
        text-transform: uppercase;
        font-size: 12px;
        letter-spacing: 0.5px;
        padding: 20px;
        border: none;
        border-bottom: 1px solid rgba(102, 126, 234, 0.18);
    }

    .table-card .table tbody tr {
        transition: all 0.15s ease;
        border-bottom: 1px solid #f1f5f9;
        background: transparent;
    }

    .table-card .table tbody tr:hover {
        background: linear-gradient(90deg, rgba(102, 126, 234, .05), rgba(118, 75, 162, .05));
    }

    .table-card .table tbody td {
        padding: 20px;
        vertical-align: middle;
        border: none;
        color: #1f2937;
    }

    .trainee-id {
        font-weight: 700;
        color: #667eea;
        font-size: 15px;
    }

    .contact-phone {
        font-weight: 600;
        color: #334155;
    }

    .text-muted-custom {
        color: #94a3b8;
        font-size: 13px;
    }

    .date-badge {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.15) 0%, rgba(118, 75, 162, 0.15) 100%);
        padding: 8px 14px;
        border-radius: 10px;
        font-weight: 600;
        color: #667eea;
        font-size: 13px;
        display: inline-block;
    }

    .btn-action {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        border: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s;
        font-size: 16px;
        cursor: pointer;
    }

    .btn-action-edit {
        background: #dbeafe;
        color: #3b82f6;
    }

    .btn-action-edit:hover {
        background: #3b82f6;
        color: white;
        transform: translateY(-3px);
        box-shadow: 0 8px 16px rgba(59, 130, 246, 0.3);
    }

    .btn-action-view {
        background: #dcfce7;
        color: #22c55e;
    }

    .btn-action-view:hover {
        background: #22c55e;
        color: white;
        transform: translateY(-3px);
        box-shadow: 0 8px 16px rgba(34, 197, 94, 0.3);
    }

    .btn-action-delete {
        background: #fee2e2;
        color: #ef4444;
    }

    .btn-action-delete:hover {
        background: #ef4444;
        color: white;
        transform: translateY(-3px);
        box-shadow: 0 8px 16px rgba(239, 68, 68, 0.3);
    }

    .export-btn {
        background: white;
        border: 2px solid #e2e8f0;
        color: #667eea;
        font-weight: 700;
        padding: 10px 24px;
        border-radius: 12px;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .export-btn:hover {
        background: #667eea;
        color: white;
        border-color: #667eea;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
    }

    .pagination-card {
        background: rgba(255, 255, 255, 0.98);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(102, 126, 234, 0.15);
        border-radius: 20px;
        border: none;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
        margin-top: 1.5rem;
    }

    .pagination {
        margin-bottom: 0;
    }

    .page-link {
        border-radius: 10px !important;
        border: 1px solid rgba(102, 126, 234, 0.2);
        color: #667eea;
        font-weight: 600;
        margin: 0 3px;
        transition: all 0.2s;
    }

    .page-link:hover {
        background: #f8fafc;
        border-color: #667eea;
        color: #667eea;
    }

    .page-item.active .page-link {
        background: linear-gradient(90deg, #667eea, #764ba2);
        border-color: transparent;
        color: white;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
    }

    .slt-empty-state {
        padding: 3rem 1.5rem;
        text-align: center;
        color: var(--slt-muted);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .slt-bg-wrap {
            padding: 32px 16px;
        }

        .page-title-trainee {
            font-size: 28px;
        }

        .page-header-trainee {
            padding: 25px;
        }

        .filter-card {
            padding: 20px;
        }

        .nav-pills-custom .nav-link {
            padding: 10px 18px;
            font-size: 14px;
        }

        .search-input-custom {
            min-width: 200px;
        }

        .table-card .table {
            min-width: 1000px;
            font-size: 14px;
        }

        .table-card .table thead th,
        .table-card .table tbody td {
            padding: 15px;
        }
    }

    @media (max-width: 640px) {
        .slt-bg-wrap {
            padding: 24px 12px;
        }

        .page-title-trainee {
            font-size: 24px;
        }

        .page-header-trainee {
            padding: 20px;
        }

        .page-header-trainee .d-flex {
            flex-direction: column;
            gap: 1rem;
            align-items: stretch !important;
        }

        .btn-gradient {
            width: 100%;
            justify-content: center;
        }

        .filter-card .d-flex {
            flex-direction: column;
            align-items: stretch !important;
        }

        .nav-pills-custom {
            width: 100%;
            flex-direction: column;
        }

        .nav-pills-custom .nav-link {
            width: 100%;
            text-align: center;
        }

        .search-input-custom {
            width: 100%;
            min-width: unset;
        }

        .d-flex.align-items-center.text-muted {
            width: 100%;
            justify-content: space-between;
        }

        .ms-auto {
            margin-left: 0 !important;
            width: 100%;
        }

        .pagination-card .card-body > .d-flex {
            flex-direction: column;
            gap: 1rem;
            align-items: stretch !important;
        }

        .export-btn {
            width: 100%;
            justify-content: center;
        }

        .pagination {
            justify-content: center;
        }
    }
</style>

 

<div class="slt-bg-wrap">
    <div class="slt-container py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Page Header -->
        <div class="page-header-trainee">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="page-title-trainee">All Trainees</h1>
                <button class="btn btn-gradient" data-bs-toggle="modal" data-bs-target="#createTraineeModal">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                    Create New
                </button>
            </div>
        </div>

        <!-- Export Section -->
        <div class="card filter-card mb-4">
            <div class="d-flex flex-wrap align-items-center justify-content-center gap-3">
                <a href="{{ route('trainees.all.export') }}" class="btn export-btn">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                        <line x1="16" y1="13" x2="8" y2="13"></line>
                        <line x1="16" y1="17" x2="8" y2="17"></line>
                        <line x1="10" y1="9" x2="8" y2="9"></line>
                    </svg>
                    Export All Trainees
                </a>
                <a href="{{ route('trainees.inactive.export') }}" class="btn export-btn">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                        <line x1="16" y1="13" x2="8" y2="13"></line>
                        <line x1="16" y1="17" x2="8" y2="17"></line>
                        <line x1="10" y1="9" x2="8" y2="9"></line>
                    </svg>
                    Export Inactive Trainees
                </a>
                <a href="{{ route('trainees.terminated.export') }}" class="btn export-btn">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                        <line x1="16" y1="13" x2="8" y2="13"></line>
                        <line x1="16" y1="17" x2="8" y2="17"></line>
                        <line x1="10" y1="9" x2="8" y2="9"></line>
                    </svg>
                    Export Terminated Trainees
                </a>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="card filter-card">
            <div class="d-flex flex-wrap align-items-center gap-3">
                <!-- Status Tabs -->
                <ul class="nav nav-pills nav-pills-custom mb-0">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ url('/trainees/active') }}">Active Trainees</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/trainees/inactive') }}">Inactive Trainees</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/trainees/paid') }}">Paid Trainees</a>
                    </li>
                </ul>

                <!-- Show Entries -->
                <div class="d-flex align-items-center text-muted ms-3">
                    <span class="me-2">Show:</span>
                    <select id="entriesPerPage" class="form-select form-select-custom">
                        <option value="15" selected>15</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                    <span class="ms-2">entries</span>
                </div>

                <!-- Search -->
                <div class="ms-auto d-flex align-items-center">
                    <span class="text-muted me-2">Search:</span>
                    <input type="text" id="searchInput" class="form-control search-input-custom" placeholder="Search trainees...">
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="card table-card">
            <div class="slt-table-container">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Trainees ID</th>
                            <th>Name</th>
                            <th>Mobile/Email/City</th>
                            <th>NIC</th>
                            <th>Training Starts</th>
                            <th>Training Ends</th>
                            <th>Institute</th>
                            <th>Field of Specialisation/Supervisor</th>
                            <th>Terminated Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($trainees as $trainee)
                        <tr data-trainee-id="{{ $trainee->Trainee_ID }}" data-trainee-name="{{ $trainee->Trainee_Name }}">
                            <td><span class="trainee-id">T{{ str_pad($trainee->Trainee_ID, 6, '0', STR_PAD_LEFT) }}</span></td>
                            <td><strong>{{ $trainee->Trainee_Name }}</strong></td>
                            <td>
                                <div class="contact-phone">{{ $trainee->Trainee_Phone ?? '-' }}</div>
                                <div class="text-muted-custom">{{ $trainee->Trainee_Email ?? '-' }}</div>
                                <div class="text-muted-custom">{{ $trainee->Trainee_HomeAddress ?? '-' }}</div>
                            </td>
                            <td>{{ $trainee->Trainee_NIC ?? '-' }}</td>
                            <td><span class="date-badge">{{ $trainee->Training_StartDate ? $trainee->Training_StartDate->format('Y-m-d') : '-' }}</span></td>
                            <td><span class="date-badge">{{ $trainee->Training_EndDate ? $trainee->Training_EndDate->format('Y-m-d') : '-' }}</span></td>
                            <td>{{ $trainee->Institute ?? '-' }}</td>
                            <td>
                                <div><strong>{{ $trainee->field_of_specialization ?? '-' }}</strong></div>
                                <div class="text-muted-custom">{{ $trainee->Supervisor ?? '-' }}</div>
                            </td>
                            <td><span class="date-badge">{{ $trainee->terminated_date ? $trainee->terminated_date->format('Y-m-d') : '-' }}</span></td>
                            <td>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-action btn-action-edit" title="Edit">
                                        <i class="ti ti-pencil"></i>
                                    </button>
                                    <button class="btn btn-action btn-action-view" title="View">
                                        <i class="ti ti-eye"></i>
                                    </button>
                                    <button class="btn btn-action btn-action-delete" title="Delete">
                                        <i class="ti ti-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="text-center py-4">
                                <p class="text-muted">No active trainees found.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="card pagination-card">
            <div class="card-body">
                <div class="d-flex justify-content-center align-items-center gap-3">
                    <span class="text-muted">Showing 1 to 5 of 100 entries</span>
                    <nav>
                        <ul class="pagination mb-0">
                            <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#">...</a></li>
                            <li class="page-item"><a class="page-link" href="#">20</a></li>
                            <li class="page-item"><a class="page-link" href="#">Next</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- View Trainee Modal -->
<div class="modal fade" id="viewTraineeModal" tabindex="-1" aria-labelledby="viewTraineeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" style="border-radius: 20px; border: none; box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);">
            <div class="modal-header" style="border-bottom: 1px solid #e6eef8; padding: 25px 30px;">
                <h5 class="modal-title" id="viewTraineeModalLabel" style="font-size: 24px; font-weight: 700; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                    <i class="ti ti-eye" style="margin-right: 10px;"></i>View Trainee Details
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="padding: 30px;">
                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label" style="font-weight: 700; color: #667eea; font-size: 12px; text-transform: uppercase;">Trainee ID</label>
                        <p id="view_traineeId" style="font-size: 16px; font-weight: 600; color: #334155;"></p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" style="font-weight: 700; color: #667eea; font-size: 12px; text-transform: uppercase;">Name</label>
                        <p id="view_name" style="font-size: 16px; font-weight: 600; color: #334155;"></p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" style="font-weight: 700; color: #667eea; font-size: 12px; text-transform: uppercase;">Mobile</label>
                        <p id="view_mobile" style="font-size: 16px; color: #334155;"></p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" style="font-weight: 700; color: #667eea; font-size: 12px; text-transform: uppercase;">Email</label>
                        <p id="view_email" style="font-size: 16px; color: #334155;"></p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" style="font-weight: 700; color: #667eea; font-size: 12px; text-transform: uppercase;">NIC</label>
                        <p id="view_nic" style="font-size: 16px; color: #334155;"></p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" style="font-weight: 700; color: #667eea; font-size: 12px; text-transform: uppercase;">City</label>
                        <p id="view_city" style="font-size: 16px; color: #334155;"></p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" style="font-weight: 700; color: #667eea; font-size: 12px; text-transform: uppercase;">Training Start Date</label>
                        <p id="view_startDate" style="font-size: 16px; color: #334155;"></p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" style="font-weight: 700; color: #667eea; font-size: 12px; text-transform: uppercase;">Training End Date</label>
                        <p id="view_endDate" style="font-size: 16px; color: #334155;"></p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" style="font-weight: 700; color: #667eea; font-size: 12px; text-transform: uppercase;">Institute</label>
                        <p id="view_institute" style="font-size: 16px; color: #334155;"></p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" style="font-weight: 700; color: #667eea; font-size: 12px; text-transform: uppercase;">Language Known</label>
                        <p id="view_language" style="font-size: 16px; color: #334155;"></p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" style="font-weight: 700; color: #667eea; font-size: 12px; text-transform: uppercase;">Field of Specialisation</label>
                        <p id="view_specialization" style="font-size: 16px; color: #334155;"></p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" style="font-weight: 700; color: #667eea; font-size: 12px; text-transform: uppercase;">Supervisor</label>
                        <p id="view_supervisor" style="font-size: 16px; color: #334155;"></p>
                    </div>
                    <div class="col-12">
                        <label class="form-label" style="font-weight: 700; color: #667eea; font-size: 12px; text-transform: uppercase;">Assigned Work</label>
                        <p id="view_assignedWork" style="font-size: 16px; color: #334155;"></p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" style="font-weight: 700; color: #667eea; font-size: 12px; text-transform: uppercase;">Target Date</label>
                        <p id="view_targetDate" style="font-size: 16px; color: #334155;"></p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" style="font-weight: 700; color: #667eea; font-size: 12px; text-transform: uppercase;">Payment start date</label>
                        <p id="view_paymentStartDate" style="font-size: 16px; color: #334155;"></p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" style="font-weight: 700; color: #667eea; font-size: 12px; text-transform: uppercase;">Payment end date</label>
                        <p id="view_paymentEndDate" style="font-size: 16px; color: #334155;"></p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" style="font-weight: 700; color: #667eea; font-size: 12px; text-transform: uppercase;">Terminated Date</label>
                        <p id="view_terminatedDate" style="font-size: 16px; color: #334155;"></p>
                    </div>
                    <div class="col-12">
                        <label class="form-label" style="font-weight: 700; color: #667eea; font-size: 12px; text-transform: uppercase;">Terminated Reason</label>
                        <p id="view_terminatedReason" style="font-size: 16px; color: #334155;"></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="border-top: 1px solid #e6eef8; padding: 20px 30px;">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: 10px; padding: 10px 24px;">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Trainee Modal -->
<div class="modal fade" id="editTraineeModal" tabindex="-1" aria-labelledby="editTraineeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" style="border-radius: 20px; border: none; box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);">
            <div class="modal-header" style="border-bottom: 1px solid #e6eef8; padding: 25px 30px;">
                <h5 class="modal-title" id="editTraineeModalLabel" style="font-size: 24px; font-weight: 700; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                    <i class="ti ti-edit" style="margin-right: 10px;"></i>Edit Trainee
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="padding: 30px;">
                <form id="editTraineeForm">
                    <input type="hidden" id="edit_rowIndex">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="edit_name" class="form-label" style="font-weight: 600; color: #334155;">Name</label>
                            <input type="text" class="form-control" id="edit_name" readonly style="border: 2px solid #e2e8f0; border-radius: 10px; padding: 10px 15px; background-color: #f8f9fa;">
                        </div>
                        <div class="col-md-6">
                            <label for="edit_mobile" class="form-label" style="font-weight: 600; color: #334155;">Mobile</label>
                            <input type="tel" class="form-control" id="edit_mobile" readonly style="border: 2px solid #e2e8f0; border-radius: 10px; padding: 10px 15px; background-color: #f8f9fa;">
                        </div>
                        <div class="col-md-6">
                            <label for="edit_nic" class="form-label" style="font-weight: 600; color: #334155;">NIC</label>
                            <input type="text" class="form-control" id="edit_nic" readonly style="border: 2px solid #e2e8f0; border-radius: 10px; padding: 10px 15px; background-color: #f8f9fa;">
                        </div>
                        <div class="col-md-6">
                            <label for="edit_email" class="form-label" style="font-weight: 600; color: #334155;">Email</label>
                            <input type="email" class="form-control" id="edit_email" readonly style="border: 2px solid #e2e8f0; border-radius: 10px; padding: 10px 15px; background-color: #f8f9fa;">
                        </div>
                        <div class="col-12">
                            <label for="edit_address" class="form-label" style="font-weight: 600; color: #334155;">Home Address/City</label>
                            <input type="text" class="form-control" id="edit_address" readonly style="border: 2px solid #e2e8f0; border-radius: 10px; padding: 10px 15px; background-color: #f8f9fa;">
                        </div>
                        <div class="col-md-6">
                            <label for="edit_startDate" class="form-label" style="font-weight: 600; color: #334155;">Training Start Date</label>
                            <input type="date" class="form-control" id="edit_startDate" style="border: 2px solid #e2e8f0; border-radius: 10px; padding: 10px 15px;">
                        </div>
                        <div class="col-md-6">
                            <label for="edit_endDate" class="form-label" style="font-weight: 600; color: #334155;">Training End Date</label>
                            <input type="date" class="form-control" id="edit_endDate" style="border: 2px solid #e2e8f0; border-radius: 10px; padding: 10px 15px;">
                        </div>
                        <div class="col-md-6">
                            <label for="edit_institute" class="form-label" style="font-weight: 600; color: #334155;">Institute</label>
                            <input type="text" class="form-control" id="edit_institute" readonly style="border: 2px solid #e2e8f0; border-radius: 10px; padding: 10px 15px; background-color: #f8f9fa;">
                        </div>
                        <div class="col-md-6">
                            <label for="edit_language" class="form-label" style="font-weight: 600; color: #334155;">Language Known</label>
                            <input type="text" class="form-control" id="edit_language" readonly style="border: 2px solid #e2e8f0; border-radius: 10px; padding: 10px 15px; background-color: #f8f9fa;">
                        </div>
                        <div class="col-md-6">
                            <label for="edit_specialization" class="form-label" style="font-weight: 600; color: #334155;">Field of Specialisation</label>
                            <input type="text" class="form-control" id="edit_specialization" style="border: 2px solid #e2e8f0; border-radius: 10px; padding: 10px 15px;">
                        </div>
                        <div class="col-md-6">
                            <label for="edit_supervisor" class="form-label" style="font-weight: 600; color: #334155;">Supervisor</label>
                            <input type="text" class="form-control" id="edit_supervisor" readonly style="border: 2px solid #e2e8f0; border-radius: 10px; padding: 10px 15px; background-color: #f8f9fa;">
                        </div>
                        <div class="col-12">
                            <label for="edit_assignedWork" class="form-label" style="font-weight: 600; color: #334155;">Assigned Work</label>
                            <textarea class="form-control" id="edit_assignedWork" rows="2" readonly style="border: 2px solid #e2e8f0; border-radius: 10px; padding: 10px 15px; background-color: #f8f9fa;"></textarea>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_requestedPaymentDate" class="form-label" style="font-weight: 600; color: #334155;">Requested payment date</label>
                            <input type="date" class="form-control" id="edit_requestedPaymentDate" style="border: 2px solid #e2e8f0; border-radius: 10px; padding: 10px 15px;">
                        </div>
                        <div class="col-md-6">
                            <label for="edit_paymentStartDate" class="form-label" style="font-weight: 600; color: #334155;">Payment start date</label>
                            <input type="date" class="form-control" id="edit_paymentStartDate" style="border: 2px solid #e2e8f0; border-radius: 10px; padding: 10px 15px;">
                        </div>
                        <div class="col-md-6">
                            <label for="edit_paymentEndDate" class="form-label" style="font-weight: 600; color: #334155;">Payment end date</label>
                            <input type="date" class="form-control" id="edit_paymentEndDate" style="border: 2px solid #e2e8f0; border-radius: 10px; padding: 10px 15px;">
                        </div>
                        <div class="col-md-6">
                            <label for="edit_absentCount" class="form-label" style="font-weight: 600; color: #334155;">Absent Count</label>
                            <input type="number" class="form-control" id="edit_absentCount" min="0" style="border: 2px solid #e2e8f0; border-radius: 10px; padding: 10px 15px;">
                        </div>
                        <div class="col-md-6">
                            <label for="edit_terminatedDate" class="form-label" style="font-weight: 600; color: #334155;">Terminated Date</label>
                            <input type="date" class="form-control" id="edit_terminatedDate" style="border: 2px solid #e2e8f0; border-radius: 10px; padding: 10px 15px;">
                        </div>
                        <div class="col-12">
                            <label for="edit_terminatedReason" class="form-label" style="font-weight: 600; color: #334155;">Terminated Reason</label>
                            <textarea class="form-control" id="edit_terminatedReason" rows="2" style="border: 2px solid #e2e8f0; border-radius: 10px; padding: 10px 15px;"></textarea>
                        </div>
                    </div>
                    <div class="mt-4 text-center">
                        <button type="submit" class="btn btn-gradient" style="padding: 12px 40px; font-size: 16px;">
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteTraineeModal" tabindex="-1" aria-labelledby="deleteTraineeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 20px; border: none; box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);">
            <div class="modal-header" style="border-bottom: 1px solid #e6eef8; padding: 25px 30px;">
                <h5 class="modal-title" id="deleteTraineeModalLabel" style="font-size: 24px; font-weight: 700; color: #ef4444;">
                    <i class="ti ti-trash" style="margin-right: 10px;"></i>Delete Trainee
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="padding: 30px;">
                <div class="text-center">
                    <div style="width: 80px; height: 80px; background: #fee2e2; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                        <i class="ti ti-alert-triangle" style="font-size: 40px; color: #ef4444;"></i>
                    </div>
                    <h5 style="font-weight: 700; color: #334155; margin-bottom: 10px;">Are you sure?</h5>
                    <p style="color: #64748b;">Do you really want to delete this trainee? This action cannot be undone.</p>
                    <p id="delete_traineeName" style="font-weight: 700; color: #667eea; font-size: 18px; margin-top: 15px;"></p>
                </div>
            </div>
            <div class="modal-footer" style="border-top: 1px solid #e6eef8; padding: 20px 30px; justify-content: center;">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: 10px; padding: 10px 24px;">Cancel</button>
                <button type="button" class="btn" id="confirmDeleteBtn" style="background: #ef4444; color: white; border-radius: 10px; padding: 10px 24px; font-weight: 600;">Delete</button>
            </div>
        </div>
    </div>
</div>

<!-- Create Trainee Modal -->
<div class="modal fade" id="createTraineeModal" tabindex="-1" aria-labelledby="createTraineeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" style="border-radius: 20px; border: none; box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);">
            <div class="modal-header" style="border-bottom: 1px solid #e6eef8; padding: 25px 30px;">
                <h5 class="modal-title" id="createTraineeModalLabel" style="font-size: 24px; font-weight: 700; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                    <i class="ti ti-user-plus" style="margin-right: 10px;"></i>Create Trainee
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="padding: 30px;">
                <form id="createTraineeForm">
                    <div class="row g-3">
                        <!-- Name -->
                        <div class="col-md-6">
                            <label for="traineeName" class="form-label" style="font-weight: 600; color: #334155;">Name</label>
                            <input type="text" class="form-control" id="traineeName" required pattern="[A-Za-z\s]+" title="Name should contain only letters and spaces" style="border: 2px solid #e2e8f0; border-radius: 10px; padding: 10px 15px;">
                            <div class="invalid-feedback">Name should contain only letters and spaces</div>
                        </div>

                        <!-- Mobile -->
                        <div class="col-md-6">
                            <label for="traineeMobile" class="form-label" style="font-weight: 600; color: #334155;">Mobile</label>
                            <input type="tel" class="form-control" id="traineeMobile" required pattern="0[0-9]{9}" maxlength="10" title="Mobile number must be 10 digits starting with 0" placeholder="0771234567" style="border: 2px solid #e2e8f0; border-radius: 10px; padding: 10px 15px;">
                            <div class="invalid-feedback">Mobile number must be 10 digits starting with 0</div>
                        </div>

                        <!-- NIC -->
                        <div class="col-md-6">
                            <label for="traineeNIC" class="form-label" style="font-weight: 600; color: #334155;">NIC</label>
                            <input type="text" class="form-control" id="traineeNIC" required style="border: 2px solid #e2e8f0; border-radius: 10px; padding: 10px 15px;">
                        </div>

                        <!-- Email -->
                        <div class="col-md-6">
                            <label for="traineeEmail" class="form-label" style="font-weight: 600; color: #334155;">Email</label>
                            <input type="email" class="form-control" id="traineeEmail" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" title="Please enter a valid email address" placeholder="example@email.com" style="border: 2px solid #e2e8f0; border-radius: 10px; padding: 10px 15px;">
                            <div class="invalid-feedback">Please enter a valid email address with @</div>
                        </div>

                        <!-- Home Address/City -->
                        <div class="col-12">
                            <label for="traineeAddress" class="form-label" style="font-weight: 600; color: #334155;">Home Address/City</label>
                            <input type="text" class="form-control" id="traineeAddress" required style="border: 2px solid #e2e8f0; border-radius: 10px; padding: 10px 15px;">
                        </div>

                        <!-- Training Start Date -->
                        <div class="col-md-6">
                            <label for="trainingStartDate" class="form-label" style="font-weight: 600; color: #334155;">Training Start Date</label>
                            <input type="date" class="form-control" id="trainingStartDate" required style="border: 2px solid #e2e8f0; border-radius: 10px; padding: 10px 15px;">
                        </div>

                        <!-- Training End Date -->
                        <div class="col-md-6">
                            <label for="trainingEndDate" class="form-label" style="font-weight: 600; color: #334155;">Training End Date</label>
                            <input type="date" class="form-control" id="trainingEndDate" required style="border: 2px solid #e2e8f0; border-radius: 10px; padding: 10px 15px;">
                        </div>

                        <!-- Institute -->
                        <div class="col-md-6">
                            <label for="traineeInstitute" class="form-label" style="font-weight: 600; color: #334155;">Institute</label>
                            <input type="text" class="form-control" id="traineeInstitute" required style="border: 2px solid #e2e8f0; border-radius: 10px; padding: 10px 15px;">
                        </div>

                        <!-- Language Known -->
                        <div class="col-md-6">
                            <label for="traineeLanguage" class="form-label" style="font-weight: 600; color: #334155;">Language Known</label>
                            <select class="form-select" id="traineeLanguage" required style="border: 2px solid #e2e8f0; border-radius: 10px; padding: 10px 15px;">
                                <option value="">Select Language</option>
                                <option value="Java">Java</option>
                                <option value="Python">Python</option>
                                <option value="JavaScript">JavaScript</option>
                                <option value="C++">C++</option>
                                <option value="PHP">PHP</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>

                        <!-- Field of Specialization -->
                        <div class="col-md-6">
                            <label for="traineeSpecialization" class="form-label" style="font-weight: 600; color: #334155;">Field of Specialization</label>
                            <select class="form-select" id="traineeSpecialization" required style="border: 2px solid #e2e8f0; border-radius: 10px; padding: 10px 15px;">
                                <option value="">Select Specialization</option>
                                <option value="Software Engineering">Software Engineering</option>
                                <option value="Data Science">Data Science</option>
                                <option value="Web Development">Web Development</option>
                                <option value="Mobile App Dev">Mobile App Dev</option>
                                <option value="Cybersecurity">Cybersecurity</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>

                        <!-- Supervisor -->
                        <div class="col-md-6">
                            <label for="traineeSupervisor" class="form-label" style="font-weight: 600; color: #334155;">Supervisor</label>
                            <input type="text" class="form-control" id="traineeSupervisor" required pattern="[A-Za-z\s]+" title="Supervisor name should contain only letters and spaces" style="border: 2px solid #e2e8f0; border-radius: 10px; padding: 10px 15px;">
                            <div class="invalid-feedback">Supervisor name should contain only letters and spaces</div>
                        </div>

                        <!-- Assigned Work -->
                        <div class="col-12">
                            <label for="traineeWork" class="form-label" style="font-weight: 600; color: #334155;">Assigned Work</label>
                            <textarea class="form-control" id="traineeWork" rows="3" style="border: 2px solid #e2e8f0; border-radius: 10px; padding: 10px 15px;"></textarea>
                        </div>

                        <!-- Target Date -->
                        <div class="col-md-6">
                            <label for="traineeTargetDate" class="form-label" style="font-weight: 600; color: #334155;">Target Date</label>
                            <input type="date" class="form-control" id="traineeTargetDate" style="border: 2px solid #e2e8f0; border-radius: 10px; padding: 10px 15px;">
                        </div>
                    </div>

                    <div class="mt-4 text-center">
                        <button type="submit" class="btn btn-gradient" style="padding: 12px 40px; font-size: 16px;">
                            Create
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>

    // Search functionality
    const searchInput = document.getElementById('searchInput');
    const tableBody = document.querySelector('.table tbody');
    const allRows = Array.from(tableBody.querySelectorAll('tr'));
    let filteredRows = [...allRows];

    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase().trim();
        
        filteredRows = allRows.filter(row => {
            const text = row.textContent.toLowerCase();
            return text.includes(searchTerm);
        });
        
        updateTable();
    });

    // Pagination functionality
    const entriesSelect = document.getElementById('entriesPerPage');
    let currentPage = 1;
    let entriesPerPage = parseInt(entriesSelect.value);

    entriesSelect.addEventListener('change', function() {
        entriesPerPage = parseInt(this.value);
        currentPage = 1;
        updateTable();
    });

    function updateTable() {
        // Hide all rows first
        allRows.forEach(row => row.style.display = 'none');
        
        // Calculate pagination
        const startIndex = (currentPage - 1) * entriesPerPage;
        const endIndex = startIndex + entriesPerPage;
        
        // Show only filtered and paginated rows
        filteredRows.slice(startIndex, endIndex).forEach(row => {
            row.style.display = '';
        });
        
        // Show "no results" message if needed
        if (filteredRows.length === 0) {
            if (!document.getElementById('noResultsRow')) {
                const noResultsRow = document.createElement('tr');
                noResultsRow.id = 'noResultsRow';
                noResultsRow.innerHTML = '<td colspan="10" class="text-center py-4 text-muted">No trainees found</td>';
                tableBody.appendChild(noResultsRow);
            }
        } else {
            const noResultsRow = document.getElementById('noResultsRow');
            if (noResultsRow) {
                noResultsRow.remove();
            }
        }
    }

    // Initial table setup
    updateTable();

    // Form Validation - Real-time feedback
    const traineeNameInput = document.getElementById('traineeName');
    const traineeMobileInput = document.getElementById('traineeMobile');
    const traineeEmailInput = document.getElementById('traineeEmail');
    const traineeSupervisorInput = document.getElementById('traineeSupervisor');

    // Name validation - only letters and spaces
    traineeNameInput.addEventListener('input', function(e) {
        const value = this.value;
        // Remove any non-letter characters except spaces
        this.value = value.replace(/[^A-Za-z\s]/g, '');
        
        if (this.value !== value) {
            this.classList.add('is-invalid');
            setTimeout(() => this.classList.remove('is-invalid'), 2000);
        }
    });

    // Supervisor validation - only letters and spaces
    traineeSupervisorInput.addEventListener('input', function(e) {
        const value = this.value;
        // Remove any non-letter characters except spaces
        this.value = value.replace(/[^A-Za-z\s]/g, '');
        
        if (this.value !== value) {
            this.classList.add('is-invalid');
            setTimeout(() => this.classList.remove('is-invalid'), 2000);
        }
    });

    // Mobile validation - only numbers, max 10 digits, must start with 0
    traineeMobileInput.addEventListener('input', function(e) {
        let value = this.value;
        // Remove any non-digit characters
        value = value.replace(/\D/g, '');
        
        // Limit to 10 digits
        if (value.length > 10) {
            value = value.slice(0, 10);
        }
        
        // Ensure it starts with 0
        if (value.length > 0 && value[0] !== '0') {
            value = '0' + value.slice(0, 9);
        }
        
        this.value = value;
        
        // Visual feedback
        if (value.length > 0 && value.length < 10) {
            this.style.borderColor = '#f59e0b';
        } else if (value.length === 10) {
            this.style.borderColor = '#10b981';
        } else {
            this.style.borderColor = '#e2e8f0';
        }
    });

    // Email validation - check for @
    traineeEmailInput.addEventListener('blur', function() {
        if (this.value && !this.value.includes('@')) {
            this.classList.add('is-invalid');
            this.setCustomValidity('Email must contain @');
        } else {
            this.classList.remove('is-invalid');
            this.setCustomValidity('');
        }
    });

    // Form submission validation
    document.getElementById('createTraineeForm').addEventListener('submit', function(e) {
        const mobile = traineeMobileInput.value;
        
        // Final mobile validation
        if (mobile.length !== 10) {
            e.preventDefault();
            traineeMobileInput.classList.add('is-invalid');
            alert('Mobile number must be exactly 10 digits');
            return false;
        }
        
        if (mobile[0] !== '0') {
            e.preventDefault();
            traineeMobileInput.classList.add('is-invalid');
            alert('Mobile number must start with 0');
            return false;
        }
    });

    // Create Form Logic - Check for past training end date
    const createEndDateInput = document.getElementById('traineeEndDate');
    if (createEndDateInput) {
        createEndDateInput.addEventListener('change', function() {
            const endDate = new Date(this.value);
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            
            if (endDate <= today) {
                this.style.borderColor = '#f59e0b';
                
                // Show notification
                const notification = document.createElement('div');
                notification.style.cssText = 'position: fixed; top: 20px; right: 20px; background: #f59e0b; color: white; padding: 15px 20px; border-radius: 10px; z-index: 9999; box-shadow: 0 4px 12px rgba(0,0,0,0.15);';
                notification.textContent = '⚠️ Past training end date - Trainee will be created as Inactive';
                document.body.appendChild(notification);
                setTimeout(() => notification.remove(), 4000);
            } else {
                this.style.borderColor = '#e2e8f0';
            }
        });
    }

    // Edit Form Logic
    const editEndDateInput = document.getElementById('edit_endDate');
    const editTerminatedDateInput = document.getElementById('edit_terminatedDate');
    const editPaymentStartInput = document.getElementById('edit_paymentStartDate');
    const editPaymentEndInput = document.getElementById('edit_paymentEndDate');

    // Auto-fill terminated date when training end date is set and is in the past
    if (editEndDateInput) {
        editEndDateInput.addEventListener('change', function() {
            const endDate = new Date(this.value);
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            
            // If end date is in the past and terminated date is empty, auto-fill it
            if (endDate < today && !editTerminatedDateInput.value) {
                editTerminatedDateInput.value = this.value;
                editTerminatedDateInput.style.borderColor = '#10b981';
                
                // Show notification
                const notification = document.createElement('div');
                notification.style.cssText = 'position: fixed; top: 20px; right: 20px; background: #10b981; color: white; padding: 15px 20px; border-radius: 10px; z-index: 9999; box-shadow: 0 4px 12px rgba(0,0,0,0.15);';
                notification.textContent = '✓ Terminated date auto-filled (Training ended)';
                document.body.appendChild(notification);
                setTimeout(() => notification.remove(), 3000);
            }
        });
    }

    // Show notification when payment dates are filled
    if (editPaymentStartInput && editPaymentEndInput) {
        const checkPaymentStatus = () => {
            if (editPaymentStartInput.value && editPaymentEndInput.value) {
                editPaymentStartInput.style.borderColor = '#10b981';
                editPaymentEndInput.style.borderColor = '#10b981';
            }
        };

        editPaymentStartInput.addEventListener('change', checkPaymentStatus);
        editPaymentEndInput.addEventListener('change', function() {
            checkPaymentStatus();
            
            if (editPaymentStartInput.value && this.value) {
                // Show notification
                const notification = document.createElement('div');
                notification.style.cssText = 'position: fixed; top: 20px; right: 20px; background: #667eea; color: white; padding: 15px 20px; border-radius: 10px; z-index: 9999; box-shadow: 0 4px 12px rgba(0,0,0,0.15);';
                notification.textContent = '✓ Payment info complete - Trainee will be moved to Paid section';
                document.body.appendChild(notification);
                setTimeout(() => notification.remove(), 4000);
            }
        });
    }

</script>

<!-- Include CRUD JavaScript -->
<script src="{{ asset('js/trainee-crud.js') }}"></script>

@endsection