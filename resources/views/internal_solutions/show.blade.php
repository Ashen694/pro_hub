@extends('layouts.app')

@section('page-title', 'Details - ' . $solution->App_Name)

@push('styles')
<style>
    .detail-item .detail-label { color: #626976; font-weight: 600; display: flex; align-items: center; }
    .detail-item .detail-label .icon { margin-right: 8px; }
    .detail-item .detail-value { font-weight: 500; word-break: break-all; }
    .card-header .card-title { line-height: 1.2; }
</style>
@endpush

@section('content')
<div class="mb-4">
    <a href="{{ url()->previous() }}" class="btn btn-outline-primary">
        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M9 14l-4 -4l4 -4"></path><path d="M5 10h11a4 4 0 0 1 0 8h-1"></path></svg>
        Back to List
    </a>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card">
            @if($solution->App_Category == 'Change Request')
                <div class="ribbon bg-yellow">Change Request</div>
            @else
                <div class="ribbon bg-blue">Main Application</div>
            @endif

            <div class="card-header">
                <div>
                    <h3 class="card-title">{{ $solution->App_Name }}</h3>
                    @if ($solution->mainApplicationParent)
                        <p class="text-muted mb-0 fst-italic">A Change Request of <a href="{{ route('internal-solutions.show', $solution->mainApplicationParent->ID) }}">{{ $solution->mainApplicationParent->App_Name }}</a></p>
                    @endif
                </div>
            </div>
            <div class="card-body">
                <div class="hr-text">Key Details</div>
                <div class="row">
                    <div class="col-md-6 mb-3 detail-item">
                        <div class="detail-label"><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-tag" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M11 3l9 9a1.5 1.5 0 0 1 0 2l-6 6a1.5 1.5 0 0 1 -2 0l-9 -9v-4a2 2 0 0 1 2 -2h4" /><circle cx="9" cy="9" r="2" /></svg>Application Group</div>
                        <div class="detail-value">{{ $solution->parentProject->ParentProjectGroup ?? 'N/A' }}</div>
                    </div>
                     <div class="col-md-6 mb-3 detail-item">
                        <div class="detail-label"><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-id" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><rect x="3" y="4" width="18" height="16" rx="3" /><circle cx="9" cy="10" r="2" /><line x1="15" y1="8" x2="17" y2="8" /><line x1="15" y1="12" x2="17" y2="12" /><line x1="7" y1="16" x2="17" y2="16" /></svg>Business Owner</div>
                        <div class="detail-value">{{ $solution->Bus_Owner ?? '-' }}</div>
                    </div>
                    <div class="col-md-6 mb-3 detail-item">
                        <div class="detail-label"><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="7" r="4" /><path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" /></svg>Developed By</div>
                        <div class="detail-value">{{ $solution->Developed_By ?? '-' }}</div>
                    </div>
                    <div class="col-md-6 mb-3 detail-item">
                        <div class="detail-label"><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-users" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="9" cy="7" r="4" /><path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" /><path d="M16 3.13a4 4 0 0 1 0 7.75" /><path d="M21 21v-2a4 4 0 0 0 -3 -3.85" /></svg>Developed Team</div>
                        <div class="detail-value">{{ $solution->Developed_Team ?? '-' }}</div>
                    </div>
                </div>

                <div class="hr-text mt-3">Technical Information</div>
                 <div class="row">
                    <div class="col-md-6 mb-3 detail-item">
                        <div class="detail-label"><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-brand-bitbucket" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3.641 4.502a.34 .34 0 0 0 -.341 .342v14.314a.34 .34 0 0 0 .341 .342h16.718a.34 .34 0 0 0 .341 -.342v-14.314a.34 .34 0 0 0 -.341 -.342h-16.718z" /><path d="M14 15l-2 -3l-2 3" /><path d="M12 12v-5" /></svg>BitBucket Repo</div>
                        <div class="detail-value">@if($solution->BIT_bucket_repo)<a href="{{ $solution->BIT_bucket_repo }}" target="_blank" rel="noopener noreferrer">{{ $solution->BIT_bucket_repo }}</a>@else - @endif</div>
                    </div>
                    <div class="col-md-6 mb-3 detail-item">
                        <div class="detail-label"><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-link" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 14a3.5 3.5 0 0 0 5 0l4 -4a3.5 3.5 0 0 0 -5 -5l-.5 .5" /><path d="M14 10a3.5 3.5 0 0 0 -5 0l-4 4a3.5 3.5 0 0 0 5 5l.5 -.5" /></svg>Application URL</div>
                        <div class="detail-value">@if($solution->App_URL)<a href="{{ $solution->App_URL }}" target="_blank" rel="noopener noreferrer">{{ $solution->App_URL }}</a>@else - @endif</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header"><h3 class="card-title">Project Timeline & Status</h3></div>
            <div class="card-body">
                <div class="mb-3 detail-item">
                    <div class="detail-label"><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-progress" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 20.777a8.942 8.942 0 0 1 -2.48 -.969" /><path d="M14 3.223a9.003 9.003 0 0 1 0 17.554" /><path d="M4.579 17.093a8.961 8.961 0 0 1 -1.227 -2.592" /><path d="M3.124 10.5c.16 -.95 .468 -1.85 .9 -2.675" /><path d="M6.907 4.579a8.954 8.954 0 0 1 3.093 -1.356" /></svg>SDLC Phase</div>
                    <div class="detail-value"><span class="badge bg-blue-lt">{{ $solution->SDLCPhase ?? '-' }}</span></div>
                </div>
                <div class="mb-3 detail-item">
                    <div class="detail-label"><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-calendar-event" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><rect x="4" y="5" width="16" height="16" rx="2" /><line x1="16" y1="3" x2="16" y2="7" /><line x1="8" y1="3" x2="8" y2="7" /><line x1="4" y1="11" x2="20" y2="11" /><rect x="8" y="15" width="2" height="2" /></svg>Start Date</div>
                    <div class="detail-value">{{ $solution->StartDate ?? '-' }}</div>
                </div>
                <div class="mb-3 detail-item">
                    <div class="detail-label"><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-calendar-due" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 5m0 2a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2z" /><path d="M16 3v4" /><path d="M8 3v4" /><path d="M4 11h16" /><path d="M12 16m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" /></svg>Target Date</div>
                    <div class="detail-value">{{ $solution->TargetDate ?? '-' }}</div>
                </div>
                 <div class="mb-3 detail-item">
                    <div class="detail-label"><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-calendar-stats" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M11.5 21h-5.5a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v4" /><path d="M16 3v4" /><path d="M8 3v4" /><path d="M4 11h16" /><path d="M16 19l2 2l4 -4" /><path d="M15 14l-2 2l-2 -2" /></svg>UAT Date</div>
                    <div class="detail-value">{{ $solution->UATDate ?? '-' }}</div>
                </div>
                <div class="mb-3 detail-item">
                    <div class="detail-label"><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-calendar-check" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M11.5 21h-5.5a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v6" /><path d="M16 3v4" /><path d="M8 3v4" /><path d="M4 11h16" /><path d="M15 19l2 2l4 -4" /></svg>Launched Date</div>
                    <div class="detail-value">{{ $solution->LaunchedDate ?? '-' }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection