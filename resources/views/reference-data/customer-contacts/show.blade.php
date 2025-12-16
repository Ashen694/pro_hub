@extends('layouts.app')
@section('page-title','Customer Contact Details')
@section('content')
<style>
    /* White details container with black text */
    .details-container { 
        background: #fff !important; 
        padding: 30px; 
        border-radius: 12px; 
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        max-width: 600px;
        margin: 20px auto;
    }
    .details-container h4, .details-container label, .details-container p, .details-container strong { 
        color: #000 !important; 
    }
    .details-container .btn { 
        color: #fff !important; 
        border: none !important; 
    }
    .details-container .btn-secondary {
        background: #6c757d !important;
    }
    .details-container .btn-primary {
        background: #007bff !important;
    }
    .details-container .btn-danger {
        background: #dc3545 !important;
    }
    .detail-row { 
        border-bottom: 1px solid #eee; 
        padding: 15px 0; 
    }
    .detail-row:last-child { 
        border-bottom: none; 
    }
</style>


<div class="container">
    <div class="details-container">
        <h4 class="mb-4">Customer Contact Details</h4>
        
        <div class="detail-row">
            <strong>Name:</strong>
            <p class="mb-0 mt-2">{{ $contact->name }}</p>
        </div>
        
        <div class="detail-row">
            <strong>Title:</strong>
            <p class="mb-0 mt-2">{{ $contact->title ?? 'Not specified' }}</p>
        </div>
        
        <div class="detail-row">
            <strong>Email:</strong>
            <p class="mb-0 mt-2">{{ $contact->email ?? 'Not provided' }}</p>
        </div>
        
        <div class="detail-row">
            <strong>Phone:</strong>
            <p class="mb-0 mt-2">{{ $contact->phone ?? 'Not provided' }}</p>
        </div>
        
        <div class="detail-row">
            <strong>Company:</strong>
            <p class="mb-0 mt-2">{{ optional($contact->company)->name ?? 'Not assigned' }}</p>
        </div>
        
        <div class="detail-row">
            <strong>Role:</strong>
            <p class="mb-0 mt-2">{{ $contact->role ?? 'Not specified' }}</p>
        </div>
        
        <div class="detail-row">
            <strong>Created:</strong>
            <p class="mb-0 mt-2">{{ $contact->created_at->format('M d, Y \a\t g:i A') }}</p>
        </div>
        
        <div class="detail-row">
            <strong>Last Updated:</strong>
            <p class="mb-0 mt-2">{{ $contact->updated_at->format('M d, Y \a\t g:i A') }}</p>
        </div>
        
        <div class="d-flex justify-content-between mt-4">
            <a href="{{ route('reference-data.customer-contacts.index') }}" class="btn btn-secondary">Back to List</a>
            <div>
                <a href="{{ route('reference-data.customer-contacts.edit', $contact) }}" class="btn btn-primary me-2">Edit</a>
                <form action="{{ route('reference-data.customer-contacts.destroy', $contact) }}" method="POST" style="display:inline" onsubmit="return confirm('Are you sure you want to delete this contact?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // No animation needed    })();
</script>
@endsection

