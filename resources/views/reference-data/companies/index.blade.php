@extends('layouts.app')

@section('page-title', 'Companies/Customers')

@section('content')
<style>
    /* Page-scoped: dark table like other lists */
    .companies-page table thead th { color:#fff !important; background:transparent !important; }
    .companies-page table tbody td { color:#fff !important; }
    .companies-page .link-details { color:#0dcaf0 !important; } /* match Details color used elsewhere */
</style>

<!-- Particle Background -->
<div class="slt-bg-wrap" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: -1; background: transparent;">
    <canvas id="particleCanvas" style="width: 100%; height: 100%;"></canvas>
</div>
<div class="container companies-page">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <div>
            <div class="mt-2">
                <a href="{{ route('reference-data.companies.create') }}" class="btn btn-primary btn-sm">Create New</a>
            </div>
        </div>
        <div class="text-end">
            {{-- right-side Create New removed per design; left 'Create New' link is primary --}}
        </div>
    </div>
    <div class="row mb-2 align-items-center">
        <div class="col-md-6">
            <div class="d-flex align-items-center">
                <label class="me-2 small">Show</label>
                <form id="perPageForm" method="GET">
                    <input type="hidden" name="q" value="{{ $q }}" />
                    <select name="perPage" onchange="document.getElementById('perPageForm').submit()" class="form-select form-select-sm" style="width:80px; display:inline-block; color:#000; background-color:#fff; border: 1px solid #ccc;">
                        <option value="10" {{ $perPage == 10 ? 'selected' : '' }} style="color:#000; background-color:#fff;">10</option>
                        <option value="25" {{ $perPage == 25 ? 'selected' : '' }} style="color:#000; background-color:#fff;">25</option>
                        <option value="50" {{ $perPage == 50 ? 'selected' : '' }} style="color:#000; background-color:#fff;">50</option>
                        <option value="100" {{ $perPage == 100 ? 'selected' : '' }} style="color:#000; background-color:#fff;">100</option>
                    </select>
                    <label class="ms-2 small">entries</label>
                </form>
            </div>
        </div>
        <div class="col-md-6 text-end">
            <form method="GET" class="d-inline-block">
                <input type="hidden" name="perPage" value="{{ $perPage }}" />
                <label class="small me-2">Search:</label>
                <input type="text" name="q" value="{{ $q }}" class="form-control form-control-sm d-inline-block" style="width:200px; display:inline-block;" />
                <button class="btn btn-sm btn-secondary ms-2" type="submit">Go</button>
            </form>
        </div>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th style="width:70%">Company_Name</th>
                <th style="width:30%"></th>
            </tr>
        </thead>
        <tbody>
            @forelse($companies as $company)
                <tr>
                    <td style="min-height:150px; vertical-align:top">&nbsp;{{ $company->name }}</td>
                    <td class="align-top">
                        <div class="small">
                            <a href="{{ route('reference-data.companies.edit', $company) }}">Edit</a> |
                            <a href="#" class="link-details">Details</a> |
                            <form action="{{ route('reference-data.companies.destroy', $company) }}" method="POST" style="display:inline" onsubmit="return confirm('Delete this company?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-link p-0 text-danger">Delete</button>
                            </form> |
                            <a href="#">Customer Contacts</a>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="2">No companies found.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="d-flex justify-content-between align-items-center">
        <?php
            $from = ($companies->currentPage() - 1) * $companies->perPage() + 1;
            $to = min($companies->currentPage() * $companies->perPage(), $companies->total());
        ?>
    <div class="small text-muted">Showing {{ $from }} to {{ $to }} of {{ $companies->total() }} entries</div>
        <div>
            <?php $current = $companies->currentPage(); $last = $companies->lastPage(); ?>
            <nav aria-label="Page navigation">
                <ul class="pagination mb-0">
                    <li class="page-item {{ $current == 1 ? 'disabled' : '' }}"><a class="page-link" href="{{ $companies->url(max(1, $current - 1)) }}">Previous</a></li>
                    @for ($p = 1; $p <= min(4, $last); $p++)
                        <li class="page-item {{ $p == $current ? 'active' : '' }}"><a class="page-link" href="{{ $companies->url($p) }}">{{ $p }}</a></li>
                    @endfor
                    <li class="page-item {{ $current == $last ? 'disabled' : '' }}"><a class="page-link" href="{{ $companies->url(min($last, $current + 1)) }}">Next</a></li>
                </ul>
            </nav>
        </div>
    </div>
</div>

<script>
        // Particles
        (function() {
            const canvas = document.getElementById('particleCanvas');
            const ctx = canvas.getContext('2d');
            function resizeCanvas() {
                canvas.width = window.innerWidth;
                canvas.height = document.querySelector('.slt-bg-wrap').offsetHeight;
            }
            resizeCanvas();
            window.addEventListener('resize', resizeCanvas);

            const colors = ['#2258a7', '#46b6ef', '#5fb545'];
            class Particle {
                constructor() {
                    this.x = Math.random() * canvas.width;
                    this.y = Math.random() * canvas.height;
                    this.vx = (Math.random() - 0.5) * 0.5;
                    this.vy = (Math.random() - 0.5) * 0.5;
                    this.radius = Math.random() * 2.5 + 1.5;
                    this.color = colors[Math.floor(Math.random() * colors.length)];
                    this.alpha = Math.random() * 0.5 + 0.5;
                }
                update() {
                    this.x += this.vx; this.y += this.vy;
                    if (this.x < 0 || this.x > canvas.width) this.vx *= -1;
                    if (this.y < 0 || this.y > canvas.height) this.vy *= -1;
                }
                draw() {
                    ctx.beginPath();
                    ctx.arc(this.x, this.y, this.radius, 0, Math.PI * 2);
                    ctx.fillStyle = this.color;
                    ctx.globalAlpha = this.alpha;
                    ctx.fill();
                    ctx.globalAlpha = 1;
                    ctx.shadowBlur = 15;
                    ctx.shadowColor = this.color;
                    ctx.fill();
                    ctx.shadowBlur = 0;
                }
            }
            const particleCount = window.innerWidth < 768 ? 60 : 120;
            const particles = Array.from({ length: particleCount }, () => new Particle());
            function drawConnections() {
                const maxDistance = 180;
                for (let i = 0; i < particles.length; i++) {
                    for (let j = i + 1; j < particles.length; j++) {
                        const dx = particles[i].x - particles[j].x;
                        const dy = particles[i].y - particles[j].y;
                        const distance = Math.sqrt(dx * dx + dy * dy);
                        if (distance < maxDistance) {
                            const opacity = (1 - distance / maxDistance) * 0.5;
                            ctx.beginPath();
                            ctx.strokeStyle = `rgba(200, 200, 200, ${opacity})`;
                            ctx.lineWidth = 1;
                            ctx.moveTo(particles[i].x, particles[i].y);
                            ctx.lineTo(particles[j].x, particles[j].y);
                            ctx.stroke();
                        }
                    }
                }
            }
            (function animate() {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                particles.forEach(p => { p.update(); p.draw(); });
                drawConnections();
                requestAnimationFrame(animate);
            })();
        })();

        // Details modal
        const detailsBackdrop = document.getElementById('sltModalBackdrop');
        function fillDetails(btn){
            document.getElementById('sltModalWeek').textContent      = btn.dataset.week || '—';
            document.getElementById('sltModalExternal').textContent  = btn.dataset.external || '—';
            document.getElementById('sltModalInternal').textContent  = btn.dataset.internal || '—';
            document.getElementById('sltModalDetails').textContent   = btn.dataset.details || '—';
            document.getElementById('sltModalUpdatedBy').textContent = btn.dataset.updatedBy || '—';
            document.getElementById('sltModalUpdatedAt').textContent = btn.dataset.updatedAt || '—';
        }
        function openSltModal(btn){ fillDetails(btn); detailsBackdrop.style.display='flex'; document.body.style.overflow='hidden'; }
        function closeSltModal(){ detailsBackdrop.style.display='none'; document.body.style.overflow=''; }
        window.closeSltModal = closeSltModal;

        document.addEventListener('click', (e)=>{
            const d = e.target.closest('.slt-details-btn');
            if(d){ openSltModal(d); }
        });
        detailsBackdrop.addEventListener('click', (e)=>{ if(e.target===detailsBackdrop) closeSltModal(); });
        document.addEventListener('keydown', (e)=>{ if(e.key==='Escape' && detailsBackdrop.style.display==='flex') closeSltModal(); });

        // Delete modal
        const deleteBackdrop = document.getElementById('sltDeleteBackdrop');
        const deleteWeekSpan = document.getElementById('sltDeleteWeek');
        const confirmDeleteBtn = document.getElementById('sltConfirmDeleteBtn');
        let deleteFormRef = null;

        function openDeleteModal(formEl, label){
            deleteFormRef = formEl;
            deleteWeekSpan.textContent = label || '—';
            deleteBackdrop.style.display='flex';
            document.body.style.overflow='hidden';
        }
        function closeDeleteModal(){
            deleteBackdrop.style.display='none';
            document.body.style.overflow='';
            deleteFormRef = null;
        }
        window.closeDeleteModal = closeDeleteModal;

        document.addEventListener('click', (e)=>{
            const btn = e.target.closest('.slt-delete-btn');
            if(!btn) return;
            const form = btn.closest('.slt-delete-form');
            openDeleteModal(form, btn.dataset.label);
        });

        confirmDeleteBtn.addEventListener('click', ()=>{
            if(deleteFormRef){ deleteFormRef.submit(); }
        });

        deleteBackdrop.addEventListener('click', (e)=>{ if(e.target===deleteBackdrop) closeDeleteModal(); });
        document.addEventListener('keydown', (e)=>{ if(e.key==='Escape' && deleteBackdrop.style.display==='flex') closeDeleteModal(); });
    </script>
@endsection
