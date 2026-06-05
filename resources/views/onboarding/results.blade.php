@extends('layouts.app')
@section('title', 'Your Results — NutriTrack')

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
    --text:#0F172A;
    --muted:#64748B;
    --card:rgba(255,255,255,.9);
    --shadow:0 24px 70px rgba(23,107,255,.12);
    --shadow-soft:0 14px 40px rgba(15,23,42,.07);
}

body {
    background:
        radial-gradient(circle at 12% 12%, rgba(32,199,255,.14), transparent 26%),
        radial-gradient(circle at 90% 6%, rgba(23,107,255,.13), transparent 28%),
        linear-gradient(135deg, #F8FBFF 0%, #EEF5FF 52%, #F9FCFF 100%);
}

.result-page {
    min-height: calc(100vh - 140px);
    display: grid;
    place-items: center;
    padding: 2rem 0;
}

.result-wrap {
    width: min(100%, 1050px);
    display: grid;
    grid-template-columns: 1.05fr .95fr;
    gap: 1.2rem;
    align-items: stretch;
}

.result-hero {
    position: relative;
    overflow: hidden;
    border-radius: 36px;
    padding: 2rem;
    color: white;
    background:
        radial-gradient(circle at 20% 20%, rgba(32,199,255,.35), transparent 28%),
        linear-gradient(135deg, #071B46 0%, #0B3D91 48%, #176BFF 100%);
    box-shadow: var(--shadow);
}

.result-hero::after {
    content:"";
    position:absolute;
    right:-120px;
    bottom:-130px;
    width:360px;
    height:360px;
    border-radius:50%;
    background:rgba(255,255,255,.1);
}

.result-hero-content {
    position: relative;
    z-index: 2;
}

.result-kicker {
    display: inline-flex;
    align-items: center;
    gap: .45rem;
    padding: .45rem .75rem;
    border-radius: 999px;
    background: rgba(255,255,255,.13);
    border: 1px solid rgba(255,255,255,.2);
    font-size: .72rem;
    font-weight: 900;
    letter-spacing: .08em;
    text-transform: uppercase;
    margin-bottom: 1rem;
}

.result-hero h1 {
    font-size: clamp(2.1rem, 4vw, 3.7rem);
    font-weight: 900;
    line-height: .98;
    letter-spacing: -.06em;
    margin-bottom: .8rem;
}

.result-hero p {
    color: rgba(255,255,255,.78);
    line-height: 1.75;
    margin-bottom: 1.2rem;
}

.result-steps {
    display: grid;
    gap: .7rem;
    margin-top: 1.2rem;
}

.result-step {
    display: flex;
    gap: .7rem;
    padding: .85rem;
    border-radius: 20px;
    background: rgba(255,255,255,.12);
    border: 1px solid rgba(255,255,255,.16);
    backdrop-filter: blur(10px);
}

.step-num {
    width: 28px;
    height: 28px;
    border-radius: 10px;
    display: grid;
    place-items: center;
    background: rgba(255,255,255,.18);
    font-size: .8rem;
    font-weight: 900;
    flex-shrink: 0;
}

.result-step strong {
    display: block;
    font-size: .88rem;
}

.result-step span {
    display: block;
    color: rgba(255,255,255,.72);
    font-size: .78rem;
    margin-top: .1rem;
}

.result-card {
    background: var(--card);
    border: 1px solid rgba(23,107,255,.1);
    border-radius: 36px;
    box-shadow: var(--shadow-soft);
    overflow: hidden;
    backdrop-filter: blur(18px);
}

.result-card-head {
    padding: 2rem 2rem 1rem;
    text-align: center;
}

.result-icon {
    width: 68px;
    height: 68px;
    margin: 0 auto .9rem;
    border-radius: 24px;
    display: grid;
    place-items: center;
    background: linear-gradient(135deg, var(--blue), var(--blue-dark));
    color: white;
    font-size: 1.8rem;
    box-shadow: 0 18px 40px rgba(23,107,255,.3);
}

.result-card-head h2 {
    margin: 0;
    color: var(--text);
    font-weight: 900;
    letter-spacing: -.04em;
}

.result-card-head p {
    color: var(--muted);
    margin: .4rem 0 0;
    line-height: 1.6;
}

.result-body {
    padding: 1rem 2rem 2rem;
}

.result-metrics {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: .8rem;
    margin-bottom: 1rem;
}

.metric-card {
    border-radius: 24px;
    padding: 1rem;
    background: #F8FBFF;
    border: 1px solid rgba(23,107,255,.08);
    text-align: center;
}

.metric-label {
    color: var(--muted);
    font-size: .7rem;
    font-weight: 900;
    letter-spacing: .08em;
    text-transform: uppercase;
}

.metric-value {
    font-size: 2rem;
    font-weight: 900;
    letter-spacing: -.06em;
    line-height: 1;
    margin-top: .5rem;
}

.metric-unit {
    color: var(--muted);
    font-size: .78rem;
    font-weight: 700;
    margin-top: .25rem;
}

.target-card {
    border-radius: 28px;
    padding: 1.25rem;
    color: white;
    text-align: center;
    background:
        radial-gradient(circle at 90% 20%, rgba(255,255,255,.2), transparent 30%),
        linear-gradient(135deg, var(--green), #15803D);
    margin-bottom: 1rem;
}

.target-card .metric-label {
    color: rgba(255,255,255,.75);
}

.target-card .metric-value {
    font-size: 3rem;
}

.target-card .metric-unit {
    color: rgba(255,255,255,.75);
}

.notice-box {
    border-radius: 24px;
    padding: 1rem;
    background: var(--orange-soft);
    color: #9A3412;
    font-size: .86rem;
    line-height: 1.6;
    margin-bottom: 1rem;
}

.action-btn {
    width: 100%;
    min-height: 52px;
    border: 0;
    border-radius: 18px;
    background: linear-gradient(135deg, var(--blue), var(--blue-dark));
    color: white;
    font-weight: 900;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: .5rem;
    text-decoration: none;
    transition: .18s ease;
}

.action-btn:hover {
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 16px 36px rgba(23,107,255,.24);
}

.secondary-link {
    display: block;
    text-align: center;
    margin-top: 1rem;
    color: var(--muted);
    text-decoration: none;
    font-weight: 800;
    font-size: .88rem;
}

.secondary-link:hover {
    color: var(--blue);
}

@media(max-width: 1000px) {
    .result-wrap {
        grid-template-columns: 1fr;
    }
}

@media(max-width: 575px) {
    .result-metrics {
        grid-template-columns: 1fr;
    }

    .result-card-head,
    .result-body {
        padding-left: 1.25rem;
        padding-right: 1.25rem;
    }
}
</style>
@endpush

@section('content')
@php
    $bmr = $data['bmr'] ?? 0;
    $tdee = $data['tdee'] ?? null;
    $dcr = $data['dcr'] ?? 0;
@endphp

<div class="container result-page">
    <div class="result-wrap">

        <aside class="result-hero">
            <div class="result-hero-content">
                <div class="result-kicker">
                    <i class="bi bi-check-circle-fill"></i>
                    Your Starter Result
                </div>

                <h1>Your calorie target is ready.</h1>

                <p>
                    NutriTrack has estimated your calorie needs. Create an account to save this profile and unlock personalized meal recommendations.
                </p>

                <div class="result-steps">
                    <div class="result-step">
                        <div class="step-num">1</div>
                        <div>
                            <strong>Save your profile</strong>
                            <span>Your results can be reused in Health Profile.</span>
                        </div>
                    </div>

                    <div class="result-step">
                        <div class="step-num">2</div>
                        <div>
                            <strong>Get Daily Plan</strong>
                            <span>Receive one ready-to-follow daily meal plan.</span>
                        </div>
                    </div>

                    <div class="result-step">
                        <div class="step-num">3</div>
                        <div>
                            <strong>Use Daily Picks</strong>
                            <span>Choose meals based on cuisine, allergy, and calorie target.</span>
                        </div>
                    </div>
                </div>
            </div>
        </aside>

        <section class="result-card">
            <div class="result-card-head">
                <div class="result-icon">📊</div>
                <h2>Your Personal Results</h2>
                <p>These values are estimated from your starter quiz answers.</p>
            </div>

            <div class="result-body">
                <div class="result-metrics">
                    <div class="metric-card">
                        <div class="metric-label">BMR</div>
                        <div class="metric-value text-primary">{{ number_format($bmr) }}</div>
                        <div class="metric-unit">kcal/day at rest</div>
                    </div>

                    <div class="metric-card">
                        <div class="metric-label">TDEE</div>
                        <div class="metric-value" style="color:var(--purple);">
                            {{ $tdee ? number_format($tdee) : '—' }}
                        </div>
                        <div class="metric-unit">activity-adjusted estimate</div>
                    </div>
                </div>

                <div class="target-card">
                    <div class="metric-label">Recommended Daily Target</div>
                    <div class="metric-value">{{ number_format($dcr) }}</div>
                    <div class="metric-unit">kcal/day</div>
                </div>

                <div class="notice-box">
                    <i class="bi bi-info-circle-fill me-1"></i>
                    This is a starter estimate. After registration, you can update your Health Profile, allergies, and preferred cuisine to improve meal recommendations.
                </div>

                <a href="{{ route('register') }}" class="action-btn">
                    <i class="bi bi-unlock-fill"></i>
                    Unlock My Personalized Plan
                </a>

                <a href="{{ route('guest.quiz') }}" class="secondary-link">
                    <i class="bi bi-arrow-left me-1"></i>
                    Retake Quiz
                </a>
            </div>
        </section>

    </div>
</div>
@endsection