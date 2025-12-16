@extends('layouts.app')
@section('page-title','Create Member')
@section('content')
<style>
    /* White form container with black text */
    .form-container { 
        background: #fff !important; 
        padding: 30px; 
        border-radius: 12px; 
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        max-width: 600px;
        margin: 20px auto;
    }
    .form-container h4, .form-container label, .form-container .form-text { color: #000 !important; }
    .form-container .form-control, .form-container .form-select { 
        color: #000 !important; 
        background: #fff !important; 
        border: 1px solid #ddd !important; 
    }
    .form-container .btn { 
        color: #fff !important; 
        border: none !important; 
    }
    .form-container .btn-secondary {
        background: #6c757d !important;
    }
    .form-container .btn-primary {
        background: #007bff !important;
    }
</style>



<div class="container">
    <div class="form-container">
        <h4 class="mb-4">Create New Member</h4>
        
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        
        <form action="{{ route('reference-data.divisional-members.store') }}" method="POST">
            @csrf
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="service_number" class="form-label">Service Number</label>
                    <input type="text" class="form-control @error('service_number') is-invalid @enderror" 
                           id="service_number" name="service_number" value="{{ old('service_number') }}">
                    @error('service_number')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="name" class="form-label">Full Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                           id="name" name="name" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                           id="email" name="email" value="{{ old('email') }}">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="contact_mobile" class="form-label">Contact Mobile Number</label>
                    <input type="text" class="form-control @error('contact_mobile') is-invalid @enderror" 
                           id="contact_mobile" name="contact_mobile" value="{{ old('contact_mobile') }}">
                    @error('contact_mobile')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="group_name" class="form-label">Group Name</label>
                    <input type="text" class="form-control @error('group_name') is-invalid @enderror" 
                           id="group_name" name="group_name" value="{{ old('group_name') }}">
                    @error('group_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="date_of_birth" class="form-label">Date of Birth</label>
                    <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror" 
                           id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') }}">
                    @error('date_of_birth')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="calling_name" class="form-label">Calling Name</label>
                    <input type="text" class="form-control @error('calling_name') is-invalid @enderror" 
                           id="calling_name" name="calling_name" value="{{ old('calling_name') }}">
                    @error('calling_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="gender" class="form-label">Gender</label>
                    <select class="form-select @error('gender') is-invalid @enderror" id="gender" name="gender">
                        <option value="">Select Gender</option>
                        <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                        <option value="Other" {{ old('gender') == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('gender')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="mb-3">
                <label for="section" class="form-label">Section</label>
                <input type="text" class="form-control @error('section') is-invalid @enderror" 
                       id="section" name="section" value="{{ old('section') }}">
                @error('section')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="member_type" class="form-label">Member Type</label>
                <select class="form-select @error('member_type') is-invalid @enderror" id="member_type" name="member_type">
                    <option value="divisional" {{ old('member_type', 'divisional') == 'divisional' ? 'selected' : '' }}>Divisional Member</option>
                    <option value="view_only" {{ old('member_type') == 'view_only' ? 'selected' : '' }}>View Only User</option>
                </select>
                @error('member_type')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="d-flex justify-content-between">
                <a href="{{ route('reference-data.divisional-members.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Create Member</button>
            </div>
        </form>
    </div>
</div>

<script>
    // No animation needed
</script>
@endsection
