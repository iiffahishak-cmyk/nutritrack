@extends('layouts.app')
@section('title', 'Settings — NutriTrack')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
            <h3 class="mb-4 text-dark fw-bold">Profile Settings</h3>

            {{-- Update Profile Information --}}
            <div class="card shadow-sm border-0 mb-4 rounded-4">
                <div class="card-body p-4">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            {{-- Update Password --}}
            <div class="card shadow-sm border-0 mb-4 rounded-4">
                <div class="card-body p-4">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            {{-- Delete Account --}}
            <div class="card shadow-sm border-danger mb-4 rounded-4">
                <div class="card-body p-4 delete-section">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

        </div>
    </div>
</div>

{{-- MAGIC STYLES: This forces Laravel's default components to look like Bootstrap --}}
<style>
    .card-body header h2 {
        font-size: 1.25rem;
        font-weight: 700;
        color: #212529;
        margin-bottom: 0.5rem;
    }
    .card-body header p {
        color: #6c757d;
        font-size: 0.9rem;
        margin-bottom: 1.5rem;
    }
    
    /* Style the Inputs */
    .card-body input[type="text"],
    .card-body input[type="email"],
    .card-body input[type="password"] {
        display: block;
        width: 100%;
        padding: 0.5rem 0.75rem;
        font-size: 1rem;
        color: #212529;
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        margin-top: 0.5rem;
        margin-bottom: 1rem;
        transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
    }
    .card-body input:focus {
        border-color: #86b7fe;
        outline: 0;
        box-shadow: 0 0 0 0.25rem rgba(13,110,253,.25);
    }
    
    /* Style the Labels */
    .card-body label {
        font-weight: 600;
        color: #495057;
        font-size: 0.9rem;
    }

    /* Style the Buttons */
    .card-body button {
        background-color: #0d6efd;
        color: white;
        border: none;
        padding: 8px 20px;
        border-radius: 6px;
        font-weight: 600;
        cursor: pointer;
        margin-top: 10px;
        transition: 0.2s;
    }
    .card-body button:hover {
        background-color: #0b5ed7;
    }

    /* Make the Delete Button Red */
    .delete-section button {
        background-color: #dc3545;
    }
    .delete-section button:hover {
        background-color: #bb2d3b;
    }
</style>
@endsection