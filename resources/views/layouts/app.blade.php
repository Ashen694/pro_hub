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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.bootstrap5.css" rel="stylesheet">
    <style>
  body {
    font-family: "Inter", sans-serif;
    background: url("{{ asset('images/bg-img2.jpg') }}") no-repeat center center fixed;
    background-size: cover;
  }

  .navbar.navbar-expand-md {
    background: linear-gradient(90deg, #007C4B 0%, #0057FF 100%);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
  }

  .navbar-collapse { flex-grow: 1; justify-content: center; }

  .avatar {
    background: linear-gradient(135deg, #007C4B, #0057FF);
    color: #fff;
    font-weight: bold;
    display: flex; align-items: center; justify-content: center;
  }

  .navbar-nav .nav-link { color: #e6e6e6 !important; font-weight: 500;
      padding: 10px 18px; transition: 0.3s; }

  .navbar-nav .nav-link:hover, .navbar-nav .nav-link.active {
      color: #fff !important;
      background-color: rgba(255, 255, 255, 0.1);
      border-radius: 8px;
  }

  .navbar-nav .nav-link.text-reset { color: #fff !important; }

  .navbar-nav .nav-link.text-reset:hover { color: #d1eaff !important; }

  .dropdown-menu {
      background-color: #0E1C3C;
      border: 1px solid rgba(255,255,255,0.1);
      border-radius: 10px;
  }

  .dropdown-item {
      color: #e6e6e6;
      transition: 0.2s;
      display: flex; align-items: center;
  }

  .dropdown-item:hover {
      background-color: rgba(0, 87, 255, 0.2); color: #fff;
  }

  .page-header {
      background: rgba(0, 0, 0, 0.35);
      border-radius: 12px; padding: 24px; margin-top: 16px;
  }

  .page-title { color: #fff; font-weight: 700; font-size: 26px; }

  .footer {
      background: rgba(0, 0, 0, 0.4);
      border-top: 1px solid rgba(255,255,255,0.1);
      color: #bfbfbf;
  }

  .footer a { color: #1E90FF; text-decoration: none; }
  .footer a:hover { color: #66b3ff; }
</style>


    @stack('styles')
  </head>
  <body >
    <div class="page">
      <!-- Combined Navbar -->
      <header class="navbar navbar-expand-md navbar-light d-print-none">
        <div class="container-xl">
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu">
            <span class="navbar-toggler-icon"></span>
          </button>
          
          
          <!-- Navigation Links -->
          <div class="collapse navbar-collapse" id="navbar-menu">
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
                        <a class="dropdown-item" href="{{ route('internal-solutions.index', ['status' => 'operational']) }}"><i class="ti ti-check me-2"></i>Internal Solutions - Operational</a>
                        <a class="dropdown-item" href="{{ route('internal-solutions.index', ['status' => 'in-progress']) }}"><i class="ti ti-progress me-2"></i>Internal Solutions - In-Progress</a>
                        <a class="dropdown-item" href="{{ route('internal-solutions.index', ['status' => 'recently-launched']) }}"><i class="ti ti-rocket me-2"></i>Internal Solutions - Recently Launched</a>
                        <a class="dropdown-item" href="{{ route('internal-solutions.index', ['status' => 'retired']) }}"><i class="ti ti-archive me-2"></i>Internal Solutions - Retired</a>
                        <a class="dropdown-item" href="{{ route('internal-solutions.index', ['status' => 'abandoned']) }}"><i class="ti ti-trash me-2"></i>Internal Solutions - Abandoned</a>
                        <a class="dropdown-item" href="{{ route('consumer-service.index') }}"><i class="ti ti-users me-2"></i>Consumer Service Platforms</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('external-solutions.index', ['status' => 'operational']) }}"><i class="ti ti-check me-2"></i>External Solutions - Operational</a>
                        <a class="dropdown-item" href="{{ route('external-solutions.index', ['status' => 'prospective']) }}"><i class="ti ti-search me-2"></i>External Solutions - Prospective</a>
                        <a class="dropdown-item" href="{{ route('external-solutions.index', ['status' => 'retired']) }}"><i class="ti ti-archive me-2"></i>External Solutions - Retired</a>
                        <a class="dropdown-item" href="{{ route('external-solutions.index', ['status' => 'abandoned']) }}"><i class="ti ti-trash me-2"></i>External Solutions - Abandoned</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('internal-solutions.backup-matrix.export') }}"><i class="ti ti-database-export me-2"></i>Internal Solutions - Backup Matrix</a>
                        <a class="dropdown-item" href="#"><i class="ti ti-database-export me-2"></i>External Solutions - Backup Matrix</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#"><i class="ti ti-chart-line me-2"></i>External Solutions - Projected Revenue</a>
                        <a class="dropdown-item" href="#"><i class="ti ti-cash me-2"></i>External Solutions - Financial Revenue</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('internal-solutions.yearly-contribution') }}"><i class="ti ti-calendar-stats me-2"></i>Internal Solutions - Yearly Contribution</a>                    </div>
                </li>

                <!-- My Work Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#navbar-work" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false">
                        <span class="nav-link-title">My Work</span>
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ route('my-work.weekly.update') }}"><i class="ti ti-edit me-2"></i>Update Weekly Plan</a>
                        <a class="dropdown-item" href="{{ route('my-work.weekly.report') }}"><i class="ti ti-file-analytics me-2"></i>Weekly Plan - Report</a>
                        <a class="dropdown-item" href="{{ route('my-work.backup-matrix') }}"><i class="ti ti-database-cog me-2"></i>My Applications - Backup Matrix</a>
                    </div>
                </li>

                <!-- Report Incidents Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#navbar-incidents" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false">
                        <span class="nav-link-title">Report Incidents</span>
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ route('incidents.external.index') }}"><i class="ti ti-bug me-2"></i>External Solutions</a>
                        <a class="dropdown-item" href="{{ route('incidents.internal.index') }}"><i class="ti ti-bug me-2"></i>Internal Solutions</a>
                        <a class="dropdown-item" href="{{ route('incidents.other.index') }}"><i class="ti ti-alert-triangle me-2"></i>Other Solutions</a>
                    </div>
                </li>

                <!-- Reference Data Dropdown--> 
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#navbar-refdata" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false">
                        <span class="nav-link-title">Reference Data</span>
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ route('reference-data.companies.index') }}"><i class="ti ti-building-skyscraper me-2"></i>Companies/Customers</a>
                        <a class="dropdown-item" href="{{ route('reference-data.customer-contacts.index') }}"><i class="ti ti-phone me-2"></i>Customer Contacts</a>
                        <a class="dropdown-item" href="{{ route('reference-data.divisional-members.index') }}"><i class="ti ti-users-group me-2"></i>Divisional Members</a>
                        <a class="dropdown-item" href="{{ route('reference-data.application-groups.index') }}"><i class="ti ti-apps me-2"></i>Application Groups</a>
                        <a class="dropdown-item" href="{{ route('reference-data.fields-of-specializations.index') }}"><i class="ti ti-certificate me-2"></i>Fields of Specialization</a>
                    </div>
                </li>

                <!-- DMS Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#navbar-dms" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false">
                        <span class="nav-link-title">DMS</span>
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ route('dms.index', ['type' => 'internal']) }}"><i class="ti ti-file-text me-2"></i>Internal Solutions Documents</a>
                        <a class="dropdown-item" href="{{ route('dms.index', ['type' => 'external']) }}"><i class="ti ti-file-text me-2"></i>External Solutions Documents</a>
                    </div>
                </li>

                <!-- Project Activities Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#navbar-projects" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false">
                        <span class="nav-link-title">Project Activities</span>
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ route('project-activities.index', ['type' => 'internal']) }}"><i class="ti ti-list-details me-2"></i>Internal Solutions Activities</a>
                        <a class="dropdown-item" href="{{ route('project-activities.index', ['type' => 'external']) }}"><i class="ti ti-list-details me-2"></i>External Solutions Activities</a>
                        <a class="dropdown-item" href="{{ route('project-activities.overtime.index') }}"><i class="ti ti-clock-hour-9 me-2"></i>OverTime Data</a>
                    </div>
                </li>

                <!-- Trainees Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#navbar-trainees" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false">
                        <span class="nav-link-title">Trainees</span>
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="#"><i class="ti ti-user-check me-2"></i>Active Trainees</a>
                        <a class="dropdown-item" href="#"><i class="ti ti-user-off me-2"></i>Inactive Trainees</a>
                        <a class="dropdown-item" href="#"><i class="ti ti-wallet me-2"></i>Paid Trainees</a>
                    </div>
                </li>

                <!-- Partners Dropdown -->
                  <li class="nav-item dropdown">
                      <a class="nav-link dropdown-toggle" href="#navbar-partners" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false">
                          <span class="nav-link-title">Partners</span>
                      </a>
                      <div class="dropdown-menu">
                          <a class="dropdown-item" href="{{ route('reference-data.partners.index') }}"><i class="ti ti-handshake me-2"></i>All Partners</a>
                          <a class="dropdown-item" href="{{ route('reference-data.partners.create') }}"><i class="ti ti-plus me-2"></i>Create Partner</a>
                      </div>
                  </li>
                <!-- Freelancers -->
                  <li class="nav-item dropdown">
                      <a class="nav-link dropdown-toggle" href="#navbar-freelancers" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false">
                          <span class="nav-link-title">Freelancers</span>
                      </a>
                      <div class="dropdown-menu">
                          <a class="dropdown-item" href="{{ route('freelancers.all') }}"><i class="ti ti-briefcase me-2"></i>All Freelancers</a>
                          <a class="dropdown-item" href="{{ route('freelancers.create') }}"><i class="ti ti-user-plus me-2"></i>Create New Freelancer</a>
                      </div>
                  </li>
            </ul>
          </div>
          
          <!-- User Profile Section -->
          <div class="navbar-nav flex-row order-md-last">
             <div class="nav-item dropdown">
                <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
                    @php
                        $name = Auth::user()->name;
                        $words = explode(" ", $name);
                        $initials = strtoupper(substr($words[0], 0, 1));
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
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="{{ route('logout') }}" class="dropdown-item"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        <i class="ti ti-logout me-2"></i>Logout
                        </a>
                    </form>
                </div>
            </div>
          </div>
        </div>
      </header>
      
      <div class="page-wrapper">
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
        <div class="page-body">
          <div class="container-xl">
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
    <script src="{{ asset('tabler/js/tabler.min.js') }}" defer></script>
    <script src="{{ asset('tabler/js/demo.min.js') }}" defer></script>
    <script src="{{ asset('tabler/libs/litepicker/dist/litepicker.js') }}" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
    @stack('scripts')
     
    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('close-modal', (event) => {
                const backdrops = document.querySelectorAll('.modal-backdrop');
                backdrops.forEach(backdrop => {
                    backdrop.remove();
                });
                document.body.style.overflow = '';
                document.body.style.paddingRight = '';
            });
        });
    </script>
  </body>
</html>