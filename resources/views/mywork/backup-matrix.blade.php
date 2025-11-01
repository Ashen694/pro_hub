@extends('layouts.app')

@section('title', 'Backup Matrix')

@section('page-title', 'My Applications – Backup Matrix')

@push('styles')
    @vite(['resources/css/backup-matrix.css'])
@endpush

@push('scripts')
    @vite(['resources/js/backup-matrix.js'])
@endpush

@section('content')
    @php
        $role        = (string) (Auth::user()->role ?? '');
        $isAdmin     = $role === 'Administrator';
        $exportScope = $isAdmin ? 'all' : 'mine';
        $exportLabel = 'Download Excel';
        $noteText    = $isAdmin
            ? 'As an Administrator, your export will include all applications, including application name, Backup #1, and Backup #2.'
            : 'Your export includes only applications where you are listed as Backup #1 or Backup #2.';
        
        $userName  = trim((string) (Auth::user()->name ?? ''));
        $nameLower = mb_strtolower($userName, 'UTF-8');
        $hasBackup = false;
        if (!$isAdmin && $nameLower !== '') {
            $hasBackup = \App\Models\InternalPlatform::query()
                ->whereRaw('LOWER(BackupOfficer_1) = ?', [$nameLower])
                ->orWhereRaw('LOWER(BackupOfficer_2) = ?', [$nameLower])
                ->exists();
        }
    @endphp

    <div class="slt-card max-w-5xl mx-auto">
        @if (session('status'))
            <div class="mb-4 rounded-md p-3" style="background:#ecf7ef;border:1px solid #cfe9d4;color:#0d4a1b;font-weight:700;">{{ session('status') }}</div>
        @endif

        <p class="slt-muted mb-2">Click <strong>Download Excel</strong> to export the matrix for applications where you are a backup officer.</p>
        <p class="slt-muted mb-5"><em>{{ $noteText }}</em></p>
        
        <div class="slt-actions">
            <a id="downloadBackupMatrix" href="{{ route('my-work.backup-matrix.download', ['scope' => $exportScope]) }}" class="slt-btn slt-btn-primary" data-is-admin="{{ $isAdmin ? '1' : '0' }}" data-has-backup="{{ $hasBackup ? '1' : '0' }}">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                {{ $exportLabel }}
            </a>
            <a href="{{ route('my-work.weekly.update') }}" class="slt-btn slt-btn-outline" title="Back to Weekly Plan list">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
                Back
            </a>
        </div>
    </div>

    {{-- No-Backups Modal --}}
    <div id="sltNoBackupModal" class="slt-modal-backdrop" aria-hidden="true">
        <div role="dialog" aria-modal="true" aria-labelledby="sltNoBackupTitle" class="slt-modal">
            <div class="slt-modal-head"><div class="slt-modal-title" id="sltNoBackupTitle">Export Backup Matrix</div><button type="button" class="slt-x" id="sltNoBackupClose">&times;</button></div>
            <div class="slt-alert" role="alert">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                <span><strong>No backup assignments found.</strong></span>
            </div>
            <div class="slt-modal-body"><dl class="slt-kv"><dt>Signed-in User</dt><dd>{{ $userName ?: 'Unknown User' }}</dd></dl></div>
            <div class="slt-modal-actions">
                <button type="button" class="slt-btn slt-btn-outline" id="sltNoBackupCancel">Close</button>
                <a href="{{ route('my-work.weekly.update') }}" class="slt-btn slt-btn-primary">Go to Weekly Plan</a>
            </div>
        </div>
    </div>
@endsection