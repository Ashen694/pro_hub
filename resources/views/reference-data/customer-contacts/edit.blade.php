@extends('layouts.app')
@section('page-title','Edit Customer Contact')
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
        <h4 class="mb-4">Edit Customer Contact</h4>
        
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        
        <form action="{{ route('reference-data.customer-contacts.update', $contact) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label for="company_id" class="form-label">Company</label>
                <select name="company_id" id="company_id" class="form-control @error('company_id') is-invalid @enderror" required>
                    <option value="">Select company</option>
                    @foreach($companies as $c)
                        <option value="{{ $c->id }}" {{ old('company_id', $contact->company_id) == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                    @endforeach
                </select>
                @error('company_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <select name="title" id="title" class="form-control @error('title') is-invalid @enderror" required>
                    <option value="">Select title</option>
                    @foreach(['Mr','Mrs','Ms','Dr','Prof'] as $t)
                        <option value="{{ $t }}" {{ old('title', $contact->title) == $t ? 'selected' : '' }}>{{ $t }}</option>
                    @endforeach
                </select>
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                       id="name" name="name" value="{{ old('name', $contact->name) }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                       id="email" name="email" value="{{ old('email', $contact->email) }}">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                       id="phone" name="phone" value="{{ old('phone', $contact->phone) }}">
                @error('phone')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="role" class="form-label">Role</label>
                <input type="text" class="form-control @error('role') is-invalid @enderror" 
                       id="role" name="role" value="{{ old('role', $contact->role) }}">
                @error('role')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="d-flex justify-content-between">
                <a href="{{ route('reference-data.customer-contacts.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Update Contact</button>
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
