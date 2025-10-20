@extends('layouts.app')
@section('page-title','New Field Of Specialization')
@section('content')
<div class="container">
    <h3>New Field Of Specialization</h3>
    @include('reference-data.fields-of-specializations._form', ['item' => null, 'action' => route('reference-data.fields-of-specializations.store'), 'method' => 'POST'])
</div>
@endsection
