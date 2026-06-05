@extends('layouts.admin')
@section('title', 'User Detail')

@section('content')
<div class="container-fluid py-2">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-0 text-dark"><i class="bi bi-person-badge text-primary me-2"></i>User Details</h2>
            <p class="text-muted">Viewing account and health profile for <strong>{{ $user->name }}</strong></p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-primary rounded-pill px-4 shadow-sm"><i class="bi bi-pencil me-1"></i> Edit User</a>
            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Permanently delete {{ $user->name }}?')">
                @csrf @method('DELETE')
                <button class="btn btn-danger rounded-pill px-4 shadow-sm"><i class="bi bi-trash me-1"></i> Delete</button>
            </form>
        </div>
    </div>

    <div class="row g-4">
        {{-- ACCOUNT SUMMARY CARD --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 text-center p-4 h-100">
                <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3 mx-auto" style="width: 80px; height: 80px;">
                    <i class="bi bi-person-circle text-primary fs-1"></i>
                </div>
                <h4 class="fw-bold text-dark mb-1">{{ $user->name }}</h4>
                <p class="text-muted mb-3">{{ $user->email }}</p>
                <span class="badge bg-primary bg-opacity-10 text-primary border border-primary rounded-pill px-3 mb-4">User</span>
                
                <div class="text-start bg-light rounded-4 p-3 mt-auto">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted small">Joined Date:</span>
                        <span class="fw-bold small text-dark">{{ $user->created_at->format('d F Y') }}</span>
                    </div>
                    @if($user->profile)
                        <div class="d-flex justify-content-between mb-2 border-top pt-2">
                            <span class="text-muted small">Target:</span>
                            <span class="fw-bold text-primary small">{{ number_format($user->profile->dcr_value, 0) }} kcal</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- HEALTH PROFILE CARD --}}
        <div class="col-md-8">
            <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold text-dark mb-0"><i class="bi bi-heart-pulse text-danger me-2"></i>Health Profile</h5>
                    @if($user->profile)
                    <form action="{{ route('admin.users.destroyProfile', $user->id) }}" method="POST" onsubmit="return confirm('Delete health profile for {{ $user->name }}?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger rounded-pill px-3"><i class="bi bi-trash me-1"></i> Delete Profile</button>
                    </form>
                    @endif
                </div>

                @if($user->profile)
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="list-group list-group-flush">
                            <div class="list-group-item bg-transparent d-flex justify-content-between px-0">
                                <span class="text-muted">Age</span><span class="fw-bold text-dark">{{ $user->profile->age }} years</span>
                            </div>
                            <div class="list-group-item bg-transparent d-flex justify-content-between px-0">
                                <span class="text-muted">Gender</span><span class="fw-bold text-dark">{{ ucfirst($user->profile->gender) }}</span>
                            </div>
                            <div class="list-group-item bg-transparent d-flex justify-content-between px-0">
                                <span class="text-muted">Weight</span><span class="fw-bold text-dark">{{ $user->profile->weight_kg }} kg</span>
                            </div>
                            <div class="list-group-item bg-transparent d-flex justify-content-between px-0">
                                <span class="text-muted">Goal</span><span class="fw-bold text-primary">{{ ucfirst(str_replace('_',' ', $user->profile->goal)) }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="list-group list-group-flush">
                            <div class="list-group-item bg-transparent d-flex justify-content-between px-0">
                                <span class="text-muted">Daily Target (DCR)</span><span class="fw-bold text-success">{{ number_format($user->profile->dcr_value, 0) }} kcal</span>
                            </div>
                            <div class="list-group-item bg-transparent d-flex justify-content-between px-0">
                                <span class="text-muted">Cuisine</span><span class="fw-bold text-dark">{{ $user->profile->preferred_cuisine ?? 'None' }}</span>
                            </div>
                            <div class="list-group-item bg-transparent d-flex justify-content-between px-0">
                                <span class="text-muted">Allergies</span>
                                <div>
                                    @foreach(explode(',', $user->profile->allergies ?? 'None') as $a)
                                        <span class="badge bg-danger bg-opacity-10 text-danger border border-danger rounded-pill px-2 small">{{ trim($a) }}</span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @else
                    <div class="text-center py-5 text-muted">
                        <i class="bi bi-person-x fs-1 d-block mb-2"></i>
                        <p>This user has not set up their health profile yet.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="mt-4">
        <a href="{{ route('admin.users.index') }}" class="btn btn-light rounded-pill px-4 border shadow-sm text-muted">
            <i class="bi bi-arrow-left me-1"></i> Back to Users
        </a>
    </div>
</div>
@endsection