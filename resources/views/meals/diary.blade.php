@extends('layouts.app')

@section('title', 'My Meal Log')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1"><i class="bi bi-journal-check text-primary me-2"></i>My Meal Log</h2>
            <p class="text-muted mb-0">History of meals saved from Meal Options, Daily Plan, and AI Food Logger.</p>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        @if(count($savedMeals) > 0)
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light text-muted small text-uppercase">
                        <tr>
                            <th class="ps-4 py-3">Date</th>
                            <th class="py-3">Time</th>
                            <th class="py-3">Meal Name</th>
                            <th class="py-3">Calories</th>
                            <th class="py-3 text-center">Macros (P/C/F)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($savedMeals as $log)
                        <tr>
                            <td class="ps-4 py-3 fw-bold">{{ \Carbon\Carbon::parse($log->date)->format('M d, Y') }}</td>
                            <td class="py-3">
                                <span class="badge bg-light text-dark border"><i class="bi bi-clock me-1"></i>{{ ucfirst($log->meal_time) }}</span>
                            </td>
                            <td class="py-3 fw-semibold text-dark">{{ $log->meal_name }}</td>
                            <td class="py-3 text-success fw-bold"><i class="bi bi-fire"></i> {{ $log->calories }} kcal</td>
                            <td class="py-3 text-center small text-muted">
                                {{ $log->protein_g }}g / {{ $log->carbs_g }}g / {{ $log->fat_g }}g
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-journal-x text-muted opacity-50" style="font-size: 4rem;"></i>
                <h5 class="fw-bold mt-3">Your meal log is empty</h5>
                <p class="text-muted">Go to Meal Options and save some meals to see them here!</p>
                <a href="{{ route('meals.hybrid-recommend') }}" class="btn btn-primary mt-2 rounded-pill px-4">
                    View Meal Options
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
