{{-- resources/views/meals/weekly.blade.php --}}
@extends('layouts.app')
@section('title', 'Weekly Meal Plan — NutriTrack')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Playfair+Display:wght@700;800&display=swap" rel="stylesheet">

<style>
:root {
    --blue: #176BFF;
    --blue-dark: #0B3D91;
    --blue-soft: #EAF2FF;
    --cyan: #20C7FF;
    --green: #16A34A;
    --green-soft: #EAFBF1;
    --orange: #F97316;
    --orange-soft: #FFF4E8;
    --purple: #7C3AED;
    --purple-soft: #F3E8FF;
    --red: #DC2626;
    --red-soft: #FEE2E2;
    --bg: #F6F9FF;
    --card: rgba(255,255,255,.84);
    --text: #0F172A;
    --muted: #64748B;
    --line: rgba(23,107,255,.12);
    --shadow: 0 24px 70px rgba(23,107,255,.12);
    --shadow-soft: 0 14px 40px rgba(15,23,42,.07);
    --radius: 30px;
}

body {
    font-family: 'Inter', sans-serif;
    background:
        radial-gradient(circle at 10% 12%, rgba(32,199,255,.16), transparent 28%),
        radial-gradient(circle at 92% 10%, rgba(23,107,255,.14), transparent 30%),
        linear-gradient(135deg, #F8FBFF 0%, #EEF5FF 52%, #F9FCFF 100%);
    color: var(--text);
}

.weekly-page {
    position: relative;
}

.weekly-page::before {
    content: "";
    position: fixed;
    inset: 0;
    pointer-events: none;
    background-image:
        linear-gradient(rgba(23,107,255,.04) 1px, transparent 1px),
        linear-gradient(90deg, rgba(23,107,255,.04) 1px, transparent 1px);
    background-size: 58px 58px;
    mask-image: linear-gradient(to bottom, rgba(0,0,0,.75), transparent 90%);
    z-index: -1;
}

/* HERO */
.week-hero {
    border-radius: 38px;
    padding: clamp(1.4rem, 3vw, 2.4rem);
    color: white;
    background:
        radial-gradient(circle at 18% 20%, rgba(32,199,255,.38), transparent 28%),
        radial-gradient(circle at 92% 16%, rgba(255,255,255,.16), transparent 24%),
        linear-gradient(135deg, #071B46 0%, #0B3D91 48%, #176BFF 100%);
    box-shadow: var(--shadow);
    position: relative;
    overflow: hidden;
    margin-bottom: 1.2rem;
}

.week-hero::after {
    content: "";
    position: absolute;
    right: -110px;
    bottom: -120px;
    width: 360px;
    height: 360px;
    border-radius: 50%;
    background: rgba(255,255,255,.1);
}

.week-hero-content {
    position: relative;
    z-index: 2;
}

.week-kicker {
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
    backdrop-filter: blur(10px);
}

.week-hero h1 {
    font-family: 'Playfair Display', serif;
    font-size: clamp(2rem, 4vw, 3.5rem);
    line-height: 1;
    letter-spacing: -.045em;
    margin-bottom: .55rem;
}

.week-hero p {
    color: rgba(255,255,255,.78);
    margin: 0;
    font-size: .95rem;
}

.week-actions {
    display: flex;
    flex-wrap: wrap;
    gap: .7rem;
    margin-top: 1.35rem;
}

.week-btn {
    min-height: 44px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: .55rem;
    padding: .72rem 1rem;
    border-radius: 16px;
    border: 0;
    font-size: .84rem;
    font-weight: 900;
    text-decoration: none;
    transition: .2s ease;
    white-space: nowrap;
}

.week-btn:hover {
    transform: translateY(-2px);
}

.btn-white {
    background: white;
    color: var(--blue-dark);
    box-shadow: 0 14px 35px rgba(0,0,0,.13);
}

.btn-white:hover {
    color: var(--blue-dark);
}

.btn-glass {
    background: rgba(255,255,255,.12);
    color: white;
    border: 1px solid rgba(255,255,255,.22);
    backdrop-filter: blur(10px);
}

.btn-glass:hover {
    color: white;
    background: rgba(255,255,255,.2);
}

.week-mini-card {
    position: relative;
    z-index: 2;
    background: rgba(255,255,255,.14);
    border: 1px solid rgba(255,255,255,.2);
    backdrop-filter: blur(16px);
    border-radius: 28px;
    padding: 1.2rem;
}

.week-mini-label {
    font-size: .7rem;
    font-weight: 900;
    letter-spacing: .08em;
    text-transform: uppercase;
    color: rgba(255,255,255,.68);
    margin-bottom: .45rem;
}

.week-mini-value {
    font-size: 2.25rem;
    line-height: 1;
    font-weight: 900;
    letter-spacing: -.06em;
}

.week-mini-sub {
    color: rgba(255,255,255,.7);
    font-size: .8rem;
    margin-top: .3rem;
}

/* ALERT */
.nt-alert-success {
    background: var(--green-soft);
    border: 1px solid rgba(22,163,74,.25);
    color: #166534;
    border-radius: 22px;
    padding: .9rem 1.1rem;
    display: flex;
    align-items: center;
    gap: .7rem;
    margin-bottom: 1.1rem;
    font-size: .88rem;
    box-shadow: var(--shadow-soft);
}

/* EMPTY */
.empty-state {
    background: rgba(255,255,255,.84);
    border: 1px dashed rgba(23,107,255,.25);
    border-radius: 30px;
    padding: 3rem 1.5rem;
    text-align: center;
    box-shadow: var(--shadow-soft);
}

.empty-icon {
    width: 82px;
    height: 82px;
    border-radius: 28px;
    background: var(--blue-soft);
    color: var(--blue);
    display: grid;
    place-items: center;
    margin: 0 auto 1rem;
    font-size: 2.2rem;
}

/* OVERVIEW CARDS */
.summary-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: .9rem;
    margin-bottom: 1.2rem;
}

.summary-card {
    background: var(--card);
    border: 1px solid rgba(23,107,255,.1);
    box-shadow: var(--shadow-soft);
    border-radius: 26px;
    padding: 1rem;
    backdrop-filter: blur(18px);
    position: relative;
    overflow: hidden;
}

.summary-card::after {
    content: "";
    position: absolute;
    width: 130px;
    height: 130px;
    right: -70px;
    top: -70px;
    border-radius: 50%;
    background: rgba(23,107,255,.08);
}

.summary-label {
    position: relative;
    z-index: 2;
    font-size: .68rem;
    color: var(--muted);
    font-weight: 900;
    letter-spacing: .08em;
    text-transform: uppercase;
}

.summary-value {
    position: relative;
    z-index: 2;
    font-size: 1.55rem;
    font-weight: 900;
    letter-spacing: -.05em;
    margin-top: .35rem;
}

.summary-sub {
    position: relative;
    z-index: 2;
    color: var(--muted);
    font-size: .75rem;
    margin-top: .15rem;
}

/* DAY SELECTOR */
.day-strip {
    background: rgba(255,255,255,.72);
    border: 1px solid rgba(23,107,255,.1);
    border-radius: 28px;
    padding: .7rem;
    box-shadow: var(--shadow-soft);
    backdrop-filter: blur(18px);
    display: flex;
    gap: .6rem;
    overflow-x: auto;
    margin-bottom: 1.2rem;
    scrollbar-width: none;
}

.day-strip::-webkit-scrollbar {
    display: none;
}

.day-tab {
    min-width: 132px;
    flex-shrink: 0;
    background: transparent;
    border: 1px solid transparent;
    border-radius: 22px;
    padding: .8rem .85rem;
    color: inherit;
    text-decoration: none;
    transition: .2s ease;
}

.day-tab:hover {
    background: rgba(23,107,255,.07);
}

.day-tab.active {
    background: linear-gradient(135deg, var(--blue), var(--blue-dark));
    color: white;
    box-shadow: 0 14px 34px rgba(23,107,255,.28);
}

.day-tab.is-today:not(.active) {
    border-color: rgba(23,107,255,.22);
    background: var(--blue-soft);
}

.day-name {
    font-size: .7rem;
    font-weight: 900;
    letter-spacing: .08em;
    text-transform: uppercase;
    opacity: .72;
}

.day-date {
    font-size: 1.25rem;
    font-weight: 900;
    margin-top: .18rem;
    line-height: 1;
}

.day-kcal {
    display: inline-flex;
    margin-top: .5rem;
    padding: .2rem .5rem;
    border-radius: 999px;
    background: rgba(23,107,255,.09);
    color: var(--blue-dark);
    font-size: .68rem;
    font-weight: 900;
}

.day-tab.active .day-kcal {
    background: rgba(255,255,255,.2);
    color: white;
}

/* DAY PANEL */
.day-panel {
    display: none;
    animation: fadeIn .25s ease both;
}

.day-panel.active {
    display: block;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(8px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.day-header {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    gap: 1rem;
    margin-bottom: 1rem;
}

.day-title {
    font-family: 'Playfair Display', serif;
    color: var(--text);
    font-size: clamp(1.8rem, 3vw, 2.6rem);
    line-height: 1;
    letter-spacing: -.045em;
    margin: 0;
}

.day-subtitle {
    color: var(--muted);
    font-size: .9rem;
    margin-top: .25rem;
}

.today-pill {
    display: inline-flex;
    align-items: center;
    border-radius: 999px;
    padding: .28rem .6rem;
    background: var(--blue);
    color: white;
    font-size: .66rem;
    font-weight: 900;
    letter-spacing: .06em;
}

/* MEAL GRID */
.meal-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1rem;
}

.meal-card {
    background: var(--card);
    border: 1px solid rgba(23,107,255,.1);
    border-radius: 30px;
    box-shadow: var(--shadow-soft);
    overflow: hidden;
    backdrop-filter: blur(18px);
    transition: .22s ease;
}

.meal-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 24px 65px rgba(23,107,255,.13);
}

.meal-top {
    min-height: 110px;
    padding: 1rem;
    color: white;
    position: relative;
    overflow: hidden;
}

.meal-top::after {
    content: "";
    position: absolute;
    right: -55px;
    top: -55px;
    width: 140px;
    height: 140px;
    border-radius: 50%;
    background: rgba(255,255,255,.16);
}

.slot-breakfast .meal-top {
    background: linear-gradient(135deg, #F97316, #EA580C);
}

.slot-lunch .meal-top {
    background: linear-gradient(135deg, #16A34A, #0F7A36);
}

.slot-dinner .meal-top {
    background: linear-gradient(135deg, #176BFF, #0B3D91);
}

.slot-snack .meal-top {
    background: linear-gradient(135deg, #7C3AED, #5B21B6);
}

.slot-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: .75rem;
    position: relative;
    z-index: 2;
}

.slot-name {
    display: flex;
    align-items: center;
    gap: .45rem;
    font-size: .72rem;
    font-weight: 900;
    letter-spacing: .08em;
    text-transform: uppercase;
    opacity: .85;
}

.slot-budget {
    font-size: .7rem;
    font-weight: 900;
    padding: .25rem .55rem;
    border-radius: 999px;
    background: rgba(255,255,255,.18);
}

.meal-name {
    position: relative;
    z-index: 2;
    margin-top: 1.2rem;
    font-size: 1.25rem;
    line-height: 1.15;
    font-weight: 900;
    letter-spacing: -.035em;
}

.meal-body {
    padding: 1rem;
}

.meal-desc {
    color: var(--muted);
    font-size: .84rem;
    line-height: 1.6;
    margin-bottom: .8rem;
}

.macro-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: .45rem;
    margin-bottom: .8rem;
}

.macro-box {
    border-radius: 16px;
    padding: .55rem .45rem;
    text-align: center;
    background: #F8FBFF;
    border: 1px solid rgba(23,107,255,.08);
}

.macro-value {
    font-size: .83rem;
    font-weight: 900;
    line-height: 1;
}

.macro-label {
    font-size: .58rem;
    color: var(--muted);
    font-weight: 800;
    text-transform: uppercase;
    margin-top: .25rem;
}

.meal-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: .75rem;
}

.cuisine-pill {
    display: inline-flex;
    align-items: center;
    gap: .35rem;
    border-radius: 999px;
    background: var(--blue-soft);
    color: var(--blue-dark);
    padding: .35rem .6rem;
    font-size: .72rem;
    font-weight: 900;
}

.btn-swap {
    display: inline-flex;
    align-items: center;
    gap: .35rem;
    border: 0;
    border-radius: 999px;
    background: #F1F5F9;
    color: var(--blue);
    padding: .42rem .75rem;
    font-size: .75rem;
    font-weight: 900;
    transition: .18s ease;
}

.btn-swap:hover {
    background: var(--blue-soft);
    transform: translateY(-2px);
}

.btn-swap.spinning i {
    animation: spin .65s linear infinite;
}

@keyframes spin {
    to {
        transform: rotate(360deg);
    }
}

.empty-meal {
    padding: 1rem;
    color: var(--muted);
    font-size: .86rem;
    display: flex;
    align-items: center;
    gap: .55rem;
}

/* DAY SUMMARY */
.day-summary {
    margin-top: 1rem;
    background: rgba(255,255,255,.84);
    border: 1px solid rgba(23,107,255,.1);
    border-radius: 28px;
    box-shadow: var(--shadow-soft);
    padding: 1rem;
    display: grid;
    grid-template-columns: 170px 1fr;
    gap: 1rem;
    align-items: center;
}

.day-total {
    border-radius: 22px;
    padding: 1rem;
    background: var(--blue-soft);
    text-align: center;
}

.day-total-value {
    font-size: 1.7rem;
    font-weight: 900;
    letter-spacing: -.05em;
    color: var(--blue);
    line-height: 1;
}

.day-total-label {
    color: var(--muted);
    font-size: .68rem;
    font-weight: 900;
    text-transform: uppercase;
    margin-top: .35rem;
}

.progress-label {
    display: flex;
    justify-content: space-between;
    color: var(--muted);
    font-size: .76rem;
    font-weight: 800;
    margin-bottom: .45rem;
}

.progress-track {
    height: 10px;
    border-radius: 999px;
    background: #E5EFFF;
    overflow: hidden;
}

.progress-fill {
    height: 100%;
    border-radius: 999px;
    transition: .4s ease;
}

.day-macro-row {
    display: flex;
    gap: .55rem;
    margin-top: .75rem;
    flex-wrap: wrap;
}

.day-macro-chip {
    border-radius: 999px;
    padding: .35rem .65rem;
    font-size: .75rem;
    font-weight: 900;
}

/* PAST WEEKS */
.past-weeks {
    margin-top: 1.2rem;
    background: rgba(255,255,255,.72);
    border: 1px solid rgba(23,107,255,.1);
    border-radius: 28px;
    box-shadow: var(--shadow-soft);
    backdrop-filter: blur(18px);
    padding: 1rem;
}

.past-title {
    color: var(--muted);
    font-size: .72rem;
    font-weight: 900;
    letter-spacing: .1em;
    text-transform: uppercase;
    margin-bottom: .75rem;
}

.past-list {
    display: flex;
    gap: .6rem;
    overflow-x: auto;
    scrollbar-width: none;
}

.past-list::-webkit-scrollbar {
    display: none;
}

.past-item {
    min-width: 155px;
    padding: .85rem;
    border-radius: 20px;
    border: 1px solid rgba(23,107,255,.1);
    background: #fff;
    color: inherit;
    text-decoration: none;
    transition: .18s ease;
}

.past-item:hover {
    transform: translateY(-3px);
    box-shadow: 0 16px 35px rgba(23,107,255,.1);
}

.past-item.current {
    border-color: rgba(23,107,255,.35);
    background: var(--blue-soft);
}

.past-label {
    color: var(--text);
    font-size: .82rem;
    font-weight: 900;
}

.past-sub {
    color: var(--muted);
    font-size: .68rem;
    margin-top: .2rem;
}

.plan-status {
    display: inline-flex;
    margin-top: .55rem;
    padding: .22rem .5rem;
    border-radius: 999px;
    font-size: .65rem;
    font-weight: 900;
}

.has-plan {
    background: var(--green-soft);
    color: var(--green);
}

.no-plan {
    background: #F1F5F9;
    color: #94A3B8;
}

/* TOAST */
#toast-box {
    position: fixed;
    bottom: 1.5rem;
    right: 1.5rem;
    z-index: 9999;
    display: flex;
    flex-direction: column;
    gap: .5rem;
}

.toast-msg {
    background: #0F172A;
    color: #fff;
    border-radius: 14px;
    padding: .75rem 1rem;
    font-size: .84rem;
    font-weight: 800;
    animation: slideIn .2s ease;
    box-shadow: 0 14px 35px rgba(15,23,42,.2);
}

.toast-msg.success {
    background: var(--green);
}

.toast-msg.error {
    background: var(--red);
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateX(16px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

/* ANIMATION */
.fade-up {
    animation: fadeUp .45s ease both;
}

.fade-up-2 {
    animation: fadeUp .45s .08s ease both;
}

.fade-up-3 {
    animation: fadeUp .45s .16s ease both;
}

@keyframes fadeUp {
    from {
        opacity: 0;
        transform: translateY(18px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@media (max-width: 991px) {
    .summary-grid {
        grid-template-columns: repeat(2, 1fr);
    }

    .meal-grid {
        grid-template-columns: 1fr;
    }

    .day-summary {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 767px) {
    .week-hero {
        border-radius: 28px;
    }

    .week-actions .week-btn {
        width: 100%;
    }

    .week-mini-card {
        margin-top: 1rem;
    }

    .summary-grid {
        grid-template-columns: 1fr;
    }

    .day-tab {
        min-width: 118px;
    }

    .macro-grid {
        grid-template-columns: repeat(2, 1fr);
    }

    .meal-footer {
        align-items: flex-start;
        flex-direction: column;
    }

    .btn-swap {
        width: 100%;
        justify-content: center;
    }
}
</style>
@endpush

@section('content')

@php
$slots = ['Breakfast', 'Lunch', 'Dinner', 'Snack'];

$slotIcons = [
    'Breakfast' => '🌅',
    'Lunch' => '☀️',
    'Dinner' => '🌙',
    'Snack' => '🍎',
];

$slotSplit = [
    'Breakfast' => 0.25,
    'Lunch' => 0.35,
    'Dinner' => 0.25,
    'Snack' => 0.15,
];

$slotBudgets = [
    'Breakfast' => round($dcr * $slotSplit['Breakfast']),
    'Lunch' => round($dcr * $slotSplit['Lunch']),
    'Dinner' => round($dcr * $slotSplit['Dinner']),
    'Snack' => round($dcr * $slotSplit['Snack']),
];

$validCuisines = ['Malay', 'Chinese', 'Indian', 'Western', 'Middle Eastern'];

$weeklyKcal = 0;
$weeklyP = 0;
$weeklyC = 0;
$weeklyF = 0;
$daysWithData = 0;

foreach ($days as $d => $day) {
    $dayKcal = 0;

    foreach ($slots as $s) {
        $p = $planGrid[$d][$s] ?? null;

        if ($p && $p->meal) {
            $dayKcal += $p->meal->calories;
            $weeklyP += $p->meal->protein;
            $weeklyC += $p->meal->carbs;
            $weeklyF += $p->meal->fat;
        }
    }

    if ($dayKcal > 0) {
        $weeklyKcal += $dayKcal;
        $daysWithData++;
    }
}

$avgDaily = $daysWithData > 0 ? round($weeklyKcal / $daysWithData) : 0;
$weeklyPct = $dcr > 0 ? round(($avgDaily / $dcr) * 100) : 0;
$weeklyStatus = $weeklyPct > 105
    ? 'over target'
    : ($weeklyPct >= 90 ? 'near target' : 'under target');

$defaultDay = 1;
foreach ($days as $d => $day) {
    if ($day['isToday']) {
        $defaultDay = $d;
        break;
    }
}
@endphp

<div id="toast-box"></div>

<div class="weekly-page">

    {{-- HERO --}}
    <div class="week-hero fade-up">
        <div class="row align-items-center g-4">
            <div class="col-12 col-lg-8">
                <div class="week-hero-content">
                    <div class="week-kicker">
                        <i class="bi bi-calendar3-week-fill"></i>
                        Weekly Meal Planner
                    </div>

                    <h1>{{ $isCurrentWeek ? "This Week's Meal Plan" : "Past Meal Plan" }}</h1>

                    <p>
                        {{ $weekStart->format('d M') }} – {{ $weekEnd->format('d M Y') }}
                        · Target {{ number_format($dcr) }} kcal/day
                    </p>

                    <div class="week-actions">
                        <a href="{{ route('meals.weekly', ['week' => $prevWeek]) }}" class="week-btn btn-glass">
                            <i class="bi bi-chevron-left"></i>
                            Previous Week
                        </a>

                        @if($canGoNext)
                            <a href="{{ route('meals.weekly', ['week' => $nextWeek]) }}" class="week-btn btn-glass">
                                Next Week
                                <i class="bi bi-chevron-right"></i>
                            </a>
                        @endif

                        @if($isCurrentWeek)
                            <form method="POST" action="{{ route('meals.weekly.generate') }}" id="gen-form" class="m-0">
                                @csrf
                                <button type="submit" class="week-btn btn-white" id="gen-btn">
                                    <i class="bi bi-lightning-fill"></i>
                                    {{ $plans->count() > 0 ? 'Regenerate Plan' : 'Generate Week' }}
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-4">
                <div class="week-mini-card text-lg-end">
                    <div class="week-mini-label">Average Daily Calories</div>
                    <div class="week-mini-value">{{ number_format($avgDaily) }}</div>
                    <div class="week-mini-sub">
                        {{ $daysWithData }} of 7 days planned
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- FLASH --}}
    @if(session('success'))
        <div class="nt-alert-success fade-up-2">
            <i class="bi bi-check-circle-fill fs-5 flex-shrink-0"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    {{-- EMPTY STATE --}}
    @if($plans->count() === 0 && $isCurrentWeek)
        <div class="empty-state fade-up-2">
            <div class="empty-icon">
                <i class="bi bi-calendar-plus"></i>
            </div>

            <h5 style="font-weight:900;color:var(--text);margin-bottom:.45rem;">
                No meal plan yet for this week
            </h5>

            <p style="color:var(--muted);max-width:430px;margin:0 auto 1.1rem;font-size:.92rem;line-height:1.7;">
                Generate a 7-day plan based on your daily calorie target, allergies, and cuisine preference.
            </p>

            <form method="POST" action="{{ route('meals.weekly.generate') }}" class="m-0">
                @csrf
                <button type="submit" class="week-btn btn-white" style="background:linear-gradient(135deg,var(--blue),var(--blue-dark));color:white;">
                    <i class="bi bi-lightning-fill"></i>
                    Generate My Weekly Plan
                </button>
            </form>
        </div>

    @elseif($plans->count() === 0)
        <div class="empty-state fade-up-2">
            <div class="empty-icon">
                <i class="bi bi-calendar-x"></i>
            </div>

            <h5 style="font-weight:900;color:var(--text);margin-bottom:.45rem;">
                No plan for this week
            </h5>

            <p style="color:var(--muted);margin:0;font-size:.92rem;">
                A meal plan was not generated for this past week.
            </p>
        </div>

    @else

        {{-- SUMMARY --}}
        <div class="summary-grid fade-up-2">
            <div class="summary-card">
                <div class="summary-label">Weekly Total</div>
                <div class="summary-value" style="color:var(--blue);">{{ number_format($weeklyKcal) }}</div>
                <div class="summary-sub">kcal planned</div>
            </div>

            <div class="summary-card">
                <div class="summary-label">Average / Day</div>
                <div class="summary-value" style="color:var(--green);">{{ number_format($avgDaily) }}</div>
                <div class="summary-sub">{{ $weeklyPct }}% of DCR · {{ $weeklyStatus }}</div>
            </div>

            <div class="summary-card">
                <div class="summary-label">Protein</div>
                <div class="summary-value" style="color:var(--purple);">{{ round($weeklyP) }}g</div>
                <div class="summary-sub">weekly total</div>
            </div>

            <div class="summary-card">
                <div class="summary-label">Carbs / Fat</div>
                <div class="summary-value" style="font-size:1.25rem;color:var(--orange);">
                    {{ round($weeklyC) }}g / {{ round($weeklyF) }}g
                </div>
                <div class="summary-sub">weekly total</div>
            </div>
        </div>

        {{-- DAY TABS --}}
        <div class="day-strip fade-up-2">
            @foreach($days as $dayNum => $day)
                @php
                    $dayKcal = 0;

                    foreach ($slots as $s) {
                        $p = $planGrid[$dayNum][$s] ?? null;

                        if ($p && $p->meal) {
                            $dayKcal += $p->meal->calories;
                        }
                    }

                    $hasData = $dayKcal > 0;
                @endphp

                <a href="#"
                   class="day-tab {{ $dayNum === $defaultDay ? 'active' : '' }} {{ $day['isToday'] ? 'is-today' : '' }}"
                   data-day="{{ $dayNum }}"
                   onclick="switchDay({{ $dayNum }}); return false;">
                    <div class="day-name">{{ $day['label'] }}</div>
                    <div class="day-date">{{ $day['carbon']->format('d M') }}</div>
                    <div class="day-kcal">{{ $hasData ? number_format($dayKcal) . ' kcal' : 'No plan' }}</div>
                </a>
            @endforeach
        </div>

        {{-- DAY PANELS --}}
        @foreach($days as $dayNum => $day)
            @php
                $dayKcalTotal = 0;
                $dayProtein = 0;
                $dayCarbs = 0;
                $dayFat = 0;

                foreach ($slots as $s) {
                    $p = $planGrid[$dayNum][$s] ?? null;

                    if ($p && $p->meal) {
                        $dayKcalTotal += $p->meal->calories;
                        $dayProtein += $p->meal->protein;
                        $dayCarbs += $p->meal->carbs;
                        $dayFat += $p->meal->fat;
                    }
                }

                $dayPct = $dcr > 0 ? round(($dayKcalTotal / $dcr) * 100) : 0;
                $progressWidth = min(100, $dayPct);

                $calorieGap = $dayKcalTotal - $dcr;

                if ($dayPct > 105) {
                    $progressColor = '#F97316';
                    $progressMessage = 'Over target by ' . number_format(abs($calorieGap)) . ' kcal';
                } elseif ($dayPct >= 90) {
                    $progressColor = '#16A34A';
                    $progressMessage = 'Within a good daily range';
                } else {
                    $progressColor = '#176BFF';
                    $progressMessage = 'Under target by ' . number_format(abs($calorieGap)) . ' kcal';
                }
            @endphp

            <div class="day-panel {{ $dayNum === $defaultDay ? 'active' : '' }}"
                 id="day-panel-{{ $dayNum }}">

                <div class="day-header fade-up-3">
                    <div>
                        <h2 class="day-title">{{ $day['carbon']->format('l') }}</h2>
                        <div class="day-subtitle">{{ $day['carbon']->format('d F Y') }}</div>
                    </div>

                    @if($day['isToday'])
                        <span class="today-pill">TODAY</span>
                    @endif
                </div>

                <div class="meal-grid fade-up-3">
                    @foreach($slots as $slot)
                        @php
                            $plan = $planGrid[$dayNum][$slot] ?? null;
                            $meal = $plan?->meal;
                            $budget = $slotBudgets[$slot];
                            $slotClass = 'slot-' . strtolower($slot);
                            $cuisine = $meal?->cuisine_type;
                            $cuisineDisplay = in_array($cuisine, $validCuisines) ? $cuisine : ($cuisine ?: 'General');
                        @endphp

                        <div class="meal-card {{ $slotClass }}">
                            <div class="meal-top">
                                <div class="slot-row">
                                    <div class="slot-name">
                                        <span>{{ $slotIcons[$slot] }}</span>
                                        <span>{{ $slot }}</span>
                                    </div>

                                    <div class="slot-budget">
                                        {{ number_format($budget) }} kcal target
                                    </div>
                                </div>

                                <div class="meal-name">
                                    {{ $meal ? $meal->meal_name : 'No meal assigned' }}
                                </div>
                            </div>

                            <div class="meal-body">
                                @if($meal)
                                    @if($meal->description)
                                        <div class="meal-desc">
                                            {{ \Illuminate\Support\Str::limit($meal->description, 95) }}
                                        </div>
                                    @else
                                        <div class="meal-desc">
                                            Recommended meal based on your target and preference.
                                        </div>
                                    @endif

                                    <div class="macro-grid">
                                        <div class="macro-box">
                                            <div class="macro-value" style="color:var(--blue);">{{ $meal->calories }}</div>
                                            <div class="macro-label">kcal</div>
                                        </div>

                                        <div class="macro-box">
                                            <div class="macro-value" style="color:var(--purple);">{{ $meal->protein }}g</div>
                                            <div class="macro-label">Protein</div>
                                        </div>

                                        <div class="macro-box">
                                            <div class="macro-value" style="color:var(--orange);">{{ $meal->carbs }}g</div>
                                            <div class="macro-label">Carbs</div>
                                        </div>

                                        <div class="macro-box">
                                            <div class="macro-value" style="color:#9333EA;">{{ $meal->fat }}g</div>
                                            <div class="macro-label">Fat</div>
                                        </div>
                                    </div>

                                    <div class="meal-footer">
                                        <div class="cuisine-pill">
                                            <i class="bi bi-geo-alt-fill"></i>
                                            {{ $cuisineDisplay }}
                                        </div>

                                        @if($isCurrentWeek)
                                            <button class="btn-swap"
                                                    id="swap-btn-{{ $dayNum }}-{{ $slot }}"
                                                    onclick="swapMeal({{ $dayNum }}, '{{ $slot }}', {{ $meal->meal_id }}, this)">
                                                <i class="bi bi-arrow-repeat"></i>
                                                Swap
                                            </button>
                                        @endif
                                    </div>
                                @else
                                    <div class="empty-meal">
                                        <i class="bi bi-dash-circle"></i>
                                        <span>No meal assigned for this slot.</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                @if($dayKcalTotal > 0)
                    <div class="day-summary fade-up-3">
                        <div class="day-total">
                            <div class="day-total-value">{{ number_format($dayKcalTotal) }}</div>
                            <div class="day-total-label">Total kcal</div>
                        </div>

                        <div>
                            <div class="progress-label">
                                <span>Daily target progress</span>
                                <span style="color:{{ $progressColor }};">{{ $dayPct }}%</span>
                            </div>

                            <div class="progress-track">
                                <div class="progress-fill"
                                     style="width:{{ $progressWidth }}%; background:{{ $progressColor }};">
                                </div>
                            </div>

                            <div class="mt-2"
                                 style="font-size:.76rem;font-weight:900;color:{{ $progressColor }};">
                                {{ $progressMessage }}
                            </div>

                            <div class="day-macro-row">
                                <span class="day-macro-chip" style="background:var(--purple-soft);color:var(--purple);">
                                    Protein {{ round($dayProtein) }}g
                                </span>

                                <span class="day-macro-chip" style="background:var(--orange-soft);color:var(--orange);">
                                    Carbs {{ round($dayCarbs) }}g
                                </span>

                                <span class="day-macro-chip" style="background:#F3E8FF;color:#9333EA;">
                                    Fat {{ round($dayFat) }}g
                                </span>

                                <span class="day-macro-chip" style="background:var(--blue-soft);color:var(--blue-dark);">
                                    Target {{ number_format($dcr) }} kcal
                                </span>
                            </div>
                        </div>
                    </div>
                @endif

            </div>
        @endforeach

        {{-- PAST WEEKS --}}
        <div class="past-weeks fade-up-3">
            <div class="past-title">
                <i class="bi bi-clock-history me-1"></i>
                Week History
            </div>

            <div class="past-list">
                @forelse($pastWeeks as $pw)
                    <a href="{{ route('meals.weekly', ['week' => $pw['start']->toDateString()]) }}"
                       class="past-item {{ $pw['isCurrent'] ? 'current' : '' }}">
                        <div class="past-label">
                            {{ $pw['start']->format('d M') }} – {{ $pw['end']->format('d M') }}
                        </div>

                        <div class="past-sub">
                            Week {{ $pw['start']->weekOfYear }}, {{ $pw['start']->year }}
                        </div>

                        @if($pw['hasPlans'])
                            <span class="plan-status has-plan">
                                <i class="bi bi-check me-1"></i>
                                Has plan
                            </span>
                        @else
                            <span class="plan-status no-plan">
                                No plan
                            </span>
                        @endif
                    </a>
                @empty
                    <p style="font-size:.84rem;color:var(--muted);margin:0;">
                        No past weeks yet.
                    </p>
                @endforelse
            </div>
        </div>

    @endif
</div>
@endsection

@push('scripts')
<script>
const CSRF = document.querySelector('meta[name="csrf-token"]')?.content ?? '';

function switchDay(dayNum) {
    document.querySelectorAll('.day-tab').forEach(tab => tab.classList.remove('active'));
    document.querySelectorAll('.day-panel').forEach(panel => panel.classList.remove('active'));

    const selectedTab = document.querySelector(`.day-tab[data-day="${dayNum}"]`);
    const selectedPanel = document.getElementById(`day-panel-${dayNum}`);

    if (selectedTab) selectedTab.classList.add('active');
    if (selectedPanel) selectedPanel.classList.add('active');
}

function showToast(message, type = 'success') {
    const box = document.getElementById('toast-box');
    const toast = document.createElement('div');

    toast.className = `toast-msg ${type}`;
    toast.textContent = message;

    box.appendChild(toast);

    setTimeout(() => {
        toast.remove();
    }, 3500);
}

async function swapMeal(day, slot, mealId, btn) {
    btn.classList.add('spinning');
    btn.disabled = true;

    try {
        const response = await fetch('{{ route("meals.weekly.swap") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                day_of_week: day,
                meal_time: slot,
                current_meal_id: mealId
            })
        });

        const data = await response.json();

        if (data.success) {
            const mealCard = btn.closest('.meal-card');

            const nameEl = mealCard.querySelector('.meal-name');
            const macroBoxes = mealCard.querySelectorAll('.macro-value');

            if (nameEl) nameEl.textContent = data.meal_name;

            if (macroBoxes[0]) macroBoxes[0].textContent = data.calories;
            if (macroBoxes[1]) macroBoxes[1].textContent = data.protein + 'g';
            if (macroBoxes[2]) macroBoxes[2].textContent = data.carbs + 'g';
            if (macroBoxes[3]) macroBoxes[3].textContent = data.fat + 'g';

            btn.setAttribute('onclick', `swapMeal(${day}, '${slot}', ${data.meal_id}, this)`);

            updateDayTotal(day);

            showToast(`Swapped to ${data.meal_name}`);
        } else {
            showToast(data.message || 'No alternative meal found.', 'error');
        }
    } catch (error) {
        showToast('Network error. Please try again.', 'error');
    } finally {
        btn.classList.remove('spinning');
        btn.disabled = false;
    }
}

function updateDayTotal(day) {
    const panel = document.getElementById(`day-panel-${day}`);

    if (!panel) return;

    let total = 0;

    panel.querySelectorAll('.macro-box:first-child .macro-value').forEach(item => {
        const number = parseInt(item.textContent.replace(/[^\d]/g, '') || 0);
        total += number;
    });

    const tabTotal = document.querySelector(`.day-tab[data-day="${day}"] .day-kcal`);

    if (tabTotal) {
        tabTotal.textContent = total > 0 ? total.toLocaleString() + ' kcal' : 'No plan';
    }
}

const genForm = document.getElementById('gen-form');
const genBtn = document.getElementById('gen-btn');

if (genForm && genBtn) {
    genForm.addEventListener('submit', () => {
        genBtn.disabled = true;
        genBtn.innerHTML = '<span class="spinner-border spinner-border-sm" style="width:14px;height:14px;border-width:2px;"></span> Generating...';
    });
}
</script>
@endpush