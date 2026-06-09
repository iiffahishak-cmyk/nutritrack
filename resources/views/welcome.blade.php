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
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        :root {
            --cream: #FAF2E3;
            --cream-2: #FFF9EF;
            --paper: #FFFCF6;
            --off-white: #F7F3EA;
            --sage: #E2ECD7;
            --sage-2: #CFE2BE;
            --green: #32684B;
            --green-dark: #1F4632;
            --terracotta: #C56C45;
            --terracotta-dark: #94482E;
            --navy: #172033;
            --ink: #1F2933;
            --muted: #697064;
            --line: rgba(31,41,51,.12);
            --shadow: 0 24px 70px rgba(23,32,51,.12);
        }

        * {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            margin: 0;
            font-family: "Plus Jakarta Sans", sans-serif;
            color: var(--ink);
            background:
                linear-gradient(90deg, rgba(31,41,51,.035) 1px, transparent 1px),
                linear-gradient(rgba(31,41,51,.03) 1px, transparent 1px),
                var(--cream);
            background-size: 72px 72px;
            overflow-x: hidden;
        }

        a {
            text-decoration: none;
        }

        img {
            max-width: 100%;
        }

        .page-shell {
            width: min(1180px, calc(100% - 2rem));
            margin: 0 auto;
        }

        .nt-nav {
            position: sticky;
            top: 0;
            z-index: 1000;
            padding: .85rem 0;
            background: rgba(250,242,227,.86);
            backdrop-filter: blur(18px);
            border-bottom: 1px solid rgba(31,41,51,.07);
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
            gap: .7rem;
            color: var(--navy);
            font-weight: 900;
            letter-spacing: -.04em;
            font-size: 1.15rem;
        }

        .brand-mark {
            width: 40px;
            height: 40px;
            display: grid;
            place-items: center;
            border-radius: 14px;
            color: var(--paper);
            background: var(--green-dark);
            box-shadow: 0 12px 30px rgba(31,70,50,.2);
        }

        .brand span span {
            color: var(--green);
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: .35rem;
        }

        .nav-link-item {
            color: #596153;
            font-size: .86rem;
            font-weight: 800;
            padding: .55rem .85rem;
            border-radius: 999px;
        }

        .nav-link-item:hover {
            color: var(--navy);
            background: rgba(50,104,75,.08);
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: .6rem;
        }

        .btn-soft,
        .btn-solid,
        .btn-outline-warm {
            min-height: 42px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: .55rem;
            border-radius: 999px;
            padding: .72rem 1rem;
            font-size: .86rem;
            font-weight: 900;
            transition: .2s ease;
            white-space: nowrap;
        }

        .btn-soft {
            color: var(--navy);
            background: rgba(255,255,255,.65);
            border: 1px solid rgba(31,41,51,.09);
        }

        .btn-soft:hover {
            color: var(--navy);
            transform: translateY(-1px);
            background: #fff;
        }

        .btn-solid {
            color: var(--paper);
            background: var(--green-dark);
            box-shadow: 0 16px 34px rgba(31,70,50,.22);
        }

        .btn-solid:hover {
            color: var(--paper);
            transform: translateY(-2px);
            background: #183A29;
        }

        .btn-outline-warm {
            color: var(--green-dark);
            background: transparent;
            border: 1px solid rgba(31,70,50,.24);
        }

        .btn-outline-warm:hover {
            color: var(--green-dark);
            transform: translateY(-2px);
            background: rgba(255,255,255,.7);
        }

        .hero {
            padding: 4.8rem 0 3.6rem;
        }

        .hero-grid {
            display: grid;
            grid-template-columns: minmax(0, 1.05fr) minmax(360px, .95fr);
            gap: clamp(2rem, 5vw, 4.5rem);
            align-items: center;
        }

        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: .55rem;
            color: var(--terracotta-dark);
            background: rgba(197,108,69,.12);
            border: 1px solid rgba(197,108,69,.18);
            border-radius: 999px;
            padding: .55rem .85rem;
            font-size: .75rem;
            font-weight: 900;
            letter-spacing: .1em;
            text-transform: uppercase;
            margin-bottom: 1.25rem;
        }

        .hero h1 {
            max-width: 760px;
            margin: 0;
            font-family: "Instrument Serif", serif;
            color: var(--navy);
            font-size: clamp(4rem, 8vw, 7.6rem);
            line-height: .86;
            letter-spacing: -.06em;
        }

        .hero h1 em {
            color: var(--terracotta);
            font-style: italic;
        }

        .hero-copy {
            max-width: 610px;
            margin: 1.45rem 0 0;
            color: #5D665A;
            font-size: 1.04rem;
            line-height: 1.9;
        }

        .hero-actions {
            display: flex;
            flex-wrap: wrap;
            gap: .8rem;
            margin-top: 1.8rem;
        }

        .hero-notes {
            display: flex;
            flex-wrap: wrap;
            gap: .75rem;
            margin-top: 2rem;
        }

        .hero-note {
            display: inline-flex;
            align-items: center;
            gap: .45rem;
            color: #4B554A;
            background: rgba(255,255,255,.62);
            border: 1px solid rgba(31,41,51,.08);
            border-radius: 999px;
            padding: .55rem .8rem;
            font-size: .82rem;
            font-weight: 800;
        }

        .hero-note i {
            color: var(--green);
        }

        .plan-card {
            position: relative;
            background: var(--paper);
            border: 1px solid rgba(31,41,51,.1);
            border-radius: 34px;
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        .plan-photo {
            height: 190px;
            position: relative;
            background: #E9E0CF;
        }

        .plan-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .plan-photo::after {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(23,32,51,.1), rgba(23,32,51,.38));
        }

        .plan-badge {
            position: absolute;
            left: 1.1rem;
            bottom: 1rem;
            z-index: 2;
            display: inline-flex;
            align-items: center;
            gap: .45rem;
            color: var(--paper);
            background: rgba(23,32,51,.72);
            border: 1px solid rgba(255,255,255,.22);
            border-radius: 999px;
            padding: .48rem .72rem;
            font-size: .76rem;
            font-weight: 900;
        }

        .plan-body {
            padding: 1.2rem;
        }

        .plan-head {
            display: flex;
            align-items: start;
            justify-content: space-between;
            gap: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid rgba(31,41,51,.08);
        }

        .plan-head small {
            color: var(--terracotta-dark);
            font-size: .72rem;
            font-weight: 900;
            letter-spacing: .12em;
            text-transform: uppercase;
        }

        .plan-head h2 {
            margin: .35rem 0 0;
            color: var(--navy);
            font-size: 1.45rem;
            font-weight: 900;
            letter-spacing: -.04em;
        }

        .target-pill {
            flex: 0 0 auto;
            border-radius: 18px;
            background: var(--sage);
            color: var(--green-dark);
            padding: .75rem .9rem;
            text-align: center;
            font-weight: 900;
            line-height: 1.15;
        }

        .target-pill span {
            display: block;
            color: #5D665A;
            font-size: .68rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: .08em;
        }

        .meal-list {
            display: grid;
            gap: .75rem;
            margin-top: 1rem;
        }

        .meal-row {
            display: grid;
            grid-template-columns: 1fr auto;
            align-items: center;
            gap: .8rem;
            padding: .75rem;
            border-radius: 20px;
            background: #FCF7ED;
            border: 1px solid rgba(31,41,51,.07);
        }

        .meal-time {
            color: var(--terracotta-dark);
            font-size: .72rem;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: .08em;
        }

        .meal-name {
            margin-top: .15rem;
            color: var(--navy);
            font-weight: 900;
            letter-spacing: -.02em;
        }

        .cuisine-tag {
            display: inline-flex;
            align-items: center;
            gap: .32rem;
            margin-top: .32rem;
            color: #53604F;
            font-size: .72rem;
            font-weight: 800;
        }

        .kcal {
            min-width: 62px;
            padding: .58rem .65rem;
            border-radius: 16px;
            color: var(--green-dark);
            background: #E9F2DF;
            text-align: center;
            font-size: .82rem;
            font-weight: 900;
        }

        .kcal span {
            display: block;
            color: #6B735F;
            font-size: .61rem;
            text-transform: uppercase;
            letter-spacing: .08em;
        }

        .plan-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            margin-top: 1rem;
            padding: 1rem;
            border-radius: 22px;
            color: #4B554A;
            background: #EFF4E8;
            font-size: .86rem;
            font-weight: 800;
        }

        .plan-footer strong {
            color: var(--green-dark);
        }

        .section {
            padding: 5.5rem 0;
        }

        .section.alt {
            background: rgba(255,252,246,.68);
            border-top: 1px solid rgba(31,41,51,.07);
            border-bottom: 1px solid rgba(31,41,51,.07);
        }

        .section-heading {
            max-width: 780px;
            margin-bottom: 2.4rem;
        }

        .section-kicker {
            color: var(--terracotta-dark);
            font-size: .76rem;
            font-weight: 900;
            letter-spacing: .12em;
            text-transform: uppercase;
            margin-bottom: .65rem;
        }

        .section-title {
            margin: 0;
            font-family: "Instrument Serif", serif;
            color: var(--navy);
            font-size: clamp(3rem, 5.6vw, 5.4rem);
            line-height: .9;
            letter-spacing: -.055em;
        }

        .section-text {
            max-width: 650px;
            color: #626A5D;
            font-size: 1rem;
            line-height: 1.85;
            margin-top: 1rem;
        }

        .flow-strip {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 0;
            overflow: hidden;
            border-radius: 32px;
            border: 1px solid rgba(31,41,51,.1);
            background: var(--paper);
            box-shadow: 0 22px 60px rgba(23,32,51,.08);
        }

        .flow-step {
            min-height: 210px;
            padding: 1.25rem;
            border-right: 1px solid rgba(31,41,51,.09);
            background: var(--paper);
        }

        .flow-step:nth-child(even) {
            background: #F6EFDF;
        }

        .flow-step:last-child {
            border-right: 0;
        }

        .flow-number {
            color: var(--terracotta);
            font-size: .8rem;
            font-weight: 900;
            letter-spacing: .12em;
            margin-bottom: 2.2rem;
        }

        .flow-step h3 {
            color: var(--navy);
            font-size: 1.08rem;
            font-weight: 900;
            letter-spacing: -.03em;
            margin-bottom: .6rem;
        }

        .flow-step p {
            color: #66705F;
            font-size: .9rem;
            line-height: 1.7;
            margin: 0;
        }

        .personal-grid {
            display: grid;
            grid-template-columns: 1.1fr .9fr;
            gap: 1.5rem;
            align-items: start;
        }

        .journal-panel {
            padding: 2rem;
            border-radius: 34px;
            color: var(--paper);
            background: var(--navy);
            box-shadow: var(--shadow);
        }

        .journal-panel h3 {
            font-family: "Instrument Serif", serif;
            font-size: clamp(2.6rem, 4vw, 4rem);
            line-height: .95;
            letter-spacing: -.055em;
            margin-bottom: 1rem;
        }

        .journal-panel p {
            color: rgba(255,252,246,.72);
            line-height: 1.8;
            margin: 0;
        }

        .journal-lines {
            display: grid;
            gap: .75rem;
            margin-top: 1.4rem;
        }

        .journal-line {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            padding: .9rem 1rem;
            border-radius: 18px;
            background: rgba(255,252,246,.08);
            border: 1px solid rgba(255,252,246,.1);
            font-weight: 800;
        }

        .journal-line span {
            color: var(--sage-2);
        }

        .reason-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
        }

        .reason-card {
            min-height: 172px;
            padding: 1.2rem;
            border-radius: 26px;
            background: var(--paper);
            border: 1px solid rgba(31,41,51,.09);
        }

        .reason-card.warm {
            background: #F8E8D8;
        }

        .reason-card.green {
            background: #EAF2E0;
        }

        .reason-card h4 {
            color: var(--navy);
            font-size: 1rem;
            font-weight: 900;
            letter-spacing: -.03em;
            margin-bottom: .55rem;
        }

        .reason-card p {
            color: #60695C;
            font-size: .9rem;
            line-height: 1.65;
            margin: 0;
        }

        .feature-board {
            display: grid;
            grid-template-columns: .95fr 1.05fr;
            gap: 2rem;
            align-items: center;
        }

        .board-photo {
            min-height: 500px;
            border-radius: 38px;
            overflow: hidden;
            box-shadow: var(--shadow);
            background: #DDD1BD;
        }

        .board-photo img {
            width: 100%;
            height: 100%;
            min-height: 500px;
            object-fit: cover;
            display: block;
        }

        .feature-list {
            display: grid;
            gap: .9rem;
        }

        .feature-item {
            display: grid;
            grid-template-columns: 42px 1fr;
            gap: 1rem;
            padding: 1.05rem;
            border-radius: 24px;
            background: rgba(255,252,246,.76);
            border: 1px solid rgba(31,41,51,.08);
        }

        .feature-mark {
            width: 42px;
            height: 42px;
            display: grid;
            place-items: center;
            border-radius: 15px;
            color: var(--paper);
            background: var(--terracotta);
        }

        .feature-item h3 {
            margin: 0 0 .35rem;
            color: var(--navy);
            font-size: 1rem;
            font-weight: 900;
        }

        .feature-item p {
            margin: 0;
            color: #626A5D;
            font-size: .92rem;
            line-height: 1.7;
        }

        .cta {
            padding: 5.5rem 0 6.5rem;
        }

        .cta-panel {
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 2rem;
            align-items: center;
            padding: clamp(2rem, 5vw, 4rem);
            border-radius: 38px;
            color: var(--paper);
            background: var(--green-dark);
            box-shadow: var(--shadow);
        }

        .cta-panel h2 {
            max-width: 720px;
            margin: 0;
            font-family: "Instrument Serif", serif;
            font-size: clamp(3rem, 5vw, 5.4rem);
            line-height: .9;
            letter-spacing: -.055em;
        }

        .cta-panel p {
            max-width: 600px;
            margin: 1rem 0 0;
            color: rgba(255,252,246,.74);
            line-height: 1.8;
        }

        .cta-actions {
            display: flex;
            flex-wrap: wrap;
            gap: .75rem;
        }

        .cta-actions .btn-solid {
            color: var(--green-dark);
            background: var(--paper);
            box-shadow: none;
        }

        .cta-actions .btn-outline-warm {
            color: var(--paper);
            border-color: rgba(255,252,246,.35);
        }

        .nt-footer {
            padding: 2.2rem 0;
            background: #EEE4D1;
            border-top: 1px solid rgba(31,41,51,.08);
        }

        .footer-grid {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            color: #626A5D;
            font-size: .88rem;
        }

        .footer-grid strong {
            color: var(--navy);
        }

        .reveal {
            opacity: 0;
            transform: translateY(24px);
            transition: .65s ease;
        }

        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }

        @media (max-width: 991px) {
            .nav-links {
                display: none;
            }

            .hero {
                padding-top: 3.4rem;
            }

            .hero-grid,
            .personal-grid,
            .feature-board,
            .cta-panel {
                grid-template-columns: 1fr;
            }

            .plan-card {
                max-width: 560px;
                margin: 0 auto;
            }

            .flow-strip {
                grid-template-columns: 1fr;
            }

            .flow-step {
                min-height: auto;
                border-right: 0;
                border-bottom: 1px solid rgba(31,41,51,.09);
            }

            .flow-step:last-child {
                border-bottom: 0;
            }

            .flow-number {
                margin-bottom: 1rem;
            }

            .board-photo,
            .board-photo img {
                min-height: 360px;
            }

            .cta-actions {
                justify-content: flex-start;
            }
        }

        @media (max-width: 767px) {
            .page-shell {
                width: min(100% - 1rem, 1180px);
            }

            .nav-inner {
                align-items: flex-start;
            }

            .brand {
                font-size: 1rem;
            }

            .brand-mark {
                width: 36px;
                height: 36px;
            }

            .nav-actions {
                flex-wrap: wrap;
                justify-content: flex-end;
            }

            .btn-soft,
            .btn-solid,
            .btn-outline-warm {
                min-height: 38px;
                padding: .62rem .8rem;
                font-size: .78rem;
            }

            .hero h1 {
                font-size: 4.2rem;
            }

            .meal-row {
                grid-template-columns: 1fr auto;
            }

            .meal-time {
                grid-column: 1 / -1;
            }

            .plan-head,
            .plan-footer {
                flex-direction: column;
                align-items: flex-start;
            }

            .target-pill {
                text-align: left;
            }

            .reason-grid {
                grid-template-columns: 1fr;
            }

            .section,
            .cta {
                padding: 4rem 0;
            }

            .footer-grid {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
</head>
<body>
<nav class="nt-nav">
    <div class="page-shell">
        <div class="nav-inner">
            <a href="{{ url('/') }}" class="brand">
                <span class="brand-mark">
                    <i class="bi bi-heart-pulse-fill"></i>
                </span>
                <span>Nutri<span>Track</span></span>
            </a>

            <div class="nav-links">
                <a href="#flow" class="nav-link-item">Flow</a>
                <a href="#personal" class="nav-link-item">Why Personal</a>
                <a href="#features" class="nav-link-item">Features</a>
            </div>

            <div class="nav-actions">
                @if(Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn-solid">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="btn-soft">Login</a>
                        @if(Route::has('register'))
                            <a href="{{ route('register') }}" class="btn-solid">Get Started</a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </div>
</nav>

<main>
    <section class="hero">
        <div class="page-shell">
            <div class="hero-grid">
                <div>
                    <div class="eyebrow">
                        <i class="bi bi-journal-medical"></i>
                        Laravel FYP meal recommendation system
                    </div>

                    <h1>
                        Plan healthier meals from a profile, not a blank page.
                    </h1>

                    <p class="hero-copy">
                        NutriTrack helps users estimate their daily calorie needs, set food preferences,
                        avoid declared allergens, and choose suitable meals through a simple web-based planner.
                    </p>

                    <div class="hero-actions">
                        <a href="{{ route('guest.quiz') }}" class="btn-solid">
                            <i class="bi bi-clipboard2-pulse"></i>
                            Try Starter Quiz
                        </a>
                        <a href="#flow" class="btn-outline-warm">
                            <i class="bi bi-arrow-down-circle"></i>
                            View System Flow
                        </a>
                    </div>

                    <div class="hero-notes">
                        <span class="hero-note"><i class="bi bi-check2-circle"></i> DCR-based planning</span>
                        <span class="hero-note"><i class="bi bi-check2-circle"></i> Allergy filtering</span>
                        <span class="hero-note"><i class="bi bi-check2-circle"></i> Meal Log tracking</span>
                    </div>
                </div>

                <aside class="plan-card reveal" aria-label="Today's NutriTrack Plan preview">
                    <div class="plan-photo">
                        <img src="https://images.unsplash.com/photo-1498837167922-ddd27525d352?auto=format&fit=crop&w=900&q=80" alt="Healthy meal ingredients on a table">
                        <div class="plan-badge">
                            <i class="bi bi-calendar2-check"></i>
                            Today's NutriTrack Plan
                        </div>
                    </div>

                    <div class="plan-body">
                        <div class="plan-head">
                            <div>
                                <small>Example daily target</small>
                                <h2>Balanced day for a Western preference</h2>
                            </div>
                            <div class="target-pill">
                                1,850
                                <span>kcal</span>
                            </div>
                        </div>

                        <div class="meal-list">
                            <div class="meal-row">
                                <div>
                                    <div class="meal-time">Breakfast</div>
                                    <div class="meal-name">Avocado Egg Toast</div>
                                    <div class="cuisine-tag"><i class="bi bi-globe2"></i> Western</div>
                                </div>
                                <div class="kcal">340<span>kcal</span></div>
                            </div>

                            <div class="meal-row">
                                <div>
                                    <div class="meal-time">Lunch</div>
                                    <div class="meal-name">Chicken Rice Bowl</div>
                                    <div class="cuisine-tag"><i class="bi bi-globe2"></i> Chinese</div>
                                </div>
                                <div class="kcal">520<span>kcal</span></div>
                            </div>

                            <div class="meal-row">
                                <div>
                                    <div class="meal-time">Dinner</div>
                                    <div class="meal-name">Tandoori Chicken Plate</div>
                                    <div class="cuisine-tag"><i class="bi bi-globe2"></i> Indian</div>
                                </div>
                                <div class="kcal">610<span>kcal</span></div>
                            </div>

                            <div class="meal-row">
                                <div>
                                    <div class="meal-time">Snack</div>
                                    <div class="meal-name">Labneh Fruit Cup</div>
                                    <div class="cuisine-tag"><i class="bi bi-globe2"></i> Middle Eastern</div>
                                </div>
                                <div class="kcal">210<span>kcal</span></div>
                            </div>
                        </div>

                        <div class="plan-footer">
                            <span><i class="bi bi-shield-check me-1"></i> Allergy checks before ranking</span>
                            <strong>92% fit</strong>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </section>

    <section class="section alt" id="flow">
        <div class="page-shell">
            <div class="section-heading reveal">
                <div class="section-kicker">Actual NutriTrack flow</div>
                <h2 class="section-title">From first estimate to saved meals.</h2>
                <p class="section-text">
                    The homepage now mirrors how the system is used in the project: a user starts with a quick
                    estimate, completes their profile, receives recommendations, compares Meal Options, and saves meals.
                </p>
            </div>

            <div class="flow-strip reveal">
                <div class="flow-step">
                    <div class="flow-number">01</div>
                    <h3>Starter Quiz</h3>
                    <p>A quick public quiz estimates initial calorie needs before account setup.</p>
                </div>
                <div class="flow-step">
                    <div class="flow-number">02</div>
                    <h3>Health Profile</h3>
                    <p>The user adds age, height, weight, activity level, goal, allergies, and cuisine preference.</p>
                </div>
                <div class="flow-step">
                    <div class="flow-number">03</div>
                    <h3>Daily Plan</h3>
                    <p>NutriTrack builds one complete day of meals using the user's calculated target.</p>
                </div>
                <div class="flow-step">
                    <div class="flow-number">04</div>
                    <h3>Meal Options</h3>
                    <p>Users compare alternatives, refresh choices, rate meals, and pick what suits them.</p>
                </div>
                <div class="flow-step">
                    <div class="flow-number">05</div>
                    <h3>Meal Log</h3>
                    <p>Saved meals are collected in one place so users can review what they selected.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="section" id="personal">
        <div class="page-shell">
            <div class="personal-grid">
                <div class="journal-panel reveal">
                    <div class="section-kicker" style="color:#CFE2BE;">Why it feels personal</div>
                    <h3>NutriTrack does not recommend the same meals to everyone.</h3>
                    <p>
                        The recommendation flow is built from the user's profile, not a generic meal list.
                        That makes the system easier to explain during evaluation because each result has a reason.
                    </p>

                    <div class="journal-lines">
                        <div class="journal-line">
                            <strong>Daily target</strong>
                            <span>DCR calculated</span>
                        </div>
                        <div class="journal-line">
                            <strong>Risk check</strong>
                            <span>Allergies filtered</span>
                        </div>
                        <div class="journal-line">
                            <strong>Preference</strong>
                            <span>Malay, Chinese, Indian, Western, Middle Eastern</span>
                        </div>
                    </div>
                </div>

                <div class="reason-grid">
                    <div class="reason-card green reveal">
                        <h4>DCR-based planning</h4>
                        <p>Meals are compared against the user's daily calorie target instead of shown randomly.</p>
                    </div>
                    <div class="reason-card reveal">
                        <h4>Allergy filtering</h4>
                        <p>Declared allergens are checked before meals are presented as suitable options.</p>
                    </div>
                    <div class="reason-card warm reveal">
                        <h4>Cuisine preference</h4>
                        <p>Preferred cuisine improves ranking while keeping the accepted cuisine categories consistent.</p>
                    </div>
                    <div class="reason-card reveal">
                        <h4>AI Food Logger</h4>
                        <p>Users can describe a meal and receive nutrition estimates for faster food tracking.</p>
                    </div>
                    <div class="reason-card reveal" style="grid-column:1 / -1;">
                        <h4>Admin-verified meal data</h4>
                        <p>Admin review keeps imported and created meals more controlled before they appear in the recommendation flow.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section alt" id="features">
        <div class="page-shell">
            <div class="feature-board">
                <div class="board-photo reveal">
                    <img src="https://images.unsplash.com/photo-1543352634-a1c51d9f1fa7?auto=format&fit=crop&w=900&q=80" alt="Healthy meal bowls prepared on a table" loading="lazy">
                </div>

                <div>
                    <div class="section-heading reveal">
                        <div class="section-kicker">Built for a student project demo</div>
                        <h2 class="section-title">Clean enough for users, clear enough for evaluation.</h2>
                        <p class="section-text">
                            The interface focuses on the features that matter: profile setup, meal recommendation,
                            meal comparison, AI-assisted logging, and admin-controlled meal data.
                        </p>
                    </div>

                    <div class="feature-list">
                        <div class="feature-item reveal">
                            <div class="feature-mark"><i class="bi bi-calculator"></i></div>
                            <div>
                                <h3>Nutrition calculations are visible</h3>
                                <p>Users can understand how calorie targets connect to their goal and activity level.</p>
                            </div>
                        </div>
                        <div class="feature-item reveal">
                            <div class="feature-mark"><i class="bi bi-ui-checks-grid"></i></div>
                            <div>
                                <h3>Meal Options support choice</h3>
                                <p>The system gives alternatives instead of forcing one meal, which makes the planner feel more usable.</p>
                            </div>
                        </div>
                        <div class="feature-item reveal">
                            <div class="feature-mark"><i class="bi bi-journal-check"></i></div>
                            <div>
                                <h3>Meal Log keeps the result</h3>
                                <p>Selected meals can be saved and reviewed later as part of the user's meal history.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="cta">
        <div class="page-shell">
            <div class="cta-panel reveal">
                <div>
                    <h2>Start with a quiz, then build a plan that fits.</h2>
                    <p>
                        NutriTrack keeps the first step light for new users, then becomes more personalized after
                        they complete their Health Profile.
                    </p>
                </div>

                <div class="cta-actions">
                    <a href="{{ route('guest.quiz') }}" class="btn-solid">
                        <i class="bi bi-clipboard2-pulse"></i>
                        Try Starter Quiz
                    </a>

                    @if(Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="btn-outline-warm">Open Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="btn-outline-warm">Login</a>
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </section>
</main>

<footer class="nt-footer">
    <div class="page-shell">
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
    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.14 });

    document.querySelectorAll('.reveal').forEach((element) => observer.observe(element));
</script>
</body>
</html>
