@extends('layouts.app')

@section('page-title', 'Edit Company')

@section('content')
<div class="container">
    <h3>Edit Company</h3>
    @include('reference-data.companies._form', ['company' => $company, 'action' => route('reference-data.companies.update', $company), 'method' => 'PUT'])
</div>
@endsection
