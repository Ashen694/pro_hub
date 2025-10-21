@extends('layouts.app')
@section('page-title','Edit Member')
@section('content')
<div class="container">
    <h3>Edit Member</h3>
    @include('reference-data.divisional-members._form', ['member' => $member, 'action' => route('reference-data.divisional-members.update', $member), 'method' => 'PUT'])
</div>
@endsection
