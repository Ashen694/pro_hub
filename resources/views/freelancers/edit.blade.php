@extends('layouts.app')

@section('content')
{{-- Bootstrap Icons (original) --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
{{-- Font Awesome CDN for Icons (for better design) --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<style>
    /* New CSS Styles from the Create Blade */
    .container {
        font-family: Arial, sans-serif;
        font-size: 14px;
    }
    .form-control, .btn {
        font-size: 14px;
        height: calc(1.5em + .5rem + 2px);
        padding: .25rem .5rem;
    }
    label {
        margin-bottom: 0.2rem;
        font-size: 14px;
        font-weight: 600; /* Added: Make labels bolder for better readability */
    }
    /* Adjusted padding for rows inside the card-body for better spacing */
    .card-body .row > .col-md-6, .card-body .row > .col-md-4, .card-body .row > .col-md-3 {
        padding-top: 0.6rem; /* Increased padding */
        padding-bottom: 0.6rem; /* Increased padding */
    }
    /* Main H2/H4 titles adjusted for new header structure */
    h2.h4, h5 {
        margin-bottom: 0;
    }
    .table th, .table td {
        padding: 0.4rem;
        font-size: 13px;
    }
    /* Styling for card header titles - slightly larger and bolder */
    .card-header h5 {
        font-size: 1.2rem; /* Slightly larger */
        font-weight: 700; /* Bolder */
        color: #343a40; /* Darker text */
    }
    /* Custom style for the card container to make it stand out */
    .styled-card {
        border: 1px solid #007bff; /* Primary color border */
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important; /* Larger shadow */
    }
    /* Specific styles for task table actions */
    .task-actions button {
        margin-right: 5px;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="container mt-4">
    
    <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-2">
        <h2 class="h4 mb-0 font-weight-bold">Update Freelancer - {{ $freelancer->name }}</h2>
        
        
        </a>
    </div>

    <form action="{{ route('freelancers.update', $freelancer->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="card mb-4 styled-card">
            <div class="card-header bg-light border-bottom">
                <h5 class="mb-0 text-dark"></i> Freelancer & Project Details</h5>
            </div>
            <div class="card-body">
                
                {{-- Freelancer basic info --}}
                <div class="row">
                    <div class="col-md-4">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="Enter full name" required value="{{ old('name', $freelancer->name) }}">
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label for="nic">NIC</label>
                        <input type="text" name="nic" id="nic" class="form-control @error('nic') is-invalid @enderror" placeholder="Enter NIC" required value="{{ old('nic', $freelancer->nic) }}">
                        @error('nic')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label for="project_name">Project Name</label>
                        <input type="text" name="project_name" id="project_name" class="form-control" placeholder="Enter project name" required value="{{ old('project_name', $freelancer->project_name) }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <label for="project_scope">Project Scope</label>
                        <input type="text" name="project_scope" id="project_scope" class="form-control" placeholder="Enter project scope" required value="{{ old('project_scope', $freelancer->project_scope) }}">
                    </div>
                    <div class="col-md-4">
                        <label for="total_amount">Total Amount (Rs)</label>
                        <input type="number" name="total_amount" id="total_amount" class="form-control" placeholder="Enter total amount" required value="{{ old('total_amount', $freelancer->total_amount) }}" step="0.01">
                    </div>
                    <div class="col-md-4">
                        <label for="budget_available">Budget Available</label>
                        <select name="budget_available" id="budget_available" class="form-control">
                            <option value="Yes" {{ old('budget_available', $freelancer->budget_available) == 'Yes' ? 'selected' : '' }}>Yes</option>
                            <option value="No" {{ old('budget_available', $freelancer->budget_available) == 'No' ? 'selected' : '' }}>No</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <label for="start_date">Start Date</label>
                        <input type="date" name="start_date" id="start_date" class="form-control" required value="{{ old('start_date', $freelancer->start_date) }}">
                    </div>
                    <div class="col-md-4">
                        <label for="end_date">End Date</label>
                        <input type="date" name="end_date" id="end_date" class="form-control" required value="{{ old('end_date', $freelancer->end_date) }}">
                    </div>
                    <div class="col-md-4">
                        <label for="duration">Duration</label>
                        <input type="text" name="duration" id="duration" class="form-control" required value="{{ old('duration', $freelancer->duration) }}">
                    </div>
                </div>

            </div> </div> <div class="card mb-4 styled-card">
            <div class="card-header bg-light border-bottom">
                <h5 class="mb-0 text-dark"></i> Add / Edit Tasks</h5>
            </div>
            <div class="card-body">
                
                {{-- Task Inputs --}}
                <div class="row">
                    <div class="col-md-3">
                        <label for="task_name">Task Name</label>
                        <input type="text" id="task_name_input" class="form-control" placeholder="Task Name">
                    </div>
                    <div class="col-md-3">
                        <label for="specification">Specification</label>
                        <input type="text" id="specification_input" class="form-control" placeholder="Specification">
                    </div>
                    <div class="col-md-2">
                        <label for="payment">Payment (Rs)</label>
                        <input type="number" id="payment_input" class="form-control" placeholder="Payment" step="0.01">
                    </div>
                    <div class="col-md-2">
                        <label for="delivery_due_date">Due Date</label>
                        <input type="date" id="delivery_due_date_input" class="form-control">
                    </div>
                    <div class="col-md-2">
                        <label for="status">Status</label>
                        <select id="status_input" class="form-control">
                            <option value="Open">Open</option>
                            <option value="In Progress">In Progress</option>
                            <option value="Completed">Completed</option>
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-2">
                        <label for="paid">Paid</label>
                        <select id="paid_input" class="form-control">
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </select>
                    </div>

                    <div class="col-md-10 d-flex align-items-end justify-content-end">
                        {{-- Hidden input to store which task index is being edited --}}
                        <input type="hidden" id="editIndex" value="-1"> 
                        <button type="button" id="cancelEditBtn" class="btn btn-secondary me-2" style="display:none;"><i class="fas fa-undo"></i> Cancel Edit</button>
                        <button type="button" id="taskActionBtn" class="btn btn-success"><i class="fas fa-plus-circle"></i> Add Task</button>
                    </div>
                </div>
            </div> </div> {{-- Tasks Table (Re-integrated with the card design structure) --}}
        <div class="card mb-4 styled-card">
            <div class="card-header bg-light border-bottom">
                <h5 class="mb-0 text-dark"></i> Current Tasks</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped mt-3 mb-0" id="tasksTable">
                        <thead class="table-dark">
                            <tr>
                                <th style="width: 50px;">#</th>
                                <th>Task Name</th>
                                <th>Specification</th>
                                <th style="width: 100px;">Payment</th>
                                <th style="width: 120px;">Due Date</th>
                                <th style="width: 100px;">Status</th>
                                <th style="width: 70px;">Paid</th>
                                <th style="width: 120px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Tasks will be rendered here by JS --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end mt-3 mb-5">
            <button type="submit" class="btn btn-primary btn-lg me-2"><i class="bi bi-save"></i> Update Freelancer</button>
            <a href="{{ route('freelancers.all') }}" class="btn btn-secondary btn-lg"><i class="bi bi-arrow-left-circle"></i> Back to List</a>
        </div>
        
        {{-- Hidden input array for tasks to be submitted to Laravel --}}
        <div id="hiddenTaskInputs">
            @foreach($freelancer->tasks as $task)
                {{-- Original Task IDs (prefixed with 'old_') are included for update/delete handling in controller --}}
                <input type="hidden" name="tasks[old_{{ $task->id }}][task_name]" value="{{ $task->task_name }}" data-id="{{ $task->id }}" class="task-input-hidden">
                <input type="hidden" name="tasks[old_{{ $task->id }}][specification]" value="{{ $task->specification }}" class="task-input-hidden">
                <input type="hidden" name="tasks[old_{{ $task->id }}][payment]" value="{{ $task->payment }}" class="task-input-hidden task-payment-input">
                <input type="hidden" name="tasks[old_{{ $task->id }}][delivery_due_date]" value="{{ $task->delivery_due_date }}" class="task-input-hidden">
                <input type="hidden" name="tasks[old_{{ $task->id }}][status]" value="{{ $task->status }}" class="task-input-hidden">
                <input type="hidden" name="tasks[old_{{ $task->id }}][paid]" value="{{ $task->paid }}" class="task-input-hidden">
            @endforeach
        </div>

    </form>
</div>

<script>
    let tasks = [];
    let newTaskIndex = 0;

    // Load existing tasks from PHP model into JS array for manipulation
    @foreach($freelancer->tasks as $task)
        tasks.push({
            id: 'old_{{ $task->id }}', // Unique identifier for existing tasks
            task_name: '{{ $task->task_name }}',
            specification: '{{ $task->specification }}',
            payment: parseFloat('{{ $task->payment }}'),
            delivery_due_date: '{{ $task->delivery_due_date }}',
            status: '{{ $task->status }}',
            paid: '{{ $task->paid }}'
        });
    @endforeach
    
    function validateTotalPayment(currentTaskPayment = 0, newPayment = 0) {
        const totalAmountInput = document.getElementById('total_amount');
        const totalAmount = parseFloat(totalAmountInput.value) || 0;
        
        let currentTotalPayment = 0;
        tasks.forEach(task => {
            currentTotalPayment += parseFloat(task.payment) || 0;
        });

        // Subtract the current task's payment before adding the new/updated payment
        const totalExcludingCurrent = currentTotalPayment - currentTaskPayment;
        const potentialTotal = totalExcludingCurrent + parseFloat(newPayment);

        if (potentialTotal > totalAmount) {
            Swal.fire({
                icon: 'error',
                title: 'Payment Error',
                text: `Task Payment Total (Rs. ${potentialTotal.toFixed(2)}) cannot exceed Total Amount (Rs. ${totalAmount.toFixed(2)})!`,
                confirmButtonColor: '#d33',
                width: '360px',
                customClass: { popup: 'compact-swal' }
            });
            return true; // Validation failed
        }

        return false; // Validation passed
    }

    function clearInputs() {
        document.getElementById('task_name_input').value = '';
        document.getElementById('specification_input').value = '';
        document.getElementById('payment_input').value = '';
        document.getElementById('delivery_due_date_input').value = '';
        document.getElementById('status_input').value = 'Open';
        document.getElementById('paid_input').value = '0';
    }

    function renderTasks() {
        let tableBody = document.querySelector('#tasksTable tbody');
        let hiddenInputsContainer = document.getElementById('hiddenTaskInputs');
        tableBody.innerHTML = '';
        hiddenInputsContainer.innerHTML = ''; // Clear existing hidden inputs

        tasks.forEach((task, index) => {
            let paidText = task.paid == '1' ? 'Yes' : 'No';
            let row = tableBody.insertRow();
            row.innerHTML = `
                <td>${index + 1}</td>
                <td>${task.task_name}</td>
                <td>${task.specification}</td>
                <td>${task.payment.toFixed(2)}</td>
                <td>${task.delivery_due_date}</td>
                <td>${task.status}</td>
                <td>${paidText}</td>
                <td class="task-actions">
                    <button type="button" class="btn btn-primary btn-sm" onclick="editTask(${index})" title="Edit"><i class="fas fa-edit"></i></button>
                    <button type="button" class="btn btn-danger btn-sm" onclick="deleteTask(${index})" title="Delete"><i class="fas fa-trash"></i></button>
                </td>
            `;
            
            // Re-create hidden inputs for submission
            let idPrefix = task.id; // Will be 'old_X' or 'new_Y'
            hiddenInputsContainer.innerHTML += `
                <input type="hidden" name="tasks[${idPrefix}][task_name]" value="${task.task_name}" class="task-input-hidden">
                <input type="hidden" name="tasks[${idPrefix}][specification]" value="${task.specification}" class="task-input-hidden">
                <input type="hidden" name="tasks[${idPrefix}][payment]" value="${task.payment.toFixed(2)}" class="task-input-hidden task-payment-input">
                <input type="hidden" name="tasks[${idPrefix}][delivery_due_date]" value="${task.delivery_due_date}" class="task-input-hidden">
                <input type="hidden" name="tasks[${idPrefix}][status]" value="${task.status}" class="task-input-hidden">
                <input type="hidden" name="tasks[${idPrefix}][paid]" value="${task.paid}" class="task-input-hidden">
            `;
        });
        
        // Reset action button state
        document.getElementById('editIndex').value = -1;
        document.getElementById('taskActionBtn').textContent = '+ Add Task';
        document.getElementById('taskActionBtn').classList.remove('btn-warning');
        document.getElementById('taskActionBtn').classList.add('btn-success');
        document.getElementById('cancelEditBtn').style.display = 'none';
    }


    document.getElementById('taskActionBtn').addEventListener('click', function() {
        let task_name = document.getElementById('task_name_input').value.trim();
        let specification = document.getElementById('specification_input').value.trim();
        let payment = parseFloat(document.getElementById('payment_input').value);
        let delivery_due_date = document.getElementById('delivery_due_date_input').value;
        let status = document.getElementById('status_input').value;
        let paid = document.getElementById('paid_input').value;
        let editIndex = parseInt(document.getElementById('editIndex').value);

        if (!task_name || isNaN(payment) || !delivery_due_date || !status || !paid) {
            Swal.fire({ 
                icon: 'warning', 
                title: 'Incomplete Fields', 
                text: 'Please fill all task fields correctly.',
                width: '360px',
                customClass: { popup: 'compact-swal' }
            });
            return;
        }

        // Determine the payment to exclude from the total check
        let currentTaskPayment = (editIndex > -1) ? tasks[editIndex].payment : 0;

        // Validation: Check if new/updated task payment exceeds total amount
        if (validateTotalPayment(currentTaskPayment, payment)) {
            return; 
        }

        let task = { task_name, specification, payment, delivery_due_date, status, paid };

        if (editIndex > -1) {
            // Update existing task
            Object.assign(tasks[editIndex], task);
        } else {
            // Add new task
            task.id = 'new_' + newTaskIndex++;
            tasks.push(task);
        }

        clearInputs();
        renderTasks();
    });

    document.getElementById('cancelEditBtn').addEventListener('click', function() {
        clearInputs();
        renderTasks(); // Re-render to clear buttons/state
    });

    function deleteTask(index) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                tasks.splice(index, 1);
                renderTasks();
                Swal.fire('Deleted!', 'Your task has been removed.', 'success');
            }
        });
    }

    function editTask(index) {
        let t = tasks[index];
        document.getElementById('task_name_input').value = t.task_name;
        document.getElementById('specification_input').value = t.specification;
        document.getElementById('payment_input').value = t.payment;
        document.getElementById('delivery_due_date_input').value = t.delivery_due_date;
        document.getElementById('status_input').value = t.status;
        document.getElementById('paid_input').value = t.paid;
        
        document.getElementById('editIndex').value = index;
        document.getElementById('taskActionBtn').textContent = 'Update Task';
        document.getElementById('taskActionBtn').classList.remove('btn-success');
        document.getElementById('taskActionBtn').classList.add('btn-warning');
        document.getElementById('cancelEditBtn').style.display = 'inline-block';
    }

    // Initial render when the page loads to display existing tasks
    document.addEventListener('DOMContentLoaded', function() {
        renderTasks();
    });

</script>

@if(session('success'))
<script>
Swal.fire({
    icon: 'success',
    title: 'Updated!',
    text: '{{ session("success") }}',
    timer: 2000,
    showConfirmButton: false
});
</script>
@endif

@endsection
