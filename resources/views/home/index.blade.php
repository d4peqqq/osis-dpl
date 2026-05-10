@extends('layouts.app')

@section('title', 'Beranda')

@section('styles')
<style>
/* ── HERO ── */
.hero {
    min-height: 100vh;
    background: linear-gradient(145deg, #020810 0%, #0a1628 40%, #112240 70%, #0e1d36 100%);
    position: relative; overflow: hidden;
    display: flex; align-items: center;
    padding: 0;
}

/* Particle canvas */
#heroCanvas { position: absolute; inset: 0; width: 100%; height: 100%; }

/* Glowing orbs */
.hero-orb {
    position: absolute; border-radius: 50%;
    filter: blur(80px); pointer-events: none;
}
.orb-1 {
    width: 500px; height: 500px;
    background: radial-gradient(circle, rgba(245,166,35,0.12), transparent 70%);
    top: -100px; right: -50px;
    animation: orbFloat 8s ease-in-out infinite;
}
.orb-2 {
    width: 350px; height: 350px;
    background: radial-gradient(circle, rgba(30,80,180,0.15), transparent 70%);
    bottom: -80px; left: 10%;
    animation: orbFloat 10s ease-in-out infinite reverse;
}
@keyframes orbFloat {
    0%, 100% { transform: translateY(0) scale(1); }
    50% { transform: translateY(-30px) scale(1.05); }
}

.hero-content {
    max-width: 1280px; margin: 0 auto; width: 100%;
    padding: 100px 2rem 80px;
    position: relative; z-index: 2;
}
.hero-grid {
    display: grid; grid-template-columns: 1fr 1fr;
    gap: 5rem; align-items: center;
}

/* Left: Text */
.hero-badge {
    display: inline-flex; align-items: center; gap: 9px;
    background: rgba(245,166,35,0.1);
    border: 1px solid rgba(245,166,35,0.28);
    color: var(--gold-light); padding: 8px 18px;
    border-radius: 30px; font-size: 0.8rem; font-weight: 700;
    letter-spacing: 0.08em; text-transform: uppercase;
    margin-bottom: 1.75rem;
    animation: fadeDown 0.7s ease 0.2s both;
}
.hero-badge i { color: var(--gold); animation: pulse 2s ease-in-out infinite; }
@keyframes pulse { 0%,100%{transform:scale(1)} 50%{transform:scale(1.25)} }

.hero-title {
    font-size: clamp(2.4rem, 5vw, 4rem);
    font-weight: 900; color: var(--white);
    line-height: 1.08; letter-spacing: -0.03em;
    margin-bottom: 1.25rem;
    animation: fadeDown 0.7s ease 0.35s both;
}
.hero-title .line-gold {
    color: var(--gold);
    border-right: 3px solid var(--gold);
    padding-right: 4px;
    animation: blink 0.85s step-end infinite;
}
@keyframes blink { 50% { border-color: transparent; } }

.hero-subtitle {
    color: rgba(255,255,255,0.62); font-size: 1.1rem; line-height: 1.8;
    margin-bottom: 2.25rem; max-width: 480px;
    animation: fadeDown 0.7s ease 0.5s both;
}
.hero-actions {
    display: flex; gap: 14px; flex-wrap: wrap;
    animation: fadeDown 0.7s ease 0.65s both;
}

/* Stats */
.hero-stats {
    display: flex; gap: 0; margin-top: 3.5rem;
    background: rgba(255,255,255,0.04);
    border: 1px solid rgba(255,255,255,0.08);
    border-radius: 16px; overflow: hidden;
    animation: fadeDown 0.7s ease 0.8s both;
}
.hero-stat {
    flex: 1; padding: 1.25rem 1rem; text-align: center;
    border-right: 1px solid rgba(255,255,255,0.08);
    position: relative;
}
.hero-stat:last-child { border-right: none; }
.stat-num {
    font-size: 2.2rem; font-weight: 900; color: var(--gold);
    line-height: 1; letter-spacing: -0.02em;
    display: block;
}
.stat-label { font-size: 0.75rem; color: rgba(255,255,255,0.5); margin-top: 5px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; }

/* Right: Visual */
.hero-visual {
    display: flex; align-items: center; justify-content: center;
    animation: fadeLeft 0.9s ease 0.4s both;
    position: relative;
}
@keyframes fadeLeft {
    from { opacity: 0; transform: translateX(50px); }
    to { opacity: 1; transform: translateX(0); }
}

.hero-orbit {
    position: relative; width: 380px; height: 380px;
}
.orbit-ring {
    position: absolute; border-radius: 50%;
    border: 1px solid rgba(245,166,35,0.18);
    inset: 0; animation: rotate 20s linear infinite;
}
.orbit-ring:nth-child(2) { inset: 30px; border-color: rgba(245,166,35,0.12); animation-duration: 15s; animation-direction: reverse; }
.orbit-ring::before {
    content: ''; position: absolute; top: -5px; left: 50%;
    width: 10px; height: 10px; border-radius: 50%;
    background: var(--gold);
    box-shadow: 0 0 10px var(--gold);
    transform: translateX(-50%);
}
@keyframes rotate { to { transform: rotate(360deg); } }

.orbit-center {
    position: absolute; inset: 60px;
    background: linear-gradient(145deg, var(--navy-light), #1a3a6b);
    border-radius: 50%;
    border: 3px solid rgba(245,166,35,0.35);
    box-shadow: 0 0 60px rgba(245,166,35,0.15), inset 0 0 40px rgba(245,166,35,0.05);
    display: flex; flex-direction: column; align-items: center; justify-content: center;
    gap: 8px;
}
.orbit-center .logo-wrap {
    width: 100px; height: 100px; border-radius: 50%;
    background: linear-gradient(135deg, var(--gold), var(--gold-dark));
    display: flex; align-items: center; justify-content: center;
    font-size: 2.8rem; font-weight: 900; color: var(--navy);
    box-shadow: 0 0 30px var(--gold-glow);
    animation: floatY 4s ease-in-out infinite;
}
@keyframes floatY { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-8px)} }
.orbit-center .oc-title { color: var(--gold); font-weight: 800; font-size: 0.95rem; text-align: center; }
.orbit-center .oc-sub { color: rgba(255,255,255,0.5); font-size: 0.78rem; text-align: center; }

/* Floating member chips */
.member-chip {
    position: absolute; background: rgba(10,22,40,0.92);
    border: 1px solid rgba(245,166,35,0.3);
    border-radius: 40px; padding: 8px 14px 8px 8px;
    display: flex; align-items: center; gap: 8px;
    backdrop-filter: blur(8px);
    white-space: nowrap;
    animation: chipFloat 5s ease-in-out infinite;
}
.member-chip:nth-child(4) { top: 20px; right: -30px; animation-delay: 0s; }
.member-chip:nth-child(5) { bottom: 60px; right: -40px; animation-delay: 1.5s; }
.member-chip:nth-child(6) { bottom: 10px; left: -20px; animation-delay: 0.8s; }
@keyframes chipFloat {
    0%,100% { transform: translateY(0); }
    50% { transform: translateY(-8px); }
}
.chip-avatar {
    width: 32px; height: 32px; border-radius: 50%;
    background: linear-gradient(135deg, var(--navy-mid), var(--gold-dark));
    display: flex; align-items: center; justify-content: center;
    color: var(--gold); font-size: 0.85rem;
    border: 2px solid var(--gold);
}
.chip-info .chip-name { color: white; font-size: 0.78rem; font-weight: 700; }
.chip-info .chip-pos { color: var(--gold); font-size: 0.68rem; }

@keyframes fadeDown {
    from { opacity: 0; transform: translateY(-20px); }
    to { opacity: 1; transform: translateY(0); }
}
@media (max-width: 900px) {
    .hero-grid { grid-template-columns: 1fr; gap: 3rem; }
    .hero-visual { display: none; }
    .hero-title { font-size: 2.4rem; }
}

/* ── WAVE DIVIDER ── */
.wave-divider {
    margin-top: -2px; line-height: 0; overflow: hidden;
}
.wave-divider svg { display: block; width: 100%; }

/* ── WELCOME SECTION ── */
.welcome-section { background: var(--gray-50); }
.welcome-grid {
    display: grid; grid-template-columns: 1fr 2fr;
    gap: 5rem; align-items: center;
}
.welcome-photo-wrap { text-align: center; }
.chairman-photo, .chairman-placeholder {
    width: 320px; height: 220px; border-radius: 20px;
    object-fit: cover; margin: 0 auto;
    border: none;
    box-shadow: 0 24px 60px rgba(0,0,0,0.15);
    display: block;
    background: linear-gradient(135deg, var(--navy-mid), var(--navy-light));
    position: relative;
}
.chairman-placeholder { display: flex; align-items: center; justify-content: center; color: var(--gold); font-size: 5rem; }
.chairman-frame {
    position: relative; display: inline-block;
}
.chairman-frame::before {
    content: ''; position: absolute;
    top: 14px; left: 14px; right: -14px; bottom: -14px;
    background: linear-gradient(135deg, var(--gold), var(--gold-dark));
    border-radius: 24px; z-index: 0; opacity: 0.35;
}
.chairman-frame > * { position: relative; z-index: 1; }
.chairman-badge {
    position: absolute; bottom: -18px; left: 50%; transform: translateX(-50%);
    background: linear-gradient(135deg, var(--gold), var(--gold-dark)); color: var(--navy);
    font-size: 0.82rem; font-weight: 800; padding: 8px 22px;
    border-radius: 30px; white-space: nowrap; z-index: 2;
    box-shadow: 0 6px 20px var(--gold-glow);
}
.chairman-name { font-weight: 800; color: var(--navy); margin-top: 2rem; font-size: 1.05rem; }
.welcome-text .quote-block {
    border-left: 4px solid var(--gold);
    padding: 1.25rem 1.5rem;
    background: rgba(245,166,35,0.05);
    border-radius: 0 12px 12px 0;
    margin: 1.5rem 0;
    font-style: italic; color: var(--gray-600); line-height: 1.85; font-size: 1.02rem;
}
@media (max-width: 768px) {
    .welcome-grid { grid-template-columns: 1fr; text-align: center; gap: 3rem; }
    .welcome-text .quote-block { text-align: left; }
    .chairman-frame::before { display: none; }
}

/* ── ACTIVITY SECTION ── */
.activity-section { background: white; }

/* ── GALLERY SECTION ── */
.gallery-section {
    background: linear-gradient(160deg, var(--navy) 0%, #0d1f3c 100%);
    position: relative; overflow: hidden;
}
.gallery-section::before {
    content: ''; position: absolute;
    top: 0; left: 0; right: 0;
    height: 80px;
    background: url("data:image/svg+xml,%3Csvg viewBox='0 0 1440 80' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M0,0 C360,80 1080,0 1440,0 L1440,0 L0,0 Z' fill='%23ffffff'/%3E%3C/svg%3E") no-repeat top / cover;
}
.gallery-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    grid-template-rows: repeat(2, 200px);
    gap: 12px;
}
.gallery-item {
    position: relative; border-radius: 14px; overflow: hidden; cursor: pointer;
}
.gallery-item:first-child {
    grid-row: span 2; grid-column: span 1;
}
.gallery-item img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s cubic-bezier(0.4,0,0.2,1); display: block; }
.gallery-item:hover img { transform: scale(1.08); }
.gallery-overlay {
    position: absolute; inset: 0;
    background: linear-gradient(to top, rgba(5,13,26,0.8) 0%, rgba(5,13,26,0.2) 50%, transparent 100%);
    opacity: 0; transition: opacity 0.35s; display: flex;
    flex-direction: column; justify-content: flex-end; padding: 1rem;
}
.gallery-item:hover .gallery-overlay { opacity: 1; }
.gallery-overlay span { color: white; font-size: 0.88rem; font-weight: 700; }
.gallery-empty {
    background: rgba(255,255,255,0.04);
    border: 1px dashed rgba(255,255,255,0.1);
    display: flex; align-items: center; justify-content: center;
    color: rgba(255,255,255,0.2); font-size: 1.5rem;
}
@media (max-width: 640px) {
    .gallery-grid { grid-template-columns: repeat(2,1fr); grid-template-rows: auto; }
    .gallery-item:first-child { grid-row: span 1; grid-column: span 2; }
}

/* ── STRUCTURE SECTION ── */
.structure-section { background: var(--gray-50); }
.profile-card-v2 {
    text-align: center; padding: 2rem 1.5rem 1.75rem;
    position: relative; overflow: hidden;
}
.profile-card-v2::before {
    content: ''; position: absolute; top: 0; left: 0; right: 0; height: 5px;
    background: linear-gradient(90deg, var(--gold), var(--gold-dark));
    transform: scaleX(0); transition: transform 0.3s;
}
.card:hover .profile-card-v2::before { transform: scaleX(1); }
.profile-img-v2 {
    width: 90px; height: 90px; border-radius: 50%;
    object-fit: cover; margin: 0 auto 0.75rem;
    border: 3px solid var(--gold);
    box-shadow: 0 0 0 5px rgba(245,166,35,0.1);
    display: flex; align-items: center; justify-content: center;
    background: linear-gradient(135deg, var(--navy-mid), var(--navy-light));
    color: var(--gold); font-size: 2.2rem;
    transition: transform 0.3s;
}
.card:hover .profile-img-v2 { transform: scale(1.06); }
</style>
@endsection

@section('content')
<!-- ── HERO ── -->
<section class="hero" id="hero">
    <canvas id="heroCanvas"></canvas>
    <div class="hero-orb orb-1"></div>
    <div class="hero-orb orb-2"></div>

    <div class="hero-content">
        <div class="hero-grid">
            <!-- Text -->
            <div>
                <div class="hero-badge">
                    <i class="fas fa-star"></i>
                    Organisasi Siswa Intra Sekolah
                </div>
                <h1 class="hero-title">
                    Selamat Datang di<br>
                    <span class="line-gold" id="typedText"></span>
                </h1>
                <div class="hero-subtitle" style="font-size:0.9rem; margin-bottom:2rem;">
                    @if(!empty($settings['visi_putra']) || !empty($settings['misi_putra']))
                        <div style="margin-bottom:12px;">
                            <span style="color:var(--gold); font-weight:bold;"><i class="fas fa-male"></i> OSIS Putra</span>
                            @if(!empty($settings['visi_putra']))<div style="margin-top:3px;"><strong>Visi:</strong> {{ $settings['visi_putra'] }}</div>@endif
                            @if(!empty($settings['misi_putra']))<div style="margin-top:2px;"><strong>Misi:</strong> {{ $settings['misi_putra'] }}</div>@endif
                        </div>
                    @endif
                    
                    @if(!empty($settings['visi_putri']) || !empty($settings['misi_putri']))
                        <div>
                            <span style="color:var(--gold); font-weight:bold;"><i class="fas fa-female"></i> OSIS Putri</span>
                            @if(!empty($settings['visi_putri']))<div style="margin-top:3px;"><strong>Visi:</strong> {{ $settings['visi_putri'] }}</div>@endif
                            @if(!empty($settings['misi_putri']))<div style="margin-top:2px;"><strong>Misi:</strong> {{ $settings['misi_putri'] }}</div>@endif
                        </div>
                    @endif
                    
                    @if(empty($settings['visi_putra']) && empty($settings['visi_putri']))
                        Bersama membangun generasi penerus bangsa yang berkarakter, berprestasi, dan berdedikasi tinggi.
                    @endif
                </div>
                <div class="hero-actions">
                    <a href="{{ route('struktur.index') }}" class="btn btn-primary">
                        <i class="fas fa-users"></i> Struktur Kami
                    </a>
                    <a href="{{ route('kegiatan.index') }}" class="btn btn-ghost">
                        <i class="fas fa-calendar-alt"></i> Kegiatan
                    </a>
                </div>
                <div class="hero-stats">
                    <div class="hero-stat">
                        <span class="stat-num counter" data-target="50">0</span>
                        <div class="stat-label">Anggota</div>
                    </div>
                    <div class="hero-stat">
                        <span class="stat-num counter" data-target="{{ $kegiatan->count() }}">0</span>
                        <div class="stat-label">Kegiatan</div>
                    </div>
                    <div class="hero-stat">
                        <span class="stat-num counter" data-target="{{ $galeri->count() }}">0</span>
                        <div class="stat-label">Dokumentasi</div>
                    </div>
                </div>
            </div>

            <!-- Visual -->
            <div class="hero-visual">
                <div class="hero-orbit">
                    <div class="orbit-ring"></div>
                    <div class="orbit-ring"></div>
                    <div class="orbit-center">
                        @if(!empty($settings['logo']))
                            <div class="logo-wrap"><img src="{{ asset('storage/'.$settings['logo']) }}" alt="Logo" style="width:80%;height:80%;object-fit:contain;border-radius:50%;"></div>
                        @else
                            <div class="logo-wrap">O</div>
                        @endif
                        <div class="oc-title">{{ $settings['nama_osis'] ?? 'OSIS SMA' }}</div>
                        <div class="oc-sub">{{ $settings['nama_sekolah'] ?? 'SMA' }}</div>
                    </div>
                    @foreach($struktur->take(3) as $i => $m)
                    <div class="member-chip">
                        <div class="chip-avatar"><i class="fas fa-user"></i></div>
                        <div class="chip-info">
                            <div class="chip-name">{{ Str::words($m->name, 1, '') }}</div>
                            <div class="chip-pos">{{ Str::limit($m->position, 18) }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ── WELCOME / CHAIRMAN ── -->
<section class="section welcome-section">
    <div class="container">
        <div class="welcome-grid">
            <div class="welcome-photo-wrap reveal">
                <div class="chairman-frame" style="display:inline-block;">
                    @if(!empty($settings['foto_ketua']))
                        <img src="{{ asset('storage/'.$settings['foto_ketua']) }}" alt="{{ $settings['nama_ketua'] ?? 'Ketua OSIS' }}" class="chairman-photo">
                    @else
                        <div class="chairman-placeholder" style="width:240px;height:240px;border-radius:24px;display:flex;align-items:center;justify-content:center;"><i class="fas fa-user-tie"></i></div>
                    @endif
                    <div class="chairman-badge"><i class="fas fa-crown"></i> {{ $settings['jabatan_ketua'] ?? 'Ketua OSIS' }}</div>
                </div>
                <div class="chairman-name" style="margin-top:2.5rem;">{{ $settings['nama_ketua'] ?? 'Nama Ketua' }}</div>
            </div>
            <div class="welcome-text reveal reveal-delay-2">
                <div class="section-title" style="text-align:left;margin-bottom:1.5rem;">
                    <div class="section-label"><i class="fas fa-quote-left"></i> Sambutan</div>
                    <h2 style="font-size:1.75rem;">Kata Sambutan<br><span class="highlight">OSIS SMA Insan Cendekia Al Kausar</span></h2>
                </div>
                <p style="color:var(--gray-600);line-height:1.85;font-size:1rem;">{{ $settings['kata_sambutan'] ?? '' }}</p>
                <div class="quote-block">
                    "{{ $settings['sambutan_ketua'] ?? 'Mari bersatu dan bergerak maju bersama OSIS!' }}"
                </div>
                <a href="{{ route('struktur.index') }}" class="btn btn-primary" style="margin-top:0.5rem;">
                    <i class="fas fa-users"></i> Lihat Struktur Lengkap
                </a>
            </div>
        </div>
    </div>
</section>

<!-- ── LATEST ACTIVITIES ── -->
@if($kegiatan->count() > 0)
<section class="section activity-section">
    <div class="container">
        <div class="section-title reveal">
            <div class="section-label"><i class="fas fa-calendar-check"></i> Aktivitas</div>
            <h2>Kegiatan <span class="highlight">Terbaru</span></h2>
            <p>Program dan kegiatan OSIS yang telah kami laksanakan</p>
        </div>
        <div class="grid-3">
            @foreach($kegiatan as $i => $k)
            <div class="card reveal reveal-delay-{{ ($i % 3) + 1 }}">
                @if($k->photo)
                    <img class="card-img" src="{{ $k->photo_url }}" alt="{{ $k->title }}">
                @else
                    <div class="card-img" style="background:linear-gradient(135deg,var(--navy-mid),var(--navy));display:flex;align-items:center;justify-content:center;">
                        <i class="fas fa-calendar-check" style="font-size:3rem;color:rgba(245,166,35,0.25);"></i>
                    </div>
                @endif
                <div class="card-body">
                    <span class="card-badge"><i class="fas fa-calendar"></i> {{ $k->date->format('d M Y') }}</span>
                    <div class="card-title">{{ $k->title }}</div>
                    <div class="card-text">{{ Str::limit(strip_tags($k->body), 110) }}</div>
                    <a href="{{ route('kegiatan.show', $k->id) }}" class="card-footer-link">
                        Baca Selengkapnya <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
        <div style="text-align:center;margin-top:3rem;" class="reveal">
            <a href="{{ route('kegiatan.index') }}" class="btn btn-primary">
                Lihat Semua Kegiatan <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>
</section>
@endif

<!-- ── GALLERY PREVIEW ── -->
@if($galeri->count() > 0)
<section class="section gallery-section" style="padding-top:120px;">
    <div class="container">
        <div class="section-title dark reveal">
            <div class="section-label"><i class="fas fa-camera"></i> Dokumentasi</div>
            <h2>Galeri <span style="color:var(--gold);">Foto</span></h2>
            <p>Momen berharga kegiatan OSIS kami</p>
        </div>
        <div class="gallery-grid reveal">
            @foreach($galeri->take(6) as $foto)
            <div class="gallery-item">
                <img src="{{ $foto->photo_url }}" alt="{{ $foto->title }}" loading="lazy">
                <div class="gallery-overlay"><span>{{ $foto->title }}</span></div>
            </div>
            @endforeach
            @if($galeri->count() < 6)
                @for($i = 0; $i < 6 - $galeri->count(); $i++)
                <div class="gallery-item gallery-empty"><i class="fas fa-image"></i></div>
                @endfor
            @endif
        </div>
        <div style="text-align:center;margin-top:3rem;" class="reveal">
            <a href="{{ route('galeri.index') }}" class="btn btn-primary">
                <i class="fas fa-images"></i> Lihat Galeri Lengkap
            </a>
        </div>
    </div>
</section>
@endif

<!-- ── STRUCTURE PREVIEW ── -->
@if($struktur->count() > 0)
<section class="section structure-section">
    <div class="container">
        <div class="section-title reveal">
            <div class="section-label"><i class="fas fa-sitemap"></i> Organisasi</div>
            <h2>Struktur <span class="highlight">Kami</span></h2>
            <p>Pengurus OSIS yang berdedikasi untuk kemajuan sekolah</p>
        </div>
        <div class="grid-4">
            @foreach($struktur->take(4) as $i => $m)
            <div class="card reveal reveal-delay-{{ $i + 1 }}">
                <div class="profile-card-v2">
                    @if($m->photo)
                        <img src="{{ $m->photo_url }}" alt="{{ $m->name }}" class="profile-img-v2" style="display:block;">
                    @else
                        <div class="profile-img-v2"><i class="fas fa-user"></i></div>
                    @endif
                    <div class="profile-name" style="margin-top:.5rem;">{{ $m->name }}</div>
                    <div class="profile-pos">{{ $m->position }}</div>
                    <a href="{{ route('anggota.show', $m->slug) }}" class="btn btn-outline" style="margin-top:1.1rem;padding:9px 18px;font-size:0.84rem;">
                        <i class="fas fa-id-card"></i> Profil
                    </a>
                </div>
            </div>
            @endforeach
        </div>
        <div style="text-align:center;margin-top:3rem;" class="reveal">
            <a href="{{ route('struktur.index') }}" class="btn btn-primary">
                Lihat Struktur Lengkap <i class="fas fa-sitemap"></i>
            </a>
        </div>
    </div>
</section>
@endif
@endsection

@section('scripts')
<script>
// ── Typing effect ──
(function() {
    const text = @json($settings['nama_osis'] ?? 'OSIS SMA');
    const el = document.getElementById('typedText');
    let i = 0;
    function type() {
        if (i <= text.length) {
            el.textContent = text.slice(0, i++);
            setTimeout(type, i === 1 ? 600 : 80);
        }
    }
    setTimeout(type, 900);
})();

// ── Counter animation ──
function animateCounter(el) {
    const target = parseInt(el.dataset.target) || 0;
    const duration = 1800;
    const step = target / (duration / 16);
    let current = 0;
    const timer = setInterval(() => {
        current = Math.min(current + step, target);
        el.textContent = Math.floor(current) + '+';
        if (current >= target) clearInterval(timer);
    }, 16);
}
const counterObs = new IntersectionObserver((entries) => {
    entries.forEach(e => {
        if (e.isIntersecting) {
            animateCounter(e.target);
            counterObs.unobserve(e.target);
        }
    });
}, { threshold: 0.5 });
document.querySelectorAll('.counter').forEach(el => counterObs.observe(el));

// ── Particle canvas ──
(function() {
    const canvas = document.getElementById('heroCanvas');
    if (!canvas) return;
    const ctx = canvas.getContext('2d');
    let W, H, particles = [];

    function resize() {
        W = canvas.width = canvas.offsetWidth;
        H = canvas.height = canvas.offsetHeight;
    }
    resize();
    window.addEventListener('resize', resize);

    const N = 60;
    for (let i = 0; i < N; i++) {
        particles.push({
            x: Math.random() * W,
            y: Math.random() * H,
            r: Math.random() * 1.5 + 0.3,
            dx: (Math.random() - 0.5) * 0.4,
            dy: (Math.random() - 0.5) * 0.4,
            o: Math.random() * 0.5 + 0.15,
        });
    }

    function draw() {
        ctx.clearRect(0, 0, W, H);
        particles.forEach(p => {
            p.x += p.dx; p.y += p.dy;
            if (p.x < 0) p.x = W; if (p.x > W) p.x = 0;
            if (p.y < 0) p.y = H; if (p.y > H) p.y = 0;

            ctx.beginPath();
            ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2);
            ctx.fillStyle = `rgba(245,166,35,${p.o})`;
            ctx.fill();
        });
        // Draw connections
        for (let i = 0; i < particles.length; i++) {
            for (let j = i + 1; j < particles.length; j++) {
                const dx = particles[i].x - particles[j].x;
                const dy = particles[i].y - particles[j].y;
                const dist = Math.sqrt(dx*dx + dy*dy);
                if (dist < 120) {
                    ctx.beginPath();
                    ctx.strokeStyle = `rgba(245,166,35,${0.07 * (1 - dist/120)})`;
                    ctx.lineWidth = 0.5;
                    ctx.moveTo(particles[i].x, particles[i].y);
                    ctx.lineTo(particles[j].x, particles[j].y);
                    ctx.stroke();
                }
            }
        }
        requestAnimationFrame(draw);
    }
    draw();
})();
</script>
@endsection
