@extends('layouts.app')

@section('page-title', 'Employee Management')

@section('content')

{{-- Custom CSS for the Success/Error Popups --}}
<style>
    .custom-modal-content {
        border-radius: 20px;
        border: none;
        text-align: center;
        overflow: hidden;
    }
    .modal-header-custom {
        height: 150px;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        border-bottom-left-radius: 50% 40px;
        border-bottom-right-radius: 50% 40px;
    }
    .success-header { background-color: #37d656; }
    .error-header { background-color: #ff4d4d; }
    
    .modal-icon-circle {
        background: rgba(255, 255, 255, 0.2);
        width: 80px; height: 80px;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 40px; color: white;
        border: 2px solid white;
    }
    .custom-modal-body h3 { font-weight: bold; margin-top: 20px; }
    .custom-btn-success { background-color: #37d656; border: none; padding: 10px 40px; border-radius: 30px; font-weight: bold; }
    .custom-btn-error { background-color: #ff4d4d; border: none; padding: 10px 40px; border-radius: 30px; font-weight: bold; color: white; }
    .custom-btn-success:hover, .custom-btn-error:hover { opacity: 0.9; color: white; }
</style>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">All Employees</h3>
        <div class="card-actions">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-create">
                <i class="ti ti-plus me-1"></i> Add New Employee
            </button>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table card-table table-vcenter text-nowrap datatable">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($employees as $emp)
                <tr>
                    <td>{{ $emp->name }}</td>
                    <td>{{ $emp->email }}</td>
                    <td><span class="badge bg-blue-lt">{{ $emp->role }}</span></td>
                    <td>
                        {{-- View Button --}}
                        <button class="btn btn-sm btn-info btn-view" 
                            data-bs-toggle="modal" data-bs-target="#modal-view"
                            data-name="{{ $emp->name }}"
                            data-email="{{ $emp->email }}"
                            data-role="{{ $emp->role }}"
                            data-phone="{{ $emp->Emp_Phone }}"
                            data-calling="{{ $emp->Calling_Name }}"
                            data-dob="{{ $emp->DOB }}"
                            data-gender="{{ $emp->Gender }}"
                            data-section="{{ $emp->Section }}">
                            View
                        </button>

                        {{-- Edit Button --}}
                        <button class="btn btn-sm btn-warning btn-edit" 
                            data-bs-toggle="modal" data-bs-target="#modal-edit"
                            data-id="{{ $emp->user_id }}"
                            data-name="{{ $emp->name }}"
                            data-role="{{ $emp->role }}"
                            data-phone="{{ $emp->Emp_Phone }}"
                            data-calling="{{ $emp->Calling_Name }}"
                            data-dob="{{ $emp->DOB }}"
                            data-gender="{{ $emp->Gender }}"
                            data-section="{{ $emp->Section }}">
                            Edit
                        </button>

                        {{-- Delete Button --}}
                        <button class="btn btn-sm btn-danger btn-delete" 
                            data-bs-toggle="modal" data-bs-target="#modal-delete"
                            data-id="{{ $emp->user_id }}">
                            Delete
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- ================= MODALS ================= --}}

{{-- Create Modal --}}
<div class="modal modal-blur fade" id="modal-create" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">New Employee Registration</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form action="{{ route('employees.store') }}" method="POST">
        @csrf
        <div class="modal-body">
            <div class="row">
                <!-- <div class="col-lg-6 mb-3"><label class="form-label">Name</label><input type="text" name="name" class="form-control" required></div> -->
                <div class="col-lg-6 mb-3"><label class="form-label">Calling Name</label><input type="text" name="calling_name" class="form-control"></div>
                <div class="col-lg-6 mb-3"><label class="form-label">Email</label><input type="email" name="email" class="form-control" required></div>
                <div class="col-lg-6 mb-3"><label class="form-label">Phone No</label><input type="text" name="phone" class="form-control"></div>
                <div class="col-lg-6 mb-3">
                    <label class="form-label">Role</label>
                    <select name="role" class="form-select" required>
                        <option value="Administrator">Administrator</option>
                        <option value="Developer">Developer</option>
                        <option value="View_only_user">View_only_user</option>
                        <option value="Ishamp_user">Ishamp_user</option>
                        <option value="Dpo_user">Dpo_user</option>
                        
                    </select>
                </div>
                <div class="col-lg-6 mb-3"><label class="form-label">Section</label><input type="text" name="section" class="form-control"></div>
                <div class="col-lg-6 mb-3"><label class="form-label">DOB</label><input type="date" name="dob" class="form-control"></div>
                <div class="col-lg-6 mb-3">
                    <label class="form-label">Gender</label>
                    <select name="gender" class="form-select">
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-link link-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary ms-auto">Create Employee</button>
        </div>
      </form>
    </div>
  </div>
</div>

{{--  View Modal --}}
<div class="modal modal-blur fade" id="modal-view" tabindex="-1">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header bg-info-lt">
          <h5 class="modal-title">Employee Details</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-6 mb-3"><strong>Name:</strong> <span id="view-name"></span></div>
                <div class="col-md-6 mb-3"><strong>Email:</strong> <span id="view-email"></span></div>
                <div class="col-md-6 mb-3"><strong>Role:</strong> <span id="view-role" class="badge bg-blue"></span></div>
                <div class="col-md-6 mb-3"><strong>Phone:</strong> <span id="view-phone"></span></div>
                <div class="col-md-6 mb-3"><strong>Calling Name:</strong> <span id="view-calling"></span></div>
                <div class="col-md-6 mb-3"><strong>Section:</strong> <span id="view-section"></span></div>
                <div class="col-md-6 mb-3"><strong>DOB:</strong> <span id="view-dob"></span></div>
                <div class="col-md-6 mb-3"><strong>Gender:</strong> <span id="view-gender"></span></div>
            </div>
        </div>
      </div>
    </div>
</div>

{{--  Edit Modal --}}
<div class="modal modal-blur fade" id="modal-edit" tabindex="-1">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Employee</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <form id="edit-form" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-body">
                {{-- Fields similar to Create, populated via JS --}}
                <div class="row">
                    <div class="col-lg-6 mb-3"><label class="form-label">Name</label><input type="text" id="edit-name" name="name" class="form-control" required></div>
                    <div class="col-lg-6 mb-3"><label class="form-label">Calling Name</label><input type="text" id="edit-calling" name="calling_name" class="form-control"></div>
                    <div class="col-lg-6 mb-3"><label class="form-label">Phone No</label><input type="text" id="edit-phone" name="phone" class="form-control"></div>
                    <div class="col-lg-6 mb-3">
                        <label class="form-label">Role</label>
                        <select name="role" id="edit-role" class="form-select" required>
                            <option value="Administrator">Administrator</option>
                            <option value="Developer">Developer</option>
                            <option value="View_only_user">View_only_user</option>
                            <option value="Ishamp_user">Ishamp_user</option>
                            <option value="Dpo_user">Dpo_user</option>
                            <option value="Inactive_user">Inactive_User</option>
                        </select>
                    </div>
                    <div class="col-lg-6 mb-3"><label class="form-label">Section</label><input type="text" id="edit-section" name="section" class="form-control"></div>
                    <div class="col-lg-6 mb-3"><label class="form-label">DOB</label><input type="date" id="edit-dob" name="dob" class="form-control"></div>
                    <div class="col-lg-6 mb-3">
                        <label class="form-label">Gender</label>
                        <select name="gender" id="edit-gender" class="form-select">
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link link-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-warning ms-auto">Update Changes</button>
            </div>
        </form>
      </div>
    </div>
</div>

{{--  Delete Confirmation Modal --}}
<div class="modal modal-blur fade" id="modal-delete" tabindex="-1">
    <div class="modal-dialog modal-sm modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-body text-center py-4">
            <i class="ti ti-alert-triangle text-danger icon-lg mb-2" style="font-size: 3rem;"></i>
            <h3>Are you sure?</h3>
            <div class="text-muted">Do you really want to remove this employee? This action cannot be undone.</div>
        </div>
        <div class="modal-footer">
          <div class="w-100">
            <div class="row">
              <div class="col"><a href="#" class="btn w-100" data-bs-dismiss="modal">Cancel</a></div>
              <div class="col">
                  <form id="delete-form" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger w-100">Delete</button>
                  </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>

{{--  Custom Success Modal (Green) --}}
<div class="modal fade" id="modal-success" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content custom-modal-content">
            <div class="modal-header-custom success-header">
                <div class="modal-icon-circle">
                    <i class="ti ti-check"></i>
                </div>
            </div>
            <div class="modal-body custom-modal-body">
                <h3>Success!</h3>
                <p class="text-muted" id="success-message">Operation completed successfully.</p>
                <button type="button" class="btn custom-btn-success mt-3" data-bs-dismiss="modal">Continue</button>
            </div>
        </div>
    </div>
</div>

{{--  Custom Error Modal (Red) --}}
<div class="modal fade" id="modal-error" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content custom-modal-content">
            <div class="modal-header-custom error-header">
                <div class="modal-icon-circle">
                    <i class="ti ti-alert-circle"></i>
                </div>
            </div>
            <div class="modal-body custom-modal-body">
                <h3>Error!</h3>
                <p class="text-muted" id="error-message">Something went wrong.</p>
                <button type="button" class="btn custom-btn-error mt-3" data-bs-dismiss="modal">Try Again</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        
        // 1. Handle View Modal Data
        var viewModal = document.getElementById('modal-view');
        viewModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            document.getElementById('view-name').textContent = button.getAttribute('data-name');
            document.getElementById('view-email').textContent = button.getAttribute('data-email');
            document.getElementById('view-role').textContent = button.getAttribute('data-role');
            document.getElementById('view-phone').textContent = button.getAttribute('data-phone');
            document.getElementById('view-calling').textContent = button.getAttribute('data-calling');
            document.getElementById('view-section').textContent = button.getAttribute('data-section');
            document.getElementById('view-dob').textContent = button.getAttribute('data-dob');
            document.getElementById('view-gender').textContent = button.getAttribute('data-gender');
        });

        // 2. Handle Edit Modal Data
        var editModal = document.getElementById('modal-edit');
        editModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var id = button.getAttribute('data-id');
            
            // Set Form Action Dynamically
            var form = document.getElementById('edit-form');
            form.action = '/employees/' + id;  

            // Populate Fields
            document.getElementById('edit-name').value = button.getAttribute('data-name');
            document.getElementById('edit-calling').value = button.getAttribute('data-calling');
            document.getElementById('edit-phone').value = button.getAttribute('data-phone');
            document.getElementById('edit-role').value = button.getAttribute('data-role');
            document.getElementById('edit-section').value = button.getAttribute('data-section');
            document.getElementById('edit-dob').value = button.getAttribute('data-dob');
            document.getElementById('edit-gender').value = button.getAttribute('data-gender');
        });

        // 3. Handle Delete Modal
        var deleteModal = document.getElementById('modal-delete');
        deleteModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var id = button.getAttribute('data-id');
            var form = document.getElementById('delete-form');
            form.action = '/employees/' + id;
        });

        // 4. Trigger Success/Error Modals based on Session
        @if(session('success'))
            document.getElementById('success-message').textContent = "{{ session('success') }}";
            var successModal = new bootstrap.Modal(document.getElementById('modal-success'));
            successModal.show();
        @endif

        @if(session('error'))
            document.getElementById('error-message').textContent = "{{ session('error') }}";
            var errorModal = new bootstrap.Modal(document.getElementById('modal-error'));
            errorModal.show();
        @endif
    });
</script>
@endpush