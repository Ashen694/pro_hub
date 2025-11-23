// CSRF Token setup for AJAX requests
const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
console.log('CSRF Token:', csrfToken);

// Helper function to format dates
function formatDate(dateString) {
    if (!dateString) return '-';
    const date = new Date(dateString);
    return date.toISOString().split('T')[0];
}

// Helper function to show toast notifications
function showToast(message, type = 'success') {
    // You can implement your preferred toast notification library here
    alert(message);
}

// Load trainees data into table
function loadTrainees(status) {
    // This will be handled by Laravel blade @foreach
    console.log('Trainees loaded for status:', status);
}

// Create Trainee
document.getElementById('createTraineeForm')?.addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = {
        Trainee_Name: document.getElementById('traineeName').value,
        Trainee_Phone: document.getElementById('traineeMobile').value,
        Trainee_NIC: document.getElementById('traineeNIC').value,
        Trainee_Email: document.getElementById('traineeEmail').value,
        Trainee_HomeAddress: document.getElementById('traineeAddress').value,
        Training_StartDate: document.getElementById('trainingStartDate').value,
        Training_EndDate: document.getElementById('trainingEndDate').value,
        Institute: document.getElementById('traineeInstitute').value,
        Languages_known: document.getElementById('traineeLanguage').value,
        field_of_specialization: document.getElementById('traineeSpecialization').value,
        Supervisor: document.getElementById('traineeSupervisor').value,
        AssignedWork_Description: document.getElementById('traineeWork').value,
        Target_Date: document.getElementById('traineeTargetDate')?.value,
        status: 'active'
    };

    console.log('Sending request with CSRF token:', csrfToken);
    console.log('Form data:', formData);
    
    fetch('/trainees', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
        },
        body: JSON.stringify(formData)
    })
    .then(response => {
        console.log('Response status:', response.status);
        return response.json().then(data => ({status: response.status, data}));
    })
    .then(({status, data}) => {
        console.log('Response data:', data);
        if (status === 201 || (data && data.success)) {
            showToast('Trainee created successfully!', 'success');
            document.getElementById('createTraineeForm').reset();
            bootstrap.Modal.getInstance(document.getElementById('createTraineeModal')).hide();
            location.reload(); // Reload to show new trainee
        } else {
            const errorMsg = data.message || JSON.stringify(data.errors) || 'Failed to create trainee';
            showToast('Error: ' + errorMsg, 'error');
            console.error('Error details:', data);
        }
    })
    .catch(error => {
        console.error('Fetch error:', error);
        showToast('Failed to create trainee: ' + error.message, 'error');
    });
});

// View Trainee
function viewTrainee(traineeId) {
    fetch(`/trainees/${traineeId}`, {
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const trainee = data.trainee;
            
            // Populate view modal
            document.getElementById('view_traineeId').textContent = trainee.Trainee_ID;
            document.getElementById('view_name').textContent = trainee.Trainee_Name || '-';
            document.getElementById('view_mobile').textContent = trainee.Trainee_Phone || '-';
            document.getElementById('view_email').textContent = trainee.Trainee_Email || '-';
            document.getElementById('view_nic').textContent = trainee.Trainee_NIC || '-';
            document.getElementById('view_city').textContent = trainee.Trainee_HomeAddress || '-';
            document.getElementById('view_startDate').textContent = formatDate(trainee.Training_StartDate);
            document.getElementById('view_endDate').textContent = formatDate(trainee.Training_EndDate);
            document.getElementById('view_institute').textContent = trainee.Institute || '-';
            document.getElementById('view_language').textContent = trainee.Languages_known || '-';
            document.getElementById('view_specialization').textContent = trainee.field_of_specialization || '-';
            document.getElementById('view_supervisor').textContent = trainee.Supervisor || '-';
            document.getElementById('view_assignedWork').textContent = trainee.AssignedWork_Description || '-';
            document.getElementById('view_targetDate').textContent = formatDate(trainee.Target_Date);
            document.getElementById('view_paymentStartDate').textContent = formatDate(trainee.payment_start_date);
            document.getElementById('view_paymentEndDate').textContent = formatDate(trainee.payment_end_date);
            document.getElementById('view_terminatedDate').textContent = formatDate(trainee.terminated_date);
            document.getElementById('view_terminatedReason').textContent = trainee.terminated_reason || '-';
            
            // Show modal
            new bootstrap.Modal(document.getElementById('viewTraineeModal')).show();
        } else {
            showToast('Failed to load trainee details', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('Failed to load trainee details', 'error');
    });
}

// Edit Trainee - Load data
function editTrainee(traineeId) {
    fetch(`/trainees/${traineeId}`, {
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const trainee = data.trainee;
            
            // Store trainee ID
            document.getElementById('edit_rowIndex').value = trainee.Trainee_ID;
            
            // Populate edit form
            document.getElementById('edit_name').value = trainee.Trainee_Name || '';
            document.getElementById('edit_mobile').value = trainee.Trainee_Phone || '';
            document.getElementById('edit_nic').value = trainee.Trainee_NIC || '';
            document.getElementById('edit_email').value = trainee.Trainee_Email || '';
            document.getElementById('edit_address').value = trainee.Trainee_HomeAddress || '';
            document.getElementById('edit_startDate').value = formatDate(trainee.Training_StartDate);
            document.getElementById('edit_endDate').value = formatDate(trainee.Training_EndDate);
            document.getElementById('edit_institute').value = trainee.Institute || '';
            document.getElementById('edit_language').value = trainee.Languages_known || '';
            document.getElementById('edit_specialization').value = trainee.field_of_specialization || '';
            document.getElementById('edit_supervisor').value = trainee.Supervisor || '';
            document.getElementById('edit_assignedWork').value = trainee.AssignedWork_Description || '';
            document.getElementById('edit_requestedPaymentDate').value = formatDate(trainee.requested_payment_date);
            document.getElementById('edit_paymentStartDate').value = formatDate(trainee.payment_start_date);
            document.getElementById('edit_paymentEndDate').value = formatDate(trainee.payment_end_date);
            document.getElementById('edit_absentCount').value = trainee.absent_Count || 0;
            document.getElementById('edit_terminatedDate').value = formatDate(trainee.terminated_date);
            document.getElementById('edit_terminatedReason').value = trainee.terminated_reason || '';
            
            // Show modal
            new bootstrap.Modal(document.getElementById('editTraineeModal')).show();
        } else {
            showToast('Failed to load trainee details', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('Failed to load trainee details', 'error');
    });
}

// Update Trainee
document.getElementById('editTraineeForm')?.addEventListener('submit', function(e) {
    e.preventDefault();
    
    const traineeId = document.getElementById('edit_rowIndex').value;
    
    const formData = {
        Training_StartDate: document.getElementById('edit_startDate').value,
        Training_EndDate: document.getElementById('edit_endDate').value,
        field_of_specialization: document.getElementById('edit_specialization').value,
        requested_payment_date: document.getElementById('edit_requestedPaymentDate').value,
        payment_start_date: document.getElementById('edit_paymentStartDate').value,
        payment_end_date: document.getElementById('edit_paymentEndDate').value,
        absent_Count: document.getElementById('edit_absentCount').value,
        terminated_date: document.getElementById('edit_terminatedDate').value,
        terminated_reason: document.getElementById('edit_terminatedReason').value
    };

    fetch(`/trainees/${traineeId}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
        },
        body: JSON.stringify(formData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast('Trainee updated successfully!', 'success');
            bootstrap.Modal.getInstance(document.getElementById('editTraineeModal')).hide();
            location.reload(); // Reload to show updated data
        } else {
            showToast('Error: ' + (data.message || 'Failed to update trainee'), 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('Failed to update trainee', 'error');
    });
});

// Delete Trainee - Prepare
let traineeToDelete = null;

function deleteTrainee(traineeId, traineeName) {
    traineeToDelete = traineeId;
    document.getElementById('delete_traineeName').textContent = traineeName;
    new bootstrap.Modal(document.getElementById('deleteTraineeModal')).show();
}

// Confirm Delete
document.getElementById('confirmDeleteBtn')?.addEventListener('click', function() {
    if (!traineeToDelete) return;
    
    fetch(`/trainees/${traineeToDelete}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast('Trainee deleted successfully!', 'success');
            bootstrap.Modal.getInstance(document.getElementById('deleteTraineeModal')).hide();
            location.reload(); // Reload to remove deleted trainee
        } else {
            showToast('Error: ' + (data.message || 'Failed to delete trainee'), 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('Failed to delete trainee', 'error');
    });
});

// Attach event listeners to buttons (will be called after page load)
document.addEventListener('DOMContentLoaded', function() {
    // Attach view button listeners
    document.querySelectorAll('.btn-action-view').forEach(button => {
        button.addEventListener('click', function() {
            const traineeId = this.closest('tr').dataset.traineeId;
            if (traineeId) viewTrainee(traineeId);
        });
    });
    
    // Attach edit button listeners
    document.querySelectorAll('.btn-action-edit').forEach(button => {
        button.addEventListener('click', function() {
            const traineeId = this.closest('tr').dataset.traineeId;
            if (traineeId) editTrainee(traineeId);
        });
    });
    
    // Attach delete button listeners
    document.querySelectorAll('.btn-action-delete').forEach(button => {
        button.addEventListener('click', function() {
            const row = this.closest('tr');
            const traineeId = row.dataset.traineeId;
            const traineeName = row.dataset.traineeName;
            if (traineeId) deleteTrainee(traineeId, traineeName);
        });
    });
});
