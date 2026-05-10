<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ $settings['nama_osis'] ?? 'OSIS SMA' }} - Website Resmi Organisasi Siswa Intra Sekolah">
    <title>@yield('title', $settings['nama_osis'] ?? 'OSIS SMA') | {{ $settings['nama_sekolah'] ?? 'SMA' }}</title>
    @if(!empty($settings['logo']))
        <link rel="icon" href="{{ asset('storage/'.$settings['logo']) }}" type="image/png">
    @else
        <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    @endif
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root {
            --navy: #050d1a;
            --navy-light: #0d1f3c;
            --navy-mid: #1a3a6b;
            --navy-glass: rgba(5, 13, 26, 0.82);
            --gold: #f5a623;
            --gold-light: #ffc94d;
            --gold-dark: #d48a0a;
            --gold-glow: rgba(245, 166, 35, 0.35);
            --white: #ffffff;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-400: #9ca3af;
            --gray-600: #6b7280;
            --text: #111827;
            --text-muted: #6b7280;
            --radius: 16px;
            --radius-sm: 10px;
            --shadow-sm: 0 2px 8px rgba(0,0,0,0.06);
            --shadow-md: 0 4px 24px rgba(0,0,0,0.10);
            --shadow-lg: 0 12px 48px rgba(0,0,0,0.16);
            --shadow-gold: 0 8px 32px rgba(245,166,35,0.30);
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--text);
            background: #fff;
            overflow-x: hidden;
        }

        /* ── SCROLLBAR ── */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: var(--navy); }
        ::-webkit-scrollbar-thumb { background: var(--gold); border-radius: 3px; }

        /* ── NAVBAR ── */
        .navbar {
            position: fixed; top: 0; left: 0; right: 0; z-index: 1000;
            padding: 0 2rem;
            transition: var(--transition);
            background: var(--navy);
        }
        .navbar.navbar-transparent {
            background: transparent;
        }
        .navbar.scrolled {
            background: var(--navy-glass);
            backdrop-filter: blur(20px) saturate(180%);
            -webkit-backdrop-filter: blur(20px) saturate(180%);
            box-shadow: 0 4px 30px rgba(0,0,0,0.4);
            border-bottom: 1px solid rgba(245,166,35,0.15);
        }
        .navbar-inner {
            max-width: 1280px; margin: 0 auto;
            display: flex; align-items: center; justify-content: space-between;
            height: 72px;
        }
        .navbar-brand {
            display: flex; align-items: center; gap: 14px;
            text-decoration: none; z-index: 1;
        }
        .brand-icon {
            width: 44px; height: 44px;
            background: linear-gradient(135deg, var(--gold), var(--gold-dark));
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-weight: 900; color: var(--navy); font-size: 1.25rem;
            box-shadow: 0 4px 16px var(--gold-glow);
            transition: var(--transition);
        }
        .navbar-brand:hover .brand-icon {
            transform: rotate(-6deg) scale(1.08);
            box-shadow: 0 6px 24px var(--gold-glow);
        }
        .brand-text { color: var(--white); }
        .brand-text .main { font-size: 1.05rem; font-weight: 800; line-height: 1.2; letter-spacing: -0.01em; }
        .brand-text .sub { font-size: 0.68rem; color: var(--gold-light); font-weight: 500; opacity: 0.85; }

        .navbar-nav { display: flex; align-items: center; gap: 4px; list-style: none; }
        .navbar-nav .nav-link {
            color: rgba(255,255,255,0.78);
            text-decoration: none;
            padding: 7px 15px;
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 600;
            transition: var(--transition);
            position: relative;
        }
        .navbar-nav .nav-link::after {
            content: '';
            position: absolute; bottom: 4px; left: 50%; right: 50%;
            height: 2px; background: var(--gold); border-radius: 1px;
            transition: var(--transition);
        }
        .navbar-nav .nav-link:hover { color: var(--white); }
        .navbar-nav .nav-link:hover::after,
        .navbar-nav .nav-link.active::after { left: 15px; right: 15px; }
        .navbar-nav .nav-link:hover,
        .navbar-nav .nav-link.active { color: var(--gold-light); }

        /* ── DROPDOWN ── */
        .nav-item-dropdown { position: relative; }
        .dropdown-menu {
            position: absolute; top: 110%; left: 0;
            background: var(--navy-glass);
            backdrop-filter: blur(24px) saturate(180%);
            -webkit-backdrop-filter: blur(24px) saturate(180%);
            min-width: 195px; border-radius: var(--radius-sm);
            padding: 0.5rem 0; box-shadow: var(--shadow-lg);
            border: 1px solid rgba(245,166,35,0.25);
            opacity: 0; transform: translateY(15px);
            visibility: hidden; transition: var(--transition);
        }
        .nav-item-dropdown:hover .dropdown-menu {
            opacity: 1; transform: translateY(0); visibility: visible;
            top: 100%;
        }
        .dropdown-item {
            color: rgba(255,255,255,0.85); text-decoration: none;
            padding: 10px 20px; display: block; font-size: 0.9rem; font-weight: 600;
            transition: var(--transition);
        }
        .dropdown-item:hover { color: var(--gold); background: rgba(245,166,35,0.1); padding-left: 24px; }

        /* Hamburger */
        .nav-toggle {
            display: none; background: none; border: none; cursor: pointer;
            padding: 8px; border-radius: 8px; transition: var(--transition);
            color: white; flex-direction: column; gap: 5px;
        }
        .nav-toggle span {
            display: block; width: 22px; height: 2px;
            background: white; border-radius: 2px; transition: var(--transition);
        }
        .nav-toggle.open span:nth-child(1) { transform: translateY(7px) rotate(45deg); }
        .nav-toggle.open span:nth-child(2) { opacity: 0; transform: scaleX(0); }
        .nav-toggle.open span:nth-child(3) { transform: translateY(-7px) rotate(-45deg); }

        /* Mobile Menu */
        .mobile-menu {
            display: none;
            position: fixed; top: 72px; left: 0; right: 0;
            z-index: 999;
            background: var(--navy-glass);
            backdrop-filter: blur(24px) saturate(160%);
            -webkit-backdrop-filter: blur(24px) saturate(160%);
            border-bottom: 1px solid rgba(245,166,35,0.15);
            padding: 1rem 1.5rem 1.5rem;
            transform: translateY(-10px); opacity: 0;
            transition: var(--transition);
            pointer-events: none;
        }
        .mobile-menu.open {
            display: flex; flex-direction: column; gap: 4px;
            transform: translateY(0); opacity: 1;
            pointer-events: auto;
        }
        .mobile-menu a {
            color: rgba(255,255,255,0.85); text-decoration: none;
            padding: 12px 16px; border-radius: 10px; font-weight: 600;
            font-size: 0.95rem; transition: var(--transition); display: block;
        }
        .mobile-menu a:hover { color: var(--gold); background: rgba(245,166,35,0.1); }
        .mobile-dropdown-menu { display: none; flex-direction: column; gap: 2px; padding-left: 10px; border-left: 1px dashed rgba(255,255,255,0.15); margin-left: 24px; margin-top: 4px; }
        .mobile-dropdown-menu.open { display: flex; animation: fadeDown 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        @keyframes fadeDown { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }
        .mobile-dropdown-toggle .toggle-icon { transition: transform 0.3s ease; }
        .mobile-dropdown-toggle.open .toggle-icon { transform: rotate(180deg); }

        @media (max-width: 768px) {
            .navbar-nav { display: none; }
            .nav-toggle { display: flex; }
        }

        /* ── PAGE BODY OFFSET (fixed navbar) ── */
        .page-offset { padding-top: 72px; }

        /* ── SECTIONS ── */
        .section { padding: 96px 2rem; }
        .section-sm { padding: 48px 2rem; }
        .container { max-width: 1280px; margin: 0 auto; }

        .section-title { text-align: center; margin-bottom: 60px; }
        .section-label {
            display: inline-flex; align-items: center; gap: 8px;
            background: rgba(245,166,35,0.12);
            border: 1px solid rgba(245,166,35,0.25);
            color: var(--gold-dark); padding: 6px 16px;
            border-radius: 20px; font-size: 0.78rem; font-weight: 700;
            letter-spacing: 0.08em; text-transform: uppercase; margin-bottom: 14px;
        }
        .section-title h2 {
            font-size: 2.25rem; font-weight: 900; color: var(--navy);
            letter-spacing: -0.02em; line-height: 1.15;
        }
        .section-title h2 .highlight { color: var(--gold-dark); }
        .section-title p { color: var(--gray-600); margin-top: 12px; font-size: 1.05rem; line-height: 1.7; }

        /* Dark variant */
        .section-title.dark h2 { color: var(--white); }
        .section-title.dark p { color: rgba(255,255,255,0.6); }
        .section-title.dark .section-label { background: rgba(245,166,35,0.15); border-color: rgba(245,166,35,0.3); color: var(--gold-light); }

        /* ── CARDS ── */
        .card {
            background: #fff;
            border-radius: var(--radius);
            overflow: hidden;
            box-shadow: var(--shadow-md);
            transition: transform 0.35s cubic-bezier(0.4,0,0.2,1), box-shadow 0.35s cubic-bezier(0.4,0,0.2,1);
            border: 1px solid var(--gray-200);
        }
        .card:hover {
            transform: translateY(-8px) scale(1.015);
            box-shadow: 0 24px 60px rgba(0,0,0,0.14), 0 0 0 1px rgba(245,166,35,0.15);
        }
        .card-img { width: 100%; height: 210px; object-fit: cover; display: block; }
        .card-body { padding: 1.5rem; }
        .card-badge {
            display: inline-flex; align-items: center; gap: 5px;
            background: linear-gradient(135deg, var(--gold), var(--gold-dark));
            color: var(--navy); font-size: 0.72rem; font-weight: 800;
            padding: 4px 12px; border-radius: 20px; margin-bottom: 10px;
            letter-spacing: 0.03em;
        }
        .card-title { font-size: 1.05rem; font-weight: 800; color: var(--navy); margin-bottom: 8px; line-height: 1.45; }
        .card-text { color: var(--gray-600); font-size: 0.9rem; line-height: 1.65; }
        .card-footer-link {
            display: inline-flex; align-items: center; gap: 7px;
            color: var(--gold-dark); font-weight: 700; font-size: 0.88rem;
            text-decoration: none; margin-top: 1.1rem;
            transition: var(--transition);
        }
        .card-footer-link i { transition: transform 0.25s; }
        .card-footer-link:hover { color: var(--gold); }
        .card-footer-link:hover i { transform: translateX(4px); }

        /* ── GRID ── */
        .grid-3 { display: grid; grid-template-columns: repeat(3, 1fr); gap: 28px; }
        .grid-4 { display: grid; grid-template-columns: repeat(4, 1fr); gap: 24px; }
        .grid-2 { display: grid; grid-template-columns: repeat(2, 1fr); gap: 28px; }
        @media (max-width: 1024px) {
            .grid-3 { grid-template-columns: repeat(2, 1fr); }
            .grid-4 { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 640px) {
            .grid-3, .grid-4, .grid-2 { grid-template-columns: 1fr; }
            .section { padding: 64px 1.25rem; }
        }

        /* ── BUTTONS ── */
        .btn {
            display: inline-flex; align-items: center; gap: 9px;
            padding: 13px 28px; border-radius: 10px; font-weight: 700;
            text-decoration: none; font-size: 0.92rem;
            transition: var(--transition); cursor: pointer; border: none;
            letter-spacing: 0.01em; font-family: inherit;
        }
        .btn-primary {
            background: linear-gradient(135deg, var(--gold), var(--gold-dark));
            color: var(--navy);
            box-shadow: 0 4px 16px var(--gold-glow);
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, var(--gold-light), var(--gold));
            transform: translateY(-2px);
            box-shadow: 0 8px 28px var(--gold-glow);
        }
        .btn-outline {
            background: transparent;
            border: 2px solid rgba(245,166,35,0.6);
            color: var(--gold);
        }
        .btn-outline:hover {
            background: rgba(245,166,35,0.1);
            border-color: var(--gold);
        }
        .btn-ghost {
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.2);
            color: white;
        }
        .btn-ghost:hover {
            background: rgba(255,255,255,0.15);
            border-color: rgba(255,255,255,0.35);
        }

        /* ── PROFILE CARD ── */
        .profile-card {
            text-align: center; padding: 2rem 1.5rem 1.75rem;
            position: relative;
        }
        .profile-avatar {
            width: 100px; height: 100px; border-radius: 50%;
            object-fit: cover; margin: 0 auto 1rem;
            border: 4px solid var(--gold);
            box-shadow: 0 0 0 6px rgba(245,166,35,0.12);
            display: flex; align-items: center; justify-content: center;
            background: linear-gradient(135deg, var(--navy-mid), var(--navy-light));
            color: var(--gold); font-size: 2.5rem;
        }
        .profile-name { font-size: 1rem; font-weight: 800; color: var(--navy); line-height: 1.3; }
        .profile-pos { font-size: 0.82rem; color: var(--gold-dark); font-weight: 700; margin-top: 5px; }

        /* ── PAGINATION ── */
        .pagination { display: flex; justify-content: center; gap: 8px; margin-top: 3.5rem; flex-wrap: wrap; }
        .pagination a, .pagination span {
            padding: 9px 15px; border-radius: 9px; font-size: 0.88rem; font-weight: 600;
            text-decoration: none; transition: var(--transition);
        }
        .pagination a {
            background: var(--gray-50); color: var(--navy);
            border: 1.5px solid var(--gray-200);
        }
        .pagination a:hover { background: var(--gold); color: var(--navy); border-color: var(--gold); }
        .pagination .active { background: var(--gold); color: var(--navy); border: 1.5px solid var(--gold); }

        /* ── ALERTS ── */
        .alert { padding: 14px 20px; border-radius: 10px; margin-bottom: 16px; font-size: 0.9rem; display: flex; align-items: center; gap: 10px; }
        .alert-success { background: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; }
        .alert-error { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }

        /* ── FLASH TOAST ── */
        .toast-container {
            position: fixed; top: 90px; right: 24px; z-index: 9999; display: flex; flex-direction: column; gap: 10px;
        }
        .toast {
            background: var(--navy-light); border-left: 4px solid var(--gold);
            color: white; padding: 14px 20px;
            border-radius: 12px; font-size: 0.9rem; font-weight: 600;
            box-shadow: 0 8px 32px rgba(0,0,0,0.3);
            display: flex; align-items: center; gap: 10px;
            animation: slideIn 0.4s cubic-bezier(0.4,0,0.2,1);
            max-width: 340px;
        }
        @keyframes slideIn {
            from { transform: translateX(120%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        .toast i { color: var(--gold); font-size: 1.1rem; }

        /* ── PAGE HERO ── */
        .page-hero {
            background: linear-gradient(135deg, var(--navy) 0%, var(--navy-light) 60%, #1a3a6b 100%);
            padding: 5rem 2rem 4rem;
            text-align: center;
            position: relative; overflow: hidden;
        }
        .page-hero::before {
            content: '';
            position: absolute; inset: 0;
            background: radial-gradient(ellipse at 70% 50%, rgba(245,166,35,0.08) 0%, transparent 70%);
        }
        .page-hero::after {
            content: '';
            position: absolute; bottom: -1px; left: 0; right: 0;
            height: 60px;
            background: url("data:image/svg+xml,%3Csvg viewBox='0 0 1440 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M0,40 C360,80 1080,0 1440,40 L1440,60 L0,60 Z' fill='%23ffffff'/%3E%3C/svg%3E") no-repeat bottom / cover;
        }
        .page-hero-dark::after {
            background: url("data:image/svg+xml,%3Csvg viewBox='0 0 1440 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M0,40 C360,80 1080,0 1440,40 L1440,60 L0,60 Z' fill='%23f3f4f6'/%3E%3C/svg%3E") no-repeat bottom / cover;
        }
        .page-hero h1 {
            font-size: 2.8rem; font-weight: 900; color: var(--gold-light);
            letter-spacing: -0.02em; position: relative; z-index: 1;
        }
        .page-hero p {
            color: rgba(255,255,255,0.68); margin-top: 0.6rem;
            font-size: 1.05rem; position: relative; z-index: 1;
        }
        .hero-breadcrumb {
            display: flex; align-items: center; gap: 8px; justify-content: center;
            margin-top: 1.2rem; position: relative; z-index: 1;
        }
        .hero-breadcrumb span { color: rgba(255,255,255,0.45); font-size: 0.82rem; }
        .hero-breadcrumb a { color: var(--gold); font-size: 0.82rem; font-weight: 600; text-decoration: none; }
        .hero-breadcrumb a:hover { text-decoration: underline; }

        /* ── SCROLL REVEAL ── */
        .reveal {
            opacity: 0;
            transform: translateY(28px);
            transition: opacity 0.65s cubic-bezier(0.4,0,0.2,1), transform 0.65s cubic-bezier(0.4,0,0.2,1);
        }
        .reveal.revealed {
            opacity: 1; transform: translateY(0);
        }
        .reveal-delay-1 { transition-delay: 0.1s; }
        .reveal-delay-2 { transition-delay: 0.2s; }
        .reveal-delay-3 { transition-delay: 0.3s; }
        .reveal-delay-4 { transition-delay: 0.4s; }

        /* ── FOOTER ── */
        footer {
            background: var(--navy);
            color: rgba(255,255,255,0.65);
            padding: 72px 2rem 36px;
            position: relative; overflow: hidden;
        }
        footer::before {
            content: '';
            position: absolute; top: 0; left: 0; right: 0; height: 3px;
            background: linear-gradient(90deg, transparent, var(--gold), transparent);
        }
        .footer-inner { max-width: 1280px; margin: 0 auto; }
        .footer-grid {
            display: grid; grid-template-columns: 2fr 1fr 1fr;
            gap: 3.5rem; margin-bottom: 3rem;
        }
        .footer-brand .name {
            color: var(--gold); font-size: 1.2rem; font-weight: 800;
            margin-bottom: 10px; letter-spacing: -0.01em;
        }
        .footer-brand p { font-size: 0.9rem; line-height: 1.75; }
        footer h4 { color: var(--white); font-size: 0.95rem; font-weight: 800; margin-bottom: 1.2rem; letter-spacing: 0.03em; text-transform: uppercase; font-size: 0.8rem; }
        footer ul { list-style: none; }
        footer ul li { margin-bottom: 10px; }
        footer ul li a {
            color: rgba(255,255,255,0.6); text-decoration: none; font-size: 0.9rem;
            transition: var(--transition); display: inline-flex; align-items: center; gap: 6px;
        }
        footer ul li a:hover { color: var(--gold); padding-left: 4px; }
        .footer-contact p { font-size: 0.88rem; margin-bottom: 10px; display: flex; align-items: flex-start; gap: 10px; }
        .footer-contact .icon { color: var(--gold); margin-top: 2px; flex-shrink: 0; }
        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,0.08);
            padding-top: 1.75rem; text-align: center; font-size: 0.82rem;
        }
        .social-links { display: flex; gap: 10px; margin-top: 1.25rem; }
        .social-links a {
            width: 38px; height: 38px; border-radius: 10px;
            background: rgba(255,255,255,0.07);
            border: 1px solid rgba(255,255,255,0.08);
            color: rgba(255,255,255,0.65);
            display: flex; align-items: center; justify-content: center;
            text-decoration: none; transition: var(--transition); font-size: 0.95rem;
        }
        .social-links a:hover {
            background: var(--gold); color: var(--navy);
            border-color: var(--gold);
            transform: translateY(-3px);
            box-shadow: 0 6px 18px var(--gold-glow);
        }
        @media (max-width: 768px) {
            .footer-grid { grid-template-columns: 1fr; gap: 2.5rem; }
            .page-hero h1 { font-size: 2rem; }
        }

        @yield('extra-styles')
    </style>
    @yield('styles')
</head>
<body>

<nav class="navbar {{ request()->routeIs('home') ? 'navbar-transparent' : '' }}" id="mainNavbar">
    <div class="navbar-inner">
        <a href="{{ route('home') }}" class="navbar-brand">
            @if(!empty($settings['logo']))
                <img src="{{ asset('storage/'.$settings['logo']) }}" alt="Logo" class="brand-icon" style="background:transparent;object-fit:contain;padding:4px;border-radius:12px;">
            @else
                <div class="brand-icon">O</div>
            @endif
            <div class="brand-text">
                <div class="main">{{ $settings['nama_osis'] ?? 'OSIS SMA' }}</div>
                <div class="sub">{{ $settings['nama_sekolah'] ?? 'SMA' }}</div>
            </div>
        </a>

        <ul class="navbar-nav">
            <li><a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Beranda</a></li>
            <li class="nav-item-dropdown">
                <a href="{{ route('kegiatan.index') }}" class="nav-link {{ request()->routeIs('kegiatan*') ? 'active' : '' }}">Kegiatan <i class="fas fa-chevron-down" style="font-size:0.7em; margin-left:4px;"></i></a>
                <div class="dropdown-menu">
                    <a href="{{ route('kegiatan.index', ['gender' => 'putra']) }}" class="dropdown-item">Kepengurusan Putra</a>
                    <a href="{{ route('kegiatan.index', ['gender' => 'putri']) }}" class="dropdown-item">Kepengurusan Putri</a>
                </div>
            </li>
            <li class="nav-item-dropdown">
                <a href="{{ route('galeri.index') }}" class="nav-link {{ request()->routeIs('galeri*') ? 'active' : '' }}">Galeri <i class="fas fa-chevron-down" style="font-size:0.7em; margin-left:4px;"></i></a>
                <div class="dropdown-menu">
                    <a href="{{ route('galeri.index', ['gender' => 'putra']) }}" class="dropdown-item">Kepengurusan Putra</a>
                    <a href="{{ route('galeri.index', ['gender' => 'putri']) }}" class="dropdown-item">Kepengurusan Putri</a>
                </div>
            </li>
            <li class="nav-item-dropdown">
                <a href="{{ route('struktur.index') }}" class="nav-link {{ request()->routeIs('struktur*') ? 'active' : '' }}">Struktur <i class="fas fa-chevron-down" style="font-size:0.7em; margin-left:4px;"></i></a>
                <div class="dropdown-menu">
                    <a href="{{ route('struktur.index', ['gender' => 'putra']) }}" class="dropdown-item">Kepengurusan Putra</a>
                    <a href="{{ route('struktur.index', ['gender' => 'putri']) }}" class="dropdown-item">Kepengurusan Putri</a>
                </div>
            </li>
            <li><a href="{{ route('kontak.index') }}" class="nav-link {{ request()->routeIs('kontak*') ? 'active' : '' }}">Kontak</a></li>
        </ul>

        <button class="nav-toggle" id="navToggle" aria-label="Toggle Menu">
            <span></span><span></span><span></span>
        </button>
    </div>
</nav>

<div class="mobile-menu" id="mobileMenu">
    <a href="{{ route('home') }}"><i class="fas fa-home"></i> Beranda</a>
    <div class="mobile-dropdown">
        <a href="javascript:void(0)" class="mobile-dropdown-toggle"><i class="fas fa-calendar-alt"></i> Kegiatan <i class="fas fa-chevron-down toggle-icon" style="float:right; margin-top:4px;"></i></a>
        <div class="mobile-dropdown-menu">
            <a href="{{ route('kegiatan.index', ['gender' => 'putra']) }}"><i class="fas fa-male" style="margin-right: 5px;"></i> Putra</a>
            <a href="{{ route('kegiatan.index', ['gender' => 'putri']) }}"><i class="fas fa-female" style="margin-right: 5px;"></i> Putri</a>
        </div>
    </div>
    <div class="mobile-dropdown">
        <a href="javascript:void(0)" class="mobile-dropdown-toggle"><i class="fas fa-images"></i> Galeri <i class="fas fa-chevron-down toggle-icon" style="float:right; margin-top:4px;"></i></a>
        <div class="mobile-dropdown-menu">
            <a href="{{ route('galeri.index', ['gender' => 'putra']) }}"><i class="fas fa-male" style="margin-right: 5px;"></i> Putra</a>
            <a href="{{ route('galeri.index', ['gender' => 'putri']) }}"><i class="fas fa-female" style="margin-right: 5px;"></i> Putri</a>
        </div>
    </div>
    <div class="mobile-dropdown">
        <a href="javascript:void(0)" class="mobile-dropdown-toggle"><i class="fas fa-sitemap"></i> Struktur <i class="fas fa-chevron-down toggle-icon" style="float:right; margin-top:4px;"></i></a>
        <div class="mobile-dropdown-menu">
            <a href="{{ route('struktur.index', ['gender' => 'putra']) }}"><i class="fas fa-male" style="margin-right: 5px;"></i> Putra</a>
            <a href="{{ route('struktur.index', ['gender' => 'putri']) }}"><i class="fas fa-female" style="margin-right: 5px;"></i> Putri</a>
        </div>
    </div>
    <a href="{{ route('kontak.index') }}"><i class="fas fa-envelope"></i> Kontak</a>
</div>

@if(session('success'))
<div class="toast-container" id="toastContainer">
    <div class="toast">
        <i class="fas fa-check-circle"></i>
        <span>{{ session('success') }}</span>
    </div>
</div>
@endif

@yield('content')

<footer>
    <div class="footer-inner">
        <div class="footer-grid">
            <div class="footer-brand">
                <div class="name"><i class="fas fa-star" style="font-size:0.8em;margin-right:6px;"></i>{{ $settings['nama_osis'] ?? 'OSIS SMA' }}</div>
                <div style="margin-bottom:1rem; color:var(--gray-400); font-size:0.9rem;">
                    @if(!empty($settings['visi_putra']) || !empty($settings['visi_putri']))
                        @if(!empty($settings['visi_putra']))
                            <div style="margin-bottom:2px;"><strong>Putra:</strong> {{ $settings['visi_putra'] }}</div>
                        @endif
                        @if(!empty($settings['visi_putri']))
                            <div><strong>Putri:</strong> {{ $settings['visi_putri'] }}</div>
                        @endif
                    @else
                        Organisasi Siswa Intra Sekolah yang berdedikasi untuk kemajuan pendidikan dan karakter siswa.
                    @endif
                </div>
                <div class="social-links">
                    @if(!empty($settings['instagram']))<a href="{{ $settings['instagram'] }}" target="_blank" title="Instagram"><i class="fab fa-instagram"></i></a>@endif
                    @if(!empty($settings['tiktok']))<a href="{{ $settings['tiktok'] }}" target="_blank" title="TikTok"><i class="fab fa-tiktok"></i></a>@endif
                    @if(!empty($settings['facebook']))<a href="{{ $settings['facebook'] }}" target="_blank" title="Facebook"><i class="fab fa-facebook-f"></i></a>@endif
                    @if(!empty($settings['twitter']))<a href="{{ $settings['twitter'] }}" target="_blank" title="Twitter/X"><i class="fab fa-twitter"></i></a>@endif
                </div>
            </div>
            <div>
                <h4>Navigasi</h4>
                <ul>
                    <li><a href="{{ route('home') }}"><i class="fas fa-chevron-right" style="font-size:0.7em;"></i>Beranda</a></li>
                    <li><a href="{{ route('kegiatan.index') }}"><i class="fas fa-chevron-right" style="font-size:0.7em;"></i>Kegiatan</a></li>
                    <li><a href="{{ route('galeri.index') }}"><i class="fas fa-chevron-right" style="font-size:0.7em;"></i>Galeri</a></li>
                    <li><a href="{{ route('struktur.index') }}"><i class="fas fa-chevron-right" style="font-size:0.7em;"></i>Struktur Organisasi</a></li>
                    <li><a href="{{ route('kontak.index') }}"><i class="fas fa-chevron-right" style="font-size:0.7em;"></i>Kontak</a></li>
                </ul>
            </div>
            <div class="footer-contact">
                <h4>Kontak</h4>
                <p><span class="icon"><i class="fas fa-map-marker-alt"></i></span>{{ $settings['alamat'] ?? '-' }}</p>
                <p><span class="icon"><i class="fab fa-whatsapp"></i></span><a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings['telepon'] ?? '') }}" target="_blank" style="color:inherit;text-decoration:none;">{{ $settings['telepon'] ?? '-' }}</a></p>
                <p><span class="icon"><i class="fas fa-envelope"></i></span><a href="mailto:{{ $settings['email'] ?? '' }}" target="_blank" style="color:inherit;text-decoration:none;">{{ $settings['email'] ?? '-' }}</a></p>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} {{ $settings['nama_osis'] ?? 'OSIS SMA' }} — {{ $settings['nama_sekolah'] ?? 'SMA' }}. Made with <i class="fas fa-heart" style="color:var(--gold);"></i> for students.</p>
        </div>
    </div>
</footer>

<script>
// ── Navbar scroll effect ──
const navbar = document.getElementById('mainNavbar');
const onScroll = () => {
    navbar.classList.toggle('scrolled', window.scrollY > 40);
};
window.addEventListener('scroll', onScroll, { passive: true });
onScroll();

// ── Hamburger toggle ──
const toggle = document.getElementById('navToggle');
const mobileMenu = document.getElementById('mobileMenu');
if (toggle && mobileMenu) {
    toggle.addEventListener('click', () => {
        const isOpen = mobileMenu.classList.toggle('open');
        toggle.classList.toggle('open', isOpen);
    });
    // Close on link click
    mobileMenu.querySelectorAll('a:not(.mobile-dropdown-toggle)').forEach(a => {
        a.addEventListener('click', () => {
            mobileMenu.classList.remove('open');
            toggle.classList.remove('open');
        });
    });

    // Mobile dropdown toggle
    mobileMenu.querySelectorAll('.mobile-dropdown-toggle').forEach(el => {
        el.addEventListener('click', function(e) {
            e.preventDefault();
            this.classList.toggle('open');
            const menu = this.nextElementSibling;
            if (menu) menu.classList.toggle('open');
        });
    });
}

// ── Auto-dismiss toast ──
setTimeout(() => {
    document.querySelectorAll('.toast').forEach(el => {
        el.style.transition = 'opacity 0.5s, transform 0.5s';
        el.style.opacity = '0'; el.style.transform = 'translateX(120%)';
        setTimeout(() => el.remove(), 500);
    });
}, 3500);

// ── Scroll Reveal ──
const revealEls = document.querySelectorAll('.reveal');
const observer = new IntersectionObserver((entries) => {
    entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('revealed'); observer.unobserve(e.target); } });
}, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });
revealEls.forEach(el => observer.observe(el));
</script>
@yield('scripts')
</body>
</html>
