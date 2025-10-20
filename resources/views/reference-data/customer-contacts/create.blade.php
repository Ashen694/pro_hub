@extends('layouts.app')
@section('page-title','New Contact')
@section('content')
<div class="container">
    <h3>New Customer Contact</h3>
    @include('reference-data.customer-contacts._form', ['contact' => null, 'action' => route('reference-data.customer-contacts.store'), 'method' => 'POST', 'companies' => $companies])
</div>
@endsection
