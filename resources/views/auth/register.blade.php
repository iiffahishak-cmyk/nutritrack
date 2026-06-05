<x-guest-layout>
    <x-slot name="title">Create your account</x-slot>
    <x-slot name="subtitle">Start your personalized nutrition journey today.</x-slot>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div>
            <label for="name" class="auth-label">Full Name</label>
            <input id="name"
                   type="text"
                   name="name"
                   value="{{ old('name') }}"
                   class="auth-input"
                   required
                   autofocus
                   autocomplete="name">
        </div>

        <div class="mt-4">
            <label for="email" class="auth-label">Email Address</label>
            <input id="email"
                   type="email"
                   name="email"
                   value="{{ old('email') }}"
                   class="auth-input"
                   required
                   autocomplete="username">
        </div>

        <div class="mt-4">
            <label for="password" class="auth-label">Password</label>

            <div class="password-wrap">
                <input id="password"
                       type="password"
                       name="password"
                       class="auth-input"
                       required
                       autocomplete="new-password">

                <button type="button" class="eye-btn" onclick="togglePassword('password', 'eye-icon-1')">
                    <span id="eye-icon-1">👁️</span>
                </button>
            </div>
        </div>

        <div class="mt-4">
            <label for="password_confirmation" class="auth-label">Confirm Password</label>

            <div class="password-wrap">
                <input id="password_confirmation"
                       type="password"
                       name="password_confirmation"
                       class="auth-input"
                       required
                       autocomplete="new-password">

                <button type="button" class="eye-btn" onclick="togglePassword('password_confirmation', 'eye-icon-2')">
                    <span id="eye-icon-2">👁️</span>
                </button>
            </div>
        </div>

        <button type="submit" class="auth-main-btn">
            Create Account
        </button>

        <div class="auth-bottom-text">
            Already registered?
            <a href="{{ route('login') }}" class="auth-link">
                Login Here
            </a>
        </div>
    </form>

    <script>
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);

            if (input.type === 'password') {
                input.type = 'text';
                icon.textContent = '🙈';
            } else {
                input.type = 'password';
                icon.textContent = '👁️';
            }
        }
    </script>
</x-guest-layout>