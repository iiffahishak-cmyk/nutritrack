<x-guest-layout>
    <x-slot name="title">Welcome back</x-slot>
    <x-slot name="subtitle">Sign in to continue your nutrition journey.</x-slot>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div>
            <label for="email" class="auth-label">Email Address</label>
            <input id="email"
                   type="email"
                   name="email"
                   value="{{ old('email') }}"
                   class="auth-input"
                   required
                   autofocus
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
                       autocomplete="current-password">

                <button type="button" class="eye-btn" onclick="togglePassword('password', 'eye-icon')">
                    <span id="eye-icon">👁️</span>
                </button>
            </div>
        </div>

        <div class="remember-row">
            <label class="remember-label">
                <input type="checkbox" name="remember">
                <span>Remember me</span>
            </label>

            @if (Route::has('password.request'))
                <a class="auth-link" href="{{ route('password.request') }}">
                    Forgot password?
                </a>
            @endif
        </div>

        <button type="submit" class="auth-main-btn">
            Log In
        </button>

        <div class="auth-bottom-text">
            Don't have an account?
            <a href="{{ route('register') }}" class="auth-link">
                Register Now
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