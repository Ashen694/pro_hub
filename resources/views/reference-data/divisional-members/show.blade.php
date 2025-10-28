@extends('layouts.app')
@section('page-title','Member Details')
@section('content')
<style>
    /* White details container with black text */
    .details-container { 
        background: #fff !important; 
        padding: 30px; 
        border-radius: 12px; 
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        max-width: 600px;
        margin: 20px auto;
    }
    .details-container h4, .details-container label, .details-container p, .details-container strong { 
        color: #000 !important; 
    }
    .details-container .btn { 
        color: #fff !important; 
        border: none !important; 
    }
    .details-container .btn-secondary {
        background: #6c757d !important;
    }
    .details-container .btn-primary {
        background: #007bff !important;
    }
    .details-container .btn-danger {
        background: #dc3545 !important;
    }
    .detail-row { 
        border-bottom: 1px solid #eee; 
        padding: 15px 0; 
    }
    .detail-row:last-child { 
        border-bottom: none; 
    }
</style>

<!-- Particle Background -->
<div class="slt-bg-wrap" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: -1; background: transparent;">
    <canvas id="particleCanvas" style="width: 100%; height: 100%;"></canvas>
</div>

<div class="container">
    <div class="details-container">
        <h4 class="mb-4">Member Details</h4>
        
        <div class="detail-row">
            <strong>Name:</strong>
            <p class="mb-0 mt-2">{{ $member->name }}</p>
        </div>
        
        <div class="detail-row">
            <strong>Email:</strong>
            <p class="mb-0 mt-2">{{ $member->email ?? 'Not provided' }}</p>
        </div>
        
        <div class="detail-row">
            <strong>Contact Mobile:</strong>
            <p class="mb-0 mt-2">{{ $member->contact_mobile ?? 'Not provided' }}</p>
        </div>
        
        <div class="detail-row">
            <strong>Division:</strong>
            <p class="mb-0 mt-2">{{ $member->division ?? 'Not specified' }}</p>
        </div>
        
        <div class="detail-row">
            <strong>Position:</strong>
            <p class="mb-0 mt-2">{{ $member->position ?? 'Not specified' }}</p>
        </div>
        
        <div class="detail-row">
            <strong>Created:</strong>
            <p class="mb-0 mt-2">{{ $member->created_at->format('M d, Y \a\t g:i A') }}</p>
        </div>
        
        <div class="detail-row">
            <strong>Last Updated:</strong>
            <p class="mb-0 mt-2">{{ $member->updated_at->format('M d, Y \a\t g:i A') }}</p>
        </div>
        
        <div class="d-flex justify-content-between mt-4">
            <a href="{{ route('reference-data.divisional-members.index') }}" class="btn btn-secondary">Back to List</a>
            <div>
                <a href="{{ route('reference-data.divisional-members.edit', $member) }}" class="btn btn-primary me-2">Edit</a>
                <form action="{{ route('reference-data.divisional-members.destroy', $member) }}" method="POST" style="display:inline" onsubmit="return confirm('Are you sure you want to delete this member?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
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