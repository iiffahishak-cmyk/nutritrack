@extends('layouts.admin')
@section('title', 'Edit User')

@section('content')
<div class="container-fluid py-2">
    <div class="mb-4">
        <h2 class="fw-bold mb-0 text-dark"><i class="bi bi-pencil-square text-primary me-2"></i>Edit User</h2>
        <p class="text-muted">Editing account and health profile for <strong>{{ $user->name }}</strong></p>
    </div>

    @if($errors->any())
        <div class="alert alert-danger border-0 shadow-sm rounded-4 mb-4">
            <ul class="mb-0">@foreach($errors->all() as $e) <li>{{ $e }}</li> @endforeach</ul>
        </div>
    @endif

    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
        @csrf @method('PUT')

        <div class="row g-4">
            {{-- ACCOUNT INFO --}}
            <div class="col-md-6">
                <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
                    <h6 class="fw-bold text-primary mb-4 border-bottom pb-2"><i class="bi bi-person-circle me-1"></i> Account Info</h6>
                    <div class="mb-3">
                        <label class="form-label fw-bold text-muted small">Full Name</label>
                        <input type="text" name="name" class="form-control bg-light border-0" value="{{ old('name', $user->name) }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold text-muted small">Email Address</label>
                        <input type="email" name="email" class="form-control bg-light border-0" value="{{ old('email', $user->email) }}" required>
                    </div>
                </div>
            </div>

            {{-- HEALTH PROFILE --}}
            <div class="col-md-6">
                <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
                    <h6 class="fw-bold text-primary mb-4 border-bottom pb-2"><i class="bi bi-heart-pulse me-1"></i> Health Profile</h6>
                    @if($user->profile)
                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <label class="form-label fw-bold text-muted small">Age</label>
                                <input type="number" name="age" class="form-control bg-light border-0" value="{{ old('age', $user->profile->age) }}">
                            </div>
                            <div class="col-6">
                                <label class="form-label fw-bold text-muted small">Gender</label>
                                <select name="gender" class="form-select bg-light border-0">
                                    <option value="male" {{ old('gender', $user->profile->gender) == 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ old('gender', $user->profile->gender) == 'female' ? 'selected' : '' }}>Female</option>
                                </select>
                            </div>
                        </div>
                        {{-- Tambah field lain mengikut keperluan kod asal anda --}}
                        <div class="mb-3 text-muted small">
                            <i class="bi bi-info-circle"></i> BMR, TDEE and DCR will be recalculated automatically on save.
                        </div>
                    @else
                        <div class="text-center py-4 text-muted">No health profile set up yet.</div>
                    @endif
                </div>
            </div>
        </div>

        <div class="d-flex gap-2 mt-4">
            <button type="submit" class="btn btn-primary rounded-pill px-5 fw-bold shadow-sm">Save Changes</button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-light rounded-pill px-4 border text-muted">Cancel</a>
        </div>
    </form>
</div>
@endsection