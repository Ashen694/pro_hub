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
    <style>
        /* Microsoft Button Styles */
        .btn-azure {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            background-color: #0078D4;
            color: white;
            font-weight: 600;
            text-decoration: none;
            border: 1px solid #0078D4;
            cursor: pointer;
            transition: background-color 0.3s;
            font-size: 1rem;
        }
        .btn-azure:hover {
            background-color: #005a9e;
        }
        .btn-azure img {
            height: 20px;
            width: 20px;
        }
        .or-divider {
            display: flex;
            align-items: center;
            text-align: center;
            color: #ccc;
            margin: 1.5rem 0;
        }
        .or-divider::before, .or-divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #555;
        }
        .or-divider:not(:empty)::before {
            margin-right: .5em;
        }
        .or-divider:not(:empty)::after {
            margin-left: .5em;
        }
        .error-message-box {
            color: #ff9aa2; 
            text-align: center; 
            margin-bottom: 15px;
            padding: 10px;
            background: rgba(255, 154, 162, 0.1);
            border: 1px solid rgba(255, 154, 162, 0.3);
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="info-column">
            <div class="slt-logo">
                <img src="{{ asset('images/slt-logo.png') }}" alt="SLT Mobitel Logo" class="logo-img">
                <h1>Project Hub</h1>
            </div>
            <h2 class="gradient-text">Manage, Monitor & Escalate.</h2>
            <p>Your central platform for progress monitoring, incident capturing, and escalation for Digital Platform operations.</p>
        </div>

        <div class="form-column">
            <div class="glass-card">
                <div class="card-header">
                    <h2 class="gradient-header">Sign In</h2>
                    <p>Access your dashboard</p>
                </div>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <!-- General Error Messages (from Azure Login etc.) -->
                @if ($errors->any())
                    <div class="error-message-box">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email Address -->
                    <div class="input-group">
                        <i class="fas fa-user"></i>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="Email Address">
                    </div>
                    
                    <!-- Password -->
                    <div class="input-group" style="margin-top: 1.5rem;">
                        <i class="fas fa-lock"></i>
                        <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="Password">
                    </div>

                    <button type="submit" class="btn-login" style="margin-top: 2rem;">
                        {{ __('Log in') }}
                    </button>

                    <div class="or-divider">or</div>

                    <!-- Azure SSO Button -->
                    <a class="btn-azure" href="{{ route('azure.redirect') }}">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/4/44/Microsoft_logo.svg" alt="Microsoft Logo">
                        <span>Continue with Microsoft</span>
                    </a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>