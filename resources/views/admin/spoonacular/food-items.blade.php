{{-- resources/views/admin/spoonacular/food-items.blade.php --}}
@extends('layouts.admin')
@section('title', 'Food Items — NutriTrack Admin')

@push('styles')
<style>
:root {
    --blue:#1565C0;
    --blue-lt:#E3F0FF;
    --green:#2E7D32;
    --green-lt:#E8F5E9;
    --orange:#E65100;
    --orange-lt:#FFF3E0;
    --red:#C62828;
    --red-lt:#FFEBEE;
    --purple:#6A1B9A;
    --muted:#64748B;
    --shadow:0 2px 16px rgba(21,101,192,.09);
}

.page-shell {
    max-width:1180px;
}

.page-header {
    background:#fff;
    border:1.5px solid #E3EAF5;
    border-radius:18px;
    box-shadow:var(--shadow);
    padding:1.25rem;
    margin-bottom:1rem;
}

.page-header h1 {
    font-size:1.65rem;
    font-weight:800;
    color:#111827;
    margin:0;
}

.page-header p {
    color:var(--muted);
    margin:.35rem 0 0;
    font-size:.9rem;
}

.panel {
    background:#fff;
    border-radius:16px;
    border:1.5px solid #E3EAF5;
    box-shadow:var(--shadow);
    overflow:hidden;
}

.filter-input {
    border:2px solid #D0DCF0;
    border-radius:10px;
    font-size:.85rem;
    padding:.55rem .75rem;
    background:#F7FAFF;
}

.filter-input:focus {
    border-color:var(--blue);
    outline:none;
    box-shadow:0 0 0 3px rgba(21,101,192,.10);
    background:#fff;
}

.filter-label {
    font-size:.72rem;
    font-weight:800;
    text-transform:uppercase;
    letter-spacing:.06em;
    color:#666;
    margin-bottom:.35rem;
}

.nt-table {
    border-collapse:separate;
    border-spacing:0;
    width:100%;
}

.nt-table thead th {
    background:#F0F4FA;
    font-size:.73rem;
    font-weight:800;
    text-transform:uppercase;
    letter-spacing:.06em;
    color:#555;
    padding:.75rem 1rem;
    border:none;
    white-space:nowrap;
}

.nt-table thead th:first-child {
    border-radius:10px 0 0 10px;
}

.nt-table thead th:last-child {
    border-radius:0 10px 10px 0;
}

.nt-table tbody td {
    padding:.75rem 1rem;
    border-bottom:1px solid #F3F6FC;
    font-size:.86rem;
    vertical-align:middle;
}

.nt-table tbody tr:last-child td {
    border-bottom:none;
}

.nt-table tbody tr:hover td {
    background:#FAFCFF;
}

.status-badge {
    font-size:.68rem;
    font-weight:800;
    padding:.25rem .6rem;
    border-radius:50px;
    display:inline-block;
    white-space:nowrap;
}

.badge-verified {
    background:var(--green-lt);
    color:var(--green);
}

.badge-pending {
    background:var(--orange-lt);
    color:var(--orange);
}

.badge-inactive {
    background:#F5F5F5;
    color:#888;
}

.slot-badge {
    background:var(--blue-lt);
    color:var(--blue);
}

.source-badge {
    background:#F0F4FA;
    color:#555;
}

.action-btn {
    border:none;
    border-radius:8px;
    padding:.25rem .55rem;
    font-size:.72rem;
    font-weight:700;
    cursor:pointer;
    transition:opacity .15s, transform .15s;
}

.action-btn:hover {
    opacity:.85;
    transform:translateY(-1px);
}

@media(max-width:768px) {
    .page-header {
        padding:1rem;
    }

    .page-header h1 {
        font-size:1.35rem;
    }
}
</style>
@endpush

@section('content')
<div class="container py-4 page-shell">

    <div class="page-header d-flex align-items-center justify-content-between flex-wrap gap-3">
        <div>
            <div style="font-size:.75rem;font-weight:800;text-transform:uppercase;letter-spacing:.07em;color:var(--blue);margin-bottom:.3rem;">
                <i class="bi bi-database-fill me-1"></i>
                Spoonacular Imported Data
            </div>

            <h1>Food Items Database</h1>

            <p>
                Total:
                <strong>{{ number_format($filterCounts['total'] ?? 0) }}</strong>
                · Verified:
                <strong style="color:var(--green);">{{ number_format($filterCounts['verified'] ?? 0) }}</strong>
                · Pending:
                <strong style="color:var(--orange);">{{ number_format($filterCounts['pending'] ?? 0) }}</strong>
            </p>
        </div>

        <a href="{{ route('admin.spoonacular.index') }}"
           class="btn btn-primary rounded-pill px-4"
           style="font-size:.85rem;font-weight:700;">
            <i class="bi bi-cloud-arrow-down me-1"></i>
            Import More
        </a>
    </div>

    @if(session('success'))
        <div class="alert rounded-3 mb-4 p-3"
             style="background:var(--green-lt);border:1.5px solid #A5D6A7;color:#1B5E20;">
            <i class="bi bi-check-circle-fill me-2"></i>
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger rounded-3 mb-4">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    {{-- Filter bar --}}
    <div class="panel mb-4">
        <div class="p-3">
            <form method="GET" action="{{ route('admin.food-items.index') }}" class="row g-3 align-items-end">

                <div class="col-12 col-lg-3">
                    <label class="filter-label">Search</label>
                    <input type="text"
                           name="search"
                           class="form-control filter-input"
                           placeholder="Meal name..."
                           value="{{ request('search') }}">
                </div>

                <div class="col-6 col-lg-2">
                    <label class="filter-label">Slot</label>
                    <select name="meal_time" class="form-select filter-input">
                        <option value="">All slots</option>
                        @foreach(['Breakfast','Lunch','Dinner','Snack','Any'] as $slot)
                            <option value="{{ $slot }}" {{ request('meal_time') === $slot ? 'selected' : '' }}>
                                {{ $slot }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-6 col-lg-2">
                    <label class="filter-label">Cuisine</label>
                    <select name="cuisine" class="form-select filter-input">
                        <option value="">All cuisines</option>
                        @foreach(['Malay','Chinese','Indian','Western','Middle Eastern'] as $cuisine)
                            <option value="{{ $cuisine }}" {{ request('cuisine') === $cuisine ? 'selected' : '' }}>
                                {{ $cuisine }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-6 col-lg-2">
                    <label class="filter-label">Status</label>
                    <select name="status" class="form-select filter-input">
                        <option value="">All</option>
                        <option value="verified" {{ request('status') === 'verified' ? 'selected' : '' }}>
                            Verified
                        </option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>
                            Pending
                        </option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>
                            Inactive
                        </option>
                    </select>
                </div>

                <div class="col-6 col-lg-1">
                    <label class="filter-label">Min kcal</label>
                    <input type="number"
                           name="min_cal"
                           class="form-control filter-input"
                           placeholder="200"
                           value="{{ request('min_cal') }}">
                </div>

                <div class="col-6 col-lg-1">
                    <label class="filter-label">Max kcal</label>
                    <input type="number"
                           name="max_cal"
                           class="form-control filter-input"
                           placeholder="800"
                           value="{{ request('max_cal') }}">
                </div>

                <div class="col-12 col-lg-1">
                    <button type="submit"
                            class="btn btn-primary w-100 rounded-2"
                            style="font-size:.82rem;font-weight:700;padding:.58rem;">
                        <i class="bi bi-search"></i>
                    </button>
                </div>

            </form>
        </div>
    </div>

    {{-- Table --}}
    <div class="panel">
        <div class="table-responsive">
            <table class="nt-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Meal Name</th>
                        <th>Slot</th>
                        <th class="text-center">Calories</th>
                        <th>Protein</th>
                        <th>Carbs</th>
                        <th>Fat</th>
                        <th>Source</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($items as $item)
                        <tr>
                            <td class="text-muted" style="font-size:.75rem;">
                                {{ $item->id }}
                            </td>

                            <td>
                                <div class="fw-bold">
                                    {{ \Illuminate\Support\Str::limit($item->meal_name, 42) }}
                                </div>

                                @if($item->cuisine_type)
                                    <span style="font-size:.7rem;color:#94A3B8;">
                                        {{ $item->cuisine_type }}
                                    </span>
                                @else
                                    <span style="font-size:.7rem;color:#CBD5E1;">
                                        No cuisine
                                    </span>
                                @endif
                            </td>

                            <td>
                                <span class="status-badge slot-badge">
                                    {{ $item->meal_time ?? 'Any' }}
                                </span>
                            </td>

                            <td class="text-center fw-bold" style="color:var(--blue);">
                                {{ number_format($item->calories ?? 0) }}
                            </td>

                            <td style="color:#4527A0;">
                                {{ $item->protein_g ?? 0 }}g
                            </td>

                            <td style="color:var(--orange);">
                                {{ $item->carbs_g ?? 0 }}g
                            </td>

                            <td style="color:var(--purple);">
                                {{ $item->fat_g ?? 0 }}g
                            </td>

                            <td>
                                <span class="status-badge source-badge">
                                    {{ $item->source ?? 'unknown' }}
                                </span>
                            </td>

                            <td class="text-center">
                                @if(! $item->is_active)
                                    <span class="status-badge badge-inactive">
                                        Inactive
                                    </span>
                                @elseif($item->is_verified)
                                    <span class="status-badge badge-verified">
                                        <i class="bi bi-check-circle-fill me-1"></i>
                                        Verified
                                    </span>
                                @else
                                    <span class="status-badge badge-pending">
                                        <i class="bi bi-clock-fill me-1"></i>
                                        Pending
                                    </span>
                                @endif
                            </td>

                            <td class="text-center">
                                <div class="d-flex gap-1 justify-content-center">

                                    @if(! $item->is_verified)
                                        <form method="POST" action="{{ route('admin.food-items.verify', $item->id) }}">
                                            @csrf
                                            @method('PATCH')

                                            <button class="action-btn"
                                                    style="background:var(--green-lt);color:var(--green);"
                                                    title="Verify">
                                                <i class="bi bi-check-lg"></i>
                                            </button>
                                        </form>
                                    @endif

                                    <form method="POST" action="{{ route('admin.food-items.toggle-active', $item->id) }}">
                                        @csrf
                                        @method('PATCH')

                                        <button class="action-btn"
                                                style="background:{{ $item->is_active ? '#FFF3E0' : '#E8F5E9' }};color:{{ $item->is_active ? '#E65100' : '#2E7D32' }};"
                                                title="{{ $item->is_active ? 'Deactivate' : 'Activate' }}">
                                            <i class="bi bi-{{ $item->is_active ? 'eye-slash' : 'eye' }}"></i>
                                        </button>
                                    </form>

                                    <form method="POST" action="{{ route('admin.food-items.destroy', $item->id) }}">
                                        @csrf
                                        @method('DELETE')

                                        <button class="action-btn"
                                                style="background:var(--red-lt);color:var(--red);"
                                                title="Delete"
                                                onclick="return confirm('Delete this food item?')">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center py-5 text-muted">
                                <i class="bi bi-database-x fs-2 d-block mb-2"></i>
                                No food items match your filters.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($items->hasPages())
            <div class="p-3 border-top" style="border-color:#EEF2FA!important;">
                {{ $items->links() }}
            </div>
        @endif
    </div>

</div>
@endsection