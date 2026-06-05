{{-- resources/views/admin/spoonacular/index.blade.php --}}
@extends('layouts.admin')
@section('title', 'Spoonacular Import — NutriTrack Admin')

@push('styles')
<style>
:root {
    --blue:#1565C0;
    --blue-mid:#1976D2;
    --blue-lt:#E3F0FF;
    --green:#2E7D32;
    --green-lt:#E8F5E9;
    --orange:#E65100;
    --orange-lt:#FFF3E0;
    --red:#C62828;
    --red-lt:#FFEBEE;
    --purple:#6A1B9A;
    --shadow:0 2px 16px rgba(21,101,192,.09);
    --r:16px;
}

.panel {
    background:#fff;
    border-radius:var(--r);
    border:1.5px solid #E3EAF5;
    box-shadow:var(--shadow);
    overflow:hidden;
}

.panel-header {
    padding:1.1rem 1.5rem;
    border-bottom:1.5px solid #EEF2FA;
    display:flex;
    align-items:center;
    justify-content:space-between;
}

.panel-header h6 {
    margin:0;
    font-weight:700;
    font-size:.82rem;
    text-transform:uppercase;
    letter-spacing:.07em;
    color:#444;
}

.panel-body {
    padding:1.5rem;
}

.stat-card {
    border-radius:14px;
    padding:1.2rem 1.4rem;
    color:#fff;
    position:relative;
    overflow:hidden;
    box-shadow:0 4px 20px rgba(0,0,0,.12);
}

.stat-card .si {
    position:absolute;
    right:1rem;
    top:1rem;
    font-size:2rem;
    opacity:.18;
}

.stat-card .sv {
    font-size:2.2rem;
    font-weight:800;
    line-height:1;
}

.stat-card .sl {
    font-size:.75rem;
    opacity:.85;
    font-weight:600;
    text-transform:uppercase;
    letter-spacing:.06em;
}

.sc-blue {
    background:linear-gradient(135deg,#1565C0,#1976D2);
}

.sc-green {
    background:linear-gradient(135deg,#2E7D32,#43A047);
}

.sc-orange {
    background:linear-gradient(135deg,#E65100,#F57C00);
}

.sc-gray {
    background:linear-gradient(135deg,#546E7A,#78909C);
}

.form-label-sm {
    font-size:.75rem;
    font-weight:700;
    text-transform:uppercase;
    letter-spacing:.06em;
    color:#666;
}

.form-control-nt {
    border:2px solid #D0DCF0;
    border-radius:10px;
    font-size:.92rem;
    padding:.65rem .9rem;
    transition:border-color .2s, box-shadow .2s;
    background:#F7FAFF;
}

.form-control-nt:focus {
    border-color:var(--blue-mid);
    box-shadow:0 0 0 3px rgba(25,118,210,.12);
    background:#fff;
    outline:none;
}

.btn-import {
    background:linear-gradient(135deg,var(--blue),var(--blue-mid));
    color:#fff;
    border:none;
    border-radius:10px;
    padding:.65rem 1.5rem;
    font-weight:700;
    font-size:.9rem;
    transition:opacity .2s, transform .15s;
}

.btn-import:hover {
    opacity:.88;
    transform:translateY(-1px);
    color:#fff;
}

.btn-import:disabled {
    opacity:.6;
    transform:none;
}

.nt-table {
    border-collapse:separate;
    border-spacing:0;
    width:100%;
}

.nt-table thead th {
    background:#F0F4FA;
    font-size:.75rem;
    font-weight:700;
    text-transform:uppercase;
    letter-spacing:.06em;
    color:#555;
    padding:.65rem 1rem;
    border:none;
}

.nt-table thead th:first-child {
    border-radius:10px 0 0 10px;
}

.nt-table thead th:last-child {
    border-radius:0 10px 10px 0;
}

.nt-table tbody td {
    padding:.7rem 1rem;
    border-bottom:1px solid #F0F4FA;
    font-size:.88rem;
    vertical-align:middle;
}

.nt-table tbody tr:last-child td {
    border-bottom:none;
}

.nt-table tbody tr:hover td {
    background:#FAFCFF;
}

.window-preview {
    background:var(--blue-lt);
    border-radius:10px;
    padding:.75rem 1rem;
    margin-top:.75rem;
    font-size:.85rem;
    color:var(--blue);
    font-weight:600;
    display:none;
}

.slot-bar-row {
    display:flex;
    align-items:center;
    gap:.6rem;
    margin-bottom:.4rem;
}

.slot-bar-track {
    flex:1;
    height:8px;
    border-radius:99px;
    background:#EEF2FA;
    overflow:hidden;
}

.slot-bar-fill {
    height:100%;
    border-radius:99px;
}
</style>
@endpush

@section('content')

@php
    $cuisineOptions = [
        'Malay',
        'Chinese',
        'Indian',
        'Western',
        'Middle Eastern',
    ];
@endphp

<div class="container py-4">

    <div class="mb-4">
        <div style="font-size:.75rem;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:var(--blue);margin-bottom:.3rem;">
            <i class="bi bi-cloud-download-fill me-1"></i>Admin Panel
        </div>

        <h1 class="fw-800 mb-1" style="font-size:1.75rem;color:#111;">
            Spoonacular API Import
        </h1>

        <p class="text-muted mb-0" style="font-size:.9rem;">
            Fetch meals from Spoonacular into the <code>food_items</code> table.
            Items require admin verification before appearing in recommendations.
        </p>
    </div>

    @if(session('success'))
        <div class="alert d-flex align-items-center gap-2 mb-4 rounded-3 p-3"
             style="background:var(--green-lt);border:1.5px solid #A5D6A7;">
            <i class="bi bi-check-circle-fill" style="color:var(--green);"></i>
            <span style="color:#1B5E20;">{{ session('success') }}</span>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger rounded-3 mb-4">
            @foreach($errors->all() as $e)
                <div>{{ $e }}</div>
            @endforeach
        </div>
    @endif

    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="stat-card sc-blue">
                <i class="bi bi-database-fill si"></i>
                <div class="sl">Total Items</div>
                <div class="sv">{{ number_format($stats['total'] ?? 0) }}</div>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="stat-card sc-green">
                <i class="bi bi-check-circle-fill si"></i>
                <div class="sl">Verified</div>
                <div class="sv">{{ number_format($stats['verified'] ?? 0) }}</div>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="stat-card sc-orange">
                <i class="bi bi-clock-fill si"></i>
                <div class="sl">Pending Review</div>
                <div class="sv">{{ number_format($stats['pending'] ?? 0) }}</div>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="stat-card sc-gray">
                <i class="bi bi-grid-fill si"></i>
                <div class="sl">Meal Slots</div>
                <div class="sv">{{ isset($stats['by_slot']) ? $stats['by_slot']->count() : 0 }}</div>
            </div>
        </div>
    </div>

    <div class="row g-4">

        <div class="col-12 col-lg-5">

            <div class="panel mb-4">
                <div class="panel-header">
                    <h6>
                        <i class="bi bi-cloud-arrow-down-fill me-2 text-primary"></i>
                        Import by Slot
                    </h6>
                </div>

                <div class="panel-body">
                    <form method="POST" action="{{ route('admin.spoonacular.import') }}" id="import-form">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label-sm">Daily Calorie Requirement (DCR)</label>
                            <input type="number"
                                   name="dcr"
                                   id="dcr-input"
                                   class="form-control form-control-nt"
                                   placeholder="e.g. 1800"
                                   min="800"
                                   max="5000"
                                   step="1"
                                   value="{{ old('dcr', 1800) }}"
                                   required>

                            <div class="window-preview" id="window-preview"></div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label-sm">Meal Slot</label>
                            <select name="meal_time"
                                    id="meal-time-select"
                                    class="form-select form-control-nt"
                                    required>
                                @foreach(['Breakfast','Lunch','Dinner','Snack','Any'] as $slot)
                                    <option value="{{ $slot }}" {{ old('meal_time') === $slot ? 'selected' : '' }}>
                                        {{ $slot }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label-sm">
                                Cuisine Preference
                                <span style="font-weight:400;color:#aaa;">(optional)</span>
                            </label>

                            <select name="cuisine" class="form-select form-control-nt">
                                <option value="">Any</option>
                                @foreach($cuisineOptions as $cuisine)
                                    <option value="{{ $cuisine }}" {{ old('cuisine') === $cuisine ? 'selected' : '' }}>
                                        {{ $cuisine }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label-sm">
                                Max Results
                                <span style="font-weight:400;color:#aaa;">(1–50)</span>
                            </label>

                            <input type="number"
                                   name="limit"
                                   class="form-control form-control-nt"
                                   min="1"
                                   max="50"
                                   value="{{ old('limit', 20) }}">
                        </div>

                        <button type="submit" class="btn btn-import w-100" id="import-btn">
                            <i class="bi bi-cloud-arrow-down me-2"></i>
                            Import from Spoonacular
                        </button>
                    </form>
                </div>
            </div>

            <div class="panel mb-4">
                <div class="panel-header">
                    <h6>
                        <i class="bi bi-collection-fill me-2 text-success"></i>
                        Bulk Import — All 4 Slots
                    </h6>
                </div>

                <div class="panel-body">
                    <form method="POST" action="{{ route('admin.spoonacular.import-profile') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label-sm">DCR (kcal)</label>
                            <input type="number"
                                   name="dcr"
                                   class="form-control form-control-nt"
                                   placeholder="e.g. 1800"
                                   min="800"
                                   max="5000"
                                   value="{{ old('dcr', 1800) }}"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label-sm">
                                Cuisine
                                <span style="font-weight:400;color:#aaa;">(optional)</span>
                            </label>

                            <select name="cuisine" class="form-select form-control-nt">
                                <option value="">Any</option>
                                @foreach($cuisineOptions as $cuisine)
                                    <option value="{{ $cuisine }}" {{ old('cuisine') === $cuisine ? 'selected' : '' }}>
                                        {{ $cuisine }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <button class="btn btn-import w-100"
                                style="background:linear-gradient(135deg,#2E7D32,#43A047);">
                            <i class="bi bi-lightning-fill me-2"></i>
                            Bulk Import All Slots
                        </button>
                    </form>
                </div>
            </div>

            <div class="panel">
                <div class="panel-header">
                    <h6>
                        <i class="bi bi-hash me-2" style="color:var(--purple);"></i>
                        Import Single Recipe by ID
                    </h6>
                </div>

                <div class="panel-body">
                    <form method="POST" action="{{ route('admin.spoonacular.import-single') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label-sm">Spoonacular Recipe ID</label>
                            <input type="number"
                                   name="spoonacular_id"
                                   class="form-control form-control-nt"
                                   placeholder="e.g. 716429"
                                   min="1"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label-sm">Assign to Slot</label>
                            <select name="meal_time" class="form-select form-control-nt" required>
                                @foreach(['Breakfast','Lunch','Dinner','Snack','Any'] as $slot)
                                    <option value="{{ $slot }}">{{ $slot }}</option>
                                @endforeach
                            </select>
                        </div>

                        <button class="btn btn-import w-100"
                                style="background:linear-gradient(135deg,#6A1B9A,#8E24AA);">
                            <i class="bi bi-download me-2"></i>
                            Import by ID
                        </button>
                    </form>
                </div>
            </div>

        </div>

        <div class="col-12 col-lg-7">

            <div class="panel mb-4">
                <div class="panel-header">
                    <h6>
                        <i class="bi bi-bar-chart-fill me-2 text-primary"></i>
                        Items by Meal Slot
                    </h6>

                    <a href="{{ route('admin.food-items.index') }}"
                       class="btn btn-sm btn-outline-primary rounded-pill px-3"
                       style="font-size:.75rem;">
                        Browse all →
                    </a>
                </div>

                <div class="panel-body">
                    @php
                        $slotColors = [
                            'Breakfast' => '#F57C00',
                            'Lunch'     => '#43A047',
                            'Dinner'    => '#1976D2',
                            'Snack'     => '#8E24AA',
                            'Any'       => '#546E7A',
                        ];

                        $bySlot = $stats['by_slot'] ?? collect();
                        $maxCount = $bySlot->max() ?: 1;
                    @endphp

                    @foreach(['Breakfast','Lunch','Dinner','Snack','Any'] as $slot)
                        @php
                            $count = $bySlot[$slot] ?? 0;
                            $width = $maxCount > 0 ? round(($count / $maxCount) * 100) : 0;
                        @endphp

                        <div class="slot-bar-row">
                            <span style="width:80px;font-size:.82rem;font-weight:600;color:#444;">
                                {{ $slot }}
                            </span>

                            <div class="slot-bar-track">
                                <div class="slot-bar-fill"
                                     style="width:{{ $width }}%;background:{{ $slotColors[$slot] ?? '#888' }};">
                                </div>
                            </div>

                            <span style="width:32px;text-align:right;font-size:.82rem;font-weight:700;color:{{ $slotColors[$slot] ?? '#888' }};">
                                {{ $count }}
                            </span>
                        </div>
                    @endforeach

                    @if(($stats['pending'] ?? 0) > 0)
                        <form method="POST" action="{{ route('admin.food-items.verify-all') }}" class="mt-3">
                            @csrf
                            @method('PATCH')

                            <button class="btn btn-sm w-100 rounded-2 fw-600"
                                    style="background:var(--green-lt);color:var(--green);border:1.5px solid #A5D6A7;font-size:.82rem;">
                                <i class="bi bi-check2-all me-1"></i>
                                Verify All {{ $stats['pending'] }} Pending Items
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            <div class="panel">
                <div class="panel-header">
                    <h6>
                        <i class="bi bi-clock-fill me-2" style="color:var(--orange);"></i>
                        Pending Verification

                        <span class="badge rounded-pill ms-2"
                              style="background:var(--orange-lt);color:var(--orange);">
                            {{ $stats['pending'] ?? 0 }}
                        </span>
                    </h6>
                </div>

                <div class="table-responsive">
                    <table class="nt-table">
                        <thead>
                            <tr>
                                <th>Meal Name</th>
                                <th>Slot</th>
                                <th class="text-center">Calories</th>
                                <th>Macros</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($pendingItems as $item)
                                <tr>
                                    <td>
                                        <div class="fw-600" style="font-size:.88rem;">
                                            {{ \Illuminate\Support\Str::limit($item->meal_name, 35) }}
                                        </div>

                                        <div style="font-size:.72rem;color:#aaa;">
                                            {{ $item->source }} · ID {{ $item->spoonacular_id ?? 'manual' }}
                                        </div>
                                    </td>

                                    <td>
                                        <span class="badge rounded-pill"
                                              style="background:#E3F0FF;color:#1565C0;font-size:.7rem;">
                                            {{ $item->meal_time }}
                                        </span>
                                    </td>

                                    <td class="text-center fw-700" style="color:#1565C0;">
                                        {{ number_format($item->calories) }}
                                    </td>

                                    <td style="font-size:.78rem;color:#666;">
                                        P {{ $item->protein_g }}g
                                        C {{ $item->carbs_g }}g
                                        F {{ $item->fat_g }}g
                                    </td>

                                    <td class="text-center">
                                        <div class="d-flex gap-1 justify-content-center">
                                            <form method="POST" action="{{ route('admin.food-items.verify', $item->id) }}">
                                                @csrf
                                                @method('PATCH')

                                                <button class="btn btn-sm rounded-2 fw-600 px-2 py-1"
                                                        style="background:var(--green-lt);color:var(--green);border:none;font-size:.72rem;"
                                                        title="Verify">
                                                    <i class="bi bi-check-lg"></i>
                                                </button>
                                            </form>

                                            <form method="POST" action="{{ route('admin.food-items.destroy', $item->id) }}">
                                                @csrf
                                                @method('DELETE')

                                                <button class="btn btn-sm rounded-2 fw-600 px-2 py-1"
                                                        style="background:var(--red-lt);color:var(--red);border:none;font-size:.72rem;"
                                                        title="Delete"
                                                        onclick="return confirm('Delete this item?')">
                                                    <i class="bi bi-trash3"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">
                                        <i class="bi bi-check2-circle fs-3 d-block mb-2" style="color:var(--green);"></i>
                                        All imported items have been verified.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
const slotPct = {
    Breakfast: .25,
    Lunch: .35,
    Dinner: .25,
    Snack: .15,
    Any: 1.00
};

const tolerance = 0.10;

function updatePreview() {
    const dcrInput = document.getElementById('dcr-input');
    const slotSelect = document.getElementById('meal-time-select');
    const preview = document.getElementById('window-preview');

    if (!dcrInput || !slotSelect || !preview) {
        return;
    }

    const dcr = parseFloat(dcrInput.value) || 0;
    const slot = slotSelect.value;

    if (dcr < 800) {
        preview.style.display = 'none';
        return;
    }

    const budget = dcr * (slotPct[slot] ?? 1.0);
    const min = Math.floor(budget * (1 - tolerance));
    const max = Math.ceil(budget * (1 + tolerance));

    preview.innerHTML = `
        <i class="bi bi-info-circle-fill me-1"></i>
        Spoonacular will search for <strong>${slot}</strong> meals
        between <strong>${min.toLocaleString()}</strong> and
        <strong>${max.toLocaleString()} kcal</strong>
        (DCR ${dcr.toLocaleString()} × ${Math.round((slotPct[slot] ?? 1) * 100)}% ± ${Math.round(tolerance * 100)}%)
    `;

    preview.style.display = 'block';
}

const dcrInput = document.getElementById('dcr-input');
const slotSelect = document.getElementById('meal-time-select');

if (dcrInput) {
    dcrInput.addEventListener('input', updatePreview);
}

if (slotSelect) {
    slotSelect.addEventListener('change', updatePreview);
}

updatePreview();

const importForm = document.getElementById('import-form');
const importBtn = document.getElementById('import-btn');

if (importForm && importBtn) {
    importForm.addEventListener('submit', function () {
        importBtn.disabled = true;
        importBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Importing from Spoonacular…';
    });
}
</script>
@endpush