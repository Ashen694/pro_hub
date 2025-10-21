@extends('layouts.app')
@section('page-title','Create')
@section('content')
<div class="container">
    @include('reference-data.divisional-members._form', ['member' => null, 'action' => route('reference-data.divisional-members.store'), 'method' => 'POST'])
</div>
@endsection
