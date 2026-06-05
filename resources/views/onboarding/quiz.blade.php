@extends('layouts.app')
@section('title', 'Get Started — NutriTrack')

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

.quiz-page {
    min-height: calc(100vh - 140px);
    display: grid;
    place-items: center;
    padding: 2rem 0;
}

.quiz-wrap {
    width: min(100%, 1080px);
    display: grid;
    grid-template-columns: .85fr 1.15fr;
    gap: 1.2rem;
    align-items: stretch;
}

.quiz-info {
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

.quiz-info::after {
    content:"";
    position:absolute;
    right:-120px;
    bottom:-130px;
    width:360px;
    height:360px;
    border-radius:50%;
    background:rgba(255,255,255,.1);
}

.quiz-info-content {
    position: relative;
    z-index: 2;
}

.quiz-kicker {
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

.quiz-info h1 {
    font-size: clamp(2.2rem, 4vw, 3.8rem);
    font-weight: 900;
    line-height: .98;
    letter-spacing: -.06em;
    margin-bottom: .8rem;
}

.quiz-info p {
    color: rgba(255,255,255,.78);
    line-height: 1.75;
    margin-bottom: 1.2rem;
}

.quiz-benefits {
    display: grid;
    gap: .7rem;
    margin-top: 1.2rem;
}

.quiz-benefit {
    display: flex;
    align-items: center;
    gap: .65rem;
    padding: .8rem;
    border-radius: 20px;
    background: rgba(255,255,255,.12);
    border: 1px solid rgba(255,255,255,.16);
    backdrop-filter: blur(10px);
    font-weight: 800;
    color: rgba(255,255,255,.9);
    font-size: .88rem;
}

.quiz-shell {
    background: var(--card);
    border: 1px solid rgba(23,107,255,.1);
    border-radius: 36px;
    box-shadow: var(--shadow-soft);
    overflow: hidden;
    backdrop-filter: blur(18px);
}

.quiz-progress-bar {
    height: 7px;
    background: #E5EFFF;
}

.quiz-progress-fill {
    height: 100%;
    background: linear-gradient(90deg, var(--blue), var(--cyan));
    transition: width .35s ease;
    border-radius: 0 999px 999px 0;
}

.quiz-step {
    display: none;
}

.quiz-step.active {
    display: block;
    animation: fadeSlide .25s ease both;
}

@keyframes fadeSlide {
    from {
        opacity: 0;
        transform: translateY(12px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.quiz-header {
    padding: 2rem 2.2rem 1rem;
    text-align: center;
}

.quiz-step-label {
    display: inline-flex;
    align-items: center;
    gap: .4rem;
    padding: .35rem .7rem;
    border-radius: 999px;
    background: var(--blue-soft);
    color: var(--blue);
    font-size: .7rem;
    font-weight: 900;
    letter-spacing: .08em;
    text-transform: uppercase;
    margin-bottom: .8rem;
}

.quiz-question {
    font-size: clamp(1.6rem, 3vw, 2.15rem);
    font-weight: 900;
    letter-spacing: -.05em;
    color: var(--text);
    line-height: 1.1;
    margin-bottom: .4rem;
}

.quiz-subtext {
    color: var(--muted);
    font-size: .92rem;
    line-height: 1.6;
}

.quiz-cards {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: .8rem;
    padding: .6rem 2.2rem 1.4rem;
}

.quiz-cards.single {
    grid-template-columns: 1fr;
}

.quiz-cards.cuisine-grid {
    grid-template-columns: repeat(5, 1fr);
}

.quiz-card {
    min-height: 108px;
    border: 1px solid rgba(23,107,255,.12);
    border-radius: 24px;
    padding: 1rem;
    cursor: pointer;
    transition: .18s ease;
    background: #F8FBFF;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: .4rem;
    text-align: center;
    position: relative;
}

.quiz-cards.single .quiz-card {
    min-height: 82px;
    flex-direction: row;
    justify-content: flex-start;
    text-align: left;
    gap: .85rem;
}

.quiz-card:hover {
    transform: translateY(-3px);
    background: var(--blue-soft);
}

.quiz-card.selected {
    background: linear-gradient(135deg, var(--blue), var(--blue-dark));
    color: white;
    box-shadow: 0 14px 34px rgba(23,107,255,.25);
}

.quiz-card.selected .qc-sub,
.quiz-card.selected .qc-label {
    color: white;
}

.quiz-card.selected::after {
    content: "✓";
    position: absolute;
    top: .7rem;
    right: .8rem;
    width: 24px;
    height: 24px;
    border-radius: 50%;
    display: grid;
    place-items: center;
    background: rgba(255,255,255,.2);
    color: white;
    font-weight: 900;
}

.qc-icon {
    font-size: 2rem;
    line-height: 1;
}

.qc-label {
    color: var(--text);
    font-size: .9rem;
    font-weight: 900;
}

.qc-sub {
    color: var(--muted);
    font-size: .75rem;
    line-height: 1.35;
}

.quiz-inputs {
    padding: .6rem 2.2rem 1.4rem;
}

.quiz-input-group {
    display: flex;
    align-items: center;
    gap: .8rem;
    background: #F8FBFF;
    border: 1px solid rgba(23,107,255,.14);
    border-radius: 22px;
    padding: .95rem 1rem;
    margin-bottom: .8rem;
    transition: .18s ease;
}

.quiz-input-group:focus-within {
    background: white;
    border-color: var(--blue);
    box-shadow: 0 0 0 4px rgba(23,107,255,.1);
}

.qig-icon {
    width: 42px;
    height: 42px;
    border-radius: 16px;
    display: grid;
    place-items: center;
    background: var(--blue-soft);
    font-size: 1.3rem;
    flex-shrink: 0;
}

.qig-label {
    width: 86px;
    color: var(--muted);
    font-size: .75rem;
    font-weight: 900;
    text-transform: uppercase;
    letter-spacing: .07em;
    flex-shrink: 0;
}

.quiz-input-group input,
.quiz-input-group select {
    flex: 1;
    border: none;
    background: transparent;
    color: var(--text);
    font-size: 1rem;
    font-weight: 800;
    outline: none;
    min-width: 0;
}

.unit {
    color: var(--muted);
    font-size: .82rem;
    font-weight: 800;
}

.optional-box {
    border-top: 1px solid rgba(23,107,255,.08);
    padding-top: 1rem;
    margin-top: .5rem;
}

.optional-title {
    color: var(--blue);
    font-size: .72rem;
    font-weight: 900;
    letter-spacing: .08em;
    text-transform: uppercase;
    margin-bottom: .7rem;
}

.quiz-nav {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: .8rem;
    padding: 1.1rem 2.2rem;
    border-top: 1px solid rgba(23,107,255,.08);
    background: rgba(248,251,255,.75);
}

.btn-quiz-back,
.btn-quiz-next {
    min-height: 46px;
    border-radius: 999px;
    padding: .7rem 1.3rem;
    font-size: .88rem;
    font-weight: 900;
    transition: .18s ease;
}

.btn-quiz-back {
    background: white;
    color: var(--muted);
    border: 1px solid rgba(23,107,255,.12);
}

.btn-quiz-back:hover {
    color: var(--blue);
    border-color: var(--blue);
}

.btn-quiz-next {
    background: linear-gradient(135deg, var(--blue), var(--blue-dark));
    color: white;
    border: 0;
    box-shadow: 0 14px 30px rgba(23,107,255,.22);
}

.btn-quiz-next:hover {
    transform: translateY(-2px);
}

.btn-quiz-next:disabled {
    opacity: .45;
    cursor: not-allowed;
    transform: none;
    box-shadow: none;
}

.summary-strip {
    display: flex;
    flex-wrap: wrap;
    gap: .45rem;
    padding: 0 2.2rem 1rem;
    justify-content: center;
}

.summary-pill {
    display: inline-flex;
    align-items: center;
    gap: .35rem;
    padding: .45rem .7rem;
    border-radius: 999px;
    background: var(--blue-soft);
    color: var(--blue-dark);
    font-size: .75rem;
    font-weight: 900;
}

@media(max-width: 1100px) {
    .quiz-wrap {
        grid-template-columns: 1fr;
    }

    .quiz-info {
        display: none;
    }
}

@media(max-width: 768px) {
    .quiz-cards,
    .quiz-cards.cuisine-grid {
        grid-template-columns: 1fr;
    }

    .quiz-header,
    .quiz-inputs,
    .quiz-nav,
    .summary-strip {
        padding-left: 1.25rem;
        padding-right: 1.25rem;
    }

    .quiz-input-group {
        align-items: flex-start;
        flex-direction: column;
    }

    .qig-label {
        width: auto;
    }

    .quiz-nav {
        flex-direction: column;
    }

    .btn-quiz-back,
    .btn-quiz-next {
        width: 100%;
    }
}
/* Make example placeholder clearly different from real user input */
.quiz-input-group input::placeholder,
.quiz-input-group textarea::placeholder {
    color: #A8B3C7;
    font-weight: 500;
    opacity: 1;
    font-style: italic;
}

.quiz-input-group input:focus::placeholder {
    color: #CBD5E1;
}

.quiz-input-group input,
.quiz-input-group select {
    color: var(--text);
    font-weight: 900;
}
</style>
@endpush

@section('content')
<div class="container quiz-page">
    <div class="quiz-wrap">

        <aside class="quiz-info">
            <div class="quiz-info-content">
                <div class="quiz-kicker">
                    <i class="bi bi-stars"></i>
                    NutriTrack Starter Quiz
                </div>

                <h1>Build your first calorie plan in minutes.</h1>

                <p>
                    Answer a few questions so NutriTrack can estimate your BMR, TDEE, and daily calorie target before you create an account.
                </p>

                <div class="quiz-benefits">
                    <div class="quiz-benefit">🎯 Personalized calorie target</div>
                    <div class="quiz-benefit">🥗 Better meal recommendations</div>
                    <div class="quiz-benefit">🌿 Allergy and cuisine preference support</div>
                    <div class="quiz-benefit">📘 Save your plan after registration</div>
                </div>
            </div>
        </aside>

        <section class="quiz-shell">
            <div class="quiz-progress-bar">
                <div class="quiz-progress-fill" id="quiz-progress" style="width:16.6%;"></div>
            </div>

            <form id="quiz-form" action="{{ route('guest.calculate') }}" method="POST">
                @csrf

                {{-- STEP 1 --}}
                <div class="quiz-step active" id="step-1">
                    <div class="quiz-header">
                        <div class="quiz-step-label">Step 1 of 6</div>
                        <div class="quiz-question">What is your biological sex?</div>
                        <div class="quiz-subtext">This is used only for the BMR formula calculation.</div>
                    </div>

                    <div class="quiz-cards">
                        <div class="quiz-card" data-field="gender" data-value="male" data-label="Male" onclick="selectCard(this)">
                            <span class="qc-icon">👨</span>
                            <span class="qc-label">Male</span>
                        </div>

                        <div class="quiz-card" data-field="gender" data-value="female" data-label="Female" onclick="selectCard(this)">
                            <span class="qc-icon">👩</span>
                            <span class="qc-label">Female</span>
                        </div>
                    </div>

                    <input type="hidden" name="gender" id="val-gender">

                    <div class="summary-strip" id="summary-strip"></div>

                    <div class="quiz-nav">
                        <div></div>
                        <button type="button" class="btn-quiz-next" id="next-1" disabled onclick="nextStep(1)">
                            Continue <i class="bi bi-arrow-right ms-1"></i>
                        </button>
                    </div>
                </div>

                {{-- STEP 2 --}}
                <div class="quiz-step" id="step-2">
                    <div class="quiz-header">
                        <div class="quiz-step-label">Step 2 of 6</div>
                        <div class="quiz-question">How old are you?</div>
                        <div class="quiz-subtext">Age affects your calorie needs and metabolic rate.</div>
                    </div>

                    <div class="quiz-inputs">
                        <div class="quiz-input-group">
                            <span class="qig-icon">🎂</span>
                            <span class="qig-label">Age</span>
                            <input type="number"
                                   name="age"
                                   id="val-age"
                                   min="12"
                                   max="100"
                                   placeholder="Example: 22"
                                   oninput="validateNumberStep('val-age','next-2',12,100)">
                            <span class="unit">years</span>
                        </div>
                    </div>

                    <div class="summary-strip" id="summary-strip-2"></div>

                    <div class="quiz-nav">
                        <button type="button" class="btn-quiz-back" onclick="prevStep(2)">
                            <i class="bi bi-arrow-left me-1"></i> Back
                        </button>

                        <button type="button" class="btn-quiz-next" id="next-2" disabled onclick="nextStep(2)">
                            Continue <i class="bi bi-arrow-right ms-1"></i>
                        </button>
                    </div>
                </div>

                {{-- STEP 3 --}}
                <div class="quiz-step" id="step-3">
                    <div class="quiz-header">
                        <div class="quiz-step-label">Step 3 of 6</div>
                        <div class="quiz-question">How active are you?</div>
                        <div class="quiz-subtext">Choose the option closest to your weekly routine.</div>
                    </div>

                    <div class="quiz-cards single">
                        @foreach([
                            ['sedentary', '🪑', 'Sedentary', 'Little or no exercise'],
                            ['lightly_active', '🚶', 'Lightly Active', '1 to 3 days per week'],
                            ['moderately_active', '🏃', 'Moderately Active', '3 to 5 days per week'],
                            ['very_active', '💪', 'Very Active', '6 to 7 days per week'],
                            ['extra_active', '🏋️', 'Extra Active', 'Physical job or intense training'],
                        ] as [$val, $icon, $label, $sub])
                            <div class="quiz-card" data-field="activity_level" data-value="{{ $val }}" data-label="{{ $label }}" onclick="selectCard(this)">
                                <span class="qc-icon">{{ $icon }}</span>
                                <div>
                                    <div class="qc-label">{{ $label }}</div>
                                    <div class="qc-sub">{{ $sub }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <input type="hidden" name="activity_level" id="val-activity_level">

                    <div class="summary-strip" id="summary-strip-3"></div>

                    <div class="quiz-nav">
                        <button type="button" class="btn-quiz-back" onclick="prevStep(3)">
                            <i class="bi bi-arrow-left me-1"></i> Back
                        </button>

                        <button type="button" class="btn-quiz-next" id="next-3" disabled onclick="nextStep(3)">
                            Continue <i class="bi bi-arrow-right ms-1"></i>
                        </button>
                    </div>
                </div>

                {{-- STEP 4 --}}
                <div class="quiz-step" id="step-4">
                    <div class="quiz-header">
                        <div class="quiz-step-label">Step 4 of 6</div>
                        <div class="quiz-question">What is your main goal?</div>
                        <div class="quiz-subtext">This will adjust your daily calorie target.</div>
                    </div>

                    <div class="quiz-cards single">
                        @foreach([
                            ['lose_weight', '📉', 'Lose Weight', 'Creates a calorie deficit'],
                            ['maintain', '⚖️', 'Maintain Weight', 'Keeps calories balanced'],
                            ['gain_weight', '📈', 'Gain Weight', 'Creates a calorie surplus'],
                        ] as [$val, $icon, $label, $sub])
                            <div class="quiz-card" data-field="goal" data-value="{{ $val }}" data-label="{{ $label }}" onclick="selectCard(this)">
                                <span class="qc-icon">{{ $icon }}</span>
                                <div>
                                    <div class="qc-label">{{ $label }}</div>
                                    <div class="qc-sub">{{ $sub }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <input type="hidden" name="goal" id="val-goal">

                    <div class="summary-strip" id="summary-strip-4"></div>

                    <div class="quiz-nav">
                        <button type="button" class="btn-quiz-back" onclick="prevStep(4)">
                            <i class="bi bi-arrow-left me-1"></i> Back
                        </button>

                        <button type="button" class="btn-quiz-next" id="next-4" disabled onclick="nextStep(4)">
                            Continue <i class="bi bi-arrow-right ms-1"></i>
                        </button>
                    </div>
                </div>

                {{-- STEP 5 --}}
                <div class="quiz-step" id="step-5">
                    <div class="quiz-header">
                        <div class="quiz-step-label">Step 5 of 6</div>
                        <div class="quiz-question">Enter your body measurements.</div>
                        <div class="quiz-subtext">These values make your calorie calculation more accurate.</div>
                    </div>

                    <div class="quiz-inputs">
                        <div class="quiz-input-group">
                            <span class="qig-icon">⚖️</span>
                            <span class="qig-label">Weight</span>
                            <input type="number"
                                   name="weight_kg"
                                   id="val-weight"
                                   step="0.1"
                                   min="20"
                                   max="300"
                                   placeholder="Example: 65.5"
                                   oninput="checkStep5()">
                            <span class="unit">kg</span>
                        </div>

                        <div class="quiz-input-group">
                            <span class="qig-icon">📏</span>
                            <span class="qig-label">Height</span>
                            <input type="number"
                                   name="height_cm"
                                   id="val-height"
                                   step="0.1"
                                   min="100"
                                   max="250"
                                   placeholder="Example: 165"
                                   oninput="checkStep5()">
                            <span class="unit">cm</span>
                        </div>
                    </div>

                    <div class="summary-strip" id="summary-strip-5"></div>

                    <div class="quiz-nav">
                        <button type="button" class="btn-quiz-back" onclick="prevStep(5)">
                            <i class="bi bi-arrow-left me-1"></i> Back
                        </button>

                        <button type="button" class="btn-quiz-next" id="next-5" disabled onclick="nextStep(5)">
                            Continue <i class="bi bi-arrow-right ms-1"></i>
                        </button>
                    </div>
                </div>

                {{-- STEP 6 --}}
                <div class="quiz-step" id="step-6">
                    <div class="quiz-header">
                        <div class="quiz-step-label">Step 6 of 6</div>
                        <div class="quiz-question">Set your food preferences.</div>
                        <div class="quiz-subtext">These are optional, but they help personalize recommendations later.</div>
                    </div>

                    <div class="quiz-inputs">
                        <div class="quiz-input-group">
                            <span class="qig-icon">🌿</span>
                            <span class="qig-label">Allergies</span>
                            <input type="text"
                                   name="allergies"
                                   placeholder="Example: nuts, dairy, shellfish">
                        </div>

                        <div class="optional-box">
                            <div class="optional-title">Preferred Cuisine</div>

                            <div class="quiz-cards cuisine-grid" style="padding:0;">
                                @foreach([
                                    ['Malay', '🍛'],
                                    ['Chinese', '🥢'],
                                    ['Indian', '🫓'],
                                    ['Western', '🥗'],
                                    ['Middle Eastern', '🧆'],
                                ] as [$cuisine, $icon])
                                    <div class="quiz-card" data-field="preferred_cuisine" data-value="{{ $cuisine }}" data-label="{{ $cuisine }}" onclick="selectCard(this)">
                                        <span class="qc-icon">{{ $icon }}</span>
                                        <span class="qc-label">{{ $cuisine }}</span>
                                    </div>
                                @endforeach
                            </div>

                            <input type="hidden" name="preferred_cuisine" id="val-preferred_cuisine" value="No preference">
                        </div>
                    </div>

                    <div class="summary-strip" id="summary-strip-6"></div>

                    <div class="quiz-nav">
                        <button type="button" class="btn-quiz-back" onclick="prevStep(6)">
                            <i class="bi bi-arrow-left me-1"></i> Back
                        </button>

                        <button type="submit" class="btn-quiz-next" id="next-6">
                            <i class="bi bi-calculator me-1"></i>
                            Calculate My Plan
                        </button>
                    </div>
                </div>

            </form>
        </section>
    </div>
</div>
@endsection

@push('scripts')
<script>
let currentStep = 1;
const totalSteps = 6;

const selectedLabels = {};

function selectCard(card) {
    const field = card.getAttribute('data-field');
    const value = card.getAttribute('data-value');
    const label = card.getAttribute('data-label') || value;

    card.closest('.quiz-step').querySelectorAll(`.quiz-card[data-field="${field}"]`).forEach(c => {
        c.classList.remove('selected');
    });

    card.classList.add('selected');

    const input = document.getElementById('val-' + field);
    if (input) {
        input.value = value;
    }

    selectedLabels[field] = label;

    const nextButton = document.getElementById('next-' + currentStep);
    if (nextButton) {
        nextButton.disabled = false;
    }

    renderSummary();
}

function validateNumberStep(id, btnId, min, max) {
    const val = parseFloat(document.getElementById(id).value);
    document.getElementById(btnId).disabled = !(val >= min && val <= max);

    if (id === 'val-age' && val >= min && val <= max) {
        selectedLabels.age = val + ' years';
    }

    renderSummary();
}

function checkStep5() {
    const w = parseFloat(document.getElementById('val-weight').value);
    const h = parseFloat(document.getElementById('val-height').value);

    document.getElementById('next-5').disabled = !(w >= 20 && w <= 300 && h >= 100 && h <= 250);

    if (w >= 20 && w <= 300) {
        selectedLabels.weight = w + ' kg';
    }

    if (h >= 100 && h <= 250) {
        selectedLabels.height = h + ' cm';
    }

    renderSummary();
}

function nextStep(step) {
    document.getElementById('step-' + step).classList.remove('active');
    currentStep = step + 1;
    document.getElementById('step-' + currentStep).classList.add('active');
    updateProgress();
    renderSummary();
}

function prevStep(step) {
    document.getElementById('step-' + step).classList.remove('active');
    currentStep = step - 1;
    document.getElementById('step-' + currentStep).classList.add('active');
    updateProgress();
    renderSummary();
}

function updateProgress() {
    const pct = (currentStep / totalSteps) * 100;
    document.getElementById('quiz-progress').style.width = pct + '%';
}

function renderSummary() {
    const target = document.getElementById('summary-strip-' + currentStep) || document.getElementById('summary-strip');

    if (!target) return;

    const items = [];

    if (selectedLabels.gender) items.push('👤 ' + selectedLabels.gender);
    if (selectedLabels.age) items.push('🎂 ' + selectedLabels.age);
    if (selectedLabels.activity_level) items.push('🏃 ' + selectedLabels.activity_level);
    if (selectedLabels.goal) items.push('🎯 ' + selectedLabels.goal);
    if (selectedLabels.weight) items.push('⚖️ ' + selectedLabels.weight);
    if (selectedLabels.height) items.push('📏 ' + selectedLabels.height);
    if (selectedLabels.preferred_cuisine) items.push('🍜 ' + selectedLabels.preferred_cuisine);

    target.innerHTML = items.map(item => `<span class="summary-pill">${item}</span>`).join('');
}
</script>
@endpush