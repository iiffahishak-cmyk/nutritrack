<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NutriTrack - Personalized Healthy Meal Recommendations</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,600;9..144,700;9..144,800&family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        :root {
            --cream: #fbf1df;
            --paper: #fffaf0;
            --paper-2: #f7ead6;
            --ink: #1f2933;
            --muted: #697064;
            --navy: #14213d;
            --green: #315f43;
            --green-2: #dcebd2;
            --green-3: #edf5e7;
            --terracotta: #c96f4a;
            --terracotta-2: #f2d5c3;
            --mustard: #e3aa43;
            --line: rgba(31, 41, 51, .12);
            --shadow: 0 24px 70px rgba(20, 33, 61, .13);
            --radius-xl: 34px;
            --radius-lg: 24px;
        }

        * { box-sizing: border-box; }

        html { scroll-behavior: smooth; }

        body {
            margin: 0;
            font-family: "Inter", sans-serif;
            color: var(--ink);
            background:
                radial-gradient(circle at top left, rgba(201,111,74,.16), transparent 34rem),
                radial-gradient(circle at 85% 10%, rgba(49,95,67,.16), transparent 30rem),
                linear-gradient(90deg, rgba(31,41,51,.035) 1px, transparent 1px),
                linear-gradient(rgba(31,41,51,.035) 1px, transparent 1px),
                var(--cream);
            background-size: auto, auto, 78px 78px, 78px 78px, auto;
            overflow-x: hidden;
        }

        a { text-decoration: none; }
        img { max-width: 100%; }

        .shell {
            width: min(1180px, calc(100% - 2rem));
            margin: 0 auto;
        }

        .nt-nav {
            position: sticky;
            top: 0;
            z-index: 1000;
            padding: .8rem 0;
            background: rgba(251, 241, 223, .88);
            backdrop-filter: blur(18px);
            border-bottom: 1px solid rgba(31, 41, 51, .08);
        }

        .nav-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
        }

        .brand {
            display: inline-flex;
            align-items: center;
            gap: .75rem;
            color: var(--navy);
            font-weight: 900;
            letter-spacing: -.05em;
            font-size: 1.18rem;
        }

        .brand:hover { color: var(--navy); }

        .brand-icon {
            width: 43px;
            height: 43px;
            display: grid;
            place-items: center;
            border-radius: 16px 16px 16px 6px;
            color: var(--paper);
            background: var(--green);
            box-shadow: 0 14px 30px rgba(49, 95, 67, .22);
        }

        .brand strong span { color: var(--terracotta); }

        .nav-menu {
            display: flex;
            align-items: center;
            gap: .3rem;
            padding: .35rem;
            border-radius: 999px;
            background: rgba(255, 250, 240, .74);
            border: 1px solid rgba(31, 41, 51, .08);
        }

        .nav-menu a {
            color: #5e675a;
            font-size: .84rem;
            font-weight: 800;
            padding: .52rem .78rem;
            border-radius: 999px;
        }

        .nav-menu a:hover {
            color: var(--navy);
            background: var(--green-3);
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: .6rem;
        }

        .btn-nt {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: .5rem;
            min-height: 42px;
            padding: .72rem 1rem;
            border-radius: 999px;
            font-size: .85rem;
            font-weight: 900;
            line-height: 1;
            transition: .18s ease;
            white-space: nowrap;
        }

        .btn-nt:hover { transform: translateY(-1px); }

        .btn-primary-nt {
            color: var(--paper);
            background: var(--green);
            box-shadow: 0 16px 34px rgba(49, 95, 67, .23);
        }

        .btn-primary-nt:hover { color: var(--paper); background: #254b35; }

        .btn-light-nt {
            color: var(--navy);
            background: rgba(255, 250, 240, .85);
            border: 1px solid rgba(31, 41, 51, .1);
        }

        .btn-light-nt:hover { color: var(--navy); background: #fffdf7; }

        .btn-warm-nt {
            color: var(--paper);
            background: var(--terracotta);
            box-shadow: 0 16px 34px rgba(201, 111, 74, .22);
        }

        .btn-warm-nt:hover { color: var(--paper); background: #b75f3f; }

        .hero {
            padding: clamp(3.2rem, 6vw, 5.8rem) 0 4.8rem;
        }

        .hero-grid {
            display: grid;
            grid-template-columns: minmax(0, 1.05fr) minmax(390px, .95fr);
            gap: clamp(2rem, 5vw, 4.5rem);
            align-items: center;
        }

        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: .55rem;
            color: #8a462e;
            background: rgba(201, 111, 74, .14);
            border: 1px solid rgba(201, 111, 74, .2);
            border-radius: 999px;
            padding: .55rem .85rem;
            font-size: .74rem;
            font-weight: 900;
            letter-spacing: .11em;
            text-transform: uppercase;
            margin-bottom: 1.25rem;
        }

        .hero h1 {
            max-width: 760px;
            margin: 0;
            font-family: "Fraunces", serif;
            color: var(--navy);
            font-size: clamp(3.35rem, 7.2vw, 6.9rem);
            line-height: .88;
            letter-spacing: -.07em;
        }

        .hero h1 span {
            color: var(--terracotta);
            font-style: italic;
        }

        .hero-copy {
            max-width: 640px;
            margin: 1.35rem 0 0;
            color: #5d665a;
            font-size: 1.03rem;
            line-height: 1.85;
        }

        .hero-actions {
            display: flex;
            flex-wrap: wrap;
            gap: .75rem;
            margin-top: 1.7rem;
        }

        .hero-tags {
            display: flex;
            flex-wrap: wrap;
            gap: .65rem;
            margin-top: 1.7rem;
        }

        .hero-tag {
            display: inline-flex;
            align-items: center;
            gap: .42rem;
            color: #4d574b;
            background: rgba(255,250,240,.72);
            border: 1px solid rgba(31,41,51,.08);
            border-radius: 999px;
            padding: .54rem .74rem;
            font-size: .8rem;
            font-weight: 800;
        }

        .hero-tag i { color: var(--green); }

        .planner-board {
            position: relative;
            padding: 1rem;
            border-radius: 42px;
            background: rgba(255,250,240,.58);
            border: 1px solid rgba(31,41,51,.09);
            box-shadow: var(--shadow);
        }

        .planner-board::before {
            content: "";
            position: absolute;
            width: 150px;
            height: 150px;
            right: -36px;
            top: -38px;
            border-radius: 50%;
            background: rgba(227,170,67,.2);
            z-index: -1;
        }

        .meal-photo {
            position: relative;
            min-height: 220px;
            overflow: hidden;
            border-radius: 32px;
            background: #d7c8b3;
        }

        .meal-photo img {
            width: 100%;
            height: 100%;
            min-height: 220px;
            object-fit: cover;
            display: block;
        }

        .meal-photo::after {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(20,33,61,.05), rgba(20,33,61,.52));
        }

        .photo-label {
            position: absolute;
            left: 1rem;
            right: 1rem;
            bottom: 1rem;
            z-index: 2;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: .8rem;
            color: var(--paper);
        }

        .photo-label small {
            display: block;
            margin-bottom: .25rem;
            font-size: .7rem;
            font-weight: 900;
            letter-spacing: .13em;
            text-transform: uppercase;
            opacity: .86;
        }

        .photo-label strong {
            font-size: 1.25rem;
            font-weight: 900;
            letter-spacing: -.04em;
        }

        .fit-score {
            flex: 0 0 auto;
            border-radius: 18px;
            padding: .7rem .8rem;
            background: rgba(255,250,240,.18);
            border: 1px solid rgba(255,250,240,.22);
            backdrop-filter: blur(10px);
            text-align: center;
            font-weight: 900;
        }

        .fit-score span {
            display: block;
            font-size: .62rem;
            opacity: .82;
            text-transform: uppercase;
            letter-spacing: .08em;
        }

        .meal-receipt {
            position: relative;
            margin: -1.4rem 1rem 0;
            z-index: 3;
            padding: 1rem;
            border-radius: 28px;
            background: var(--paper);
            border: 1px solid rgba(31,41,51,.09);
            box-shadow: 0 18px 45px rgba(20,33,61,.12);
        }

        .receipt-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            padding-bottom: .9rem;
            border-bottom: 1px dashed rgba(31,41,51,.18);
        }

        .receipt-head h2 {
            margin: 0;
            color: var(--navy);
            font-size: 1.18rem;
            font-weight: 900;
            letter-spacing: -.04em;
        }

        .receipt-head p {
            margin: .25rem 0 0;
            color: var(--muted);
            font-size: .78rem;
            font-weight: 700;
        }

        .target-box {
            flex: 0 0 auto;
            padding: .72rem .85rem;
            border-radius: 18px;
            color: var(--green);
            background: var(--green-2);
            text-align: center;
            font-weight: 900;
            line-height: 1.12;
        }

        .target-box span {
            display: block;
            color: #6a7466;
            font-size: .62rem;
            text-transform: uppercase;
            letter-spacing: .08em;
        }

        .meal-list {
            display: grid;
            gap: .7rem;
            margin-top: .9rem;
        }

        .meal-row {
            display: grid;
            grid-template-columns: 1fr auto;
            gap: .7rem;
            align-items: center;
            padding: .72rem;
            border-radius: 18px;
            background: #fbf4e8;
            border: 1px solid rgba(31,41,51,.06);
        }

        .meal-time {
            color: #8a462e;
            font-size: .68rem;
            font-weight: 900;
            letter-spacing: .1em;
            text-transform: uppercase;
        }

        .meal-title {
            margin-top: .12rem;
            color: var(--navy);
            font-size: .93rem;
            font-weight: 900;
            letter-spacing: -.025em;
        }

        .meal-meta {
            display: inline-flex;
            align-items: center;
            gap: .32rem;
            margin-top: .22rem;
            color: #68715f;
            font-size: .72rem;
            font-weight: 800;
        }

        .kcal {
            min-width: 66px;
            padding: .58rem .62rem;
            border-radius: 16px;
            color: var(--green);
            background: var(--green-3);
            text-align: center;
            font-size: .84rem;
            font-weight: 900;
        }

        .kcal span {
            display: block;
            color: #717b6b;
            font-size: .58rem;
            letter-spacing: .08em;
            text-transform: uppercase;
        }

        .receipt-note {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            margin-top: .85rem;
            padding: .9rem;
            border-radius: 20px;
            color: #51604d;
            background: var(--green-3);
            font-size: .82rem;
            font-weight: 800;
        }

        .section {
            padding: 5.4rem 0;
        }

        .section.alt {
            background: rgba(255,250,240,.6);
            border-top: 1px solid rgba(31,41,51,.07);
            border-bottom: 1px solid rgba(31,41,51,.07);
        }

        .section-heading {
            max-width: 780px;
            margin-bottom: 2.3rem;
        }

        .kicker {
            color: #8a462e;
            font-size: .76rem;
            font-weight: 900;
            letter-spacing: .13em;
            text-transform: uppercase;
            margin-bottom: .65rem;
        }

        .section-title {
            margin: 0;
            font-family: "Fraunces", serif;
            color: var(--navy);
            font-size: clamp(2.75rem, 5.2vw, 5rem);
            line-height: .92;
            letter-spacing: -.06em;
        }

        .section-copy {
            max-width: 690px;
            margin-top: 1rem;
            color: #5f685c;
            font-size: 1rem;
            line-height: 1.82;
        }

        .pathway {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            overflow: hidden;
            border-radius: 34px;
            background: var(--paper);
            border: 1px solid rgba(31,41,51,.09);
            box-shadow: 0 22px 60px rgba(20,33,61,.08);
        }

        .path-step {
            min-height: 210px;
            padding: 1.2rem;
            border-right: 1px solid rgba(31,41,51,.09);
        }

        .path-step:nth-child(even) { background: #f6ebd8; }
        .path-step:last-child { border-right: 0; }

        .path-no {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 38px;
            height: 38px;
            border-radius: 15px;
            color: var(--paper);
            background: var(--terracotta);
            font-size: .78rem;
            font-weight: 900;
            margin-bottom: 1.4rem;
        }

        .path-step h3 {
            color: var(--navy);
            font-size: 1.02rem;
            font-weight: 900;
            letter-spacing: -.03em;
            margin: 0 0 .55rem;
        }

        .path-step p {
            margin: 0;
            color: #67715f;
            font-size: .9rem;
            line-height: 1.65;
        }

        .personal-layout {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.4rem;
            align-items: stretch;
        }

        .dark-card {
            padding: clamp(1.6rem, 4vw, 2.3rem);
            border-radius: 36px;
            color: var(--paper);
            background: var(--navy);
            box-shadow: var(--shadow);
        }

        .dark-card .kicker { color: #dcebd2; }

        .dark-card h2 {
            margin: 0;
            font-family: "Fraunces", serif;
            font-size: clamp(2.4rem, 4vw, 4.2rem);
            line-height: .95;
            letter-spacing: -.06em;
        }

        .dark-card p {
            margin: 1rem 0 0;
            color: rgba(255,250,240,.72);
            line-height: 1.8;
        }

        .mini-log {
            display: grid;
            gap: .75rem;
            margin-top: 1.35rem;
        }

        .mini-log-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: .9rem;
            padding: .86rem .95rem;
            border-radius: 18px;
            background: rgba(255,250,240,.08);
            border: 1px solid rgba(255,250,240,.1);
            font-size: .87rem;
            font-weight: 800;
        }

        .mini-log-row span {
            color: #dcebd2;
            white-space: nowrap;
        }

        .reason-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .reason-card {
            min-height: 176px;
            padding: 1.2rem;
            border-radius: 28px;
            background: var(--paper);
            border: 1px solid rgba(31,41,51,.09);
        }

        .reason-card.green { background: var(--green-3); }
        .reason-card.warm { background: #f7e1d2; }
        .reason-card.full { grid-column: 1 / -1; min-height: auto; }

        .reason-card i {
            display: inline-flex;
            width: 40px;
            height: 40px;
            align-items: center;
            justify-content: center;
            border-radius: 15px;
            color: var(--paper);
            background: var(--green);
            margin-bottom: .85rem;
        }

        .reason-card h3 {
            margin: 0 0 .5rem;
            color: var(--navy);
            font-size: 1rem;
            font-weight: 900;
            letter-spacing: -.03em;
        }

        .reason-card p {
            margin: 0;
            color: #616b5d;
            font-size: .9rem;
            line-height: 1.65;
        }

        .feature-layout {
            display: grid;
            grid-template-columns: .95fr 1.05fr;
            gap: 2rem;
            align-items: center;
        }

        .feature-photo {
            min-height: 520px;
            overflow: hidden;
            border-radius: 42px;
            background: #e0d0b8;
            box-shadow: var(--shadow);
        }

        .feature-photo img {
            width: 100%;
            height: 100%;
            min-height: 520px;
            object-fit: cover;
            display: block;
        }

        .feature-list {
            display: grid;
            gap: .85rem;
        }

        .feature-row {
            display: grid;
            grid-template-columns: 46px 1fr;
            gap: .95rem;
            padding: 1rem;
            border-radius: 24px;
            background: rgba(255,250,240,.72);
            border: 1px solid rgba(31,41,51,.08);
        }

        .feature-row i {
            width: 46px;
            height: 46px;
            display: grid;
            place-items: center;
            border-radius: 16px;
            color: var(--paper);
            background: var(--terracotta);
        }

        .feature-row h3 {
            margin: 0 0 .3rem;
            color: var(--navy);
            font-size: 1rem;
            font-weight: 900;
        }

        .feature-row p {
            margin: 0;
            color: #626b5c;
            font-size: .92rem;
            line-height: 1.65;
        }

        .testing-strip {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
        }

        .test-card {
            padding: 1.25rem;
            border-radius: 28px;
            background: var(--paper);
            border: 1px solid rgba(31,41,51,.09);
        }

        .test-card strong {
            display: block;
            color: var(--navy);
            font-size: 1rem;
            font-weight: 900;
            margin-bottom: .45rem;
        }

        .test-card p {
            margin: 0;
            color: #626b5c;
            font-size: .9rem;
            line-height: 1.65;
        }

        .cta {
            padding: 5.2rem 0 6.2rem;
        }

        .cta-panel {
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 2rem;
            align-items: center;
            padding: clamp(2rem, 5vw, 4rem);
            border-radius: 42px;
            color: var(--paper);
            background: var(--green);
            box-shadow: var(--shadow);
        }

        .cta-panel h2 {
            max-width: 760px;
            margin: 0;
            font-family: "Fraunces", serif;
            font-size: clamp(2.8rem, 5vw, 5rem);
            line-height: .92;
            letter-spacing: -.06em;
        }

        .cta-panel p {
            max-width: 640px;
            margin: 1rem 0 0;
            color: rgba(255,250,240,.76);
            line-height: 1.8;
        }

        .cta-actions {
            display: flex;
            flex-wrap: wrap;
            gap: .7rem;
        }

        .cta-actions .btn-primary-nt {
            color: var(--green);
            background: var(--paper);
            box-shadow: none;
        }

        .cta-actions .btn-light-nt {
            color: var(--paper);
            background: transparent;
            border-color: rgba(255,250,240,.32);
        }

        .nt-footer {
            padding: 2rem 0;
            background: #efe2cf;
            border-top: 1px solid rgba(31,41,51,.08);
        }

        .footer-grid {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            color: #626b5c;
            font-size: .86rem;
            line-height: 1.7;
        }

        .footer-grid strong { color: var(--navy); }

        .reveal {
            opacity: 0;
            transform: translateY(22px);
            transition: .62s ease;
        }

        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }

        @media (max-width: 991px) {
            .nav-menu { display: none; }

            .hero-grid,
            .personal-layout,
            .feature-layout,
            .cta-panel {
                grid-template-columns: 1fr;
            }

            .planner-board {
                max-width: 590px;
                margin: 0 auto;
            }

            .pathway { grid-template-columns: 1fr; }

            .path-step {
                min-height: auto;
                border-right: 0;
                border-bottom: 1px solid rgba(31,41,51,.09);
            }

            .path-step:last-child { border-bottom: 0; }

            .feature-photo,
            .feature-photo img {
                min-height: 380px;
            }

            .testing-strip { grid-template-columns: 1fr; }
        }

        @media (max-width: 767px) {
            .shell { width: min(100% - 1rem, 1180px); }

            .nav-inner { align-items: flex-start; }
            .brand { font-size: 1rem; }
            .brand-icon { width: 38px; height: 38px; }
            .nav-actions { justify-content: flex-end; flex-wrap: wrap; }

            .btn-nt {
                min-height: 38px;
                padding: .62rem .78rem;
                font-size: .78rem;
            }

            .hero { padding-top: 3rem; }
            .hero h1 { font-size: 3.45rem; }
            .hero-copy { font-size: .96rem; }

            .receipt-head,
            .receipt-note,
            .photo-label {
                align-items: flex-start;
                flex-direction: column;
            }

            .reason-grid { grid-template-columns: 1fr; }
            .reason-card.full { grid-column: auto; }

            .section,
            .cta { padding: 4rem 0; }

            .footer-grid {
                align-items: flex-start;
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
@php
    $quizUrl = Route::has('guest.quiz') ? route('guest.quiz') : url('/quiz');
@endphp

<nav class="nt-nav">
    <div class="shell">
        <div class="nav-inner">
            <a href="{{ url('/') }}" class="brand" aria-label="NutriTrack home">
                <span class="brand-icon"><i class="bi bi-heart-pulse-fill"></i></span>
                <strong>Nutri<span>Track</span></strong>
            </a>

            <div class="nav-menu" aria-label="Landing page navigation">
                <a href="#path">System Flow</a>
                <a href="#personal">Personalization</a>
                <a href="#features">Features</a>
                <a href="#testing">Testing</a>
            </div>

            <div class="nav-actions">
                @if(Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn-nt btn-primary-nt">
                            <i class="bi bi-grid-fill"></i> Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn-nt btn-light-nt">Login</a>
                        @if(Route::has('register'))
                            <a href="{{ route('register') }}" class="btn-nt btn-primary-nt">Get Started</a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </div>
</nav>

<main>
    <section class="hero">
        <div class="shell">
            <div class="hero-grid">
                <div class="reveal">
                    <div class="eyebrow">
                        <i class="bi bi-clipboard2-pulse"></i>
                        Web-based healthy meal planner
                    </div>

                    <h1>Choose meals with a <span>reason</span>, not just a random list.</h1>

                    <p class="hero-copy">
                        NutriTrack helps users calculate their health profile, understand daily calorie needs,
                        and receive meal recommendations based on DCR, allergies, cuisine preference, meal time,
                        nutrition value, and user rating.
                    </p>

                    <div class="hero-actions">
                        <a href="{{ $quizUrl }}" class="btn-nt btn-warm-nt">
                            <i class="bi bi-pencil-square"></i> Try Starter Quiz
                        </a>
                        @if(Route::has('register'))
                            <a href="{{ route('register') }}" class="btn-nt btn-light-nt">
                                Create Account
                            </a>
                        @endif
                    </div>

                    <div class="hero-tags">
                        <span class="hero-tag"><i class="bi bi-check2-circle"></i> BMI, BMR, TDEE and DCR</span>
                        <span class="hero-tag"><i class="bi bi-check2-circle"></i> Daily Plan and Meal Options</span>
                        <span class="hero-tag"><i class="bi bi-check2-circle"></i> AI Food Logger</span>
                    </div>
                </div>

                <aside class="planner-board reveal" aria-label="NutriTrack daily plan preview">
                    <div class="meal-photo">
                        <img src="https://images.unsplash.com/photo-1498837167922-ddd27525d352?auto=format&fit=crop&w=1200&q=80" alt="Healthy meal ingredients arranged on a table">
                        <div class="photo-label">
                            <div>
                                <small>Preview</small>
                                <strong>Today’s NutriTrack Plan</strong>
                            </div>
                            <div class="fit-score">
                                92%
                                <span>Profile fit</span>
                            </div>
                        </div>
                    </div>

                    <div class="meal-receipt">
                        <div class="receipt-head">
                            <div>
                                <h2>Daily target example</h2>
                                <p>Generated after Health Profile is completed</p>
                            </div>
                            <div class="target-box">
                                1,850
                                <span>kcal</span>
                            </div>
                        </div>

                        <div class="meal-list">
                            <div class="meal-row">
                                <div>
                                    <div class="meal-time">Breakfast</div>
                                    <div class="meal-title">Avocado Egg Toast</div>
                                    <div class="meal-meta"><i class="bi bi-globe2"></i> Western · 25% DCR</div>
                                </div>
                                <div class="kcal">340<span>kcal</span></div>
                            </div>

                            <div class="meal-row">
                                <div>
                                    <div class="meal-time">Lunch</div>
                                    <div class="meal-title">Chicken Rice Bowl</div>
                                    <div class="meal-meta"><i class="bi bi-globe2"></i> Chinese · allergy checked</div>
                                </div>
                                <div class="kcal">520<span>kcal</span></div>
                            </div>

                            <div class="meal-row">
                                <div>
                                    <div class="meal-time">Dinner</div>
                                    <div class="meal-title">Tandoori Chicken Plate</div>
                                    <div class="meal-meta"><i class="bi bi-globe2"></i> Indian · high protein</div>
                                </div>
                                <div class="kcal">610<span>kcal</span></div>
                            </div>

                            <div class="meal-row">
                                <div>
                                    <div class="meal-time">Snack</div>
                                    <div class="meal-title">Labneh Fruit Cup</div>
                                    <div class="meal-meta"><i class="bi bi-globe2"></i> Middle Eastern · light option</div>
                                </div>
                                <div class="kcal">210<span>kcal</span></div>
                            </div>
                        </div>

                        <div class="receipt-note">
                            <span><i class="bi bi-shield-check me-1"></i> Meals are checked against allergies before ranking.</span>
                            <strong>Save to Meal Log</strong>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </section>

    <section class="section alt" id="path">
        <div class="shell">
            <div class="section-heading reveal">
                <div class="kicker">NutriTrack system flow</div>
                <h2 class="section-title">A clear path from quiz to Meal Log.</h2>
                <p class="section-copy">
                    The landing page shows the real system journey so users understand what they should test during evaluation.
                </p>
            </div>

            <div class="pathway reveal">
                <div class="path-step">
                    <div class="path-no">01</div>
                    <h3>Starter Quiz</h3>
                    <p>Guest users answer a short quiz to estimate their initial health result before registration.</p>
                </div>

                <div class="path-step">
                    <div class="path-no">02</div>
                    <h3>Health Profile</h3>
                    <p>Registered users update weight, height, goal, activity level, allergies, and cuisine preference.</p>
                </div>

                <div class="path-step">
                    <div class="path-no">03</div>
                    <h3>Daily Plan</h3>
                    <p>The system generates a ready-to-follow meal plan using the user’s DCR and meal time.</p>
                </div>

                <div class="path-step">
                    <div class="path-no">04</div>
                    <h3>Meal Options</h3>
                    <p>Users compare alternative meals, rate suggestions, swap options, and choose suitable meals.</p>
                </div>

                <div class="path-step">
                    <div class="path-no">05</div>
                    <h3>Meal Log</h3>
                    <p>Saved meals and food logging results can be reviewed later in one organized place.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="section" id="personal">
        <div class="shell">
            <div class="personal-layout">
                <div class="dark-card reveal">
                    <div class="kicker">Why NutriTrack feels personal</div>
                    <h2>It connects meals to the user’s profile.</h2>
                    <p>
                        NutriTrack is not just a food list. It reads the user’s health profile and uses that information
                        to filter, rank, and display meals that better match the user’s needs.
                    </p>

                    <div class="mini-log">
                        <div class="mini-log-row">
                            <strong>Daily target</strong>
                            <span>DCR calculated</span>
                        </div>
                        <div class="mini-log-row">
                            <strong>Preference</strong>
                            <span>Malay · Chinese · Indian · Western · Middle Eastern</span>
                        </div>
                        <div class="mini-log-row">
                            <strong>Food safety</strong>
                            <span>Allergy filter applied</span>
                        </div>
                    </div>
                </div>

                <div class="reason-grid">
                    <div class="reason-card green reveal">
                        <i class="bi bi-calculator"></i>
                        <h3>DCR-based planning</h3>
                        <p>Meal suggestions are linked to calculated calorie requirements instead of generic diet advice.</p>
                    </div>

                    <div class="reason-card reveal">
                        <i class="bi bi-shield-check"></i>
                        <h3>Allergy filtering</h3>
                        <p>The system checks declared allergies before showing meals as suitable recommendations.</p>
                    </div>

                    <div class="reason-card warm reveal">
                        <i class="bi bi-stars"></i>
                        <h3>Hybrid ranking</h3>
                        <p>Meals are ranked using calorie closeness, meal time, cuisine match, nutrition value, and ratings.</p>
                    </div>

                    <div class="reason-card reveal">
                        <i class="bi bi-robot"></i>
                        <h3>AI Food Logger</h3>
                        <p>Users can describe foods outside the database and receive nutrition and healthiness estimates.</p>
                    </div>

                    <div class="reason-card full reveal">
                        <i class="bi bi-database-check"></i>
                        <h3>Admin-verified meal data</h3>
                        <p>Spoonacular imports are reviewed in a pending table before suitable records are promoted into the main meals database.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section alt" id="features">
        <div class="shell">
            <div class="feature-layout">
                <div class="feature-photo reveal">
                    <img src="https://images.unsplash.com/photo-1543352634-a1c51d9f1fa7?auto=format&fit=crop&w=1100&q=80" alt="Prepared healthy meal bowls on a table" loading="lazy">
                </div>

                <div>
                    <div class="section-heading reveal">
                        <div class="kicker">Core modules</div>
                        <h2 class="section-title">Built for meal planning, not only calorie tracking.</h2>
                        <p class="section-copy">
                            NutriTrack focuses on the actions users need during testing: creating a profile, receiving meal suggestions,
                            saving meals, and checking nutrition estimates.
                        </p>
                    </div>

                    <div class="feature-list">
                        <div class="feature-row reveal">
                            <i class="bi bi-person-lines-fill"></i>
                            <div>
                                <h3>Health Profile</h3>
                                <p>Calculates BMI, BMR, TDEE, DCR, and healthy weight range using user information.</p>
                            </div>
                        </div>

                        <div class="feature-row reveal">
                            <i class="bi bi-calendar2-week"></i>
                            <div>
                                <h3>Daily Plan and Weekly Meal Plan</h3>
                                <p>Supports short-term and extended meal planning based on the user’s calorie target.</p>
                            </div>
                        </div>

                        <div class="feature-row reveal">
                            <i class="bi bi-ui-checks-grid"></i>
                            <div>
                                <h3>Meal Options</h3>
                                <p>Allows users to compare alternative meal choices instead of accepting only one result.</p>
                            </div>
                        </div>

                        <div class="feature-row reveal">
                            <i class="bi bi-journal-check"></i>
                            <div>
                                <h3>Meal Log</h3>
                                <p>Stores selected meals and food logging results for later review.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section" id="testing">
        <div class="shell">
            <div class="section-heading reveal">
                <div class="kicker">For user testing</div>
                <h2 class="section-title">What respondents should try.</h2>
                <p class="section-copy">
                    This section helps new visitors understand the main testing tasks before they answer the questionnaire.
                </p>
            </div>

            <div class="testing-strip reveal">
                <div class="test-card">
                    <strong>1. Complete profile</strong>
                    <p>Register or login, then update Health Profile details so the system can calculate DCR.</p>
                </div>

                <div class="test-card">
                    <strong>2. Try recommendation modules</strong>
                    <p>Open Daily Plan, Meal Options, and Weekly Meal Plan to view generated meal suggestions.</p>
                </div>

                <div class="test-card">
                    <strong>3. Save and log meals</strong>
                    <p>Use Save to Meal Log and try AI Food Logger to check nutrition estimates for food descriptions.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="cta">
        <div class="shell">
            <div class="cta-panel reveal">
                <div>
                    <h2>Start with the quiz, then let NutriTrack build the plan.</h2>
                    <p>
                        The system becomes more personalized after users complete their Health Profile and select their dietary preferences.
                    </p>
                </div>

                <div class="cta-actions">
                    <a href="{{ $quizUrl }}" class="btn-nt btn-primary-nt">
                        <i class="bi bi-clipboard2-pulse"></i> Try Starter Quiz
                    </a>

                    @if(Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="btn-nt btn-light-nt">Open Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="btn-nt btn-light-nt">Login</a>
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </section>
</main>

<footer class="nt-footer">
    <div class="shell">
        <div class="footer-grid">
            <div>
                <strong>NutriTrack</strong><br>
                Personalized Healthy Meal Recommendation System
            </div>
            <div>
                Final Year Project - Iffah Binti Ishak, UiTM 2026<br>
                Built with Laravel 12, Bootstrap 5, and MySQL
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const revealObserver = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                revealObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.14 });

    document.querySelectorAll('.reveal').forEach((element) => revealObserver.observe(element));
</script>
</body>
</html>
