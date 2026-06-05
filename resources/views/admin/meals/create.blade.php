@extends('layouts.admin')
@section('title', 'Add New Meal — NutriTrack Admin')

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
    --red:#DC2626;
    --text:#0F172A;
    --muted:#64748B;
    --shadow:0 18px 45px rgba(15,23,42,.07);
}

.form-shell {
    max-width:1100px;
}

.page-hero {
    border-radius:30px;
    padding:1.5rem;
    color:white;
    background:linear-gradient(135deg,#071B46,#176BFF);
    margin-bottom:1.2rem;
    box-shadow:0 24px 65px rgba(23,107,255,.16);
}

.page-hero h1 {
    margin:0;
    font-weight:900;
    letter-spacing:-.05em;
}

.page-hero p {
    margin:.35rem 0 0;
    color:rgba(255,255,255,.78);
}

.panel {
    background:white;
    border:1px solid rgba(23,107,255,.1);
    border-radius:30px;
    box-shadow:var(--shadow);
    overflow:hidden;
}

.panel-head {
    padding:1.1rem 1.25rem;
    border-bottom:1px solid rgba(23,107,255,.08);
}

.panel-head h5 {
    margin:0;
    font-weight:900;
}

.panel-body {
    padding:1.25rem;
}

.form-label-modern {
    color:var(--muted);
    font-size:.72rem;
    font-weight:900;
    letter-spacing:.08em;
    text-transform:uppercase;
    margin-bottom:.45rem;
}

.form-control,
.form-select {
    border-radius:18px;
    border:1px solid rgba(23,107,255,.16);
    background:#F8FBFF;
    padding:.82rem .95rem;
    font-weight:700;
}

.form-control:focus,
.form-select:focus {
    background:white;
    border-color:var(--blue);
    box-shadow:0 0 0 4px rgba(23,107,255,.1);
}

.meal-time-grid,
.cuisine-grid {
    display:grid;
    grid-template-columns:repeat(4, 1fr);
    gap:.65rem;
}

.cuisine-grid {
    grid-template-columns:repeat(5, 1fr);
}

.option-card input {
    display:none;
}

.option-box {
    cursor:pointer;
    border-radius:20px;
    padding:.9rem .7rem;
    text-align:center;
    background:#F8FBFF;
    border:1px solid rgba(23,107,255,.1);
    transition:.18s ease;
    height:100%;
}

.option-box:hover {
    transform:translateY(-2px);
    background:var(--blue-soft);
}

.option-card input:checked + .option-box {
    background:linear-gradient(135deg,var(--blue),var(--blue-dark));
    color:white;
    box-shadow:0 14px 34px rgba(23,107,255,.25);
}

.option-icon {
    display:block;
    font-size:1.35rem;
    margin-bottom:.35rem;
}

.option-title {
    display:block;
    font-weight:900;
    font-size:.82rem;
}

.macro-card {
    border-radius:22px;
    padding:1rem;
    background:#F8FBFF;
    border:1px solid rgba(23,107,255,.08);
}

.macro-card input {
    background:white;
}

.help-box {
    border-radius:24px;
    padding:1rem;
    background:var(--blue-soft);
    color:var(--blue-dark);
    font-size:.86rem;
    line-height:1.6;
}

.submit-btn {
    min-height:52px;
    border:0;
    border-radius:999px;
    background:linear-gradient(135deg,var(--blue),var(--blue-dark));
    color:white;
    font-weight:900;
    padding:.8rem 1.5rem;
    transition:.2s ease;
}

.submit-btn:hover {
    transform:translateY(-2px);
    color:white;
}

@media(max-width:991px) {
    .meal-time-grid,
    .cuisine-grid {
        grid-template-columns:repeat(2, 1fr);
    }
}

@media(max-width:575px) {
    .meal-time-grid,
    .cuisine-grid {
        grid-template-columns:1fr;
    }
}
</style>
@endpush

@section('content')
<div class="container-fluid py-2 form-shell">

    <div class="page-hero">
        <div class="d-flex justify-content-between align-items-center gap-3 flex-wrap">
            <div>
                <div style="font-size:.72rem;font-weight:900;letter-spacing:.08em;text-transform:uppercase;opacity:.8;">
                    Meal Database
                </div>
                <h1>Add New Meal</h1>
                <p>Create a verified meal record for NutriTrack recommendations.</p>
            </div>

            <a href="{{ route('admin.meals.index') }}" class="btn btn-light rounded-pill fw-bold px-4">
                <i class="bi bi-arrow-left me-1"></i>
                Back to Meals
            </a>
        </div>
    </div>

    @if($errors->any())
        <div class="alert alert-danger border-0 shadow-sm rounded-4 mb-4">
            <strong>Please check the form:</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.meals.store') }}" method="POST">
        @csrf

        <div class="row g-4">
            <div class="col-12 col-xl-7">
                <div class="panel mb-4">
                    <div class="panel-head">
                        <h5><i class="bi bi-info-circle text-primary me-2"></i>Basic Information</h5>
                    </div>

                    <div class="panel-body">
                        <div class="mb-4">
                            <label class="form-label-modern">Meal Name</label>
                            <input type="text"
                                   name="meal_name"
                                   value="{{ old('meal_name') }}"
                                   class="form-control"
                                   placeholder="Example: Nasi Lemak with Boiled Egg"
                                   required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label-modern">Description</label>
                            <textarea name="description"
                                      class="form-control"
                                      rows="4"
                                      placeholder="Briefly describe the meal, ingredients, or health value.">{{ old('description') }}</textarea>
                        </div>

                        <div>
                            <label class="form-label-modern">Ingredients</label>
                            <input type="text"
                                   name="ingredients"
                                   value="{{ old('ingredients') }}"
                                   class="form-control"
                                   placeholder="Example: rice, coconut milk, egg, cucumber, sambal">

                            <small class="text-muted d-block mt-2">
                                Use commas to separate ingredients. This helps allergy filtering.
                            </small>
                        </div>
                    </div>
                </div>

                <div class="panel">
                    <div class="panel-head">
                        <h5><i class="bi bi-bar-chart text-primary me-2"></i>Nutritional Values</h5>
                    </div>

                    <div class="panel-body">
                        <div class="row g-3">
                            @foreach([
                                'calories' => ['label' => 'Calories', 'unit' => 'kcal', 'color' => 'var(--blue)'],
                                'protein' => ['label' => 'Protein', 'unit' => 'g', 'color' => 'var(--purple)'],
                                'carbs' => ['label' => 'Carbs', 'unit' => 'g', 'color' => 'var(--orange)'],
                                'fat' => ['label' => 'Fat', 'unit' => 'g', 'color' => 'var(--red)'],
                            ] as $field => $meta)
                                <div class="col-6 col-md-3">
                                    <div class="macro-card">
                                        <label class="form-label-modern">{{ $meta['label'] }} ({{ $meta['unit'] }})</label>
                                        <input type="number"
                                               step="0.1"
                                               name="{{ $field }}"
                                               value="{{ old($field) }}"
                                               class="form-control"
                                               placeholder="0"
                                               required>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="help-box mt-3">
                            <i class="bi bi-lightbulb-fill me-1"></i>
                            For better recommendations, enter realistic values per serving. Snack should usually be lower calories than lunch or dinner.
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-xl-5">
                <div class="panel mb-4">
                    <div class="panel-head">
                        <h5><i class="bi bi-clock text-primary me-2"></i>Meal Time</h5>
                    </div>

                    <div class="panel-body">
                        <div class="meal-time-grid">
                            @foreach([
                                'Breakfast' => '🌅',
                                'Lunch' => '☀️',
                                'Dinner' => '🌙',
                                'Snack' => '🍎',
                            ] as $time => $icon)
                                <label class="option-card">
                                    <input type="radio"
                                           name="meal_time"
                                           value="{{ $time }}"
                                           {{ old('meal_time') === $time ? 'checked' : '' }}
                                           required>

                                    <div class="option-box">
                                        <span class="option-icon">{{ $icon }}</span>
                                        <span class="option-title">{{ $time }}</span>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="panel">
                    <div class="panel-head">
                        <h5><i class="bi bi-globe2 text-primary me-2"></i>Cuisine Type</h5>
                    </div>

                    <div class="panel-body">
                        <div class="cuisine-grid">
                            @foreach(['Malay','Chinese','Indian','Western','Middle Eastern'] as $cuisine)
                                <label class="option-card">
                                    <input type="radio"
                                           name="cuisine_type"
                                           value="{{ $cuisine }}"
                                           {{ old('cuisine_type') === $cuisine ? 'checked' : '' }}>

                                    <div class="option-box">
                                        <span class="option-icon">
                                            @if($cuisine === 'Malay') 🍛
                                            @elseif($cuisine === 'Chinese') 🥢
                                            @elseif($cuisine === 'Indian') 🫓
                                            @elseif($cuisine === 'Western') 🥗
                                            @else 🧆
                                            @endif
                                        </span>
                                        <span class="option-title">{{ $cuisine }}</span>
                                    </div>
                                </label>
                            @endforeach
                        </div>

                        <div class="help-box mt-3">
                            <i class="bi bi-info-circle-fill me-1"></i>
                            Cuisine type is important because users can choose their preferred cuisine in the Health Profile.
                        </div>

                        <div class="d-flex gap-2 mt-4 flex-wrap">
                            <button type="submit" class="submit-btn">
                                <i class="bi bi-check-lg me-1"></i>
                                Save Meal
                            </button>

                            <a href="{{ route('admin.meals.index') }}" class="btn btn-light rounded-pill px-4 fw-bold border">
                                Cancel
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

</div>
@endsection