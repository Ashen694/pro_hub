<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Project Hub</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/prohub-login.css') }}">
</head>
<body>
    <div class="login-container">
        <!-- Left Info Column -->
        <div class="info-column">
            <div class="slt-logo">
                <img src="{{ asset('images/slt-logo.png') }}" alt="SLT Mobitel Logo" class="logo-img">
                <h1>Project Hub</h1>
            </div>
            <h2 class="gradient-text">Manage, Monitor & Escalate.</h2>
            <p>Your central platform for progress monitoring, incident capturing, and escalation for Digital Platform operations.</p>
        </div>

        <!-- Right Form Column -->
        <div class="form-column">
            <div class="glass-card">
                <div class="card-header">
                    <h2 class="gradient-header">Sign In</h2>
                    <p>Access your dashboard</p>
                </div>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email Address -->
                    <div class="input-group">
                        <i class="fas fa-user"></i>
                        <input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="Email Address">
                    </div>
                     <x-input-error :messages="$errors->get('email')" class="error-message" />

                    <!-- Password -->
                    <div class="input-group" style="margin-top: 1.5rem;">
                        <i class="fas fa-lock"></i>
                        <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="Password">
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="error-message" />


                    <button type="submit" class="btn-login" style="margin-top: 2rem;">
                        {{ __('Log in') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

