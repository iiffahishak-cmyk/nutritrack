{{-- resources/views/meals/hybrid-recommend.blade.php --}}
@extends('layouts.app')
@section('title', 'Meal Options - NutriTrack')

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

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
    --text: #0F172A;
    --muted: #64748B;
    --line: rgba(15,23,42,.08);
    --surface: rgba(255,255,255,.82);
    --surface-strong: rgba(255,255,255,.94);
    --shadow: 0 14px 36px rgba(15,23,42,.07);
    --shadow-hover: 0 20px 48px rgba(23,107,255,.12);
}

body {
    font-family: 'Inter', sans-serif;
    background:
        radial-gradient(circle at 8% 8%, rgba(23,107,255,.08), transparent 27%),
        radial-gradient(circle at 92% 4%, rgba(32,199,255,.10), transparent 25%),
        linear-gradient(135deg, #F8FBFF 0%, #EEF5FF 100%);
    color: var(--text);
}

.meal-options-page {
    padding: 1.15rem 0 2.5rem;
}

.page-top {
    margin-bottom: .9rem;
}

.page-top-row {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    gap: 1rem;
    flex-wrap: wrap;
    padding-bottom: 1rem;
    border-bottom: 1px solid rgba(15,23,42,.08);
}

.page-kicker {
    display: inline-flex;
    align-items: center;
    gap: .45rem;
    color: var(--blue);
    font-size: .72rem;
    font-weight: 900;
    letter-spacing: .08em;
    text-transform: uppercase;
    margin-bottom: .45rem;
}

.page-title {
    margin: 0;
    font-size: clamp(2rem, 3vw, 2.75rem);
    line-height: 1.04;
    font-weight: 900;
    letter-spacing: -.055em;
}

.page-subtitle {
    margin: .42rem 0 0;
    color: var(--muted);
    max-width: 620px;
    font-size: .92rem;
    line-height: 1.55;
}

.header-actions {
    display: flex;
    align-items: center;
    gap: .6rem;
    flex-wrap: wrap;
}

.action-btn {
    min-height: 40px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: .45rem;
    padding: .62rem .95rem;
    border-radius: 999px;
    font-size: .8rem;
    font-weight: 900;
    text-decoration: none;
    border: 1px solid transparent;
    transition: .18s ease;
    white-space: nowrap;
}

.action-btn:hover {
    transform: translateY(-2px);
}

.action-btn.primary {
    background: var(--blue);
    color: #fff;
    box-shadow: 0 12px 24px rgba(23,107,255,.20);
}

.action-btn.primary:hover {
    background: var(--blue-dark);
    color: #fff;
}

.action-btn.secondary {
    background: rgba(255,255,255,.8);
    color: var(--blue);
    border-color: rgba(23,107,255,.16);
}

.action-btn.secondary:hover {
    background: var(--blue-soft);
    color: var(--blue);
}

.quick-panel {
    display: grid;
    grid-template-columns: minmax(0, 1fr) minmax(280px, .34fr);
    gap: .75rem;
    align-items: start;
    margin-bottom: 1.2rem;
}

.status-ribbon {
    display: flex;
    align-items: center;
    gap: .72rem;
    flex-wrap: wrap;
    min-height: 54px;
    background: var(--surface);
    border: 1px solid rgba(15,23,42,.07);
    border-radius: 20px;
    padding: .68rem .85rem;
    box-shadow: var(--shadow);
    backdrop-filter: blur(14px);
}

.ribbon-item {
    display: flex;
    align-items: baseline;
    gap: .38rem;
    white-space: nowrap;
}

.ribbon-item span {
    color: var(--muted);
    font-size: .71rem;
    font-weight: 800;
}

.ribbon-item strong {
    color: var(--text);
    font-size: .8rem;
    font-weight: 900;
}

.ribbon-dot {
    width: 5px;
    height: 5px;
    border-radius: 50%;
    background: rgba(15,23,42,.18);
}

.guide-card {
    background: var(--surface);
    border: 1px solid rgba(15,23,42,.07);
    border-radius: 20px;
    box-shadow: var(--shadow);
    backdrop-filter: blur(14px);
    overflow: hidden;
}

.guide-summary {
    min-height: 54px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: .7rem;
    padding: .68rem .85rem;
    cursor: pointer;
    list-style: none;
}

.guide-summary::-webkit-details-marker {
    display: none;
}

.guide-summary-main {
    min-width: 0;
    display: flex;
    align-items: center;
    gap: .5rem;
    color: var(--blue);
}

.guide-summary-main strong {
    color: var(--text);
    font-size: .82rem;
    font-weight: 900;
    white-space: nowrap;
}

.guide-summary-main span {
    color: var(--muted);
    font-size: .72rem;
    font-weight: 700;
    white-space: nowrap;
}

.guide-chevron {
    width: 32px;
    height: 32px;
    border-radius: 12px;
    display: grid;
    place-items: center;
    color: var(--blue);
    background: var(--blue-soft);
    transition: .18s ease;
    flex: 0 0 auto;
}

details[open] .guide-chevron {
    transform: rotate(180deg);
}

.guide-content {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: .55rem;
    padding: 0 .85rem .85rem;
}

.guide-step {
    border-radius: 14px;
    padding: .72rem;
    background: #F8FBFF;
    border: 1px solid rgba(15,23,42,.06);
}

.guide-step strong {
    display: block;
    color: var(--text);
    font-size: .78rem;
    font-weight: 900;
    margin-bottom: .18rem;
}

.guide-step span {
    display: block;
    color: var(--muted);
    font-size: .7rem;
    line-height: 1.4;
}

.slot-section {
    margin-bottom: 1.55rem;
}

.slot-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: .85rem;
    flex-wrap: wrap;
    margin-bottom: .72rem;
}

.slot-title {
    display: flex;
    align-items: center;
    gap: .65rem;
}

.slot-icon {
    width: 40px;
    height: 40px;
    border-radius: 15px;
    display: grid;
    place-items: center;
    font-size: 1.05rem;
    color: var(--slot-color);
    background: var(--slot-soft);
}

.slot-name {
    margin: 0;
    color: var(--text);
    font-size: 1.08rem;
    font-weight: 900;
    letter-spacing: -.03em;
}

.slot-budget {
    color: var(--muted);
    font-size: .78rem;
    font-weight: 700;
    margin-top: .05rem;
}

.slot-refresh {
    min-height: 38px;
    border: 0;
    border-radius: 999px;
    background: rgba(255,255,255,.86);
    color: var(--blue);
    border: 1px solid rgba(23,107,255,.14);
    padding: .48rem .82rem;
    font-size: .76rem;
    font-weight: 900;
    box-shadow: 0 8px 18px rgba(15,23,42,.04);
    transition: .18s ease;
}

.slot-refresh:hover {
    background: var(--blue-soft);
    transform: translateY(-2px);
}

.meal-list {
    display: flex;
    flex-direction: column;
    gap: .68rem;
}

.meal-card {
    position: relative;
    display: grid;
    grid-template-columns: minmax(0, 1fr) minmax(260px, auto) minmax(245px, auto);
    gap: 1rem;
    align-items: center;
    background: var(--surface-strong);
    border: 1px solid rgba(15,23,42,.07);
    border-radius: 20px;
    padding: .9rem 1rem .9rem 1.1rem;
    box-shadow: var(--shadow);
    backdrop-filter: blur(14px);
    transition: .18s ease;
    overflow: hidden;
}

.meal-card::before {
    content: "";
    position: absolute;
    left: 0;
    top: 12px;
    bottom: 12px;
    width: 5px;
    border-radius: 999px;
    background: var(--slot-color);
}

.meal-card:hover {
    transform: translateY(-3px);
    box-shadow: var(--shadow-hover);
}

.meal-main {
    min-width: 0;
    padding-left: .12rem;
}

.meal-meta {
    display: flex;
    align-items: center;
    gap: .45rem;
    flex-wrap: wrap;
    margin-bottom: .38rem;
}

.cuisine-pill,
.match-badge,
.match-percent {
    display: inline-flex;
    align-items: center;
    gap: .32rem;
    padding: .25rem .55rem;
    border-radius: 999px;
    font-size: .67rem;
    font-weight: 900;
}

.cuisine-pill {
    background: #F8FBFF;
    color: var(--muted);
    border: 1px solid rgba(15,23,42,.07);
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

.match-percent {
    background: rgba(15,23,42,.04);
    color: var(--muted);
}

.meal-name {
    margin: 0;
    color: var(--text);
    font-size: 1rem;
    font-weight: 900;
    line-height: 1.25;
    letter-spacing: -.025em;
}

.meal-reason {
    color: var(--muted);
    font-size: .76rem;
    line-height: 1.42;
    margin-top: .34rem;
    max-width: 720px;
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.macro-strip {
    display: grid;
    grid-template-columns: repeat(4, 62px);
    gap: .4rem;
}

.macro-mini {
    text-align: center;
    border-radius: 14px;
    background: #F8FBFF;
    border: 1px solid rgba(15,23,42,.06);
    padding: .5rem .3rem;
}

.macro-value {
    font-size: .76rem;
    font-weight: 900;
    line-height: 1;
}

.macro-label {
    font-size: .53rem;
    color: var(--muted);
    font-weight: 800;
    text-transform: uppercase;
    margin-top: .22rem;
}

.meal-actions {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: .65rem;
}

.star-wrap {
    display: flex;
    align-items: center;
    gap: .35rem;
}

.star-label {
    font-size: .68rem;
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
    font-size: 1rem;
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
    min-height: 38px;
    border: 0;
    border-radius: 999px;
    background: var(--blue);
    color: white;
    padding: .5rem .78rem;
    font-size: .74rem;
    font-weight: 900;
    transition: .18s ease;
    white-space: nowrap;
}

.save-btn:hover {
    background: var(--blue-dark);
    transform: translateY(-2px);
}

.empty-slot {
    background: var(--surface-strong);
    border: 1px dashed rgba(23,107,255,.22);
    border-radius: 20px;
    padding: 1.45rem;
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
    .quick-panel {
        grid-template-columns: 1fr;
    }

    .guide-content {
        grid-template-columns: repeat(2, 1fr);
    }

    .meal-card {
        grid-template-columns: minmax(0, 1fr);
        align-items: stretch;
    }

    .macro-strip {
        grid-template-columns: repeat(4, 1fr);
    }

    .meal-actions {
        justify-content: space-between;
        border-top: 1px solid rgba(15,23,42,.06);
        padding-top: .7rem;
    }
}

@media (max-width: 768px) {
    .page-top-row {
        align-items: flex-start;
    }

    .header-actions {
        width: 100%;
    }

    .action-btn {
        width: 100%;
    }

    .status-ribbon {
        border-radius: 18px;
        align-items: flex-start;
        flex-direction: column;
        gap: .45rem;
    }

    .ribbon-dot {
        display: none;
    }

    .guide-summary-main {
        align-items: flex-start;
        flex-direction: column;
        gap: .15rem;
    }

    .guide-summary-main span {
        white-space: normal;
    }

    .guide-content {
        grid-template-columns: 1fr;
    }

    .slot-header {
        align-items: flex-start;
    }

    .slot-refresh {
        width: 100%;
    }

    .macro-strip {
        grid-template-columns: repeat(2, 1fr);
    }

    .meal-actions {
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
        'Breakfast' => 'bi-sunrise-fill',
        'Lunch' => 'bi-brightness-high-fill',
        'Dinner' => 'bi-moon-stars-fill',
        'Snack' => 'bi-cup-hot-fill',
    ];

    $slotColors = [
        'Breakfast' => '#F97316',
        'Lunch' => '#16A34A',
        'Dinner' => '#176BFF',
        'Snack' => '#7C3AED',
    ];

    $slotSofts = [
        'Breakfast' => '#FFF4E8',
        'Lunch' => '#EAFBF1',
        'Dinner' => '#EAF2FF',
        'Snack' => '#F3E8FF',
    ];

    $validCuisines = ['Malay', 'Chinese', 'Indian', 'Western', 'Middle Eastern'];

    $goalRaw = $profile->goal ?? 'health';
    $goalClean = ucwords(str_replace(['_weight', '_'], ['', ' '], $goalRaw));
@endphp

@section('content')
<div id="toast-box"></div>

<div class="meal-options-page">

    <div class="page-top">
        <div class="page-top-row">
            <div>
                <div class="page-kicker">
                    <i class="bi bi-card-checklist"></i>
                    Meal Options
                </div>

                <h1 class="page-title">Choose meals for today.</h1>

                <p class="page-subtitle">
                    Review matched meals, save what you want, and rate options to improve future suggestions.
                </p>
            </div>

            <div class="header-actions">
                <a href="{{ route('meals.hybrid-recommend', ['refresh' => now()->timestamp]) }}" class="action-btn primary">
                    <i class="bi bi-shuffle"></i>
                    Refresh Options
                </a>

                <a href="{{ route('diary.index') }}" class="action-btn secondary">
                    <i class="bi bi-journal-check"></i>
                    View Meal Log
                </a>
            </div>
        </div>
    </div>

    <div class="quick-panel">
        <div class="status-ribbon">
            <div class="ribbon-item">
                <span>Daily Target</span>
                <strong>{{ number_format($dcr) }} kcal</strong>
            </div>

            <div class="ribbon-dot"></div>

            <div class="ribbon-item">
                <span>Goal</span>
                <strong>{{ $goalClean }}</strong>
            </div>

            <div class="ribbon-dot"></div>

            <div class="ribbon-item">
                <span>Mode</span>
                <strong>{{ $isCF ? 'Personalized' : 'Profile-based' }}</strong>
            </div>

            <div class="ribbon-dot"></div>

            <div class="ribbon-item">
                <span>Ratings</span>
                <strong id="rating-progress-percent">{{ $progressPct }}%</strong>
            </div>
        </div>

        <details class="guide-card">
            <summary class="guide-summary">
                <div class="guide-summary-main">
                    <i class="bi bi-info-circle-fill"></i>
                    <strong>How this works</strong>
                    <span>Open quick guide</span>
                </div>

                <div class="guide-chevron">
                    <i class="bi bi-chevron-down"></i>
                </div>
            </summary>

            <div class="guide-content">
                <div class="guide-step">
                    <strong>Choose</strong>
                    <span>Check meals by time.</span>
                </div>

                <div class="guide-step">
                    <strong>Save</strong>
                    <span>Add meals to your Meal Log.</span>
                </div>

                <div class="guide-step">
                    <strong>Rate</strong>
                    <span>Help improve suggestions.</span>
                </div>

                <div class="guide-step">
                    <strong>Refresh</strong>
                    <span>Get another set of options.</span>
                </div>
            </div>
        </details>
    </div>

    @forelse($recommendations as $slot => $result)
        @php
            $slotMeals = $result['meals'] ?? collect();
            $budget = $result['slot_budget'] ?? 0;
            $method = $result['method'] ?? 'profile-based';
            $slotIcon = $slotIcons[$slot] ?? 'bi-egg-fried';
            $slotColor = $slotColors[$slot] ?? '#176BFF';
            $slotSoft = $slotSofts[$slot] ?? '#EAF2FF';
        @endphp

        <section class="slot-section" id="slot-{{ strtolower($slot) }}" style="--slot-color: {{ $slotColor }}; --slot-soft: {{ $slotSoft }};">
            <div class="slot-header">
                <div class="slot-title">
                    <div class="slot-icon">
                        <i class="bi {{ $slotIcon }}"></i>
                    </div>

                    <div>
                        <h4 class="slot-name">{{ $slot }}</h4>
                        <div class="slot-budget">
                            {{ number_format($budget) }} kcal target · {{ $method === 'rating-supported' ? 'Personalized matching' : 'Profile-based matching' }}
                        </div>
                    </div>
                </div>

                <button type="button"
                        class="slot-refresh"
                        id="refresh-{{ strtolower($slot) }}"
                        onclick="refreshSlot('{{ $slot }}')">
                    <i class="bi bi-arrow-clockwise"></i>
                    Refresh {{ $slot }}
                </button>
            </div>

            <div class="meal-list" id="meals-{{ strtolower($slot) }}">
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
                        $displayReason = trim((string) preg_replace('/^Recommended because\s+/i', '', $reason));
                        $displayReason = $displayReason ?: 'Suitable for this meal time.';
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
                        <div class="meal-main">
                            <div class="meal-meta">
                                <span class="cuisine-pill">
                                    <i class="bi bi-geo-alt-fill"></i>
                                    {{ $cuisineDisplay }}
                                </span>

                                <span class="match-badge {{ $matchClass }}">
                                    <i class="bi bi-check-circle-fill"></i>
                                    {{ $matchLabel }}
                                </span>

                                <span class="match-percent">
                                    {{ $matchPct }}% match
                                </span>
                            </div>

                            <h5 class="meal-name">{{ $mealName }}</h5>

                            <div class="meal-reason">
                                {{ $displayReason }}
                            </div>
                        </div>

                        <div class="macro-strip">
                            <div class="macro-mini">
                                <div class="macro-value" style="color:var(--blue);">{{ number_format($calories) }}</div>
                                <div class="macro-label">kcal</div>
                            </div>

                            <div class="macro-mini">
                                <div class="macro-value" style="color:var(--purple);">{{ number_format($protein, 1) }}g</div>
                                <div class="macro-label">Protein</div>
                            </div>

                            <div class="macro-mini">
                                <div class="macro-value" style="color:var(--orange);">{{ number_format($carbs, 1) }}g</div>
                                <div class="macro-label">Carbs</div>
                            </div>

                            <div class="macro-mini">
                                <div class="macro-value" style="color:#9333EA;">{{ number_format($fat, 1) }}g</div>
                                <div class="macro-label">Fat</div>
                            </div>
                        </div>

                        <div class="meal-actions">
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

            <a href="{{ route('meals.hybrid-recommend', ['refresh' => now()->timestamp]) }}" class="action-btn primary">
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
            const percentBox = document.getElementById('rating-progress-percent');

            if (percentBox && data.rating_count !== undefined) {
                const newPct = Math.min(100, Math.round((data.rating_count / 5) * 100));
                percentBox.textContent = `${newPct}%`;
            }

            showToast(data.message ?? `Rated ${stars} star${stars !== 1 ? 's' : ''}.`);

            if (data.cf_unlocked) {
                showToast('Personalized matching unlocked. Refreshing...');
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