@extends('layouts.app')

@section('page-title', 'Create New Freelancer')

@section('content')
<!-- Font Awesome CDN for Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
{{-- SweetAlert2 CDN --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    /* === CARD STYLE UPDATES START HERE === */
    .styled-card {
        background-color: #ffffff !important;  
        border: 1px solid #dee2e6 !important;  
        box-shadow: 0 .125rem .25rem rgba(0,0,0,.075) !important;  
        border-radius: 8px;  
    }
    .styled-card .card-header {
        background-color: #f8f9fa !important;  
        border-bottom: 1px solid #dee2e6 !important;
    }
    label, .card-header h5 {
        color: #212529 !important; 
    }
    .form-control, .form-select {
        background-color: #ffffff !important;
        color: #212529 !important;
        border: 1px solid #ced4da !important;
    }
    .form-control::placeholder { 
        color: #6c757d; 
    }
    .form-control:focus, .form-select:focus {
        background-color: #ffffff !important;
        color: #212529 !important;
        border-color: #86b7fe !important;
        box-shadow: 0 0 0 .25rem rgba(13,110,253,.25) !important;
    }    
    
    /* === TABLE STYLE (NO CHANGES) === */
    #tasksTable {
        background-color: #ffffff !important;
        color: #212529 !important;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        overflow: hidden; 
    }
    #tasksTable thead { 
        background-color: #f8f9fa !important;
        color: #495057 !important;
    }
    #tasksTable th, #tasksTable td { 
        border: 1px solid #dee2e6;
        color: #333;
    }
    

    /* === BUTTON STYLE (NO CHANGES) === */
    .btn-outline-primary {
        color: #66b3ff !important;
        border-color: #66b3ff !important;
    }
    .btn-outline-primary:hover {
        color: #fff !important;
        background-color: #1E90FF !important;
        border-color: #1E90FF !important;
    }
</style>

<div class="d-flex justify-content-end align-items-center mb-3">
    <a href="{{ route('freelancers.all') }}" class="btn btn-sm btn-outline-primary">
        <i class="fas fa-users me-1"></i> All Freelancers
    </a>
</div>

@if(session('error'))
<script>
    Swal.fire({
        icon: 'error', title: 'Error!', text: "{{ session('error') }}",
        background: '#0c1631', color: '#e6e6e6', confirmButtonColor: '#d33',
    });
</script>
@endif

@if(session('success'))
<script>
    Swal.fire({
        icon: 'success', title: 'Success!', text: "{{ session('success') }}",
        background: '#0c1631', color: '#e6e6e6', confirmButtonColor: '#28a745',
    });
</script>
@endif

<form method="POST" action="{{ route('freelancers.store') }}">
    @csrf

    <!-- 1. Freelancer & Project Details Card -->
    <div class="card mb-4 styled-card">
        <div class="card-header">
            <h5 class="mb-0">Freelancer & Project Details</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Enter full name" required value="{{ old('name') }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="nic">NIC</label>
                    <input type="text" name="nic" id="nic" class="form-control" placeholder="Enter NIC" required value="{{ old('nic') }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="project_name">Project Name</label>
                    <input type="text" name="project_name" id="project_name" class="form-control" placeholder="Enter project name" required value="{{ old('project_name') }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="project_scope">Project Scope</label>
                    <input type="text" name="project_scope" id="project_scope" class="form-control" placeholder="Enter project scope" required value="{{ old('project_scope') }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="total_amount">Amount</label>
                    <input type="number" name="total_amount" id="total_amount" class="form-control" placeholder="Enter total amount" required value="{{ old('total_amount') }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="budget_available">Budget Available</label>
                    <select name="budget_available" id="budget_available" class="form-select">
                        <option value="" disabled selected>-- Select --</option>
                        <option value="Yes" {{ old('budget_available') == 'Yes' ? 'selected' : '' }}>Yes</option>
                        <option value="No" {{ old('budget_available') == 'No' ? 'selected' : '' }}>No</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="start_date">Start Date</label>
                    <input type="date" name="start_date" id="start_date" class="form-control" required value="{{ old('start_date') }}">
                </div>
                <div class="col-md-4">
                    <label for="end_date">End Date</label>
                    <input type="date" name="end_date" id="end_date" class="form-control" required value="{{ old('end_date') }}">
                </div>
                <div class="col-md-4">
                    <label for="duration">Duration</label>
                    <input type="text" name="duration" id="duration" class="form-control" required value="{{ old('duration') }}">
                </div>
            </div>
        </div>
    </div>

    <!-- 2. Add Task Card -->
    <div class="card mb-4 styled-card">
        <div class="card-header">
            <h5 class="mb-0">Add Task</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3 mb-3">
                    <label for="task_name">Task</label>
                    <input type="text" id="task_name" class="form-control" placeholder="Enter task name">
                </div>
                <div class="col-md-3 mb-3">
                    <label for="specification">Specification</label>
                    <input type="text" id="specification" class="form-control" placeholder="Enter specification">
                </div>
                <div class="col-md-3 mb-3">
                    <label for="payment">Payment</label>
                    <input type="number" id="payment" class="form-control" placeholder="Enter payment">
                </div>
                <div class="col-md-3 mb-3">
                    <label for="delivery_due_date">Delivery Due Date</label>
                    <input type="date" id="delivery_due_date" class="form-control">
                </div>
                <div class="col-md-3">
                    <label for="status">Status</label>
                    <select id="status" class="form-select">
                        <option value="" disabled selected>-- Select --</option>
                        <option>Open</option>
                        <option>In Progress</option>
                        <option>Completed</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="paid">Paid</label>
                    <select id="paid" class="form-select">
                        <option value="" disabled selected>-- Select --</option>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                </div>
                <div class="col-md-6 d-flex align-items-end justify-content-end">
                    <input type="hidden" id="editIndex" value="-1">
                    <button type="button" id="cancelEditBtn" class="btn btn-secondary me-2" style="display:none;">Cancel</button>
                    <button type="button" id="taskActionBtn" class="btn btn-success">+ Add Task</button>
                </div>
            </div>
        </div>
    </div>

    <table class="table table-bordered" id="tasksTable">
        <thead>
            <tr>
                <th>#</th>
                <th>Task</th>
                <th>Specification</th>
                <th>Payment</th>
                <th>Delivery Due Date</th>
                <th>Status</th>
                <th>Paid</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>

    <input type="hidden" name="tasks" id="tasksInput" value="{{ old('tasks') }}">

    <div class="d-flex justify-content-end mt-3 mb-4">
        <button type="submit" class="btn btn-primary">Save Freelancer</button>
    </div>
</form>

{{-- Original Javascript, no changes needed here --}}
<script>
let tasks = [];
let taskCounter = 0;

document.getElementById('taskActionBtn').addEventListener('click', function() {
    let task_name = document.getElementById('task_name').value.trim();
    let specification = document.getElementById('specification').value.trim();
    let payment = parseFloat(document.getElementById('payment').value);
    let delivery_due_date = document.getElementById('delivery_due_date').value;
    let status = document.getElementById('status').value;
    let paid = document.getElementById('paid').value;
    let total_amount = parseFloat(document.getElementById('total_amount').value);
    let editIndex = parseInt(document.getElementById('editIndex').value);

    if (!task_name || isNaN(payment) || !delivery_due_date || !status || status === '' || paid === '') {
        Swal.fire({ 
            icon: 'warning', 
            title: 'Incomplete Fields', 
            text: 'Please fill all task fields including Paid.',
            background: '#0c1631', color: '#e6e6e6'
        });
        return;
    }

    if (isNaN(total_amount) || total_amount <= 0) {
        Swal.fire({ 
            icon: 'info', 
            title: 'Enter Total Amount', 
            text: 'Please enter a valid total amount before adding tasks.',
            background: '#0c1631', color: '#e6e6e6'
        });
        return;
    }

    let currentTotal = tasks.reduce((sum, t) => sum + parseFloat(t.payment), 0);
    let newTotal = currentTotal + payment;

    if (editIndex > -1) {
        currentTotal -= parseFloat(tasks[editIndex].payment);
        newTotal = currentTotal + payment;
    }

    if (newTotal > total_amount) {
        Swal.fire({
            icon: 'error',
            title: 'Budget Limit Exceeded',
            html: `<b>You cannot add this task.</b><br>Total task payments exceed project total.`,
            confirmButtonColor: '#d33',
            background: '#0c1631', color: '#e6e6e6'
        });
        return;
    }

    let task = { task_name, specification, payment, delivery_due_date, status, paid };

    if (editIndex > -1) {
        Object.assign(tasks[editIndex], task);
        document.getElementById('taskActionBtn').textContent = 'Update Task';
        document.getElementById('taskActionBtn').classList.remove('btn-success');
        document.getElementById('taskActionBtn').classList.add('btn-warning');
        document.getElementById('editIndex').value = -1;
        document.getElementById('cancelEditBtn').style.display = 'none';
    } else {
        task.temp_id = taskCounter++;
        tasks.push(task);
    }

    clearInputs();
    renderTasks();
});

document.getElementById('cancelEditBtn').addEventListener('click', function() {
    clearInputs();
    document.getElementById('editIndex').value = -1;
    document.getElementById('taskActionBtn').textContent = '+ Add Task';
    document.getElementById('taskActionBtn').classList.remove('btn-warning');
    document.getElementById('taskActionBtn').classList.add('btn-success');
    document.getElementById('cancelEditBtn').style.display = 'none';
});

function renderTasks() {
    let tableBody = document.querySelector('#tasksTable tbody');
    tableBody.innerHTML = '';
    tasks.forEach((task, index) => {
        let paidText = task.paid == 1 ? 'Yes' : 'No';
        let row = tableBody.insertRow();
        row.innerHTML = `
            <td>${index + 1}</td>
            <td>${task.task_name}</td>
            <td>${task.specification}</td>
            <td>${parseFloat(task.payment).toFixed(2)}</td>
            <td>${task.delivery_due_date}</td>
            <td>${task.status}</td>
            <td>${paidText}</td>
            <td>
                <button type="button" class="btn btn-primary btn-sm" onclick="editTask(${index})"><i class="fa fa-edit"></i></button>
                <button type="button" class="btn btn-danger btn-sm" onclick="deleteTask(${index})"><i class="fa fa-trash"></i></button>
            </td>
        `;
    });
    document.getElementById('tasksInput').value = JSON.stringify(tasks);
}

function clearInputs() {
    document.getElementById('task_name').value = '';
    document.getElementById('specification').value = '';
    document.getElementById('payment').value = '';
    document.getElementById('delivery_due_date').value = '';
    document.getElementById('status').value = '';
    document.getElementById('paid').value = '';
}

function deleteTask(index) {
    tasks.splice(index, 1);
    renderTasks();
}

function editTask(index) {
    let t = tasks[index];
    document.getElementById('task_name').value = t.task_name;
    document.getElementById('specification').value = t.specification;
    document.getElementById('payment').value = t.payment;
    document.getElementById('delivery_due_date').value = t.delivery_due_date;
    document.getElementById('status').value = t.status;
    document.getElementById('paid').value = t.paid;
    document.getElementById('editIndex').value = index;
    document.getElementById('taskActionBtn').textContent = 'Update Task';
    document.getElementById('taskActionBtn').classList.remove('btn-success');
    document.getElementById('taskActionBtn').classList.add('btn-warning');
    document.getElementById('cancelEditBtn').style.display = 'inline-block';
}

if (document.getElementById('tasksInput').value) {
    try {
        tasks = JSON.parse(document.getElementById('tasksInput').value);
        if (Array.isArray(tasks) && tasks.length > 0) {
            taskCounter = tasks[tasks.length - 1].temp_id + 1;
            renderTasks();
        }
    } catch (e) {
        console.error("Error parsing tasks from old input:", e);
    }
}
</script>

@endsection