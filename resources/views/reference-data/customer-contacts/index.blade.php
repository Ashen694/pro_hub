@extends('layouts.app')
@section('page-title','Customer Contacts')
@section('content')
<style>
    /* Page-scoped overrides for readability */
    .customer-contacts-table { background: #fff; }
    .customer-contacts-table thead th { color: #000 !important; background:#fff !important; }
    .customer-contacts-table tbody td { color: #000 !important; background:#fff !important; }
    .link-details { color: #0dcaf0; }
    /* Black visible borders */
    .customer-contacts-table, .customer-contacts-table th, .customer-contacts-table td { 
        border: 1px solid #000 !important; 
        border-collapse: collapse !important;
    }
    .customer-contacts-table tr:hover td { background: #f8f9fa !important; }
    </style>
<!-- Particle Background -->
<div class="slt-bg-wrap" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: -1; background: transparent;">
    <canvas id="particleCanvas" style="width: 100%; height: 100%;"></canvas>
    </div>
<div class="container">
    <div class="row mb-2">
        <div class="col-6">
            <a href="{{ route('reference-data.customer-contacts.create') }}">Create New</a>
        </div>
        <div class="col-6 text-end">
            <form method="GET" class="d-inline-block">
                Show
                <select name="perPage" onchange="this.form.submit()" style="color: #000;">
                    <option value="10" @if(request('perPage')==10) selected @endif>10</option>
                    <option value="25" @if(request('perPage')==25) selected @endif>25</option>
                    <option value="50" @if(request('perPage')==50) selected @endif>50</option>
                </select>
                entries
            </form>
            <form method="GET" class="d-inline-block ms-3">
                <input type="hidden" name="perPage" value="{{ request('perPage', 10) }}">
                <label>Search: <input type="search" name="q" value="{{ request('q') }}" placeholder="Search..." style="color:#000;background:#fff;border:1px solid #ccc;"> </label>
                <button type="submit" class="btn btn-sm btn-secondary ms-2">Go</button>
            </form>
        </div>
    </div>

    <table class="table table-bordered customer-contacts-table">
        <thead>
            <tr>
                <th style="color:#000;">Contact Person's Title</th>
                <th style="color:#000;">Contact Person's Name</th>
                <th style="color:#000;">Contact Person's Phone 1</th>
                <th style="color:#000;">Contact Person's Company</th>
                <th style="color:#000;">External Platform/Solution</th>
                <th style="color:#000;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($contacts as $contact)
                <tr>
                    <td style="color:#000;">{{ $contact->title }}</td>
                    <td style="color:#000;">{{ $contact->name }}</td>
                    <td style="color:#000;">{{ $contact->phone }}</td>
                    <td style="color:#000;">{{ optional($contact->company)->name }}</td>
                    <td style="color:#000;">{{ $contact->external_platform }}</td>
                    <td>
                        <a href="{{ route('reference-data.customer-contacts.edit', $contact) }}">Edit</a> |
                        <a href="{{ route('reference-data.customer-contacts.show', $contact) }}" class="link-details">Details</a> |
                        <form action="{{ route('reference-data.customer-contacts.destroy', $contact) }}" method="POST" style="display:inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-link p-0 text-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6">No contacts</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="d-flex justify-content-between">
        <div>
            Showing {{ $contacts->firstItem() ?? 0 }} to {{ $contacts->lastItem() ?? 0 }} of {{ $contacts->total() }} entries
        </div>
        <div>
            {{ $contacts->appends(request()->query())->links() }}
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
