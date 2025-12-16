@extends('layouts.app')
@section('page-title','Edit Field Of Specialization')
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
        <h4 class="mb-4">Edit Field Of Specialization</h4>
        
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        
        <form action="{{ route('reference-data.fields-of-specializations.update', $item) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label for="name" class="form-label">Field Of Specialization</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                       id="name" name="name" value="{{ old('name', $item->name) }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="notes" class="form-label">Description</label>
                <textarea class="form-control @error('notes') is-invalid @enderror" 
                          id="notes" name="notes" rows="4">{{ old('notes', $item->notes) }}</textarea>
                @error('notes')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="d-flex justify-content-between">
                <a href="{{ route('reference-data.fields-of-specializations.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Update Field</button>
            </div>
        </form>
    </div>
</div>

<script>
    // No animation needed    })();
</script>
@endsection
