{{-- resources/views/meals/food-logger.blade.php --}}
@extends('layouts.app')

@section('title', 'AI Food Logger — NutriTrack')

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

.logger-page::before {
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

.ai-hero {
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

.ai-hero::after {
    content: "";
    position: absolute;
    right: -120px;
    bottom: -130px;
    width: 380px;
    height: 380px;
    border-radius: 50%;
    background: rgba(255,255,255,.1);
}

.ai-hero-content {
    position: relative;
    z-index: 2;
}

.ai-kicker {
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

.ai-hero h1 {
    font-family: 'Playfair Display', serif;
    font-size: clamp(2rem, 4vw, 3.5rem);
    line-height: 1;
    letter-spacing: -.045em;
    margin-bottom: .6rem;
}

.ai-hero p {
    color: rgba(255,255,255,.78);
    margin: 0;
    max-width: 720px;
    line-height: 1.7;
    font-size: .95rem;
}

.hero-note {
    position: relative;
    z-index: 2;
    background: rgba(255,255,255,.14);
    border: 1px solid rgba(255,255,255,.2);
    backdrop-filter: blur(16px);
    border-radius: 28px;
    padding: 1.15rem;
}

.hero-note-label {
    font-size: .7rem;
    font-weight: 900;
    letter-spacing: .08em;
    text-transform: uppercase;
    color: rgba(255,255,255,.68);
    margin-bottom: .45rem;
}

.hero-note-text {
    color: rgba(255,255,255,.82);
    font-size: .86rem;
    line-height: 1.65;
}

.logger-card,
.result-card,
.empty-result {
    background: var(--card);
    border: 1px solid rgba(23,107,255,.1);
    border-radius: 30px;
    box-shadow: var(--shadow-soft);
    backdrop-filter: blur(18px);
    overflow: hidden;
}

.card-head {
    padding: 1.15rem 1.25rem;
    border-bottom: 1px solid rgba(23,107,255,.09);
}

.card-head h5 {
    margin: 0;
    color: var(--text);
    font-weight: 900;
    letter-spacing: -.03em;
}

.card-head p {
    margin: .3rem 0 0;
    color: var(--muted);
    font-size: .84rem;
    line-height: 1.55;
}

.card-body-custom {
    padding: 1.25rem;
}

.meal-time-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: .55rem;
    margin-bottom: 1rem;
}

.meal-time-option input {
    display: none;
}

.meal-time-box {
    cursor: pointer;
    border-radius: 18px;
    padding: .75rem .5rem;
    text-align: center;
    background: #F8FBFF;
    border: 1px solid rgba(23,107,255,.1);
    transition: .18s ease;
}

.meal-time-box:hover {
    transform: translateY(-2px);
    background: var(--blue-soft);
}

.meal-time-option input:checked + .meal-time-box {
    background: linear-gradient(135deg, var(--blue), var(--blue-dark));
    color: white;
    box-shadow: 0 14px 34px rgba(23,107,255,.25);
}

.meal-time-icon {
    font-size: 1.25rem;
    display: block;
    margin-bottom: .25rem;
}

.meal-time-label {
    font-size: .72rem;
    font-weight: 900;
}

.form-label-modern {
    color: var(--muted);
    font-size: .72rem;
    font-weight: 900;
    letter-spacing: .08em;
    text-transform: uppercase;
    margin-bottom: .5rem;
}

.food-textarea {
    min-height: 135px;
    border-radius: 22px;
    border: 1px solid rgba(23,107,255,.16);
    background: #F8FBFF;
    padding: 1rem;
    font-size: .95rem;
    line-height: 1.65;
    color: var(--text);
    resize: vertical;
    outline: none;
    transition: .18s ease;
}

.food-textarea:focus {
    background: white;
    border-color: var(--blue);
    box-shadow: 0 0 0 4px rgba(23,107,255,.1);
}

.example-chip {
    border: 0;
    border-radius: 999px;
    padding: .45rem .75rem;
    background: var(--blue-soft);
    color: var(--blue-dark);
    font-size: .78rem;
    font-weight: 800;
    transition: .18s ease;
}

.example-chip:hover {
    transform: translateY(-2px);
    background: #DCEBFF;
}

.analyze-btn,
.save-ai-btn {
    width: 100%;
    min-height: 50px;
    border: 0;
    border-radius: 18px;
    background: linear-gradient(135deg, var(--blue), var(--blue-dark));
    color: white;
    font-size: .93rem;
    font-weight: 900;
    transition: .2s ease;
    box-shadow: 0 16px 36px rgba(23,107,255,.24);
}

.analyze-btn:hover,
.save-ai-btn:hover {
    transform: translateY(-2px);
    color: white;
}

.helper-box {
    margin-top: 1rem;
    padding: 1rem;
    border-radius: 24px;
    background: #F8FBFF;
    border: 1px solid rgba(23,107,255,.08);
}

.helper-title {
    color: var(--blue);
    font-size: .72rem;
    font-weight: 900;
    letter-spacing: .08em;
    text-transform: uppercase;
    margin-bottom: .7rem;
}

.helper-step {
    display: flex;
    gap: .55rem;
    margin-bottom: .6rem;
    color: var(--muted);
    font-size: .82rem;
    line-height: 1.5;
}

.helper-step:last-child {
    margin-bottom: 0;
}

.helper-num {
    width: 22px;
    height: 22px;
    border-radius: 9px;
    background: var(--blue-soft);
    color: var(--blue);
    display: grid;
    place-items: center;
    font-size: .7rem;
    font-weight: 900;
    flex-shrink: 0;
}

.result-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: .9rem;
    margin-bottom: 1rem;
}

.result-title {
    font-weight: 900;
    color: var(--text);
    letter-spacing: -.03em;
    margin-bottom: .25rem;
}

.confidence-badge {
    border-radius: 999px;
    padding: .45rem .7rem;
    font-size: .75rem;
    font-weight: 900;
    white-space: nowrap;
}

.conf-high {
    background: var(--green-soft);
    color: var(--green);
}

.conf-medium {
    background: var(--orange-soft);
    color: var(--orange);
}

.conf-low {
    background: var(--red-soft);
    color: var(--red);
}

.calorie-panel {
    border-radius: 30px;
    padding: 1.4rem;
    color: white;
    background:
        radial-gradient(circle at 90% 20%, rgba(255,255,255,.2), transparent 30%),
        linear-gradient(135deg, var(--blue), var(--blue-dark));
    margin-bottom: 1rem;
    text-align: center;
}

.calorie-label {
    color: rgba(255,255,255,.72);
    font-size: .75rem;
    font-weight: 900;
    text-transform: uppercase;
    letter-spacing: .08em;
}

.calorie-value {
    font-size: 3.2rem;
    line-height: 1;
    font-weight: 900;
    letter-spacing: -.07em;
    margin-top: .4rem;
}

.calorie-unit {
    color: rgba(255,255,255,.75);
    font-weight: 700;
    margin-top: .25rem;
}

.macro-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: .75rem;
    margin-bottom: 1rem;
}

.macro-box {
    border-radius: 22px;
    padding: .85rem;
    background: #F8FBFF;
    border: 1px solid rgba(23,107,255,.08);
}

.macro-icon {
    width: 36px;
    height: 36px;
    border-radius: 14px;
    display: grid;
    place-items: center;
    margin-bottom: .65rem;
}

.macro-value {
    font-size: 1.15rem;
    font-weight: 900;
    letter-spacing: -.04em;
    line-height: 1;
}

.macro-label {
    color: var(--muted);
    font-size: .65rem;
    font-weight: 900;
    text-transform: uppercase;
    margin-top: .28rem;
}

.extra-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: .75rem;
    margin-bottom: 1rem;
}

.extra-box {
    border-radius: 22px;
    padding: .9rem;
    background: #F8FBFF;
    border: 1px solid rgba(23,107,255,.08);
    text-align: center;
}

.extra-value {
    font-size: 1.2rem;
    font-weight: 900;
}

.extra-label {
    color: var(--muted);
    font-size: .72rem;
    font-weight: 800;
}

/* Healthiness Estimate */
.health-card {
    border-radius: 26px;
    padding: 1rem;
    margin-bottom: 1rem;
    border: 1px solid rgba(23,107,255,.09);
}

.health-card.healthy {
    background: var(--green-soft);
    color: #14532D;
}

.health-card.moderate {
    background: var(--orange-soft);
    color: #9A3412;
}

.health-card.less_healthy {
    background: var(--red-soft);
    color: #7F1D1D;
}

.health-top {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: .75rem;
    margin-bottom: .75rem;
}

.health-label {
    font-size: 1rem;
    font-weight: 900;
    margin-bottom: .15rem;
}

.health-summary {
    font-size: .84rem;
    line-height: 1.55;
}

.health-score {
    min-width: 68px;
    text-align: center;
    border-radius: 18px;
    padding: .55rem .7rem;
    background: rgba(255,255,255,.62);
    font-weight: 900;
}

.health-score small {
    display: block;
    font-size: .62rem;
    color: rgba(15,23,42,.55);
    text-transform: uppercase;
    letter-spacing: .06em;
}

.health-list {
    margin: 0;
    padding-left: 1.1rem;
    font-size: .82rem;
    line-height: 1.55;
}

.health-list li {
    margin-bottom: .2rem;
}

.item-table {
    margin-bottom: 0;
}

.item-table thead th {
    background: #F8FBFF;
    color: var(--muted);
    font-size: .72rem;
    font-weight: 900;
    text-transform: uppercase;
    border: 0;
    padding: .75rem;
}

.item-table tbody td {
    border-bottom: 1px solid rgba(23,107,255,.08);
    padding: .75rem;
    font-size: .88rem;
}

.empty-result {
    min-height: 520px;
    display: grid;
    place-items: center;
    text-align: center;
    padding: 2rem;
    border: 1px dashed rgba(23,107,255,.25);
}

.empty-icon {
    width: 86px;
    height: 86px;
    border-radius: 30px;
    background: var(--blue-soft);
    color: var(--blue);
    display: grid;
    place-items: center;
    font-size: 2.2rem;
    margin: 0 auto 1rem;
}

.notice-box {
    margin-top: 1rem;
    border-radius: 24px;
    padding: .9rem;
    background: var(--orange-soft);
    color: #9A3412;
    font-size: .82rem;
    line-height: 1.55;
}

#loading-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(248,251,255,.78);
    backdrop-filter: blur(5px);
    z-index: 9999;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    gap: 1rem;
}

#loading-overlay.active {
    display: flex;
}

.spinner-ring {
    width: 58px;
    height: 58px;
    border: 5px solid var(--blue-soft);
    border-top-color: var(--blue);
    border-radius: 50%;
    animation: spin .8s linear infinite;
}

@keyframes spin {
    to {
        transform: rotate(360deg);
    }
}

.fade-up {
    animation: fadeUp .45s ease both;
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
    .meal-time-grid,
    .macro-grid {
        grid-template-columns: repeat(2, 1fr);
    }

    .empty-result {
        min-height: 360px;
    }
}

@media (max-width: 575px) {
    .meal-time-grid,
    .macro-grid,
    .extra-grid {
        grid-template-columns: 1fr;
    }

    .result-header,
    .health-top {
        flex-direction: column;
    }
}
</style>
@endpush

@section('content')

<div id="loading-overlay">
    <div class="spinner-ring"></div>
    <p class="fw-bold text-primary mb-0">Analyzing your meal with AI...</p>
</div>

<div class="logger-page">

    <div class="ai-hero fade-up">
        <div class="row align-items-center g-4">
            <div class="col-12 col-lg-8">
                <div class="ai-hero-content">
                    <div class="ai-kicker">
                        <i class="bi bi-stars"></i>
                        AI Food Logger
                    </div>

                    <h1>Describe your meal. Get instant nutrition estimates.</h1>

                    <p>
                        Choose the meal time, describe what you ate in normal language, and NutriTrack will estimate calories,
                        macros, sugar, sodium, fiber, and item breakdown.
                    </p>
                </div>
            </div>

            <div class="col-12 col-lg-4">
                <div class="hero-note">
                    <div class="hero-note-label">Important Note</div>
                    <div class="hero-note-text">
                        AI values are estimates. For better accuracy, include portion size, cooking method, and quantity.
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($errors->has('api'))
        <div class="alert alert-danger d-flex align-items-center gap-2 mb-4 rounded-4" role="alert">
            <i class="bi bi-exclamation-triangle-fill fs-5"></i>
            <span>{{ $errors->first('api') }}</span>
        </div>
    @endif

    <div class="row g-4">

        <div class="col-12 col-xl-5">
            <div class="logger-card h-100">
                <div class="card-head">
                    <h5><i class="bi bi-pencil-square text-primary me-2"></i>Log a Meal</h5>
                    <p>Tell the AI what you ate. The more specific your description, the better the estimate.</p>
                </div>

                <div class="card-body-custom">
                    <form id="logger-form" action="{{ route('food-logger.analyze') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <div class="form-label-modern">Meal Time</div>

                            @php
                                $selectedMealTime = old('meal_time', $nutrition['meal_time'] ?? 'Breakfast');
                                $mealTimes = [
                                    'Breakfast' => '🌅',
                                    'Lunch' => '☀️',
                                    'Dinner' => '🌙',
                                    'Snack' => '🍎',
                                ];
                            @endphp

                            <div class="meal-time-grid">
                                @foreach($mealTimes as $time => $icon)
                                    <label class="meal-time-option">
                                        <input type="radio" name="meal_time" value="{{ $time }}" {{ $selectedMealTime === $time ? 'checked' : '' }}>
                                        <div class="meal-time-box">
                                            <span class="meal-time-icon">{{ $icon }}</span>
                                            <span class="meal-time-label">{{ $time }}</span>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="food_description" class="form-label-modern">
                                What did you eat?
                            </label>

                            <textarea
                                id="food_description"
                                name="food_description"
                                class="form-control food-textarea @error('food_description') is-invalid @enderror"
                                placeholder="Example: 1 plate of nasi lemak with sambal, fried anchovies, boiled egg, cucumber, and teh tarik"
                                maxlength="500"
                            >{{ old('food_description', $nutrition['food_description'] ?? '') }}</textarea>

                            @error('food_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            <div class="d-flex justify-content-between mt-2">
                                <small class="text-muted">Include portion size for better accuracy.</small>
                                <small class="text-muted" id="char-count">0 / 500</small>
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="form-label-modern">Quick Examples</div>

                            <div class="d-flex flex-wrap gap-2">
                                <button type="button" class="example-chip"
                                    data-text="1 plate of nasi lemak with sambal, fried anchovies, boiled egg and cucumber">
                                    🍛 Nasi Lemak
                                </button>

                                <button type="button" class="example-chip"
                                    data-text="1 bowl of chicken rice with soup and cucumber">
                                    🍗 Chicken Rice
                                </button>

                                <button type="button" class="example-chip"
                                    data-text="1 plate of mee goreng mamak with fried egg">
                                    🍜 Mee Goreng
                                </button>

                                <button type="button" class="example-chip"
                                    data-text="2 slices of whole wheat bread with peanut butter and one banana">
                                    🥜 PB Bread
                                </button>

                                <button type="button" class="example-chip"
                                    data-text="200g grilled chicken breast with 1 cup white rice and mixed vegetables">
                                    🥗 Chicken Set
                                </button>
                            </div>
                        </div>

                        <button type="submit" class="analyze-btn" id="analyze-btn">
                            <i class="bi bi-stars me-2"></i>
                            Analyze with AI
                        </button>
                    </form>

                    <div class="helper-box">
                        <div class="helper-title">
                            <i class="bi bi-info-circle-fill me-1"></i>
                            How this feature works
                        </div>

                        <div class="helper-step">
                            <div class="helper-num">1</div>
                            <div>Choose whether the food is breakfast, lunch, dinner, or snack.</div>
                        </div>

                        <div class="helper-step">
                            <div class="helper-num">2</div>
                            <div>Describe your meal using normal language.</div>
                        </div>

                        <div class="helper-step">
                            <div class="helper-num">3</div>
                            <div>NutriTrack estimates nutrition using AI and shows the breakdown.</div>
                        </div>

                        <div class="helper-step">
                            <div class="helper-num">4</div>
                            <div>Save the result to your diary if you want to keep it.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-xl-7">
            @if(isset($nutrition))
                <div class="result-card fade-up">
                    <div class="card-body-custom">

                        <div class="result-header">
                            <div>
                                <h4 class="result-title">{{ $nutrition['meal_name'] }}</h4>

                                @if($nutrition['serving_note'])
                                    <div class="text-muted small">{{ $nutrition['serving_note'] }}</div>
                                @endif

                                <div class="mt-2">
                                    <span class="badge rounded-pill bg-light text-dark border">
                                        <i class="bi bi-clock me-1"></i>
                                        {{ $nutrition['meal_time'] ?? 'Meal' }}
                                    </span>

                                    @if(isset($nutrition['api_used']))
                                        <span class="badge rounded-pill bg-light text-dark border">
                                            <i class="bi bi-cpu me-1"></i>
                                            {{ $nutrition['api_used'] }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <span class="confidence-badge conf-{{ $nutrition['confidence'] }}">
                                @if($nutrition['confidence'] === 'high')
                                    <i class="bi bi-check-circle-fill me-1"></i> High Confidence
                                @elseif($nutrition['confidence'] === 'medium')
                                    <i class="bi bi-dash-circle-fill me-1"></i> Medium Confidence
                                @else
                                    <i class="bi bi-exclamation-circle-fill me-1"></i> Low Confidence
                                @endif
                            </span>
                        </div>

                        <div class="calorie-panel">
                            <div class="calorie-label">Estimated Calories</div>
                            <div class="calorie-value">{{ number_format($nutrition['total_calories']) }}</div>
                            <div class="calorie-unit">kcal</div>
                        </div>

                        <div class="macro-grid">
                            <div class="macro-box">
                                <div class="macro-icon" style="background:var(--blue-soft);color:var(--blue);">
                                    <i class="bi bi-droplet-fill"></i>
                                </div>
                                <div class="macro-value" style="color:var(--blue);">{{ number_format($nutrition['protein_g'], 1) }}g</div>
                                <div class="macro-label">Protein</div>
                            </div>

                            <div class="macro-box">
                                <div class="macro-icon" style="background:var(--orange-soft);color:var(--orange);">
                                    <i class="bi bi-lightning-fill"></i>
                                </div>
                                <div class="macro-value" style="color:var(--orange);">{{ number_format($nutrition['carbs_g'], 1) }}g</div>
                                <div class="macro-label">Carbs</div>
                            </div>

                            <div class="macro-box">
                                <div class="macro-icon" style="background:var(--purple-soft);color:var(--purple);">
                                    <i class="bi bi-heart-fill"></i>
                                </div>
                                <div class="macro-value" style="color:var(--purple);">{{ number_format($nutrition['fat_g'], 1) }}g</div>
                                <div class="macro-label">Fat</div>
                            </div>

                            <div class="macro-box">
                                <div class="macro-icon" style="background:var(--green-soft);color:var(--green);">
                                    <i class="bi bi-tree-fill"></i>
                                </div>
                                <div class="macro-value" style="color:var(--green);">{{ number_format($nutrition['fiber_g'], 1) }}g</div>
                                <div class="macro-label">Fiber</div>
                            </div>
                        </div>

                        <div class="extra-grid">
                            <div class="extra-box">
                                <div class="extra-value" style="color:var(--orange);">{{ number_format($nutrition['sugar_g'], 1) }}g</div>
                                <div class="extra-label">Sugar</div>
                            </div>

                            <div class="extra-box">
                                <div class="extra-value" style="color:var(--blue);">{{ number_format($nutrition['sodium_mg'], 0) }}mg</div>
                                <div class="extra-label">Sodium</div>
                            </div>
                        </div>

                        @if(!empty($nutrition['healthiness']))
                            @php
                                $health = $nutrition['healthiness'];
                                $healthIcon = match($health['level']) {
                                    'healthy' => 'bi-check-circle-fill',
                                    'moderate' => 'bi-exclamation-circle-fill',
                                    default => 'bi-x-circle-fill',
                                };
                            @endphp

                            <div class="health-card {{ $health['level'] }}">
                                <div class="health-top">
                                    <div>
                                        <div class="health-label">
                                            <i class="bi {{ $healthIcon }} me-1"></i>
                                            {{ $health['label'] }}
                                        </div>

                                        <div class="health-summary">
                                            {{ $health['summary'] }}
                                        </div>
                                    </div>

                                    <div class="health-score">
                                        {{ $health['score'] }}/100
                                        <small>Score</small>
                                    </div>
                                </div>

                                @if(!empty($health['reasons']))
                                    <div class="fw-bold mb-1" style="font-size:.78rem;">Why?</div>
                                    <ul class="health-list mb-2">
                                        @foreach(array_slice($health['reasons'], 0, 4) as $reason)
                                            <li>{{ $reason }}</li>
                                        @endforeach
                                    </ul>
                                @endif

                                @if(!empty($health['suggestions']))
                                    <div class="fw-bold mb-1" style="font-size:.78rem;">Suggestion</div>
                                    <ul class="health-list">
                                        @foreach(array_slice($health['suggestions'], 0, 3) as $suggestion)
                                            <li>{{ $suggestion }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        @endif

                        @if(!empty($nutrition['items']))
                            <div class="table-responsive mb-3">
                                <table class="table item-table">
                                    <thead>
                                        <tr>
                                            <th>Food Item</th>
                                            <th>Quantity</th>
                                            <th class="text-end">Calories</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach($nutrition['items'] as $item)
                                            <tr>
                                                <td class="fw-bold">{{ $item['name'] }}</td>
                                                <td class="text-muted">{{ $item['quantity'] }}</td>
                                                <td class="text-end fw-bold text-primary">{{ number_format($item['calories']) }} kcal</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif

                        <form action="{{ route('food-logger.save') }}" method="POST">
                            @csrf

                            <input type="hidden" name="meal_time" value="{{ $nutrition['meal_time'] ?? 'Snack' }}">
                            <input type="hidden" name="meal_name" value="{{ $nutrition['meal_name'] }}">
                            <input type="hidden" name="total_calories" value="{{ $nutrition['total_calories'] }}">
                            <input type="hidden" name="protein_g" value="{{ $nutrition['protein_g'] }}">
                            <input type="hidden" name="carbs_g" value="{{ $nutrition['carbs_g'] }}">
                            <input type="hidden" name="fat_g" value="{{ $nutrition['fat_g'] }}">

                            <button type="submit" class="save-ai-btn">
                                <i class="bi bi-journal-plus me-2"></i>
                                Save This AI Meal to Diary
                            </button>
                        </form>

                        <div class="notice-box">
                            <i class="bi bi-exclamation-circle-fill me-1"></i>
                            This is an AI-generated estimate. Nutrition values may vary depending on actual ingredients, portion size, and cooking method.
                        </div>
                    </div>
                </div>
            @else
                <div class="empty-result">
                    <div>
                        <div class="empty-icon">
                            <i class="bi bi-robot"></i>
                        </div>

                        <h5 class="fw-bold text-primary mb-2">Ready to analyze your meal</h5>

                        <p class="text-muted mb-0" style="max-width:360px;">
                            Select the meal time, describe what you ate, and your nutrition result will appear here.
                        </p>
                    </div>
                </div>
            @endif
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const textarea = document.getElementById('food_description');
    const charCount = document.getElementById('char-count');

    const updateCount = () => {
        if (textarea && charCount) {
            charCount.textContent = `${textarea.value.length} / 500`;
        }
    };

    if (textarea) {
        textarea.addEventListener('input', updateCount);
        updateCount();
    }

    document.querySelectorAll('.example-chip').forEach(button => {
        button.addEventListener('click', () => {
            textarea.value = button.dataset.text;
            textarea.focus();
            updateCount();
        });
    });

    const form = document.getElementById('logger-form');
    const overlay = document.getElementById('loading-overlay');
    const submitButton = document.getElementById('analyze-btn');

    if (form && overlay && submitButton) {
        form.addEventListener('submit', () => {
            overlay.classList.add('active');
            submitButton.disabled = true;
            submitButton.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Analyzing...';
        });
    }
});
</script>
@endpush