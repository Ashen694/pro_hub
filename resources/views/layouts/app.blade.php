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
      /* Add any custom styles here */
    </style>
    @stack('styles')
  </head>
  <body >
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

                    <span class="avatar avatar-sm">{{ $initials }}</span>

                    <div class="d-none d-xl-block ps-2">
                        <div>{{ Auth::user()->name }}</div>
                        <div class="mt-1 small text-muted">Admin</div> <!-- You can make this dynamic later -->
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

                <!-- Reference Data Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#navbar-refdata" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false">
                        <span class="nav-link-title">
                        Reference Data
                        </span>
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="#">Companies/Customers</a>
                        <a class="dropdown-item" href="#">Customer Contacts</a>
                        <a class="dropdown-item" href="#">Divisional Members</a>
                        <a class="dropdown-item" href="#">Application Groups</a>
                        <a class="dropdown-item" href="#">Fields of Specialization</a>
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
                        <span class="nav-link-title">
                        Partners
                        </span>
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="#">All Partners</a>
                    </div>
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
  </body>
</html>