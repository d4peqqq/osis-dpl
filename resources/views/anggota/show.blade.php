@extends('layouts.app')
@section('title', $anggota->name . ' — ' . $anggota->position)

@section('styles')
<style>
.profile-hero {
    background: linear-gradient(145deg, var(--navy), #1a3a6b);
    min-height: 300px; position: relative;
    display: flex; align-items: flex-end;
    overflow: hidden;
}
.profile-hero::before {
    content: ''; position: absolute; inset: 0;
    background: radial-gradient(ellipse at 60% 40%, rgba(245,166,35,0.1), transparent 65%);
}
.profile-hero-inner { max-width: 760px; margin: 0 auto; width: 100%; padding: 0 2rem 100px; position: relative; z-index: 1; }

.profile-card-main {
    max-width: 760px; margin: -80px auto 0; position: relative; z-index: 2;
    padding: 0 2rem 3rem;
}
.profile-photo-wrap {
    display: flex; justify-content: center; margin-bottom: 1.5rem;
}
.profile-photo-main, .profile-avatar-main {
    width: 140px; height: 140px; border-radius: 50%;
    object-fit: cover; display: block;
    border: 5px solid white;
    box-shadow: 0 12px 40px rgba(0,0,0,0.25), 0 0 0 6px rgba(245,166,35,0.2);
    background: linear-gradient(135deg, var(--navy-mid), var(--navy-light));
    display: flex; align-items: center; justify-content: center;
    color: var(--gold); font-size: 3.5rem;
}

.info-grid {
    display: grid; grid-template-columns: 1fr 1fr; gap: 10px;
    margin-top: 1.5rem;
}
.info-row {
    display: flex; gap: 12px; align-items: center;
    padding: 1rem; background: var(--gray-50);
    border-radius: 12px; border: 1px solid var(--gray-200);
}
.info-row i { color: var(--gold); width: 18px; text-align: center; flex-shrink: 0; }
.info-row span { color: var(--text); font-size: 0.9rem; font-weight: 600; }
@media (max-width: 640px) { .info-grid { grid-template-columns: 1fr; } }
</style>
@endsection

@section('content')
<div class="page-offset">
    <!-- Profile Hero Banner -->
    <div class="profile-hero">
        <div class="profile-hero-inner">
            <div class="hero-breadcrumb" style="margin-bottom:0;justify-content:flex-start;">
                <a href="{{ route('home') }}">Beranda</a>
                <span><i class="fas fa-chevron-right" style="font-size:0.7em;"></i></span>
                <a href="{{ route('struktur.index') }}">Struktur</a>
                <span><i class="fas fa-chevron-right" style="font-size:0.7em;"></i></span>
                <span style="color:var(--gold);">Profil</span>
            </div>
        </div>
    </div>

    <!-- Profile Card -->
    <div class="profile-card-main">
        <div class="card" style="border-radius:24px;overflow:hidden;">
            <div style="background:linear-gradient(135deg,var(--navy),var(--navy-mid));height:12px;"></div>
            <div style="padding:2rem;text-align:center;">
                <div class="profile-photo-wrap">
                    @if($anggota->photo)
                        <img src="{{ $anggota->photo_url }}" alt="{{ $anggota->name }}" class="profile-photo-main" style="display:block;">
                    @else
                        <div class="profile-avatar-main"><i class="fas fa-user"></i></div>
                    @endif
                </div>

                <div style="display:inline-flex;align-items:center;gap:6px;background:linear-gradient(135deg,var(--gold),var(--gold-dark));color:var(--navy);font-size:0.82rem;font-weight:800;padding:6px 18px;border-radius:24px;box-shadow:0 4px 14px var(--gold-glow);margin-bottom:1rem;">
                    <i class="fas fa-id-badge"></i> {{ $anggota->position }}
                </div>

                <h1 style="font-size:1.9rem;font-weight:900;color:var(--navy);letter-spacing:-0.02em;">{{ $anggota->name }}</h1>

                @if($anggota->description)
                <p style="color:var(--gray-600);line-height:1.85;margin-top:1rem;font-size:0.98rem;max-width:560px;margin-left:auto;margin-right:auto;">{{ $anggota->description }}</p>
                @endif

                <div class="info-grid" style="text-align:left;">
                    <div class="info-row">
                        <i class="fas fa-user-tag"></i>
                        <span>{{ $anggota->position }}</span>
                    </div>
                    <div class="info-row">
                        <i class="fas fa-school"></i>
                        <span>{{ $settings['nama_sekolah'] ?? 'SMA' }}</span>
                    </div>
                    <div class="info-row">
                        <i class="fas fa-users"></i>
                        <span>{{ $settings['nama_osis'] ?? 'OSIS SMA' }}</span>
                    </div>
                    <div class="info-row">
                        <i class="fas fa-star"></i>
                        <span>Pengurus Aktif</span>
                    </div>
                </div>

                <div style="margin-top:2rem;display:flex;gap:12px;justify-content:center;flex-wrap:wrap;">
                    <a href="{{ route('struktur.index') }}" class="btn btn-primary">
                        <i class="fas fa-sitemap"></i> Lihat Struktur
                    </a>
                    <a href="{{ route('home') }}" class="btn btn-outline">
                        <i class="fas fa-home"></i> Beranda
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div style="height:3rem;"></div>
</div>
@endsection
