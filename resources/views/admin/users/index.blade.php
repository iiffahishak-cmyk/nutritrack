@extends('layouts.admin')
@section('title', 'Manage Users — NutriTrack Admin')

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
    --purple:#7C3AED;
    --purple-soft:#F3E8FF;
    --text:#0F172A;
    --muted:#64748B;
    --line:rgba(23,107,255,.12);
    --shadow:0 18px 45px rgba(15,23,42,.07);
}

.users-shell {
    max-width:1200px;
}

.users-hero {
    border-radius:32px;
    padding:1.5rem;
    color:white;
    background:
        radial-gradient(circle at 88% 10%, rgba(255,255,255,.16), transparent 25%),
        linear-gradient(135deg,#071B46,#176BFF);
    box-shadow:0 24px 65px rgba(23,107,255,.16);
    margin-bottom:1.2rem;
}

.users-hero h1 {
    margin:0;
    font-weight:900;
    letter-spacing:-.05em;
    line-height:1.05;
}

.users-hero p {
    margin:.35rem 0 0;
    color:rgba(255,255,255,.78);
}

.hero-pill {
    display:inline-flex;
    align-items:center;
    gap:.45rem;
    padding:.45rem .75rem;
    border-radius:999px;
    background:rgba(255,255,255,.14);
    border:1px solid rgba(255,255,255,.2);
    font-size:.72rem;
    font-weight:900;
    letter-spacing:.08em;
    text-transform:uppercase;
    margin-bottom:.75rem;
}

.stat-grid {
    display:grid;
    grid-template-columns:repeat(3, 1fr);
    gap:1rem;
    margin-bottom:1.2rem;
}

.stat-card {
    background:white;
    border:1px solid var(--line);
    border-radius:28px;
    box-shadow:var(--shadow);
    padding:1.15rem;
    position:relative;
    overflow:hidden;
    min-height:132px;
}

.stat-card::after {
    content:"";
    position:absolute;
    width:130px;
    height:130px;
    right:-72px;
    top:-72px;
    border-radius:50%;
    background:rgba(23,107,255,.08);
}

.stat-icon {
    width:46px;
    height:46px;
    border-radius:18px;
    display:grid;
    place-items:center;
    margin-bottom:.8rem;
    position:relative;
    z-index:2;
}

.stat-label {
    color:var(--muted);
    font-size:.72rem;
    font-weight:900;
    letter-spacing:.08em;
    text-transform:uppercase;
    position:relative;
    z-index:2;
}

.stat-value {
    font-size:2rem;
    font-weight:900;
    letter-spacing:-.06em;
    line-height:1;
    margin-top:.35rem;
    position:relative;
    z-index:2;
    color:var(--text);
}

.stat-sub {
    color:var(--muted);
    font-size:.78rem;
    margin-top:.35rem;
    position:relative;
    z-index:2;
}

.panel {
    background:white;
    border:1px solid var(--line);
    border-radius:28px;
    box-shadow:var(--shadow);
    overflow:hidden;
}

.search-panel {
    padding:1rem;
    margin-bottom:1.2rem;
}

.filter-label {
    color:var(--muted);
    font-size:.72rem;
    font-weight:900;
    letter-spacing:.08em;
    text-transform:uppercase;
    margin-bottom:.45rem;
}

.filter-input {
    border-radius:18px;
    border:1px solid rgba(23,107,255,.16);
    background:#F8FBFF;
    padding:.82rem .95rem;
    font-weight:700;
}

.filter-input:focus {
    background:white;
    border-color:var(--blue);
    box-shadow:0 0 0 4px rgba(23,107,255,.1);
}

.search-btn {
    min-height:48px;
    border:0;
    border-radius:999px;
    background:linear-gradient(135deg,var(--blue),var(--blue-dark));
    color:white;
    font-weight:900;
    padding:.75rem 1rem;
}

.search-btn:hover {
    color:white;
    transform:translateY(-1px);
}

.clear-btn {
    min-height:48px;
    border-radius:999px;
    font-weight:900;
}

.table-wrap {
    padding:1rem;
}

.nt-table {
    width:100%;
    border-collapse:separate;
    border-spacing:0;
}

.nt-table thead th {
    background:#F0F4FA;
    color:var(--muted);
    font-size:.72rem;
    font-weight:900;
    text-transform:uppercase;
    letter-spacing:.06em;
    padding:.85rem 1rem;
    border:none;
    white-space:nowrap;
}

.nt-table thead th:first-child {
    border-radius:16px 0 0 16px;
}

.nt-table thead th:last-child {
    border-radius:0 16px 16px 0;
}

.nt-table tbody td {
    padding:.9rem 1rem;
    border-bottom:1px solid rgba(23,107,255,.08);
    vertical-align:middle;
    font-size:.88rem;
}

.nt-table tbody tr:last-child td {
    border-bottom:none;
}

.nt-table tbody tr:hover td {
    background:#FAFCFF;
}

.user-cell {
    display:flex;
    align-items:center;
    gap:.8rem;
}

.user-avatar {
    width:42px;
    height:42px;
    border-radius:16px;
    background:linear-gradient(135deg,var(--blue),var(--blue-dark));
    color:white;
    display:grid;
    place-items:center;
    font-weight:900;
    flex-shrink:0;
}

.user-name {
    font-weight:900;
    color:var(--text);
    line-height:1.2;
}

.user-id {
    color:var(--muted);
    font-size:.72rem;
    margin-top:.12rem;
}

.email-text {
    color:var(--muted);
    font-size:.84rem;
}

.status-badge {
    display:inline-flex;
    align-items:center;
    gap:.35rem;
    border-radius:999px;
    padding:.32rem .68rem;
    font-size:.72rem;
    font-weight:900;
    white-space:nowrap;
}

.badge-complete {
    background:var(--green-soft);
    color:var(--green);
    border:1px solid rgba(22,163,74,.25);
}

.badge-notset {
    background:#F8FAFC;
    color:#64748B;
    border:1px solid rgba(100,116,139,.18);
}

.bmi-badge {
    display:inline-flex;
    align-items:center;
    justify-content:center;
    min-width:48px;
    border-radius:999px;
    padding:.32rem .65rem;
    font-size:.75rem;
    font-weight:900;
}

.bmi-under,
.bmi-over {
    background:var(--orange-soft);
    color:var(--orange);
}

.bmi-normal {
    background:var(--green-soft);
    color:var(--green);
}

.bmi-obese {
    background:var(--red-soft);
    color:var(--red);
}

.goal-badge {
    display:inline-flex;
    align-items:center;
    border-radius:999px;
    background:var(--blue-soft);
    color:var(--blue-dark);
    padding:.32rem .65rem;
    font-size:.74rem;
    font-weight:800;
    white-space:nowrap;
}

.date-text {
    color:var(--muted);
    font-size:.82rem;
    white-space:nowrap;
}

.action-group {
    display:flex;
    justify-content:center;
    gap:.4rem;
}

.action-btn {
    width:36px;
    height:36px;
    border-radius:12px;
    display:grid;
    place-items:center;
    border:1px solid rgba(23,107,255,.1);
    background:#F8FBFF;
    transition:.18s ease;
    text-decoration:none;
}

.action-btn:hover {
    transform:translateY(-2px);
}

.action-view {
    color:var(--blue);
}

.action-edit {
    color:var(--orange);
}

.action-delete {
    color:var(--red);
}

.empty-state {
    padding:3rem 1rem;
    text-align:center;
    color:var(--muted);
}

.empty-icon {
    width:74px;
    height:74px;
    border-radius:26px;
    display:grid;
    place-items:center;
    background:var(--blue-soft);
    color:var(--blue);
    font-size:2rem;
    margin:0 auto 1rem;
}

.pagination-wrap {
    padding:1rem;
    border-top:1px solid rgba(23,107,255,.08);
}

@media(max-width:991px) {
    .stat-grid {
        grid-template-columns:1fr;
    }
}
</style>
@endpush

@section('content')
@php
    $stats = $stats ?? [
        'total' => $users->total(),
        'with_profile' => $users->filter(fn($u) => $u->profile)->count(),
        'no_profile' => $users->filter(fn($u) => ! $u->profile)->count(),
    ];

    function bmiClassForUser($profile) {
        if (! $profile || ! $profile->weight_kg || ! $profile->height_cm || $profile->height_cm <= 0) {
            return ['--', 'badge-notset'];
        }

        $bmi = round($profile->weight_kg / (($profile->height_cm / 100) ** 2), 1);

        if ($bmi < 18.5) {
            return [$bmi, 'bmi-under'];
        }

        if ($bmi < 25) {
            return [$bmi, 'bmi-normal'];
        }

        if ($bmi < 30) {
            return [$bmi, 'bmi-over'];
        }

        return [$bmi, 'bmi-obese'];
    }
@endphp

<div class="container-fluid py-3 users-shell">

    <div class="users-hero">
        <div class="hero-pill">
            <i class="bi bi-people-fill"></i>
            Admin User Management
        </div>

        <h1>Manage registered users.</h1>

        <p>
            View user accounts, check profile completion, monitor BMI and goal information,
            and manage user records in NutriTrack.
        </p>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4">
            <i class="bi bi-check-circle-fill me-1"></i>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger border-0 shadow-sm rounded-4 mb-4">
            <i class="bi bi-exclamation-circle-fill me-1"></i>
            {{ session('error') }}
        </div>
    @endif

    <div class="stat-grid">
        <div class="stat-card">
            <div class="stat-icon" style="background:var(--blue-soft);color:var(--blue);">
                <i class="bi bi-people-fill"></i>
            </div>

            <div class="stat-label">Total Users</div>
            <div class="stat-value">{{ number_format($stats['total'] ?? 0) }}</div>
            <div class="stat-sub">registered user accounts</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background:var(--green-soft);color:var(--green);">
                <i class="bi bi-person-check-fill"></i>
            </div>

            <div class="stat-label">With Profile</div>
            <div class="stat-value">{{ number_format($stats['with_profile'] ?? 0) }}</div>
            <div class="stat-sub">completed health setup</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background:var(--orange-soft);color:var(--orange);">
                <i class="bi bi-person-x-fill"></i>
            </div>

            <div class="stat-label">No Profile</div>
            <div class="stat-value">{{ number_format($stats['no_profile'] ?? 0) }}</div>
            <div class="stat-sub">not set up yet</div>
        </div>
    </div>

    <div class="panel search-panel">
        <form method="GET" action="{{ route('admin.users.index') }}" class="row g-3 align-items-end">
            <div class="col-12 col-lg-8">
                <label class="filter-label">Search by name or email</label>
                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       class="form-control filter-input"
                       placeholder="e.g. Iffah or iffah@email.com">
            </div>

            <div class="col-12 col-lg-2">
                <button type="submit" class="btn search-btn w-100">
                    <i class="bi bi-search me-1"></i>
                    Search
                </button>
            </div>

            <div class="col-12 col-lg-2">
                <a href="{{ route('admin.users.index') }}" class="btn btn-light clear-btn border w-100">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <div class="panel">
        <div class="table-wrap">
            <div class="table-responsive">
                <table class="nt-table">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Email</th>
                            <th>Profile</th>
                            <th>BMI</th>
                            <th>Goal</th>
                            <th>Joined</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($users as $user)
                            @php
                                [$bmi, $bmiClass] = bmiClassForUser($user->profile);
                                $initial = strtoupper(substr($user->name ?? 'U', 0, 1));
                                $goalLabel = $user->profile?->goal
                                    ? ucfirst(str_replace('_', ' ', $user->profile->goal))
                                    : '--';
                            @endphp

                            <tr>
                                <td>
                                    <div class="user-cell">
                                        <div class="user-avatar">
                                            {{ $initial }}
                                        </div>

                                        <div>
                                            <div class="user-name">
                                                {{ $user->name }}
                                            </div>

                                            <div class="user-id">
                                                User ID: {{ $user->id }}
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <span class="email-text">
                                        {{ $user->email }}
                                    </span>
                                </td>

                                <td>
                                    @if($user->profile)
                                        <span class="status-badge badge-complete">
                                            <i class="bi bi-check-circle-fill"></i>
                                            Complete
                                        </span>
                                    @else
                                        <span class="status-badge badge-notset">
                                            <i class="bi bi-x-circle-fill"></i>
                                            Not set
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    @if($user->profile)
                                        <span class="bmi-badge {{ $bmiClass }}">
                                            {{ $bmi }}
                                        </span>
                                    @else
                                        <span class="text-muted">--</span>
                                    @endif
                                </td>

                                <td>
                                    @if($goalLabel !== '--')
                                        <span class="goal-badge">
                                            {{ $goalLabel }}
                                        </span>
                                    @else
                                        <span class="text-muted">--</span>
                                    @endif
                                </td>

                                <td>
                                    <span class="date-text">
                                        {{ $user->created_at?->format('d M Y') }}
                                    </span>
                                </td>

                                <td class="text-center">
                                    <div class="action-group">
                                        <a href="{{ route('admin.users.show', $user->id) }}"
                                           class="action-btn action-view"
                                           title="View user">
                                            <i class="bi bi-eye-fill"></i>
                                        </a>

                                        <a href="{{ route('admin.users.edit', $user->id) }}"
                                           class="action-btn action-edit"
                                           title="Edit user">
                                            <i class="bi bi-pencil-fill"></i>
                                        </a>

                                        <form action="{{ route('admin.users.destroy', $user->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('Delete {{ addslashes($user->name) }}?')">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="action-btn action-delete"
                                                    title="Delete user">
                                                <i class="bi bi-trash3-fill"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">
                                    <div class="empty-state">
                                        <div class="empty-icon">
                                            <i class="bi bi-person-x"></i>
                                        </div>

                                        <div class="fw-bold text-dark mb-1">No users found</div>
                                        <div>Try another search keyword or reset the filter.</div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($users->hasPages())
            <div class="pagination-wrap">
                {{ $users->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
</div>
@endsection