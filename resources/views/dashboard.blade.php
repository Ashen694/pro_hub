@extends('layouts.app')

@section('page-title', 'Dashboard')

@section('content')

{{-- Inline CSS --}}
<style>
    /* 3-card layout */
    .stats-row {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 22px;
        margin-top: 25px;
    }

    /* Square card style */
    .stat-card {
        height: 180px; /* width will be larger automatically */
        border-radius: 14px;
        padding: 22px;
        color: #fff;
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        position: relative;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0,0,0,0.15);
        transition: 0.25s ease;
    }

    .stat-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 10px 28px rgba(0,0,0,0.20);
    }

    /* Icon style */
    .stat-icon {
        position: absolute;
        top: 18px;
        right: 18px;
        font-size: 40px;
        opacity: 0.4;
    }

    .stat-title {
        font-size: 15px;
        font-weight: 600;
        text-transform: uppercase;
        opacity: 0.8;
    }

    .stat-value {
        font-size: 46px;
        font-weight: 700;
        margin-top: 8px;
        line-height: 1;
    }

    .stat-desc {
        font-size: 13px;
        opacity: 0.8;
        margin-top: 4px;
    }

    /* Card Colors */
    .card-blue { background: linear-gradient(135deg, #3b82f6, #1d4ed8); }
    .card-green { background: linear-gradient(135deg, #22c55e, #15803d); }
    .card-purple { background: linear-gradient(135deg, #a855f7, #7e22ce); }
</style>

{{-- Include FontAwesome for icons --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

<div class="stats-row">

    {{-- Total Employees Card --}}
    <div class="stat-card card-blue">
        <i class="fa-solid fa-users stat-icon"></i>
        <div class="stat-title">Total Employees</div>
        <div class="stat-value">{{ $employeeCount }}</div>
        <div class="stat-desc">Active members in your company</div>
    </div>

    {{-- Example Card 2 --}}
    <div class="stat-card card-green">
        <i class="fa-solid fa-building stat-icon"></i>
        <div class="stat-title">Freelancers</div>
        <div class="stat-value">{{ $freelancerCount }}</div>
        <div class="stat-desc">Active organizational units</div>
    </div>

    {{-- Example Card 3 --}}
    <div class="stat-card card-purple">
        <i class="fa-solid fa-user-check stat-icon"></i>
        <div class="stat-title">New Joinees</div>
        <div class="stat-value">05</div>
        <div class="stat-desc">Employees added this month</div>
    </div>

</div>

@endsection
