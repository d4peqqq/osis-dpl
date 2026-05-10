<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - @yield('title', 'Dashboard') | OSIS SMA</title>
    @php $favicon = \App\Models\Pengaturan::where('key', 'logo')->value('value'); @endphp
    @if(!empty($favicon))
        <link rel="icon" href="{{ asset('storage/'.$favicon) }}" type="image/png">
    @else
        <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    @endif
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root {
            --navy: #050d1a; --navy-light: #0d1f3c; --navy-mid: #1a3a6b;
            --gold: #f5a623; --gold-light: #ffc94d; --gold-dark: #d48a0a;
            --sidebar-w: 260px; --topbar-h: 64px;
            --success: #10b981; --danger: #ef4444; --warning: #f59e0b;
            --gray-50: #f8fafc; --gray-100: #f1f5f9; --gray-200: #e2e8f0;
            --gray-600: #64748b; --text: #1e293b;
        }
        * { margin:0;padding:0;box-sizing:border-box; }
        body { font-family:'Plus Jakarta Sans',sans-serif; background:var(--gray-50); color:var(--text); }

        /* Sidebar */
        .sidebar {
            position:fixed; top:0; left:0; bottom:0;
            width:var(--sidebar-w); background:var(--navy);
            display:flex; flex-direction:column; z-index:100;
            transition:transform 0.3s;
        }
        .sidebar-header {
            padding:1.5rem; border-bottom:1px solid rgba(255,255,255,0.07);
        }
        .sidebar-brand { display:flex; align-items:center; gap:10px; text-decoration:none; }
        .sidebar-brand .icon {
            width:40px;height:40px;background:var(--gold);border-radius:8px;
            display:flex;align-items:center;justify-content:center;
            font-weight:900;color:var(--navy);font-size:1.1rem;
        }
        .sidebar-brand .text .main { color:white;font-weight:700;font-size:1rem;line-height:1.2; }
        .sidebar-brand .text .sub { color:rgba(255,255,255,0.4);font-size:0.7rem; }
        .sidebar-nav { flex:1; overflow-y:auto; padding:1rem 0; }
        .nav-group-label {
            padding:0.5rem 1.5rem; font-size:0.68rem; font-weight:600;
            color:rgba(255,255,255,0.3); text-transform:uppercase; letter-spacing:1px;
            margin-top:0.5rem;
        }
        .nav-item a {
            display:flex; align-items:center; gap:12px;
            padding:10px 20px; color:rgba(255,255,255,0.65);
            text-decoration:none; font-size:0.9rem; font-weight:500;
            border-radius:8px; margin:2px 8px;
            transition:all 0.2s;
        }
        .nav-item a:hover, .nav-item a.active {
            color:white; background:rgba(255,255,255,0.08);
        }
        .nav-item a.active { background:rgba(240,165,0,0.15); color:var(--gold); }
        .nav-item a .icon { width:20px;text-align:center;font-size:0.9rem; }
        .sidebar-footer {
            padding:1rem; border-top:1px solid rgba(255,255,255,0.07);
        }
        .user-info { display:flex;align-items:center;gap:10px;padding:0.75rem;background:rgba(255,255,255,0.05);border-radius:10px; }
        .user-avatar {
            width:36px;height:36px;background:var(--gold);border-radius:8px;
            display:flex;align-items:center;justify-content:center;color:var(--navy);font-weight:700;
        }
        .user-details .name { color:white;font-size:0.85rem;font-weight:600; }
        .user-details .role { color:var(--gold);font-size:0.7rem; }

        /* Topbar */
        .topbar {
            position:fixed; top:0; left:var(--sidebar-w); right:0;
            height:var(--topbar-h); background:white;
            border-bottom:1px solid var(--gray-200);
            display:flex; align-items:center; justify-content:space-between;
            padding:0 2rem; z-index:99;
            box-shadow:0 1px 3px rgba(0,0,0,0.06);
        }
        .topbar-title { font-size:1.1rem; font-weight:700; color:var(--navy); }
        .topbar-actions { display:flex; align-items:center; gap:1rem; }
        .topbar-btn {
            display:inline-flex; align-items:center; gap:6px;
            padding:8px 16px; border-radius:8px; font-size:0.85rem; font-weight:600;
            text-decoration:none; transition:all 0.2s; cursor:pointer; border:none;
        }
        .btn-gold { background:var(--gold); color:var(--navy); }
        .btn-gold:hover { background:var(--gold-light); }
        .btn-danger { background:#fee2e2; color:var(--danger); border:1px solid #fca5a5; }
        .btn-danger:hover { background:var(--danger); color:white; }

        /* Main */
        .main-content { margin-left:var(--sidebar-w); margin-top:var(--topbar-h); padding:2rem; min-height:calc(100vh - var(--topbar-h)); }

        /* Stats cards */
        .stats-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:1.5rem; margin-bottom:2rem; }
        .stat-card {
            background:white; border-radius:16px; padding:1.5rem;
            box-shadow:0 1px 8px rgba(0,0,0,0.05); display:flex; align-items:center; gap:1rem;
        }
        .stat-icon {
            width:56px;height:56px;border-radius:14px;
            display:flex;align-items:center;justify-content:center;font-size:1.4rem;flex-shrink:0;
        }
        .stat-icon.gold { background:rgba(240,165,0,0.1); color:var(--gold); }
        .stat-icon.navy { background:rgba(10,22,40,0.08); color:var(--navy); }
        .stat-icon.green { background:rgba(16,185,129,0.1); color:var(--success); }
        .stat-num { font-size:2rem; font-weight:800; color:var(--navy); line-height:1; }
        .stat-label { font-size:0.85rem; color:var(--gray-600); margin-top:4px; }

        /* Table */
        .table-wrap { background:white; border-radius:16px; overflow:hidden; box-shadow:0 1px 8px rgba(0,0,0,0.05); }
        .table-header { padding:1.25rem 1.5rem; display:flex; align-items:center; justify-content:space-between; border-bottom:1px solid var(--gray-100); }
        .table-header h3 { font-size:1rem; font-weight:700; color:var(--navy); }
        table { width:100%; border-collapse:collapse; }
        thead th { background:var(--gray-50); padding:12px 16px; text-align:left; font-size:0.8rem; font-weight:700; color:var(--gray-600); text-transform:uppercase; letter-spacing:0.05em; border-bottom:1px solid var(--gray-200); }
        tbody td { padding:14px 16px; font-size:0.9rem; border-bottom:1px solid var(--gray-100); color:var(--text); vertical-align:middle; }
        tbody tr:last-child td { border-bottom:none; }
        tbody tr:hover { background:var(--gray-50); }

        /* Form */
        .form-wrap { background:white; border-radius:16px; padding:2rem; box-shadow:0 1px 8px rgba(0,0,0,0.05); }
        .form-group { margin-bottom:1.25rem; }
        label { display:block; font-size:0.85rem; font-weight:600; color:var(--navy); margin-bottom:6px; }
        input[type=text], input[type=email], input[type=date], input[type=number], input[type=password], textarea, select {
            width:100%; padding:10px 14px; border:2px solid var(--gray-200);
            border-radius:8px; font-size:0.9rem; font-family:inherit;
            transition:border-color 0.2s; outline:none; background:white;
        }
        input:focus, textarea:focus, select:focus { border-color:var(--gold); }
        textarea { min-height:120px; resize:vertical; }
        .form-check { display:flex; align-items:center; gap:8px; }
        .form-check input[type=checkbox] { width:18px; height:18px; accent-color:var(--gold); }
        .form-error { color:var(--danger); font-size:0.8rem; margin-top:4px; }
        .form-hint { color:var(--gray-600); font-size:0.8rem; margin-top:4px; }
        .img-preview { max-width:200px; border-radius:10px; margin-top:8px; border:2px solid var(--gray-200); }

        /* Alert */
        .alert { padding:12px 16px; border-radius:8px; margin-bottom:1.25rem; font-size:0.9rem; display:flex; align-items:center; gap:8px; }
        .alert-success { background:#d1fae5; color:#065f46; border:1px solid #a7f3d0; }
        .alert-error { background:#fee2e2; color:#991b1b; border:1px solid #fca5a5; }

        /* Badge */
        .badge { padding:3px 10px; border-radius:20px; font-size:0.75rem; font-weight:600; }
        .badge-success { background:#d1fae5; color:#065f46; }
        .badge-danger { background:#fee2e2; color:#991b1b; }
        .badge-gold { background:rgba(240,165,0,0.15); color:var(--gold-dark); }

        /* Action buttons */
        .action-btns { display:flex; gap:6px; }
        .btn-sm { padding:5px 12px; border-radius:6px; font-size:0.8rem; font-weight:600; text-decoration:none; border:none; cursor:pointer; display:inline-flex; align-items:center; gap:4px; transition:all 0.2s; }
        .btn-sm.edit { background:#eff6ff; color:#1d4ed8; }
        .btn-sm.edit:hover { background:#1d4ed8; color:white; }
        .btn-sm.delete { background:#fee2e2; color:var(--danger); }
        .btn-sm.delete:hover { background:var(--danger); color:white; }
        .btn-sm.view { background:rgba(240,165,0,0.1); color:var(--gold-dark); }
        .btn-sm.view:hover { background:var(--gold); color:var(--navy); }
        .btn-sm.pdf { background:#f0fdf4; color:#15803d; }
        .btn-sm.pdf:hover { background:#15803d; color:white; }
        .btn-sm.print { background:#eff6ff; color:#1d4ed8; }
        .btn-sm.print:hover { background:#1d4ed8; color:white; }

        /* Breadcrumb */
        .breadcrumb { display:flex; align-items:center; gap:6px; margin-bottom:1.5rem; font-size:0.85rem; color:var(--gray-600); }
        .breadcrumb a { color:var(--gray-600); text-decoration:none; }
        .breadcrumb a:hover { color:var(--gold-dark); }

        /* Pagination */
        .pagination-wrap { display:flex; align-items:center; justify-content:space-between; padding:1rem 1.5rem; border-top:1px solid var(--gray-100); flex-wrap:wrap; gap:0.75rem; }
        .pagination-info { font-size:0.82rem; color:var(--gray-600); }
        .pagination { display:flex; align-items:center; gap:4px; list-style:none; }
        .pagination li a,
        .pagination li span {
            display:inline-flex; align-items:center; justify-content:center;
            min-width:36px; height:36px; padding:0 10px;
            border-radius:8px; font-size:0.85rem; font-weight:600;
            text-decoration:none; transition:all 0.2s;
            border:1.5px solid var(--gray-200); color:var(--gray-600);
            background:white;
        }
        .pagination li a:hover { border-color:var(--gold); color:var(--gold-dark); background:#fffbeb; }
        .pagination li.active span { background:var(--gold); color:var(--navy); border-color:var(--gold); font-weight:700; }
        .pagination li.disabled span { color:var(--gray-200); border-color:var(--gray-100); cursor:not-allowed; background:var(--gray-50); }
        .pagination li.prev a, .pagination li.next a { font-weight:700; gap:4px; }
        .pagination li.prev a:hover, .pagination li.next a:hover { background:var(--navy); color:white; border-color:var(--navy); }

        /* Member Card Preview */
        .id-card {
            width:340px; background:linear-gradient(135deg,var(--navy) 0%,var(--navy-mid) 100%);
            border-radius:16px; overflow:hidden; box-shadow:0 20px 60px rgba(0,0,0,0.3);
            position:relative;
        }
        .id-card-header { background:var(--gold); padding:1rem 1.5rem; display:flex; align-items:center; gap:10px; }
        .id-card-header .school { color:var(--navy); font-weight:800; font-size:0.9rem; }
        .id-card-header .osis-label { color:var(--navy-mid); font-size:0.7rem; font-weight:600; }
        .id-card-body { padding:1.5rem; display:flex; gap:1rem; align-items:flex-start; }
        .id-card-photo { width:90px; height:90px; border-radius:10px; object-fit:cover; border:3px solid var(--gold); flex-shrink:0; background:rgba(255,255,255,0.1); display:flex; align-items:center; justify-content:center; color:rgba(255,255,255,0.4); font-size:2rem; }
        .id-card-info { flex:1; }
        .id-card-info .pos { color:var(--gold); font-size:0.75rem; font-weight:700; text-transform:uppercase; letter-spacing:1px; }
        .id-card-info .name { color:white; font-size:1.1rem; font-weight:800; margin-top:4px; line-height:1.2; }
        .id-card-info .school { color:rgba(255,255,255,0.6); font-size:0.75rem; margin-top:6px; }
        .id-card-footer { padding:0.75rem 1.5rem 1.25rem; display:flex; align-items:center; justify-content:space-between; border-top:1px solid rgba(255,255,255,0.1); }
        .id-card-footer .url { color:rgba(255,255,255,0.4); font-size:0.7rem; }
        .qr-box { width:70px; height:70px; background:white; border-radius:6px; padding:4px; display:flex; align-items:center; justify-content:center; }
        .qr-box img { width:100%; height:100%; }

        @media(max-width:1024px){ .stats-grid{grid-template-columns:repeat(2,1fr);} }
        @media(max-width:768px){ .sidebar{transform:translateX(-100%);} .topbar,.main-content{left:0;margin-left:0;} }
    </style>
    @yield('styles')
</head>
<body>
<aside class="sidebar">
    <div class="sidebar-header">
        <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">
            @php $currentLogo = \App\Models\Pengaturan::where('key', 'logo')->value('value'); @endphp
            @if(!empty($currentLogo))
                <img src="{{ asset('storage/'.$currentLogo) }}" alt="Logo" class="icon" style="background:transparent;object-fit:contain;padding:2px;">
            @else
                <div class="icon">O</div>
            @endif
            <div class="text">
                <div class="main">Admin Panel</div>
                <div class="sub">OSIS SMA</div>
            </div>
        </a>
    </div>
    <nav class="sidebar-nav">
        <div class="nav-group-label">Menu Utama</div>
        <div class="nav-item">
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <span class="icon"><i class="fas fa-tachometer-alt"></i></span> Dashboard
            </a>
        </div>
        <div class="nav-group-label">Konten</div>
        <div class="nav-item">
            <a href="{{ route('admin.kegiatan.index') }}" class="{{ request()->routeIs('admin.kegiatan*') ? 'active' : '' }}">
                <span class="icon"><i class="fas fa-calendar-alt"></i></span> Kegiatan
            </a>
        </div>
        <div class="nav-item">
            <a href="{{ route('admin.galeri.index') }}" class="{{ request()->routeIs('admin.galeri*') ? 'active' : '' }}">
                <span class="icon"><i class="fas fa-images"></i></span> Galeri
            </a>
        </div>
        <div class="nav-item">
            <a href="{{ route('admin.struktur.index') }}" class="{{ request()->routeIs('admin.struktur*') ? 'active' : '' }}">
                <span class="icon"><i class="fas fa-sitemap"></i></span> Struktur Organisasi
            </a>
        </div>
        <div class="nav-group-label">Fitur Khusus</div>
        <div class="nav-item">
            <a href="{{ route('admin.kartu-anggota.index') }}" class="{{ request()->routeIs('admin.kartu-anggota*') ? 'active' : '' }}">
                <span class="icon"><i class="fas fa-id-card"></i></span> Kartu Anggota
            </a>
        </div>
        @if(auth()->check() && auth()->user()->isAdmin())
        <div class="nav-group-label">Sistem</div>
        <div class="nav-item">
            <a href="{{ route('admin.pengaturan.index') }}" class="{{ request()->routeIs('admin.pengaturan*') ? 'active' : '' }}">
                <span class="icon"><i class="fas fa-cog"></i></span> Pengaturan
            </a>
        </div>
        <div class="nav-item">
            <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users*') ? 'active' : '' }}">
                <span class="icon"><i class="fas fa-users-cog"></i></span> Manajemen User
            </a>
        </div>
        @endif
    </nav>
    <div class="sidebar-footer">
        <div class="user-info">
            <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}</div>
            <div class="user-details">
                <div class="name">{{ auth()->user()->name ?? 'Admin' }}</div>
                <div class="role"><i class="fas fa-shield-alt"></i> {{ auth()->check() && auth()->user()->isAdmin() ? 'Administrator' : 'Admin Konten' }}</div>
            </div>
        </div>
        <form method="POST" action="{{ route('admin.logout') }}" style="margin-top:8px;">
            @csrf
            <button type="submit" style="width:100%;background:rgba(239,68,68,0.1);color:#ef4444;border:1px solid rgba(239,68,68,0.2);padding:8px;border-radius:8px;cursor:pointer;font-size:0.85rem;font-weight:600;display:flex;align-items:center;justify-content:center;gap:6px;">
                <i class="fas fa-sign-out-alt"></i> Logout
            </button>
        </form>
    </div>
</aside>

<header class="topbar">
    <div class="topbar-title">@yield('page-title', 'Dashboard')</div>
    <div class="topbar-actions">
        <a href="{{ route('home') }}" target="_blank" class="topbar-btn btn-gold">
            <i class="fas fa-external-link-alt"></i> Lihat Website
        </a>
    </div>
</header>

<main class="main-content">
    @if(session('success'))
        <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-error"><i class="fas fa-exclamation-circle"></i> {{ session('error') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-error">
            <i class="fas fa-exclamation-circle"></i>
            <ul style="list-style:none;padding:0;">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif

    @yield('content')
</main>
@yield('scripts')
</body>
</html>
