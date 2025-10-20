@extends('layouts.app')
@section('page-title','New Member')
@section('content')
<div class="container">
    <h3>New Divisional Member</h3>
    @include('reference-data.divisional-members._form', ['member' => null, 'action' => route('reference-data.divisional-members.store'), 'method' => 'POST'])
</div>
@endsection
