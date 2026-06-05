<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>NutriTrack - @yield('title', 'Healthy Meal Planner')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    @stack('styles')

    <style>
    :root {
        --primary: #176BFF;
        --primary-dark: #0B3D91;
        --primary-soft: #EAF2FF;
        --cyan: #20C7FF;
        --green: #16A34A;
        --orange: #F97316;
        --purple: #7C3AED;
        --text-main: #0F172A;
        --text-muted: #64748B;
        --nav-bg: rgba(255, 255, 255, 0.82);
        --shadow-soft: 0 14px 40px rgba(15, 23, 42, .08);
    }

    body {
        font-family: 'Inter', 'Segoe UI', sans-serif;
        background:
            radial-gradient(circle at 10% 10%, rgba(32,199,255,.12), transparent 28%),
            radial-gradient(circle at 90% 6%, rgba(23,107,255,.10), transparent 30%),
            linear-gradient(135deg, #F8FBFF 0%, #EEF5FF 52%, #F9FCFF 100%);
        padding-top: 92px;
        color: var(--text-main);
    }

    .navbar-nutritrack {
        background: var(--nav-bg);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border-bottom: 1px solid rgba(23,107,255,.10);
        padding: .75rem 0;
        box-shadow: 0 10px 30px rgba(15,23,42,.04);
    }

    .brand-shell {
        display: inline-flex;
        align-items: center;
        gap: .65rem;
        text-decoration: none;
        color: var(--text-main);
        font-weight: 900;
        letter-spacing: -.04em;
        font-size: 1.25rem;
    }

    .brand-mark {
        width: 38px;
        height: 38px;
        border-radius: 15px;
        display: grid;
        place-items: center;
        color: white;
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        box-shadow: 0 14px 30px rgba(23,107,255,.25);
    }

    .brand-shell span span {
        color: var(--primary);
    }

    .nav-center {
        background: rgba(248,251,255,.8);
        border: 1px solid rgba(23,107,255,.08);
        border-radius: 999px;
        padding: .28rem;
        display: flex;
        gap: .12rem;
    }

    .nav-link-custom {
        display: inline-flex;
        align-items: center;
        gap: .42rem;
        font-weight: 800;
        color: var(--text-muted);
        padding: .58rem .72rem !important;
        border-radius: 999px;
        transition: all .2s ease;
        font-size: .82rem;
        text-decoration: none;
        white-space: nowrap;
    }

    .nav-link-custom:hover {
        color: var(--primary);
        background: rgba(23,107,255,.08);
    }

    .nav-link-custom.active {
        color: white;
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        box-shadow: 0 10px 24px rgba(23,107,255,.22);
    }

    .profile-trigger {
        background: #fff;
        border: 1px solid rgba(23,107,255,.12);
        padding: 5px 12px 5px 6px;
        border-radius: 999px;
        display: flex;
        align-items: center;
        gap: 10px;
        cursor: pointer;
        box-shadow: 0 10px 28px rgba(15,23,42,.06);
        transition: .2s ease;
    }

    .profile-trigger:hover {
        transform: translateY(-1px);
        border-color: rgba(23,107,255,.28);
    }

    .avatar-circle {
        width: 34px;
        height: 34px;
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: white;
        border-radius: 50%;
        display: grid;
        place-items: center;
        font-weight: 900;
        font-size: .8rem;
    }

    .dropdown-menu {
        border: 1px solid rgba(23,107,255,.08);
        border-radius: 22px;
        box-shadow: var(--shadow-soft);
        padding: .6rem;
        min-width: 260px;
    }

    .dropdown-header-card {
        padding: .8rem .85rem;
        border-radius: 18px;
        background: var(--primary-soft);
        margin-bottom: .45rem;
    }

    .dropdown-header-name {
        color: var(--text-main);
        font-weight: 900;
        font-size: .9rem;
    }

    .dropdown-header-email {
        color: var(--text-muted);
        font-size: .76rem;
        margin-top: .1rem;
    }

    .dropdown-item {
        border-radius: 14px;
        padding: .7rem .85rem;
        font-weight: 800;
        font-size: .88rem;
        display: flex;
        align-items: center;
        gap: .55rem;
    }

    .dropdown-item:hover {
        background-color: var(--primary-soft);
        color: var(--primary);
    }

    .dropdown-item.text-danger:hover {
        background: #FEE2E2;
        color: #DC2626 !important;
    }

    .btn-login {
        font-weight: 800;
        color: var(--text-main);
        text-decoration: none;
        padding: .55rem 1rem;
        border-radius: 999px;
    }

    .btn-login:hover {
        background: var(--primary-soft);
        color: var(--primary);
    }

    .btn-register-smart {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: white !important;
        font-weight: 900;
        padding: .65rem 1.3rem;
        border-radius: 999px;
        text-decoration: none;
        box-shadow: 0 14px 30px rgba(23,107,255,.22);
    }

    .navbar-toggler {
        background: var(--primary-soft);
        border-radius: 14px;
        padding: .5rem .65rem;
    }

    .main-content {
        padding: 20px;
    }

    .footer-nav {
        margin-top: 60px;
        padding: 20px 0;
        text-align: center;
        color: var(--text-muted);
        font-size: .9rem;
    }

    @media (max-width: 991px) {
        body {
            padding-top: 82px;
        }

        .navbar-collapse {
            margin-top: .9rem;
            padding: .9rem;
            border-radius: 24px;
            background: rgba(255,255,255,.9);
            border: 1px solid rgba(23,107,255,.08);
            box-shadow: var(--shadow-soft);
        }

        .nav-center {
            display: grid;
            border-radius: 22px;
            background: transparent;
            border: 0;
            padding: 0;
            gap: .45rem;
        }

        .nav-link-custom {
            width: 100%;
            border-radius: 16px;
            padding: .8rem .9rem !important;
        }

        .profile-trigger {
            width: 100%;
            justify-content: space-between;
            margin-top: .65rem;
        }
    }
</style>
</head>

<body>

{{-- NAVBAR --}}
<nav class="navbar navbar-expand-lg navbar-nutritrack fixed-top">
    <div class="container">

        <a class="brand-shell" href="{{ route('dashboard') }}">
            <span class="brand-mark">
                <i class="bi bi-heart-pulse-fill"></i>
            </span>
            <span>Nutri<span>Track</span></span>
        </a>

        <button class="navbar-toggler border-0 shadow-none"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#topNavBar"
                aria-controls="topNavBar"
                aria-expanded="false"
                aria-label="Toggle navigation">
            <span class="bi bi-list fs-3"></span>
        </button>

        <div class="collapse navbar-collapse" id="topNavBar">

            @auth
                <div class="navbar-nav mx-lg-auto mt-3 mt-lg-0">
                    <div class="nav-center">

                        <a href="{{ route('dashboard') }}"
                           class="nav-link-custom {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <i class="bi bi-grid-1x2-fill"></i>
                            Dashboard
                        </a>

                        <a href="{{ route('meals.recommend') }}"
                           class="nav-link-custom {{ request()->routeIs('meals.recommend') ? 'active' : '' }}">
                            <i class="bi bi-calendar2-check-fill"></i>
                            Daily Plan
                        </a>

                        <a href="{{ route('meals.hybrid-recommend') }}"
                           class="nav-link-custom {{ request()->routeIs('meals.hybrid-recommend') ? 'active' : '' }}">
                            <i class="bi bi-stars"></i>
                            Meal Options
                        </a>

                        <a href="{{ route('meals.weekly') }}"
                           class="nav-link-custom {{ request()->routeIs('meals.weekly') ? 'active' : '' }}">
                            <i class="bi bi-calendar3-week-fill"></i>
                            Weekly Plan
                        </a>

                        <a href="{{ route('food-logger.index') }}"
                           class="nav-link-custom {{ request()->routeIs('food-logger.*') ? 'active' : '' }}">
                            <i class="bi bi-robot"></i>
                            AI Logger
                        </a>

                        <a href="{{ route('diary.index') }}"
                           class="nav-link-custom {{ request()->routeIs('diary.*') ? 'active' : '' }}">
                            <i class="bi bi-journal-check"></i>
                            Meal Log
                        </a>
                    
                        <a href="{{ route('profile.index') }}"
                           class="nav-link-custom {{ request()->routeIs('profile.index') ? 'active' : '' }}">
                            <i class="bi bi-person-heart"></i>
                            Health Profile
                        </a>

                        @if(Auth::user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}"
                               class="nav-link-custom {{ request()->routeIs('admin.*') ? 'active' : '' }}">
                                <i class="bi bi-shield-lock-fill"></i>
                                Admin
                            </a>
                        @endif

                    </div>
                </div>
            @endauth

            <div class="d-flex align-items-center gap-2 ms-lg-auto mt-3 mt-lg-0">

                @auth
                    <div class="dropdown w-100 w-lg-auto">

                        <div class="profile-trigger"
                             data-bs-toggle="dropdown"
                             aria-expanded="false">

                            <div class="d-flex align-items-center gap-2">
                                <div class="avatar-circle">
                                    {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                                </div>

                                <span class="fw-bold"
                                      style="font-size:.9rem;color:var(--text-main);">
                                    {{ Auth::user()->name ?? 'User' }}
                                </span>
                            </div>

                            <i class="bi bi-chevron-down small text-muted"></i>
                        </div>

                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <div class="dropdown-header-card">
                                    <div class="dropdown-header-name">
                                        {{ Auth::user()->name ?? 'User' }}
                                    </div>
                                    <div class="dropdown-header-email">
                                        {{ Auth::user()->email ?? '' }}
                                    </div>
                                </div>
                            </li>

                            <li>
                                <a class="dropdown-item" href="{{ route('profile.index') }}">
                                    <i class="bi bi-person-heart"></i>
                                    Health Profile
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                    <i class="bi bi-gear"></i>
                                    Account Settings
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item" href="{{ route('diary.index') }}">
                                    <i class="bi bi-journal-check"></i>
                                    My Meal Log
                                </a>
                            </li>
                            <li>
    <a class="dropdown-item" href="{{ route('nutrition-guide') }}">
        <i class="bi bi-book-fill"></i>
        Nutrition Guide
    </a>
</li>

                            <li>
                                <hr class="dropdown-divider">
                            </li>

                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf

                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="bi bi-box-arrow-right"></i>
                                        Log Out
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="btn-login">
                        Login
                    </a>

                    <a href="{{ route('register') }}" class="btn-register-smart">
                        Get Started
                    </a>
                @endauth

            </div>
        </div>
    </div>
</nav>

{{-- MAIN CONTENT --}}
<main class="main-content container">

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="bi bi-check-circle"></i>
            {{ session('success') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="bi bi-exclamation-circle"></i>
            {{ session('error') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"></button>
        </div>
    @endif

    @yield('content')

</main>

{{-- FOOTER --}}
<footer class="footer-nav">
    <div class="container">
        &copy; {{ date('Y') }}
        <strong>NutriTrack</strong>
        — Empowering Healthy Lifestyles
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

@stack('scripts')

</body>
</html>
