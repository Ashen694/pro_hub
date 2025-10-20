@extends('layouts.app')

@section('page-title', 'New Company')

@section('content')
<div class="container">
    <h3>New Company</h3>
    @include('reference-data.companies._form', ['company' => null, 'action' => route('reference-data.companies.store'), 'method' => 'POST'])
</div>
@endsection
