@extends('layouts.app')

@section('page-title', 'Add New Company/Customer')

@section('content')
<div class="container pt-4">
    <div class="mt-3">
        @include('reference-data.companies._form', ['company' => null, 'action' => route('reference-data.companies.store'), 'method' => 'POST'])
    </div>
</div>
@endsection
