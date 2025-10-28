@extends('layouts.app')
@section('page-title','Customer Contacts')
@section('content')
<div class="container">
    {{-- Page title is rendered by layout; remove duplicate heading per design --}}
    @include('reference-data.customer-contacts._form', ['contact' => null, 'action' => route('reference-data.customer-contacts.store'), 'method' => 'POST', 'companies' => $companies])
</div>
@endsection
