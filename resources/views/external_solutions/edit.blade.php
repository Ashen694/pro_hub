@extends('layouts.app')

@section('page-title', $title ?? 'Edit External Solution')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ $title ?? 'Edit External Solution' }}</h3>
    </div>
    <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('external-solutions.update', $externalSolution->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Application/Platform Name</label>
                        <input type="text" name="application_name" value="{{ old('application_name', $externalSolution->application_name) }}" class="form-control">
                    </div>
                    <!-- Add more fields as needed, similar to create.blade.php -->
                </div>
            </div>

            <div class="mt-3">
                <button class="btn btn-primary">Save</button>
                <a href="{{ route('external-solutions.index', ['status' => 'operational']) }}" class="btn btn-link">Back to List</a>
            </div>
        </form>
    </div>
</div>
@endsection
