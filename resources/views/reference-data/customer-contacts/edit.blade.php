@extends('layouts.app')
@section('page-title','Edit Customer Contact')
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
        <h4 class="mb-4">Edit Customer Contact</h4>
        
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        
        <form action="{{ route('reference-data.customer-contacts.update', $contact) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label for="company_id" class="form-label">Company</label>
                <select name="company_id" id="company_id" class="form-control @error('company_id') is-invalid @enderror" required>
                    <option value="">Select company</option>
                    @foreach($companies as $c)
                        <option value="{{ $c->id }}" {{ old('company_id', $contact->company_id) == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                    @endforeach
                </select>
                @error('company_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <select name="title" id="title" class="form-control @error('title') is-invalid @enderror" required>
                    <option value="">Select title</option>
                    @foreach(['Mr','Mrs','Ms','Dr','Prof'] as $t)
                        <option value="{{ $t }}" {{ old('title', $contact->title) == $t ? 'selected' : '' }}>{{ $t }}</option>
                    @endforeach
                </select>
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                       id="name" name="name" value="{{ old('name', $contact->name) }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                       id="email" name="email" value="{{ old('email', $contact->email) }}">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                       id="phone" name="phone" value="{{ old('phone', $contact->phone) }}">
                @error('phone')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="external_platform_id" class="form-label">External Platform/Solution</label>
                <select name="external_platform_id" id="external_platform_id" class="form-control @error('external_platform_id') is-invalid @enderror">
                    <option value="">Select external platform (optional)</option>
                    @foreach($externalPlatforms as $platform)
                        <option value="{{ $platform->platform_id }}" {{ old('external_platform_id', $contact->external_platform_id) == $platform->platform_id ? 'selected' : '' }}>
                            {{ $platform->platform_name }}
                        </option>
                    @endforeach
                </select>
                @error('external_platform_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="role" class="form-label">Role</label>
                <input type="text" class="form-control @error('role') is-invalid @enderror" 
                       id="role" name="role" value="{{ old('role', $contact->role) }}">
                @error('role')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="d-flex justify-content-between">
                <a href="{{ route('reference-data.customer-contacts.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Update Contact</button>
            </div>
        </form>
    </div>
</div>

<script>
    // No animation needed    })();

    // Dynamic External Platform Loading
    document.addEventListener('DOMContentLoaded', function() {
        const companySelect = document.getElementById('company_id');
        const platformSelect = document.getElementById('external_platform_id');
        
        if (companySelect && platformSelect) {
            companySelect.addEventListener('change', function() {
                const companyId = this.value;
                const currentPlatformId = '{{ old('external_platform_id', $contact->external_platform_id) }}';
                
                // Clear current options except the first one
                platformSelect.innerHTML = '<option value="">Select external platform (optional)</option>';
                
                if (companyId) {
                    // Show loading state
                    platformSelect.innerHTML = '<option value="">Loading platforms...</option>';
                    
                    // Fetch external platforms for this company
                    fetch(`{{ route('reference-data.customer-contacts.external-platforms') }}?company_id=${companyId}`)
                        .then(response => response.json())
                        .then(platforms => {
                            // Clear loading state
                            platformSelect.innerHTML = '<option value="">Select external platform (optional)</option>';
                            
                            // Add platforms to dropdown
                            platforms.forEach(platform => {
                                const option = document.createElement('option');
                                option.value = platform.platform_id;
                                option.textContent = platform.platform_name;
                                // Maintain selection if editing
                                if (platform.platform_id == currentPlatformId) {
                                    option.selected = true;
                                }
                                platformSelect.appendChild(option);
                            });
                        })
                        .catch(error => {
                            console.error('Error fetching platforms:', error);
                            platformSelect.innerHTML = '<option value="">Error loading platforms</option>';
                        });
                }
            });
        }
    });
</script>
@endsection
