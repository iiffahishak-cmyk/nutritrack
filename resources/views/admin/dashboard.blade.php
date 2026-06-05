@extends('layouts.admin')
@section('title', 'Admin Dashboard — NutriTrack')

@push('styles')
<style>
:root {
    --blue:#176BFF;
    --blue-dark:#0B3D91;
    --blue-soft:#EAF2FF;
    --green:#16A34A;
    --green-soft:#EAFBF1;
    --orange:#F97316;
    --orange-soft:#FFF4E8;
    --purple:#7C3AED;
    --purple-soft:#F3E8FF;
    --red:#DC2626;
    --red-soft:#FEE2E2;
    --text:#0F172A;
    --muted:#64748B;
    --card:rgba(255,255,255,.9);
    --shadow:0 20px 55px rgba(15,23,42,.08);
}

body {
    background:
        radial-gradient(circle at 8% 10%, rgba(23,107,255,.10), transparent 26%),
        linear-gradient(135deg, #F8FBFF 0%, #EEF5FF 52%, #F9FCFF 100%);
}

.admin-hero {
    border-radius: 34px;
    padding: clamp(1.4rem, 3vw, 2.2rem);
    color: white;
    background:
        radial-gradient(circle at 20% 20%, rgba(32,199,255,.35), transparent 28%),
        linear-gradient(135deg, #071B46 0%, #0B3D91 48%, #176BFF 100%);
    box-shadow: 0 24px 70px rgba(23,107,255,.16);
    margin-bottom: 1.3rem;
    position: relative;
    overflow: hidden;
}

.admin-hero::after {
    content:"";
    position:absolute;
    right:-120px;
    bottom:-130px;
    width:360px;
    height:360px;
    border-radius:50%;
    background:rgba(255,255,255,.1);
}

.hero-content {
    position:relative;
    z-index:2;
}

.hero-kicker {
    display:inline-flex;
    align-items:center;
    gap:.45rem;
    padding:.45rem .78rem;
    border-radius:999px;
    background:rgba(255,255,255,.13);
    border:1px solid rgba(255,255,255,.2);
    font-size:.72rem;
    font-weight:900;
    letter-spacing:.08em;
    text-transform:uppercase;
    margin-bottom:.85rem;
}

.admin-hero h1 {
    font-size:clamp(2rem, 4vw, 3.4rem);
    font-weight:900;
    letter-spacing:-.06em;
    line-height:1;
    margin-bottom:.55rem;
}

.admin-hero p {
    color:rgba(255,255,255,.78);
    margin:0;
    line-height:1.7;
}

.quick-actions {
    display:flex;
    gap:.65rem;
    flex-wrap:wrap;
    margin-top:1.25rem;
}

.nt-btn {
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:.5rem;
    min-height:44px;
    padding:.72rem 1rem;
    border-radius:999px;
    border:0;
    font-size:.84rem;
    font-weight:900;
    text-decoration:none;
    transition:.2s ease;
}

.nt-btn:hover {
    transform:translateY(-2px);
}

.btn-white {
    background:white;
    color:var(--blue-dark);
}

.btn-glass {
    background:rgba(255,255,255,.13);
    color:white;
    border:1px solid rgba(255,255,255,.22);
}

.btn-glass:hover {
    color:white;
    background:rgba(255,255,255,.2);
}

.stat-grid {
    display:grid;
    grid-template-columns:repeat(4, 1fr);
    gap:1rem;
    margin-bottom:1.2rem;
}

.stat-card {
    background:var(--card);
    border:1px solid rgba(23,107,255,.1);
    border-radius:28px;
    box-shadow:var(--shadow);
    padding:1.15rem;
    position:relative;
    overflow:hidden;
    min-height:140px;
}

.stat-card::after {
    content:"";
    position:absolute;
    width:130px;
    height:130px;
    right:-70px;
    top:-70px;
    border-radius:50%;
    background:rgba(23,107,255,.08);
}

.stat-icon {
    width:46px;
    height:46px;
    border-radius:18px;
    display:grid;
    place-items:center;
    margin-bottom:.8rem;
    position:relative;
    z-index:2;
}

.stat-label {
    color:var(--muted);
    font-size:.72rem;
    font-weight:900;
    letter-spacing:.08em;
    text-transform:uppercase;
    position:relative;
    z-index:2;
}

.stat-value {
    font-size:2rem;
    font-weight:900;
    letter-spacing:-.06em;
    line-height:1;
    margin-top:.35rem;
    position:relative;
    z-index:2;
}

.stat-sub {
    color:var(--muted);
    font-size:.78rem;
    margin-top:.35rem;
    position:relative;
    z-index:2;
}

.panel {
    background:var(--card);
    border:1px solid rgba(23,107,255,.1);
    border-radius:30px;
    box-shadow:var(--shadow);
    overflow:hidden;
}

.panel-head {
    padding:1.1rem 1.25rem;
    border-bottom:1px solid rgba(23,107,255,.08);
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:1rem;
    flex-wrap:wrap;
}

.panel-head h5 {
    margin:0;
    font-weight:900;
    color:var(--text);
}

.panel-head p {
    margin:.25rem 0 0;
    color:var(--muted);
    font-size:.84rem;
}

.panel-body {
    padding:1.25rem;
}

.coverage-row {
    display:flex;
    align-items:center;
    gap:.75rem;
    margin-bottom:.85rem;
}

.coverage-label {
    width:120px;
    color:var(--text);
    font-weight:900;
    font-size:.86rem;
}

.coverage-track {
    flex:1;
    height:12px;
    border-radius:999px;
    background:#E5EFFF;
    overflow:hidden;
}

.coverage-fill {
    height:100%;
    border-radius:999px;
    background:linear-gradient(135deg, var(--blue), var(--blue-dark));
}

.coverage-count {
    width:55px;
    text-align:right;
    color:var(--muted);
    font-weight:900;
    font-size:.82rem;
}

.action-grid {
    display:grid;
    grid-template-columns:repeat(2, 1fr);
    gap:.8rem;
}

.action-card {
    display:flex;
    align-items:center;
    gap:.8rem;
    padding:1rem;
    border-radius:24px;
    background:#F8FBFF;
    border:1px solid rgba(23,107,255,.08);
    text-decoration:none;
    color:var(--text);
    transition:.18s ease;
    min-height:78px;
}

.action-card:hover {
    transform:translateY(-3px);
    background:var(--blue-soft);
    color:var(--text);
}

.action-icon {
    width:44px;
    height:44px;
    border-radius:16px;
    display:grid;
    place-items:center;
    background:var(--blue-soft);
    color:var(--blue);
    flex-shrink:0;
}

.action-title {
    font-weight:900;
    font-size:.9rem;
}

.action-sub {
    color:var(--muted);
    font-size:.76rem;
    margin-top:.1rem;
}

.health-note {
    border-radius:24px;
    padding:1rem;
    background:var(--orange-soft);
    color:#9A3412;
    font-size:.86rem;
    line-height:1.6;
}

/* ===== Cleaner equal cards for Recent Meals and Recent Users ===== */

.dashboard-equal-panel {
    height: auto;
}

.dashboard-equal-list {
    display: grid;
    gap: .75rem;
}

.dashboard-equal-item {
    min-height: 72px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    padding: .85rem 1rem;
    border-radius: 18px;
    background: #F8FBFF;
    border: 1px solid rgba(23,107,255,.08);
}

.dashboard-equal-title {
    font-weight: 900;
    color: var(--text);
    font-size: .88rem;
    line-height: 1.25;
}

.dashboard-equal-sub {
    color: var(--muted);
    font-size: .74rem;
    margin-top: .22rem;
}

.dashboard-equal-value {
    flex-shrink: 0;
    min-width: 88px;
    text-align: right;
    font-weight: 900;
    color: var(--blue);
    font-size: .86rem;
}

@media(max-width:1200px) {
    .stat-grid {
        grid-template-columns:repeat(2, 1fr);
    }
}

@media(max-width:768px) {
    .stat-grid,
    .action-grid {
        grid-template-columns:1fr;
    }

    .coverage-label {
        width:90px;
    }

    .dashboard-equal-item {
        align-items:flex-start;
    }

    .dashboard-equal-value {
        min-width:70px;
    }
}
</style>
@endpush

@section('content')
@php
    $targetPerCuisine = 40;
    $targetPerSlot = 50;

    $slotLabels = ['Breakfast', 'Lunch', 'Dinner', 'Snack'];
    $cuisineLabels = ['Malay', 'Chinese', 'Indian', 'Western', 'Middle Eastern'];

    $timeCounts = collect($mealsByTime ?? []);
    $cuisineCounts = collect($mealsByCuisine ?? []);
@endphp

<div class="container-fluid py-2">

    <div class="admin-hero">
        <div class="hero-content">
            <div class="hero-kicker">
                <i class="bi bi-shield-lock-fill"></i>
                Admin Control Center
            </div>

            <h1>Manage NutriTrack’s meal intelligence.</h1>

            <p>
                Monitor users, improve the meal database, import verified recipes, and check whether
                the recommendation system has enough data coverage.
            </p>

            <div class="quick-actions">
                <a href="{{ route('admin.meals.create') }}" class="nt-btn btn-white">
                    <i class="bi bi-plus-circle"></i>
                    Add New Meal
                </a>

                <a href="{{ route('admin.spoonacular.index') }}" class="nt-btn btn-glass">
                    <i class="bi bi-cloud-download"></i>
                    Spoonacular Import
                </a>

                <a href="{{ route('admin.food-items.index') }}" class="nt-btn btn-glass">
                    <i class="bi bi-check2-circle"></i>
                    Verify Imported Items
                </a>
            </div>
        </div>
    </div>

    <div class="stat-grid">
        <div class="stat-card">
            <div class="stat-icon" style="background:var(--blue-soft);color:var(--blue);">
                <i class="bi bi-people-fill"></i>
            </div>
            <div class="stat-label">Registered Users</div>
            <div class="stat-value">{{ number_format($totalUsers ?? 0) }}</div>
            <div class="stat-sub">{{ number_format($newUsersThisWeek ?? 0) }} new this week</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background:var(--green-soft);color:var(--green);">
                <i class="bi bi-egg-fried"></i>
            </div>
            <div class="stat-label">Main Meal Database</div>
            <div class="stat-value">{{ number_format($totalMeals ?? 0) }}</div>
            <div class="stat-sub">verified meals available</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background:var(--purple-soft);color:var(--purple);">
                <i class="bi bi-calendar2-check-fill"></i>
            </div>
            <div class="stat-label">Today’s Plans</div>
            <div class="stat-value">{{ number_format($totalRecommendations ?? 0) }}</div>
            <div class="stat-sub">daily recommendations generated today</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background:var(--orange-soft);color:var(--orange);">
                <i class="bi bi-database-check"></i>
            </div>
            <div class="stat-label">Database Target</div>
            <div class="stat-value">200</div>
            <div class="stat-sub">recommended minimum meals</div>
        </div>
    </div>

    <div class="row g-4 align-items-start">
        <div class="col-12 col-xl-7">
            <div class="panel mb-4">
                <div class="panel-head">
                    <div>
                        <h5><i class="bi bi-graph-up-arrow text-primary me-2"></i>Recommendation Database Health</h5>
                        <p>Target: at least 40 meals per cuisine for stronger personalization.</p>
                    </div>
                </div>

                <div class="panel-body">
                    @foreach($cuisineLabels as $cuisine)
                        @php
                            $count = (int) ($cuisineCounts[$cuisine] ?? 0);
                            $pct = min(100, round(($count / $targetPerCuisine) * 100));
                        @endphp

                        <div class="coverage-row">
                            <div class="coverage-label">{{ $cuisine }}</div>
                            <div class="coverage-track">
                                <div class="coverage-fill"
                                     style="width:{{ $pct }}%; background:{{ $pct >= 75 ? 'linear-gradient(135deg,#16A34A,#15803D)' : 'linear-gradient(135deg,#176BFF,#0B3D91)' }};">
                                </div>
                            </div>
                            <div class="coverage-count">{{ $count }}/{{ $targetPerCuisine }}</div>
                        </div>
                    @endforeach

                    @if(($totalMeals ?? 0) < 200)
                        <div class="health-note mt-3">
                            <i class="bi bi-exclamation-circle-fill me-1"></i>
                            Your meal database is still below the recommended FYP target.
                            Aim for <strong>5 cuisines × 4 meal times × 10 meals = 200 meals</strong>
                            to make recommendations more accurate.
                        </div>
                    @endif
                </div>
            </div>

            <div class="panel dashboard-equal-panel">
                <div class="panel-head">
                    <div>
                        <h5><i class="bi bi-clock-history text-primary me-2"></i>Recent Meals</h5>
                        <p>Latest meals added to the main recommendation database.</p>
                    </div>

                    <a href="{{ route('admin.meals.index') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                        Browse All
                    </a>
                </div>

                <div class="panel-body">
                    <div class="dashboard-equal-list">
                        @forelse($recentMeals ?? [] as $meal)
                            <div class="dashboard-equal-item">
                                <div>
                                    <div class="dashboard-equal-title">
                                        {{ \Illuminate\Support\Str::limit($meal->meal_name, 38) }}
                                    </div>

                                    <div class="dashboard-equal-sub">
                                        {{ $meal->meal_time ?? 'No time' }} · {{ $meal->cuisine_type ?? 'No cuisine' }}
                                    </div>
                                </div>

                                <div class="dashboard-equal-value">
                                    {{ number_format($meal->calories ?? 0) }} kcal
                                </div>
                            </div>
                        @empty
                            <div class="text-center text-muted py-4">
                                <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                                No meals yet.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-xl-5">
            <div class="panel mb-4">
                <div class="panel-head">
                    <div>
                        <h5><i class="bi bi-pie-chart-fill text-primary me-2"></i>Meal Slot Coverage</h5>
                        <p>Each meal time should have enough options.</p>
                    </div>
                </div>

                <div class="panel-body">
                    @foreach($slotLabels as $slot)
                        @php
                            $count = (int) ($timeCounts[$slot] ?? 0);
                            $pct = min(100, round(($count / $targetPerSlot) * 100));
                        @endphp

                        <div class="coverage-row">
                            <div class="coverage-label">{{ $slot }}</div>
                            <div class="coverage-track">
                                <div class="coverage-fill"
                                     style="width:{{ $pct }}%; background:{{ $pct >= 75 ? 'linear-gradient(135deg,#16A34A,#15803D)' : 'linear-gradient(135deg,#F97316,#EA580C)' }};">
                                </div>
                            </div>
                            <div class="coverage-count">{{ $count }}/{{ $targetPerSlot }}</div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="panel mb-4">
                <div class="panel-head">
                    <div>
                        <h5><i class="bi bi-lightning-charge-fill text-primary me-2"></i>Quick Admin Actions</h5>
                        <p>Common tasks for improving NutriTrack data.</p>
                    </div>
                </div>

                <div class="panel-body">
                    <div class="action-grid">
                        <a href="{{ route('admin.meals.create') }}" class="action-card">
                            <div class="action-icon"><i class="bi bi-plus-lg"></i></div>
                            <div>
                                <div class="action-title">Add Meal</div>
                                <div class="action-sub">Manual local meal data</div>
                            </div>
                        </a>

                        <a href="{{ route('admin.meals.index') }}" class="action-card">
                            <div class="action-icon"><i class="bi bi-search"></i></div>
                            <div>
                                <div class="action-title">Manage Meals</div>
                                <div class="action-sub">Edit database items</div>
                            </div>
                        </a>

                        <a href="{{ route('admin.spoonacular.index') }}" class="action-card">
                            <div class="action-icon"><i class="bi bi-cloud-download"></i></div>
                            <div>
                                <div class="action-title">Import API Data</div>
                                <div class="action-sub">Use Spoonacular</div>
                            </div>
                        </a>

                        <a href="{{ route('admin.users.index') }}" class="action-card">
                            <div class="action-icon"><i class="bi bi-people"></i></div>
                            <div>
                                <div class="action-title">Manage Users</div>
                                <div class="action-sub">View user accounts</div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <div class="panel dashboard-equal-panel">
                <div class="panel-head">
                    <div>
                        <h5><i class="bi bi-person-plus-fill text-primary me-2"></i>Recent Users</h5>
                        <p>Latest registered users.</p>
                    </div>
                </div>

                <div class="panel-body">
                    <div class="dashboard-equal-list">
                        @forelse($recentUsers ?? [] as $user)
                            <div class="dashboard-equal-item">
                                <div>
                                    <div class="dashboard-equal-title">
                                        {{ \Illuminate\Support\Str::limit($user->name, 28) }}
                                    </div>

                                    <div class="dashboard-equal-sub">
                                        {{ \Illuminate\Support\Str::limit($user->email, 32) }}
                                    </div>
                                </div>

                                <div class="dashboard-equal-value text-muted">
                                    {{ $user->created_at?->format('d M') }}
                                </div>
                            </div>
                        @empty
                            <div class="text-center text-muted py-4">
                                No users yet.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection