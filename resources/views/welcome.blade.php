<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>NutriTrack — Personalized Healthy Meal Recommendations</title>

    <!-- Bootstrap 5 + Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700;14..32,800;14..32,900&family=Caveat:wght@500..700&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --navy: #0B1B3A;
            --blue: #2563EB;
            --blue-dark: #1D4ED8;
            --blue-soft: #EAF4FF;
            --green: #22C55E;
            --green-dark: #15803D;
            --green-soft: #ECFDF5;
            --white: #FFFFFF;
            --ice: #F6FAFF;
            --line: #D7E7F7;
            --muted: #64748B;
            --text: #14213D;
            --shadow-sm: 0 10px 30px -18px rgba(15, 23, 42, 0.28);
            --shadow-md: 0 28px 60px -28px rgba(15, 23, 42, 0.32);
            --shadow-blue: 0 24px 56px -26px rgba(37, 99, 235, 0.42);
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Inter', sans-serif;
            background:
                radial-gradient(circle at top left, rgba(37, 99, 235, .10), transparent 34rem),
                radial-gradient(circle at 90% 12%, rgba(14, 165, 233, .11), transparent 30rem),
                var(--ice);
            color: var(--text);
            overflow-x: hidden;
        }

        a {
            text-decoration: none;
        }

        .page-container {
            max-width: 1180px;
            margin: 0 auto;
            padding: 0 1.35rem;
        }

        .handwritten {
            font-family: 'Caveat', cursive;
            font-weight: 700;
        }

        .mini-strip {
            background: linear-gradient(90deg, #1D4ED8, #0EA5E9);
            color: rgba(255,255,255,.92);
            font-size: .74rem;
            padding: .48rem 0;
        }

        .navbar-custom {
            position: sticky;
            top: 0;
            z-index: 1000;
            background: rgba(255, 255, 255, 0.88);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(221, 232, 245, .9);
            padding: .85rem 0;
        }

        .brand {
            display: inline-flex;
            align-items: center;
            gap: .65rem;
            font-weight: 900;
            font-size: 1.38rem;
            letter-spacing: -0.04em;
            color: var(--navy);
        }

        .brand:hover {
            color: var(--navy);
        }

        .brand-mark {
            width: 42px;
            height: 42px;
            display: grid;
            place-items: center;
            border-radius: 16px;
            color: var(--white);
            background: linear-gradient(135deg, var(--blue), #0EA5E9);
            box-shadow: var(--shadow-blue);
        }

        .brand span span {
            color: var(--blue);
        }

        .nav-menu a {
            color: #506174;
            font-weight: 750;
            font-size: .9rem;
            padding: .58rem .8rem;
            border-radius: 999px;
        }

        .nav-menu a:hover {
            color: var(--blue-dark);
            background: var(--blue-soft);
        }

        .btn-main,
        .btn-ghost,
        .btn-white {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: .5rem;
            border-radius: 999px;
            padding: .72rem 1.22rem;
            font-size: .9rem;
            font-weight: 850;
            transition: .22s ease;
            white-space: nowrap;
        }

        .btn-main {
            color: var(--white);
            background: linear-gradient(135deg, var(--blue), #0EA5E9);
            box-shadow: var(--shadow-blue);
            border: 0;
        }

        .btn-main:hover {
            color: var(--white);
            transform: translateY(-2px);
            filter: brightness(.96);
        }

        .btn-ghost {
            color: var(--navy);
            background: var(--white);
            border: 1px solid var(--line);
        }

        .btn-ghost:hover {
            color: var(--blue-dark);
            border-color: rgba(29,111,233,.28);
            background: var(--blue-soft);
            transform: translateY(-2px);
        }

        .btn-white {
            color: var(--blue-dark);
            background: var(--white);
            border: 1px solid rgba(255,255,255,.24);
        }

        .btn-white:hover {
            color: var(--blue-dark);
            transform: translateY(-2px);
        }

        .hero-section {
            padding: 4.7rem 0 5.2rem;
            position: relative;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: .55rem;
            color: var(--green-dark);
            background: var(--green-soft);
            border: 1px solid rgba(24,160,88,.15);
            border-radius: 999px;
            padding: .5rem .88rem;
            font-size: .76rem;
            font-weight: 900;
            letter-spacing: .08em;
            text-transform: uppercase;
            margin-bottom: 1.3rem;
        }

        .hero-title {
            max-width: 660px;
            color: var(--navy);
            font-weight: 900;
            font-size: clamp(3.25rem, 7vw, 6.5rem);
            line-height: .92;
            letter-spacing: -0.075em;
            margin-bottom: 1.2rem;
        }

        .hero-title .highlight {
            color: var(--blue);
            position: relative;
            display: inline-block;
        }

        .hero-title .highlight::after {
            content: "";
            position: absolute;
            left: .08em;
            right: .08em;
            bottom: .08em;
            height: .12em;
            border-radius: 999px;
            background: rgba(24,160,88,.20);
            z-index: -1;
        }

        .hero-copy {
            max-width: 570px;
            color: var(--muted);
            font-size: 1.08rem;
            line-height: 1.85;
            margin-bottom: 1.55rem;
        }

        .feature-pill {
            background: var(--white);
            border-radius: 80px;
            padding: .58rem .95rem;
            color: #42536A;
            font-size: .84rem;
            font-weight: 750;
            box-shadow: 0 4px 14px rgba(15,23,42,.035);
            border: 1px solid var(--line);
            display: inline-flex;
            align-items: center;
            gap: .48rem;
        }

        .feature-pill i {
            color: var(--green);
        }

        .meal-compass {
            position: relative;
            min-height: 500px;
            display: grid;
            place-items: center;
        }

        .compass-ring {
            width: min(430px, 86vw);
            aspect-ratio: 1/1;
            border-radius: 50%;
            background:
                conic-gradient(from 180deg, rgba(29,111,233,.18), rgba(24,160,88,.18), rgba(29,111,233,.18));
            display: grid;
            place-items: center;
            box-shadow: var(--shadow-md);
            border: 1px solid rgba(29,111,233,.12);
            position: relative;
        }

        .compass-ring::before {
            content: "";
            position: absolute;
            inset: 34px;
            border-radius: 50%;
            background: var(--white);
            border: 1px solid var(--line);
        }

        .inner-plate {
            position: relative;
            z-index: 2;
            width: 62%;
            height: 62%;
            border-radius: 50%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            background:
                radial-gradient(circle at 40% 30%, rgba(234,243,255,.98), rgba(255,255,255,1) 62%);
            box-shadow: inset 0 0 0 10px rgba(29,111,233,.08);
        }

        .inner-plate .number {
            color: var(--navy);
            font-size: 3.2rem;
            line-height: 1;
        }

        .inner-plate .label {
            color: var(--muted);
            font-weight: 800;
            font-size: .76rem;
            text-transform: uppercase;
            letter-spacing: .1em;
        }

        .floating-card {
            position: absolute;
            background: rgba(255,255,255,.96);
            border-radius: 999px;
            padding: .68rem 1.05rem .68rem .68rem;
            display: flex;
            align-items: center;
            gap: .78rem;
            box-shadow: var(--shadow-sm);
            border: 1px solid rgba(221,232,245,.95);
            font-weight: 750;
            font-size: .86rem;
            color: var(--navy);
        }

        .floating-card small {
            display: block;
            color: var(--muted);
            font-weight: 650;
            margin-top: .08rem;
        }

        .card1 { top: 8%; left: 1%; }
        .card2 { top: 22%; right: -2%; }
        .card3 { bottom: 18%; left: -3%; }
        .card4 { bottom: 7%; right: 5%; }

        .floating-icon {
            background: var(--blue-soft);
            width: 38px;
            height: 38px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: var(--blue);
            flex: 0 0 auto;
        }

        .floating-card.green .floating-icon {
            background: var(--green-soft);
            color: var(--green);
        }

        .section {
            padding: 4.6rem 0;
        }

        .section-soft {
            background: rgba(255,255,255,.72);
            border-top: 1px solid rgba(221,232,245,.9);
            border-bottom: 1px solid rgba(221,232,245,.9);
        }

        .section-heading {
            max-width: 720px;
            margin: 0 auto 2.5rem;
            text-align: center;
        }

        .section-heading h2 {
            color: var(--navy);
            font-size: clamp(2.15rem, 4vw, 3.8rem);
            font-weight: 900;
            line-height: 1;
            letter-spacing: -.055em;
            margin-bottom: .8rem;
        }

        .section-heading p {
            color: var(--muted);
            font-size: 1rem;
            line-height: 1.8;
            margin: 0;
        }

        .journey {
            max-width: 930px;
            margin: 0 auto;
            display: grid;
            gap: 1rem;
        }

        .journey-row {
            display: grid;
            grid-template-columns: 86px 1fr;
            align-items: center;
            gap: 1.2rem;
            padding: 1.1rem 1.2rem;
            border-radius: 28px;
            background: var(--white);
            border: 1px solid var(--line);
            box-shadow: 0 8px 24px rgba(15,23,42,.035);
        }

        .journey-no {
            width: 66px;
            height: 66px;
            border-radius: 22px;
            display: grid;
            place-items: center;
            color: var(--white);
            font-size: 1.2rem;
            font-weight: 950;
            background: linear-gradient(135deg, var(--blue), #0EA5E9);
            box-shadow: var(--shadow-blue);
        }

        .journey-row h3 {
            color: var(--navy);
            font-size: 1.05rem;
            font-weight: 900;
            margin: 0 0 .28rem;
        }

        .journey-row p {
            color: var(--muted);
            margin: 0;
            line-height: 1.65;
            font-size: .95rem;
        }

        .taste-section {
            background: linear-gradient(135deg, #EAF4FF 0%, #ECFDF5 100%);
            color: var(--navy);
            overflow: hidden;
            position: relative;
        }

        .taste-section::before {
            content: "";
            position: absolute;
            width: 36rem;
            height: 36rem;
            border-radius: 50%;
            right: -14rem;
            top: -10rem;
            background: rgba(37,99,235,.08);
        }

        .taste-section .page-container {
            position: relative;
            z-index: 2;
        }

        .taste-section h2 {
            max-width: 680px;
            color: var(--navy);
            font-size: clamp(2.5rem, 5vw, 5rem);
            font-weight: 950;
            letter-spacing: -.07em;
            line-height: .98;
        }

        .taste-section p {
            max-width: 610px;
            color: var(--muted);
            line-height: 1.8;
            margin-top: 1rem;
        }

        .pill-cuisine {
            background: var(--white);
            border-radius: 60px;
            padding: .55rem .9rem;
            font-size: .82rem;
            font-weight: 780;
            display: inline-flex;
            align-items: center;
            gap: .45rem;
            color: var(--navy);
            border: 1px solid var(--line);
        }

        .filter-panel {
            background: rgba(255,255,255,.94);
            color: var(--navy);
            border-radius: 32px;
            padding: 1.4rem;
            box-shadow: var(--shadow-md);
        }

        .filter-line {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            padding: .95rem 1rem;
            border-radius: 20px;
            background: var(--ice);
            border: 1px solid var(--line);
            margin-bottom: .7rem;
            color: #435267;
            font-weight: 750;
        }

        .filter-line:last-child {
            margin-bottom: 0;
        }

        .filter-line span {
            color: var(--green-dark);
            font-weight: 900;
        }

        .module-list {
            max-width: 980px;
            margin: 0 auto;
            border: 1px solid var(--line);
            border-radius: 30px;
            background: var(--white);
            overflow: hidden;
            box-shadow: 0 14px 40px rgba(15,23,42,.055);
        }

        .module-row {
            display: grid;
            grid-template-columns: 58px 1fr auto;
            align-items: center;
            gap: 1rem;
            padding: 1.15rem 1.3rem;
            border-bottom: 1px solid var(--line);
        }

        .module-row:last-child {
            border-bottom: 0;
        }

        .module-icon {
            width: 48px;
            height: 48px;
            display: grid;
            place-items: center;
            border-radius: 16px;
            color: var(--blue);
            background: var(--blue-soft);
            font-size: 1.25rem;
        }

        .module-row:nth-child(even) .module-icon {
            color: var(--green);
            background: var(--green-soft);
        }

        .module-row h3 {
            margin: 0 0 .18rem;
            color: var(--navy);
            font-size: 1rem;
            font-weight: 900;
        }

        .module-row p {
            margin: 0;
            color: var(--muted);
            line-height: 1.6;
            font-size: .92rem;
        }

        .module-tag {
            border-radius: 999px;
            padding: .45rem .75rem;
            color: var(--blue-dark);
            background: var(--blue-soft);
            font-size: .74rem;
            font-weight: 850;
            white-space: nowrap;
        }

        .cta-block {
            border-radius: 34px;
            padding: clamp(2rem, 5vw, 3.2rem);
            color: var(--white);
            background:
                radial-gradient(circle at top right, rgba(255,255,255,.24), transparent 18rem),
                linear-gradient(135deg, #2563EB, #0EA5E9);
            box-shadow: var(--shadow-blue);
        }

        .cta-block h2 {
            color: var(--white);
            font-weight: 950;
            letter-spacing: -.055em;
            line-height: 1;
        }

        .cta-block p {
            color: rgba(255,255,255,.82);
            line-height: 1.8;
        }



        /* Color-only update: make personalization section lighter and more distinct */
        .taste-section .hero-badge {
            background: var(--white) !important;
            border-color: var(--line) !important;
            color: var(--blue-dark) !important;
            box-shadow: 0 10px 24px rgba(37,99,235,.08);
        }

        .taste-section .filter-panel {
            border: 1px solid rgba(37,99,235,.12);
            box-shadow: 0 24px 56px -30px rgba(37,99,235,.34);
        }

        .taste-section .pill-cuisine i {
            color: var(--green);
        }

        .cta-block .btn-white {
            color: var(--blue-dark);
            box-shadow: 0 10px 26px rgba(15,23,42,.14);
        }

        footer {
            border-top: 1px solid var(--line);
            background: var(--white);
        }

        .reveal {
            opacity: 0;
            transform: translateY(18px);
            transition: .55s ease;
        }

        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }

        @media (max-width: 991px) {
            .hero-section {
                padding-top: 3.4rem;
            }

            .meal-compass {
                min-height: 470px;
                margin-top: 1rem;
            }

            .floating-card {
                transform: scale(.92);
            }

            .card1 { left: 0; }
            .card2 { right: 0; }
            .card3 { left: 0; }
            .card4 { right: 0; }

            .module-row {
                grid-template-columns: 52px 1fr;
            }

            .module-tag {
                grid-column: 2;
                justify-self: start;
            }
        }

        @media (max-width: 767px) {
            .page-container {
                padding: 0 1rem;
            }

            .brand {
                font-size: 1.1rem;
            }

            .brand-mark {
                width: 38px;
                height: 38px;
            }

            .nav-actions {
                gap: .45rem !important;
            }

            .btn-main,
            .btn-ghost,
            .btn-white {
                padding: .62rem .85rem;
                font-size: .78rem;
            }

            .hero-title {
                font-size: 3.5rem;
            }

            .meal-compass {
                min-height: auto;
                display: block;
            }

            .compass-ring {
                margin: 0 auto 1rem;
                width: min(330px, 92vw);
            }

            .floating-card {
                position: static;
                transform: none;
                width: 100%;
                margin-bottom: .65rem;
            }

            .journey-row {
                grid-template-columns: 1fr;
                gap: .75rem;
            }

            .journey-no {
                width: 56px;
                height: 56px;
            }

            .section {
                padding: 3.5rem 0;
            }

            .module-row {
                grid-template-columns: 1fr;
            }

            .module-tag {
                grid-column: auto;
            }
        }
    </style>
</head>
<body>

<div class="mini-strip">
    <div class="page-container d-flex justify-content-between align-items-center flex-wrap gap-2">
        <span><i class="bi bi-mortarboard me-1"></i> Final Year Project live testing</span>
        <span><i class="bi bi-heart-pulse me-1"></i> DCR planning · allergy filtering · Meal Log</span>
    </div>
</div>

<nav class="navbar-custom">
    <div class="page-container d-flex justify-content-between align-items-center gap-3">
        <a href="{{ url('/') }}" class="brand">
            <span class="brand-mark"><i class="bi bi-heart-pulse-fill"></i></span>
            <span>Nutri<span>Track</span></span>
        </a>

        <div class="nav-menu d-none d-md-flex gap-1">
            <a href="#how-it-works">Flow</a>
            <a href="#personal">Personalization</a>
            <a href="#tools">Modules</a>
        </div>

        <div class="nav-actions d-flex gap-2">
            @if(Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn-main">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn-ghost">Login</a>
                    @if(Route::has('register'))
                        <a href="{{ route('register') }}" class="btn-main">Get Started</a>
                    @endif
                @endauth
            @endif
        </div>
    </div>
</nav>

<main>
    <section class="hero-section">
        <div class="page-container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6 reveal">
                    <div class="hero-badge">
                        <i class="bi bi-stars"></i>
                        Profile-based meal planning
                    </div>

                    <h1 class="hero-title">
                        Meals that <span class="highlight">fit</span> your day.
                    </h1>

                    <p class="hero-copy">
                        NutriTrack helps users calculate their health profile, avoid declared allergens,
                        and choose suitable meals based on calorie needs, meal time and cuisine preference.
                    </p>

                    <div class="d-flex flex-wrap gap-3 mb-4">
                        <a href="{{ route('guest.quiz') }}" class="btn-main">
                            <i class="bi bi-clipboard2-pulse"></i>
                            Take Starter Quiz
                        </a>
                        <a href="#how-it-works" class="btn-ghost">
                            <i class="bi bi-arrow-down-circle"></i>
                            See how it works
                        </a>
                    </div>

                    <div class="d-flex flex-wrap gap-2">
                        <span class="feature-pill"><i class="bi bi-shield-check"></i> Allergy-aware</span>
                        <span class="feature-pill"><i class="bi bi-calculator-fill"></i> DCR-based</span>
                        <span class="feature-pill"><i class="bi bi-journal-check"></i> Meal Log</span>
                    </div>
                </div>

                <div class="col-lg-6 reveal">
                    <div class="meal-compass" aria-label="NutriTrack meal preview">
                        <div class="compass-ring">
                            <div class="inner-plate">
                                <div class="number handwritten">1,850</div>
                                <div class="label">daily target</div>
                                <div class="mt-2"><i class="bi bi-egg-fried fs-3" style="color: var(--green);"></i></div>
                            </div>
                        </div>

                        <div class="floating-card card1 green">
                            <span class="floating-icon"><i class="bi bi-sun"></i></span>
                            <span><strong>Breakfast</strong><small>Avocado toast</small></span>
                        </div>

                        <div class="floating-card card2">
                            <span class="floating-icon"><i class="bi bi-basket"></i></span>
                            <span><strong>Lunch</strong><small>Chicken rice bowl</small></span>
                        </div>

                        <div class="floating-card card3">
                            <span class="floating-icon"><i class="bi bi-moon"></i></span>
                            <span><strong>Dinner</strong><small>Grilled fish plate</small></span>
                        </div>

                        <div class="floating-card card4 green">
                            <span class="floating-icon"><i class="bi bi-cup-straw"></i></span>
                            <span><strong>Snack</strong><small>Yogurt and berries</small></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section section-soft" id="how-it-works">
        <div class="page-container">
            <div class="section-heading reveal">
                <div class="hero-badge">
                    <i class="bi bi-diagram-3"></i>
                    System flow
                </div>
                <h2>Simple steps before recommendations appear.</h2>
                <p>
                    NutriTrack keeps the user journey easy: answer basic details, calculate the profile,
                    then explore meal suggestions that match the saved information.
                </p>
            </div>

            <div class="journey">
                <div class="journey-row reveal">
                    <div class="journey-no">01</div>
                    <div>
                        <h3>Start with quiz or account setup</h3>
                        <p>New users can begin with the Starter Quiz or create an account to access the full system.</p>
                    </div>
                </div>

                <div class="journey-row reveal">
                    <div class="journey-no">02</div>
                    <div>
                        <h3>Complete the Health Profile</h3>
                        <p>The system calculates BMI, BMR, TDEE, DCR and healthy weight range from the user profile.</p>
                    </div>
                </div>

                <div class="journey-row reveal">
                    <div class="journey-no">03</div>
                    <div>
                        <h3>Generate meal recommendations</h3>
                        <p>Daily Plan, Meal Options and Weekly Meal Plan use DCR, meal time, allergies and cuisine preference.</p>
                    </div>
                </div>

                <div class="journey-row reveal">
                    <div class="journey-no">04</div>
                    <div>
                        <h3>Save useful meals to Meal Log</h3>
                        <p>Users can save selected meals and review them later from the Meal Log page.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="personal" class="section taste-section">
        <div class="page-container">
            <div class="row align-items-center g-5">
                <div class="col-lg-7 reveal">
                    <div class="hero-badge" style="background: rgba(255,255,255,.12); border-color: rgba(255,255,255,.18); color: white;">
                        <i class="bi bi-funnel"></i>
                        Personalization
                    </div>

                    <h2>The system filters before it recommends.</h2>

                    <p>
                        NutriTrack does not display meals randomly. It checks the user's calorie target,
                        allergy restrictions, meal time and accepted cuisine categories before showing suitable options.
                    </p>

                    <div class="d-flex flex-wrap gap-2 mt-4">
                        <span class="pill-cuisine"><i class="bi bi-bookmark-heart"></i> Malay</span>
                        <span class="pill-cuisine"><i class="bi bi-bookmark-heart"></i> Chinese</span>
                        <span class="pill-cuisine"><i class="bi bi-bookmark-heart"></i> Indian</span>
                        <span class="pill-cuisine"><i class="bi bi-bookmark-heart"></i> Western</span>
                        <span class="pill-cuisine"><i class="bi bi-bookmark-heart"></i> Middle Eastern</span>
                    </div>
                </div>

                <div class="col-lg-5 reveal">
                    <div class="filter-panel">
                        <div class="filter-line">
                            <div><i class="bi bi-calculator me-2"></i> User DCR</div>
                            <span>checked</span>
                        </div>
                        <div class="filter-line">
                            <div><i class="bi bi-shield-slash me-2"></i> Allergy restriction</div>
                            <span>filtered</span>
                        </div>
                        <div class="filter-line">
                            <div><i class="bi bi-clock me-2"></i> Meal time</div>
                            <span>matched</span>
                        </div>
                        <div class="filter-line">
                            <div><i class="bi bi-star me-2"></i> Rating data</div>
                            <span>ranked</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="tools" class="section">
        <div class="page-container">
            <div class="section-heading reveal">
                <div class="hero-badge">
                    <i class="bi bi-grid-3x3-gap-fill"></i>
                    Core modules
                </div>
                <h2>Everything users need in one web system.</h2>
                <p>
                    The modules are kept focused so users can calculate, plan, log and review meals without a complicated setup.
                </p>
            </div>

            <div class="module-list">
                <div class="module-row reveal">
                    <div class="module-icon"><i class="bi bi-clipboard2-heart"></i></div>
                    <div>
                        <h3>Health Profile</h3>
                        <p>Stores user details, activity level, goal, allergies and cuisine preference.</p>
                    </div>
                    <div class="module-tag">profile</div>
                </div>

                <div class="module-row reveal">
                    <div class="module-icon"><i class="bi bi-calendar-check"></i></div>
                    <div>
                        <h3>Daily Plan and Weekly Meal Plan</h3>
                        <p>Generates meal plans based on daily calorie needs and meal time.</p>
                    </div>
                    <div class="module-tag">planning</div>
                </div>

                <div class="module-row reveal">
                    <div class="module-icon"><i class="bi bi-arrow-repeat"></i></div>
                    <div>
                        <h3>Meal Options</h3>
                        <p>Provides alternative meal choices for users who want to compare or swap meals.</p>
                    </div>
                    <div class="module-tag">choices</div>
                </div>

                <div class="module-row reveal">
                    <div class="module-icon"><i class="bi bi-robot"></i></div>
                    <div>
                        <h3>AI Food Logger</h3>
                        <p>Estimates calories, nutrients, item breakdown and healthiness from food descriptions.</p>
                    </div>
                    <div class="module-tag">AI logger</div>
                </div>

                <div class="module-row reveal">
                    <div class="module-icon"><i class="bi bi-journal-check"></i></div>
                    <div>
                        <h3>Meal Log</h3>
                        <p>Collects saved recommendations and AI food logging results for later review.</p>
                    </div>
                    <div class="module-tag">tracking</div>
                </div>
            </div>
        </div>
    </section>

    <section class="section pt-0">
        <div class="page-container">
            <div class="cta-block reveal">
                <div class="row align-items-center g-4">
                    <div class="col-lg-8">
                        <h2 class="display-5 mb-3">Ready to test NutriTrack?</h2>
                        <p class="mb-0">
                            Start with the quiz, complete the Health Profile, then try the Daily Plan,
                            Meal Options, Weekly Meal Plan, AI Food Logger and Meal Log.
                        </p>
                    </div>
                    <div class="col-lg-4 text-lg-end">
                        <a href="{{ route('guest.quiz') }}" class="btn-white">
                            <i class="bi bi-arrow-right-circle"></i>
                            Start quiz
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<footer class="py-4">
    <div class="page-container d-flex flex-wrap justify-content-between align-items-center gap-2">
        <div class="small text-secondary">
            <strong style="color: var(--navy);">NutriTrack</strong> — Personalized Healthy Meal Recommendation System
        </div>
        <div class="small text-secondary">
            <i class="bi bi-database"></i> Laravel 12 · MySQL · Bootstrap 5
        </div>
    </div>
</footer>

<script>
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.15 });

    document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
</script>
</body>
</html>
