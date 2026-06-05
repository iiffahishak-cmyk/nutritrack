<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // List all users
    public function index(Request $request)
    {
        $baseUserQuery = User::with('profile')
            ->where('role', 'user');

        $stats = [
            'total' => User::where('role', 'user')->count(),
            'with_profile' => User::where('role', 'user')->whereHas('profile')->count(),
            'no_profile' => User::where('role', 'user')->whereDoesntHave('profile')->count(),
        ];

        if ($request->filled('search')) {
            $baseUserQuery->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $users = $baseUserQuery
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.users.index', compact('users', 'stats'));
    }

    // Show single user + their profile
    public function show($id)
    {
        $user = User::with('profile')->findOrFail($id);

        return view('admin.users.show', compact('user'));
    }

    // Show edit form for user + profile
    public function edit($id)
    {
        $user = User::with('profile')->findOrFail($id);

        return view('admin.users.edit', compact('user'));
    }

    // Update user account + profile data
    public function update(Request $request, $id)
    {
        $user = User::with('profile')->findOrFail($id);

        $request->validate([
            'name'              => ['required', 'string', 'max:255'],
            'email'             => ['required', 'email', 'unique:users,email,' . $id],
            'age'               => ['nullable', 'integer', 'min:1', 'max:120'],
            'gender'            => ['nullable', 'in:male,female'],
            'weight_kg'         => ['nullable', 'numeric', 'min:1'],
            'height_cm'         => ['nullable', 'numeric', 'min:1'],
            'activity_level'    => ['nullable', 'in:sedentary,lightly_active,moderately_active,very_active,extra_active'],
            'goal'              => ['nullable', 'in:lose_weight,maintain,gain_weight'],
            'allergies'         => ['nullable', 'string'],
            'preferred_cuisine' => ['nullable', 'string'],
        ]);

        $user->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        if (
            $user->profile &&
            $request->filled('age') &&
            $request->filled('gender') &&
            $request->filled('weight_kg') &&
            $request->filled('height_cm') &&
            $request->filled('activity_level') &&
            $request->filled('goal')
        ) {
            $activityFactors = [
                'sedentary'         => 1.2,
                'lightly_active'    => 1.375,
                'moderately_active' => 1.55,
                'very_active'       => 1.725,
                'extra_active'      => 1.9,
            ];

            $weight = (float) $request->weight_kg;
            $height = (float) $request->height_cm;
            $age = (int) $request->age;
            $gender = $request->gender;
            $goal = $request->goal;
            $factor = $activityFactors[$request->activity_level] ?? 1.2;

            if ($gender === 'male') {
                $bmr = (10 * $weight) + (6.25 * $height) - (5 * $age) + 5;
            } else {
                $bmr = (10 * $weight) + (6.25 * $height) - (5 * $age) - 161;
            }

            $tdee = $bmr * $factor;

            $dcr = match ($goal) {
                'lose_weight' => $tdee - 500,
                'gain_weight' => $tdee + 500,
                default => $tdee,
            };

            $user->profile->update([
                'age'               => $age,
                'gender'            => $gender,
                'weight_kg'         => $weight,
                'height_cm'         => $height,
                'activity_level'    => $request->activity_level,
                'goal'              => $goal,
                'bmr'               => round($bmr, 2),
                'tdee_value'        => round($tdee, 2),
                'dcr_value'         => round($dcr, 2),
                'allergies'         => $request->allergies,
                'preferred_cuisine' => $request->preferred_cuisine,
            ]);
        }

        return redirect()
            ->route('admin.users.show', $id)
            ->with('success', 'User updated successfully!');
    }

    // Delete user and their related profile through database cascade if configured
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->role === 'admin') {
            return redirect()
                ->route('admin.users.index')
                ->with('error', 'Cannot delete admin accounts.');
        }

        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }

    // Delete only the user's profile and keep the account
    public function destroyProfile($id)
    {
        $user = User::with('profile')->findOrFail($id);

        if ($user->profile) {
            $user->profile->delete();
        }

        return redirect()
            ->route('admin.users.show', $id)
            ->with('success', 'User profile deleted successfully.');
    }
}