<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>@yield('title', 'Dashboard') - ProHub</title>
    <!-- CSS files -->
    <link href="{{ asset('tabler/css/tabler.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('tabler/css/tabler-flags.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('tabler/css/tabler-payments.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('tabler/css/tabler-vendors.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('tabler/css/demo.css') }}" rel="stylesheet"/>
    <link href="{{ asset('tabler/libs/litepicker/dist/litepicker.css') }}" rel="stylesheet"/>
    <style>
  body {

    font-family: "Inter", sans-serif;
  }

  /* 🔹 Top Header (Logo + User Info) */
  .navbar:first-of-type {
    background: linear-gradient(90deg, #007C4B 0%, #0057FF 100%);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
    border-bottom: none;
    padding: 0.8rem 0;
  }

  .navbar-brand a {
    color: #fff;
    font-weight: 700;
    font-size: 22px;
    letter-spacing: 1px;
    text-decoration: none;
  }

  .navbar-brand a:hover {
    color: #e0e0e0;
  }

  .avatar {
    background: linear-gradient(135deg, #007C4B, #0057FF);
    color: #fff;
    font-weight: bold;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .nav-link.text-reset {
    color: #fff !important;
  }

  .nav-link.text-reset:hover {
    color: #d1eaff !important;
  }

  /* 🔹 Second Row (Navigation Bar) */
  .navbar-expand-md .navbar-light {
    background: #102046; /* darker blue for contrast */
    border-top: 1px solid rgba(255, 255, 255, 0.1);
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    box-shadow: 0 2px 10px rgba(0,0,0,0.3);
  }

  .nav-link {
    color: #e6e6e6 !important;
    font-weight: 500;
    padding: 10px 18px;
    transition: 0.3s;
  }

  .nav-link:hover, .nav-link.active {
    color: #fff !important;
    background-color: rgba(255, 255, 255, 0.1);
    border-radius: 8px;
  }

  /* 🔹 Dropdown styling */
  .dropdown-menu {
    background-color: #0E1C3C;
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: 10px;
  }

  .dropdown-item {
    color: #e6e6e6;
    transition: 0.2s;
  }

  .dropdown-item:hover {
    background-color: rgba(0, 87, 255, 0.2);
    color: #fff;
  }

  /* 🔹 Page title area */
  .page-header {
    background: radial-gradient(circle at top left, rgba(0, 124, 75, 0.25), rgba(0, 87, 255, 0.15));
    border-radius: 12px;
    padding: 24px;
    margin-top: 16px;
  }

  .page-title {
    color: #ffffff;
    font-weight: 700;
    font-size: 26px;
  }

  /* 🔹 Footer */
  .footer {
    background: #0C1631;
    border-top: 1px solid rgba(255,255,255,0.1);
    color: #bfbfbf;
  }

  .footer a {
    color: #1E90FF;
    text-decoration: none;
  }

  .footer a:hover {
    color: #66b3ff;
  }

  .colorful-avatar {
  background: conic-gradient(from 180deg, #007C4B, #00C2FF, #007C4B);
  color: #fff;
  font-weight: 700;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 50%;
  box-shadow: 0 0 8px rgba(0,0,0,0.2);
}

    :root{
        --slt-primary:#2258a7; --slt-primary-600:#1c4b8f; --slt-primary-700:#163e77;
        --slt-info:#46b6ef; --slt-accent:#5fb545;
        --slt-white:#ffffff; --slt-ink:#0c1b2a; --slt-muted:#6b7a8a;
        --slt-border:#e6eef8; --slt-focus:0 0 0 .25rem rgba(34,88,167,.25);
        --slt-radius-lg:16px; --slt-radius-md:12px;
    }

    #particleCanvas {
        position: fixed; 
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: -1; 
        background-color: var(--slt-ink); 
    }

    .page {
        background-color: transparent; 
        position: relative; 
        z-index: 1; 
    }

</style>

    @stack('styles')
  </head>
  <body >
    <canvas id="particleCanvas"></canvas>
    <div class="page">
      <!-- Navbar -->
      <header class="navbar navbar-expand-md navbar-light d-print-none">
        <div class="container-xl">
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu">
            <span class="navbar-toggler-icon"></span>
          </button>
          <h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
            <a href=".">
              PROHUB
            </a>
          </h1>
          <div class="navbar-nav flex-row order-md-last">
             <div class="nav-item dropdown">
                <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">

                    @php
                        // Get user's name
                        $name = Auth::user()->name;
                        // Split name into words
                        $words = explode(" ", $name);
                        // Get the first letter of the first word
                        $initials = strtoupper(substr($words[0], 0, 1));
                        // If there's a second word, get its first letter too
                        if (count($words) > 1) {
                            $initials .= strtoupper(substr($words[count($words) - 1], 0, 1));
                        }
                    @endphp

                    <span class="avatar avatar-sm colorful-avatar">{{ $initials }}</span>

                    <div class="d-none d-xl-block ps-2">
                        <div>{{ Auth::user()->name }}</div>
                        <div class="mt-1 small text-muted">Admin</div>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <!-- Logout Form -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="{{ route('logout') }}" class="dropdown-item"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        Logout
                        </a>
                    </form>
                </div>
            </div>
          </div>
        </div>
      </header>

      <div class="navbar-expand-md">
        <div class="collapse navbar-collapse" id="navbar-menu">
          <div class="navbar navbar-light">
            <div class="container-xl">
              <ul class="navbar-nav">
                <!-- Home/Dashboard Link -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('dashboard') }}" >
                        <span class="nav-link-title">
                        Dashboard
                        </span>
                    </a>
                </li>

                <!-- Platforms/Solutions Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#navbar-platforms" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false">
                        <span class="nav-link-title">Platforms/Solutions</span>
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ route('internal-solutions.index', ['status' => 'operational']) }}">Internal Solutions - Operational</a>
                        <a class="dropdown-item" href="{{ route('internal-solutions.index', ['status' => 'in-progress']) }}">Internal Solutions - In-Progress</a>
                        <a class="dropdown-item" href="{{ route('internal-solutions.index', ['status' => 'recently-launched']) }}">Internal Solutions - Recently Launched</a>
                        <a class="dropdown-item" href="{{ route('internal-solutions.index', ['status' => 'retired']) }}">Internal Solutions - Retired</a>
                        <a class="dropdown-item" href="{{ route('internal-solutions.index', ['status' => 'abandoned']) }}">Internal Solutions - Abandoned</a>
                        <a class="dropdown-item" href="{{ route('consumer-service.index') }}">Consumer Service Platforms</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('external-solutions.index', ['status' => 'operational']) }}">External Solutions - Operational</a>
                        <a class="dropdown-item" href="{{ route('external-solutions.index', ['status' => 'prospective']) }}">External Solutions - Prospective</a>
                        <a class="dropdown-item" href="#">External Solutions - Retired</a>
                        <a class="dropdown-item" href="#">External Solutions - Abandoned</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Internal Solutions - Backup Matrix</a>
                        <a class="dropdown-item" href="#">External Solutions - Backup Matrix</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">External Solutions - Projected Revenue</a>
                        <a class="dropdown-item" href="#">External Solutions - Financial Revenue</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('internal-solutions.yearly-contribution') }}">Internal Solutions - Yearly Contribution</a>                    </div>
                </li>

                <!-- My Work Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#navbar-work" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false">
                        <span class="nav-link-title">
                        My Work
                        </span>
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="#">Update Weekly Plan</a>
                        <a class="dropdown-item" href="#">Weekly Plan - Report</a>
                        <a class="dropdown-item" href="#">My Applications - Backup Matrix</a>
                    </div>
                </li>

                <!-- Report Incidents Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#navbar-incidents" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false">
                        <span class="nav-link-title">
                        Report Incidents
                        </span>
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="#">External Solutions</a>
                        <a class="dropdown-item" href="#">Internal Solutions</a>
                        <a class="dropdown-item" href="#">Other Solutions</a>
                    </div>
                </li>

                <!-- Reference Data Dropdown--> 
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#navbar-refdata" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false">
                        <span class="nav-link-title">
                        Reference Data
                        </span>
                    </a>
          <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ route('reference-data.companies.index') }}">Companies/Customers</a>
                        <a class="dropdown-item" href="{{ route('reference-data.customer-contacts.index') }}">Customer Contacts</a>
                        <a class="dropdown-item" href="{{ route('reference-data.divisional-members.index') }}">Divisional Members</a>
                        <a class="dropdown-item" href="{{ route('reference-data.application-groups.index') }}">Application Groups</a>
                        <a class="dropdown-item" href="{{ route('reference-data.fields-of-specializations.index') }}">Fields of Specialization</a>
                    </div>
                </li>
                       
                    </a>
          <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ route('reference-data.companies.index') }}">Companies/Customers</a>
                        <a class="dropdown-item" href="{{ route('reference-data.customer-contacts.index') }}">Customer Contacts</a>
                        <a class="dropdown-item" href="{{ route('reference-data.divisional-members.index') }}">Divisional Members</a>
                        <a class="dropdown-item" href="{{ route('reference-data.application-groups.index') }}">Application Groups</a>
                        <a class="dropdown-item" href="{{ route('reference-data.fields-of-specializations.index') }}">Fields of Specialization</a>
                    </div>
                </li>

                <!-- DMS Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#navbar-dms" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false">
                        <span class="nav-link-title">
                        DMS
                        </span>
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="#">Internal Solutions Documents</a>
                        <a class="dropdown-item" href="#">External Solutions Documents</a>
                    </div>
                </li>

                <!-- Project Activities Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#navbar-projects" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false">
                        <span class="nav-link-title">
                        Project Activities
                        </span>
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="#">Internal Solutions Activities</a>
                        <a class="dropdown-item" href="#">External Solutions Activities</a>
                        <a class="dropdown-item" href="#">OverTime Data</a>
                    </div>
                </li>

                <!-- Trainees Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#navbar-trainees" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false">
                        <span class="nav-link-title">
                        Trainees
                        </span>
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="#">Active Trainees</a>
                        <a class="dropdown-item" href="#">Inactive Trainees</a>
                        <a class="dropdown-item" href="#">Paid Trainees</a>
                    </div>
                </li>

                <!-- Partners Dropdown -->
                  <li class="nav-item dropdown">
                      <a class="nav-link dropdown-toggle" href="#navbar-partners" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false">
                          <span class="nav-link-title">Partners</span>
                      </a>
                      <div class="dropdown-menu">
                          <a class="dropdown-item" href="{{ route('reference-data.partners.index') }}">All Partners</a>
                          <a class="dropdown-item" href="{{ route('reference-data.partners.create') }}">Create Partner</a>
                      </div>
                  </li>
                <!-- Freelancers -->
                <li class="nav-item dropdown">
                    <a class="nav-link" href="#navbar-partners" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false">
                        <span class="nav-link-title">
                        Freelancers
                        </span>
                    </a>
                </li>

            </ul>
            </div>
          </div>
        </div>
      </div>

      <div class="page-wrapper">
        <!-- Page header -->
        <div class="page-header d-print-none">
          <div class="container-xl">
            <div class="row g-2 align-items-center">
              <div class="col">
                <h2 class="page-title">
                  @yield('page-title', 'Dashboard')
                </h2>
              </div>
            </div>
          </div>
        </div>
        <!-- Page body -->
        <div class="page-body">
          <div class="container-xl">
            <!-- Content here -->
            @yield('content')
          </div>
        </div>
        <footer class="footer footer-transparent d-print-none">
          <div class="container-xl">
            <div class="row text-center align-items-center flex-row-reverse">
              <div class="col-12 col-lg-auto mt-3 mt-lg-0">
                <ul class="list-inline list-inline-dots mb-0">
                  <li class="list-inline-item">
                    &copy; {{ date('Y') }} ProHub - Digital Platform
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </footer>
      </div>
    </div>
    <!-- Libs JS -->
    <!-- Tabler Core -->
    <script src="{{ asset('tabler/js/tabler.min.js') }}" defer></script>
    <script src="{{ asset('tabler/js/demo.min.js') }}" defer></script>
    <!-- datepicker -->
    <script src="{{ asset('tabler/libs/litepicker/dist/litepicker.js') }}" defer></script>

    @stack('scripts')
     <script>
        // Particles Background
        (function() {
            const canvas = document.getElementById('particleCanvas');
            if (!canvas) return;  
            const ctx = canvas.getContext('2d');

            function resizeCanvas() {
                canvas.width = window.innerWidth;
                canvas.height = window.innerHeight;
            }
            resizeCanvas();
            window.addEventListener('resize', resizeCanvas);

            const rootStyles = getComputedStyle(document.documentElement);
            const colors = [
                rootStyles.getPropertyValue('--slt-primary').trim(),
                rootStyles.getPropertyValue('--slt-info').trim(),
                rootStyles.getPropertyValue('--slt-accent').trim()
            ];

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
  </body>
</html>
