<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>Sistem Informasi Pemetaan Keterampilan Desa</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <style>
        /* ===============================
   ROOT VARIABLES
=============================== */
:root {
    --primary: #2f855a;
    --primary-dark: #1f6f4a;
    --primary-light: #68d391;
    --primary-gradient: linear-gradient(135deg, #2f855a 0%, #48bb78 50%, #68d391 100%);
    --light-bg: #f0f7f2;
    --text-dark: #1a2a2a;
    --text-muted: #5a6b6b;
    --white: #ffffff;
    --shadow-sm: 0 4px 15px rgba(0, 0, 0, 0.06);
    --shadow-md: 0 8px 30px rgba(0, 0, 0, 0.10);
    --shadow-lg: 0 15px 50px rgba(0, 0, 0, 0.12);
    --radius-sm: 12px;
    --radius-md: 20px;
    --radius-lg: 28px;
    --transition: all 0.5s cubic-bezier(0.22, 1, 0.36, 1);
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

html {
    scroll-behavior: smooth;
    -webkit-tap-highlight-color: transparent;
    overflow-x: hidden;
}

body {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    color: var(--text-dark);
    background: var(--light-bg);
    overflow-x: hidden;
    -webkit-font-smoothing: antialiased;
    width: 100%;
    max-width: 100vw;
}

img,
svg,
iframe,
video {
    max-width: 100%;
    height: auto;
    display: block;
}

section {
    scroll-margin-top: 80px;
    padding: 80px 0;
}

.container {
    max-width: 100%;
    overflow-x: hidden;
}

.row {
    margin-left: 0;
    margin-right: 0;
}

[class*="col-"] {
    padding-left: 12px;
    padding-right: 12px;
}

/* ===============================
   ANIMASI
=============================== */
@keyframes float {
    0%,
    100% {
        transform: translateY(0px);
    }
    50% {
        transform: translateY(-12px);
    }
}

@keyframes shimmer {
    0% {
        background-position: -200% center;
    }
    100% {
        background-position: 200% center;
    }
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes pulse-dot {
    0%,
    100% {
        opacity: 1;
        transform: scale(1);
    }
    50% {
        opacity: 0.30;
        transform: scale(0.70);
    }
}

@keyframes float-particle {
    0% {
        transform: translate(0, 0) scale(1);
        opacity: 0.3;
    }
    25% {
        transform: translate(30px, -60px) scale(1.2);
        opacity: 0.6;
    }
    50% {
        transform: translate(-20px, -120px) scale(0.8);
        opacity: 0.4;
    }
    75% {
        transform: translate(40px, -80px) scale(1.1);
        opacity: 0.7;
    }
    100% {
        transform: translate(0, -160px) scale(1);
        opacity: 0.2;
    }
}

@keyframes scaleIn {
    from {
        opacity: 0;
        transform: scale(0.8);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}

/* ===============================
   NAVBAR
=============================== */
.navbar {
    background: rgba(255, 255, 255, 0);
    backdrop-filter: blur(0px);
    box-shadow: none;
    padding: 1.2rem 0;
    transition: var(--transition);
    min-height: 80px;
}

.navbar.scrolled {
    background: rgba(255, 255, 255, 0.92);
    backdrop-filter: blur(16px);
    -webkit-backdrop-filter: blur(16px);
    box-shadow: 0 4px 30px rgba(0, 0, 0, 0.08);
    padding: 0.6rem 0;
}

.navbar-brand {
    display: flex;
    align-items: center;
    gap: 12px;
    font-weight: 800;
    color: var(--white) !important;
    transition: var(--transition);
}

.navbar.scrolled .navbar-brand {
    color: var(--primary) !important;
}

.logo-navbar {
    width: 48px;
    height: 48px;
    object-fit: contain;
    flex-shrink: 0;
    filter: drop-shadow(0 2px 8px rgba(0, 0, 0, 0.10));
}

.navbar.scrolled .logo-navbar {
    filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.05));
}

.brand-title {
    font-size: 1.1rem;
    font-weight: 800;
    line-height: 1.2;
    letter-spacing: -0.3px;
}

.brand-subtitle {
    font-size: 0.6rem;
    font-weight: 500;
    opacity: 0.8;
    display: block;
    letter-spacing: 0.5px;
    text-transform: uppercase;
}

.navbar .nav-link {
    color: rgba(255, 255, 255, 0.85) !important;
    font-weight: 500;
    padding: 0.5rem 1rem;
    border-radius: 10px;
    transition: var(--transition);
    position: relative;
    font-size: 0.92rem;
}

.navbar.scrolled .nav-link {
    color: var(--text-dark) !important;
}

.navbar .nav-link:hover {
    color: var(--white) !important;
    background: rgba(255, 255, 255, 0.12);
}

.navbar.scrolled .nav-link:hover {
    color: var(--primary) !important;
    background: rgba(47, 133, 90, 0.08);
}

.navbar .nav-link.active {
    color: var(--white) !important;
    font-weight: 600;
}

.navbar.scrolled .nav-link.active {
    color: var(--primary) !important;
}

.navbar .nav-link.active::after {
    content: '';
    position: absolute;
    bottom: 4px;
    left: 50%;
    transform: translateX(-50%);
    width: 20px;
    height: 3px;
    background: var(--white);
    border-radius: 999px;
    transition: var(--transition);
}

.navbar.scrolled .nav-link.active::after {
    background: var(--primary);
}

.navbar-toggler {
    border: none;
    padding: 0.4rem 0.6rem;
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(8px);
    border-radius: 10px;
    color: var(--white);
    transition: var(--transition);
}

.navbar.scrolled .navbar-toggler {
    background: rgba(0, 0, 0, 0.05);
    color: var(--text-dark);
}

.navbar-toggler:focus {
    box-shadow: none !important;
}

/* ===============================
   HERO SECTION
=============================== */
.hero {
    position: relative;
    min-height: 100vh;
    min-height: 100dvh;
    display: flex;
    align-items: center;
    overflow: hidden;
    background:
        linear-gradient(135deg,
            rgba(8, 35, 24, 0.60) 0%,
            rgba(8, 35, 24, 0.30) 50%,
            rgba(8, 35, 24, 0.10) 100%),
        url("{{ asset('images/bgg.png') }}") center center / cover no-repeat;
    padding: 100px 0 60px;
}

.hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background:
        radial-gradient(circle at 30% 20%, rgba(47, 133, 90, 0.25) 0%, transparent 60%),
        radial-gradient(circle at 70% 80%, rgba(47, 133, 90, 0.15) 0%, transparent 50%);
    pointer-events: none;
    z-index: 1;
}

.hero-particles {
    position: absolute;
    inset: 0;
    z-index: 0;
    pointer-events: none;
    overflow: hidden;
}

.hero-particles span {
    position: absolute;
    width: 6px;
    height: 6px;
    background: rgba(255, 255, 255, 0.15);
    border-radius: 50%;
    animation: float-particle linear infinite;
}

.hero-particles span:nth-child(1) {
    left: 10%;
    top: 20%;
    animation-duration: 18s;
    width: 8px;
    height: 8px;
}
.hero-particles span:nth-child(2) {
    left: 20%;
    top: 60%;
    animation-duration: 22s;
    animation-delay: 2s;
}
.hero-particles span:nth-child(3) {
    left: 80%;
    top: 15%;
    animation-duration: 16s;
    animation-delay: 4s;
    width: 10px;
    height: 10px;
}
.hero-particles span:nth-child(4) {
    left: 85%;
    top: 70%;
    animation-duration: 20s;
    animation-delay: 1s;
}
.hero-particles span:nth-child(5) {
    left: 50%;
    top: 85%;
    animation-duration: 24s;
    animation-delay: 3s;
    width: 12px;
    height: 12px;
}
.hero-particles span:nth-child(6) {
    left: 5%;
    top: 40%;
    animation-duration: 19s;
    animation-delay: 5s;
}

.hero-content {
    position: relative;
    z-index: 2;
}

.hero-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 20px;
    border-radius: 999px;
    background: rgba(255, 255, 255, 0.18);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    border: 1px solid rgba(255, 255, 255, 0.20);
    font-weight: 600;
    font-size: 0.78rem;
    color: var(--white);
    margin-bottom: 20px;
    animation: slideDown 0.6s ease;
}

.hero-badge i {
    color: #68d391;
    font-size: 0.85rem;
}

.hero h1 {
    font-size: clamp(2rem, 7vw, 4.2rem);
    font-weight: 900;
    line-height: 1.10;
    color: var(--white);
    text-shadow: 0 2px 30px rgba(0, 0, 0, 0.20);
    margin-bottom: 16px;
    letter-spacing: -0.02em;
}

.hero h1 .highlight {
    background: linear-gradient(135deg, #68d391, #48bb78, #68d391);
    background-size: 200% auto;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    animation: shimmer 4s ease-in-out infinite;
}

.hero p {
    font-size: clamp(0.95rem, 1.2vw, 1.15rem);
    color: rgba(255, 255, 255, 0.90);
    max-width: 580px;
    line-height: 1.8;
    text-shadow: 0 1px 12px rgba(0, 0, 0, 0.10);
    margin-bottom: 0;
}

.hero-buttons {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    margin-top: 28px;
}

.btn-main {
    background: var(--primary-gradient);
    border: none;
    padding: 14px 34px;
    border-radius: 50px;
    font-weight: 700;
    font-size: clamp(0.85rem, 1vw, 1rem);
    color: white !important;
    box-shadow: 0 12px 35px rgba(47, 133, 90, 0.30);
    transition: var(--transition);
    display: inline-flex;
    align-items: center;
    gap: 10px;
    text-decoration: none;
    position: relative;
    overflow: hidden;
}

.btn-main::after {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(255, 255, 255, 0.15), transparent);
    opacity: 0;
    transition: var(--transition);
}

.btn-main:hover {
    transform: translateY(-3px) scale(1.02);
    box-shadow: 0 18px 45px rgba(47, 133, 90, 0.40);
    color: white !important;
}

.btn-main:hover::after {
    opacity: 1;
}

.btn-main:active {
    transform: scale(0.96);
}

.btn-outline-hero {
    border: 2px solid rgba(255, 255, 255, 0.35);
    background: rgba(255, 255, 255, 0.08);
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    color: white !important;
    padding: 12px 30px;
    border-radius: 50px;
    font-weight: 600;
    font-size: clamp(0.85rem, 1vw, 1rem);
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    transition: var(--transition);
}

.btn-outline-hero:hover {
    background: rgba(255, 255, 255, 0.18);
    border-color: rgba(255, 255, 255, 0.50);
    transform: translateY(-2px);
    color: white !important;
}

/* Hero Stat Cards - 1 Baris */
.hero-stats-wrapper {
    margin-top: 32px;
}

.hero-stats {
    display: grid;
    grid-template-columns: repeat(8, 1fr);
    gap: 10px;
    width: 100%;
}

.hero-stat-card {
    background: rgba(255, 255, 255, 0.10);
    backdrop-filter: blur(16px);
    -webkit-backdrop-filter: blur(16px);
    border: 1px solid rgba(255, 255, 255, 0.12);
    border-radius: 14px;
    padding: 12px 8px;
    text-align: center;
    transition: var(--transition);
    animation: scaleIn 0.6s ease forwards;
    opacity: 0;
    cursor: pointer;
}

.hero-stat-card:hover {
    background: rgba(255, 255, 255, 0.25);
    transform: translateY(-4px) scale(1.02);
}

.hero-stat-card:nth-child(1) {
    animation-delay: 0.05s;
}
.hero-stat-card:nth-child(2) {
    animation-delay: 0.10s;
}
.hero-stat-card:nth-child(3) {
    animation-delay: 0.15s;
}
.hero-stat-card:nth-child(4) {
    animation-delay: 0.20s;
}
.hero-stat-card:nth-child(5) {
    animation-delay: 0.25s;
}
.hero-stat-card:nth-child(6) {
    animation-delay: 0.30s;
}
.hero-stat-card:nth-child(7) {
    animation-delay: 0.35s;
}
.hero-stat-card:nth-child(8) {
    animation-delay: 0.40s;
}

.hero-stat-label {
    display: block;
    font-size: clamp(0.45rem, 0.6vw, 0.60rem);
    font-weight: 600;
    color: rgba(255, 255, 255, 0.70);
    text-transform: uppercase;
    letter-spacing: 0.3px;
}

.hero-stat-number {
    font-size: clamp(1rem, 2vw, 1.6rem);
    font-weight: 900;
    color: var(--white);
    line-height: 1.2;
    margin: 2px 0;
    text-shadow: 0 2px 10px rgba(0, 0, 0, 0.10);
}

/* Hero Card - Preview Map */
.hero-card-wrapper {
    position: relative;
    z-index: 2;
}

.hero-card {
    position: relative;
    border-radius: var(--radius-md);
    overflow: hidden;
    box-shadow: 0 25px 60px rgba(0, 0, 0, 0.20);
    background: rgba(255, 255, 255, 0.08);
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    border: 1px solid rgba(255, 255, 255, 0.10);
    cursor: pointer;
    transition: var(--transition);
}

.hero-card:hover {
    transform: scale(1.02);
}

#heroMap {
    width: 100%;
    height: clamp(180px, 30vh, 320px);
    z-index: 1;
}

.hero-badge-live {
    position: absolute;
    top: 14px;
    left: 14px;
    z-index: 10;
    background: rgba(0, 0, 0, 0.55);
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    color: #fff;
    font-size: clamp(0.60rem, 0.7vw, 0.75rem);
    font-weight: 700;
    padding: 4px 14px 4px 10px;
    border-radius: 999px;
    display: flex;
    align-items: center;
    gap: 6px;
    border: 1px solid rgba(255, 255, 255, 0.08);
    pointer-events: none;
}

.live-dot {
    width: 7px;
    height: 7px;
    background: #4ade80;
    border-radius: 50%;
    display: inline-block;
    animation: pulse-dot 1.5s ease-in-out infinite;
}

.hero-card-attribution {
    position: absolute;
    bottom: 8px;
    right: 10px;
    z-index: 10;
    color: rgba(255, 255, 255, 0.6);
    font-size: 9px;
    font-weight: 400;
    pointer-events: none;
    background: rgba(0, 0, 0, 0.4);
    padding: 2px 8px;
    border-radius: 4px;
}

.hero-wave {
    position: absolute;
    bottom: -2px;
    left: 0;
    width: 100%;
    line-height: 0;
    z-index: 2;
    pointer-events: none;
}

.hero-wave svg {
    width: 100%;
    height: clamp(40px, 8vw, 80px);
    display: block;
}

/* ===============================
   SECTION TITLE
=============================== */
.section-title {
    font-size: clamp(1.6rem, 3.5vw, 2.5rem);
    font-weight: 800;
    margin-bottom: 12px;
    color: var(--text-dark);
    letter-spacing: -0.02em;
}

.section-title .highlight {
    color: var(--primary);
}

.section-subtitle {
    color: var(--text-muted);
    max-width: 680px;
    margin: 0 auto 45px auto;
    font-size: clamp(0.95rem, 1.1vw, 1.1rem);
    line-height: 1.7;
}

.section-badge {
    display: inline-block;
    padding: 4px 16px;
    border-radius: 999px;
    background: rgba(47, 133, 90, 0.10);
    color: var(--primary);
    font-weight: 600;
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 8px;
}

.bg-soft {
    background: var(--light-bg);
}

/* ===============================
   FEATURE CARDS
=============================== */
.feature-card {
    background: var(--white);
    border-radius: var(--radius-md);
    box-shadow: var(--shadow-sm);
    padding: 32px 24px;
    height: 100%;
    transition: var(--transition);
    border: 1px solid rgba(0, 0, 0, 0.03);
    position: relative;
    overflow: hidden;
}

.feature-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: var(--primary-gradient);
    opacity: 0;
    transition: var(--transition);
}

.feature-card:hover {
    transform: translateY(-8px);
    box-shadow: var(--shadow-md);
}

.feature-card:hover::before {
    opacity: 1;
}

.feature-icon {
    width: 64px;
    height: 64px;
    border-radius: 16px;
    background: var(--primary-gradient);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.6rem;
    margin-bottom: 18px;
    box-shadow: 0 8px 24px rgba(47, 133, 90, 0.20);
}

.feature-card h5 {
    font-weight: 700;
    font-size: 1.1rem;
    margin-bottom: 10px;
}

.feature-card p {
    color: var(--text-muted);
    font-size: 0.95rem;
    line-height: 1.7;
    margin: 0;
}

/* ===============================
   DATA BOX
=============================== */
.data-box {
    background: var(--primary-gradient);
    color: white;
    border-radius: var(--radius-lg);
    padding: 45px 40px;
    position: relative;
    overflow: hidden;
    box-shadow: 0 20px 50px rgba(47, 133, 90, 0.20);
}

.data-box::before {
    content: '';
    position: absolute;
    top: -120px;
    right: -120px;
    width: 300px;
    height: 300px;
    background: rgba(255, 255, 255, 0.05);
    border-radius: 50%;
}

.data-box::after {
    content: '';
    position: absolute;
    bottom: -80px;
    left: -80px;
    width: 200px;
    height: 200px;
    background: rgba(255, 255, 255, 0.04);
    border-radius: 50%;
}

.data-box .comparison-box {
    background: rgba(255, 255, 255, 0.10);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    border-radius: var(--radius-md);
    padding: 28px 24px;
    border: 1px solid rgba(255, 255, 255, 0.10);
    height: 100%;
    position: relative;
    z-index: 1;
}

.data-box .comparison-box h4 {
    font-weight: 700;
    font-size: 1.1rem;
    margin-bottom: 20px;
    color: #fff;
}

.data-box .comparison-box h4 i {
    color: #fff !important;
}

/* ===============================
   MAP
=============================== */
.map-card {
    background: var(--white);
    border-radius: var(--radius-md);
    box-shadow: var(--shadow-sm);
    overflow: hidden;
    border: 1px solid rgba(0, 0, 0, 0.03);
    position: relative;
}

#map {
    height: 400px;
    width: 100%;
    border-radius: 0;
    z-index: 1;
}

#legend-box {
    position: absolute;
    bottom: 20px;
    right: 20px;
    z-index: 999;
    background: rgba(255, 255, 255, 0.92);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    padding: 14px 18px;
    border-radius: 14px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.12);
    min-width: 160px;
    font-size: 0.82rem;
    line-height: 1.6;
    border: 1px solid rgba(255, 255, 255, 0.30);
}

#legend-box h6 {
    font-weight: 700;
    margin-bottom: 8px;
    font-size: 0.85rem;
}

.kotak {
    display: inline-block;
    width: 14px;
    height: 14px;
    margin-right: 8px;
    border-radius: 4px;
    vertical-align: middle;
}

.hijau {
    background: #198754;
}
.ungu {
    background: #6f42c1;
}

.bulat {
    display: inline-block;
    background: #333;
    border-radius: 50%;
    margin-right: 8px;
    vertical-align: middle;
}

.besar {
    width: 12px;
    height: 12px;
}

/* ===============================
   FOOTER
=============================== */
.footer-desa {
    background: #0d2a1a;
    color: #ffffff;
    padding: 50px 0 20px;
}

.footer-desa h5,
.footer-desa h6 {
    color: #fff;
    font-weight: 700;
}

.footer-desa p {
    color: rgba(255, 255, 255, 0.75);
    line-height: 1.8;
    font-size: 0.92rem;
}

.footer-desa a {
    color: rgba(255, 255, 255, 0.75);
    text-decoration: none;
    transition: var(--transition);
}

.footer-desa a:hover {
    color: #68d391;
    padding-left: 4px;
}

.footer-desa hr {
    border-color: rgba(255, 255, 255, 0.08);
    margin: 25px 0;
}

.footer-desa i {
    color: #68d391;
    width: 20px;
}

/* ===============================
   SCROLL ANIMATION
=============================== */
.scroll-animate {
    opacity: 0;
    transform: translate3d(0, 40px, 0) scale(0.97);
    will-change: opacity, transform;
    backface-visibility: hidden;
    transition: all 0.8s cubic-bezier(0.22, 1, 0.36, 1) 0s;
}

.scroll-animate.in-view {
    opacity: 1;
    transform: translate3d(0, 0, 0) scale(1);
}

.fade-up {
    transform: translate3d(0, 40px, 0) scale(0.97);
}
.fade-left {
    transform: translate3d(-40px, 0, 0) scale(0.97);
}
.fade-right {
    transform: translate3d(40px, 0, 0) scale(0.97);
}

.delay-1 {
    transition-delay: 0.08s;
}
.delay-2 {
    transition-delay: 0.18s;
}
.delay-3 {
    transition-delay: 0.30s;
}
.delay-4 {
    transition-delay: 0.42s;
}
.delay-5 {
    transition-delay: 0.55s;
}
.delay-6 {
    transition-delay: 0.68s;
}

/* ===============================
   FILTER
=============================== */
.filter-group {
    position: relative;
}

.filter-icon {
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--primary);
    z-index: 10;
    font-size: 0.9rem;
}

.filter-select {
    height: 48px;
    border-radius: var(--radius-sm);
    border: 1px solid #e2e8f0;
    padding-left: 40px;
    font-weight: 500;
    font-size: 0.9rem;
    transition: var(--transition);
    background: #fafcfa;
}

.filter-select:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 4px rgba(47, 133, 90, 0.10);
}

.btn-reset {
    height: 48px;
    border: none;
    border-radius: var(--radius-sm);
    font-weight: 600;
    color: #fff;
    background: var(--primary-gradient);
    transition: var(--transition);
    width: 100%;
    font-size: 0.9rem;
}

.btn-reset:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(47, 133, 90, 0.25);
    color: #fff;
}

/* ===============================
   CHART CONTAINER
=============================== */
.chart-container {
    position: relative;
    height: 280px;
    width: 100%;
}

.chart-container canvas {
    max-height: 100%;
    max-width: 100%;
}

/* ===============================
   CONTACT
=============================== */
.contact-card {
    background: var(--white);
    border-radius: var(--radius-md);
    box-shadow: var(--shadow-sm);
    padding: 32px 28px;
    height: 100%;
    transition: var(--transition);
    border: 1px solid rgba(0, 0, 0, 0.03);
}

.contact-card:hover {
    box-shadow: var(--shadow-md);
}

.contact-card h4 {
    font-weight: 700;
    font-size: 1.2rem;
}

.contact-card .form-control {
    border-radius: var(--radius-sm);
    padding: 12px 16px;
    border: 1px solid #e2e8f0;
    transition: var(--transition);
    font-size: 0.92rem;
}

.contact-card .form-control:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 4px rgba(47, 133, 90, 0.10);
}

.contact-card .form-label {
    font-weight: 600;
    font-size: 0.85rem;
    margin-bottom: 4px;
}

.contact-card .input-group-text {
    background: #f7faf7;
    border: 1px solid #e2e8f0;
    font-weight: 600;
    font-size: 0.85rem;
}

.contact-card .btn-main {
    width: 100%;
    justify-content: center;
}

/* ===============================
   NAVBAR COLLAPSE FIX
=============================== */
@media (max-width: 991.98px) {
    .navbar-collapse {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.4s cubic-bezier(0.22, 1, 0.36, 1);
        background: rgba(255, 255, 255, 0.98);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border-radius: var(--radius-sm);
        box-shadow: var(--shadow-md);
        padding: 0 16px;
        margin-top: 12px;
    }

    .navbar-collapse.show {
        max-height: 80vh;
        padding: 12px 16px;
        overflow-y: auto;
    }

    .navbar .nav-link {
        color: var(--text-dark) !important;
        padding: 12px 14px;
        border-radius: 10px;
        border-bottom: 1px solid #f0f0f0;
        font-size: 0.95rem;
        display: block;
        transition: var(--transition);
    }

    .navbar .nav-link:last-child {
        border-bottom: none;
    }

    .navbar .nav-link.active {
        color: var(--primary) !important;
        background: rgba(47, 133, 90, 0.05);
    }

    .navbar .nav-link.active::after {
        display: none;
    }

    .navbar .nav-link:hover {
        background: rgba(47, 133, 90, 0.05);
    }

    .navbar-nav {
        gap: 2px;
    }
}

/* ===============================
   RESPONSIVE - SMARTPHONE (≤575px)
=============================== */
@media (max-width: 575.98px) {
    section {
        padding: 40px 0;
    }

    .container {
        padding-left: 12px;
        padding-right: 12px;
    }

    .hero {
        padding: 100px 0 30px;
        min-height: 90dvh;
    }

    /* HERO - Peta di Atas, Text di Bawah */
    .hero .row {
        display: flex;
        flex-direction: column;
    }

    .hero .row .order-1 {
        order: 1 !important;
    }

    .hero .row .order-2 {
        order: 2 !important;
    }

    .hero-card-wrapper {
        margin-top: 0;
        margin-bottom: 16px;
        width: 100%;
    }

    #heroMap {
        height: 180px !important;
        width: 100% !important;
    }

    .hero-card {
        border-radius: 14px;
    }

    .hero-card-attribution {
        font-size: 7px !important;
        bottom: 4px !important;
        right: 6px !important;
        padding: 1px 6px !important;
    }

    /* Hero Content - Text di Bawah */
    .hero-content {
        text-align: center !important;
        padding: 0;
    }

    /* Hilangkan Badge "Desa Karangmulya" di Mobile */
    .hero-badge.d-none.d-lg-inline-flex {
        display: none !important;
    }

    .hero h1 {
        font-size: 1.5rem !important;
        font-weight: 800 !important;
        line-height: 1.2;
        margin-bottom: 10px;
    }

    .hero h1 .highlight {
        font-weight: 900 !important;
    }

    .hero p {
        font-size: 0.88rem !important;
        color: rgba(255, 255, 255, 0.88) !important;
        max-width: 100% !important;
        line-height: 1.7;
        margin-bottom: 16px;
    }

    /* Tombol - Hanya Lihat Peta, Full Width */
    .hero-buttons {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 10px;
        margin-top: 16px;
        width: 100%;
    }

    .hero-buttons .btn-main {
        width: 100%;
        justify-content: center;
        padding: 12px 20px !important;
        font-size: 0.85rem !important;
        border-radius: 50px;
    }

    .hero-buttons .btn-outline-hero {
        display: none !important;
    }

    /* Hero Stats - Grid 4 kolom */
    .hero-stats-wrapper {
        margin-top: 24px;
    }

    .hero-stats {
        grid-template-columns: repeat(4, 1fr) !important;
        gap: 6px !important;
    }

    .hero-stat-card {
        padding: 8px 4px !important;
        border-radius: 10px !important;
        cursor: default;
    }

    .hero-stat-card:hover {
        transform: none !important;
        background: rgba(255, 255, 255, 0.10) !important;
    }

    .hero-stat-number {
        font-size: 0.9rem !important;
        font-weight: 900 !important;
    }

    .hero-stat-label {
        font-size: 0.40rem !important;
        font-weight: 600 !important;
        letter-spacing: 0.2px;
    }

    /* Badge Peta Keterampilan */
    .hero-badge-live {
        font-size: 0.50rem !important;
        padding: 3px 10px 3px 8px !important;
        top: 8px !important;
        left: 8px !important;
    }

    .live-dot {
        width: 5px !important;
        height: 5px !important;
    }

    /* Gelombang */
    .hero-wave svg {
        height: 25px !important;
    }

    /* Sembunyikan Partikel */
    .hero-particles span {
        display: none;
    }

    /* Section Title */
    .section-title {
        font-size: 1.3rem;
    }

    .section-subtitle {
        font-size: 0.85rem;
        margin-bottom: 25px;
    }

    /* Data Box */
    .data-box {
        padding: 20px 14px;
        border-radius: var(--radius-md);
    }

    .data-box .comparison-box {
        padding: 16px 12px;
    }

    /* Map */
    #map {
        height: 250px;
    }

    #legend-box {
        bottom: 10px;
        right: 10px;
        padding: 8px 12px;
        font-size: 0.65rem;
        min-width: 120px;
        z-index: 1000;
    }

    #legend-box h6 {
        font-size: 0.7rem;
        margin-bottom: 4px;
    }

    .kotak {
        width: 10px;
        height: 10px;
        margin-right: 4px;
    }

    .bulat.besar {
        width: 8px;
        height: 8px;
    }

    /* Footer */
    .footer-desa {
        padding: 25px 0 12px;
    }

    .footer-desa p {
        font-size: 0.82rem;
    }

    /* Navbar */
    .navbar {
        padding: 0.5rem 0;
        min-height: 65px;
    }

    .logo-navbar {
        width: 34px;
        height: 34px;
    }

    .brand-title {
        font-size: 0.85rem;
    }

    .brand-subtitle {
        font-size: 0.5rem;
    }

    /* Chart */
    .chart-container {
        height: 200px;
    }

    /* Contact */
    .contact-card {
        padding: 20px 16px;
    }

    .contact-card h4 {
        font-size: 1rem;
    }

    .contact-card .form-control {
        font-size: 0.85rem;
        padding: 10px 14px;
    }

    /* Filter */
    .filter-select {
        height: 42px;
        font-size: 0.85rem;
        padding-left: 36px;
    }

    .filter-icon {
        font-size: 0.8rem;
        left: 12px;
    }

    .btn-reset {
        height: 42px;
        font-size: 0.85rem;
    }

    /* Layer Control */
    .ctrl-panel {
        min-width: 130px !important;
        font-size: 11px !important;
        padding: 8px 12px !important;
    }

    .custom-layer-ctrl .ctrl-toggle {
        width: 34px !important;
        height: 34px !important;
    }

    .leaflet-control-layers-toggle {
        width: 34px !important;
        height: 34px !important;
        background-size: 18px !important;
    }

    /* Stat Card */
    .stat-card {
        padding: 16px 12px;
    }

    .stat-icon {
        width: 44px;
        height: 44px;
        font-size: 1.1rem;
    }

    .stat-number {
        font-size: 1.3rem;
    }

    /* Feature Card */
    .feature-card {
        padding: 20px 16px;
    }

    .feature-icon {
        width: 48px;
        height: 48px;
        font-size: 1.2rem;
    }
}

/* ===============================
   RESPONSIVE - TABLET (576px - 991px)
=============================== */
@media (min-width: 576px) and (max-width: 991.98px) {
    .hero {
        padding: 110px 0 40px;
        min-height: auto;
    }

    /* HERO - Peta di Atas, Text di Bawah di Tablet */
    .hero .row {
        display: flex;
        flex-direction: column;
    }

    .hero .row .order-1 {
        order: 1 !important;
    }
    .hero .row .order-2 {
        order: 2 !important;
    }

    .hero-card-wrapper {
        margin-top: 0;
        margin-bottom: 20px;
        width: 100%;
    }

    #heroMap {
        height: 220px !important;
        width: 100% !important;
    }

    /* Hilangkan Badge di Tablet */
    .hero-badge.d-none.d-lg-inline-flex {
        display: none !important;
    }

    .hero-content {
        text-align: center !important;
    }

    .hero h1 {
        font-size: 2.2rem !important;
    }

    .hero p {
        font-size: 0.95rem !important;
        max-width: 90% !important;
        margin-left: auto !important;
        margin-right: auto !important;
    }

    .hero-buttons {
        justify-content: center !important;
    }

    /* Hilangkan Tombol Pelajari di Tablet */
    .hero-buttons .btn-outline-hero {
        display: none !important;
    }

    .hero-stats {
        grid-template-columns: repeat(4, 1fr) !important;
        gap: 8px !important;
    }

    .hero-stat-card {
        padding: 10px 6px !important;
    }

    .hero-stat-number {
        font-size: 1.1rem !important;
    }

    .hero-stat-label {
        font-size: 0.45rem !important;
    }

    .hero-card-attribution {
        font-size: 8px !important;
        bottom: 6px !important;
        right: 8px !important;
    }

    /* Section */
    .section-title {
        font-size: 1.8rem;
    }

    #map {
        height: 320px;
    }

    .data-box {
        padding: 30px 24px;
    }

    .chart-container {
        height: 230px;
    }

    /* Navbar Collapse */
    .navbar-collapse {
        background: rgba(255, 255, 255, 0.98);
        backdrop-filter: blur(16px);
        border-radius: var(--radius-sm);
        padding: 12px 16px;
        margin-top: 12px;
        box-shadow: var(--shadow-md);
        max-height: 80vh;
        overflow-y: auto;
    }

    .navbar .nav-link {
        color: var(--text-dark) !important;
        padding: 10px 14px;
        border-radius: 10px;
        border-bottom: 1px solid #f0f0f0;
    }

    .navbar .nav-link:last-child {
        border-bottom: none;
    }

    .navbar .nav-link.active {
        color: var(--primary) !important;
        background: rgba(47, 133, 90, 0.05);
    }

    .navbar .nav-link.active::after {
        display: none;
    }

    /* Layer Control */
    .ctrl-panel {
        min-width: 140px !important;
        font-size: 12px !important;
    }
}

/* ===============================
   RESPONSIVE - DESKTOP (≥992px)
=============================== */
@media (min-width: 992px) {
    .hero {
        min-height: 100vh;
        min-height: 100dvh;
        padding: 100px 0 60px;
    }

    .hero .row {
        display: flex;
        flex-direction: row;
    }

    .hero .row .order-lg-1 {
        order: 1 !important;
    }
    .hero .row .order-lg-2 {
        order: 2 !important;
    }

    .hero-card-wrapper {
        margin-top: 0;
        margin-bottom: 0;
    }

    #heroMap {
        height: 320px !important;
    }

    .hero-content {
        text-align: left !important;
        padding-right: 30px;
    }

    .hero-badge.d-none.d-lg-inline-flex {
        display: inline-flex !important;
    }

    .hero h1 {
        font-size: 3.8rem !important;
    }

    .hero p {
        font-size: 1.05rem !important;
        max-width: 580px !important;
        margin-left: 0 !important;
        margin-right: 0 !important;
    }

    .hero-buttons {
        justify-content: flex-start !important;
    }

    .hero-buttons .btn-outline-hero {
        display: inline-flex !important;
    }

    .hero-stats {
        grid-template-columns: repeat(8, 1fr) !important;
        gap: 12px !important;
    }

    .hero-stat-card {
        padding: 12px 10px !important;
    }

    .hero-stat-number {
        font-size: 1.4rem !important;
    }

    .hero-stat-label {
        font-size: 0.55rem !important;
    }

    .hero-card-attribution {
        font-size: 9px !important;
    }
}

/* ===============================
   LARGE DESKTOP (≥1400px)
=============================== */
@media (min-width: 1400px) {
    .hero h1 {
        font-size: 4.5rem !important;
    }

    .hero-stats {
        gap: 16px !important;
    }

    .hero-stat-number {
        font-size: 1.6rem !important;
    }

    #heroMap {
        height: 380px !important;
    }
}

/* ===============================
   ORIENTASI LANDSCAPE
=============================== */
@media (max-height: 500px) and (orientation: landscape) {
    .hero {
        min-height: 100vh;
        padding: 70px 0 20px;
    }

    #heroMap {
        height: 130px !important;
    }

    .hero h1 {
        font-size: 1.3rem !important;
    }

    .hero p {
        font-size: 0.75rem !important;
        max-width: 70% !important;
    }

    .hero-stats {
        grid-template-columns: repeat(4, 1fr) !important;
        gap: 4px !important;
    }

    .hero-stat-number {
        font-size: 0.8rem !important;
    }

    .hero-stat-card {
        padding: 4px 6px !important;
    }

    .hero-stat-label {
        font-size: 0.35rem !important;
    }

    .hero-buttons .btn-main {
        padding: 6px 16px !important;
        font-size: 0.7rem !important;
    }

    .hero-wave svg {
        height: 18px !important;
    }

    #map {
        height: 180px;
    }
}

/* ===============================
   ACCESSIBILITY
=============================== */
@media (prefers-reduced-motion: reduce) {
    .scroll-animate,
    .scroll-animate.in-view {
        transition: none !important;
        transform: none !important;
        opacity: 1 !important;
    }

    .hero h1 .highlight {
        animation: none !important;
        -webkit-text-fill-color: #68d391;
    }

    .live-dot {
        animation: none !important;
    }

    .hero-particles span {
        animation: none !important;
        display: none;
    }

    .hero-stat-card {
        animation: none !important;
        opacity: 1 !important;
    }

    .btn-main,
    .btn-outline-hero {
        transition: none !important;
    }

    .btn-main:hover,
    .btn-outline-hero:hover {
        transform: none !important;
    }
}

/* ===============================
   TOUCH DEVICE
=============================== */
@media (hover: none) {
    .hero-stat-card:hover {
        transform: none !important;
    }
    .btn-main:hover {
        transform: none !important;
    }
    .btn-outline-hero:hover {
        transform: none !important;
    }
    .feature-card:hover {
        transform: none !important;
    }
    .stat-card:hover {
        transform: none !important;
    }
}

/* ===============================
   POPUP MODERN
=============================== */
.leaflet-popup-content-wrapper {
    border-radius: 18px !important;
    padding: 0 !important;
    overflow: hidden;
    box-shadow: 0 12px 30px rgba(0, 0, 0, .15);
}

.leaflet-popup-content {
    margin: 0 !important;
    min-width: 280px;
}

.popup-modern {
    animation: popupFade .35s ease;
}

@keyframes popupFade {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.popup-header {
    padding: 16px;
    color: white;
}

.popup-title {
    font-size: 16px;
    font-weight: 700;
    margin-bottom: 3px;
}

.popup-subtitle {
    font-size: 12px;
    opacity: .9;
}

.popup-body {
    padding: 14px 16px;
}

.popup-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 9px 0;
    border-bottom: 1px solid #eef2f7;
}

.popup-row:last-child {
    border-bottom: none;
}

.popup-label {
    color: #6b7280;
    font-size: 13px;
}

.popup-value {
    font-weight: 700;
    color: #111827;
}

@media(max-width:576px) {
    .leaflet-popup-content {
        min-width: 220px;
    }
}

/* ===============================
   LAYER CONTROL CUSTOM
=============================== */
.custom-layer-ctrl {
    background: transparent;
    position: relative;
    z-index: 1000;
}

.ctrl-toggle {
    width: 44px;
    height: 44px;
    background: #fff;
    border: none;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: var(--transition);
    z-index: 1000;
    position: relative;
}

.ctrl-toggle:hover {
    transform: scale(1.05);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.25);
}

.ctrl-panel {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
    padding: 12px 16px;
    margin-top: 8px;
    min-width: 150px;
    font-size: 13px;
    color: #333;
    position: absolute;
    right: 0;
    top: 100%;
    z-index: 1001;
    animation: slideDown 0.3s ease;
}

.ctrl-section label {
    display: flex;
    align-items: center;
    gap: 6px;
    margin-bottom: 5px;
    cursor: pointer;
    white-space: nowrap;
    padding: 4px 0;
    transition: var(--transition);
}

.ctrl-section label:hover {
    color: var(--primary);
}

.ctrl-section input {
    cursor: pointer;
    margin: 0;
    accent-color: var(--primary);
}

.leaflet-control-layers-toggle {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='%230d6efd' class='bi bi-layers-fill' viewBox='0 0 16 16'%3E%3Cpath d='M7.765 1.559a.5.5 0 0 1 .47 0l6.39 3.39a.5.5 0 0 1 0 .87l-6.39 3.39a.5.5 0 0 1-.47 0L1.375 5.819a.5.5 0 0 1 0-.87l6.39-3.39z'/%3E%3Cpath d='m1.375 9.18 6.39 3.39a.5.5 0 0 0 .47 0l6.39-3.39a.5.5 0 0 0 0-.87l-6.39-3.39a.5.5 0 0 0-.47 0L1.375 8.31a.5.5 0 0 0 0 .87z'/%3E%3Cpath d='m1.375 12.54 6.39 3.39a.5.5 0 0 0 .47 0l6.39-3.39a.5.5 0 0 0 0-.87l-6.39-3.39a.5.5 0 0 0-.47 0L1.375 11.67a.5.5 0 0 0 0 .87z'/%3E%3C/svg%3E") !important;
    background-size: 22px;
    background-position: center;
    width: 44px !important;
    height: 44px !important;
    border-radius: 8px !important;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2) !important;
    border: none !important;
    background-color: #ffffff !important;
}

.leaflet-control-layers {
    border-radius: 12px !important;
    border: none !important;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15) !important;
    padding: 5px !important;
}

.chart-container {
    position: relative;
    height: 300px;
    width: 100%;
}

.chart-container canvas {
    max-height: 100%;
}

    </style>
</head>

<body>

    <!-- ===============================
         NAVBAR
    ================================ -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#beranda">
                <img src="{{ asset('images/logo-indramayu.png') }}" alt="Logo Indramayu" class="logo-navbar">
                <div>
                    <span class="brand-title">SIKARMAP</span>
                    <span class="brand-subtitle">Desa Karangmulya</span>
                </div>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar"
                aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </button>

            <div class="collapse navbar-collapse" id="mainNavbar">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link active" href="#beranda">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="#tentang">Tentang</a></li>
                    <li class="nav-item"><a class="nav-link" href="#fitur">Pemetaan</a></li>
                    <li class="nav-item"><a class="nav-link" href="#data">Statistik</a></li>
                    <li class="nav-item"><a class="nav-link" href="#kontak">Pengajuan</a></li>
                    <li class="nav-item">
                        <a href="{{ route('login') }}" class="nav-link">
                            <i class="fas fa-sign-in-alt me-1"></i> Login
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

  <!-- ===============================
         HERO SECTION - KHUSUS MOBILE SEPERTI GAMBAR
    ================================ -->
    <section class="hero" id="beranda">
        <div class="hero-particles">
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
        </div>

        <div class="container">
            <!-- KONTEN UTAMA - Stack vertikal di mobile -->
            <div class="row align-items-center g-4 g-lg-5">
                <!-- KONTEN ATAS - Peta Preview (Mobile) / Kanan (Desktop) -->
                <div class="col-lg-5 order-1 order-lg-2 scroll-animate fade-right delay-2">
                    <div class="hero-card-wrapper">
                        <div class="hero-card" onclick="document.getElementById('fitur').scrollIntoView({behavior: 'smooth'})">
                            <div id="heroMap" style="width: 100%; height: clamp(180px, 30vh, 320px); z-index: 1;"></div>
                            <!-- Badge Peta Keterampilan -->
                            <div class="hero-badge-live" style="position:absolute; top:14px; left:14px; z-index:10; background:rgba(0,0,0,0.55); backdrop-filter:blur(8px); color:#fff; font-size:clamp(0.60rem,0.7vw,0.75rem); font-weight:700; padding:4px 14px 4px 10px; border-radius:999px; display:flex; align-items:center; gap:6px; border:1px solid rgba(255,255,255,0.08); pointer-events:none;">
                                <span class="live-dot" style="width:7px; height:7px; background:#4ade80; border-radius:50%; display:inline-block; animation:pulse-dot 1.5s ease-in-out infinite;"></span>
                                Peta Keterampilan
                            </div>
                            <!-- Leaflet attribution di dalam card -->
                            <div style="position:absolute; bottom:8px; right:10px; z-index:10; color:rgba(255,255,255,0.6); font-size:9px; font-weight:400; pointer-events:none; background:rgba(0,0,0,0.4); padding:2px 8px; border-radius:4px;">
                                Leaflet | © OpenStreetMap
                            </div>
                        </div>
                    </div>
                </div>

                <!-- KONTEN BAWAH - Text (Mobile) / Kiri (Desktop) -->
                <div class="col-lg-7 order-2 order-lg-1">
                    <div class="hero-content text-center text-lg-start">
                        <!-- Badge "Desa Karangmulya" - HILANG DI MOBILE -->
                        <div class="hero-badge scroll-animate fade-up delay-1 d-none d-lg-inline-flex">
                            <i class="fas fa-map-pin"></i>
                            Desa Karangmulya
                        </div>

                        <h1 class="scroll-animate fade-up delay-1" style="font-size: clamp(1.5rem, 7vw, 4.2rem); font-weight: 800;">
                            Sistem Pemetaan<br>
                            <span class="highlight" style="font-weight: 900;">Keterampilan Warga</span>
                        </h1>

                        <p class="scroll-animate fade-up delay-2" style="font-size: clamp(0.88rem, 1.2vw, 1.15rem); color: rgba(255,255,255,0.88);">
                            Sistem berbasis WebGIS untuk mengelola, menampilkan, dan memetakan
                            data keterampilan warga berdasarkan wilayah RT, RW, dan dusun secara digital.
                        </p>

                        <div class="hero-buttons scroll-animate fade-up delay-3" style="justify-content: center; justify-content-lg: start;">
                            <a href="#fitur" class="btn-main" style="padding: 12px 28px; font-size: clamp(0.85rem, 1vw, 1rem);">
                                <i class="fas fa-map"></i> Lihat Peta
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- STATISTIK - 1 Baris -->
            <div class="hero-stats-wrapper scroll-animate fade-up delay-3">
                <div class="hero-stats">
                    <div class="hero-stat-card" onclick="document.getElementById('data').scrollIntoView({behavior: 'smooth'})">
                        <span class="hero-stat-label">Total Warga</span>
                        <div class="hero-stat-number">{{ $totalWarga ?? 0 }}</div>
                    </div>
                    <div class="hero-stat-card" onclick="document.getElementById('data').scrollIntoView({behavior: 'smooth'})">
                        <span class="hero-stat-label">Warga Keterampilan</span>
                        <div class="hero-stat-number">{{ $totalSkill ?? 0 }}</div>
                    </div>
                    <div class="hero-stat-card" onclick="document.getElementById('data').scrollIntoView({behavior: 'smooth'})">
                        <span class="hero-stat-label">Dusun Terampil</span>
                        <div class="hero-stat-number">{{ $dusunTerampil->nama_dusun ?? '-' }}</div>
                    </div>
                    <div class="hero-stat-card" onclick="document.getElementById('data').scrollIntoView({behavior: 'smooth'})">
                        <span class="hero-stat-label">RW Terampil</span>
                        <div class="hero-stat-number">RW {{ $rwTerampil->nomor_rw ?? '-' }}</div>
                    </div>
                    <div class="hero-stat-card" onclick="document.getElementById('data').scrollIntoView({behavior: 'smooth'})">
                        <span class="hero-stat-label">RT Terampil</span>
                        <div class="hero-stat-number">RT {{ $rtTerampil->nomor_rt ?? '-' }}</div>
                    </div>
                    <div class="hero-stat-card" onclick="document.getElementById('data').scrollIntoView({behavior: 'smooth'})">
                        <span class="hero-stat-label">Kategori Terbanyak</span>
                        <div class="hero-stat-number">{{ $kategoriTerbanyak->nama_kategori ?? '-' }}</div>
                    </div>
                    <div class="hero-stat-card" onclick="document.getElementById('data').scrollIntoView({behavior: 'smooth'})">
                        <span class="hero-stat-label">Gender Terbanyak</span>
                        <div class="hero-stat-number">{{ $genderTerbanyak->jenis_kelamin ?? '-' }}</div>
                    </div>
                    <div class="hero-stat-card" onclick="document.getElementById('data').scrollIntoView({behavior: 'smooth'})">
                        <span class="hero-stat-label">Usia Dominan</span>
                        <div class="hero-stat-number">{{ $usiaTerbanyak ?? '-' }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="hero-wave">
            <svg viewBox="0 0 1440 120" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
                <path fill="#ffffff" fill-opacity="1"
                    d="M0,64L80,64C160,64,320,64,480,58.7C640,53,800,43,960,48C1120,53,1280,75,1360,85.3L1440,96L1440,120L1360,120C1280,120,1120,120,960,120C800,120,640,120,480,120C320,120,160,120,80,120L0,120Z">
                </path>
            </svg>
        </div>
    </section>

    <!-- ===============================
         TENTANG SISTEM
    ================================ -->
    <section id="tentang" class="bg-soft">
        <div class="container">
            <div class="text-center mb-5 scroll-animate fade-up">
                <span class="section-badge">Tentang Kami</span>
                <h2 class="section-title">
                    Mengenal <span class="highlight">SIKARMAP</span>
                </h2>
                <p class="section-subtitle">
                    SIKARMAP merupakan Sistem Pemetaan Keterampilan Warga Desa Karangmulya berbasis WebGIS
                    yang digunakan untuk mengelola, memvisualisasikan, dan memetakan data keterampilan warga
                    berdasarkan wilayah RT, RW, dan dusun ke dalam bentuk peta digital secara interaktif.
                </p>
            </div>

            <div class="row g-4">
                <div class="col-md-4 scroll-animate fade-up">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-map"></i>
                        </div>
                        <h5>Fungsi Sistem</h5>
                        <p>Membantu mengelola dan menampilkan keterampilan warga desa secara digital melalui peta
                            interaktif yang mudah diakses.</p>
                    </div>
                </div>

                <div class="col-md-4 scroll-animate fade-up delay-2">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-bar-chart"></i>
                        </div>
                        <h5>Manfaat Sistem</h5>
                        <p>Membantu pemerintah desa dan masyarakat mengetahui keterampilan warga yang lebih banyak
                            dimiliki di setiap wilayah desa.</p>
                    </div>
                </div>

                <div class="col-md-4 scroll-animate fade-up delay-3">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-people"></i>
                        </div>
                        <h5>Fitur Utama</h5>
                        <p>Menyediakan peta digital, statistik data, dan pemetaan keterampilan warga berdasarkan wilayah
                            desa secara real-time.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===============================
         PEMETAAN
    ================================ -->
    <section id="fitur" class="bg-soft scroll-animate fade-up">
        <div class="container">
            <div class="text-center mb-5 scroll-animate fade-up delay-1">
                <span class="section-badge">Pemetaan</span>
                <h2 class="section-title">
                    Peta <span class="highlight">Keterampilan Warga</span>
                </h2>
                <p class="section-subtitle">
                    Menampilkan sebaran keterampilan warga Desa Karangmulya secara interaktif
                    dalam bentuk peta digital berdasarkan wilayah RT, RW, dan dusun.
                </p>
            </div>

            <!-- Filter -->
            <div class="row g-3 align-items-center mb-4">
                <div class="col-lg-3 col-md-6">
                    <div class="filter-group">
                        <i class="fa-solid fa-map-location-dot filter-icon"></i>
                        <select id="filterDusun" class="form-select filter-select">
                            <option value="">Semua Dusun</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="filter-group">
                        <i class="fa-solid fa-location-dot filter-icon"></i>
                        <select id="filterRt" class="form-select filter-select">
                            <option value="">Semua RT / RW</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="filter-group">
                        <i class="fa-solid fa-tags filter-icon"></i>
                        <select id="filterKategori" class="form-select filter-select">
                            <option value="">Semua Kategori</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <button id="resetFilter" class="btn btn-reset">
                        <i class="fa-solid fa-rotate-left me-2"></i>
                        Reset Filter
                    </button>
                </div>
            </div>

            <!-- Map -->
            <div class="card card-map border-0 shadow-sm">
                <div class="card-body position-relative">
                    <div id="map"></div>
                    <div id="legend-box">
                        <h6><i class="fas fa-layer-group me-1"></i> Keterangan</h6>
                        <p>
                            <span class="kotak hijau"></span> Dusun Kemped
                        </p>
                        <p>
                            <span class="kotak ungu"></span> Dusun Sukamelang
                        </p>
                        <hr>
                        <p><span class="bulat besar"></span> Keterampilan Warga</p>
                        <small class="text-muted">Warna: Kategori | Ukuran: Jumlah</small>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===============================
         STATISTIK & DATA
    ================================ -->
    <section id="data" class="scroll-animate fade-up">
        <div class="container">
            <div class="text-center mb-5 scroll-animate fade-up delay-1">
                <span class="section-badge">Statistik</span>
                <h2 class="section-title">
                    Data & <span class="highlight">Statistik Desa</span>
                </h2>
                <p class="section-subtitle">
                    Berikut data sebaran keterampilan warga Desa Karangmulya berdasarkan data terbaru pada sistem.
                </p>
            </div>

            <!-- Grafik -->
            <div class="row g-4">

                <!-- Grafik Kategori -->
                <div class="col-lg-6 scroll-animate fade-left delay-2">
                    <div class="comparison-box" style="background:rgba(255,255,255,0.10); backdrop-filter:blur(12px); border-radius:20px; padding:24px 20px;">
                        <h4 style="color:#000000;">
                            <i class="fas fa-chart-pie me-2 text-success"></i>
                            Grafik Kategori Keterampilan
                        </h4>
                        <div class="chart-container">
                            <canvas id="kategoriChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Grafik Gender -->
                <div class="col-lg-6 scroll-animate fade-right delay-3">
                    <div class="comparison-box" style="background:rgba(255,255,255,0.10); backdrop-filter:blur(12px); border-radius:20px; padding:24px 20px;">
                        <h4 style="color:#000000;">
                            <i class="fas fa-venus-mars me-2 text-primary"></i>
                            Grafik Gender
                        </h4>
                        <div class="chart-container">
                            <canvas id="genderSkillChart"></canvas>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row g-4 mt-2">

                <!-- Grafik Usia -->
                <div class="col-lg-6">
                    <div class="comparison-box" style="background:rgba(255,255,255,0.10); backdrop-filter:blur(12px); border-radius:20px; padding:24px 20px;">
                        <h4 style="color:#000000;">
                            <i class="fas fa-user-clock me-2 text-warning"></i>
                            Grafik Kelompok Usia
                        </h4>
                        <div class="chart-container">
                            <canvas id="usiaChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Top Skill -->
                <div class="col-lg-6">
                    <div class="comparison-box" style="background:rgba(255,255,255,0.10); backdrop-filter:blur(12px); border-radius:20px; padding:24px 20px;">
                        <h4 style="color:#000000;">
                            <i class="fas fa-award me-2 text-danger"></i>
                            Top 10 Keterampilan
                        </h4>
                        <div class="chart-container">
                            <canvas id="kategoriBarChart"></canvas>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row mt-4">
                <div class="col-12">
                    <div class="comparison-box" style="background:rgba(255,255,255,0.10); backdrop-filter:blur(12px); border-radius:20px; padding:24px 20px;">
                        <h4 style="color:#000000;">
                            <i class="fas fa-map-marked-alt me-2 text-success"></i>
                            Grafik Sebaran Wilayah
                        </h4>
                        <div class="chart-container">
                            <canvas id="grafikKategoriDusun"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Visualisasi Data -->
            <div class="data-box scroll-animate fade-up delay-2">
                <div class="row g-4">

                    <!-- Grafik Per Dusun - Ganti warna hijau -->
                    <div class="col-lg-6 scroll-animate fade-left delay-2">
                        <div class="comparison-box">
                            <h4><i class="fas fa-map me-2 text-success"></i> Grafik Per Dusun</h4>
                            <div class="chart-container">
                                <canvas id="dusunChart"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- Grafik Per RT/RW -->
                    <div class="col-lg-6 scroll-animate fade-right delay-3">
                        <div class="comparison-box">
                            <h4><i class="fas fa-layer-group me-2 text-primary"></i> Grafik Per RT/RW</h4>
                            <div class="chart-container">
                                <canvas id="rtRwChart"></canvas>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <!-- ===============================
         PENGAJUAN KETERAMPILAN - KEMBALI KE TAMPILAN SEBELUMNYA
    ================================ -->
    <section id="kontak" class="bg-soft scroll-animate fade-up">
        <div class="container">
            <div class="text-center mb-5 scroll-animate fade-up delay-1">
                <span class="section-badge">Pengajuan</span>
                <h2 class="section-title">
                    Ajukan <span class="highlight">Keterampilan</span>
                </h2>
                <p class="section-subtitle">
                    Masyarakat Desa Karangmulya yang memiliki keterampilan, usaha, atau potensi yang belum terdata
                    dapat mengajukan informasi melalui formulir berikut untuk mendukung pendataan potensi SDM desa.
                </p>
            </div>

            <div class="row g-4">
                <!-- Cari Data -->
                <div class="col-lg-5 scroll-animate fade-left delay-2">
                    <div class="contact-card">
                        <div class="mb-4">
                            <h4><i class="fas fa-search text-primary me-2"></i> Cari Data Warga</h4>
                            <p class="text-muted small mb-0">
                                Masukkan NIK untuk melihat apakah data keterampilan sudah terdaftar dalam sistem.
                            </p>
                        </div>

                        <form action="{{ route('landing') }}#kontak" method="GET" id="formCariNik">
                            <div class="mb-3">
                                <label class="form-label">Nomor Induk Kependudukan (NIK)</label>
                                <input type="text" name="nik" maxlength="16" class="form-control"
                                    placeholder="Masukkan 16 digit NIK" required>
                            </div>
                            <button type="submit" class="btn btn-main">
                                <i class="bi bi-search me-2"></i>
                                Cari Data
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Form Pengajuan -->
                <div class="col-lg-7 scroll-animate fade-right delay-3">
                    <div class="contact-card">
                        <h4 class="fw-bold mb-4"><i class="fas fa-pen-fancy text-primary me-2"></i> Form Pengajuan
                        </h4>

                        <form action="{{ route('pesan.store') }}" method="POST">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Nama Lengkap</label>
                                    <input type="text" name="nama" class="form-control"
                                        placeholder="Masukkan nama lengkap" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">NIK</label>
                                    <input type="text" name="nik" class="form-control" maxlength="16"
                                        placeholder="Masukkan 16 digit NIK" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Nomor HP</label>
                                    <input type="text" name="nomor_hp" class="form-control"
                                        placeholder="081234567890" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Dusun</label>
                                    <input type="text" name="dusun" class="form-control"
                                        placeholder="Nama Dusun" required>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label">Wilayah</label>
                                    <div class="row g-2">
                                        <div class="col-6">
                                            <div class="input-group">
                                                <span class="input-group-text">RW</span>
                                                <input type="text" name="rw" class="form-control"
                                                    placeholder="01">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="input-group">
                                                <span class="input-group-text">RT</span>
                                                <input type="text" name="rt" class="form-control"
                                                    placeholder="01">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Kategori Keterampilan</label>
                                    <select name="kategori_keterampilan_id" id="kategoriSelect" class="form-select"
                                        required>
                                        <option value="">-- Pilih Kategori --</option>
                                        @foreach (isset($kategoriKeterampilans) ? $kategoriKeterampilans : [] as $kategori)
                                            <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}
                                            </option>
                                        @endforeach
                                        <option value="lainnya">Lainnya</option>
                                    </select>
                                </div>
                                <div class="col-md-6 d-none" id="kategoriLainnyaBox">
                                    <label class="form-label">Nama Kategori Baru</label>
                                    <input type="text" name="kategori_lainnya" id="kategoriLainnya"
                                        class="form-control" placeholder="Masukkan kategori baru">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Keterampilan</label>
                                    <input type="text" name="keterampilan" class="form-control"
                                        placeholder="Contoh: Menjahit, Bertani, Servis" required>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Deskripsi</label>
                                    <textarea name="pesan" class="form-control" rows="4"
                                        placeholder="Jelaskan keterampilan, usaha, atau potensi yang ingin diajukan." required></textarea>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-main">
                                        <i class="bi bi-send-fill me-2"></i>
                                        Ajukan Data
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===============================
         FOOTER
    ================================ -->
    <footer class="footer-desa scroll-animate fade-up">
        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-5">
                    <h5 class="fw-bold mb-3">
                        <i class="fas fa-map-pin me-2"></i>
                        SIKARMAP
                    </h5>
                    <p>
                        Sistem informasi untuk mendukung pendataan dan pemetaan
                        keterampilan masyarakat Desa Karangmulya guna menunjang
                        pembangunan desa berbasis potensi warga.
                    </p>
                </div>
                <div class="col-lg-4">
                    <h6 class="fw-bold mb-3"><i class="fas fa-address-book me-2"></i>Kontak Desa</h6>
                    <p><i class="bi bi-geo-alt-fill me-2"></i>Desa Karangmulya, Kec. Kandanghaur, Kab. Indramayu</p>
                    <p><i class="bi bi-telephone-fill me-2"></i>(021) 1234-5678</p>
                    <p><i class="bi bi-envelope-fill me-2"></i>info@skillmapdesa.id</p>
                </div>
                <div class="col-lg-3">
                    <h6 class="fw-bold mb-3"><i class="fas fa-link me-2"></i>Menu Cepat</h6>
                    <p><a href="#beranda">Beranda</a></p>
                    <p><a href="#tentang">Tentang</a></p>
                    <p><a href="#data">Statistik</a></p>
                    <p><a href="#kontak">Pengajuan</a></p>
                </div>
            </div>
            <hr>
            <div class="text-center">
                <small>© 2026 Pemerintah Desa Karangmulya | Sistem Pemetaan Keterampilan Warga</small>
            </div>
        </div>
    </footer>

    <!-- ===============================
         SCRIPTS
    ================================ -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>

    <!-- ===============================
         COUNTER STATISTIK
    ================================ -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const counters = document.querySelectorAll('.stat-number[data-target]');

            counters.forEach(counter => {
                const target = parseInt(counter.getAttribute('data-target')) || 0;
                const increment = Math.ceil(target / 80);

                const updateCounter = () => {
                    const current = parseInt(counter.innerText) || 0;
                    if (current < target) {
                        counter.innerText = Math.min(current + increment, target);
                        setTimeout(updateCounter, 20);
                    } else {
                        counter.innerText = target;
                    }
                };

                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            updateCounter();
                            observer.unobserve(entry.target);
                        }
                    });
                }, {
                    threshold: 0.2
                });

                observer.observe(counter);
            });
        });
    </script>

    <!-- ===============================
         SCROLL ANIMATION
    ================================ -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const animatedElements = document.querySelectorAll('.scroll-animate');

            if ('IntersectionObserver' in window) {
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('in-view');
                        }
                    });
                }, {
                    threshold: 0.10,
                    rootMargin: '0px 0px -30px 0px'
                });

                animatedElements.forEach(el => observer.observe(el));
            } else {
                animatedElements.forEach(el => el.classList.add('in-view'));
            }
        });
    </script>

    <!-- ===============================
         NAVBAR SCROLL & ACTIVE
    ================================ -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const navbar = document.querySelector('.navbar');

            window.addEventListener('scroll', function() {
                if (window.scrollY > 50) {
                    navbar.classList.add('scrolled');
                } else {
                    navbar.classList.remove('scrolled');
                }
            });

            const navLinks = document.querySelectorAll('.navbar .nav-link[href^="#"]');
            const sections = Array.from(navLinks)
                .map(link => document.querySelector(link.getAttribute('href')))
                .filter(section => section !== null);

            function setActiveLink(id) {
                navLinks.forEach(link => link.classList.remove('active'));
                const active = document.querySelector(`.navbar .nav-link[href="${id}"]`);
                if (active) active.classList.add('active');
            }

            navLinks.forEach(link => {
                link.addEventListener('click', function() {
                    setActiveLink(this.getAttribute('href'));
                });
            });

            if ('IntersectionObserver' in window) {
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            setActiveLink(`#${entry.target.id}`);
                        }
                    });
                }, {
                    threshold: 0.05,
                    rootMargin: '-80px 0px -40% 0px'
                });

                sections.forEach(section => observer.observe(section));
            }

            if (window.scrollY < 100) setActiveLink('#beranda');
        });
    </script>

    <!-- ===============================
         NAVBAR COLLAPSE - TUTUP SAAT KLIK LINK
    ================================ -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const navbarCollapse = document.querySelector('.navbar-collapse');
            const navLinks = document.querySelectorAll('.navbar .nav-link');

            navLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    const bsCollapse = bootstrap.Collapse.getInstance(navbarCollapse);
                    if (bsCollapse) {
                        bsCollapse.hide();
                    }
                });
            });
        });
    </script>

    <!-- ===============================
         FORM KATEGORI LAINNYA
    ================================ -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const kategoriSelect = document.getElementById('kategoriSelect');
            const kategoriLainnyaBox = document.getElementById('kategoriLainnyaBox');
            const kategoriLainnya = document.getElementById('kategoriLainnya');

            if (kategoriSelect) {
                kategoriSelect.addEventListener('change', function() {
                    if (this.value === 'lainnya') {
                        kategoriLainnyaBox.classList.remove('d-none');
                        kategoriLainnya.required = true;
                    } else {
                        kategoriLainnyaBox.classList.add('d-none');
                        kategoriLainnya.required = false;
                        kategoriLainnya.value = '';
                    }
                });
            }
        });
    </script>

    <!-- ===============================
         ALERT PENGAJUAN BERHASIL
    ================================ -->
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil Dikirim',
                text: '{{ session('success') }}',
                confirmButtonColor: '#2f855a',
                timer: 3000,
                timerProgressBar: true
            });

            history.replaceState(null, null, '#kontak');
            setTimeout(() => {
                document.getElementById('kontak')?.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }, 100);
        </script>
    @endif

    <!-- ===============================
         ALERT HASIL PENCARIAN NIK
    ================================ -->
    @if (request('nik'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                setTimeout(() => {
                    document.getElementById('kontak')?.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }, 100);

                @if ($hasil ?? false)
                    @if ($jenis == 'warga')
                        Swal.fire({
                            icon: 'success',
                            title: 'Data Ditemukan',
                            confirmButtonColor: '#2f855a',
                            html: `
                                <div style="text-align:left;font-size:14px;line-height:1.8">
                                    <b>Nama:</b> {{ $hasil->nama ?? '-' }}<br>
                                    <b>NIK:</b> {{ $hasil->nik ?? '-' }}<br>
                                    <b>Wilayah:</b> Dusun {{ $hasil->rt->rw->dusun->nama_dusun ?? '-' }},
                                    RW {{ $hasil->rt->rw->nomor_rw ?? '-' }},
                                    RT {{ $hasil->rt->nomor_rt ?? '-' }}<br>
                                    <b>Kategori:</b> {{ $hasil->keterampilans->pluck('kategori.nama_kategori')->filter()->unique()->implode(', ') ?: '-' }}<br>
                                    <b>Keterampilan:</b> {{ $hasil->keterampilans->pluck('nama_keterampilan')->implode(', ') ?: '-' }}<br>
                                    <b>Status:</b> <span style="color:#198754;font-weight:600">Terdaftar</span>
                                </div>
                            `
                        });
                    @else
                        Swal.fire({
                            icon: '{{ $hasil->status == 'Disetujui' ? 'success' : ($hasil->status == 'Ditolak' ? 'error' : 'info') }}',
                            title: 'Data Pengajuan Ditemukan',
                            confirmButtonColor: '#2f855a',
                            html: `
                                <div style="text-align:left;font-size:14px;line-height:1.8">
                                    <b>Nama:</b> {{ $hasil->nama ?? '-' }}<br>
                                    <b>NIK:</b> {{ $hasil->nik ?? '-' }}<br>
                                    <b>Kategori:</b> {{ $hasil->kategori->nama_kategori ?? '-' }}<br>
                                    <b>Keterampilan:</b> {{ $hasil->keterampilan ?? '-' }}<br>
                                    <b>Wilayah:</b> Dusun {{ $hasil->dusun ?? '-' }}, RW {{ $hasil->rw ?? '-' }}, RT {{ $hasil->rt ?? '-' }}<br>
                                    <b>Status:</b> <strong>{{ $hasil->status ?? '-' }}</strong>
                                    @if (($hasil->status ?? '') == 'Ditolak')
                                        <br><br><b>Alasan Penolakan:</b><br>{{ $hasil->alasan_penolakan ?? '-' }}
                                    @endif
                                </div>
                            `
                        });
                    @endif
                @else
                    Swal.fire({
                        icon: 'warning',
                        title: 'Data Tidak Ditemukan',
                        text: 'NIK belum ditemukan pada data warga maupun data pengajuan.',
                        confirmButtonColor: '#f59e0b'
                    });
                @endif
            });
        </script>
    @endif

    <!-- ===============================
         LEAFLET MAP
    ================================ -->
    <script>
        const streetLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap'
        });
        const streetLayerHero = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap'
        });

        const satelliteLayer = L.tileLayer(
            'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
                attribution: 'Tiles &copy; Esri'
            });

        const terrainLayer = L.tileLayer('https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png', {
            attribution: 'Map data: &copy; OpenStreetMap | Style: &copy; OpenTopoMap'
        });

        // INISIALISASI MAP
        const map = L.map('map', {
            center: [-6.39963, 108.11848],
            zoom: 14,
            layers: [streetLayer]
        });

        const heroMap = L.map('heroMap', {
            center: [-6.39963, 108.11848],
            zoom: 14,
            layers: [streetLayerHero],
            zoomControl: false,
            dragging: false,
            touchZoom: false,
            scrollWheelZoom: false,
            doubleClickZoom: false,
            boxZoom: false,
            keyboard: false
        });

        [map, heroMap].forEach(m => {
            m.createPane('dusunPane');
            m.createPane('rwPane');
            m.createPane('rtPane');

            m.getPane('dusunPane').style.zIndex = 300;
            m.getPane('rwPane').style.zIndex = 700;
            m.getPane('rtPane').style.zIndex = 750;
        });

        map.scrollWheelZoom.disable();
        map.dragging.disable();

        map.once('click', function() {
            map.scrollWheelZoom.enable();
            map.dragging.enable();
        });

        heroMap.on('click', function() {
            document.getElementById('fitur').scrollIntoView({
                behavior: 'smooth'
            });
        });

        // LAYER GROUPS
        const polygonLayer = L.featureGroup().addTo(map);
        const dusunLayer = L.featureGroup().addTo(map);
        const skillLayer = L.featureGroup().addTo(map);

        const heroPolygonLayer = L.featureGroup().addTo(heroMap);
        const heroDusunLayer = L.featureGroup().addTo(heroMap);
        const heroSkillLayer = L.featureGroup().addTo(heroMap);

        function getDusunStyle(feature) {
            let nama = (
                feature.properties.dusunbaru ||
                feature.properties.nama_dusun ||
                ''
            ).toLowerCase();
            return {
                color: nama.includes('kemped') ? '#198754' : '#6f42c1',
                fillColor: nama.includes('kemped') ? '#198754' : '#6f42c1',
                weight: 2,
                fillOpacity: 0.10
            };
        }

        // LOAD GEOJSON BATAS DESA
        fetch("{{ asset('geojson/karangmulya.geojson') }}")
            .then(res => res.json())
            .then(data => {
                const geojson = L.geoJSON(data, {
                    pane: 'dusunPane',
                    style: getDusunStyle
                }).addTo(dusunLayer);

                const geojsonHero = L.geoJSON(data, {
                    pane: 'dusunPane',
                    style: getDusunStyle,
                    interactive: false
                }).addTo(heroDusunLayer);

                polygonLayer.bringToBack();
                heroPolygonLayer.bringToBack();

                try {
                    map.fitBounds(geojson.getBounds());
                    const bounds = geojsonHero.getBounds();
                    heroMap.setView(bounds.getCenter(), 14);
                } catch (e) {}
            });

        // FUNGSI WARNA KATEGORI
        function warnaKategori(kategori) {
            if (!kategori) return '#6c757d';
            let hash = 0;
            for (let i = 0; i < kategori.length; i++) {
                hash = kategori.charCodeAt(i) + ((hash << 5) - hash);
            }
            const warna = (hash & 0x00FFFFFF).toString(16).toUpperCase();
            return "#" + "000000".substring(0, 6 - warna.length) + warna;
        }

        let filterDusun = '';
        let filterRt = '';
        let filterKategori = '';

        function isiFilter(data) {
            const dusunSelect = document.getElementById('filterDusun');
            const rtSelect = document.getElementById('filterRt');
            const kategoriSelect = document.getElementById('filterKategori');

            if (!dusunSelect || !rtSelect || !kategoriSelect) return;

            dusunSelect.innerHTML = '<option value="">Semua Dusun</option>';
            rtSelect.innerHTML = '<option value="">Semua RT / RW</option>';

            let rtSet = new Set();
            const daftarRt = filterDusun ? data.rt.filter(rt => rt.nama_dusun === filterDusun) : data.rt;

            daftarRt.forEach(item => {
                const value = item.nama_rt + "|" + item.nama_rw;
                if (!rtSet.has(value)) {
                    rtSet.add(value);
                    rtSelect.innerHTML += `
                        <option value="${value}">RT ${item.nama_rt} / RW ${item.nama_rw}</option>
                    `;
                }
            });
            rtSelect.value = filterRt;

            kategoriSelect.innerHTML = '<option value="">Semua Kategori</option>';
            [...new Set(data.kategori.map(item => item.dusun))].forEach(dusun => {
                dusunSelect.innerHTML += `<option value="${dusun}">${dusun}</option>`;
            });
            dusunSelect.value = filterDusun;

            [...new Set(data.kategori.map(item => item.kategori))].forEach(kategori => {
                kategoriSelect.innerHTML += `<option value="${kategori}">${kategori}</option>`;
            });
            kategoriSelect.value = filterKategori;
        }

        function getDusunRealStyle(feature) {
            let nama = (feature.properties.dusunbaru || feature.properties.nama_dusun || '').toLowerCase();
            return {
                color: nama.includes('kemped') ? '#198754' : '#6f42c1',
                fillColor: nama.includes('kemped') ? '#198754' : '#6f42c1',
                weight: 3,
                fillOpacity: 0.15
            };
        }

        // LOAD DATA
        function loadData() {
            dusunLayer.clearLayers();
            skillLayer.clearLayers();
            heroDusunLayer.clearLayers();
            heroSkillLayer.clearLayers();
            window.rtPosisi = {};

            fetch("{{ url('/api/pemetaan') }}")
                .then(res => res.json())
                .then(data => {
                    window.dataDusun = data.dusun;
                    isiFilter(data);

                    fetch("{{ asset('geojson/dusunreal.geojson') }}")
                        .then(res => res.json())
                        .then(geoData => {
                            // Untuk Peta Utama
                            L.geoJSON(geoData, {
                                interactive: true,
                                style: getDusunRealStyle,
                                onEachFeature: function(feature, layer) {
                                    const namaDusun = (feature.properties.dusunbaru || feature
                                        .properties.nama_dusun || '').toLowerCase();
                                    const dusunData = window.dataDusun?.find(d =>
                                        d.nama_dusun.toLowerCase() === namaDusun
                                    );
                                    if (!dusunData) return;

                                    layer.bindPopup(`
                                        <div class="popup-modern">
                                            <div class="popup-header" style="background:${warnaKategori(dusunData.keterampilan_dominan)};color:white;border-radius:12px 12px 0 0;padding:16px;">
                                                <div class="popup-title">${dusunData.nama_dusun}</div>
                                                <div class="popup-subtitle">Wilayah Dusun</div>
                                            </div>
                                            <div class="popup-body">
                                                <div class="popup-row">
                                                    <span class="popup-label">Jumlah RW</span>
                                                    <span class="popup-value">${dusunData.jumlah_rw || 0}</span>
                                                </div>
                                                <div class="popup-row">
                                                    <span class="popup-label">Jumlah RT</span>
                                                    <span class="popup-value">${dusunData.jumlah_rt || 0}</span>
                                                </div>
                                                <div class="popup-row">
                                                    <span class="popup-label">Total Warga</span>
                                                    <span class="popup-value">${dusunData.jumlah_warga || 0}</span>
                                                </div>
                                                <div class="popup-row">
                                                    <span class="popup-label">Kategori Dominan</span>
                                                    <span class="popup-value" style="background:${warnaKategori(dusunData.keterampilan_dominan)};color:#fff;padding:2px 12px;border-radius:999px;font-size:12px;">${dusunData.keterampilan_dominan || '-'}</span>
                                                </div>
                                            </div>
                                        </div>
                                    `);

                                    layer.on({
                                        mouseover: function(e) {
                                            e.target.setStyle({ weight: 5, fillOpacity: 0.25 });
                                        },
                                        mouseout: function(e) {
                                            e.target.setStyle({ weight: 3, fillOpacity: 0.15 });
                                        }
                                    });
                                }
                            }).addTo(dusunLayer);
                            dusunLayer.bringToBack();

                            // Untuk Hero Map
                            L.geoJSON(geoData, {
                                interactive: false,
                                style: getDusunRealStyle
                            }).addTo(heroDusunLayer);
                            heroDusunLayer.bringToBack();
                        });

                    data.kategori.forEach(item => {
                        if (filterDusun && item.dusun !== filterDusun) return;
                        if (filterRt) {
                            const value = item.rt + "|" + item.rw;
                            if (value !== filterRt) return;
                        }
                        if (filterKategori && item.kategori !== filterKategori) return;
                        if (!item.latitude || !item.longitude) return;

                        const ukuran = data.max_jumlah > 0 ? 5 + ((item.jumlah_warga / data.max_jumlah) *
                            12) : 5;

                        if (!window.rtPosisi) window.rtPosisi = {};
                        const key = item.rt + '-' + item.rw;
                        if (!window.rtPosisi[key]) window.rtPosisi[key] = 0;
                        const index = window.rtPosisi[key]++;

                        let lat = parseFloat(item.latitude);
                        let lng = parseFloat(item.longitude);

                        const posisi = [
                            [0, 0],
                            [0.0018, 0],
                            [-0.0018, 0],
                            [0, 0.0018],
                            [0, -0.0018],
                            [0.0015, 0.0015],
                            [-0.0015, -0.0015],
                            [0.0015, -0.0015],
                            [-0.0015, 0.0015],
                            [0.0030, 0],
                            [-0.0030, 0],
                            [0, 0.0030],
                            [0, -0.0030],
                            [0.0025, 0.0025],
                            [-0.0025, -0.0025],
                            [0.0025, -0.0025],
                            [-0.0025, 0.0025],
                            [0.0038, 0.0015],
                            [-0.0038, -0.0015],
                            [0.0015, -0.0038]
                        ];

                        const p = posisi[index % posisi.length];
                        lat += p[0];
                        lng += p[1];

                        // Peta Utama Marker
                        L.circleMarker([lat, lng], {
                            radius: ukuran,
                            color: '#ffffff',
                            fillColor: warnaKategori(item.kategori),
                            fillOpacity: 0.9,
                            weight: 2
                        }).bindPopup(`
                            <div class="popup-modern">
                                <div class="popup-header" style="background:${warnaKategori(item.kategori)};color:white;border-radius:12px 12px 0 0;padding:16px;">
                                    <div class="popup-title">${item.kategori}</div>
                                    <div class="popup-subtitle">Kategori Keterampilan</div>
                                </div>
                                <div class="popup-body">
                                    <div class="popup-row">
                                        <span class="popup-label">Jumlah Warga</span>
                                        <span class="popup-value">${item.jumlah_warga} Orang</span>
                                    </div>
                                    <div class="popup-row">
                                        <span class="popup-label">RT</span>
                                        <span class="popup-value">${item.rt}</span>
                                    </div>
                                    <div class="popup-row">
                                        <span class="popup-label">RW</span>
                                        <span class="popup-value">${item.rw}</span>
                                    </div>
                                    <div class="popup-row">
                                        <span class="popup-label">Dusun</span>
                                        <span class="popup-value">${item.dusun}</span>
                                    </div>
                                </div>
                            </div>
                        `, { maxWidth: 320, className: 'custom-popup' }).addTo(skillLayer);

                        // Hero Map Marker
                        L.circleMarker([lat, lng], {
                            radius: ukuran,
                            color: '#ffffff',
                            fillColor: warnaKategori(item.kategori),
                            fillOpacity: 0.9,
                            weight: 2,
                            interactive: false
                        }).addTo(heroSkillLayer);
                    });
                });
        }

        loadData();

        // LAYER CONTROL CUSTOM
        const CustomControl = L.Control.extend({
            options: { position: 'topright' },
            onAdd: function() {
                const div = L.DomUtil.create('div', 'custom-layer-ctrl');
                div.innerHTML = `
                    <button class="ctrl-toggle" onclick="toggleLayerPanel(this)">
                        <svg width="20" height="20" fill="#0d6efd" viewBox="0 0 16 16">
                            <path d="M7.765 1.559a.5.5 0 0 1 .47 0l6.39 3.39a.5.5 0 0 1 0 .87l-6.39 3.39a.5.5 0 0 1-.47 0L1.375 5.819a.5.5 0 0 1 0-.87l6.39-3.39z"/>
                            <path d="m1.375 9.18 6.39 3.39a.5.5 0 0 0 .47 0l6.39-3.39a.5.5 0 0 0 0-.87l-6.39-3.39a.5.5 0 0 0-.47 0L1.375 8.31a.5.5 0 0 0 0 .87z"/>
                            <path d="m1.375 12.54 6.39 3.39a.5.5 0 0 0 .47 0l6.39-3.39a.5.5 0 0 0 0-.87l-6.39-3.39a.5.5 0 0 0-.47 0L1.375 11.67a.5.5 0 0 0 0 .87z"/>
                        </svg>
                    </button>
                    <div class="ctrl-panel" style="display:none;">
                        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
                            <small style="font-weight:600; color:#555;">Layer</small>
                            <button onclick="closeLayerPanel(this)" style="background:none; border:none; cursor:pointer; font-size:16px; color:#999; line-height:1; padding:0;">&times;</button>
                        </div>
                        <div class="ctrl-section">
                            <label><input type="radio" name="basemap" value="street" checked onchange="switchBase(this)"> Peta Jalan</label>
                            <label><input type="radio" name="basemap" value="satellite" onchange="switchBase(this)"> Satelit</label>
                            <label><input type="radio" name="basemap" value="terrain" onchange="switchBase(this)"> Terrain</label>
                        </div>
                        <hr style="margin:6px 0;">
                        <div class="ctrl-section">
                            <label><input type="checkbox" checked onchange="toggleLayer('polygon', this)"> Batas Wilayah</label>
                            <label><input type="checkbox" checked onchange="toggleLayer('dusun', this)"> Dusun</label>
                        </div>
                    </div>
                `;
                L.DomEvent.disableClickPropagation(div);
                return div;
            }
        });
        new CustomControl().addTo(map);

        function toggleLayerPanel(btn) {
            const panel = btn.nextElementSibling;
            panel.style.display = 'block';
            btn.style.display = 'none';
        }

        function closeLayerPanel(closeBtn) {
            const panel = closeBtn.closest('.ctrl-panel');
            const toggle = panel.previousElementSibling;
            panel.style.display = 'none';
            toggle.style.display = 'flex';
        }

        function switchBase(radio) {
            map.removeLayer(streetLayer);
            map.removeLayer(satelliteLayer);
            map.removeLayer(terrainLayer);
            if (radio.value === 'street') map.addLayer(streetLayer);
            if (radio.value === 'satellite') map.addLayer(satelliteLayer);
            if (radio.value === 'terrain') map.addLayer(terrainLayer);
        }

        function toggleLayer(name, cb) {
            const layers = { polygon: polygonLayer, dusun: dusunLayer, skill: skillLayer };
            if (cb.checked) map.addLayer(layers[name]);
            else map.removeLayer(layers[name]);
        }

        document.addEventListener('change', function(e) {
            if (e.target.id === 'filterDusun') {
                filterDusun = e.target.value;
                filterRt = '';
                document.getElementById('filterRt').value = '';
                loadData();
            }
            if (e.target.id === 'filterRt') {
                filterRt = e.target.value;
                loadData();
            }
            if (e.target.id === 'filterKategori') {
                filterKategori = e.target.value;
                loadData();
            }
        });

        document.getElementById('resetFilter')?.addEventListener('click', function() {
            filterDusun = '';
            filterRt = '';
            filterKategori = '';
            document.getElementById('filterDusun').value = '';
            document.getElementById('filterRt').value = '';
            document.getElementById('filterKategori').value = '';
            loadData();
        });

        window.addEventListener('resize', () => {
            map.invalidateSize();
            heroMap.invalidateSize();
        });
    </script>

    <!-- ===============================
         CHART.JS - FONT PUTIH, GRAFIK DUSUN WARNA BEDA
    ================================ -->
    <script>
        // Konfigurasi Chart Global - FONT HITAM UNTUK SEMUA GRAFIK
Chart.defaults.font.family = "'Inter', sans-serif";
Chart.defaults.color = '#1a2a2a'; // Warna hitam untuk semua teks chart

// KATEGORI CHART (Doughnut)
const kategoriLabels = {!! json_encode($kategoriChart->pluck('nama_kategori')) !!};
const kategoriValues = {!! json_encode($kategoriChart->pluck('total')) !!};

new Chart(document.getElementById('kategoriChart'), {
    type: 'doughnut',
    data: {
        labels: kategoriLabels,
        datasets: [{
            data: kategoriValues,
            backgroundColor: [
                '#4361ee', '#3a0ca3', '#7209b7', '#f72585',
                '#4cc9f0', '#4f46e5', '#3b0ca3', '#7b2cbf',
                '#0ea5e9', '#14b8a6', '#22c55e', '#f59e0b'
            ],
            borderWidth: 3,
            borderColor: 'rgba(255,255,255,0.3)',
        }]
    },
    plugins: [ChartDataLabels],
    options: {
        responsive: true,
        maintainAspectRatio: false,
        cutout: '65%',
        animation: {
            duration: 1500,
            easing: 'easeOutQuart'
        },
        plugins: {
            datalabels: {
                color: '#1a2a2a', // HITAM
                font: {
                    weight: '700',
                    size: 9
                },
                formatter: (value, context) => {
                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                    return ((value / total) * 100).toFixed(1) + '%';
                }
            },
            legend: {
                position: 'bottom',
                labels: {
                    usePointStyle: true,
                    padding: 15,
                    boxWidth: 10,
                    font: {
                        size: 11,
                        color: '#1a2a2a' // HITAM
                    }
                }
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                        const persen = (context.raw / total * 100).toFixed(1);
                        return context.label + ' : ' + persen + '%';
                    }
                }
            }
        }
    }
});

// GENDER CHART
new Chart(document.getElementById('genderSkillChart'), {
    type: 'pie',
    data: {
        labels: {!! json_encode($genderSkillChart->pluck('jenis_kelamin')) !!},
        datasets: [{
            data: {!! json_encode($genderSkillChart->pluck('total')) !!},
            backgroundColor: ['#3b82f6', '#ec4899'],
            borderWidth: 3,
            borderColor: 'rgba(255,255,255,0.3)'
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    usePointStyle: true,
                    padding: 15,
                    boxWidth: 10,
                    font: {
                        size: 11,
                        color: '#1a2a2a' // HITAM
                    }
                }
            }
        }
    }
});

// TOP SKILL BAR CHART
new Chart(document.getElementById('kategoriBarChart'), {
    type: 'bar',
    data: {
        labels: {!! json_encode($kategoriChart->pluck('nama_kategori')) !!},
        datasets: [{
            label: 'Jumlah Warga',
            data: {!! json_encode($kategoriChart->pluck('total')) !!},
            backgroundColor: [
                '#2563eb', '#0ea5e9', '#14b8a6', '#22c55e',
                '#f59e0b', '#ef4444', '#8b5cf6', '#ec4899',
                '#f97316', '#06b6d4'
            ],
            borderRadius: 8,
            borderColor: 'rgba(255,255,255,0.2)',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                labels: {
                    color: '#1a2a2a' // HITAM
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    color: '#1a2a2a' // HITAM
                },
                grid: {
                    color: 'rgba(0,0,0,0.08)'
                }
            },
            x: {
                ticks: {
                    color: '#1a2a2a', // HITAM
                    font: {
                        size: 9
                    }
                },
                grid: {
                    display: false
                }
            }
        }
    }
});

// USIA CHART
new Chart(document.getElementById('usiaChart'), {
    type: 'bar',
    data: {
        labels: {!! json_encode(array_keys($usiaChart)) !!},
        datasets: [{
            label: 'Jumlah Warga',
            data: {!! json_encode(array_values($usiaChart)) !!},
            backgroundColor: '#f97316',
            borderRadius: 8,
            borderColor: 'rgba(255,255,255,0.2)',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                labels: {
                    color: '#1a2a2a' // HITAM
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    color: '#1a2a2a' // HITAM
                },
                grid: {
                    color: 'rgba(0,0,0,0.08)'
                }
            },
            x: {
                ticks: {
                    color: '#1a2a2a', // HITAM
                    font: {
                        size: 10
                    }
                },
                grid: {
                    display: false
                }
            }
        }
    }
});
    </script>

    @php
        $kategoriUnik = $grafikKategoriDusun->pluck('nama_kategori')->unique()->values();
        $kemped = [];
        $sukamelang = [];
        foreach ($kategoriUnik as $kategori) {
            $kemped[] = $grafikKategoriDusun
                ->where('nama_dusun', 'Kemped')
                ->where('nama_kategori', $kategori)
                ->sum('total');
            $sukamelang[] = $grafikKategoriDusun
                ->where('nama_dusun', 'Sukamelang')
                ->where('nama_kategori', $kategori)
                ->sum('total');
        }
    @endphp

    <script>
        // GRAFIK SEBARAN WILAYAH
const kategoriUnik = @json($kategoriUnik);
const kemped = @json($kemped);
const sukamelang = @json($sukamelang);

new Chart(document.getElementById('grafikKategoriDusun'), {
    type: 'bar',
    data: {
        labels: kategoriUnik,
        datasets: [{
            label: 'Dusun Kemped',
            data: kemped,
            backgroundColor: '#198754',
            borderRadius: 6,
            borderColor: 'rgba(255,255,255,0.2)',
            borderWidth: 1
        }, {
            label: 'Dusun Sukamelang',
            data: sukamelang,
            backgroundColor: '#6f42c1',
            borderRadius: 6,
            borderColor: 'rgba(255,255,255,0.2)',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'top',
                labels: {
                    usePointStyle: true,
                    padding: 15,
                    boxWidth: 10,
                    font: {
                        size: 11,
                        color: '#1a2a2a' // HITAM
                    }
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    color: '#1a2a2a' // HITAM
                },
                grid: {
                    color: 'rgba(0,0,0,0.08)'
                }
            },
            x: {
                ticks: {
                    color: '#1a2a2a', // HITAM
                    font: {
                        size: 8
                    }
                },
                grid: {
                    display: false
                }
            }
        }
    }
});

        // GRAFIK PER DUSUN - WARNA TIDAK HIJAU AGAR KELIHATAN
        new Chart(document.getElementById('dusunChart'), {
            type: 'bar',
            data: {
                labels: {!! json_encode($dusunChart->pluck('nama_dusun')) !!},
                datasets: [{
                    label: 'Jumlah Keseluruhan Warga',
                    data: {!! json_encode($dusunChart->pluck('total_warga')) !!},
                    backgroundColor: '#2563eb', // Biru
                    borderRadius: 8,
                    borderColor: 'rgba(255,255,255,0.2)',
                    borderWidth: 1
                }, {
                    label: 'Punya Keterampilan',
                    data: {!! json_encode($dusunChart->pluck('total_skill')) !!},
                    backgroundColor: '#f59e0b', // Orange/Kuning
                    borderRadius: 8,
                    borderColor: 'rgba(255,255,255,0.2)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            padding: 15,
                            boxWidth: 10,
                            font: {
                                size: 11,
                                color: '#ffffff'
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: 'rgba(255,255,255,0.8)'
                        },
                        grid: {
                            color: 'rgba(255,255,255,0.08)'
                        }
                    },
                    x: {
                        ticks: {
                            color: 'rgba(255,255,255,0.8)',
                            font: {
                                size: 11
                            }
                        },
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        // GRAFIK PER RT/RW
        const rtRwLabels = {!! json_encode($rtRwChart->map(fn($item) => 'RT ' . $item->rt . '/RW ' . $item->rw)) !!};

        new Chart(document.getElementById('rtRwChart'), {
            type: 'bar',
            data: {
                labels: rtRwLabels,
                datasets: [{
                    label: 'Jumlah Keseluruhan Warga',
                    data: {!! json_encode($rtRwChart->pluck('total_warga')) !!},
                    backgroundColor: '#f59e0b',
                    borderRadius: 8,
                    borderColor: 'rgba(255,255,255,0.2)',
                    borderWidth: 1
                }, {
                    label: 'Punya Keterampilan',
                    data: {!! json_encode($rtRwChart->pluck('total_skill')) !!},
                    backgroundColor: '#ec4899',
                    borderRadius: 8,
                    borderColor: 'rgba(255,255,255,0.2)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            padding: 15,
                            boxWidth: 10,
                            font: {
                                size: 11,
                                color: '#ffffff'
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: 'rgba(255,255,255,0.8)'
                        },
                        grid: {
                            color: 'rgba(255,255,255,0.08)'
                        }
                    },
                    x: {
                        ticks: {
                            color: 'rgba(255,255,255,0.8)',
                            font: {
                                size: 8
                            }
                        },
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    </script>

</body>
</html>