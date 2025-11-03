@extends('layouts.app')

@push('styles')
    <style>
        .partners-content-wrapper {
            background-color: #ffffff;
            border: 1px solid #e0e0e0;
            padding: 24px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }
        .partners-content-wrapper h1, .partners-content-wrapper h2, .partners-content-wrapper h3, .partners-content-wrapper label, .partners-content-wrapper p, .partners-content-wrapper th, .partners-content-wrapper td {
            color: #212529 !important;
        }
        .partners-content-wrapper .table {
            --bs-table-bg: #ffffff;
            --bs-table-striped-color: #212529;
            --bs-table-striped-bg: #f8f9fa;
            --bs-table-hover-color: #212529;
            --bs-table-hover-bg: #f1f3f5;
            color: #212529;
        }
        .partners-content-wrapper .page-link {
            background-color: #ffffff !important;
            border-color: #dee2e6 !important;
            color: #0057FF !important;
        }
        .partners-content-wrapper .page-item.active .page-link {
            background-color: #0057FF !important;
            border-color: #0057FF !important;
            color: #ffffff !important;
        }

        /* --- Action Buttons --- */
        .action-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            border-radius: 8px;
            text-decoration: none !important;
            transition: all 0.2s ease-in-out;
            border: none;
        }
        .action-btn i {
            font-size: 16px;
        }
        .action-btn-edit {
            background-color: #e6f0ff;
        }
        .action-btn-edit i {
            color: #0057ff;
        }
        .action-btn-edit:hover {
            background-color: #cce0ff;
        }
        .action-btn-view {
            background-color: #e3f9e5;
        }
        .action-btn-view i {
            color: #28a745;
        }
        .action-btn-view:hover {
            background-color: #c1f2c6;
        }
        .action-btn-delete {
            background-color: #ffe6e6;
            cursor: pointer;
        }
        .action-btn-delete i {
            color: #dc3545;
        }
        .action-btn-delete:hover {
            background-color: #ffcccc;
        }

        /* --- Modal Styles --- */
        .modal-content {
            background-color: #ffffff !important;
            color: #212529 !important;
        }
        .modal-header {
            border-bottom: 1px solid #dee2e6;
        }
        .modal-body h5, .modal-body p, .modal-body strong {
            color: #212529 !important;
        }
        .modal-footer {
            border-top: 1px solid #dee2e6;
        }
    </style>
@endpush

@section('page-title', 'Partners')

@section('content')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Auto-hide success message after 3 seconds
            const successAlert = document.querySelector('.alert-success');
            if (successAlert) {
                setTimeout(() => {
                    successAlert.style.transition = "opacity 0.5s";
                    successAlert.style.opacity = "0";
                    setTimeout(() => successAlert.remove(), 500);
                }, 3000);
            }

            // View button - Load data via AJAX and show in modal
            document.querySelectorAll('.view-btn').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const url = this.getAttribute('data-url');

                    fetch(url, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    })
                        .then(response => response.json())
                        .then(data => {
                            // Populate modal with partner data
                            document.getElementById('modal-org-name').textContent = data.organization_name;
                            document.getElementById('modal-contact-name').textContent =
                                (data.contact_person_title ? data.contact_person_title + ' ' : '') + data.contact_person_name;
                            document.getElementById('modal-designation').textContent =
                                data.contact_person_designation || 'N/A';
                            document.getElementById('modal-email').textContent = data.contact_person_email;
                            document.getElementById('modal-phone1').textContent =
                                data.contact_person_phone_1 || 'N/A';
                            document.getElementById('modal-phone2').textContent =
                                data.contact_person_phone_2 || 'N/A';

                            // Show modal
                            const viewModal = new bootstrap.Modal(document.getElementById('viewPartnerModal'));
                            viewModal.show();
                        })
                        .catch(error => {
                            console.error('Error loading partner data:', error);
                            alert('Failed to load partner details.');
                        });
                });
            });

            // Delete button - Show confirmation modal
            document.querySelectorAll('.delete-btn').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const form = this.closest('form');
                    const partnerName = this.getAttribute('data-partner-name');

                    // Set partner name in modal
                    document.getElementById('delete-partner-name').textContent = partnerName;

                    // Show confirmation modal
                    const deleteModal = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));
                    deleteModal.show();

                    // Handle confirm delete
                    document.getElementById('confirm-delete-btn').onclick = function() {
                        form.submit();
                    };
                });
            });
        });
    </script>

    <div class="partners-content-wrapper">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Partners</h1>
            <a href="{{ route('reference-data.partners.create') }}" class="btn btn-primary">Create Partner</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($partners->count())
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th>Organization Name</th>
                        <th>Contact Person</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th class="text-center">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($partners as $partner)
                        <tr>
                            <td>{{ $partner->organization_name }}</td>
                            <td>{{ $partner->contact_person_title }} {{ $partner->contact_person_name }}</td>
                            <td>{{ $partner->contact_person_email }}</td>
                            <td>{{ $partner->contact_person_phone_1 }}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <button type="button" class="action-btn action-btn-view view-btn"
                                            data-url="{{ route('reference-data.partners.show', $partner) }}"
                                            title="View">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <a href="{{ route('reference-data.partners.edit', $partner) }}" class="action-btn action-btn-edit" title="Edit">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                    <form action="{{ route('reference-data.partners.destroy', $partner) }}" method="POST" class="delete-form d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="action-btn action-btn-delete delete-btn"
                                                data-partner-name="{{ $partner->organization_name }}"
                                                title="Delete">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-3">{{ $partners->links() }}</div>
        @else
            <p>No partners found.</p>
        @endif
    </div>

    <!-- View Partner Modal -->
    <div class="modal fade" id="viewPartnerModal" tabindex="-1" aria-labelledby="viewPartnerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewPartnerModalLabel">Partner Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h3 id="modal-org-name" class="mb-4"></h3>

                    <h5>Contact Person</h5>
                    <p><strong>Name:</strong> <span id="modal-contact-name"></span></p>
                    <p><strong>Designation:</strong> <span id="modal-designation"></span></p>

                    <hr>

                    <h5>Contact Details</h5>
                    <p><strong>Email:</strong> <span id="modal-email"></span></p>
                    <p><strong>Phone 1:</strong> <span id="modal-phone1"></span></p>
                    <p><strong>Phone 2:</strong> <span id="modal-phone2"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteConfirmModalLabel">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete partner <strong id="delete-partner-name"></strong>?</p>
                    <p class="text-danger">This action cannot be undone.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirm-delete-btn">Delete</button>
                </div>
            </div>
        </div>
    </div>
@endsection
