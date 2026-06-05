<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>NutriTrack</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Playfair+Display:wght@700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --blue: #176BFF;
            --blue-dark: #0B3D91;
            --blue-soft: #EAF2FF;
            --text: #0F172A;
            --muted: #64748B;
            --card: rgba(255,255,255,.94);
            --shadow: 0 30px 90px rgba(15,23,42,.24);
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            color: var(--text);
            background:
                linear-gradient(135deg, rgba(7,27,70,.76), rgba(11,61,145,.58)),
                url('{{ asset('images/pexels-janetrangdoan-1092730.jpg') }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }

        .auth-page {
            min-height: 100vh;
            display: grid;
            grid-template-columns: 1fr 1fr;
        }

        .auth-left {
            padding: clamp(2rem, 5vw, 5rem);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            color: white;
        }

        .brand {
            display: inline-flex;
            align-items: center;
            gap: .7rem;
            text-decoration: none;
            color: white;
            font-size: 1.35rem;
            font-weight: 900;
            letter-spacing: -.04em;
        }

        .brand-mark {
            width: 42px;
            height: 42px;
            border-radius: 16px;
            display: grid;
            place-items: center;
            background: rgba(255,255,255,.16);
            border: 1px solid rgba(255,255,255,.22);
            backdrop-filter: blur(12px);
        }

        .brand span span {
            color: #A7F3D0;
        }

        .hero-copy {
            max-width: 640px;
        }

        .hero-kicker {
            display: inline-flex;
            align-items: center;
            gap: .45rem;
            padding: .45rem .75rem;
            border-radius: 999px;
            background: rgba(255,255,255,.14);
            border: 1px solid rgba(255,255,255,.18);
            font-size: .72rem;
            font-weight: 900;
            letter-spacing: .08em;
            text-transform: uppercase;
            margin-bottom: 1rem;
        }

        .hero-copy h1 {
            font-family: 'Playfair Display', serif;
            font-size: clamp(2.7rem, 6vw, 5.4rem);
            line-height: .95;
            letter-spacing: -.06em;
            margin: 0 0 1rem;
        }

        .hero-copy p {
            color: rgba(255,255,255,.82);
            font-size: 1rem;
            line-height: 1.8;
            max-width: 540px;
            margin: 0;
        }

        .auth-points {
            display: flex;
            flex-wrap: wrap;
            gap: .7rem;
            margin-top: 1.4rem;
        }

        .auth-point {
            display: inline-flex;
            align-items: center;
            gap: .45rem;
            padding: .55rem .8rem;
            border-radius: 999px;
            background: rgba(255,255,255,.12);
            border: 1px solid rgba(255,255,255,.16);
            color: rgba(255,255,255,.92);
            font-size: .82rem;
            font-weight: 800;
            backdrop-filter: blur(10px);
        }

        .auth-right {
            padding: 2rem 5rem 2rem 2rem;
            display: grid;
            place-items: center;
        }

        .auth-card {
            width: min(100%, 620px);
            background: var(--card);
            border: 1px solid rgba(255,255,255,.65);
            border-radius: 36px;
            box-shadow: var(--shadow);
            backdrop-filter: blur(22px);
            overflow: hidden;
        }

        .auth-card-top {
            padding: 2.4rem 3rem 1.2rem;
            text-align: center;
        }

        .auth-logo {
            width: 62px;
            height: 62px;
            margin: 0 auto .9rem;
            border-radius: 22px;
            display: grid;
            place-items: center;
            background: linear-gradient(135deg, var(--blue), var(--blue-dark));
            color: white;
            font-size: 1.55rem;
            box-shadow: 0 18px 40px rgba(23,107,255,.3);
        }

        .auth-card-top h2 {
            margin: 0;
            color: var(--text);
            font-weight: 900;
            letter-spacing: -.04em;
            font-size: 1.8rem;
        }

        .auth-card-top p {
            color: var(--muted);
            margin: .4rem 0 0;
            font-size: .95rem;
        }

        .auth-slot {
            padding: 0 3rem 2.6rem;
        }

        .auth-label {
            display: block;
            color: var(--muted);
            font-size: .76rem;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: .07em;
            margin-bottom: .45rem;
        }

        .auth-input {
            width: 100%;
            border-radius: 18px;
            border: 1px solid rgba(23,107,255,.18);
            background: #F8FBFF;
            padding: .9rem 1rem;
            color: var(--text);
            font-size: .95rem;
            box-shadow: none;
            outline: none;
        }

        .auth-input:focus {
            border-color: var(--blue);
            box-shadow: 0 0 0 4px rgba(23,107,255,.1);
            background: white;
        }

        .password-wrap {
            position: relative;
        }

        .password-wrap .auth-input {
            padding-right: 3rem;
        }

        .eye-btn {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            background: transparent;
            border: 0;
            padding: 0;
            width: 28px;
            height: 28px;
            display: grid;
            place-items: center;
            cursor: pointer;
            color: var(--muted);
            font-size: 1rem;
        }

        .eye-btn:hover {
            color: var(--blue);
        }

        .remember-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: .75rem;
            margin-top: 1rem;
        }

        .remember-label {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            color: #475569;
            font-size: .88rem;
            font-weight: 700;
            text-transform: none;
            letter-spacing: 0;
            margin: 0;
        }

        .remember-label input {
            width: 18px;
            height: 18px;
            border-radius: 6px;
            border: 1px solid rgba(23,107,255,.25);
            accent-color: var(--blue);
        }

        .auth-link {
            color: var(--blue);
            font-weight: 800;
            text-decoration: none;
            font-size: .88rem;
        }

        .auth-link:hover {
            color: var(--blue-dark);
            text-decoration: underline;
        }

        .auth-main-btn {
            width: 100%;
            min-height: 52px;
            border: 0;
            border-radius: 18px;
            background: linear-gradient(135deg, var(--blue), var(--blue-dark));
            color: white;
            font-weight: 900;
            font-size: .95rem;
            transition: .2s ease;
            cursor: pointer;
            margin-top: 1.6rem;
        }

        .auth-main-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 16px 36px rgba(23,107,255,.25);
        }

        .auth-bottom-text {
            text-align: center;
            margin-top: 1.4rem;
            color: #64748B;
            font-size: .9rem;
        }

        .auth-footer {
            color: rgba(255,255,255,.72);
            font-size: .85rem;
            font-weight: 700;
        }

        .back-home {
            position: fixed;
            top: 1.2rem;
            left: 1.2rem;
            z-index: 10;
            display: inline-flex;
            align-items: center;
            gap: .45rem;
            background: rgba(15,23,42,.75);
            color: white;
            text-decoration: none;
            border-radius: 999px;
            padding: .65rem .9rem;
            font-size: .82rem;
            font-weight: 900;
            backdrop-filter: blur(12px);
        }

        .back-home:hover {
            color: white;
            background: rgba(15,23,42,.92);
        }

        @media (max-width: 1100px) {
            .auth-page {
                grid-template-columns: 1fr;
            }

            .auth-left {
                padding: 2rem 1.5rem 1rem;
                gap: 2rem;
            }

            .auth-right {
                padding: 1rem 1.5rem 2rem;
            }

            .auth-card {
                width: min(100%, 620px);
            }

            .hero-copy h1 {
                font-size: 2.8rem;
            }
        }

        @media (max-width: 575px) {
            .auth-card {
                border-radius: 28px;
            }

            .auth-card-top {
                padding: 2rem 1.4rem 1rem;
            }

            .auth-slot {
                padding: 0 1.4rem 2rem;
            }

            .remember-row {
                align-items: flex-start;
                flex-direction: column;
            }

            .back-home {
                position: static;
                margin: 1rem;
            }
        }
    </style>
</head>

<body>
    <a href="{{ url('/') }}" class="back-home">← Back to Home</a>

    <div class="auth-page">
        <section class="auth-left">
            <a href="{{ url('/') }}" class="brand">
                <span class="brand-mark">⚡</span>
                <span>Nutri<span>Track</span></span>
            </a>

            <div class="hero-copy">
                <div class="hero-kicker">
                    Personalized Meal Planner
                </div>

                <h1>Healthy eating starts with one smart choice.</h1>

                <p>
                    Access your daily plan, daily picks, weekly planner, AI food logger, and meal diary in one place.
                </p>

                <div class="auth-points">
                    <div class="auth-point">🥗 Daily Plan</div>
                    <div class="auth-point">✨ Daily Picks</div>
                    <div class="auth-point">🤖 AI Logger</div>
                    <div class="auth-point">📘 Meal Diary</div>
                </div>
            </div>

            <div class="auth-footer">
                © {{ date('Y') }} NutriTrack — Empowering healthy lifestyles
            </div>
        </section>

        <section class="auth-right">
            <div class="auth-card">
                <div class="auth-card-top">
                    <div class="auth-logo">💙</div>

                    <h2>{{ $title ?? 'Welcome back' }}</h2>
                    <p>{{ $subtitle ?? 'Sign in to continue your nutrition journey.' }}</p>
                </div>

                <div class="auth-slot">
                    {{ $slot }}
                </div>
            </div>
        </section>
    </div>
</body>
</html>