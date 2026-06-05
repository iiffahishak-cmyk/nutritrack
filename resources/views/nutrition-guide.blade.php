@extends('layouts.app')
@section('title', 'Nutrition Guide — NutriTrack')

@push('styles')
<style>
:root {
    --blue:#176BFF;
    --blue-dark:#0B3D91;
    --blue-soft:#EAF2FF;
    --cyan:#20C7FF;
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
    --card:rgba(255,255,255,.86);
    --shadow:0 20px 55px rgba(15,23,42,.08);
}

.guide-page {
    position: relative;
}

.guide-page::before {
    content:"";
    position:fixed;
    inset:0;
    pointer-events:none;
    background-image:
        linear-gradient(rgba(23,107,255,.04) 1px, transparent 1px),
        linear-gradient(90deg, rgba(23,107,255,.04) 1px, transparent 1px);
    background-size:58px 58px;
    mask-image:linear-gradient(to bottom, rgba(0,0,0,.75), transparent 90%);
    z-index:-1;
}

.guide-hero {
    border-radius:38px;
    padding:clamp(1.4rem, 3vw, 2.4rem);
    color:white;
    background:
        radial-gradient(circle at 18% 20%, rgba(32,199,255,.38), transparent 28%),
        radial-gradient(circle at 92% 16%, rgba(255,255,255,.16), transparent 24%),
        linear-gradient(135deg, #071B46 0%, #0B3D91 48%, #176BFF 100%);
    box-shadow:0 24px 70px rgba(23,107,255,.12);
    margin-bottom:1.2rem;
    position:relative;
    overflow:hidden;
}

.guide-hero::after {
    content:"";
    position:absolute;
    right:-120px;
    bottom:-130px;
    width:380px;
    height:380px;
    border-radius:50%;
    background:rgba(255,255,255,.1);
}

.guide-hero-content {
    position:relative;
    z-index:2;
}

.guide-kicker {
    display:inline-flex;
    align-items:center;
    gap:.45rem;
    padding:.45rem .78rem;
    border-radius:999px;
    background:rgba(255,255,255,.13);
    border:1px solid rgba(255,255,255,.2);
    color:rgba(255,255,255,.88);
    font-size:.72rem;
    font-weight:900;
    letter-spacing:.08em;
    text-transform:uppercase;
    margin-bottom:.85rem;
}

.guide-hero h1 {
    font-family:'Playfair Display', serif;
    font-size:clamp(2rem, 4vw, 3.5rem);
    line-height:1;
    letter-spacing:-.045em;
    margin-bottom:.65rem;
}

.guide-hero p {
    color:rgba(255,255,255,.78);
    max-width:760px;
    line-height:1.7;
    margin:0;
    font-size:.95rem;
}

.guide-grid {
    display:grid;
    grid-template-columns:repeat(3, 1fr);
    gap:1rem;
    margin-bottom:1.2rem;
}

.guide-card {
    background:var(--card);
    border:1px solid rgba(23,107,255,.1);
    border-radius:30px;
    box-shadow:var(--shadow);
    padding:1.2rem;
    backdrop-filter:blur(18px);
    position:relative;
    overflow:hidden;
}

.guide-card::after {
    content:"";
    position:absolute;
    width:130px;
    height:130px;
    right:-70px;
    top:-70px;
    border-radius:50%;
    background:rgba(23,107,255,.08);
}

.guide-icon {
    width:50px;
    height:50px;
    border-radius:18px;
    display:grid;
    place-items:center;
    font-size:1.45rem;
    margin-bottom:.85rem;
    position:relative;
    z-index:2;
}

.guide-card h3 {
    font-size:1.05rem;
    font-weight:900;
    color:var(--text);
    margin-bottom:.45rem;
    position:relative;
    z-index:2;
}

.guide-card p {
    color:var(--muted);
    font-size:.88rem;
    line-height:1.7;
    margin:0;
    position:relative;
    z-index:2;
}

.example-box {
    margin-top:.85rem;
    border-radius:20px;
    padding:.85rem;
    background:#F8FBFF;
    border:1px solid rgba(23,107,255,.08);
    color:var(--text);
    font-size:.82rem;
    line-height:1.6;
    position:relative;
    z-index:2;
}

.section-panel {
    background:var(--card);
    border:1px solid rgba(23,107,255,.1);
    border-radius:34px;
    box-shadow:var(--shadow);
    padding:1.35rem;
    margin-bottom:1.2rem;
    backdrop-filter:blur(18px);
}

.section-title {
    font-weight:900;
    letter-spacing:-.04em;
    margin-bottom:.4rem;
    color:var(--text);
}

.section-sub {
    color:var(--muted);
    font-size:.9rem;
    line-height:1.7;
    margin-bottom:1rem;
}

.calorie-split-grid {
    display:grid;
    grid-template-columns:repeat(4, 1fr);
    gap:.8rem;
}

.split-card {
    border-radius:24px;
    padding:1rem;
    background:#F8FBFF;
    border:1px solid rgba(23,107,255,.08);
    text-align:center;
}

.split-percent {
    font-size:1.8rem;
    font-weight:900;
    line-height:1;
}

.split-label {
    color:var(--muted);
    font-size:.72rem;
    font-weight:900;
    letter-spacing:.08em;
    text-transform:uppercase;
    margin-top:.35rem;
}

.warning-box {
    border-radius:24px;
    padding:1rem;
    background:var(--orange-soft);
    color:#9A3412;
    line-height:1.7;
    font-size:.88rem;
}

.accordion-item {
    border:1px solid rgba(23,107,255,.1) !important;
    border-radius:22px !important;
    overflow:hidden;
    margin-bottom:.7rem;
    background:white;
}

.accordion-button {
    font-weight:900;
    color:var(--text);
    background:#F8FBFF;
    box-shadow:none !important;
}

.accordion-button:not(.collapsed) {
    background:var(--blue-soft);
    color:var(--blue-dark);
}

.accordion-body {
    color:var(--muted);
    line-height:1.7;
    font-size:.9rem;
}

@media(max-width:1100px) {
    .guide-grid {
        grid-template-columns:repeat(2, 1fr);
    }
}

@media(max-width:768px) {
    .guide-grid,
    .calorie-split-grid {
        grid-template-columns:1fr;
    }

    .guide-hero {
        border-radius:28px;
    }
}
</style>
@endpush

@section('content')
<div class="guide-page">

    <div class="guide-hero">
        <div class="guide-hero-content">
            <div class="guide-kicker">
                <i class="bi bi-book-fill"></i>
                Nutrition Guide
            </div>

            <h1>Understand your calorie target.</h1>

            <p>
                This guide explains the basic nutrition terms used in NutriTrack, such as BMI, BMR, TDEE, DCR,
                calorie deficit, calorie surplus, and meal calorie split. It helps users understand how the system
                calculates and uses their daily calorie target.
            </p>
        </div>
    </div>

    <div class="guide-grid">
        <div class="guide-card">
            <div class="guide-icon" style="background:var(--blue-soft);color:var(--blue);">
                ⚖️
            </div>
            <h3>BMI</h3>
            <p>
                BMI means Body Mass Index. It estimates whether a person’s weight is within a general healthy range based on height.
            </p>
            <div class="example-box">
                Formula: weight (kg) ÷ height² (m)
            </div>
        </div>

        <div class="guide-card">
            <div class="guide-icon" style="background:var(--green-soft);color:var(--green);">
                🔥
            </div>
            <h3>BMR</h3>
            <p>
                BMR means Basal Metabolic Rate. It estimates how many calories your body needs at rest for basic body functions.
            </p>
            <div class="example-box">
                Example: breathing, blood circulation, and body repair.
            </div>
        </div>

        <div class="guide-card">
            <div class="guide-icon" style="background:var(--purple-soft);color:var(--purple);">
                🏃
            </div>
            <h3>TDEE</h3>
            <p>
                TDEE means Total Daily Energy Expenditure. It estimates how many calories your body burns in a day including activity.
            </p>
            <div class="example-box">
                TDEE = BMR × activity level.
            </div>
        </div>

        <div class="guide-card">
            <div class="guide-icon" style="background:var(--orange-soft);color:var(--orange);">
                🎯
            </div>
            <h3>DCR</h3>
            <p>
                DCR means Daily Calorie Requirement. In NutriTrack, it is the calorie target adjusted based on the user’s goal.
            </p>
            <div class="example-box">
                Lose weight = lower target. Gain weight = higher target.
            </div>
        </div>

        <div class="guide-card">
            <div class="guide-icon" style="background:var(--red-soft);color:var(--red);">
                📉
            </div>
            <h3>Calorie Deficit</h3>
            <p>
                A calorie deficit happens when a person consumes fewer calories than their body uses. This is commonly linked with weight loss.
            </p>
            <div class="example-box">
                Example: eating below your TDEE consistently.
            </div>
        </div>

        <div class="guide-card">
            <div class="guide-icon" style="background:var(--green-soft);color:var(--green);">
                📈
            </div>
            <h3>Calorie Surplus</h3>
            <p>
                A calorie surplus happens when a person consumes more calories than their body uses. This is commonly linked with weight gain.
            </p>
            <div class="example-box">
                Example: eating above your TDEE consistently.
            </div>
        </div>
    </div>

    <div class="section-panel">
        <h2 class="section-title">How NutriTrack divides your daily calories</h2>
        <p class="section-sub">
            NutriTrack divides the user’s DCR into four meal times. This helps the system recommend meals based on
            meal-time calorie targets instead of choosing meals randomly.
        </p>

        <div class="calorie-split-grid">
            <div class="split-card">
                <div class="split-percent" style="color:var(--orange);">25%</div>
                <div class="split-label">Breakfast</div>
            </div>

            <div class="split-card">
                <div class="split-percent" style="color:var(--green);">35%</div>
                <div class="split-label">Lunch</div>
            </div>

            <div class="split-card">
                <div class="split-percent" style="color:var(--blue);">25%</div>
                <div class="split-label">Dinner</div>
            </div>

            <div class="split-card">
                <div class="split-percent" style="color:var(--purple);">15%</div>
                <div class="split-label">Snack</div>
            </div>
        </div>
    </div>

    <div class="section-panel">
        <h2 class="section-title">Why a meal plan may exceed the target</h2>

        <div class="warning-box">
            <i class="bi bi-info-circle-fill me-1"></i>
            Sometimes, a meal plan may exceed 100% of the daily target because the available meals in the database
            may not perfectly match the user’s calorie budget. For example, if the dinner target is 356 kcal but the closest
            available meal is 390 kcal, the system may still choose it because it is the most suitable option from the database.
            This can be improved by adding more meal records with different calorie ranges.
        </div>
    </div>

    <div class="section-panel">
        <h2 class="section-title">Frequently Asked Questions</h2>
        <p class="section-sub">
            These simple explanations help users understand how the recommendation system works.
        </p>

        <div class="accordion" id="guideAccordion">
            <div class="accordion-item">
                <h2 class="accordion-header" id="faqOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">
                        Why does NutriTrack ask for my weight and height?
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#guideAccordion">
                    <div class="accordion-body">
                        Weight and height are needed to calculate BMI, BMR, TDEE, DCR, and healthy weight range.
                        These values help NutriTrack estimate your calorie target more accurately.
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header" id="faqTwo">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo">
                        Why does preferred cuisine matter?
                    </button>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#guideAccordion">
                    <div class="accordion-body">
                        Preferred cuisine helps the system recommend meals that match your taste. For example, if the user prefers Malay cuisine,
                        Malay meals will receive higher priority in the recommendation score.
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header" id="faqThree">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree">
                        Why does NutriTrack need allergy information?
                    </button>
                </h2>
                <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#guideAccordion">
                    <div class="accordion-body">
                        Allergy information helps the system avoid meals that may contain unsuitable ingredients.
                        The system checks meal names, descriptions, and ingredients to reduce the chance of recommending risky meals.
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header" id="faqFour">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour">
                        What is the difference between Daily Plan and Meal Options?
                    </button>
                </h2>
                <div id="collapseFour" class="accordion-collapse collapse" data-bs-parent="#guideAccordion">
                    <div class="accordion-body">
                        Daily Plan gives one complete ready-to-follow menu for the day. Meal Options gives several alternative meals
                        that users can choose, refresh, rate, and save. Daily Plan is automatic, while Meal Options is more flexible.
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection