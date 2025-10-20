@extends('layouts.app')
@section('page-title','New Application Group')
@section('content')
<div class="container">
    <h3>New Application Group</h3>
    @include('reference-data.application-groups._form', ['group' => null, 'action' => route('reference-data.application-groups.store'), 'method' => 'POST'])
</div>
@endsection
