@extends('layouts.admin')
@section('title', 'Recommendation Testing — NutriTrack Admin')

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
    --red:#DC2626;
    --red-soft:#FEE2E2;
    --text:#0F172A;
    --muted:#64748B;
    --shadow:0 18px 45px rgba(15,23,42,.07);
}

.test-hero {
    border-radius:30px;
    padding:1.6rem;
    color:white;
    background:linear-gradient(135deg,#071B46,#176BFF);
    margin-bottom:1.2rem;
    box-shadow:0 24px 65px rgba(23,107,255,.16);
}

.test-hero h1 {
    font-weight:900;
    letter-spacing:-.05em;
    margin:0;
}

.test-hero p {
    color:rgba(255,255,255,.78);
    margin:.35rem 0 0;
}

.panel {
    background:white;
    border:1px solid rgba(23,107,255,.09);
    border-radius:28px;
    box-shadow:var(--shadow);
    overflow:hidden;
}

.panel-body {
    padding:1.2rem;
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

.test-btn {
    width:100%;
    min-height:48px;
    border:0;
    border-radius:18px;
    background:linear-gradient(135deg,var(--blue),var(--blue-dark));
    color:white;
    font-weight:900;
}

.summary-grid {
    display:grid;
    grid-template-columns:repeat(4, 1fr);
    gap:.75rem;
    margin-bottom:1rem;
}

.summary-card {
    border-radius:22px;
    background:#F8FBFF;
    border:1px solid rgba(23,107,255,.08);
    padding:.9rem;
}

.summary-label {
    color:var(--muted);
    font-size:.68rem;
    font-weight:900;
    text-transform:uppercase;
    letter-spacing:.08em;
}

.summary-value {
    margin-top:.25rem;
    color:var(--text);
    font-weight:900;
}

.score-badge {
    display:inline-flex;
    align-items:center;
    justify-content:center;
    min-width:62px;
    padding:.35rem .65rem;
    border-radius:999px;
    font-size:.76rem;
    font-weight:900;
}

.score-good {
    background:var(--green-soft);
    color:var(--green);
}

.score-mid {
    background:var(--orange-soft);
    color:var(--orange);
}

.score-low {
    background:var(--red-soft);
    color:var(--red);
}

.reason-text {
    color:var(--muted);
    font-size:.82rem;
    line-height:1.5;
}

.table thead th {
    background:#F8FBFF;
    color:var(--muted);
    font-size:.72rem;
    font-weight:900;
    text-transform:uppercase;
    letter-spacing:.06em;
    border:0;
}

.table tbody td {
    vertical-align:middle;
    border-bottom:1px solid rgba(23,107,255,.07);
}

@media(max-width:991px) {
    .summary-grid {
        grid-template-columns:repeat(2, 1fr);
    }
}

@media(max-width:575px) {
    .summary-grid {
        grid-template-columns:1fr;
    }
}
</style>
@endpush

@section('content')
<div class="container-fluid py-2">

    <div class="test-hero">
        <div style="font-size:.72rem;font-weight:900;letter-spacing:.08em;text-transform:uppercase;opacity:.8;">
            Admin Testing Tool
        </div>
        <h1>Recommendation Accuracy Test</h1>
        <p>
            Test whether NutriTrack recommends meals that match calorie target, cuisine preference,
            allergy restrictions, and nutrition quality.
        </p>
    </div>

    <div class="panel mb-4">
        <div class="panel-body">
            <form method="POST" action="{{ route('admin.recommendation-test.index') }}" class="row g-3 align-items-end">
                @csrf

                <div class="col-12 col-md-3">
                    <label class="form-label-modern">DCR</label>
                    <input type="number"
                           name="dcr"
                           value="{{ old('dcr', $summary['dcr'] ?? 1800) }}"
                           class="form-control"
                           placeholder="Example: 1800"
                           required>
                </div>

                <div class="col-12 col-md-3">
                    <label class="form-label-modern">Meal Time</label>
                    <select name="meal_time" class="form-select" required>
                        @foreach(['Breakfast','Lunch','Dinner','Snack'] as $slot)
                            <option value="{{ $slot }}" {{ old('meal_time', $summary['meal_time'] ?? '') === $slot ? 'selected' : '' }}>
                                {{ $slot }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12 col-md-3">
                    <label class="form-label-modern">Preferred Cuisine</label>
                    <select name="preferred_cuisine" class="form-select">
                        <option value="">No preference</option>
                        @foreach(['Malay','Chinese','Indian','Western','Middle Eastern'] as $cuisine)
                            <option value="{{ $cuisine }}" {{ old('preferred_cuisine', $summary['preferred_cuisine'] ?? '') === $cuisine ? 'selected' : '' }}>
                                {{ $cuisine }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12 col-md-2">
                    <label class="form-label-modern">Allergies</label>
                    <input type="text"
                           name="allergies"
                           value="{{ old('allergies') }}"
                           class="form-control"
                           placeholder="nuts, dairy">
                </div>

                <div class="col-12 col-md-1">
                    <button type="submit" class="test-btn">
                        Test
                    </button>
                </div>
            </form>
        </div>
    </div>

    @if($summary)
        <div class="summary-grid">
            <div class="summary-card">
                <div class="summary-label">Slot Target</div>
                <div class="summary-value">{{ number_format($summary['slot_budget']) }} kcal</div>
            </div>

            <div class="summary-card">
                <div class="summary-label">Cuisine</div>
                <div class="summary-value">{{ $summary['preferred_cuisine'] }}</div>
            </div>

            <div class="summary-card">
                <div class="summary-label">Allergy</div>
                <div class="summary-value">{{ $summary['allergies'] }}</div>
            </div>

            <div class="summary-card">
                <div class="summary-label">Candidates</div>
                <div class="summary-value">{{ $summary['shown_results'] }} shown / {{ $summary['total_candidates'] }} found</div>
            </div>
        </div>

        <div class="panel">
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Meal</th>
                                <th>Calories</th>
                                <th>Score</th>
                                <th>Reason</th>
                                <th>Warnings</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($results as $meal)
                                @php
                                    $scoreClass = $meal->test_score >= 75 ? 'score-good' : ($meal->test_score >= 45 ? 'score-mid' : 'score-low');
                                @endphp

                                <tr>
                                    <td>
                                        <div class="fw-bold text-dark">{{ $meal->meal_name }}</div>
                                        <div class="text-muted small">
                                            {{ $meal->meal_time }} · {{ $meal->cuisine_type ?? 'No cuisine' }}
                                        </div>
                                    </td>

                                    <td>
                                        <span class="fw-bold text-primary">{{ $meal->calories }} kcal</span>
                                        <div class="text-muted small">
                                            Difference: {{ $meal->test_calorie_diff }} kcal
                                        </div>
                                    </td>

                                    <td>
                                        <span class="score-badge {{ $scoreClass }}">
                                            {{ $meal->test_score }}%
                                        </span>
                                    </td>

                                    <td class="reason-text">
                                        {{ $meal->test_reason }}
                                    </td>

                                    <td>
                                        @if(count($meal->test_warnings))
                                            @foreach($meal->test_warnings as $warning)
                                                <div class="badge rounded-pill bg-warning bg-opacity-10 text-warning border border-warning mb-1">
                                                    {{ $warning }}
                                                </div>
                                            @endforeach
                                        @else
                                            <span class="badge rounded-pill bg-success bg-opacity-10 text-success border border-success">
                                                Passed
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-5">
                                        <i class="bi bi-search fs-1 d-block mb-2"></i>
                                        No suitable meals found. Add more meals for this cuisine and meal time.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif

</div>
@endsection