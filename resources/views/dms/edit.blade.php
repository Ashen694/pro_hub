@extends('layouts.app')

@section('page-title', $title)

@push('styles')
<style>
    .disabled-field {
        background-color: #f8f9fa;
        cursor: not-allowed;
    }
</style>
@endpush

@section('content')
<form action="{{ route('dms.update', $document->ID) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Edit Document</h3>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="row">
                <div class="col-md-8 mx-auto">
                    {{-- Non-Editable Fields --}}
                    <div class="mb-3">
                        <label class="form-label">Platform</label>
                        <input type="text" class="form-control disabled-field" value="{{ $platformType }}" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Solution</label>
                        <input type="text" class="form-control disabled-field" value="{{ $document->internalSolution->App_Name ?? 'N/A' }}" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Uploaded By</label>
                        <input type="text" class="form-control disabled-field" value="{{ $document->uploader->name ?? 'N/A' }}" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Document Type</label>
                        <input type="text" class="form-control disabled-field" value="{{ $document->Doc_Type }}" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Document URL</label>
                        <input type="text" class="form-control disabled-field" value="{{ $document->Doc_URL }}" disabled>
                    </div>
                    
                    <hr class="my-4">

                    {{-- Editable Fields --}}
                    <div class="mb-3">
                        <label class="form-label required">Document Name</label>
                        <input type="text" class="form-control" name="Doc_Name" value="{{ old('Doc_Name', $document->Doc_Name) }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Document Classification</label>
                        <input type="text" class="form-control" name="Doc_classification" value="{{ old('Doc_classification', $document->Doc_classification) }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tags</label>
                        <input type="text" class="form-control" name="Tags" value="{{ old('Tags', $document->Tags) }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label required">Confidentiality</label>
                        <select class="form-select" name="Confidential">
                            <option value="Low" {{ old('Confidential', $document->Confidential) == 'Low' ? 'selected' : '' }}>Low</option>
                            <option value="Medium" {{ old('Confidential', $document->Confidential) == 'Medium' ? 'selected' : '' }}>Medium</option>
                            <option value="High" {{ old('Confidential', $document->Confidential) == 'High' ? 'selected' : '' }}>High</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer text-end">
            <a href="{{ route('dms.index', ['type' => ($document->Platform_ID == 1 ? 'internal' : 'external')]) }}" class="btn btn-link">Back to List</a>
            <button type="submit" class="btn btn-primary">Save Changes</button>
        </div>
    </div>
</form>
@endsection