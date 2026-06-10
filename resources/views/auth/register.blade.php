<x-guest-layout>
    <x-slot name="title">Create your account</x-slot>
    <x-slot name="subtitle">Start your personalized nutrition journey today.</x-slot>

    <style>
        .password-rule-popup {
            display: flex;
            align-items: flex-start;
            gap: .55rem;
            margin-top: .7rem;
            padding: .75rem .85rem;
            border-radius: 18px;
            color: #92400E;
            background: #FFF7ED;
            border: 1px solid #FED7AA;
            font-size: .82rem;
            font-weight: 700;
            line-height: 1.45;
        }

        .password-rule-popup.show {
            display: flex;
        }

        .password-rule-popup.valid {
            color: #166534;
            background: #F0FDF4;
            border-color: #BBF7D0;
        }

        .password-rule-icon {
            width: 1.35rem;
            height: 1.35rem;
            display: inline-grid;
            place-items: center;
            flex: 0 0 auto;
            border-radius: 50%;
            color: #FFF7ED;
            background: #EA580C;
            font-size: .72rem;
            font-weight: 900;
            margin-top: .05rem;
        }

        .password-rule-popup.valid .password-rule-icon {
            color: #F0FDF4;
            background: #16A34A;
            font-size: .62rem;
        }

        .password-rule-message {
            flex: 1 1 auto;
        }
    </style>

    <form method="POST" action="{{ route('register') }}" id="register-form">
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
                       minlength="8"
                       title="Password must be at least 8 characters."
                       aria-describedby="password-rule-popup"
                       autocomplete="new-password">

                <button type="button" class="eye-btn" onclick="togglePassword('password', 'eye-icon-1')">
                    <span id="eye-icon-1">👁️</span>
                </button>
            </div>

            <div id="password-rule-popup" class="password-rule-popup" role="alert" aria-live="polite">
                <span class="password-rule-icon">!</span>
                <span class="password-rule-message">Password must be at least 8 characters before you can create an account.</span>
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
                       minlength="8"
                       title="Password must be at least 8 characters."
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
        const registerForm = document.getElementById('register-form');
        const passwordInput = document.getElementById('password');
        const passwordPopup = document.getElementById('password-rule-popup');
        const passwordPopupIcon = passwordPopup?.querySelector('.password-rule-icon');
        const passwordPopupText = passwordPopup?.querySelector('.password-rule-message');

        function updatePasswordRule(forceShow = false) {
            if (!passwordInput || !passwordPopup) {
                return true;
            }

            const isValid = passwordInput.value.length >= 8;
            passwordPopup.classList.toggle('valid', isValid);

            if (passwordPopupIcon) {
                passwordPopupIcon.textContent = isValid ? 'OK' : '!';
            }

            if (passwordPopupText) {
                passwordPopupText.textContent = isValid
                    ? 'Password length is okay.'
                    : 'Password must be at least 8 characters before you can create an account.';
            }

            return isValid;
        }

        passwordInput?.addEventListener('focus', () => updatePasswordRule(true));
        passwordInput?.addEventListener('input', () => updatePasswordRule(true));

        registerForm?.addEventListener('submit', (event) => {
            if (!updatePasswordRule(true)) {
                event.preventDefault();
                passwordInput.focus();
            }
        });

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
