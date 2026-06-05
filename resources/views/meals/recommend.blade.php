@extends('layouts.app')

@section('title', 'Today’s Meal Plan — NutriTrack')

@push('styles')
<style>
:root {
    --blue: #176BFF;
    --blue-dark: #0B3D91;
    --blue-soft: #EAF2FF;
    --green: #16A34A;
    --green-soft: #EAFBF1;
    --orange: #F97316;
    --orange-soft: #FFF4E8;
    --purple: #7C3AED;
    --purple-soft: #F3E8FF;
    --red: #DC2626;
    --red-soft: #FEE2E2;
    --text: #0F172A;
    --muted: #64748B;
    --card: rgba(255,255,255,.88);
    --shadow: 0 20px 55px rgba(15,23,42,.08);
}

body {
    background:
        radial-gradient(circle at 10% 10%, rgba(23,107,255,.12), transparent 28%),
        linear-gradient(135deg, #F8FBFF 0%, #EEF5FF 52%, #F9FCFF 100%);
}

.recommend-page {
    position: relative;
}

.plan-hero {
    border-radius: 34px;
    padding: clamp(1.4rem, 3vw, 2.2rem);
    color: white;
    background:
        radial-gradient(circle at 20% 20%, rgba(32,199,255,.35), transparent 28%),
        linear-gradient(135deg, #071B46 0%, #0B3D91 48%, #176BFF 100%);
    box-shadow: 0 24px 70px rgba(23,107,255,.16);
    margin-bottom: 1.3rem;
    overflow: hidden;
    position: relative;
}

.plan-hero::after {
    content: "";
    position: absolute;
    right: -120px;
    bottom: -130px;
    width: 360px;
    height: 360px;
    border-radius: 50%;
    background: rgba(255,255,255,.1);
}

.hero-content {
    position: relative;
    z-index: 2;
}

.hero-kicker {
    display: inline-flex;
    align-items: center;
    gap: .45rem;
    padding: .45rem .78rem;
    border-radius: 999px;
    background: rgba(255,255,255,.13);
    border: 1px solid rgba(255,255,255,.2);
    color: rgba(255,255,255,.88);
    font-size: .72rem;
    font-weight: 900;
    letter-spacing: .08em;
    text-transform: uppercase;
    margin-bottom: .85rem;
}

.plan-hero h1 {
    font-size: clamp(2rem, 4vw, 3.4rem);
    font-weight: 900;
    letter-spacing: -.06em;
    line-height: 1;
    margin-bottom: .55rem;
}

.plan-hero p {
    color: rgba(255,255,255,.78);
    margin: 0;
    line-height: 1.7;
}

.hero-stat {
    position: relative;
    z-index: 2;
    background: rgba(255,255,255,.14);
    border: 1px solid rgba(255,255,255,.22);
    border-radius: 26px;
    padding: 1.1rem;
    backdrop-filter: blur(16px);
}

.hero-stat-label {
    font-size: .7rem;
    font-weight: 900;
    letter-spacing: .08em;
    text-transform: uppercase;
    color: rgba(255,255,255,.68);
}

.hero-stat-value {
    font-size: 2.25rem;
    font-weight: 900;
    line-height: 1;
    margin-top: .35rem;
}

.hero-stat-sub {
    color: rgba(255,255,255,.72);
    font-size: .82rem;
    margin-top: .25rem;
}

.nt-btn {
    min-height: 44px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: .5rem;
    padding: .72rem 1rem;
    border-radius: 999px;
    border: 0;
    font-size: .84rem;
    font-weight: 900;
    text-decoration: none;
    transition: .2s ease;
}

.nt-btn:hover {
    transform: translateY(-2px);
}

.btn-white {
    background: white;
    color: var(--blue-dark);
}

.btn-white:hover {
    color: var(--blue-dark);
}

.info-card,
.side-card {
    background: var(--card);
    border: 1px solid rgba(23,107,255,.1);
    border-radius: 30px;
    box-shadow: var(--shadow);
    backdrop-filter: blur(18px);
}

.info-card {
    padding: 1rem;
    margin-bottom: 1.2rem;
}

.info-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: .75rem;
}

.info-item {
    padding: .9rem;
    border-radius: 22px;
    background: #F8FBFF;
    border: 1px solid rgba(23,107,255,.08);
}

.info-label {
    color: var(--muted);
    font-size: .68rem;
    font-weight: 900;
    text-transform: uppercase;
    letter-spacing: .08em;
}

.info-value {
    color: var(--text);
    font-size: 1.2rem;
    font-weight: 900;
    margin-top: .25rem;
}

.meal-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1rem;
}

.meal-card {
    background: var(--card);
    border: 1px solid rgba(23,107,255,.1);
    border-radius: 30px;
    box-shadow: var(--shadow);
    backdrop-filter: blur(18px);
    overflow: hidden;
    height: 100%;
    transition: .22s ease;
}

.meal-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 24px 65px rgba(23,107,255,.13);
}

.meal-image {
    height: 190px;
    position: relative;
    overflow: hidden;
}

.meal-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.meal-image::after {
    content: "";
    position: absolute;
    inset: 0;
    background: linear-gradient(to top, rgba(0,0,0,.68), rgba(0,0,0,.05));
}

.meal-overlay {
    position: absolute;
    left: 1rem;
    right: 1rem;
    bottom: 1rem;
    z-index: 2;
    color: white;
}

.meal-tags {
    display: flex;
    gap: .45rem;
    flex-wrap: wrap;
    margin-bottom: .65rem;
}

.meal-tag {
    display: inline-flex;
    align-items: center;
    gap: .3rem;
    padding: .25rem .55rem;
    border-radius: 999px;
    background: rgba(255,255,255,.18);
    backdrop-filter: blur(10px);
    font-size: .7rem;
    font-weight: 900;
}

.meal-title {
    font-size: 1.25rem;
    font-weight: 900;
    letter-spacing: -.035em;
    line-height: 1.15;
    margin: 0;
}

.meal-body {
    padding: 1rem;
}

.meal-description {
    color: var(--muted);
    font-size: .84rem;
    line-height: 1.6;
    min-height: 42px;
    margin-bottom: .85rem;
}

.macro-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: .45rem;
    margin-bottom: .9rem;
}

.macro-box {
    border-radius: 16px;
    padding: .55rem .45rem;
    text-align: center;
    background: #F8FBFF;
    border: 1px solid rgba(23,107,255,.08);
}

.macro-value {
    font-size: .8rem;
    font-weight: 900;
    line-height: 1;
}

.macro-label {
    color: var(--muted);
    font-size: .55rem;
    font-weight: 900;
    text-transform: uppercase;
    margin-top: .25rem;
}

.save-btn {
    width: 100%;
    min-height: 44px;
    border: 0;
    border-radius: 16px;
    background: linear-gradient(135deg, var(--blue), var(--blue-dark));
    color: white;
    font-weight: 900;
    font-size: .86rem;
    transition: .2s ease;
}

.save-btn:hover {
    transform: translateY(-2px);
}

.empty-meal {
    min-height: 320px;
    display: grid;
    place-items: center;
    text-align: center;
    padding: 1.5rem;
}

.side-card {
    padding: 1.1rem;
    margin-bottom: 1rem;
}

.side-title {
    color: var(--text);
    font-size: 1rem;
    font-weight: 900;
    margin-bottom: .85rem;
}

.chart-wrap {
    height: 220px;
}

.macro-summary {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: .6rem;
    margin-top: .9rem;
}

.macro-summary-item {
    text-align: center;
    border-radius: 18px;
    background: #F8FBFF;
    padding: .75rem .5rem;
}

.grocery-list {
    max-height: 340px;
    overflow-y: auto;
    padding-right: .25rem;
}

.grocery-item {
    display: flex;
    align-items: center;
    gap: .65rem;
    padding: .75rem;
    border-radius: 18px;
    background: #F8FBFF;
    border: 1px solid rgba(23,107,255,.07);
    margin-bottom: .55rem;
}

.grocery-item label {
    color: var(--text);
    font-size: .86rem;
    font-weight: 800;
    cursor: pointer;
}

.progress-box {
    margin-top: 1rem;
    padding: 1rem;
    border-radius: 26px;
    background: var(--blue-soft);
}

.progress {
    height: 10px;
    border-radius: 999px;
    background: #DCEBFF;
}

.toast-box {
    position: fixed;
    right: 1.5rem;
    bottom: 1.5rem;
    z-index: 9999;
}

.nt-toast {
    background: #0F172A;
    color: white;
    padding: .75rem 1rem;
    border-radius: 14px;
    font-weight: 800;
    box-shadow: 0 14px 35px rgba(15,23,42,.2);
}

@media(max-width: 991px) {
    .info-grid,
    .meal-grid {
        grid-template-columns: 1fr;
    }
}

@media(max-width: 575px) {
    .macro-grid,
    .macro-summary {
        grid-template-columns: 1fr 1fr;
    }
}
</style>
@endpush

@section('content')

@php
    $dailyPct = $dcr > 0 ? min(100, round(($macros['calories'] / $dcr) * 100)) : 0;
@endphp

<div class="toast-box" id="toastBox"></div>

<div class="recommend-page">

    <div class="plan-hero">
        <div class="row align-items-center g-4">
            <div class="col-12 col-lg-8">
                <div class="hero-content">
                    <div class="hero-kicker">
                        <i class="bi bi-calendar2-check-fill"></i>
                        Today’s Meal Plan
                    </div>

                    <h1>Your suggested menu for today.</h1>

                    <p>
                        This page gives one complete daily meal plan based on your calorie target, preferred cuisine,
                        allergies, and meal time.
                    </p>

                    <div class="mt-3">
                        <a href="{{ route('meals.recommend') }}" class="nt-btn btn-white">
                            <i class="bi bi-arrow-clockwise"></i>
                            Refresh Today’s Plan
                        </a>
                        <button type="button" class="nt-btn btn-white" onclick="saveFullDailyPlan(this)">
    <i class="bi bi-journal-plus"></i>
    Save Full Plan
</button>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-4">
                <div class="hero-stat text-lg-end">
                    <div class="hero-stat-label">Daily Target</div>
                    <div class="hero-stat-value">{{ number_format($dcr, 0) }}</div>
                    <div class="hero-stat-sub">
                        kcal/day · {{ now()->format('l, d M Y') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="info-card">
        <div class="info-grid">
            <div class="info-item">
                <div class="info-label">Planned Calories</div>
                <div class="info-value text-primary">{{ number_format($macros['calories']) }}</div>
            </div>

            <div class="info-item">
                <div class="info-label">Protein</div>
                <div class="info-value" style="color:var(--purple);">{{ $macros['protein'] }}g</div>
            </div>

            <div class="info-item">
                <div class="info-label">Carbs</div>
                <div class="info-value" style="color:#0891B2;">{{ $macros['carbs'] }}g</div>
            </div>

            <div class="info-item">
                <div class="info-label">Fat</div>
                <div class="info-value" style="color:var(--red);">{{ $macros['fat'] }}g</div>
            </div>
        </div>

        <div class="progress-box">
            <div class="d-flex justify-content-between small fw-bold mb-2">
                <span class="text-muted">Daily target progress</span>
                <span class="text-primary">{{ $dailyPct }}%</span>
            </div>

            <div class="progress">
                <div class="progress-bar" style="width: {{ $dailyPct }}%; background: linear-gradient(135deg, var(--blue), var(--blue-dark));"></div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-12 col-xl-8">
            <div class="meal-grid">
                @foreach(['Breakfast','Lunch','Dinner','Snack'] as $time)
                    @php
                        $meal = $meals[$time] ?? null;
                    @endphp

                    @if($meal)
                        <article class="meal-card">
                            <div class="meal-image">
                                <img src="{{ $meal->image_url }}" alt="{{ $meal->meal_name }}">

                                <div class="meal-overlay">
                                    <div class="meal-tags">
                                        <span class="meal-tag">
                                            <i class="bi bi-clock-fill"></i>
                                            {{ $time }}
                                        </span>

                                        <span class="meal-tag">
                                            <i class="bi bi-globe2"></i>
                                            {{ $meal->cuisine_type ?? 'General' }}
                                        </span>
                                    </div>

                                    <h3 class="meal-title">{{ $meal->meal_name }}</h3>
                                </div>
                            </div>

                            <div class="meal-body">
                                <div class="meal-description">
                                    {{ $meal->description ?? 'Balanced meal selected based on your calorie target and nutrition profile.' }}
                                </div>

                                <div class="macro-grid">
                                    <div class="macro-box">
                                        <div class="macro-value" style="color:var(--green);">{{ $meal->calories }}</div>
                                        <div class="macro-label">kcal</div>
                                    </div>

                                    <div class="macro-box">
                                        <div class="macro-value" style="color:var(--purple);">{{ $meal->protein }}g</div>
                                        <div class="macro-label">Protein</div>
                                    </div>

                                    <div class="macro-box">
                                        <div class="macro-value" style="color:#0891B2;">{{ $meal->carbs }}g</div>
                                        <div class="macro-label">Carbs</div>
                                    </div>

                                    <div class="macro-box">
                                        <div class="macro-value" style="color:var(--red);">{{ $meal->fat }}g</div>
                                        <div class="macro-label">Fat</div>
                                    </div>
                                </div>

                                <button type="button"
                                        class="save-btn"
                                        onclick="saveRecommendedMeal({{ $meal->meal_id }}, '{{ $time }}', this)">
                                    <i class="bi bi-journal-plus"></i>
                                    Save to Diary
                                </button>
                            </div>
                        </article>
                    @else
                        <div class="meal-card empty-meal">
                            <div>
                                <i class="bi bi-emoji-frown fs-1 text-muted d-block mb-2"></i>
                                <h6 class="fw-bold mb-1">No {{ $time }} Available</h6>
                                <p class="text-muted small mb-0">Add more {{ strtolower($time) }} meals in the admin meal database.</p>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>

        <div class="col-12 col-xl-4">
            <div class="side-card">
                <h6 class="side-title">
                    <i class="bi bi-pie-chart-fill text-primary me-2"></i>
                    Macro Distribution
                </h6>

                <div class="chart-wrap">
                    <canvas id="macroChart"></canvas>
                </div>

                <div class="macro-summary">
                    <div class="macro-summary-item">
                        <div class="fw-bold text-primary">{{ $macros['protein'] }}g</div>
                        <small class="text-muted fw-bold">Protein</small>
                    </div>

                    <div class="macro-summary-item">
                        <div class="fw-bold" style="color:#0891B2;">{{ $macros['carbs'] }}g</div>
                        <small class="text-muted fw-bold">Carbs</small>
                    </div>

                    <div class="macro-summary-item">
                        <div class="fw-bold text-danger">{{ $macros['fat'] }}g</div>
                        <small class="text-muted fw-bold">Fat</small>
                    </div>
                </div>
            </div>

            <div class="side-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="side-title mb-0">
                        <i class="bi bi-basket2-fill text-primary me-2"></i>
                        Grocery List
                    </h6>

                    <button onclick="printGroceryList()" class="btn btn-sm btn-light border rounded-pill">
                        <i class="bi bi-printer text-primary"></i>
                    </button>
                </div>

                @if(count($groceryList) > 0)
                    <div class="grocery-list" id="grocery-list-content">
                        @foreach($groceryList as $item)
                            <div class="grocery-item">
                                <input type="checkbox" class="form-check-input mt-0" onchange="strikeItem(this)">
                                <label>{{ $item }}</label>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-4 text-muted">
                        <i class="bi bi-cart-x fs-2 d-block mb-2"></i>
                        <p class="small mb-0">No grocery items found.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const ctx = document.getElementById('macroChart');

if (ctx) {
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Protein', 'Carbs', 'Fat'],
            datasets: [{
                data: [
                    {{ $macros['protein'] }},
                    {{ $macros['carbs'] }},
                    {{ $macros['fat'] }}
                ],
                backgroundColor: ['#7C3AED', '#0891B2', '#DC2626'],
                borderWidth: 0
            }]
        },
        options: {
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        boxWidth: 10,
                        font: {
                            size: 11,
                            weight: 'bold'
                        }
                    }
                }
            },
            cutout: '74%'
        }
    });
}

function showToast(message) {
    const box = document.getElementById('toastBox');
    box.innerHTML = `<div class="nt-toast">${message}</div>`;

    setTimeout(() => {
        box.innerHTML = '';
    }, 3000);
}

function strikeItem(checkbox) {
    const label = checkbox.nextElementSibling;
    label.style.textDecoration = checkbox.checked ? 'line-through' : 'none';
    label.style.opacity = checkbox.checked ? '.5' : '1';
}

function printGroceryList() {
    const items = document.querySelectorAll('#grocery-list-content label');

    let list = '';

    items.forEach(item => {
        list += `<li style="margin-bottom:8px;">${item.textContent}</li>`;
    });

    const win = window.open('', '_blank');

    win.document.write(`
        <html>
            <body style="font-family:sans-serif;padding:40px;">
                <h2>NutriTrack Grocery List</h2>
                <p>Generated on {{ now()->format('d M Y') }}</p>
                <hr>
                <ul>${list}</ul>
            </body>
        </html>
    `);

    win.print();
    win.close();
}

function saveRecommendedMeal(mealId, mealTime, btn) {
    const originalText = btn.innerHTML;

    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span>Saving...';
    btn.disabled = true;

    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    fetch("{{ route('meals.save') }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token,
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            meal_id: mealId,
            meal_time: mealTime
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            btn.innerHTML = '<i class="bi bi-check-circle-fill"></i> Saved';
            btn.style.background = 'linear-gradient(135deg, #16A34A, #15803D)';
            showToast(data.message || 'Meal saved to diary.');
        } else {
            btn.innerHTML = originalText;
            btn.disabled = false;
            showToast(data.message || 'Could not save this meal.');
        }
    })
    .catch(error => {
        console.error(error);
        btn.innerHTML = originalText;
        btn.disabled = false;
        showToast('Could not connect to the server.');
    });
}
@php
    $dailyPlanMealsForJs = collect($meals ?? [])
        ->filter()
        ->map(function ($meal, $time) {
            return [
                'meal_id' => $meal->meal_id,
                'meal_time' => $time,
            ];
        })
        ->values()
        ->toArray();
@endphp

const dailyPlanMeals = @json($dailyPlanMealsForJs);
function saveFullDailyPlan(btn) {
    if (!dailyPlanMeals.length) {
        showToast('No meals available to save.');
        return;
    }

    const original = btn.innerHTML;
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span>Saving...';

    fetch("{{ route('meals.save-many') }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            meals: dailyPlanMeals
        })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            btn.innerHTML = '<i class="bi bi-check-circle-fill"></i> Saved';
            showToast(data.message || 'Full plan saved.');
        } else {
            btn.disabled = false;
            btn.innerHTML = original;
            showToast(data.message || 'Could not save full plan.');
        }
    })
    .catch(() => {
        btn.disabled = false;
        btn.innerHTML = original;
        showToast('Could not connect to the server.');
    });
}
</script>
@endpush