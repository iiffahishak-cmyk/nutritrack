@extends('layouts.admin')
@section('title', 'Manage Meals — NutriTrack Admin')

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
    --card:#FFFFFF;
    --shadow:0 18px 45px rgba(15,23,42,.07);
}

.meals-hero {
    border-radius:30px;
    padding:1.6rem;
    color:white;
    background:linear-gradient(135deg,#071B46,#176BFF);
    margin-bottom:1.2rem;
    box-shadow:0 24px 65px rgba(23,107,255,.16);
}

.meals-hero h1 {
    font-weight:900;
    letter-spacing:-.05em;
    margin:0;
}

.meals-hero p {
    color:rgba(255,255,255,.78);
    margin:.35rem 0 0;
}

.nt-btn {
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:.45rem;
    min-height:42px;
    padding:.65rem 1rem;
    border-radius:999px;
    font-size:.84rem;
    font-weight:900;
    text-decoration:none;
    border:0;
    transition:.2s ease;
}

.nt-btn:hover {
    transform:translateY(-2px);
}

.btn-white {
    background:white;
    color:var(--blue-dark);
}

.stat-grid {
    display:grid;
    grid-template-columns:repeat(5, 1fr);
    gap:.8rem;
    margin-bottom:1rem;
}

.stat-card {
    background:var(--card);
    border:1px solid rgba(23,107,255,.09);
    border-radius:24px;
    box-shadow:var(--shadow);
    padding:1rem;
}

.stat-label {
    color:var(--muted);
    font-size:.68rem;
    font-weight:900;
    letter-spacing:.08em;
    text-transform:uppercase;
}

.stat-value {
    margin-top:.3rem;
    font-size:1.7rem;
    font-weight:900;
    letter-spacing:-.05em;
}

.panel {
    background:var(--card);
    border:1px solid rgba(23,107,255,.09);
    border-radius:28px;
    box-shadow:var(--shadow);
    overflow:hidden;
}

.panel-body {
    padding:1.15rem;
}

.filter-input {
    border-radius:16px;
    border:1px solid rgba(23,107,255,.14);
    background:#F8FBFF;
    padding:.78rem .9rem;
    font-weight:700;
}

.filter-input:focus {
    border-color:var(--blue);
    box-shadow:0 0 0 4px rgba(23,107,255,.09);
}

.table thead th {
    color:var(--muted);
    font-size:.72rem;
    font-weight:900;
    text-transform:uppercase;
    letter-spacing:.06em;
    border:0;
    background:#F8FBFF;
    padding:.85rem;
}

.table tbody td {
    padding:.85rem;
    vertical-align:middle;
    border-bottom:1px solid rgba(23,107,255,.06);
}

.meal-thumb {
    width:52px;
    height:52px;
    border-radius:18px;
    object-fit:cover;
    background:var(--blue-soft);
}

.meal-name {
    font-weight:900;
    color:var(--text);
}

.meal-desc {
    color:var(--muted);
    font-size:.74rem;
    margin-top:.15rem;
}

.badge-soft {
    display:inline-flex;
    align-items:center;
    gap:.35rem;
    padding:.35rem .65rem;
    border-radius:999px;
    font-size:.72rem;
    font-weight:900;
}

.action-icon-btn {
    width:36px;
    height:36px;
    border-radius:14px;
    display:inline-grid;
    place-items:center;
    border:0;
    background:#F8FBFF;
    text-decoration:none;
    transition:.18s ease;
}

.action-icon-btn:hover {
    transform:translateY(-2px);
}

@media(max-width:1200px) {
    .stat-grid {
        grid-template-columns:repeat(2, 1fr);
    }
}

@media(max-width:768px) {
    .stat-grid {
        grid-template-columns:1fr;
    }
}
</style>
@endpush

@section('content')
<div class="container-fluid py-2">

    <div class="meals-hero">
        <div class="d-flex justify-content-between align-items-center gap-3 flex-wrap">
            <div>
                <div style="font-size:.72rem;font-weight:900;letter-spacing:.08em;text-transform:uppercase;opacity:.8;">
                    Admin Meal Database
                </div>
                <h1>Manage Meals</h1>
                <p>Add, edit, filter, and improve meals used by Daily Plan, Meal Options, and Weekly Plan.</p>
            </div>

            <a href="{{ route('admin.meals.create') }}" class="nt-btn btn-white">
                <i class="bi bi-plus-circle"></i>
                Add New Meal
            </a>
        </div>
    </div>

    <div class="stat-grid">
        <div class="stat-card">
            <div class="stat-label">Total Meals</div>
            <div class="stat-value text-primary">{{ $totalMeals ?? 0 }}</div>
        </div>

        <div class="stat-card">
            <div class="stat-label">Breakfast</div>
            <div class="stat-value" style="color:var(--orange);">{{ $countByTime['Breakfast'] ?? 0 }}</div>
        </div>

        <div class="stat-card">
            <div class="stat-label">Lunch</div>
            <div class="stat-value" style="color:var(--green);">{{ $countByTime['Lunch'] ?? 0 }}</div>
        </div>

        <div class="stat-card">
            <div class="stat-label">Dinner</div>
            <div class="stat-value" style="color:var(--blue);">{{ $countByTime['Dinner'] ?? 0 }}</div>
        </div>

        <div class="stat-card">
            <div class="stat-label">Snack</div>
            <div class="stat-value" style="color:var(--purple);">{{ $countByTime['Snack'] ?? 0 }}</div>
        </div>
    </div>

    <div class="panel mb-4">
        <div class="panel-body">
            <form method="GET" action="{{ route('admin.meals.index') }}" class="row g-3 align-items-end">
                <div class="col-12 col-lg-4">
                    <label class="form-label small fw-bold text-muted text-uppercase">Search Meal</label>
                    <input type="text"
                           name="search"
                           value="{{ request('search') }}"
                           class="form-control filter-input"
                           placeholder="Search by meal name...">
                </div>

                <div class="col-12 col-md-4 col-lg-3">
                    <label class="form-label small fw-bold text-muted text-uppercase">Meal Time</label>
                    <select name="meal_time" class="form-select filter-input">
                        <option value="">All Times</option>
                        @foreach(['Breakfast','Lunch','Dinner','Snack'] as $t)
                            <option value="{{ $t }}" {{ request('meal_time') == $t ? 'selected' : '' }}>
                                {{ $t }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12 col-md-4 col-lg-3">
                    <label class="form-label small fw-bold text-muted text-uppercase">Cuisine</label>
                    <select name="cuisine_type" class="form-select filter-input">
                        <option value="">All Cuisines</option>
                        @foreach($cuisines as $c)
                            <option value="{{ $c }}" {{ request('cuisine_type') == $c ? 'selected' : '' }}>
                                {{ $c }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12 col-md-4 col-lg-2">
                    <button type="submit" class="btn btn-primary w-100 rounded-pill fw-bold py-2">
                        <i class="bi bi-funnel me-1"></i>
                        Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="panel">
        <div class="panel-body">
            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                <div class="fw-bold text-muted">
                    Showing {{ $meals->firstItem() ?? 0 }}–{{ $meals->lastItem() ?? 0 }} of {{ $meals->total() }} meals
                </div>

                <a href="{{ route('admin.spoonacular.index') }}" class="btn btn-sm btn-outline-primary rounded-pill fw-bold px-3">
                    <i class="bi bi-cloud-download me-1"></i>
                    Import More Data
                </a>
            </div>

            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Meal</th>
                            <th>Time</th>
                            <th>Cuisine</th>
                            <th>Calories</th>
                            <th>Macros</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($meals as $meal)
                            @php
                                $timeColors = [
                                    'Breakfast' => ['bg' => 'var(--orange-soft)', 'color' => 'var(--orange)', 'icon' => 'bi-sunrise-fill'],
                                    'Lunch' => ['bg' => 'var(--green-soft)', 'color' => 'var(--green)', 'icon' => 'bi-sun-fill'],
                                    'Dinner' => ['bg' => 'var(--blue-soft)', 'color' => 'var(--blue)', 'icon' => 'bi-moon-stars-fill'],
                                    'Snack' => ['bg' => 'var(--purple-soft)', 'color' => 'var(--purple)', 'icon' => 'bi-apple'],
                                ];

                                $tc = $timeColors[$meal->meal_time] ?? ['bg' => '#F1F5F9', 'color' => '#64748B', 'icon' => 'bi-circle'];
                            @endphp

                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <img src="{{ $meal->image_url }}" class="meal-thumb" alt="{{ $meal->meal_name }}">
                                        <div>
                                            <div class="meal-name">{{ $meal->meal_name }}</div>
                                            <div class="meal-desc">
                                                {{ \Illuminate\Support\Str::limit($meal->description ?? 'No description', 65) }}
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <span class="badge-soft" style="background:{{ $tc['bg'] }};color:{{ $tc['color'] }};">
                                        <i class="bi {{ $tc['icon'] }}"></i>
                                        {{ $meal->meal_time }}
                                    </span>
                                </td>

                                <td>
                                    <span class="fw-bold text-muted">{{ $meal->cuisine_type ?? 'No cuisine' }}</span>
                                </td>

                                <td>
                                    <span class="badge-soft" style="background:var(--blue-soft);color:var(--blue);">
                                        {{ $meal->calories }} kcal
                                    </span>
                                </td>

                                <td>
                                    <div class="small fw-bold text-muted">
                                        P {{ $meal->protein }}g · C {{ $meal->carbs }}g · F {{ $meal->fat }}g
                                    </div>
                                </td>

                                <td class="text-end">
                                    <a href="{{ route('admin.meals.edit', $meal->meal_id) }}"
                                       class="action-icon-btn text-warning"
                                       title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                    <form action="{{ route('admin.meals.destroy', $meal->meal_id) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Delete {{ addslashes($meal->meal_name) }}?')">
                                        @csrf
                                        @method('DELETE')

                                        <button class="action-icon-btn text-danger" title="Delete">
                                            <i class="bi bi-trash3-fill"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-5">
                                    <i class="bi bi-inbox fs-1 d-block mb-3 text-light"></i>
                                    <h5 class="fw-bold">No meals found</h5>
                                    <p>
                                        Try a different filter or
                                        <a href="{{ route('admin.meals.create') }}" class="text-decoration-none fw-bold">
                                            add a new meal
                                        </a>.
                                    </p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4 d-flex justify-content-end">
                {{ $meals->withQueryString()->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>

</div>
@endsection
