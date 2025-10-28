@extends('layouts.app')
@section('page-title','Application Groups')
@section('content')
<style>
    /* White container with rounded corners */
    .app-groups-container {
        background: #fff;
        border-radius: 12px;
        padding: 24px;
        margin: 20px auto;
        max-width: 900px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    
    .app-groups-container h4 {
        color: #666;
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 20px;
    }
    
    /* Table styling */
    .app-groups-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }
    
    .app-groups-table th {
        background: #f8f9fa;
        color: #666;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        padding: 12px 16px;
        border: none;
        border-bottom: 1px solid #e9ecef;
    }
    
    .app-groups-table td {
        padding: 16px;
        border-bottom: 1px solid #e9ecef;
        color: #333;
        vertical-align: middle;
    }
    
    .app-groups-table tbody tr:hover {
        background-color: #f8f9fa;
    }
    
    /* Action buttons - circular icons */
    .action-btn {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        border: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin: 0 4px;
        cursor: pointer;
        transition: all 0.2s ease;
        font-size: 14px;
    }
    
    .action-btn-view {
        background-color: #28a745;
        color: white;
    }
    
    .action-btn-view:hover {
        background-color: #218838;
        transform: scale(1.1);
    }
    
    .action-btn-edit {
        background-color: #007bff;
        color: white;
    }
    
    .action-btn-edit:hover {
        background-color: #0056b3;
        transform: scale(1.1);
    }
    
    .action-btn-delete {
        background-color: #dc3545;
        color: white;
    }
    
    .action-btn-delete:hover {
        background-color: #c82333;
        transform: scale(1.1);
    }
    
    /* Create New button */
    .btn-create-new {
        background-color: #007bff;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 500;
    }
    
    .btn-create-new:hover {
        background-color: #0056b3;
        color: white;
    }
</style>

<!-- Particle Background -->
<div class="slt-bg-wrap" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: -1; background: transparent;">
    <canvas id="particleCanvas" style="width: 100%; height: 100%;"></canvas>
</div>
<div class="container">
    <div class="app-groups-container">
        <!-- Header with title and Create New button -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4>Application Groups</h4>
            <a href="{{ route('reference-data.application-groups.create') }}" class="btn btn-create-new">Create New</a>
        </div>

        <!-- Search and Show entries -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="d-flex align-items-center">
                <span class="me-2" style="color: #666; font-size: 14px;">Show</span>
                <form method="GET" class="d-inline">
                    <input type="hidden" name="q" value="{{ request('q') }}">
                    <select name="perPage" onchange="this.form.submit()" class="form-select form-select-sm" style="width: 80px; color: #000; background: #fff; border: 1px solid #ddd;">
                        <option value="10" {{ request('perPage', 10) == 10 ? 'selected' : '' }}>10</option>
                        <option value="25" {{ request('perPage', 10) == 25 ? 'selected' : '' }}>25</option>
                        <option value="50" {{ request('perPage', 10) == 50 ? 'selected' : '' }}>50</option>
                    </select>
                </form>
                <span class="ms-2" style="color: #666; font-size: 14px;">entries</span>
            </div>
            <div class="d-flex align-items-center">
                <span class="me-2" style="color: #666; font-size: 14px;">Search:</span>
                <form method="GET" class="d-flex">
                    <input type="hidden" name="perPage" value="{{ request('perPage', 10) }}">
                    <input type="text" name="q" value="{{ request('q') }}" class="form-control form-control-sm" style="width: 200px; color: #000; background: #fff; border: 1px solid #ddd;" placeholder="Search...">
                    <button type="submit" class="btn btn-sm btn-primary ms-2">Go</button>
                </form>
            </div>
        </div>

        <!-- Table -->
        <table class="app-groups-table">
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
                        <td style="text-transform: uppercase; font-weight: 500;">{{ $g->name }}</td>
                        <td>{{ $g->description }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <!-- View Button -->
                                <button class="action-btn action-btn-view" title="View Details" onclick="window.location='{{ route('reference-data.application-groups.show', $g) }}'">
                                    <i class="ti ti-eye"></i>
                                </button>
                                
                                <!-- Edit Button -->
                                <button class="action-btn action-btn-edit" title="Edit" onclick="window.location='{{ route('reference-data.application-groups.edit', $g) }}'">
                                    <i class="ti ti-pencil"></i>
                                </button>
                                
                                <!-- Delete Button -->
                                <form action="{{ route('reference-data.application-groups.destroy', $g) }}" method="POST" style="display:inline" onsubmit="return confirm('Are you sure you want to delete this application group?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="action-btn action-btn-delete" title="Delete">
                                        <i class="ti ti-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" style="text-align: center; color: #666; padding: 40px;">No application groups found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination and entries info -->
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div style="color: #666; font-size: 14px;">
                Showing {{ $groups->firstItem() ?? 0 }} to {{ $groups->lastItem() ?? 0 }} of {{ $groups->total() }} entries
            </div>
            <div>
                {{ $groups->appends(request()->query())->links() }}
            </div>
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
