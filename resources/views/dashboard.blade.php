{{-- resources/views/dashboard.blade.php --}}
@extends('layouts.app')
@section('title', 'Dashboard — NutriTrack')

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
    --card: rgba(255,255,255,.82);
    --text: #0F172A;
    --muted: #64748B;
    --line: rgba(23,107,255,.12);
    --shadow: 0 24px 70px rgba(23,107,255,.12);
    --shadow-soft: 0 14px 40px rgba(15,23,42,.07);
    --radius: 28px;
}

* {
    box-sizing: border-box;
}

body {
    font-family: 'Inter', sans-serif;
    background:
        radial-gradient(circle at 12% 12%, rgba(32,199,255,.16), transparent 28%),
        radial-gradient(circle at 92% 5%, rgba(23,107,255,.14), transparent 30%),
        linear-gradient(135deg, #F8FBFF 0%, #EEF5FF 50%, #F9FCFF 100%);
    color: var(--text);
}

.dashboard-wrap {
    position: relative;
}

.dashboard-wrap::before {
    content: "";
    position: fixed;
    inset: 0;
    pointer-events: none;
    background-image:
        linear-gradient(rgba(23,107,255,.04) 1px, transparent 1px),
        linear-gradient(90deg, rgba(23,107,255,.04) 1px, transparent 1px);
    background-size: 58px 58px;
    mask-image: linear-gradient(to bottom, rgba(0,0,0,.8), transparent 90%);
    z-index: -1;
}

/* ================= HERO ================= */
.dash-hero {
    position: relative;
    overflow: hidden;
    border-radius: 36px;
    padding: clamp(1.4rem, 3vw, 2.4rem);
    color: #fff;
    background:
        radial-gradient(circle at 18% 20%, rgba(32,199,255,.38), transparent 28%),
        radial-gradient(circle at 92% 16%, rgba(255,255,255,.16), transparent 24%),
        linear-gradient(135deg, #071B46 0%, #0B3D91 48%, #176BFF 100%);
    box-shadow: var(--shadow);
    margin-bottom: 1.3rem;
}

.dash-hero::after {
    content: "";
    position: absolute;
    right: -90px;
    bottom: -100px;
    width: 320px;
    height: 320px;
    border-radius: 50%;
    background: rgba(255,255,255,.1);
}

.hero-content {
    position: relative;
    z-index: 2;
}

.greeting-pill {
    display: inline-flex;
    align-items: center;
    gap: .45rem;
    padding: .45rem .78rem;
    border-radius: 999px;
    background: rgba(255,255,255,.13);
    border: 1px solid rgba(255,255,255,.2);
    color: rgba(255,255,255,.88);
    font-size: .72rem;
    font-weight: 800;
    letter-spacing: .08em;
    text-transform: uppercase;
    margin-bottom: .85rem;
    backdrop-filter: blur(10px);
}

.dash-hero h1 {
    font-family: 'Playfair Display', serif;
    font-size: clamp(2rem, 4vw, 3.4rem);
    line-height: 1;
    letter-spacing: -.045em;
    margin-bottom: .55rem;
}

.dash-hero p {
    color: rgba(255,255,255,.76);
    margin: 0;
    font-size: .95rem;
}

.hero-actions {
    display: flex;
    flex-wrap: wrap;
    gap: .7rem;
    margin-top: 1.35rem;
}

.hero-mini-card {
    position: relative;
    z-index: 2;
    background: rgba(255,255,255,.14);
    border: 1px solid rgba(255,255,255,.2);
    backdrop-filter: blur(16px);
    border-radius: 28px;
    padding: 1.2rem;
}

.hero-mini-label {
    font-size: .7rem;
    font-weight: 800;
    letter-spacing: .08em;
    text-transform: uppercase;
    color: rgba(255,255,255,.68);
    margin-bottom: .45rem;
}

.hero-dcr {
    font-size: 2.65rem;
    line-height: 1;
    font-weight: 900;
    letter-spacing: -.06em;
}

.hero-unit {
    color: rgba(255,255,255,.68);
    font-size: .82rem;
    font-weight: 600;
    margin-top: .25rem;
}

/* ================= BUTTONS ================= */
.dash-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: .55rem;
    min-height: 46px;
    padding: .78rem 1rem;
    border-radius: 16px;
    font-size: .86rem;
    font-weight: 800;
    border: 0;
    text-decoration: none;
    transition: .2s ease;
    white-space: nowrap;
}

.dash-btn:hover {
    transform: translateY(-2px);
}

.btn-white {
    background: #fff;
    color: var(--blue-dark);
    box-shadow: 0 14px 35px rgba(0,0,0,.13);
}

.btn-white:hover {
    color: var(--blue-dark);
}

.btn-glass {
    background: rgba(255,255,255,.12);
    color: #fff;
    border: 1px solid rgba(255,255,255,.22);
    backdrop-filter: blur(10px);
}

.btn-glass:hover {
    color: #fff;
    background: rgba(255,255,255,.2);
}

.btn-blue {
    background: linear-gradient(135deg, var(--blue), var(--blue-dark));
    color: #fff;
    box-shadow: 0 14px 32px rgba(23,107,255,.25);
}

.btn-blue:hover {
    color: #fff;
}

.btn-soft {
    background: var(--blue-soft);
    color: var(--blue-dark);
}

.btn-soft:hover {
    color: var(--blue-dark);
    background: #DDEBFF;
}

.btn-green {
    background: linear-gradient(135deg, #16A34A, #0F7A36);
    color: #fff;
    box-shadow: 0 14px 32px rgba(22,163,74,.22);
}

.btn-green:hover {
    color: #fff;
}

.btn-orange {
    background: linear-gradient(135deg, #F97316, #EA580C);
    color: #fff;
}

.btn-orange:hover {
    color: #fff;
}

/* ================= NO PROFILE ================= */
.no-profile-banner {
    background: rgba(255,255,255,.82);
    border: 1px solid rgba(249,115,22,.25);
    border-radius: 24px;
    padding: 1rem 1.15rem;
    display: flex;
    align-items: center;
    gap: .85rem;
    margin-bottom: 1.3rem;
    box-shadow: var(--shadow-soft);
}

/* ================= METRICS ================= */
.metric-card {
    height: 100%;
    border-radius: 28px;
    background: var(--card);
    border: 1px solid rgba(23,107,255,.1);
    box-shadow: var(--shadow-soft);
    padding: 1.25rem;
    backdrop-filter: blur(18px);
    position: relative;
    overflow: hidden;
    transition: .22s ease;
}

.metric-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 24px 65px rgba(23,107,255,.13);
}

.metric-card::after {
    content: "";
    position: absolute;
    width: 150px;
    height: 150px;
    right: -75px;
    top: -75px;
    border-radius: 50%;
    background: rgba(23,107,255,.08);
}

.metric-top {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1rem;
    position: relative;
    z-index: 2;
}

.metric-icon {
    width: 46px;
    height: 46px;
    border-radius: 17px;
    display: grid;
    place-items: center;
    font-size: 1.25rem;
}

.metric-label {
    font-size: .7rem;
    font-weight: 900;
    color: var(--muted);
    letter-spacing: .08em;
    text-transform: uppercase;
    position: relative;
    z-index: 2;
}

.metric-value {
    font-size: 2rem;
    font-weight: 900;
    letter-spacing: -.06em;
    line-height: 1.05;
    margin-top: .35rem;
    position: relative;
    z-index: 2;
}

.metric-sub {
    font-size: .78rem;
    color: var(--muted);
    margin-top: .35rem;
    position: relative;
    z-index: 2;
}

.weight-range-mini {
    margin-top: .85rem;
    padding: .72rem;
    border-radius: 18px;
    background: rgba(248,251,255,.9);
    border: 1px solid rgba(23,107,255,.08);
    position: relative;
    z-index: 2;
}

.weight-range-track {
    height: 8px;
    border-radius: 999px;
    background: #E5EFFF;
    overflow: hidden;
    margin-top: .55rem;
}

.weight-range-fill {
    height: 100%;
    border-radius: 999px;
    background: linear-gradient(135deg, var(--green), #0F7A36);
}


/* ================= MAIN CARDS ================= */
.modern-card {
    background: var(--card);
    border: 1px solid rgba(23,107,255,.1);
    box-shadow: var(--shadow-soft);
    border-radius: 30px;
    overflow: hidden;
    backdrop-filter: blur(18px);
}

.modern-card-header {
    padding: 1.1rem 1.25rem;
    border-bottom: 1px solid rgba(23,107,255,.09);
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: .75rem;
}

.modern-card-header h6 {
    margin: 0;
    font-size: .74rem;
    font-weight: 900;
    letter-spacing: .1em;
    text-transform: uppercase;
    color: #334155;
    display: flex;
    align-items: center;
    gap: .45rem;
}

.modern-card-body {
    padding: 1.25rem;
}

/* ================= QUICK ACTIONS ================= */
.action-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: .75rem;
}

.action-tile {
    display: flex;
    align-items: center;
    gap: .85rem;
    padding: .95rem;
    border-radius: 22px;
    text-decoration: none;
    background: rgba(248,251,255,.85);
    border: 1px solid rgba(23,107,255,.1);
    transition: .2s ease;
}

.action-tile:hover {
    transform: translateY(-3px);
    background: #fff;
    box-shadow: 0 18px 40px rgba(23,107,255,.1);
}

.action-icon {
    width: 46px;
    height: 46px;
    border-radius: 17px;
    display: grid;
    place-items: center;
    flex-shrink: 0;
    font-size: 1.25rem;
}

.action-title {
    color: var(--text);
    font-size: .92rem;
    font-weight: 900;
    margin-bottom: .1rem;
}

.action-sub {
    color: var(--muted);
    font-size: .76rem;
    line-height: 1.35;
}

/* ================= PROFILE ================= */
.profile-list {
    display: grid;
    gap: .75rem;
}

.profile-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: .8rem;
    padding: .85rem;
    border-radius: 18px;
    background: rgba(248,251,255,.82);
    border: 1px solid rgba(23,107,255,.08);
}

.profile-label {
    color: var(--muted);
    font-size: .8rem;
    font-weight: 700;
}

.profile-value {
    color: var(--text);
    font-size: .86rem;
    font-weight: 900;
    text-align: right;
}

.bmi-badge {
    display: inline-flex;
    align-items: center;
    padding: .24rem .62rem;
    border-radius: 999px;
    font-size: .68rem;
    font-weight: 900;
}

.bmi-underweight {
    background: var(--orange-soft);
    color: var(--orange);
}

.bmi-normal {
    background: var(--green-soft);
    color: var(--green);
}

.bmi-overweight {
    background: var(--orange-soft);
    color: var(--orange);
}

.bmi-obese {
    background: var(--red-soft);
    color: var(--red);
}

/* ================= TIP / WEIGHT ================= */
.tip-card {
    background:
        radial-gradient(circle at 90% 20%, rgba(32,199,255,.2), transparent 25%),
        linear-gradient(135deg, #FFFFFF, #F3F8FF);
    border: 1px solid rgba(23,107,255,.1);
    box-shadow: var(--shadow-soft);
    border-radius: 28px;
    padding: 1.25rem;
    min-height: 100%;
}

.tip-icon {
    width: 48px;
    height: 48px;
    display: grid;
    place-items: center;
    border-radius: 18px;
    background: var(--blue-soft);
    color: var(--blue);
    font-size: 1.35rem;
    margin-bottom: .8rem;
}

.section-eyebrow {
    font-size: .7rem;
    font-weight: 900;
    letter-spacing: .1em;
    text-transform: uppercase;
    color: var(--blue);
    margin-bottom: .45rem;
}

.weight-box {
    margin-top: 1rem;
    padding-top: 1rem;
    border-top: 1px dashed rgba(23,107,255,.18);
}

.weight-input-group {
    display: flex;
    gap: .5rem;
    margin-top: .75rem;
}

.weight-input-group input {
    flex: 1;
    border: 1px solid rgba(23,107,255,.18);
    background: #fff;
    border-radius: 15px;
    padding: .7rem .8rem;
    font-size: .9rem;
    font-weight: 800;
    color: var(--text);
    outline: none;
}

.weight-input-group input:focus {
    border-color: var(--blue);
    box-shadow: 0 0 0 4px rgba(23,107,255,.1);
}

.weight-unit {
    display: flex;
    align-items: center;
    padding: .7rem .75rem;
    border-radius: 15px;
    background: var(--blue-soft);
    color: var(--blue-dark);
    font-size: .82rem;
    font-weight: 900;
}

.weight-input-group button {
    border: 0;
    border-radius: 15px;
    padding: .7rem 1rem;
    background: var(--blue);
    color: #fff;
    font-size: .82rem;
    font-weight: 900;
}

/* ================= EMPTY PROFILE ================= */
.empty-profile {
    text-align: center;
    padding: 2rem 1rem;
}

.empty-profile i {
    font-size: 2.7rem;
    color: #CBD5E1;
    display: block;
    margin-bottom: .75rem;
}

/* ================= ANIMATION ================= */
.fade-up {
    animation: fadeUp .45s ease both;
}

.fade-up-2 {
    animation: fadeUp .45s .08s ease both;
}

.fade-up-3 {
    animation: fadeUp .45s .16s ease both;
}

.fade-up-4 {
    animation: fadeUp .45s .24s ease both;
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

@media (max-width: 767px) {
    .dash-hero {
        border-radius: 28px;
    }

    .hero-actions .dash-btn {
        width: 100%;
    }

    .hero-mini-card {
        margin-top: 1rem;
    }

    .metric-value {
        font-size: 1.55rem;
    }

    .weight-input-group {
        flex-wrap: wrap;
    }

    .weight-input-group input {
        min-width: 100%;
    }

    .weight-input-group button {
        flex: 1;
    }
}
</style>
@endpush

@section('content')

@php
$hour       = (int) date('H');
$greeting   = $hour < 12 ? 'Good morning' : ($hour < 17 ? 'Good afternoon' : 'Good evening');
$greetEmoji = $hour < 12 ? '🌤️' : ($hour < 17 ? '☀️' : '🌙');

$profile = auth()->user()->profile ?? null;

/* BMI */
$bmi = null;
$bmiClass = 'bmi-normal';
$bmiLabel = 'Normal';

if ($profile && $profile->height_cm > 0) {
    $hM = $profile->height_cm / 100;
    $bmi = round($profile->weight_kg / ($hM * $hM), 1);

    if ($bmi < 18.5) {
        $bmiClass = 'bmi-underweight';
        $bmiLabel = 'Underweight';
    } elseif ($bmi < 25) {
        $bmiClass = 'bmi-normal';
        $bmiLabel = 'Normal';
    } elseif ($bmi < 30) {
        $bmiClass = 'bmi-overweight';
        $bmiLabel = 'Overweight';
    } else {
        $bmiClass = 'bmi-obese';
        $bmiLabel = 'Obese';
    }
}

/* Main values */
$dcr = $profile ? ($profile->dcr_value ?? 0) : 0;

/* Daily tips */
$tips = [
    "Drinking water before meals can naturally reduce portion sizes and aid digestion.",
    "Protein-rich breakfasts keep you fuller for longer — aim for at least 20g at breakfast.",
    "A 10-minute walk after meals helps regulate blood sugar and supports better digestion.",
    "Aim to fill half your plate with vegetables at every main meal.",
    "Sleep 7–9 hours — poor sleep can increase hunger and cravings the next day.",
    "Chewing slowly gives your brain time to register fullness.",
    "Meal prepping on Sunday can help you avoid unhealthy last-minute choices during busy weekdays.",
];

$todayTip = $tips[date('N') % count($tips)];

/* Goal label clean-up */
$goalRaw = $profile->goal ?? '';
$goalClean = $profile ? ucfirst(str_replace(['_weight', '_'], ['', ' '], $goalRaw)) : '—';

/* Healthy weight range based on BMI 18.5–24.9 */
$idealMinWeight = null;
$idealMaxWeight = null;
$weightStatusMessage = null;
$weightStatusType = 'success';
$weightRangePercent = 0;

if ($profile && $profile->height_cm > 0 && $profile->weight_kg > 0) {
    $heightM = $profile->height_cm / 100;
    $idealMinWeight = round(18.5 * ($heightM * $heightM), 1);
    $idealMaxWeight = round(24.9 * ($heightM * $heightM), 1);

    if ($profile->weight_kg < $idealMinWeight) {
        $gap = round($idealMinWeight - $profile->weight_kg, 1);
        $weightStatusMessage = $gap . ' kg below healthy range';
        $weightStatusType = 'warning';
        $weightRangePercent = 8;
    } elseif ($profile->weight_kg > $idealMaxWeight) {
        $gap = round($profile->weight_kg - $idealMaxWeight, 1);
        $weightStatusMessage = $gap . ' kg above healthy range';
        $weightStatusType = 'warning';
        $weightRangePercent = 100;
    } else {
        $weightStatusMessage = 'Within healthy range';
        $weightStatusType = 'success';
        $rangeWidth = max(1, $idealMaxWeight - $idealMinWeight);
        $weightRangePercent = 8 + min(84, (($profile->weight_kg - $idealMinWeight) / $rangeWidth) * 84);
    }
}

@endphp

<div class="dashboard-wrap">

    {{-- ================= HERO ================= --}}
    <div class="dash-hero fade-up">
        <div class="row align-items-center g-4">
            <div class="col-12 col-lg-8">
                <div class="hero-content">
                    <div class="greeting-pill">
                        {{ $greetEmoji }} {{ $greeting }}
                    </div>

                    <h1>Welcome back, {{ auth()->user()->name }}.</h1>
                    <p>{{ now()->format('l, j F Y') }} · Your personal nutrition space is ready.</p>

                    <div class="hero-actions">
                        <a href="{{ route('meals.recommend') }}" class="dash-btn btn-white">
                            <i class="bi bi-calendar2-check-fill"></i>
                            View Today's Meal Plan
                        </a>

                        <a href="{{ route('food-logger.index') }}" class="dash-btn btn-glass">
                            <i class="bi bi-stars"></i>
                            AI Food Logger
                        </a>

                        @if($profile)
                            <a href="{{ route('meals.weekly') }}" class="dash-btn btn-glass">
                                <i class="bi bi-calendar3-week-fill"></i>
                                Weekly Plan
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            @if($profile)
                <div class="col-12 col-lg-4">
                    <div class="hero-mini-card text-lg-end">
                        <div class="hero-mini-label">Daily Target</div>
                        <div class="hero-dcr">{{ number_format($dcr) }}</div>
                        <div class="hero-unit">kcal per day</div>

                        <div class="mt-3">
                            <span class="bmi-badge {{ $bmiClass }}">
                                BMI {{ $bmi }} · {{ $bmiLabel }}
                            </span>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- ================= NO PROFILE BANNER ================= --}}
    @if(!$profile)
        <div class="no-profile-banner fade-up-2">
            <i class="bi bi-exclamation-triangle-fill fs-4 flex-shrink-0" style="color: var(--orange);"></i>

            <div style="flex:1;">
                <strong style="color:#C2410C;">Complete your health profile to unlock Meal Options.</strong>
                <span class="text-muted ms-1" style="font-size:.88rem;">
                    NutriTrack needs your weight, height, activity level, and goal to calculate your calorie target.
                </span>
            </div>

            <a href="{{ route('profile.index') }}" class="dash-btn btn-orange">
                Set up profile
                <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    @endif

    {{-- ================= METRICS ================= --}}
    <div class="row g-3 mb-4 fade-up-2">
        <div class="col-6 col-xl-3">
            <div class="metric-card">
                <div class="metric-top">
                    <div class="metric-icon" style="background: var(--blue-soft); color: var(--blue);">
                        <i class="bi bi-fire"></i>
                    </div>
                </div>
                <div class="metric-label">Daily Target</div>
                <div class="metric-value">{{ $profile ? number_format($profile->dcr_value) : '—' }}</div>
                <div class="metric-sub">kcal per day</div>
            </div>
        </div>

        <div class="col-6 col-xl-3">
            <div class="metric-card">
                <div class="metric-top">
                    <div class="metric-icon" style="background: var(--green-soft); color: var(--green);">
                        <i class="bi bi-heart-pulse"></i>
                    </div>
                </div>
                <div class="metric-label">BMR</div>
                <div class="metric-value">{{ $profile ? number_format($profile->bmr) : '—' }}</div>
                <div class="metric-sub">base calorie rate</div>
            </div>
        </div>

        <div class="col-6 col-xl-3">
            <div class="metric-card">
                <div class="metric-top">
                    <div class="metric-icon" style="background: var(--orange-soft); color: var(--orange);">
                        <i class="bi bi-lightning-fill"></i>
                    </div>
                </div>
                <div class="metric-label">TDEE</div>
                <div class="metric-value">{{ $profile ? number_format($profile->tdee_value) : '—' }}</div>
                <div class="metric-sub">with activity level</div>
            </div>
        </div>

        <div class="col-6 col-xl-3">
            <div class="metric-card">
                <div class="metric-top">
                    <div class="metric-icon" style="background: var(--purple-soft); color: var(--purple);">
                        <i class="bi bi-bullseye"></i>
                    </div>
                </div>
                <div class="metric-label">Goal</div>
                <div class="metric-value" style="font-size:1.32rem; line-height:1.2;">
                    {{ $profile ? $goalClean . ' Weight' : '—' }}
                </div>
                <div class="metric-sub">{{ $profile ? 'active target' : 'not set' }}</div>
            </div>
        </div>


    </div>

    {{-- ================= MAIN CONTENT ================= --}}
    <div class="row g-4 fade-up-3">

        {{-- QUICK ACTIONS --}}
        <div class="col-12 col-xl-4">
            <div class="modern-card h-100">
                <div class="modern-card-header">
                    <h6>
                        <i class="bi bi-grid-1x2-fill" style="color: var(--blue);"></i>
                        Quick Actions
                    </h6>
                </div>

                <div class="modern-card-body">
                    <div class="action-grid">
                        <a href="{{ route('meals.recommend') }}" class="action-tile">
                            <div class="action-icon" style="background: var(--blue-soft); color: var(--blue);">
                                <i class="bi bi-calendar2-check-fill"></i>
                            </div>
                            <div>
                                <div class="action-title">Today's Meal Plan</div>
                                <div class="action-sub">View your personalized meal recommendation.</div>
                            </div>
                        </a>

                        <a href="{{ route('meals.weekly') }}" class="action-tile">
                            <div class="action-icon" style="background: var(--green-soft); color: var(--green);">
                                <i class="bi bi-calendar3-week-fill"></i>
                            </div>
                            <div>
                                <div class="action-title">Weekly Meal Plan</div>
                                <div class="action-sub">Plan your meals across the week.</div>
                            </div>
                        </a>

                        <a href="{{ route('food-logger.index') }}" class="action-tile">
                            <div class="action-icon" style="background: var(--orange-soft); color: var(--orange);">
                                <i class="bi bi-stars"></i>
                            </div>
                            <div>
                                <div class="action-title">AI Food Logger</div>
                                <div class="action-sub">Estimate calories from food descriptions.</div>
                            </div>
                        </a>
                        <a href="{{ route('nutrition-guide') }}" class="action-tile">
    <div class="action-icon" style="background: var(--blue-soft); color: var(--blue);">
        <i class="bi bi-book-fill"></i>
    </div>
    <div>
        <div class="action-title">Nutrition Guide</div>
        <div class="action-sub">Learn BMI, BMR, TDEE, DCR, and calorie targets.</div>
    </div>
</a>

                        <a href="{{ route('profile.index') }}" class="action-tile">
                            <div class="action-icon" style="background: var(--purple-soft); color: var(--purple);">
                                <i class="bi bi-person-circle"></i>
                            </div>
                            <div>
                                <div class="action-title">Edit My Profile</div>
                                <div class="action-sub">Update goal, allergies, cuisine, or body details.</div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- PROFILE SUMMARY --}}
        <div class="col-12 col-xl-5">
            <div class="modern-card h-100">
                <div class="modern-card-header">
                    <h6>
                        <i class="bi bi-person-fill" style="color: var(--blue);"></i>
                        Profile Summary
                    </h6>

                    <a href="{{ route('profile.index') }}" class="dash-btn btn-soft" style="min-height:36px; padding:.45rem .75rem; font-size:.76rem;">
                        Edit
                    </a>
                </div>

                <div class="modern-card-body">
                    @if($profile)
                        <div class="profile-list">
                            <div class="profile-row">
                                <span class="profile-label">Weight</span>
                                <span class="profile-value">{{ $profile->weight_kg }} kg</span>
                            </div>

                            <div class="profile-row">
                                <span class="profile-label">Height</span>
                                <span class="profile-value">{{ $profile->height_cm }} cm</span>
                            </div>

                            <div class="profile-row">
                                <span class="profile-label">BMI</span>
                                <span class="profile-value">
                                    {{ $bmi }}
                                    <span class="bmi-badge {{ $bmiClass }} ms-1">{{ $bmiLabel }}</span>
                                </span>
                            </div>



                            @if($idealMinWeight && $idealMaxWeight)
                                <div class="profile-row" style="background: linear-gradient(135deg, rgba(234,242,255,.95), rgba(255,255,255,.92));">
                                    <span class="profile-label">Healthy Range</span>
                                    <span class="profile-value">
                                        {{ $idealMinWeight }}–{{ $idealMaxWeight }} kg
                                        <small class="d-block text-muted mt-1" style="font-size:.68rem;font-weight:800;">
                                            {{ $weightStatusMessage }}
                                        </small>
                                    </span>
                                </div>
                            @endif

                            <div class="profile-row">
                                <span class="profile-label">Activity Level</span>
                                <span class="profile-value">{{ ucwords(str_replace('_', ' ', $profile->activity_level)) }}</span>
                            </div>

                            <div class="profile-row">
                                <span class="profile-label">Cuisine Preference</span>
                                <span class="profile-value">{{ $profile->preferred_cuisine ?? '—' }}</span>
                            </div>

                            @if($profile->allergies)
                                <div class="profile-row">
                                    <span class="profile-label">Allergies</span>
                                    <span class="profile-value" style="color: var(--red);">{{ $profile->allergies }}</span>
                                </div>
                            @endif
                        </div>

                        <div class="weight-box">
                            <div class="section-eyebrow">Update Weight</div>

                            <form action="{{ route('profile.weight') }}" method="POST">
                                @csrf
                                <div class="weight-input-group">
                                    <input
                                        type="number"
                                        name="weight_kg"
                                        step="0.1"
                                        min="20"
                                        max="300"
                                        value="{{ $profile->weight_kg }}"
                                        placeholder="kg"
                                    >

                                    <span class="weight-unit">kg</span>

                                    <button type="submit">
                                        Update
                                    </button>
                                </div>
                            </form>
                        </div>
                    @else
                        <div class="empty-profile">
                            <i class="bi bi-person-x"></i>
                            <p class="text-muted mb-3">No health profile has been set up yet.</p>

                            <a href="{{ route('profile.index') }}" class="dash-btn btn-blue">
                                Set up now
                                <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- DAILY TIP --}}
        <div class="col-12 col-xl-3">
            <div class="tip-card">
                <div class="tip-icon">
                    <i class="bi bi-lightbulb-fill"></i>
                </div>

                <div class="section-eyebrow">Daily Tip</div>

                <p style="color: var(--muted); line-height:1.7; font-size:.9rem; margin-bottom:1.1rem;">
                    {{ $todayTip }}
                </p>

                <a href="{{ route('meals.recommend') }}" class="dash-btn btn-blue w-100">
                    Plan my meal
                    <i class="bi bi-arrow-right-circle-fill"></i>
                </a>
            </div>
        </div>

    </div>
</div>
@endsection
