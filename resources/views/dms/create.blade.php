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
<form action="{{ route('dms.store', ['type' => $type]) }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ $title }}</h3>
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
                    <div class="mb-3">
                        <label class="form-label">Platform</label>
                        <input type="text" class="form-control disabled-field" value="{{ ucfirst($type) }}" disabled>
                    </div>

                    <div class="mb-3">
                        <label class="form-label required">Solution</label>
                        <select class="form-select" name="solution_id">
                            <option value="" selected disabled>Please select a solution</option>
                            @foreach($solutions as $solution)
                                <option value="{{ $type === 'internal' ? $solution->ID : $solution->platform_id }}" {{ old('solution_id') == ($type === 'internal' ? $solution->ID : $solution->platform_id) ? 'selected' : '' }}>
                                    {{ $type === 'internal' ? $solution->App_Name : $solution->platform_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label required">Document Name</label>
                        <input type="text" class="form-control" name="doc_name" placeholder="Enter document name" value="{{ old('doc_name') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Uploaded By</label>
                        <input type="text" class="form-control disabled-field" value="{{ $currentUser->name }}" disabled>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Document Classification</label>
                        <input type="text" class="form-control" name="doc_classification" placeholder="e.g., UAT Document, FRD" value="{{ old('doc_classification') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tags</label>
                        <input type="text" class="form-control" name="tags" placeholder="Comma separated tags (e.g., billing, new, high-priority)" value="{{ old('tags') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label required">Confidentiality</label>
                        <select class="form-select" name="confidentiality">
                            {{-- Confidentiality සඳහා ද placeholder එකක් යෙදීම වඩාත් සුදුසුය --}}
                            <option value="" @if(!old('confidentiality')) selected @endif disabled>Select confidentiality</option>
                            <option value="Low" {{ old('confidentiality') == 'Low' ? 'selected' : '' }}>Low</option>
                            <option value="Medium" {{ old('confidentiality') == 'Medium' ? 'selected' : '' }}>Medium</option>
                            <option value="High" {{ old('confidentiality') == 'High' ? 'selected' : '' }}>High</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label required">Document File</label>
                        <input type="file" class="form-control" name="document_file">
                    </div>

                </div>
            </div>
        </div>
        <div class="card-footer text-end">
            <a href="{{ route('dms.index', ['type' => $type]) }}" class="btn btn-link">Back to List</a>
            <button type="submit" class="btn btn-primary">Create</button>
        </div>
    </div>
</form>
@endsection