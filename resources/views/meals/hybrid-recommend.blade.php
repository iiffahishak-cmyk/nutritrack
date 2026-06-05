{{-- resources/views/meals/hybrid-recommend.blade.php --}}
@extends('layouts.app')
@section('title', 'Meal Options — NutriTrack')

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
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
    --card: rgba(255,255,255,.86);
    --text: #0F172A;
    --muted: #64748B;
    --line: rgba(23,107,255,.12);
    --shadow: 0 24px 70px rgba(23,107,255,.12);
    --shadow-soft: 0 14px 40px rgba(15,23,42,.07);
}

body {
    font-family: 'Inter', sans-serif;
    background:
        radial-gradient(circle at 10% 10%, rgba(32,199,255,.15), transparent 28%),
        radial-gradient(circle at 90% 6%, rgba(23,107,255,.14), transparent 30%),
        linear-gradient(135deg, #F8FBFF 0%, #EEF5FF 52%, #F9FCFF 100%);
    color: var(--text);
}

.hybrid-page {
    position: relative;
}

.hybrid-page::before {
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

.hero-card {
    position: relative;
    overflow: hidden;
    border-radius: 38px;
    padding: clamp(1.4rem, 3vw, 2.4rem);
    color: white;
    background:
        radial-gradient(circle at 18% 20%, rgba(32,199,255,.38), transparent 28%),
        radial-gradient(circle at 92% 16%, rgba(255,255,255,.16), transparent 24%),
        linear-gradient(135deg, #071B46 0%, #0B3D91 48%, #176BFF 100%);
    box-shadow: var(--shadow);
    margin-bottom: 1.2rem;
}

.hero-card::after {
    content: "";
    position: absolute;
    right: -120px;
    bottom: -130px;
    width: 380px;
    height: 380px;
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
    backdrop-filter: blur(10px);
}

.hero-card h1 {
    font-family: 'Playfair Display', serif;
    font-size: clamp(2rem, 4vw, 3.5rem);
    line-height: 1;
    letter-spacing: -.045em;
    margin-bottom: .6rem;
}

.hero-card p {
    color: rgba(255,255,255,.78);
    margin: 0;
    max-width: 700px;
    line-height: 1.7;
    font-size: .95rem;
}

.hero-actions {
    display: flex;
    flex-wrap: wrap;
    gap: .7rem;
    margin-top: 1.35rem;
}

.nt-btn {
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

.nt-btn:hover {
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

.hero-stat {
    position: relative;
    z-index: 2;
    background: rgba(255,255,255,.14);
    border: 1px solid rgba(255,255,255,.2);
    backdrop-filter: blur(16px);
    border-radius: 28px;
    padding: 1.2rem;
}

.hero-stat-label {
    font-size: .7rem;
    font-weight: 900;
    letter-spacing: .08em;
    text-transform: uppercase;
    color: rgba(255,255,255,.68);
    margin-bottom: .45rem;
}

.hero-stat-value {
    font-size: 2.25rem;
    line-height: 1;
    font-weight: 900;
    letter-spacing: -.06em;
}

.hero-stat-sub {
    color: rgba(255,255,255,.7);
    font-size: .8rem;
    margin-top: .3rem;
}

.guide-grid {
    display: grid;
    grid-template-columns: 1.2fr .8fr;
    gap: 1rem;
    margin-bottom: 1.2rem;
}

.guide-card,
.unlock-card {
    background: var(--card);
    border: 1px solid rgba(23,107,255,.1);
    box-shadow: var(--shadow-soft);
    border-radius: 30px;
    padding: 1.2rem;
    backdrop-filter: blur(18px);
}

.guide-title {
    font-size: .78rem;
    font-weight: 900;
    letter-spacing: .1em;
    text-transform: uppercase;
    color: var(--blue);
    margin-bottom: .8rem;
}

.step-list {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: .7rem;
}

.step-item {
    border-radius: 22px;
    padding: .9rem;
    background: #F8FBFF;
    border: 1px solid rgba(23,107,255,.08);
}

.step-num {
    width: 30px;
    height: 30px;
    border-radius: 12px;
    display: grid;
    place-items: center;
    background: var(--blue-soft);
    color: var(--blue);
    font-weight: 900;
    font-size: .78rem;
    margin-bottom: .55rem;
}

.step-item strong {
    display: block;
    color: var(--text);
    font-size: .84rem;
    font-weight: 900;
    margin-bottom: .25rem;
}

.step-item span {
    display: block;
    color: var(--muted);
    font-size: .74rem;
    line-height: 1.45;
}

.unlock-top {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: .75rem;
    margin-bottom: .8rem;
}

.unlock-icon {
    width: 48px;
    height: 48px;
    border-radius: 18px;
    display: grid;
    place-items: center;
    background: var(--blue-soft);
    color: var(--blue);
    font-size: 1.35rem;
}

.unlock-percent {
    font-size: 1.6rem;
    font-weight: 900;
    color: var(--blue);
    letter-spacing: -.05em;
}

.unlock-card h6 {
    font-weight: 900;
    margin-bottom: .35rem;
}

.unlock-card p {
    color: var(--muted);
    font-size: .84rem;
    line-height: 1.6;
    margin-bottom: .8rem;
}

.progress-track {
    height: 9px;
    border-radius: 999px;
    background: #E5EFFF;
    overflow: hidden;
}

.progress-fill {
    height: 100%;
    border-radius: 999px;
    background: linear-gradient(90deg, var(--blue), var(--cyan));
    transition: .4s ease;
}

.slot-section {
    margin-bottom: 1.4rem;
}

.slot-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: .8rem;
    margin-bottom: .8rem;
    flex-wrap: wrap;
}

.slot-title {
    display: flex;
    align-items: center;
    gap: .65rem;
}

.slot-icon {
    width: 46px;
    height: 46px;
    border-radius: 18px;
    display: grid;
    place-items: center;
    font-size: 1.35rem;
}

.slot-name {
    margin: 0;
    color: var(--text);
    font-weight: 900;
    letter-spacing: -.03em;
}

.slot-budget {
    color: var(--muted);
    font-size: .82rem;
    margin-top: .08rem;
}

.slot-tools {
    display: flex;
    align-items: center;
    gap: .55rem;
}

.slot-refresh {
    border: 0;
    border-radius: 999px;
    background: var(--blue-soft);
    color: var(--blue);
    padding: .52rem .85rem;
    font-size: .78rem;
    font-weight: 900;
    transition: .18s ease;
}

.slot-refresh:hover {
    transform: translateY(-2px);
    background: #DCEBFF;
}

.meal-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
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
    height: 100%;
    display: flex;
    flex-direction: column;
}

.meal-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 24px 65px rgba(23,107,255,.13);
}

.meal-cover {
    min-height: 96px;
    padding: 1rem;
    color: white;
    position: relative;
    overflow: hidden;
}

.meal-cover::after {
    content: "";
    position: absolute;
    right: -55px;
    top: -55px;
    width: 140px;
    height: 140px;
    border-radius: 50%;
    background: rgba(255,255,255,.16);
}

.cover-breakfast {
    background: linear-gradient(135deg, #F97316, #EA580C);
}

.cover-lunch {
    background: linear-gradient(135deg, #16A34A, #0F7A36);
}

.cover-dinner {
    background: linear-gradient(135deg, #176BFF, #0B3D91);
}

.cover-snack {
    background: linear-gradient(135deg, #7C3AED, #5B21B6);
}

.meal-cuisine {
    position: relative;
    z-index: 2;
    display: inline-flex;
    align-items: center;
    gap: .35rem;
    padding: .25rem .55rem;
    border-radius: 999px;
    background: rgba(255,255,255,.18);
    font-size: .68rem;
    font-weight: 900;
}

.meal-name {
    position: relative;
    z-index: 2;
    margin-top: 1rem;
    font-size: 1.1rem;
    line-height: 1.18;
    font-weight: 900;
    letter-spacing: -.03em;
}

.meal-body {
    padding: 1rem;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.match-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: .6rem;
    margin-bottom: .7rem;
}

.match-badge {
    display: inline-flex;
    align-items: center;
    gap: .35rem;
    padding: .32rem .6rem;
    border-radius: 999px;
    font-size: .7rem;
    font-weight: 900;
}

.match-high {
    background: var(--green-soft);
    color: var(--green);
}

.match-medium {
    background: var(--blue-soft);
    color: var(--blue);
}

.match-low {
    background: #F1F5F9;
    color: #64748B;
}

.meal-reason {
    color: var(--muted);
    font-size: .82rem;
    line-height: 1.55;
    margin-bottom: .85rem;
}

.macro-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: .45rem;
    margin-top: auto;
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
    border-top: 1px solid rgba(23,107,255,.08);
    padding: .9rem 1rem;
    background: rgba(248,251,255,.7);
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: .7rem;
    flex-wrap: wrap;
}

.star-wrap {
    display: flex;
    align-items: center;
    gap: .35rem;
}

.star-label {
    font-size: .7rem;
    color: var(--muted);
    font-weight: 800;
}

.star-group {
    display: flex;
    gap: 1px;
}

.star-btn {
    background: none;
    border: none;
    cursor: pointer;
    font-size: 1.05rem;
    color: #CBD5E1;
    padding: 1px 2px;
    line-height: 1;
    transition: .1s ease;
}

.star-btn:hover,
.star-btn.is-active {
    color: #F9A825;
    transform: scale(1.15);
}

.save-btn {
    border: 0;
    border-radius: 999px;
    background: white;
    color: var(--blue);
    border: 1px solid rgba(23,107,255,.18);
    padding: .45rem .75rem;
    font-size: .76rem;
    font-weight: 900;
    transition: .18s ease;
}

.save-btn:hover {
    background: var(--blue-soft);
    transform: translateY(-2px);
}

.empty-slot {
    background: rgba(255,255,255,.84);
    border: 1px dashed rgba(23,107,255,.25);
    border-radius: 28px;
    padding: 2rem;
    text-align: center;
    color: var(--muted);
}

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

.toast-msg.ok {
    background: var(--green);
}

.toast-msg.err {
    background: var(--red);
}

@keyframes slideIn {
    from { opacity: 0; transform: translateX(16px); }
    to { opacity: 1; transform: translateX(0); }
}

@media (max-width: 1200px) {
    .meal-grid {
        grid-template-columns: repeat(2, 1fr);
    }

    .step-list {
        grid-template-columns: repeat(2, 1fr);
    }

    .guide-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 768px) {
    .hero-card {
        border-radius: 28px;
    }

    .hero-actions .nt-btn {
        width: 100%;
    }

    .meal-grid {
        grid-template-columns: 1fr;
    }

    .step-list {
        grid-template-columns: 1fr;
    }

    .meal-footer {
        align-items: flex-start;
        flex-direction: column;
    }

    .save-btn {
        width: 100%;
    }
}
</style>
@endpush

@php
    $CF_THRESHOLD = 5;
    $ratingCount = $ratingCount ?? 0;
    $dcr = $dcr ?? 0;
    $isCF = $ratingCount >= $CF_THRESHOLD;
    $remaining = max(0, $CF_THRESHOLD - $ratingCount);
    $progressPct = min(100, round(($ratingCount / $CF_THRESHOLD) * 100));
    $recommendations = $recommendations ?? [];

    $slotIcons = [
        'Breakfast' => '🌅',
        'Lunch' => '☀️',
        'Dinner' => '🌙',
        'Snack' => '🍎',
    ];

    $slotClass = [
        'Breakfast' => 'breakfast',
        'Lunch' => 'lunch',
        'Dinner' => 'dinner',
        'Snack' => 'snack',
    ];

    $validCuisines = ['Malay', 'Chinese', 'Indian', 'Western', 'Middle Eastern'];

    $goalRaw = $profile->goal ?? 'health';
    $goalClean = ucwords(str_replace(['_weight', '_'], ['', ' '], $goalRaw));
@endphp

@section('content')
<div id="toast-box"></div>

<div class="hybrid-page">

    <div class="hero-card">
        <div class="row align-items-center g-4">
            <div class="col-12 col-lg-8">
                <div class="hero-content">
                    <div class="hero-kicker">
                        <i class="bi bi-card-checklist"></i>
                        Meal Options
                    </div>

                    <h1>Choose your meal options easily.</h1>

                    <p>
                        Meal Options gives you several suitable choices for each meal time. You can choose, rate,
                        refresh, and save meals based on your calorie target, allergies, and cuisine preference.
                    </p>

                    <div class="hero-actions">
                        <a href="{{ route('meals.hybrid-recommend', ['refresh' => now()->timestamp]) }}" class="nt-btn btn-white">
                            <i class="bi bi-shuffle"></i>
                            Get New Meal Options
                        </a>

                        <a href="{{ route('diary.index') }}" class="nt-btn btn-glass">
                            <i class="bi bi-journal-check"></i>
                            View My Meal Log
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-4">
                <div class="hero-stat text-lg-end">
                    <div class="hero-stat-label">Daily Target</div>
                    <div class="hero-stat-value">{{ number_format($dcr) }}</div>
                    <div class="hero-stat-sub">
                        kcal/day · {{ $goalClean }} goal
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="guide-grid">
        <div class="guide-card">
            <div class="guide-title">
                <i class="bi bi-info-circle-fill me-1"></i>
                How to use this page
            </div>

            <div class="step-list">
                <div class="step-item">
                    <div class="step-num">1</div>
                    <strong>Check options</strong>
                    <span>Each section shows meals for one meal time.</span>
                </div>

                <div class="step-item">
                    <div class="step-num">2</div>
                    <strong>Save meals</strong>
                    <span>Click Add to Meal Log for meals you want to keep.</span>
                </div>

                <div class="step-item">
                    <div class="step-num">3</div>
                    <strong>Rate meals</strong>
                    <span>Ratings help NutriTrack learn your taste.</span>
                </div>

                <div class="step-item">
                    <div class="step-num">4</div>
                    <strong>Refresh slot</strong>
                    <span>Refresh only breakfast, lunch, dinner, or snack.</span>
                </div>
            </div>
        </div>

        <div class="unlock-card">
            <div class="unlock-top">
                <div class="unlock-icon">
                    <i class="bi {{ $isCF ? 'bi-people-fill' : 'bi-person-check-fill' }}"></i>
                </div>

                <div class="unlock-percent">{{ $progressPct }}%</div>
            </div>

            @if($isCF)
                <h6>Rating-supported mode active</h6>
                <p>
                    Your meal ratings are now used together with profile-based matching to improve your Meal Options.
                </p>
            @else
                <h6>Profile-based mode active</h6>
                <p>
                    Rate <strong>{{ $remaining }}</strong> more meal{{ $remaining !== 1 ? 's' : '' }}
                    to unlock rating-supported Meal Options improvement.
                </p>
            @endif

            <div class="progress-track">
                <div class="progress-fill" id="cf-progress-fill" style="width: {{ $progressPct }}%;"></div>
            </div>
        </div>
    </div>

    @forelse($recommendations as $slot => $result)
        @php
            $slotMeals = $result['meals'] ?? collect();
            $budget = $result['slot_budget'] ?? 0;
            $method = $result['method'] ?? 'profile-based';
            $slotSuffix = $slotClass[$slot] ?? 'breakfast';
            $slotIcon = $slotIcons[$slot] ?? '🍽️';
        @endphp

        <section class="slot-section" id="slot-{{ strtolower($slot) }}">
            <div class="slot-header">
                <div class="slot-title">
                    <div class="slot-icon" style="background: var(--{{ $slotSuffix === 'breakfast' ? 'orange' : ($slotSuffix === 'lunch' ? 'green' : ($slotSuffix === 'dinner' ? 'blue' : 'purple')) }}-soft);">
                        {{ $slotIcon }}
                    </div>

                    <div>
                        <h4 class="slot-name">{{ $slot }}</h4>
                        <div class="slot-budget">
                            {{ number_format($budget) }} kcal target · {{ $method === 'rating-supported' ? 'Rating-supported matching' : 'Profile-based matching' }}
                        </div>
                    </div>
                </div>

                <div class="slot-tools">
                    <button type="button"
                            class="slot-refresh"
                            id="refresh-{{ strtolower($slot) }}"
                            onclick="refreshSlot('{{ $slot }}')">
                        <i class="bi bi-arrow-clockwise"></i>
                        Refresh {{ $slot }}
                    </button>
                </div>
            </div>

            <div class="meal-grid" id="meals-{{ strtolower($slot) }}">
                @forelse($slotMeals as $meal)
                    @php
                        $mealId = $meal->meal_id ?? 0;
                        $mealName = $meal->meal_name ?? 'Unnamed Meal';
                        $calories = $meal->calories ?? 0;
                        $protein = $meal->protein ?? 0;
                        $carbs = $meal->carbs ?? 0;
                        $fat = $meal->fat ?? 0;
                        $cuisine = $meal->cuisine_type ?? null;
                        $cuisineDisplay = in_array($cuisine, $validCuisines) ? $cuisine : ($cuisine ?: 'Mixed');
                        $score = $meal->recommendation_score ?? 0;
                        $reason = $meal->recommendation_reason ?? 'Recommended as a suitable option for this meal time.';
                        $matchPct = min(100, (int) round(($score / 85) * 100));
                        $matchClass = $matchPct >= 70 ? 'match-high' : ($matchPct >= 40 ? 'match-medium' : 'match-low');
                        $matchLabel = $matchPct >= 70 ? 'Best fit' : ($matchPct >= 40 ? 'Good fit' : 'Fair fit');

                        try {
                            $existingRating = $mealId
                                ? (\App\Models\MealRating::where('user_id', auth()->id())->where('meal_id', $mealId)->value('rating') ?? 0)
                                : 0;
                        } catch (\Exception $e) {
                            $existingRating = 0;
                        }
                    @endphp

                    <article class="meal-card" data-meal-id="{{ $mealId }}">
                        <div class="meal-cover cover-{{ $slotSuffix }}">
                            <div class="meal-cuisine">
                                <i class="bi bi-geo-alt-fill"></i>
                                {{ $cuisineDisplay }}
                            </div>

                            <div class="meal-name">{{ $mealName }}</div>
                        </div>

                        <div class="meal-body">
                            <div class="match-row">
                                <span class="match-badge {{ $matchClass }}">
                                    <i class="bi bi-check-circle-fill"></i>
                                    {{ $matchLabel }}
                                </span>

                                <span style="font-size:.72rem;color:var(--muted);font-weight:800;">
                                    {{ $matchPct }}% match
                                </span>
                            </div>

                            <div class="meal-reason">
                                <i class="bi bi-lightbulb-fill" style="color:#F9A825;"></i>
                                {{ $reason }}
                            </div>

                            <div class="macro-grid">
                                <div class="macro-box">
                                    <div class="macro-value" style="color:var(--blue);">{{ number_format($calories) }}</div>
                                    <div class="macro-label">kcal</div>
                                </div>

                                <div class="macro-box">
                                    <div class="macro-value" style="color:var(--purple);">{{ number_format($protein, 1) }}g</div>
                                    <div class="macro-label">Protein</div>
                                </div>

                                <div class="macro-box">
                                    <div class="macro-value" style="color:var(--orange);">{{ number_format($carbs, 1) }}g</div>
                                    <div class="macro-label">Carbs</div>
                                </div>

                                <div class="macro-box">
                                    <div class="macro-value" style="color:#9333EA;">{{ number_format($fat, 1) }}g</div>
                                    <div class="macro-label">Fat</div>
                                </div>
                            </div>
                        </div>

                        <div class="meal-footer">
                            <div class="star-wrap">
                                <span class="star-label">Rate</span>

                                <div class="star-group" data-meal-id="{{ $mealId }}">
                                    @for($s = 1; $s <= 5; $s++)
                                        <button type="button"
                                                class="star-btn {{ $existingRating >= $s ? 'is-active' : '' }}"
                                                data-star="{{ $s }}"
                                                onclick="submitRating({{ $mealId }}, {{ $s }}, this)">
                                            ★
                                        </button>
                                    @endfor
                                </div>
                            </div>

                            <button type="button"
                                    class="save-btn"
                                    id="save-btn-{{ $mealId }}"
                                    onclick="saveMeal({{ $mealId }}, '{{ $slot }}', this)">
                                <i class="bi bi-plus-circle"></i>
                                Add to Meal Log
                            </button>
                        </div>
                    </article>
                @empty
                    <div class="empty-slot">
                        <i class="bi bi-search fs-3 d-block mb-2"></i>
                        <strong>No meals matched for {{ $slot }}.</strong>
                        <p class="mb-0 mt-1">Try adding more meals to the database for this meal time.</p>
                    </div>
                @endforelse
            </div>
        </section>
    @empty
        <div class="empty-slot">
            <i class="bi bi-cpu fs-2 d-block mb-2"></i>
            <strong>No Meal Options generated yet.</strong>
            <p class="mb-3 mt-1">Complete your health profile, then refresh this page.</p>

            <a href="{{ route('meals.hybrid-recommend', ['refresh' => now()->timestamp]) }}" class="nt-btn btn-white" style="background:linear-gradient(135deg,var(--blue),var(--blue-dark));color:white;">
                <i class="bi bi-arrow-clockwise"></i>
                Try Again
            </a>
        </div>
    @endforelse

</div>
@endsection

@push('scripts')
<script>
const CSRF = document.querySelector('meta[name="csrf-token"]')?.content ?? '';

function showToast(msg, type = 'ok') {
    const box = document.getElementById('toast-box');
    if (!box) return;

    const toast = document.createElement('div');
    toast.className = `toast-msg ${type}`;
    toast.textContent = msg;

    box.appendChild(toast);

    setTimeout(() => toast.remove(), 3500);
}

async function saveMeal(mealId, slot, btn) {
    if (!mealId) {
        showToast('Invalid meal.', 'err');
        return;
    }

    const original = btn.innerHTML;

    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm" style="width:12px;height:12px;border-width:2px;"></span>';

    try {
        const res = await fetch('/meals/save', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF,
                'Accept': 'application/json',
            },
            body: JSON.stringify({
                meal_id: mealId,
                meal_time: slot
            }),
        });

        if (!res.ok) {
            btn.disabled = false;
            btn.innerHTML = original;
            showToast(`Save failed (${res.status}).`, 'err');
            return;
        }

        const data = await res.json();

        if (data.success) {
            btn.innerHTML = '<i class="bi bi-check-circle-fill"></i> Added';
            btn.style.background = 'var(--green-soft)';
            btn.style.color = 'var(--green)';
            btn.style.borderColor = 'rgba(22,163,74,.25)';
            showToast(data.message ?? 'Meal added to Meal Log.');
        } else {
            btn.disabled = false;
            btn.innerHTML = original;
            showToast(data.message ?? 'Could not save meal.', 'err');
        }
    } catch (e) {
        btn.disabled = false;
        btn.innerHTML = original;
        showToast('Network error while saving meal.', 'err');
    }
}

function attachStarHover(container = document) {
    container.querySelectorAll('.star-group').forEach(group => {
        const stars = [...group.querySelectorAll('.star-btn')];

        stars.forEach((btn, index) => {
            btn.addEventListener('mouseenter', () => {
                stars.forEach((star, i) => {
                    star.style.color = i <= index ? '#F9A825' : '#CBD5E1';
                });
            });

            btn.addEventListener('mouseleave', () => {
                stars.forEach(star => {
                    star.style.color = star.classList.contains('is-active') ? '#F9A825' : '#CBD5E1';
                });
            });
        });
    });
}

attachStarHover(document);

async function submitRating(mealId, stars, clickedBtn) {
    if (!mealId) {
        showToast('Invalid meal.', 'err');
        return;
    }

    const group = clickedBtn.closest('.star-group');

    group.querySelectorAll('.star-btn').forEach((btn, index) => {
        btn.classList.toggle('is-active', index < stars);
        btn.style.color = index < stars ? '#F9A825' : '#CBD5E1';
    });

    try {
        const res = await fetch('/meals/rate', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                meal_id: mealId,
                rating: stars
            }),
        });

        if (!res.ok) {
            showToast(`Rating failed (${res.status}).`, 'err');
            return;
        }

        const data = await res.json();

        if (data.success) {
            const fill = document.getElementById('cf-progress-fill');

            if (fill && data.rating_count !== undefined) {
                fill.style.width = Math.min(100, Math.round((data.rating_count / 5) * 100)) + '%';
            }

            showToast(data.message ?? `Rated ${stars} star${stars !== 1 ? 's' : ''}.`);

            if (data.cf_unlocked) {
                showToast('Rating-supported mode unlocked. Refreshing...');
                setTimeout(() => location.reload(), 1500);
            }
        } else {
            showToast(data.message ?? 'Could not save rating.', 'err');
        }
    } catch (e) {
        showToast('Network error while saving rating.', 'err');
    }
}

function refreshSlot(slot) {
    const btn = document.getElementById(`refresh-${slot.toLowerCase()}`);
    const grid = document.getElementById(`meals-${slot.toLowerCase()}`);

    if (!btn || !grid) {
        showToast('Refresh target not found.', 'err');
        return;
    }

    const currentIds = [...grid.querySelectorAll('.meal-card')]
        .map(card => card.dataset.mealId)
        .filter(Boolean)
        .join(',');

    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm" style="width:12px;height:12px;border-width:2px;"></span> Refreshing...';

    const url = new URL("{{ route('meals.hybrid-recommend') }}", window.location.origin);
    url.searchParams.set('refresh_slot', slot);
    url.searchParams.set('exclude_ids', currentIds);
    url.searchParams.set('t', Date.now());

    window.location.href = url.toString();
}
</script>
@endpush
