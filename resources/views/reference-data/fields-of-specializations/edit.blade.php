@extends('layouts.app')
@section('page-title','Edit Field')
@section('content')
<div class="container">
    <h3>Edit Field Of Specialization</h3>
    @include('reference-data.fields-of-specializations._form', ['item' => $item, 'action' => route('reference-data.fields-of-specializations.update', $item), 'method' => 'PUT'])
</div>
@endsection
