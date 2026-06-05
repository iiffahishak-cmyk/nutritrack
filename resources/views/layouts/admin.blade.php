<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>NutriTrack Admin - @yield('title', 'Control Panel')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    @stack('styles')

    <style>
        :root {
            --primary: #1e293b; /* Warna admin sedikit gelap/profesional */
            --primary-soft: rgba(30, 41, 59, 0.08);
            --text-main: #1f2937;
            --text-muted: #6b7280;
            --nav-bg: rgba(255, 255, 255, 0.95);
        }

        body {
            font-family: 'Inter', 'Segoe UI', sans-serif;
            background-color: #f8fafc;
            padding-top: 85px;
        }

        .navbar-nutritrack {
            background: var(--nav-bg);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(0,0,0,0.08);
            padding: 0.75rem 0;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        .navbar-brand {
            font-weight: 800;
            font-size: 1.4rem;
            color: var(--primary) !important;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .nav-link-custom {
            font-weight: 600;
            color: var(--text-muted);
            padding: 0.5rem 1.2rem !important;
            border-radius: 12px;
            transition: all 0.2s ease;
            font-size: 0.95rem;
            text-decoration: none;
        }

        .nav-link-custom:hover,
        .nav-link-custom.active {
            color: #0f172a;
            background: #e2e8f0;
        }

        .profile-trigger {
            background: #fff;
            border: 1.5px solid #edf2f7;
            padding: 4px 12px 4px 6px;
            border-radius: 50px;
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
        }

        .avatar-circle {
            width: 32px;
            height: 32px;
            background: #ef4444; /* Warna merah untuk Admin */
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.8rem;
        }

        .dropdown-menu {
            border: none;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            padding: 10px;
            min-width: 220px;
        }

        .dropdown-item {
            border-radius: 10px;
            padding: 0.6rem 1rem;
            font-weight: 500;
        }

        .dropdown-item:hover {
            background-color: var(--primary-soft);
            color: var(--primary);
        }

        .main-content {
            padding: 20px;
        }

        .footer-nav {
            margin-top: 60px;
            padding: 20px 0;
            text-align: center;
            color: var(--text-muted);
            font-size: 0.9rem;
        }
    </style>
</head>

<body>

{{-- NAVBAR KHAS UNTUK ADMIN --}}
<nav class="navbar navbar-expand-lg navbar-nutritrack fixed-top">
  <div class="container-fluid px-4">
        

        <a class="navbar-brand" href="{{ route('admin.dashboard') }}">
            <i class="bi bi-shield-lock-fill text-danger"></i>
            NutriTrack <span class="badge bg-danger ms-2" style="font-size: 0.7rem; vertical-align: middle;">ADMIN PANEL</span>
        </a>

        <button class="navbar-toggler border-0 shadow-none"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#topNavBar">
            <span class="bi bi-list fs-2"></span>
        </button>

        <div class="collapse navbar-collapse" id="topNavBar">

            {{-- MENU ADMIN SAHAJA --}}
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4 gap-2">
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}"
                       class="nav-link-custom {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.meals.index') }}"
                       class="nav-link-custom {{ request()->routeIs('admin.meals.*') ? 'active' : '' }}">
                        <i class="bi bi-egg-fried"></i> Manage Meals
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.users.index') }}"
                       class="nav-link-custom {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        <i class="bi bi-people"></i> Manage Users
                    </a>
                </li>
                
                <li class="nav-item">
                    <a href="{{ route('admin.spoonacular.index') }}"
                       class="nav-link-custom {{ request()->routeIs('admin.spoonacular.*') ? 'active' : '' }}">
                        <i class="bi bi-cloud-download"></i> Spoonacular API
                    </a>
                </li>
            </ul>



            <div class="d-flex align-items-center gap-2">
                <div class="dropdown">
                    <div class="profile-trigger" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="avatar-circle">A</div>
                        <span class="fw-bold d-none d-md-inline" style="font-size:0.9rem; color:var(--text-main);">
                            Admin User
                        </span>
                        <i class="bi bi-chevron-down small text-muted"></i>
                    </div>

                   <ul class="dropdown-menu dropdown-menu-end">
    <li>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="dropdown-item text-danger">
                <i class="bi bi-power"></i> Log Out
            </button>
        </form>
    </li>
</ul>
                </div>
            </div>
        </div>
    </div>
</nav>

{{-- MAIN CONTENT --}}
<main class="main-content container">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm border-0">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @yield('content')
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')

</body>
</html>