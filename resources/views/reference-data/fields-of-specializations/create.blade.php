@extends('layouts.app')
@section('page-title','Create')
@section('content')
<div class="container">
    @include('reference-data.fields-of-specializations._form', ['item' => null, 'action' => route('reference-data.fields-of-specializations.store'), 'method' => 'POST'])
</div>
@endsection
