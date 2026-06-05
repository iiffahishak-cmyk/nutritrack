@extends('layouts.app')

@section('title', 'My Health Profile — NutriTrack')

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

.profile-page::before {
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

.profile-hero {
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

.profile-hero::after {
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

.profile-hero h1 {
    font-family: 'Playfair Display', serif;
    font-size: clamp(2rem, 4vw, 3.5rem);
    line-height: 1;
    letter-spacing: -.045em;
    margin-bottom: .6rem;
}

.profile-hero p {
    color: rgba(255,255,255,.78);
    margin: 0;
    max-width: 720px;
    line-height: 1.7;
    font-size: .95rem;
}

.hero-stat-card {
    position: relative;
    z-index: 2;
    background: rgba(255,255,255,.14);
    border: 1px solid rgba(255,255,255,.2);
    backdrop-filter: blur(16px);
    border-radius: 28px;
    padding: 1.15rem;
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
    font-size: 2.2rem;
    line-height: 1;
    font-weight: 900;
    letter-spacing: -.06em;
}

.hero-stat-sub {
    color: rgba(255,255,255,.7);
    font-size: .8rem;
    margin-top: .3rem;
}

.nt-card {
    background: var(--card);
    border: 1px solid rgba(23,107,255,.1);
    border-radius: 30px;
    box-shadow: var(--shadow-soft);
    backdrop-filter: blur(18px);
    overflow: hidden;
}

.nt-card-head {
    padding: 1.15rem 1.25rem;
    border-bottom: 1px solid rgba(23,107,255,.09);
}

.nt-card-head h5 {
    margin: 0;
    color: var(--text);
    font-weight: 900;
    letter-spacing: -.03em;
}

.nt-card-head p {
    margin: .3rem 0 0;
    color: var(--muted);
    font-size: .84rem;
    line-height: 1.55;
}

.nt-card-body {
    padding: 1.25rem;
}

.form-label-modern {
    color: var(--muted);
    font-size: .72rem;
    font-weight: 900;
    letter-spacing: .08em;
    text-transform: uppercase;
    margin-bottom: .5rem;
}

.form-control,
.form-select {
    border-radius: 18px;
    border: 1px solid rgba(23,107,255,.16);
    background: #F8FBFF;
    padding: .78rem .9rem;
    font-weight: 700;
    color: var(--text);
}

.form-control:focus,
.form-select:focus {
    background: white;
    border-color: var(--blue);
    box-shadow: 0 0 0 4px rgba(23,107,255,.1);
}

.goal-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: .75rem;
}

.goal-option input {
    display: none;
}

.goal-box {
    cursor: pointer;
    border-radius: 22px;
    padding: 1rem;
    text-align: center;
    background: #F8FBFF;
    border: 1px solid rgba(23,107,255,.1);
    transition: .18s ease;
    height: 100%;
}

.goal-box:hover {
    transform: translateY(-2px);
    background: var(--blue-soft);
}

.goal-option input:checked + .goal-box {
    background: linear-gradient(135deg, var(--blue), var(--blue-dark));
    color: white;
    box-shadow: 0 14px 34px rgba(23,107,255,.25);
}

.goal-icon {
    font-size: 1.6rem;
    display: block;
    margin-bottom: .45rem;
}

.goal-title {
    display: block;
    font-size: .86rem;
    font-weight: 900;
}

.goal-desc {
    display: block;
    font-size: .7rem;
    opacity: .72;
    margin-top: .25rem;
}

.submit-btn,
.action-btn {
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
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: .55rem;
}

.submit-btn:hover,
.action-btn:hover {
    transform: translateY(-2px);
    color: white;
}

.stat-main {
    text-align: center;
    padding: 1.2rem;
    border-radius: 28px;
    background: var(--blue-soft);
    margin-bottom: 1rem;
}

.bmi-number {
    font-size: 3.5rem;
    font-weight: 900;
    letter-spacing: -.08em;
    line-height: 1;
    color: var(--blue);
}

.bmi-label {
    display: inline-flex;
    align-items: center;
    padding: .38rem .8rem;
    border-radius: 999px;
    font-size: .75rem;
    font-weight: 900;
    margin-top: .7rem;
}

.bmi-warning {
    background: var(--orange-soft);
    color: var(--orange);
}

.bmi-success {
    background: var(--green-soft);
    color: var(--green);
}

.bmi-danger {
    background: var(--red-soft);
    color: var(--red);
}

.stat-list {
    display: grid;
    gap: .7rem;
}

.stat-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: .8rem;
    padding: .85rem;
    border-radius: 18px;
    background: #F8FBFF;
    border: 1px solid rgba(23,107,255,.08);
}

.stat-row span:first-child {
    color: var(--muted);
    font-size: .82rem;
    font-weight: 800;
}

.stat-row span:last-child {
    color: var(--text);
    font-size: .9rem;
    font-weight: 900;
    text-align: right;
}

.daily-target-row {
    background: linear-gradient(135deg, var(--blue), var(--blue-dark));
    color: white;
}

.daily-target-row span:first-child,
.daily-target-row span:last-child {
    color: white;
}

.daily-target-row span:last-child {
    font-size: 1.25rem;
}


/* ================= IDEAL WEIGHT RANGE ================= */
.ideal-weight-card {
    margin: 1rem 0;
    border-radius: 26px;
    padding: 1rem;
    background:
        radial-gradient(circle at 90% 10%, rgba(32,199,255,.15), transparent 28%),
        linear-gradient(135deg, #FFFFFF, #F8FBFF);
    border: 1px solid rgba(23,107,255,.1);
    box-shadow: 0 14px 34px rgba(23,107,255,.07);
}

.ideal-range-main {
    display: grid;
    grid-template-columns: 58px 1fr;
    gap: .85rem;
    align-items: center;
    padding: .95rem;
    border-radius: 24px;
    background: var(--blue-soft);
    margin-bottom: .85rem;
}

.ideal-range-icon {
    width: 58px;
    height: 58px;
    border-radius: 20px;
    display: grid;
    place-items: center;
    background: linear-gradient(135deg, var(--blue), var(--blue-dark));
    color: white;
    font-size: 1.55rem;
    box-shadow: 0 14px 28px rgba(23,107,255,.22);
}

.ideal-range-label {
    color: var(--muted);
    font-size: .68rem;
    font-weight: 900;
    text-transform: uppercase;
    letter-spacing: .08em;
    margin-bottom: .3rem;
}

.ideal-range-value {
    color: var(--blue-dark);
    font-size: 1.65rem;
    line-height: 1;
    font-weight: 900;
    letter-spacing: -.06em;
}

.ideal-progress-track {
    position: relative;
    height: 12px;
    border-radius: 999px;
    background: #E5EFFF;
    overflow: hidden;
    margin: .9rem 0 .7rem;
}

.ideal-progress-fill {
    height: 100%;
    border-radius: 999px;
    background: linear-gradient(135deg, var(--green), #0F7A36);
}

.weight-status-box {
    border-radius: 18px;
    padding: .85rem;
    font-size: .84rem;
    font-weight: 800;
    line-height: 1.55;
}

.weight-status-success {
    background: var(--green-soft);
    color: var(--green);
}

.weight-status-warning {
    background: var(--orange-soft);
    color: #9A3412;
}

.weight-guide-note {
    color: var(--muted);
    font-size: .74rem;
    line-height: 1.55;
    margin-top: .75rem;
}

.weight-update-box {
    margin-top: 1rem;
    padding: 1rem;
    border-radius: 24px;
    background: #F8FBFF;
    border: 1px solid rgba(23,107,255,.08);
}

.info-box {
    border-radius: 24px;
    padding: 1rem;
    background: var(--orange-soft);
    color: #9A3412;
    font-size: .84rem;
    line-height: 1.6;
}

.empty-state {
    text-align: center;
    padding: 2rem 1rem;
}

.empty-icon {
    width: 76px;
    height: 76px;
    border-radius: 28px;
    background: var(--blue-soft);
    color: var(--blue);
    display: grid;
    place-items: center;
    font-size: 2rem;
    margin: 0 auto 1rem;
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
    .goal-grid {
        grid-template-columns: 1fr;
    }
}
</style>
@endpush

@section('content')
@php
    $hasProfile = isset($profile) && $profile;

    $bmi = null;
    $bmiCategory = null;

    if ($hasProfile && $profile->height_cm > 0) {
        $bmi = round($profile->weight_kg / (($profile->height_cm / 100) ** 2), 1);

        $bmiCategory = $bmi < 18.5
            ? ['Underweight', 'warning']
            : ($bmi < 25
                ? ['Normal', 'success']
                : ($bmi < 30
                    ? ['Overweight', 'warning']
                    : ['Obese', 'danger']));
    }

    $goalRaw = $hasProfile ? $profile->goal : null;
    $goalClean = $goalRaw ? ucwords(str_replace('_', ' ', $goalRaw)) : 'Not Set';

    $idealMinWeight = null;
    $idealMaxWeight = null;
    $weightGap = null;
    $weightStatusMessage = null;
    $weightStatusType = 'success';

    if ($hasProfile && $profile->height_cm > 0 && $profile->weight_kg > 0) {
        $heightM = $profile->height_cm / 100;

        $idealMinWeight = round(18.5 * ($heightM ** 2), 1);
        $idealMaxWeight = round(24.9 * ($heightM ** 2), 1);

        if ($profile->weight_kg < $idealMinWeight) {
            $weightGap = round($idealMinWeight - $profile->weight_kg, 1);
            $weightStatusMessage = "You are about {$weightGap} kg below the healthy weight range.";
            $weightStatusType = 'warning';
        } elseif ($profile->weight_kg > $idealMaxWeight) {
            $weightGap = round($profile->weight_kg - $idealMaxWeight, 1);
            $weightStatusMessage = "You are about {$weightGap} kg above the healthy weight range.";
            $weightStatusType = 'warning';
        } else {
            $weightGap = 0;
            $weightStatusMessage = "Your current weight is within the healthy weight range.";
            $weightStatusType = 'success';
        }
    }

@endphp

<div class="profile-page">

    <div class="profile-hero fade-up">
        <div class="row align-items-center g-4">
            <div class="col-12 col-lg-8">
                <div class="hero-content">
                    <div class="hero-kicker">
                        <i class="bi bi-person-heart"></i>
                        Health Profile
                    </div>

                    <h1>Set up your nutrition profile.</h1>

                    <p>
                        Your profile helps NutriTrack calculate BMR, TDEE, DCR, and personalize meals based on your goal,
                        allergies, and preferred cuisine.
                    </p>
                </div>
            </div>

            <div class="col-12 col-lg-4">
                <div class="hero-stat-card text-lg-end">
                    <div class="hero-stat-label">Daily Target</div>
                    <div class="hero-stat-value">
                        {{ $hasProfile ? number_format($profile->dcr_value, 0) : '—' }}
                    </div>
                    <div class="hero-stat-sub">
                        {{ $hasProfile ? 'kcal/day · ' . $goalClean : 'Complete your profile first' }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success rounded-4 border-0 shadow-sm">
            <i class="bi bi-check-circle-fill me-1"></i>
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger rounded-4 border-0 shadow-sm">
            <strong>Please check the form:</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row g-4">

        <div class="col-12 col-xl-7">
            <div class="nt-card h-100">
                <div class="nt-card-head">
                    <h5><i class="bi bi-sliders text-primary me-2"></i>Personal Health Data</h5>
                    <p>Enter accurate details so the system can calculate your calorie needs properly.</p>
                </div>

                <div class="nt-card-body">
                    <form action="{{ route('profile.save') }}" method="POST">
                        @csrf

                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <label class="form-label-modern">Age</label>
                                <input type="number"
                                       name="age"
                                       class="form-control"
                                       value="{{ old('age', $profile?->age) }}"
                                       placeholder="Example: 22"
                                       required>
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label-modern">Gender</label>
                                <select name="gender" class="form-select" required>
                                    <option value="">Select gender</option>
                                    <option value="male" {{ old('gender', $profile?->gender) == 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ old('gender', $profile?->gender) == 'female' ? 'selected' : '' }}>Female</option>
                                </select>
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label-modern">Weight (kg)</label>
                                <input type="number"
                                       step="0.1"
                                       name="weight_kg"
                                       class="form-control"
                                       value="{{ old('weight_kg', $profile?->weight_kg) }}"
                                       placeholder="Example: 65.5"
                                       required>
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label-modern">Height (cm)</label>
                                <input type="number"
                                       step="0.1"
                                       name="height_cm"
                                       class="form-control"
                                       value="{{ old('height_cm', $profile?->height_cm) }}"
                                       placeholder="Example: 165"
                                       required>
                            </div>

                            <div class="col-12">
                                <label class="form-label-modern">Activity Level</label>
                                <select name="activity_level" class="form-select" required>
                                    <option value="">Select your activity level</option>
                                    <option value="sedentary" {{ old('activity_level', $profile?->activity_level) == 'sedentary' ? 'selected' : '' }}>
                                        Sedentary — little or no exercise
                                    </option>
                                    <option value="lightly_active" {{ old('activity_level', $profile?->activity_level) == 'lightly_active' ? 'selected' : '' }}>
                                        Lightly active — 1 to 3 days per week
                                    </option>
                                    <option value="moderately_active" {{ old('activity_level', $profile?->activity_level) == 'moderately_active' ? 'selected' : '' }}>
                                        Moderately active — 3 to 5 days per week
                                    </option>
                                    <option value="very_active" {{ old('activity_level', $profile?->activity_level) == 'very_active' ? 'selected' : '' }}>
                                        Very active — 6 to 7 days per week
                                    </option>
                                    <option value="extra_active" {{ old('activity_level', $profile?->activity_level) == 'extra_active' ? 'selected' : '' }}>
                                        Extra active — physical job or intense training
                                    </option>
                                </select>
                            </div>

                            <div class="col-12">
                                <label class="form-label-modern">Your Goal</label>

                                <div class="goal-grid">
                                    @php
                                        $goals = [
                                            'lose_weight' => [
                                                'title' => 'Lose Weight',
                                                'desc' => 'Calorie deficit',
                                                'icon' => 'bi-arrow-down-circle',
                                            ],
                                            'maintain' => [
                                                'title' => 'Maintain',
                                                'desc' => 'Balanced target',
                                                'icon' => 'bi-circle',
                                            ],
                                            'gain_weight' => [
                                                'title' => 'Gain Weight',
                                                'desc' => 'Calorie surplus',
                                                'icon' => 'bi-arrow-up-circle',
                                            ],
                                        ];
                                    @endphp

                                    @foreach($goals as $value => $goal)
                                        <label class="goal-option">
                                            <input type="radio"
                                                   name="goal"
                                                   value="{{ $value }}"
                                                   {{ old('goal', $profile?->goal) == $value ? 'checked' : '' }}
                                                   required>

                                            <div class="goal-box">
                                                <i class="bi {{ $goal['icon'] }} goal-icon"></i>
                                                <span class="goal-title">{{ $goal['title'] }}</span>
                                                <span class="goal-desc">{{ $goal['desc'] }}</span>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="form-label-modern">Allergies</label>
                                <input type="text"
                                       name="allergies"
                                       class="form-control"
                                       value="{{ old('allergies', $profile?->allergies) }}"
                                       placeholder="Example: nuts, dairy, shellfish">

                                <small class="text-muted d-block mt-2">
                                    Separate multiple allergies with commas.
                                </small>
                            </div>

                            <div class="col-12">
                                <label class="form-label-modern">Preferred Cuisine</label>
                                <select name="preferred_cuisine" class="form-select">
                                    <option value="">No preference</option>

                                    @foreach(['Malay', 'Chinese', 'Indian', 'Western', 'Middle Eastern'] as $cuisine)
                                        <option value="{{ $cuisine }}"
                                            {{ old('preferred_cuisine', $profile?->preferred_cuisine) == $cuisine ? 'selected' : '' }}>
                                            {{ $cuisine }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="info-box mt-4">
                            <i class="bi bi-info-circle-fill me-1"></i>
                            NutriTrack uses this information to calculate your daily calorie target and personalize recommendations.
                        </div>

                        <button type="submit" class="submit-btn mt-4">
                            <i class="bi bi-calculator"></i>
                            {{ $hasProfile ? 'Update Profile & Recalculate' : 'Calculate My Calorie Plan' }}
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-12 col-xl-5">
            <div class="nt-card mb-4">
                <div class="nt-card-head">
                    <h5><i class="bi bi-heart-pulse text-primary me-2"></i>Your Nutrition Summary</h5>
                    <p>Your calculated health indicators will appear here.</p>
                </div>

                <div class="nt-card-body">
                    @if($hasProfile)
                        <div class="stat-main">
                            <div class="bmi-number">{{ $bmi }}</div>
                            <span class="bmi-label bmi-{{ $bmiCategory[1] }}">
                                {{ $bmiCategory[0] }}
                            </span>
                            <div class="text-muted small fw-bold text-uppercase mt-2">
                                Body Mass Index
                            </div>
                        </div>



                        @if($idealMinWeight && $idealMaxWeight)
                            @php
                                $rangeWidth = max(1, $idealMaxWeight - $idealMinWeight);
                                $currentWeightPosition = $profile->weight_kg <= $idealMinWeight
                                    ? 8
                                    : ($profile->weight_kg >= $idealMaxWeight
                                        ? 100
                                        : 8 + min(84, (($profile->weight_kg - $idealMinWeight) / $rangeWidth) * 84));
                            @endphp

                            <div class="ideal-weight-card">
                                <div class="ideal-range-main">
                                    <div class="ideal-range-icon">
                                        <i class="bi bi-bullseye"></i>
                                    </div>

                                    <div>
                                        <div class="ideal-range-label">Healthy Weight Range</div>
                                        <div class="ideal-range-value">
                                            {{ $idealMinWeight }}–{{ $idealMaxWeight }} kg
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between align-items-center small fw-bold text-muted">
                                    <span>{{ $idealMinWeight }} kg</span>
                                    <span>Current: {{ $profile->weight_kg }} kg</span>
                                    <span>{{ $idealMaxWeight }} kg</span>
                                </div>

                                <div class="ideal-progress-track">
                                    <div class="ideal-progress-fill" style="width: {{ $currentWeightPosition }}%;"></div>
                                </div>

                                <div class="weight-status-box weight-status-{{ $weightStatusType }}">
                                    <i class="bi {{ $weightStatusType === 'success' ? 'bi-check-circle-fill' : 'bi-info-circle-fill' }} me-1"></i>
                                    {{ $weightStatusMessage }}
                                </div>

                                <div class="weight-guide-note">
                                    This range is based on the adult BMI healthy range of 18.5 to 24.9. It is a guide only and does not replace medical advice.
                                </div>
                            </div>
                        @endif

                        <div class="stat-list">
                            <div class="stat-row">
                                <span>BMR</span>
                                <span>{{ number_format($profile->bmr, 0) }} kcal</span>
                            </div>
                            <div class="info-box mb-3">
    <div class="d-flex align-items-start gap-2">
        <i class="bi bi-book-fill mt-1"></i>
        <div>
            <strong>Not sure what BMI, BMR, TDEE, or DCR means?</strong>
            <div class="mt-1">
                These values help NutriTrack estimate your calorie needs and recommend meals that match your health goal.
            </div>

            <a href="{{ route('nutrition-guide') }}"
               class="action-btn mt-3"
               style="min-height:42px;font-size:.82rem;background:linear-gradient(135deg,var(--orange),#EA580C);">
                <i class="bi bi-book"></i>
                Open Nutrition Guide
            </a>
        </div>
    </div>
</div>

                            <div class="stat-row">
                                <span>TDEE</span>
                                <span>{{ number_format($profile->tdee_value, 0) }} kcal</span>
                            </div>

                            <div class="stat-row">
                                <span>Goal</span>
                                <span>{{ $goalClean }}</span>
                            </div>

                            <div class="stat-row">
                                <span>Preferred Cuisine</span>
                                <span>{{ $profile->preferred_cuisine ?? 'No preference' }}</span>
                            </div>

                            <div class="stat-row daily-target-row">
                                <span>Daily Target</span>
                                <span>{{ number_format($profile->dcr_value, 0) }} kcal</span>
                            </div>
                        </div>

                        <a href="{{ route('meals.hybrid-recommend') }}" class="action-btn mt-3">
                            <i class="bi bi-stars"></i>
                            View My Recommendations
                        </a>
                    @else
                        <div class="empty-state">
                            <div class="empty-icon">
                                <i class="bi bi-clipboard2-pulse"></i>
                            </div>

                            <h5 class="fw-bold text-primary mb-2">No profile yet</h5>

                            <p class="text-muted mb-0">
                                Fill in the form to unlock your DCR, BMI, and personalized meal recommendations.
                            </p>
                        </div>
                    @endif
                </div>
            </div>

            @if($hasProfile)
                <div class="nt-card">
                    <div class="nt-card-head">
                        <h5><i class="bi bi-graph-up text-primary me-2"></i>Quick Weight Update</h5>
                        <p>Update only your latest weight to keep your calorie target accurate.</p>
                    </div>

                    <div class="nt-card-body">
                        <form action="{{ route('profile.weight') }}" method="POST">
                            @csrf

                            <div class="row g-2">
                                <div class="col">
                                    <input type="number"
                                           step="0.1"
                                           name="weight_kg"
                                           value="{{ $profile->weight_kg }}"
                                           class="form-control"
                                           placeholder="kg"
                                           required>
                                </div>

                                <div class="col-auto">
                                    <button type="submit" class="submit-btn px-4" style="width:auto;">
                                        Update
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
        </div>

    </div>
</div>
@endsection