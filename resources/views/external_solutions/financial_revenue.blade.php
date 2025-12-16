@extends('layouts.app')

@section('page-title', $title)

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title mb-0">{{ $title }}</h3>
        <p class="text-muted mb-0">for all the projects currently active for particular year</p>
    </div>

    {{-- Flash Messages --}}
    @if (session()->has('success'))
        <div class="alert alert-success m-3">{{ session('success') }}</div>
    @endif
    @if (session()->has('error'))
        <div class="alert alert-danger m-3">{{ session('error') }}</div>
    @endif

    <div class="card-body">
        <div class="table-responsive" style="border:4px solid #000; padding:0;">
            <table class="table table-sm mb-0">
                <thead>
                    <tr>
                        <th style="width:80px">Year</th>
                        <th>OTC Total</th>
                        <th>MRC Total from projects launched in the year</th>
                        <th>MRC Total from projects launched in previous years</th>
                        <th>Grand Total</th>
                        <th style="width:110px"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($years as $year)
                        <tr>
                            <td class="align-middle">{{ $year }}</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td class="text-end"><a href="#" class="btn btn-sm btn-link">Details</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
