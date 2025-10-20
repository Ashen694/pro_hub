@extends('layouts.app')
@section('page-title','Edit Application Group')
@section('content')
<div class="container">
    <h3>Edit Application Group</h3>
    @include('reference-data.application-groups._form', ['group' => $group, 'action' => route('reference-data.application-groups.update', $group), 'method' => 'PUT'])
</div>
@endsection
