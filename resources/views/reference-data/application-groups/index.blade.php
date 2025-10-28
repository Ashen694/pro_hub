@extends('layouts.app')

@push('styles')
<style>
<<<<<<< HEAD
    /* White table with black borders */
    .ag-table { background: #fff !important; }
    .ag-table thead th { color: #000 !important; background: #fff !important; }
    .ag-table tbody td { color: #000 !important; background: #fff !important; }
    .link-details { color: #0dcaf0; }
    /* Black visible borders */
    .ag-table, .ag-table th, .ag-table td { 
        border: 1px solid #000 !important; 
        border-collapse: collapse !important;
    }
    .ag-table tr:hover td { background: #f8f9fa !important; }
    /* Make all text visible with black color */
    .container label, .container .small, .container a, .container .text-muted { color: #000 !important; }
    .container .btn { color: #000 !important; background: #fff !important; border: 1px solid #000 !important; }
    .container .form-control, .container .form-select { color: #000 !important; background: #fff !important; border: 1px solid #000 !important; }
</style>

<!-- Particle Background -->
<div class="slt-bg-wrap" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: -1; background: transparent;">
    <canvas id="particleCanvas" style="width: 100%; height: 100%;"></canvas>
</div>
=======
    .ag-content-wrapper {
        background-color: #ffffff;
        border: 1px solid #e0e0e0;
        padding: 24px;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }

    .ag-content-wrapper h1, 
    .ag-content-wrapper label, 
    .ag-content-wrapper p, 
    .ag-content-wrapper th, 
    .ag-content-wrapper td {
        color: #212529 !important;
    }

    .ag-content-wrapper .table {
        --bs-table-bg: #ffffff;
        --bs-table-striped-color: #212529;
        --bs-table-striped-bg: #f8f9fa;
        --bs-table-hover-color: #212529;
        --bs-table-hover-bg: #f1f3f5;
        color: #212529;
    }

    .ag-content-wrapper .page-link {
        background-color: #ffffff !important;
        border-color: #dee2e6 !important;
        color: #0057FF !important;
    }
    .ag-content-wrapper .page-item.active .page-link {
        background-color: #0057FF !important;
        border-color: #0057FF !important;
        color: #ffffff !important;
    }

    .action-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        border-radius: 8px;
        text-decoration: none !important;
        text-decoration: none;
        transition: all 0.2s ease-in-out;
        border: none;
    }
    .action-btn i {
        font-size: 16px;
    }
    .action-btn-edit {
        background-color: #e6f0ff;
    }
    .action-btn-edit i {
        color: #0057ff;
    }
    .action-btn-edit:hover {
        background-color: #cce0ff;
    }
    .action-btn-view {
        background-color: #e3f9e5;
    }
    .action-btn-view i {
        color: #28a745;
    }
    .action-btn-view:hover {
        background-color: #c1f2c6;
    }
    .action-btn-delete {
        background-color: #ffe6e6;
        cursor: pointer;
    }
    .action-btn-delete i {
        color: #dc3545;
    }
    .action-btn-delete:hover {
        background-color: #ffcccc;
    }
    .action-btn:hover {
    text-decoration: none !important;  
    }
</style>
@endpush

@section('page-title', 'Application Groups')

@section('content')
>>>>>>> 9d3b362242590499553813a58ee1a33fc6f732eb
<div class="container">
    <div class="ag-content-wrapper">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Application Groups</h1>
            <a href="{{ route('reference-data.application-groups.create') }}" class="btn btn-primary">Create New</a>
        </div>
<<<<<<< HEAD
        <div class="col-6 text-end">
            <form method="GET" class="d-inline-block">
                <label class="small me-2">Search:</label>
                <input type="search" name="q" value="{{ request('q') }}" class="form-control form-control-sm d-inline-block" style="width:200px;">
                <button type="submit" class="btn btn-sm btn-secondary ms-2">Go</button>
            </form>
        </div>
    </div>
=======
>>>>>>> 9d3b362242590499553813a58ee1a33fc6f732eb

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th>Application Group</th>
                    <th>Description</th>
                    <th class="text-center">Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse($groups as $g)
                    <tr>
                        <td style="text-transform:uppercase;">{{ $g->name }}</td>
                        <td>{{ $g->description }}</td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('reference-data.application-groups.show', $g) }}" class="action-btn action-btn-view" title="Details">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('reference-data.application-groups.edit', $g) }}" class="action-btn action-btn-edit" title="Edit">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                                <form action="{{ route('reference-data.application-groups.destroy', $g) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this group?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-btn action-btn-delete" title="Delete">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center">No groups found.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        @if ($groups->hasPages())
            <div class="mt-3">
                {{ $groups->links() }}
            </div>
        @endif
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
    </script>
@endsection
