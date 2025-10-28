@extends('layouts.app')
@section('page-title','Edit Contact')
@section('content')
<div class="container">
    <h3>Edit Customer Contact</h3>
    @include('reference-data.customer-contacts._form', ['contact' => $contact, 'action' => route('reference-data.customer-contacts.update', $contact), 'method' => 'PUT', 'companies' => $companies])
</div>
@endsection
