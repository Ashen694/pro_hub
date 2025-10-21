@extends('layouts.app')
@section('page-title','Create')
@section('content')
<div class="container">
    @include('reference-data.application-groups._form', ['group' => null, 'action' => route('reference-data.application-groups.store'), 'method' => 'POST'])
</div>
@endsection
