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
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Newsreader:opsz,wght@6..72,500;6..72,600;6..72,700&display=swap" rel="stylesheet">

    <style>
        :root {
            --navy: #08234A;
            --blue: #1267D9;
            --blue-soft: #EAF3FF;
            --green: #18A86B;
            --green-dark: #08734D;
            --green-soft: #EAFBF3;
            --sky: #F5FAFF;
            --white: #FFFFFF;
            --ink: #132338;
            --muted: #617389;
            --line: rgba(8, 35, 74, .12);
            --shadow: 0 26px 70px rgba(8, 35, 74, .14);
        }

        * { box-sizing: border-box; }
        html { scroll-behavior: smooth; }

        body {
            margin: 0;
            font-family: "Manrope", sans-serif;
            color: var(--ink);
            background: var(--white);
            overflow-x: hidden;
        }

        a { text-decoration: none; }

        .page-shell {
            width: min(1140px, calc(100% - 2rem));
            margin: 0 auto;
        }

        .top-strip {
            background: var(--navy);
            color: rgba(255,255,255,.86);
            font-size: .78rem;
            font-weight: 700;
            letter-spacing: .02em;
            padding: .55rem 0;
        }

        .top-strip .page-shell {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: .55rem;
            text-align: center;
        }

        .nt-nav {
            position: sticky;
            top: 0;
            z-index: 1000;
            background: rgba(255,255,255,.92);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid var(--line);
        }

        .nav-inner {
            min-height: 74px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
        }

        .brand {
            display: inline-flex;
            align-items: center;
            gap: .72rem;
            color: var(--navy);
            font-weight: 800;
            letter-spacing: -.04em;
            font-size: 1.08rem;
        }

        .brand-mark {
            width: 42px;
            height: 42px;
            display: grid;
            place-items: center;
            border-radius: 50%;
            color: var(--white);
            background: var(--green);
            box-shadow: 0 12px 26px rgba(24, 168, 107, .24);
        }

        .brand span span { color: var(--blue); }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 1.35rem;
        }

        .nav-links a {
            color: var(--muted);
            font-size: .88rem;
            font-weight: 800;
        }

        .nav-links a:hover { color: var(--navy); }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: .65rem;
        }

        .btn-main,
        .btn-lightline {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: .5rem;
            min-height: 43px;
            border-radius: 999px;
            padding: .74rem 1.05rem;
            font-size: .88rem;
            font-weight: 900;
            white-space: nowrap;
            transition: .18s ease;
        }

        .btn-main {
            color: var(--white);
            background: var(--blue);
            box-shadow: 0 15px 28px rgba(18, 103, 217, .22);
        }

        .btn-main:hover {
            color: var(--white);
            transform: translateY(-2px);
            background: #0F58BA;
        }

        .btn-lightline {
            color: var(--navy);
            background: var(--white);
            border: 1px solid var(--line);
        }

        .btn-lightline:hover {
            color: var(--navy);
            transform: translateY(-2px);
            background: var(--sky);
        }

        .hero {
            min-height: calc(100vh - 112px);
            display: flex;
            align-items: center;
            padding: clamp(3rem, 7vw, 6rem) 0;
            background:
                radial-gradient(circle at 8% 14%, rgba(24, 168, 107, .12), transparent 28%),
                linear-gradient(180deg, #FFFFFF 0%, #F5FAFF 100%);
        }

        .hero-grid {
            display: grid;
            grid-template-columns: minmax(0, 1fr) minmax(360px, .82fr);
            align-items: center;
            gap: clamp(2rem, 6vw, 5rem);
        }

        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            color: var(--green-dark);
            background: var(--green-soft);
            border: 1px solid rgba(24, 168, 107, .18);
            border-radius: 999px;
            padding: .55rem .85rem;
            font-size: .76rem;
            font-weight: 900;
            letter-spacing: .08em;
            text-transform: uppercase;
            margin-bottom: 1.15rem;
        }

        .hero h1 {
            margin: 0;
            max-width: 780px;
            color: var(--navy);
            font-family: "Newsreader", serif;
            font-size: clamp(3.8rem, 8vw, 7.6rem);
            line-height: .86;
            letter-spacing: -.06em;
            font-weight: 700;
        }

        .hero h1 span {
            color: var(--green);
            font-style: italic;
        }

        .hero-copy {
            max-width: 625px;
            margin: 1.45rem 0 0;
            color: var(--muted);
            font-size: 1.08rem;
            line-height: 1.85;
        }

        .hero-actions {
            display: flex;
            flex-wrap: wrap;
            gap: .78rem;
            margin-top: 1.8rem;
        }

        .micro-list {
            display: flex;
            flex-wrap: wrap;
            gap: .8rem 1.1rem;
            margin-top: 1.65rem;
            color: #51657B;
            font-size: .9rem;
            font-weight: 800;
        }

        .micro-list span {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
        }

        .micro-list i { color: var(--green); }

        .meal-stage {
            position: relative;
            min-height: 565px;
            display: grid;
            place-items: center;
        }

        .stage-blob {
            position: absolute;
            width: 92%;
            height: 78%;
            border-radius: 46% 54% 48% 52%;
            background: linear-gradient(140deg, var(--blue-soft), #FFFFFF 52%, var(--green-soft));
            border: 1px solid rgba(18, 103, 217, .10);
            transform: rotate(-5deg);
        }

        .plate-ring {
            position: relative;
            width: min(430px, 92vw);
            aspect-ratio: 1;
            border-radius: 50%;
            background: var(--white);
            box-shadow: var(--shadow);
            border: 1px solid var(--line);
            display: grid;
            place-items: center;
        }

        .plate-inner {
            width: 67%;
            aspect-ratio: 1;
            border-radius: 50%;
            background:
                radial-gradient(circle at center, #FFFFFF 0 32%, transparent 33%),
                conic-gradient(from 0deg,
                    #BFEBD6 0deg 70deg,
                    #D7E9FF 70deg 155deg,
                    #E9F8EF 155deg 235deg,
                    #CFE4FF 235deg 315deg,
                    #BFEBD6 315deg 360deg);
            border: 10px solid #F7FBFF;
            display: grid;
            place-items: center;
            text-align: center;
            padding: 2rem;
        }

        .plate-inner strong {
            display: block;
            color: var(--navy);
            font-size: 2.25rem;
            line-height: .95;
            letter-spacing: -.06em;
        }

        .plate-inner small {
            display: block;
            color: var(--muted);
            font-weight: 800;
            margin-top: .55rem;
        }

        .meal-ticket {
            position: absolute;
            width: 205px;
            padding: .85rem .95rem;
            border-radius: 999px;
            background: rgba(255,255,255,.94);
            border: 1px solid var(--line);
            box-shadow: 0 18px 45px rgba(8,35,74,.12);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: .8rem;
        }

        .meal-ticket b {
            display: block;
            color: var(--navy);
            font-size: .9rem;
            line-height: 1.1;
        }

        .meal-ticket span {
            color: var(--muted);
            font-size: .72rem;
            font-weight: 800;
        }

        .meal-ticket i {
            width: 36px;
            height: 36px;
            flex: 0 0 auto;
            display: grid;
            place-items: center;
            border-radius: 50%;
            color: var(--white);
            background: var(--green);
        }

        .ticket-one { top: 9%; left: 0; }
        .ticket-two { top: 18%; right: -2%; }
        .ticket-three { bottom: 19%; left: -3%; }
        .ticket-four { bottom: 8%; right: 3%; }

        .section {
            padding: clamp(4rem, 8vw, 6.5rem) 0;
        }

        .section-heading {
            max-width: 760px;
            margin-bottom: 2.2rem;
        }

        .kicker {
            color: var(--blue);
            font-size: .78rem;
            font-weight: 900;
            letter-spacing: .11em;
            text-transform: uppercase;
            margin-bottom: .65rem;
        }

        .section-title {
            margin: 0;
            color: var(--navy);
            font-family: "Newsreader", serif;
            font-size: clamp(3rem, 6vw, 5.6rem);
            line-height: .9;
            letter-spacing: -.055em;
            font-weight: 700;
        }

        .section-copy {
            max-width: 660px;
            color: var(--muted);
            font-size: 1rem;
            line-height: 1.8;
            margin-top: 1rem;
        }

        .story-board {
            border-top: 1px solid var(--line);
        }

        .story-step {
            display: grid;
            grid-template-columns: 140px minmax(0, .9fr) minmax(260px, .8fr);
            align-items: center;
            gap: 2rem;
            padding: 2.2rem 0;
            border-bottom: 1px solid var(--line);
        }

        .story-num {
            color: rgba(18, 103, 217, .22);
            font-family: "Newsreader", serif;
            font-size: clamp(4rem, 8vw, 7rem);
            font-weight: 700;
            line-height: .85;
        }

        .story-step h3 {
            margin: 0 0 .65rem;
            color: var(--navy);
            font-size: clamp(1.35rem, 3vw, 2.2rem);
            letter-spacing: -.04em;
            font-weight: 900;
        }

        .story-step p {
            color: var(--muted);
            line-height: 1.75;
            margin: 0;
        }

        .story-chipline {
            display: flex;
            flex-wrap: wrap;
            justify-content: flex-end;
            gap: .6rem;
        }

        .story-chipline span {
            color: var(--navy);
            background: var(--sky);
            border: 1px solid var(--line);
            border-radius: 999px;
            padding: .55rem .78rem;
            font-size: .8rem;
            font-weight: 900;
        }

        .green-band {
            background: var(--green-dark);
            color: var(--white);
            overflow: hidden;
        }

        .band-inner {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 3rem;
            align-items: center;
        }

        .green-band .kicker { color: #BDF3D7; }
        .green-band .section-title { color: var(--white); }
        .green-band .section-copy { color: rgba(255,255,255,.76); }

        .preference-orbit {
            min-height: 420px;
            position: relative;
            display: grid;
            place-items: center;
        }

        .orbit-core {
            width: 220px;
            height: 220px;
            border-radius: 50%;
            display: grid;
            place-items: center;
            text-align: center;
            padding: 1.4rem;
            color: var(--navy);
            background: var(--white);
            box-shadow: 0 24px 60px rgba(0,0,0,.12);
            font-weight: 900;
            letter-spacing: -.04em;
            font-size: 1.35rem;
        }

        .orbit-pill {
            position: absolute;
            color: var(--white);
            border: 1px solid rgba(255,255,255,.24);
            background: rgba(255,255,255,.13);
            backdrop-filter: blur(12px);
            border-radius: 999px;
            padding: .7rem 1rem;
            font-size: .86rem;
            font-weight: 900;
        }

        .pill-a { top: 14%; left: 12%; }
        .pill-b { top: 12%; right: 10%; }
        .pill-c { right: 0; top: 48%; }
        .pill-d { bottom: 13%; right: 18%; }
        .pill-e { bottom: 14%; left: 9%; }
        .pill-f { left: 0; top: 48%; }

        .simple-modules {
            display: grid;
            gap: 0;
            border-top: 1px solid var(--line);
        }

        .module-row {
            display: grid;
            grid-template-columns: 1fr 1.2fr auto;
            gap: 1.5rem;
            align-items: center;
            padding: 1.35rem 0;
            border-bottom: 1px solid var(--line);
        }

        .module-row h3 {
            margin: 0;
            color: var(--navy);
            font-size: 1.2rem;
            font-weight: 900;
            letter-spacing: -.03em;
        }

        .module-row p {
            color: var(--muted);
            line-height: 1.7;
            margin: 0;
        }

        .module-row span {
            color: var(--green-dark);
            font-size: .82rem;
            font-weight: 900;
            background: var(--green-soft);
            border-radius: 999px;
            padding: .5rem .75rem;
            white-space: nowrap;
        }

        .cta-panel {
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 2rem;
            align-items: center;
            padding: clamp(2rem, 5vw, 3.2rem);
            border-radius: 36px;
            background: linear-gradient(135deg, var(--blue), #0A8B62);
            color: var(--white);
            box-shadow: var(--shadow);
        }

        .cta-panel h2 {
            margin: 0;
            max-width: 680px;
            font-family: "Newsreader", serif;
            font-size: clamp(2.6rem, 5vw, 5rem);
            line-height: .92;
            letter-spacing: -.055em;
            font-weight: 700;
        }

        .cta-panel p {
            color: rgba(255,255,255,.78);
            max-width: 610px;
            line-height: 1.75;
            margin: 1rem 0 0;
        }

        .cta-actions {
            display: flex;
            flex-wrap: wrap;
            gap: .75rem;
        }

        .cta-actions .btn-main {
            color: var(--blue);
            background: var(--white);
            box-shadow: none;
        }

        .cta-actions .btn-lightline {
            color: var(--white);
            background: transparent;
            border-color: rgba(255,255,255,.32);
        }

        .nt-footer {
            padding: 2rem 0;
            color: var(--muted);
            border-top: 1px solid var(--line);
            font-size: .88rem;
        }

        .footer-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
        }

        .footer-inner strong { color: var(--navy); }

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
            .nav-links { display: none; }

            .hero {
                min-height: auto;
            }

            .hero-grid,
            .band-inner,
            .cta-panel {
                grid-template-columns: 1fr;
            }

            .meal-stage {
                min-height: 510px;
            }

            .story-step {
                grid-template-columns: 90px 1fr;
            }

            .story-chipline {
                grid-column: 2 / -1;
                justify-content: flex-start;
            }

            .module-row {
                grid-template-columns: 1fr;
                gap: .65rem;
            }

            .module-row span {
                justify-self: flex-start;
            }
        }

        @media (max-width: 767px) {
            .page-shell { width: min(100% - 1rem, 1140px); }

            .top-strip { font-size: .72rem; }

            .nav-inner {
                min-height: 68px;
                align-items: flex-start;
                padding: .8rem 0;
            }

            .brand { font-size: 1rem; }
            .brand-mark { width: 38px; height: 38px; }

            .nav-actions {
                flex-wrap: wrap;
                justify-content: flex-end;
            }

            .btn-main,
            .btn-lightline {
                min-height: 38px;
                padding: .62rem .78rem;
                font-size: .78rem;
            }

            .hero h1 {
                font-size: 4.1rem;
            }

            .meal-stage {
                min-height: 560px;
            }

            .plate-ring {
                width: min(330px, 86vw);
            }

            .plate-inner strong {
                font-size: 1.65rem;
            }

            .meal-ticket {
                width: 190px;
                padding: .72rem .78rem;
            }

            .ticket-one { top: 1%; left: 2%; }
            .ticket-two { top: 15%; right: 0; }
            .ticket-three { bottom: 18%; left: 0; }
            .ticket-four { bottom: 2%; right: 0; }

            .story-step {
                grid-template-columns: 1fr;
                gap: .8rem;
                padding: 1.8rem 0;
            }

            .story-num {
                font-size: 4rem;
            }

            .story-chipline {
                grid-column: auto;
            }

            .preference-orbit {
                min-height: 520px;
            }

            .orbit-core {
                width: 190px;
                height: 190px;
            }

            .pill-a { top: 6%; left: 6%; }
            .pill-b { top: 5%; right: 5%; }
            .pill-c { top: 38%; right: 0; }
            .pill-d { bottom: 12%; right: 5%; }
            .pill-e { bottom: 10%; left: 5%; }
            .pill-f { top: 39%; left: 0; }

            .footer-inner {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
</head>
<body>
<div class="top-strip">
    <div class="page-shell">
        <i class="bi bi-stars"></i>
        <span>Final Year Project user testing version - web-based healthy meal recommendation system</span>
    </div>
</div>

<nav class="nt-nav">
    <div class="page-shell">
        <div class="nav-inner">
            <a href="{{ url('/') }}" class="brand">
                <span class="brand-mark"><i class="bi bi-heart-pulse-fill"></i></span>
                <span>Nutri<span>Track</span></span>
            </a>

            <div class="nav-links">
                <a href="#how">How it works</a>
                <a href="#personal">Personalization</a>
                <a href="#modules">Modules</a>
            </div>

            <div class="nav-actions">
                @if(Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn-main">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="btn-lightline">Login</a>
                        @if(Route::has('register'))
                            <a href="{{ route('register') }}" class="btn-main">Get Started</a>
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
                <div class="reveal">
                    <div class="eyebrow">
                        <i class="bi bi-clipboard2-pulse"></i>
                        Personalized meal planning
                    </div>

                    <h1>Healthy eating made <span>personal.</span></h1>

                    <p class="hero-copy">
                        NutriTrack turns your health profile into daily meal guidance. Complete a quick quiz,
                        calculate your calorie needs, compare Meal Options, and save meals into your Meal Log.
                    </p>

                    <div class="hero-actions">
                        <a href="{{ route('guest.quiz') }}" class="btn-main">
                            <i class="bi bi-play-circle"></i>
                            Start Starter Quiz
                        </a>
                        <a href="#how" class="btn-lightline">
                            See how it works
                        </a>
                    </div>

                    <div class="micro-list">
                        <span><i class="bi bi-check-circle-fill"></i> BMI, BMR, TDEE and DCR</span>
                        <span><i class="bi bi-check-circle-fill"></i> Allergy-aware filtering</span>
                        <span><i class="bi bi-check-circle-fill"></i> AI Food Logger</span>
                    </div>
                </div>

                <div class="meal-stage reveal" aria-label="NutriTrack meal planning visual">
                    <div class="stage-blob"></div>

                    <div class="plate-ring">
                        <div class="plate-inner">
                            <div>
                                <strong>1,850<br>kcal</strong>
                                <small>example daily target</small>
                            </div>
                        </div>
                    </div>

                    <div class="meal-ticket ticket-one">
                        <div>
                            <b>Breakfast</b>
                            <span>Avocado Toast</span>
                        </div>
                        <i class="bi bi-sunrise"></i>
                    </div>

                    <div class="meal-ticket ticket-two">
                        <div>
                            <b>Lunch</b>
                            <span>Chicken Bowl</span>
                        </div>
                        <i class="bi bi-basket2"></i>
                    </div>

                    <div class="meal-ticket ticket-three">
                        <div>
                            <b>Dinner</b>
                            <span>Grilled Plate</span>
                        </div>
                        <i class="bi bi-moon-stars"></i>
                    </div>

                    <div class="meal-ticket ticket-four">
                        <div>
                            <b>Snack</b>
                            <span>Fruit Cup</span>
                        </div>
                        <i class="bi bi-cup-straw"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section" id="how">
        <div class="page-shell">
            <div class="section-heading reveal">
                <div class="kicker">How NutriTrack works</div>
                <h2 class="section-title">No heavy reading. Just a simple path.</h2>
                <p class="section-copy">
                    The landing page focuses on the actual user journey so new testers can understand the system quickly.
                </p>
            </div>

            <div class="story-board">
                <div class="story-step reveal">
                    <div class="story-num">01</div>
                    <div>
                        <h3>It starts with a few questions.</h3>
                        <p>The Starter Quiz collects basic details such as goal, activity level, allergies, and preferred cuisine.</p>
                    </div>
                    <div class="story-chipline">
                        <span>Goal</span>
                        <span>Activity</span>
                        <span>Allergies</span>
                    </div>
                </div>

                <div class="story-step reveal">
                    <div class="story-num">02</div>
                    <div>
                        <h3>NutriTrack calculates your profile.</h3>
                        <p>The system calculates BMI, BMR, TDEE, DCR, and healthy weight range for recommendation support.</p>
                    </div>
                    <div class="story-chipline">
                        <span>BMI</span>
                        <span>BMR</span>
                        <span>TDEE</span>
                        <span>DCR</span>
                    </div>
                </div>

                <div class="story-step reveal">
                    <div class="story-num">03</div>
                    <div>
                        <h3>Meals are matched and saved.</h3>
                        <p>Users can view Daily Plan, compare Meal Options, generate Weekly Plan, and save meals into the Meal Log.</p>
                    </div>
                    <div class="story-chipline">
                        <span>Daily Plan</span>
                        <span>Meal Options</span>
                        <span>Meal Log</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section green-band" id="personal">
        <div class="page-shell">
            <div class="band-inner">
                <div class="reveal">
                    <div class="kicker">Personalized but simple</div>
                    <h2 class="section-title">The system filters before it recommends.</h2>
                    <p class="section-copy">
                        NutriTrack considers calorie needs, allergies, meal time, nutrition value, rating data, and only the accepted cuisine categories used in this project.
                    </p>
                </div>

                <div class="preference-orbit reveal" aria-label="NutriTrack personalization factors">
                    <div class="orbit-core">Meal match from user profile</div>
                    <span class="orbit-pill pill-a">Malay</span>
                    <span class="orbit-pill pill-b">Chinese</span>
                    <span class="orbit-pill pill-c">Indian</span>
                    <span class="orbit-pill pill-d">Western</span>
                    <span class="orbit-pill pill-e">Middle Eastern</span>
                    <span class="orbit-pill pill-f">Allergy check</span>
                </div>
            </div>
        </div>
    </section>

    <section class="section" id="modules">
        <div class="page-shell">
            <div class="section-heading reveal">
                <div class="kicker">Main modules</div>
                <h2 class="section-title">Everything stays focused.</h2>
                <p class="section-copy">
                    Instead of showing many repeated cards, this page keeps the main NutriTrack functions in a simple list.
                </p>
            </div>

            <div class="simple-modules">
                <div class="module-row reveal">
                    <h3>Health Profile</h3>
                    <p>Calculates health values and stores user preferences for recommendation.</p>
                    <span>Profile setup</span>
                </div>

                <div class="module-row reveal">
                    <h3>Daily Plan</h3>
                    <p>Generates a ready-to-follow daily meal plan based on DCR.</p>
                    <span>Meal planning</span>
                </div>

                <div class="module-row reveal">
                    <h3>Meal Options</h3>
                    <p>Shows alternative meal choices that fit allergy, cuisine, meal time, and calorie needs.</p>
                    <span>Choice support</span>
                </div>

                <div class="module-row reveal">
                    <h3>AI Food Logger</h3>
                    <p>Estimates nutrition information and healthiness from a food description.</p>
                    <span>AI estimate</span>
                </div>

                <div class="module-row reveal">
                    <h3>Meal Log</h3>
                    <p>Keeps saved meals and logged food records in one place.</p>
                    <span>Tracking</span>
                </div>
            </div>
        </div>
    </section>

    <section class="section pt-0">
        <div class="page-shell">
            <div class="cta-panel reveal">
                <div>
                    <h2>Testing NutriTrack?</h2>
                    <p>
                        Start with the quiz, complete your profile, then try Daily Plan, AI Food Logger,
                        Weekly Plan, Meal Options, and Meal Log before answering the questionnaire.
                    </p>
                </div>

                <div class="cta-actions">
                    <a href="{{ route('guest.quiz') }}" class="btn-main">
                        <i class="bi bi-clipboard2-pulse"></i>
                        Start Quiz
                    </a>
                    @if(Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="btn-lightline">Open Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="btn-lightline">Login</a>
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </section>
</main>

<footer class="nt-footer">
    <div class="page-shell">
        <div class="footer-inner">
            <div><strong>NutriTrack</strong><br>Personalized Healthy Meal Recommendation System</div>
            <div>Laravel 12 · Bootstrap 5 · MySQL</div>
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
