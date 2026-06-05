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
           FOOD ART
        ======================= */
        .food-stage {
            position: relative;
            min-height: 590px;
            z-index: 3;
        }

        .plate-glow {
            position: absolute;
            width: 410px;
            height: 410px;
            right: 6%;
            top: 50%;
            transform: translateY(-50%);
            border-radius: 50%;
            background:
                radial-gradient(circle, rgba(167,243,91,.42), transparent 58%);
            filter: blur(35px);
            animation: glowPulse 3.5s ease-in-out infinite alternate;
        }

        @keyframes glowPulse {
            from { opacity: .55; transform: translateY(-50%) scale(.94); }
            to { opacity: 1; transform: translateY(-50%) scale(1.05); }
        }

        .plate {
            position: absolute;
            width: 380px;
            height: 380px;
            right: 8%;
            top: 50%;
            transform: translateY(-50%);
            border-radius: 50%;
            background:
                radial-gradient(circle at 50% 50%, #FFFDF4 0 48%, #EAF7E9 49% 63%, #FFFFFF 64% 100%);
            box-shadow:
                0 45px 100px rgba(0,0,0,.35),
                inset 0 0 0 16px rgba(255,255,255,.7);
            animation: plateFloat 5s ease-in-out infinite alternate;
        }

        @keyframes plateFloat {
            from { margin-top: 0; }
            to { margin-top: -18px; }
        }

        .salad {
            position: absolute;
            width: 220px;
            height: 220px;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            border-radius: 50%;
            background:
                radial-gradient(circle at 35% 35%, #A7F35B 0 10%, transparent 11%),
                radial-gradient(circle at 60% 30%, #35D07F 0 12%, transparent 13%),
                radial-gradient(circle at 45% 65%, #16A34A 0 13%, transparent 14%),
                radial-gradient(circle at 70% 65%, #FFB347 0 9%, transparent 10%),
                radial-gradient(circle at 30% 70%, #F97316 0 8%, transparent 9%),
                linear-gradient(135deg, #DFFFEA, #B7F7C8);
            box-shadow: inset 0 -18px 40px rgba(8,17,12,.12);
        }

        .food-emoji {
            position: absolute;
            width: 76px;
            height: 76px;
            border-radius: 28px;
            display: grid;
            place-items: center;
            font-size: 2.45rem;
            background: rgba(255,255,255,.86);
            border: 1px solid rgba(255,255,255,.55);
            backdrop-filter: blur(18px);
            box-shadow: 0 24px 50px rgba(0,0,0,.22);
            animation: foodFloat 4s ease-in-out infinite alternate;
        }

        .f1 { right: 55%; top: 12%; animation-delay: .1s; }
        .f2 { right: 2%; top: 18%; animation-delay: .5s; }
        .f3 { right: 56%; bottom: 14%; animation-delay: .9s; }
        .f4 { right: 6%; bottom: 10%; animation-delay: 1.3s; }

        @keyframes foodFloat {
            from { transform: translateY(0) rotate(-3deg); }
            to { transform: translateY(-18px) rotate(4deg); }
        }

        .floating-card {
            position: absolute;
            z-index: 6;
            width: 210px;
            border-radius: 28px;
            padding: 1rem;
            background: rgba(255,255,255,.12);
            border: 1px solid rgba(255,255,255,.18);
            backdrop-filter: blur(22px);
            box-shadow: 0 24px 70px rgba(0,0,0,.22);
            color: white;
        }

        .floating-card.one {
            left: 4%;
            top: 14%;
        }

        .floating-card.two {
            right: 0;
            bottom: 18%;
        }

        .floating-label {
            color: rgba(255,255,255,.6);
            font-size: .7rem;
            text-transform: uppercase;
            letter-spacing: .1em;
            font-weight: 900;
            margin-bottom: .35rem;
        }

        .floating-title {
            font-size: .95rem;
            font-weight: 900;
            line-height: 1.35;
            margin-bottom: .8rem;
        }

        .floating-meter {
            height: 8px;
            border-radius: 999px;
            background: rgba(255,255,255,.14);
            overflow: hidden;
        }

        .floating-meter span {
            display: block;
            height: 100%;
            border-radius: 999px;
            background: linear-gradient(90deg, var(--green), var(--green-2));
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

            .food-stage {
                min-height: 500px;
                margin-top: 2rem;
            }

            .plate {
                width: 330px;
                height: 330px;
                right: 50%;
                transform: translate(50%, -50%);
            }

            .plate-glow {
                right: 50%;
                transform: translate(50%, -50%);
            }

            .floating-card.one {
                left: 0;
            }

            .floating-card.two {
                right: 0;
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

            .btn-hero-primary,
            .btn-hero-ghost,
            .btn-cta {
                width: 100%;
            }

            .food-stage {
                min-height: 430px;
            }

            .plate {
                width: 270px;
                height: 270px;
            }

            .salad {
                width: 155px;
                height: 155px;
            }

            .food-emoji {
                width: 58px;
                height: 58px;
                border-radius: 22px;
                font-size: 1.9rem;
            }

            .floating-card {
                width: 178px;
                padding: .9rem;
            }

            .floating-card.one {
                top: 4%;
            }

            .floating-card.two {
                bottom: 4%;
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
                            Your next meal should already <em>understand you.</em>
                        </h1>

                        <p class="hero-desc">
                            NutriTrack recommends healthier meals based on your daily calorie requirement,
                            food allergies, personal goal, and cuisine preference — helping you plan meals
                            with less guessing and more confidence.
                        </p>

                        <div class="hero-actions">
                            <a href="{{ route('guest.quiz') }}" class="btn-hero-primary">
                                <i class="bi bi-rocket-takeoff-fill"></i>
                                Get started free
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
                    <div class="food-stage">
                        <div class="plate-glow"></div>

                        <div class="plate">
                            <div class="salad"></div>
                        </div>

                        <div class="food-emoji f1">🥑</div>
                        <div class="food-emoji f2">🍓</div>
                        <div class="food-emoji f3">🍚</div>
                        <div class="food-emoji f4">🥗</div>

                        <div class="floating-card one">
                            <div class="floating-label">Meal Safety</div>
                            <div class="floating-title">Allergy-risk meals are filtered first.</div>
                            <div class="floating-meter">
                                <span style="width: 88%;"></span>
                            </div>
                        </div>

                        <div class="floating-card two">
                            <div class="floating-label">Meal Fit</div>
                            <div class="floating-title">Meals are ranked by goal and calorie gap.</div>
                            <div class="floating-meter">
                                <span style="width: 74%;"></span>
                            </div>
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
                    <span class="marquee-item"><i class="bi bi-check-circle-fill"></i> Meal diary support</span>
                    <span class="marquee-item"><i class="bi bi-check-circle-fill"></i> Swap and rate meals</span>

                    <span class="marquee-item"><i class="bi bi-check-circle-fill"></i> Breakfast, lunch, dinner, and snack planning</span>
                    <span class="marquee-item"><i class="bi bi-check-circle-fill"></i> Personalized calorie targets</span>
                    <span class="marquee-item"><i class="bi bi-check-circle-fill"></i> Allergy-aware recommendations</span>
                    <span class="marquee-item"><i class="bi bi-check-circle-fill"></i> Meal diary support</span>
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
                <h2 class="section-title">Not just meal ideas. A smarter recommendation flow.</h2>
            </div>

            <div class="col-12 col-lg-5 reveal">
                <p class="section-desc ms-lg-auto">
                    NutriTrack uses user profile data, calorie calculation, allergy filtering,
                    and preference-based scoring to recommend meals that feel more personal and practical.
                </p>
            </div>
        </div>

        <div class="bento-grid">
            <div class="bento-card large reveal">
                <div class="bento-icon">
                    <i class="bi bi-calculator-fill"></i>
                </div>
                <h3>Daily calorie requirement calculation</h3>
                <p>
                    NutriTrack calculates BMR, TDEE, and Daily Caloric Requirement based on user profile details
                    such as age, weight, height, activity level, and health goal.
                </p>
                <div class="bento-big-text">DCR</div>
            </div>

            <div class="bento-card medium reveal">
                <div class="bento-icon" style="background: #FFF2D8;">
                    <i class="bi bi-shield-check-fill"></i>
                </div>
                <h3>Allergy-aware meal filtering</h3>
                <p>
                    Meals that may contain declared allergens are filtered out before recommendations are shown.
                </p>
                <div class="bento-big-text">Safe</div>
            </div>

            <div class="bento-card small reveal">
                <div class="bento-icon" style="background: #E0F2FE;">
                    <i class="bi bi-cup-hot-fill"></i>
                </div>
                <h3>Cuisine preference matching</h3>
                <p>
                    Meals matching the user’s preferred cuisine receive better ranking scores.
                </p>
                <div class="bento-big-text">Taste</div>
            </div>

            <div class="bento-card small reveal">
                <div class="bento-icon" style="background: #F3E8FF;">
                    <i class="bi bi-calendar-week-fill"></i>
                </div>
                <h3>Weekly meal planning</h3>
                <p>
                    Users can plan meals across different days for a more consistent eating routine.
                </p>
                <div class="bento-big-text">Plan</div>
            </div>

            <div class="bento-card small reveal">
                <div class="bento-icon" style="background: #FFE4E6;">
                    <i class="bi bi-arrow-repeat"></i>
                </div>
                <h3>Swap and rate meals</h3>
                <p>
                    Users can change unsuitable meals and rate recommendations based on their experience.
                </p>
                <div class="bento-big-text">Rate</div>
            </div>

            <div class="bento-card medium reveal">
                <div class="bento-icon" style="background: #DCFCE7;">
                    <i class="bi bi-journal-check"></i>
                </div>
                <h3>Personal meal diary</h3>
                <p>
                    Recommended meals can be saved into a personal diary, allowing users to review their saved meals anytime.
                </p>
                <div class="bento-big-text">Diary</div>
            </div>

            <div class="bento-card large reveal">
                <div class="bento-icon" style="background: #FEF9C3;">
                    <i class="bi bi-magic"></i>
                </div>
                <h3>AI food logger support</h3>
                <p>
                    Users can describe what they ate and receive estimated calorie and macro information,
                    supporting better awareness of their daily food intake.
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
                    <h4><i class="bi bi-journal-check me-1" style="color:#16A34A;"></i> Save to diary</h4>
                    <p>Users can save selected meals and review them later in their personal meal diary.</p>
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
                                <div style="font-size:2rem;margin-bottom:.5rem;">🔥</div>
                                <h5 style="font-weight:900;color:var(--dark);">BMR & TDEE</h5>
                                <p style="color:var(--muted);font-size:.9rem;line-height:1.7;margin:0;">
                                    Learn how your body burns calories at rest and during daily activity.
                                </p>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div style="border-radius:24px;padding:1rem;background:#FFF8E8;border:1px solid rgba(249,115,22,.12);height:100%;">
                                <div style="font-size:2rem;margin-bottom:.5rem;">🎯</div>
                                <h5 style="font-weight:900;color:var(--dark);">DCR</h5>
                                <p style="color:var(--muted);font-size:.9rem;line-height:1.7;margin:0;">
                                    Understand how NutriTrack adjusts calories based on lose, maintain, or gain weight goals.
                                </p>
                            </div>
                        </div>

                        <div class="col-12">
                            <div style="border-radius:24px;padding:1rem;background:#F0F9FF;border:1px solid rgba(14,165,233,.12);">
                                <div style="font-size:2rem;margin-bottom:.5rem;">🍽️</div>
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