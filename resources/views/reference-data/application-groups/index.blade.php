@extends('layouts.app')
@section('page-title','Application Groups')
@section('content')
<style>
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
<div class="container">
    <div class="row mb-2">
        <div class="col-6">
            <a href="{{ route('reference-data.application-groups.create') }}">Create New</a>
        </div>
        <div class="col-6 text-end">
            <form method="GET" class="d-inline-block">
                <label class="small me-2">Search:</label>
                <input type="search" name="q" value="{{ request('q') }}" class="form-control form-control-sm d-inline-block" style="width:200px;">
                <button type="submit" class="btn btn-sm btn-secondary ms-2">Go</button>
            </form>
        </div>
    </div>

    <table class="table table-bordered ag-table">
        <thead>
        <tr>
            <th>Application Group</th>
            <th>Description</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @forelse($groups as $g)
            <tr>
                <td style="text-transform:uppercase;">{{ $g->name }}</td>
                <td>{{ $g->description }}</td>
                <td>
                    <a href="{{ route('reference-data.application-groups.edit', $g) }}">Edit</a> |
                    <a href="{{ route('reference-data.application-groups.show', $g) }}" class="link-details">Details</a> |
                    <form action="{{ route('reference-data.application-groups.destroy', $g) }}" method="POST" style="display:inline" onsubmit="return confirm('Are you sure you want to delete this group?');">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-link p-0 text-danger">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="3">No groups</td></tr>
        @endforelse
        </tbody>
    </table>

    <div class="d-flex justify-content-between">
        <div>
            Showing {{ $groups->firstItem() ?? 0 }} to {{ $groups->lastItem() ?? 0 }} of {{ $groups->total() }} entries
        </div>
        <div>
            {{ $groups->links() }}
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
    </script>
@endsection
