<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NutriTrack — Personalized Healthy Meal Recommendations</title>

    {{-- Bootstrap 5 + Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        :root {
            --dark: #08110C;
            --dark-2: #0D1D14;
            --green: #35D07F;
            --green-2: #A7F35B;
            --mint: #DFFFEA;
            --cream: #FFF8E8;
            --orange: #FFB347;
            --blue: #7DD3FC;
            --text: #1D2939;
            --muted: #667085;
            --white: #FFFFFF;
            --line: rgba(255,255,255,.14);
            --shadow: 0 30px 90px rgba(8,17,12,.22);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #FBFFF8;
            color: var(--text);
            overflow-x: hidden;
        }

        a {
            text-decoration: none;
        }

        /* =======================
           PREMIUM BACKGROUND
        ======================= */
        .site-bg {
            position: fixed;
            inset: 0;
            z-index: -5;
            background:
                radial-gradient(circle at 10% 15%, rgba(53,208,127,.18), transparent 26%),
                radial-gradient(circle at 88% 8%, rgba(255,179,71,.16), transparent 28%),
                radial-gradient(circle at 72% 88%, rgba(125,211,252,.16), transparent 30%),
                linear-gradient(180deg, #FBFFF8 0%, #F4FFF7 48%, #FFFDF6 100%);
        }

        .floating-noise {
            position: fixed;
            inset: 0;
            z-index: -4;
            opacity: .5;
            background-image:
                linear-gradient(rgba(8,17,12,.035) 1px, transparent 1px),
                linear-gradient(90deg, rgba(8,17,12,.035) 1px, transparent 1px);
            background-size: 70px 70px;
            mask-image: linear-gradient(to bottom, rgba(0,0,0,.7), transparent 85%);
            animation: gridDrift 20s linear infinite;
        }

        @keyframes gridDrift {
            from { background-position: 0 0; }
            to { background-position: 70px 70px; }
        }

        /* =======================
           NAVBAR
        ======================= */
        .nt-nav {
            position: fixed;
            top: 18px;
            left: 0;
            right: 0;
            z-index: 1000;
            pointer-events: none;
        }

        .nav-shell {
            pointer-events: auto;
            background: rgba(255,255,255,.72);
            backdrop-filter: blur(22px);
            border: 1px solid rgba(8,17,12,.08);
            border-radius: 999px;
            padding: .65rem .7rem;
            box-shadow: 0 20px 60px rgba(8,17,12,.08);
        }

        .brand {
            display: inline-flex;
            align-items: center;
            gap: .65rem;
            color: var(--dark);
            font-weight: 900;
            letter-spacing: -.04em;
            font-size: 1.12rem;
        }

        .brand-mark {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: grid;
            place-items: center;
            background: var(--dark);
            color: var(--green);
            box-shadow: 0 14px 30px rgba(8,17,12,.18);
        }

        .brand span span {
            color: #16A34A;
        }

        .nav-link-item {
            color: #475467;
            font-size: .86rem;
            font-weight: 800;
            padding: .55rem .9rem;
            border-radius: 999px;
            transition: .2s ease;
        }

        .nav-link-item:hover {
            color: var(--dark);
            background: rgba(8,17,12,.06);
        }

        .btn-nav-login,
        .btn-nav-signup {
            min-height: 38px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 999px;
            font-size: .84rem;
            font-weight: 900;
            padding: .55rem 1rem;
            transition: .22s ease;
            white-space: nowrap;
        }

        .btn-nav-login {
            color: var(--dark);
            background: rgba(8,17,12,.06);
        }

        .btn-nav-login:hover {
            color: var(--dark);
            background: rgba(8,17,12,.1);
        }

        .btn-nav-signup {
            color: white;
            background: var(--dark);
            box-shadow: 0 14px 30px rgba(8,17,12,.18);
        }

        .btn-nav-signup:hover {
            color: white;
            transform: translateY(-2px);
            background: #000;
        }

        /* =======================
           HERO
        ======================= */
        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 8.5rem 0 5rem;
            position: relative;
        }

        .hero-shell {
            position: relative;
            border-radius: 56px;
            overflow: hidden;
            background:
                radial-gradient(circle at 12% 20%, rgba(53,208,127,.3), transparent 28%),
                radial-gradient(circle at 80% 18%, rgba(255,179,71,.18), transparent 26%),
                linear-gradient(135deg, #08110C 0%, #0D1D14 58%, #13261B 100%);
            color: white;
            padding: clamp(2rem, 5vw, 4.5rem);
            box-shadow: var(--shadow);
        }

        .hero-shell::before {
            content: "";
            position: absolute;
            inset: 0;
            background:
                linear-gradient(rgba(255,255,255,.035) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,.035) 1px, transparent 1px);
            background-size: 54px 54px;
            mask-image: radial-gradient(circle at 50% 40%, black, transparent 75%);
        }

        .hero-content {
            position: relative;
            z-index: 3;
        }

        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: .55rem;
            padding: .55rem .95rem;
            border-radius: 999px;
            background: rgba(255,255,255,.1);
            border: 1px solid var(--line);
            color: rgba(255,255,255,.84);
            font-size: .78rem;
            font-weight: 900;
            letter-spacing: .09em;
            text-transform: uppercase;
            margin-bottom: 1.4rem;
            animation: fadeUp .75s ease both;
        }

        .hero-title {
            font-family: 'Instrument Serif', serif;
            font-size: clamp(3.4rem, 8vw, 7.8rem);
            line-height: .86;
            letter-spacing: -.07em;
            max-width: 850px;
            margin-bottom: 1.55rem;
            animation: fadeUp .75s .08s ease both;
        }

        .hero-title em {
            font-style: italic;
            color: var(--green-2);
        }

        .hero-desc {
            max-width: 620px;
            color: rgba(255,255,255,.72);
            font-size: 1.05rem;
            line-height: 1.85;
            margin-bottom: 2rem;
            animation: fadeUp .75s .16s ease both;
        }

        .hero-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            animation: fadeUp .75s .24s ease both;
        }

        .btn-hero-primary,
        .btn-hero-ghost,
        .btn-cta {
            min-height: 56px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: .65rem;
            border-radius: 999px;
            font-size: .94rem;
            font-weight: 900;
            padding: .95rem 1.35rem;
            transition: .22s ease;
        }

        .btn-hero-primary {
            color: var(--dark);
            background: linear-gradient(135deg, var(--green), var(--green-2));
            box-shadow: 0 22px 55px rgba(53,208,127,.28);
        }

        .btn-hero-primary:hover {
            color: var(--dark);
            transform: translateY(-3px);
            box-shadow: 0 28px 68px rgba(53,208,127,.35);
        }

        .btn-hero-ghost {
            color: white;
            background: rgba(255,255,255,.08);
            border: 1px solid rgba(255,255,255,.16);
        }

        .btn-hero-ghost:hover {
            color: white;
            background: rgba(255,255,255,.14);
            transform: translateY(-3px);
        }

        .hero-points {
            display: flex;
            flex-wrap: wrap;
            gap: .75rem;
            margin-top: 2rem;
            animation: fadeUp .75s .32s ease both;
        }

        .hero-pill {
            display: inline-flex;
            align-items: center;
            gap: .45rem;
            border-radius: 999px;
            padding: .58rem .85rem;
            background: rgba(255,255,255,.08);
            border: 1px solid rgba(255,255,255,.12);
            color: rgba(255,255,255,.76);
            font-size: .82rem;
            font-weight: 700;
        }

        /* =======================
           MEAL PLAN PREVIEW
        ======================= */
        .meal-preview {
            position: relative;
            z-index: 4;
            max-width: 470px;
            margin-left: auto;
            border-radius: 34px;
            overflow: hidden;
            background: #FFFDF7;
            color: var(--dark);
            border: 1px solid rgba(255,255,255,.42);
            box-shadow: 0 34px 90px rgba(0,0,0,.28);
        }

        .meal-preview-header {
            padding: 1.25rem 1.25rem .9rem;
            background:
                linear-gradient(rgba(8,17,12,.04), rgba(8,17,12,.04)),
                #FFFDF7;
            border-bottom: 1px solid rgba(8,17,12,.08);
        }

        .preview-label {
            color: #16A34A;
            font-size: .72rem;
            font-weight: 900;
            letter-spacing: .12em;
            text-transform: uppercase;
            margin-bottom: .45rem;
        }

        .meal-preview-header h3 {
            font-size: 1.28rem;
            font-weight: 900;
            letter-spacing: -.04em;
            margin: 0;
        }

        .preview-target {
            display: inline-flex;
            align-items: center;
            gap: .45rem;
            margin-top: .75rem;
            padding: .45rem .7rem;
            border-radius: 999px;
            background: #F4FFF7;
            color: #166534;
            font-size: .78rem;
            font-weight: 800;
        }

        .preview-list {
            padding: .9rem;
        }

        .preview-meal {
            display: grid;
            grid-template-columns: 84px 1fr auto;
            gap: .85rem;
            align-items: center;
            padding: .75rem;
            border-radius: 22px;
            background: white;
            border: 1px solid rgba(8,17,12,.07);
            margin-bottom: .75rem;
        }

        .preview-meal:last-child {
            margin-bottom: 0;
        }

        .preview-photo {
            width: 84px;
            aspect-ratio: 4 / 3;
            border-radius: 16px;
            overflow: hidden;
            background: #EEF7EA;
        }

        .preview-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .preview-time {
            color: #667085;
            font-size: .72rem;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: .08em;
        }

        .preview-name {
            color: var(--dark);
            font-weight: 900;
            font-size: .95rem;
            margin: .15rem 0;
        }

        .preview-meta {
            color: #667085;
            font-size: .76rem;
            font-weight: 700;
        }

        .preview-kcal {
            min-width: 58px;
            text-align: center;
            padding: .48rem .55rem;
            border-radius: 16px;
            background: #F4FFF7;
            color: #166534;
            font-size: .8rem;
            font-weight: 900;
        }

        .preview-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            padding: 1rem 1.25rem 1.2rem;
            background: #F8FBF6;
            border-top: 1px solid rgba(8,17,12,.08);
        }

        .preview-footer span {
            color: #475467;
            font-size: .82rem;
            font-weight: 800;
        }

        .preview-score {
            color: #16A34A;
            font-weight: 900;
        }

        /* =======================
           MARQUEE
        ======================= */
        .marquee-section {
            margin-top: -2.2rem;
            position: relative;
            z-index: 5;
        }

        .marquee {
            overflow: hidden;
            border-radius: 999px;
            background: white;
            border: 1px solid rgba(8,17,12,.08);
            box-shadow: 0 20px 70px rgba(8,17,12,.08);
            padding: .9rem 0;
        }

        .marquee-track {
            display: flex;
            gap: 2rem;
            white-space: nowrap;
            animation: marqueeMove 22s linear infinite;
        }

        .marquee-item {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            color: #344054;
            font-size: .9rem;
            font-weight: 800;
        }

        .marquee-item i {
            color: #16A34A;
        }

        @keyframes marqueeMove {
            from { transform: translateX(0); }
            to { transform: translateX(-50%); }
        }

        /* =======================
           SECTIONS
        ======================= */
        .section-padding {
            padding: 6rem 0;
        }

        .section-kicker {
            color: #16A34A;
            font-size: .78rem;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: .12em;
            margin-bottom: .75rem;
        }

        .section-title {
            font-family: 'Instrument Serif', serif;
            color: var(--dark);
            font-size: clamp(2.6rem, 5vw, 5rem);
            line-height: .9;
            letter-spacing: -.055em;
            margin-bottom: 1rem;
        }

        .section-desc {
            color: var(--muted);
            font-size: 1rem;
            line-height: 1.8;
            max-width: 660px;
        }

        /* =======================
           BENTO FEATURES
        ======================= */
        .bento-grid {
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            gap: 1rem;
            margin-top: 3rem;
        }

        .bento-card {
            min-height: 250px;
            border-radius: 36px;
            padding: 1.6rem;
            background: rgba(255,255,255,.78);
            border: 1px solid rgba(8,17,12,.08);
            box-shadow: 0 20px 70px rgba(8,17,12,.07);
            backdrop-filter: blur(20px);
            position: relative;
            overflow: hidden;
            transition: .25s ease;
        }

        .bento-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 30px 90px rgba(8,17,12,.12);
        }

        .bento-card.large {
            grid-column: span 7;
        }

        .bento-card.medium {
            grid-column: span 5;
        }

        .bento-card.small {
            grid-column: span 4;
        }

        .bento-card::after {
            content: "";
            position: absolute;
            width: 220px;
            height: 220px;
            border-radius: 50%;
            right: -100px;
            bottom: -100px;
            background: rgba(53,208,127,.12);
        }

        .bento-icon {
            width: 58px;
            height: 58px;
            border-radius: 22px;
            display: grid;
            place-items: center;
            color: var(--dark);
            background: #DFFFEA;
            font-size: 1.55rem;
            margin-bottom: 1.2rem;
            position: relative;
            z-index: 2;
        }

        .bento-card h3 {
            position: relative;
            z-index: 2;
            color: var(--dark);
            font-size: 1.28rem;
            font-weight: 900;
            letter-spacing: -.04em;
            margin-bottom: .7rem;
        }

        .bento-card p {
            position: relative;
            z-index: 2;
            color: #667085;
            line-height: 1.75;
            font-size: .95rem;
            margin: 0;
        }

        .bento-big-text {
            position: absolute;
            right: 1.4rem;
            bottom: .8rem;
            font-family: 'Instrument Serif', serif;
            font-size: 5rem;
            line-height: 1;
            color: rgba(8,17,12,.07);
            z-index: 1;
        }

        /* =======================
           HOW IT WORKS
        ======================= */
        .journey {
            position: relative;
            margin-top: 3rem;
        }

        .journey::before {
            content: "";
            position: absolute;
            top: 34px;
            bottom: 34px;
            left: 50%;
            width: 2px;
            transform: translateX(-50%);
            background: linear-gradient(to bottom, transparent, rgba(22,163,74,.35), transparent);
        }

        .journey-row {
            display: grid;
            grid-template-columns: 1fr 92px 1fr;
            gap: 1.5rem;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .journey-row:last-child {
            margin-bottom: 0;
        }

        .journey-box {
            border-radius: 32px;
            padding: 1.4rem;
            background: rgba(255,255,255,.82);
            border: 1px solid rgba(8,17,12,.08);
            box-shadow: 0 20px 70px rgba(8,17,12,.07);
        }

        .journey-box h4 {
            color: var(--dark);
            font-size: 1.05rem;
            font-weight: 900;
            letter-spacing: -.03em;
            margin-bottom: .5rem;
        }

        .journey-box p {
            color: #667085;
            font-size: .92rem;
            line-height: 1.7;
            margin: 0;
        }

        .journey-number {
            width: 72px;
            height: 72px;
            margin: 0 auto;
            border-radius: 50%;
            display: grid;
            place-items: center;
            color: var(--dark);
            background: linear-gradient(135deg, var(--green), var(--green-2));
            font-weight: 900;
            font-size: 1.15rem;
            box-shadow: 0 18px 45px rgba(53,208,127,.3);
            position: relative;
            z-index: 3;
        }

        .empty-cell {
            min-height: 1px;
        }

        /* =======================
           CTA
        ======================= */
        .cta-zone {
            padding: 6rem 0 7rem;
        }

        .cta-card {
            position: relative;
            overflow: hidden;
            border-radius: 56px;
            padding: clamp(2.3rem, 6vw, 5rem);
            background:
                radial-gradient(circle at 20% 20%, rgba(53,208,127,.28), transparent 28%),
                radial-gradient(circle at 86% 24%, rgba(167,243,91,.22), transparent 28%),
                linear-gradient(135deg, #08110C, #122D1D);
            color: white;
            box-shadow: var(--shadow);
            text-align: center;
        }

        .cta-card h2 {
            position: relative;
            z-index: 2;
            font-family: 'Instrument Serif', serif;
            font-size: clamp(3rem, 6vw, 6rem);
            line-height: .88;
            letter-spacing: -.06em;
            margin-bottom: 1.2rem;
        }

        .cta-card p {
            position: relative;
            z-index: 2;
            max-width: 620px;
            margin: 0 auto 2rem;
            color: rgba(255,255,255,.72);
            line-height: 1.8;
        }

        .btn-cta {
            position: relative;
            z-index: 2;
            color: var(--dark);
            background: linear-gradient(135deg, var(--green), var(--green-2));
            box-shadow: 0 22px 55px rgba(53,208,127,.25);
        }

        .btn-cta:hover {
            color: var(--dark);
            transform: translateY(-3px);
        }
        

        

        /* =======================
           FOOTER
        ======================= */
        .nt-footer {
            padding: 2.4rem 0;
            background: white;
            border-top: 1px solid rgba(8,17,12,.08);
        }

        .footer-brand {
            color: var(--dark);
            font-weight: 900;
            letter-spacing: -.04em;
            font-size: 1.15rem;
        }

        .footer-brand span {
            color: #16A34A;
        }

        /* =======================
           ANIMATIONS
        ======================= */
        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(28px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: .65s ease;
        }

        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* =======================
           RESPONSIVE
        ======================= */
        @media (max-width: 991px) {
            .nt-nav {
                top: 10px;
            }

            .hero {
                padding-top: 6.8rem;
            }

            .hero-shell {
                border-radius: 38px;
            }

            .meal-preview {
                margin: 1.5rem auto 0;
            }

            .bento-card.large,
            .bento-card.medium,
            .bento-card.small {
                grid-column: span 12;
            }

            .journey::before {
                left: 36px;
                transform: none;
            }

            .journey-row {
                grid-template-columns: 72px 1fr;
            }

            .journey-number {
                grid-column: 1;
                grid-row: 1;
                width: 64px;
                height: 64px;
            }

            .journey-box {
                grid-column: 2;
            }

            .empty-cell {
                display: none;
            }
        }

        @media (max-width: 767px) {
            .nav-shell {
                border-radius: 28px;
            }

            .brand {
                font-size: 1rem;
            }

            .brand-mark {
                width: 32px;
                height: 32px;
            }

            .nav-link-item {
                display: none;
            }

            .btn-nav-login,
            .btn-nav-signup {
                font-size: .78rem;
                padding: .5rem .8rem;
            }

            .hero-title {
                font-size: 4rem;
            }

            .hero-desc {
                font-size: .96rem;
            }

            .meal-preview {
                border-radius: 26px;
            }

            .preview-meal {
                grid-template-columns: 72px 1fr;
                align-items: start;
            }

            .preview-photo {
                width: 72px;
            }

            .preview-kcal {
                grid-column: 2;
                width: fit-content;
            }

            .preview-footer {
                align-items: flex-start;
                flex-direction: column;
            }

            .btn-hero-primary,
            .btn-hero-ghost,
            .btn-cta {
                width: 100%;
            }

            .section-padding,
            .cta-zone {
                padding: 4.5rem 0;
            }

            .section-title {
                font-size: 3.2rem;
            }

            .journey-row {
                gap: 1rem;
            }

            .journey-box {
                padding: 1.1rem;
            }
        }
    </style>
</head>

<body>
<div class="site-bg"></div>
<div class="floating-noise"></div>

{{-- ===================== NAVBAR ===================== --}}
<nav class="nt-nav">
    <div class="container">
        <div class="nav-shell d-flex align-items-center justify-content-between">
            <a href="{{ url('/') }}" class="brand">
                <span class="brand-mark">
                    <i class="bi bi-leaf-fill"></i>
                </span>
                <span>Nutri<span>Track</span></span>
            </a>

            <div class="d-none d-lg-flex align-items-center gap-1">
                <a href="#features" class="nav-link-item">Features</a>
                <a href="#how-it-works" class="nav-link-item">How It Works</a>
            </div>

            <div class="d-flex align-items-center gap-2">
                @if(Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn-nav-signup">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="btn-nav-login">Log in</a>
                        @if(Route::has('register'))
                            <a href="{{ route('register') }}" class="btn-nav-signup">Get started</a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </div>
</nav>

{{-- ===================== HERO ===================== --}}
<section class="hero">
    <div class="container">
        <div class="hero-shell">
            <div class="row align-items-center g-5">
                <div class="col-12 col-lg-7">
                    <div class="hero-content">
                        <div class="eyebrow">
                            <i class="bi bi-stars"></i>
                            Personalized Healthy Meal Recommendation System
                        </div>

                        <h1 class="hero-title">
                            Meal planning that starts with <em>your profile.</em>
                        </h1>

                        <p class="hero-desc">
                            NutriTrack is a web-based FYP system that recommends healthier meals using
                            daily calorie needs, allergies, goals, and cuisine preference. It helps users
                            choose meals with clearer nutrition context, not guesswork.
                        </p>

                        <div class="hero-actions">
                            <a href="{{ route('guest.quiz') }}" class="btn-hero-primary">
                                <i class="bi bi-clipboard2-pulse-fill"></i>
                                Start guest quiz
                            </a>

                            <a href="#how-it-works" class="btn-hero-ghost">
                                <i class="bi bi-play-circle-fill"></i>
                                See how it works
                            </a>
                        </div>

                        <div class="hero-points">
                            <div class="hero-pill">
                                <i class="bi bi-calculator-fill" style="color: var(--green);"></i>
                                DCR-based planning
                            </div>

                            <div class="hero-pill">
                                <i class="bi bi-shield-check-fill" style="color: var(--green-2);"></i>
                                Allergy-aware filtering
                            </div>

                            <div class="hero-pill">
                                <i class="bi bi-cup-hot-fill" style="color: var(--orange);"></i>
                                Cuisine preference matching
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-5">
                    <div class="meal-preview">
                        <div class="meal-preview-header">
                            <div class="preview-label">Today's Meal Plan Preview</div>
                            <h3>A full day built around one calorie target.</h3>
                            <div class="preview-target">
                                <i class="bi bi-bullseye"></i>
                                1,850 kcal target · Western preference
                            </div>
                        </div>

                        <div class="preview-list">
                            <div class="preview-meal">
                                <div class="preview-photo">
                                    <img src="https://images.unsplash.com/photo-1525351484163-7529414344d8?auto=format&fit=crop&w=420&q=80" alt="Avocado toast breakfast">
                                </div>
                                <div>
                                    <div class="preview-time">Breakfast</div>
                                    <div class="preview-name">Avocado Toast</div>
                                    <div class="preview-meta">egg · wholegrain · balanced fat</div>
                                </div>
                                <div class="preview-kcal">340</div>
                            </div>

                            <div class="preview-meal">
                                <div class="preview-photo">
                                    <img src="https://images.unsplash.com/photo-1553909489-cd47e0907980?auto=format&fit=crop&w=420&q=80" alt="Chicken sandwich lunch">
                                </div>
                                <div>
                                    <div class="preview-time">Lunch</div>
                                    <div class="preview-name">Chicken Sandwich</div>
                                    <div class="preview-meta">lean protein · vegetables</div>
                                </div>
                                <div class="preview-kcal">480</div>
                            </div>

                            <div class="preview-meal">
                                <div class="preview-photo">
                                    <img src="https://images.unsplash.com/photo-1512621776951-a57141f2eefd?auto=format&fit=crop&w=420&q=80" alt="Salmon bowl dinner">
                                </div>
                                <div>
                                    <div class="preview-time">Dinner</div>
                                    <div class="preview-name">Salmon Quinoa Bowl</div>
                                    <div class="preview-meta">protein · fibre · steady energy</div>
                                </div>
                                <div class="preview-kcal">520</div>
                            </div>

                            <div class="preview-meal">
                                <div class="preview-photo">
                                    <img src="https://images.unsplash.com/photo-1488477181946-6428a0291777?auto=format&fit=crop&w=420&q=80" alt="Yogurt and fruit snack">
                                </div>
                                <div>
                                    <div class="preview-time">Snack</div>
                                    <div class="preview-name">Yogurt Fruit Cup</div>
                                    <div class="preview-meta">simple snack · lower sugar</div>
                                </div>
                                <div class="preview-kcal">210</div>
                            </div>
                        </div>

                        <div class="preview-footer">
                            <span><i class="bi bi-shield-check me-1"></i> Allergens checked before ranking</span>
                            <span class="preview-score">92% fit</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Moving benefits strip --}}
        <div class="marquee-section">
            <div class="marquee">
                <div class="marquee-track">
                    <span class="marquee-item"><i class="bi bi-check-circle-fill"></i> Breakfast, lunch, dinner, and snack planning</span>
                    <span class="marquee-item"><i class="bi bi-check-circle-fill"></i> Personalized calorie targets</span>
                    <span class="marquee-item"><i class="bi bi-check-circle-fill"></i> Allergy-aware recommendations</span>
                    <span class="marquee-item"><i class="bi bi-check-circle-fill"></i> Meal Log support</span>
                    <span class="marquee-item"><i class="bi bi-check-circle-fill"></i> Swap and rate meals</span>

                    <span class="marquee-item"><i class="bi bi-check-circle-fill"></i> Breakfast, lunch, dinner, and snack planning</span>
                    <span class="marquee-item"><i class="bi bi-check-circle-fill"></i> Personalized calorie targets</span>
                    <span class="marquee-item"><i class="bi bi-check-circle-fill"></i> Allergy-aware recommendations</span>
                    <span class="marquee-item"><i class="bi bi-check-circle-fill"></i> Meal Log support</span>
                    <span class="marquee-item"><i class="bi bi-check-circle-fill"></i> Swap and rate meals</span>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ===================== FEATURES ===================== --}}
<section class="section-padding" id="features">
    <div class="container">
        <div class="row align-items-end g-4">
            <div class="col-12 col-lg-7 reveal">
                <div class="section-kicker">What NutriTrack does</div>
                <h2 class="section-title">A practical flow for everyday meal decisions.</h2>
            </div>

            <div class="col-12 col-lg-5 reveal">
                <p class="section-desc ms-lg-auto">
                    The system connects profile data, calorie calculation, allergy checks, and meal scoring
                    into one student-friendly workflow for planning, choosing, and saving meals.
                </p>
            </div>
        </div>

        <div class="bento-grid">
            <div class="bento-card large reveal">
                <div class="bento-icon">
                    <i class="bi bi-calculator-fill"></i>
                </div>
                <h3>Daily calorie target calculation</h3>
                <p>
                    NutriTrack estimates BMR, TDEE, and Daily Caloric Requirement from age, weight,
                    height, activity level, and health goal before meals are recommended.
                </p>
                <div class="bento-big-text">DCR</div>
            </div>

            <div class="bento-card medium reveal">
                <div class="bento-icon" style="background: #FFF2D8;">
                    <i class="bi bi-shield-check-fill"></i>
                </div>
                <h3>Allergy-aware meal filtering</h3>
                <p>
                    Meals that may contain declared allergens are removed early so the recommendation list
                    is safer and easier to review.
                </p>
                <div class="bento-big-text">Safe</div>
            </div>

            <div class="bento-card small reveal">
                <div class="bento-icon" style="background: #E0F2FE;">
                    <i class="bi bi-cup-hot-fill"></i>
                </div>
                <h3>Cuisine preference matching</h3>
                <p>
                    Meal ranking considers the user's selected cuisine preference such as Malay, Chinese,
                    Indian, Western, or Middle Eastern.
                </p>
                <div class="bento-big-text">Taste</div>
            </div>

            <div class="bento-card small reveal">
                <div class="bento-icon" style="background: #F3E8FF;">
                    <i class="bi bi-calendar-week-fill"></i>
                </div>
                <h3>Weekly meal planning</h3>
                <p>
                    Users can generate a weekly view when they want structure beyond today's meals.
                </p>
                <div class="bento-big-text">Plan</div>
            </div>

            <div class="bento-card small reveal">
                <div class="bento-icon" style="background: #FFE4E6;">
                    <i class="bi bi-arrow-repeat"></i>
                </div>
                <h3>Swap and rate meals</h3>
                <p>
                    Meal Options let users refresh, compare, rate, and save the meals that fit them best.
                </p>
                <div class="bento-big-text">Rate</div>
            </div>

            <div class="bento-card medium reveal">
                <div class="bento-icon" style="background: #DCFCE7;">
                    <i class="bi bi-journal-check"></i>
                </div>
                <h3>Personal Meal Log</h3>
                <p>
                    Recommended meals can be saved into a personal Meal Log, allowing users to review
                    their saved meals anytime.
                </p>
                <div class="bento-big-text">Log</div>
            </div>

            <div class="bento-card large reveal">
                <div class="bento-icon" style="background: #FEF9C3;">
                    <i class="bi bi-magic"></i>
                </div>
                <h3>AI food logger support</h3>
                <p>
                    Users can describe a meal in normal language and receive estimated calories and macros
                    for quicker food intake tracking.
                </p>
                <div class="bento-big-text">AI</div>
            </div>
        </div>
    </div>
</section>

{{-- ===================== HOW IT WORKS ===================== --}}
<section class="section-padding" id="how-it-works">
    <div class="container">
        <div class="text-center reveal">
            <div class="section-kicker">How it works</div>
            <h2 class="section-title">From profile to plate.</h2>
            <p class="section-desc mx-auto">
                NutriTrack keeps the flow simple, but the recommendation logic works behind the scenes
                to make each result more suitable for the user.
            </p>
        </div>

        <div class="journey">
            <div class="journey-row reveal">
                <div class="journey-box">
                    <h4><i class="bi bi-person-plus-fill me-1" style="color:#16A34A;"></i> Create your account</h4>
                    <p>Users register and access NutriTrack through a secure account.</p>
                </div>
                <div class="journey-number">01</div>
                <div class="empty-cell"></div>
            </div>

            <div class="journey-row reveal">
                <div class="empty-cell"></div>
                <div class="journey-number">02</div>
                <div class="journey-box">
                    <h4><i class="bi bi-clipboard2-pulse-fill me-1" style="color:#16A34A;"></i> Complete health profile</h4>
                    <p>Users enter their age, height, weight, activity level, goal, allergies, and cuisine preference.</p>
                </div>
            </div>

            <div class="journey-row reveal">
                <div class="journey-box">
                    <h4><i class="bi bi-calculator-fill me-1" style="color:#16A34A;"></i> Calculate calorie needs</h4>
                    <p>The system calculates BMR, TDEE, and Daily Caloric Requirement.</p>
                </div>
                <div class="journey-number">03</div>
                <div class="empty-cell"></div>
            </div>

            <div class="journey-row reveal">
                <div class="empty-cell"></div>
                <div class="journey-number">04</div>
                <div class="journey-box">
                    <h4><i class="bi bi-stars me-1" style="color:#16A34A;"></i> Recommend safe meals</h4>
                    <p>Meals are filtered for allergies and ranked based on calorie gap and cuisine preference.</p>
                </div>
            </div>

            <div class="journey-row reveal">
                <div class="journey-box">
                    <h4><i class="bi bi-journal-check me-1" style="color:#16A34A;"></i> Save to Meal Log</h4>
                    <p>Users can save selected meals and review them later in their personal Meal Log.</p>
                </div>
                <div class="journey-number">05</div>
                <div class="empty-cell"></div>
            </div>
        </div>
    </div>
</section>

{{-- ===================== CTA ===================== --}}
<section class="cta-zone">
    <div class="container">
        <div class="cta-card reveal">
            <h2>Plan meals that fit your real life.</h2>
            <p>
                Start your profile and let NutriTrack recommend meals based on your body,
                your goal, your allergies, and your food preference.
            </p>

            <div class="d-flex justify-content-center gap-3 flex-wrap">
                <a href="{{ route('register') }}" class="btn-cta">
                    <i class="bi bi-rocket-takeoff-fill"></i>
                    Create free account
                </a>

                <a href="{{ route('login') }}" class="btn-hero-ghost">
                    <i class="bi bi-box-arrow-in-right"></i>
                    Log in
                </a>
            </div>
        </div>
    </div>
</section>
{{-- ===================== NUTRITION GUIDE TEASER ===================== --}}
<section class="section-padding">
    <div class="container">
        <div class="row align-items-center g-4">
            <div class="col-12 col-lg-6">
                <div class="section-kicker">Nutrition Guide</div>

                <h2 class="section-title">
                    New to calories?
                </h2>

                <p class="section-desc">
                    NutriTrack helps users understand basic nutrition terms such as BMI, BMR, TDEE, DCR,
                    calorie deficit, and calorie surplus before they start using the meal recommendation system.
                </p>

                <div class="mt-4 d-flex gap-3 flex-wrap">
                    @auth
                        <a href="{{ route('nutrition-guide') }}" class="btn-cta">
                            <i class="bi bi-book-fill"></i>
                            Open Nutrition Guide
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="btn-cta">
                            <i class="bi bi-person-plus-fill"></i>
                            Create account to learn
                        </a>

                        <a href="{{ route('guest.quiz') }}" class="btn-hero-ghost" style="color:var(--dark);border-color:rgba(8,17,12,.12);background:white;">
                            <i class="bi bi-clipboard2-pulse-fill"></i>
                            Try guest quiz
                        </a>
                    @endauth
                </div>
            </div>

            <div class="col-12 col-lg-6">
                <div class="bento-card reveal" style="min-height:auto;">
                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <div style="border-radius:24px;padding:1rem;background:#F4FFF7;border:1px solid rgba(22,163,74,.12);height:100%;">
                                <div style="font-size:1.65rem;margin-bottom:.5rem;color:#16A34A;"><i class="bi bi-activity"></i></div>
                                <h5 style="font-weight:900;color:var(--dark);">BMR & TDEE</h5>
                                <p style="color:var(--muted);font-size:.9rem;line-height:1.7;margin:0;">
                                    Learn how your body burns calories at rest and during daily activity.
                                </p>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div style="border-radius:24px;padding:1rem;background:#FFF8E8;border:1px solid rgba(249,115,22,.12);height:100%;">
                                <div style="font-size:1.65rem;margin-bottom:.5rem;color:#F97316;"><i class="bi bi-bullseye"></i></div>
                                <h5 style="font-weight:900;color:var(--dark);">DCR</h5>
                                <p style="color:var(--muted);font-size:.9rem;line-height:1.7;margin:0;">
                                    Understand how NutriTrack adjusts calories based on lose, maintain, or gain weight goals.
                                </p>
                            </div>
                        </div>

                        <div class="col-12">
                            <div style="border-radius:24px;padding:1rem;background:#F0F9FF;border:1px solid rgba(14,165,233,.12);">
                                <div style="font-size:1.65rem;margin-bottom:.5rem;color:#0284C7;"><i class="bi bi-pie-chart-fill"></i></div>
                                <h5 style="font-weight:900;color:var(--dark);">Meal calorie split</h5>
                                <p style="color:var(--muted);font-size:.9rem;line-height:1.7;margin:0;">
                                    See how NutriTrack divides daily calories into breakfast, lunch, dinner, and snack targets.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
   </div>
</section>

{{-- ===================== FOOTER ===================== --}}
<footer class="nt-footer">
    <div class="container">
        <div class="row align-items-center g-3">
            <div class="col-12 col-md-6 text-center text-md-start">
                <div class="footer-brand">Nutri<span>Track</span></div>
                <small class="text-muted">Personalized Healthy Meal Recommendation System</small><br>
                <small class="text-muted">Final Year Project — Iffah Binti Ishak, UiTM 2026</small>
            </div>

            <div class="col-12 col-md-6 text-center text-md-end">
                <small class="text-muted">Built with Laravel 12 · Bootstrap 5 · MySQL</small><br>
                <small class="text-muted">© {{ date('Y') }} NutriTrack. All rights reserved.</small>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                observer.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.12
    });

    document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
</script>
</body>
</html>
