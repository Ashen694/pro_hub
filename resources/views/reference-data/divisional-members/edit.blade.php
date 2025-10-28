@extends('layouts.app')
@section('page-title','Edit Member')
@section('content')
<style>
    /* White form container with black text */
    .form-container { 
        background: #fff !important; 
        padding: 30px; 
        border-radius: 12px; 
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        max-width: 600px;
        margin: 20px auto;
    }
    .form-container h4, .form-container label, .form-container .form-text { color: #000 !important; }
    .form-container .form-control, .form-container .form-select { 
        color: #000 !important; 
        background: #fff !important; 
        border: 1px solid #ddd !important; 
    }
    .form-container .btn { 
        color: #fff !important; 
        border: none !important; 
    }
    .form-container .btn-secondary {
        background: #6c757d !important;
    }
    .form-container .btn-primary {
        background: #007bff !important;
    }
</style>

<!-- Particle Background -->
<div class="slt-bg-wrap" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: -1; background: transparent;">
    <canvas id="particleCanvas" style="width: 100%; height: 100%;"></canvas>
</div>

<div class="container">
    <div class="form-container">
        <h4 class="mb-4">Edit Member</h4>
        
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        
        <form action="{{ route('reference-data.divisional-members.update', $member) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label for="name" class="form-label">Full Name</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                       id="name" name="name" value="{{ old('name', $member->name) }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                       id="email" name="email" value="{{ old('email', $member->email) }}">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="contact_mobile" class="form-label">Contact Mobile Number</label>
                <input type="text" class="form-control @error('contact_mobile') is-invalid @enderror" 
                       id="contact_mobile" name="contact_mobile" value="{{ old('contact_mobile', $member->contact_mobile) }}">
                @error('contact_mobile')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="division" class="form-label">Division</label>
                <input type="text" class="form-control @error('division') is-invalid @enderror" 
                       id="division" name="division" value="{{ old('division', $member->division) }}">
                @error('division')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="position" class="form-label">Position</label>
                <input type="text" class="form-control @error('position') is-invalid @enderror" 
                       id="position" name="position" value="{{ old('position', $member->position) }}">
                @error('position')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="d-flex justify-content-between">
                <a href="{{ route('reference-data.divisional-members.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Update Member</button>
            </div>
        </form>
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
