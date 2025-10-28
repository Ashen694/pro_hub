@extends('layouts.app')
@section('page-title','Members')
@section('content')
<style>
    /* White table with black borders */
    .divisional-members-table { background: #fff !important; }
    .divisional-members-table thead th { color: #000 !important; background: #fff !important; }
    .divisional-members-table tbody td { color: #000 !important; background: #fff !important; }
    /* Black visible borders */
    .divisional-members-table, .divisional-members-table th, .divisional-members-table td { 
        border: 1px solid #000 !important; 
        border-collapse: collapse !important;
    }
    .divisional-members-table tr:hover td { background: #f8f9fa !important; }
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
            <a href="{{ route('reference-data.divisional-members.create') }}" class="btn btn-primary btn-sm">Create New</a>
            <a href="#" class="ms-3">Divisional Members</a>
            <a href="#" class="ms-2">View Only Users</a>
        </div>
        <div class="col-6 text-end">
            <form method="GET" class="d-inline-block">
                <label class="me-2 small">Show</label>
                <select name="perPage" class="form-select form-select-sm d-inline-block" style="width:80px; color:#000;" onchange="this.form.submit()">
                    <option value="10" @if(request('perPage')==10) selected @endif>10</option>
                    <option value="25" @if(request('perPage')==25) selected @endif>25</option>
                </select>
                <label class="ms-2 small">entries</label>
            </form>
            <form method="GET" class="d-inline-block ms-3">
                <label class="small me-2">Search</label>
                <input type="search" name="q" value="{{ request('q') }}" class="form-control form-control-sm d-inline-block" style="width:200px;">
                <button type="submit" class="btn btn-sm btn-secondary ms-2">Go</button>
            </form>
        </div>
    </div>

    <table class="table table-bordered divisional-members-table">
        <thead>
            <tr>
                <th>Full Name</th>
                <th>Email</th>
                <th>Contact Mobile Number</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse($members as $m)
                <tr>
                    <td>{{ $m->name }}</td>
                    <td>{{ $m->email }}</td>
                    <td>{{ $m->contact_mobile ?? '' }}</td>
                    <td class="text-end"><a href="#">Edit</a></td>
                </tr>
            @empty
                <tr><td colspan="4">No members</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="d-flex justify-content-between">
        <div class="small text-muted">Showing {{ $members->firstItem() ?? 0 }} to {{ $members->lastItem() ?? 0 }} of {{ $members->total() }} entries</div>
        <div>{{ $members->links() }}</div>
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
