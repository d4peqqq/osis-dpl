@extends('layouts.app')
@section('title', 'Struktur Organisasi')

@section('styles')
<style>
/* ── Gender Tab Navigation ── */
.gender-nav {
    display: flex; gap: 0; justify-content: center; margin: 0 auto 2.5rem;
    background: white; border-radius: 50px; padding: 6px;
    box-shadow: 0 4px 24px rgba(0,0,0,0.1); width: fit-content;
    border: 1px solid var(--gray-200);
}
.gender-nav-btn {
    padding: 12px 36px; border-radius: 40px; font-size: 0.9rem; font-weight: 800;
    cursor: pointer; border: none; background: transparent;
    transition: all .3s cubic-bezier(0.4,0,0.2,1); color: var(--gray-600);
    letter-spacing: 0.02em; display: flex; align-items: center; gap: 8px;
}
.gender-nav-btn.active-putra {
    background: linear-gradient(135deg, #1e40af, #3b82f6);
    color: white; box-shadow: 0 6px 20px rgba(59,130,246,0.4);
    transform: scale(1.03);
}
.gender-nav-btn.active-putri {
    background: linear-gradient(135deg, #9d174d, #ec4899);
    color: white; box-shadow: 0 6px 20px rgba(236,72,153,0.4);
    transform: scale(1.03);
}

/* ── Gender Section Panels ── */
.gender-panel { animation: fadeInUp .4s ease; }
@keyframes fadeInUp {
    from { opacity:0; transform: translateY(20px); }
    to   { opacity:1; transform: translateY(0); }
}

/* ── Ketua Hero ── */
.ketua-hero {
    border-radius: 24px; padding: 3.5rem 2rem;
    text-align: center; color: white; position: relative; overflow: hidden;
    display: flex; flex-direction: column; align-items: center;
    max-width: 440px; margin: 0 auto 3rem;
    box-shadow: 0 24px 60px rgba(0,0,0,0.2);
}
.ketua-hero.putra {
    background: linear-gradient(145deg, #1e3a8a 0%, #1d4ed8 60%, #2563eb 100%);
}
.ketua-hero.putri {
    background: linear-gradient(145deg, #831843 0%, #be185d 60%, #ec4899 100%);
}
.ketua-hero::before {
    content: ''; position: absolute; top: -60px; right: -60px;
    width: 220px; height: 220px;
    background: radial-gradient(circle, rgba(255,255,255,0.15), transparent 70%);
    border-radius: 50%;
}
.ketua-hero::after {
    content: ''; position: absolute; bottom: -40px; left: -40px;
    width: 160px; height: 160px;
    background: radial-gradient(circle, rgba(255,255,255,0.08), transparent 70%);
    border-radius: 50%;
}
.ketua-photo-frame { position: relative; margin-bottom: 2rem; z-index: 2; }
.ketua-photo, .ketua-placeholder {
    width: 150px; height: 150px; border-radius: 50%;
    object-fit: cover; display: block; margin: 0 auto;
    box-shadow: 0 0 0 8px rgba(255,255,255,0.15), 0 16px 40px rgba(0,0,0,0.3);
    background: rgba(255,255,255,0.1);
}
.ketua-hero.putra .ketua-photo  { border: 5px solid #93c5fd; }
.ketua-hero.putri .ketua-photo  { border: 5px solid #f9a8d4; }
.ketua-placeholder { display: flex; align-items: center; justify-content: center; font-size: 4rem; }
.ketua-crown {
    position: absolute; top: -16px; left: 50%; transform: translateX(-50%);
    border-radius: 30px; padding: 5px 16px;
    font-size: 0.75rem; font-weight: 800; letter-spacing: 0.04em;
    display: flex; align-items: center; gap: 6px;
    white-space: nowrap;
}
.ketua-hero.putra .ketua-crown  { background: linear-gradient(135deg,#93c5fd,#3b82f6); color:#1e3a8a; box-shadow:0 4px 14px rgba(59,130,246,0.5); }
.ketua-hero.putri .ketua-crown  { background: linear-gradient(135deg,#f9a8d4,#ec4899); color:#831843; box-shadow:0 4px 14px rgba(236,72,153,0.5); }
.ketua-pos-badge {
    position: absolute; bottom: -14px; left: 50%; transform: translateX(-50%);
    border-radius: 30px; padding: 6px 22px;
    font-size: 0.82rem; font-weight: 800; white-space: nowrap;
    border: 3px solid rgba(255,255,255,0.3);
}
.ketua-hero.putra .ketua-pos-badge { background: linear-gradient(90deg,#93c5fd,#3b82f6); color:#1e3a8a; box-shadow:0 6px 18px rgba(59,130,246,0.4); }
.ketua-hero.putri .ketua-pos-badge { background: linear-gradient(90deg,#f9a8d4,#ec4899); color:#831843; box-shadow:0 6px 18px rgba(236,72,153,0.4); }
.ketua-name { font-size: 1.7rem; font-weight: 900; z-index: 2; letter-spacing: -0.02em; }
.ketua-desc { opacity: 0.75; font-size: 0.9rem; margin-top: 0.5rem; z-index: 2; max-width: 320px; }

/* ── Section divider ── */
.org-divider { display: flex; align-items: center; gap: 1.5rem; margin: 2.5rem 0 2rem; }
.org-divider-line { flex: 1; height: 1px; }
.org-divider-line.putra { background: linear-gradient(90deg, transparent, #93c5fd, transparent); }
.org-divider-line.putri { background: linear-gradient(90deg, transparent, #f9a8d4, transparent); }
.org-divider-label {
    display: flex; align-items: center; gap: 8px;
    padding: 8px 20px; border-radius: 30px;
    font-size: 0.82rem; font-weight: 800; letter-spacing: 0.05em;
    white-space: nowrap; text-transform: uppercase;
    box-shadow: 0 4px 16px rgba(0,0,0,0.12);
}
.org-divider-label.putra { background: linear-gradient(135deg,#1e40af,#3b82f6); color: white; }
.org-divider-label.putri { background: linear-gradient(135deg,#9d174d,#ec4899); color: white; }

/* ── Member cards ── */
.member-card { text-align: center; padding: 2rem 1.25rem 1.75rem; position: relative; display: flex; flex-direction: column; align-items: center; height: 100%; }
.member-card::before {
    content: ''; position: absolute; top: 0; left: 0; right: 0; height: 4px;
    opacity: 0; transition: opacity 0.3s; border-radius: 4px 4px 0 0;
}
.member-card.putra::before { background: linear-gradient(90deg, #3b82f6, #93c5fd); }
.member-card.putri::before { background: linear-gradient(90deg, #ec4899, #f9a8d4); }
.card:hover .member-card::before { opacity: 1; }
.member-photo, .member-placeholder {
    width: 100px; height: 100px; border-radius: 50%;
    object-fit: cover; margin: 0 auto 0.75rem;
    display: flex; align-items: center; justify-content: center;
    font-size: 2.5rem;
    transition: transform 0.35s cubic-bezier(0.4,0,0.2,1);
}
.member-card.putra .member-photo, .member-card.putra .member-placeholder {
    border: 3.5px solid #3b82f6; box-shadow: 0 0 0 5px rgba(59,130,246,0.12);
    background: linear-gradient(135deg, #dbeafe, #eff6ff);
    color: #1e40af;
}
.member-card.putri .member-photo, .member-card.putri .member-placeholder {
    border: 3.5px solid #ec4899; box-shadow: 0 0 0 5px rgba(236,72,153,0.12);
    background: linear-gradient(135deg, #fce7f3, #fdf2f8);
    color: #be185d;
}
.card:hover .member-photo, .card:hover .member-placeholder { transform: scale(1.06); }
.member-name { font-size: 1rem; font-weight: 800; color: var(--navy); }
.member-pos {
    font-size: 0.78rem; font-weight: 700; color: white;
    padding: 4px 14px; border-radius: 20px; display: inline-block; margin-top: 6px; margin-bottom: 1.25rem;
}
.member-card.putra .member-pos { background: linear-gradient(135deg, #1e40af, #3b82f6); }
.member-card.putri .member-pos { background: linear-gradient(135deg, #9d174d, #ec4899); }

/* ── Big section header ── */
.gender-section-header {
    display: flex; align-items: center; gap: 1rem; margin-bottom: 2rem; padding: 1.25rem 1.75rem;
    border-radius: 16px; color: white;
}
.gender-section-header.putra { background: linear-gradient(135deg, #1e3a8a, #2563eb); box-shadow: 0 8px 24px rgba(30,64,175,0.3); }
.gender-section-header.putri { background: linear-gradient(135deg, #831843, #db2777); box-shadow: 0 8px 24px rgba(131,24,67,0.3); }
.gender-section-header .section-icon { font-size: 2.5rem; }
.gender-section-header h2 { font-size: 1.5rem; font-weight: 900; margin: 0; }
.gender-section-header p  { margin: 0; opacity: 0.8; font-size: 0.88rem; }
</style>
@endsection

@section('content')
<div class="page-offset">
    <!-- Page Hero -->
    <div class="page-hero">
        <div class="hero-breadcrumb">
            <a href="{{ route('home') }}">Beranda</a>
            <span><i class="fas fa-chevron-right" style="font-size:0.7em;"></i></span>
            <span style="color:var(--gold);">Struktur</span>
        </div>
        <h1><i class="fas fa-sitemap" style="font-size:0.75em;margin-right:12px;"></i>Struktur Organisasi</h1>
        <p>Pengurus {{ $settings['nama_osis'] ?? 'OSIS' }} periode aktif</p>

        {{-- Gender Navigation --}}
        <div class="gender-nav" style="margin-top:1.5rem; position:relative; z-index:10;">
            <button class="gender-nav-btn {{ request('gender') == 'putri' ? '' : 'active-putra' }}" id="btnPutra" onclick="switchGender('putra')">
                🧑 Pengurus Putra
            </button>
            <button class="gender-nav-btn {{ request('gender') == 'putri' ? 'active-putri' : '' }}" id="btnPutri" onclick="switchGender('putri')">
                👩 Pengurus Putri
            </button>
        </div>
    </div>

    <section class="section" style="background:var(--gray-50);">
        <div class="container">

            {{-- ════════════════════════════════
                 PANEL PUTRA (biru)
                 ════════════════════════════════ --}}
            <div id="panelPutra" class="gender-panel" style="{{ request('gender') == 'putri' ? 'display:none;' : '' }}">
                {{-- Section header --}}
                <div class="gender-section-header putra reveal">
                    <div class="section-icon">🧑</div>
                    <div>
                        <h2>Pengurus Putra</h2>
                        <p>Jajaran pengurus OSIS putra periode aktif</p>
                    </div>
                </div>

                {{-- Ketua Putra --}}
                @if($ketuaPutra)
                <div class="reveal">
                    <div class="ketua-hero putra">
                        <div class="ketua-photo-frame">
                            <div class="ketua-crown"><i class="fas fa-crown"></i> Ketua OSIS Putra</div>
                            @if($ketuaPutra->photo)
                                <img class="ketua-photo" src="{{ $ketuaPutra->photo_url }}" alt="{{ $ketuaPutra->name }}">
                            @else
                                <div class="ketua-placeholder">🧑</div>
                            @endif
                            <div class="ketua-pos-badge">{{ $ketuaPutra->position }}</div>
                        </div>
                        <div class="ketua-name" style="margin-top:1rem;">{{ $ketuaPutra->name }}</div>
                        @if($ketuaPutra->description)<p class="ketua-desc">{{ $ketuaPutra->description }}</p>@endif
                        <a href="{{ route('anggota.show', $ketuaPutra->slug) }}" class="btn" style="margin-top:1.5rem;z-index:2;background:rgba(255,255,255,0.2);color:white;border:2px solid rgba(255,255,255,0.4);border-radius:30px;padding:10px 24px;font-weight:700;text-decoration:none;transition:all .2s;">
                            <i class="fas fa-id-card"></i> Lihat Profil
                        </a>
                    </div>
                </div>
                @endif

                {{-- Wakil Ketua Putra --}}
                @if($wakilPutra)
                <div class="org-divider reveal">
                    <div class="org-divider-line putra"></div>
                    <div class="org-divider-label putra"><i class="fas fa-user-tie"></i> Wakil Ketua Putra</div>
                    <div class="org-divider-line putra"></div>
                </div>
                <div style="max-width:280px;margin:0 auto 1rem;" class="reveal">
                    <div class="card">
                        <div class="member-card putra">
                            @if($wakilPutra->photo)
                                <img class="member-photo" src="{{ $wakilPutra->photo_url }}" alt="{{ $wakilPutra->name }}" style="display:block;">
                            @else
                                <div class="member-placeholder">🧑</div>
                            @endif
                            <div class="member-name">{{ $wakilPutra->name }}</div>
                            <div class="member-pos">{{ $wakilPutra->position }}</div>
                            <a href="{{ route('anggota.show', $wakilPutra->slug) }}" class="btn btn-outline" style="margin-top:auto;padding:9px 18px;font-size:0.84rem;">
                                <i class="fas fa-id-card"></i> Profil
                            </a>
                        </div>
                    </div>
                </div>
                @endif

                {{-- Pengurus Putra --}}
                @if($anggotaPutra->count() > 0)
                <div class="org-divider reveal">
                    <div class="org-divider-line putra"></div>
                    <div class="org-divider-label putra"><i class="fas fa-users"></i> Pengurus Putra</div>
                    <div class="org-divider-line putra"></div>
                </div>
                <div class="grid-4">
                    @foreach($anggotaPutra as $i => $m)
                    <div class="card reveal reveal-delay-{{ ($i % 4) + 1 }}">
                        <div class="member-card putra">
                            @if($m->photo)
                                <img class="member-photo" src="{{ $m->photo_url }}" alt="{{ $m->name }}" style="display:block;">
                            @else
                                <div class="member-placeholder">🧑</div>
                            @endif
                            <div class="member-name">{{ $m->name }}</div>
                            <div class="member-pos">{{ $m->position }}</div>
                            <a href="{{ route('anggota.show', $m->slug) }}" class="btn btn-outline" style="margin-top:auto;padding:9px 18px;font-size:0.84rem;">
                                <i class="fas fa-id-card"></i> Profil
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif

                @if(!$ketuaPutra && !$wakilPutra && $anggotaPutra->count() === 0)
                <div style="text-align:center;padding:3rem;color:var(--gray-600);">
                    <i class="fas fa-user-slash" style="font-size:2.5rem;margin-bottom:1rem;display:block;opacity:0.4;"></i>
                    Belum ada pengurus putra yang ditambahkan.
                </div>
                @endif
            </div>

            {{-- ════════════════════════════════
                 PANEL PUTRI (pink/rose)
                 ════════════════════════════════ --}}
            <div id="panelPutri" class="gender-panel" style="{{ request('gender') == 'putri' ? '' : 'display:none;' }}">
                {{-- Section header --}}
                <div class="gender-section-header putri reveal">
                    <div class="section-icon">👩</div>
                    <div>
                        <h2>Pengurus Putri</h2>
                        <p>Jajaran pengurus OSIS putri periode aktif</p>
                    </div>
                </div>

                {{-- Ketua Putri --}}
                @if($ketuaPutri)
                <div class="reveal">
                    <div class="ketua-hero putri">
                        <div class="ketua-photo-frame">
                            <div class="ketua-crown"><i class="fas fa-crown"></i> Ketua OSIS Putri</div>
                            @if($ketuaPutri->photo)
                                <img class="ketua-photo" src="{{ $ketuaPutri->photo_url }}" alt="{{ $ketuaPutri->name }}">
                            @else
                                <div class="ketua-placeholder">👩</div>
                            @endif
                            <div class="ketua-pos-badge">{{ $ketuaPutri->position }}</div>
                        </div>
                        <div class="ketua-name" style="margin-top:1rem;">{{ $ketuaPutri->name }}</div>
                        @if($ketuaPutri->description)<p class="ketua-desc">{{ $ketuaPutri->description }}</p>@endif
                        <a href="{{ route('anggota.show', $ketuaPutri->slug) }}" class="btn" style="margin-top:1.5rem;z-index:2;background:rgba(255,255,255,0.2);color:white;border:2px solid rgba(255,255,255,0.4);border-radius:30px;padding:10px 24px;font-weight:700;text-decoration:none;transition:all .2s;">
                            <i class="fas fa-id-card"></i> Lihat Profil
                        </a>
                    </div>
                </div>
                @endif

                {{-- Wakil Ketua Putri --}}
                @if($wakilPutri)
                <div class="org-divider reveal">
                    <div class="org-divider-line putri"></div>
                    <div class="org-divider-label putri"><i class="fas fa-user-tie"></i> Wakil Ketua Putri</div>
                    <div class="org-divider-line putri"></div>
                </div>
                <div style="max-width:280px;margin:0 auto 1rem;" class="reveal">
                    <div class="card">
                        <div class="member-card putri">
                            @if($wakilPutri->photo)
                                <img class="member-photo" src="{{ $wakilPutri->photo_url }}" alt="{{ $wakilPutri->name }}" style="display:block;">
                            @else
                                <div class="member-placeholder">👩</div>
                            @endif
                            <div class="member-name">{{ $wakilPutri->name }}</div>
                            <div class="member-pos">{{ $wakilPutri->position }}</div>
                            <a href="{{ route('anggota.show', $wakilPutri->slug) }}" class="btn btn-outline" style="margin-top:auto;padding:9px 18px;font-size:0.84rem;">
                                <i class="fas fa-id-card"></i> Profil
                            </a>
                        </div>
                    </div>
                </div>
                @endif

                {{-- Pengurus Putri --}}
                @if($anggotaPutri->count() > 0)
                <div class="org-divider reveal">
                    <div class="org-divider-line putri"></div>
                    <div class="org-divider-label putri"><i class="fas fa-users"></i> Pengurus Putri</div>
                    <div class="org-divider-line putri"></div>
                </div>
                <div class="grid-4">
                    @foreach($anggotaPutri as $i => $m)
                    <div class="card reveal reveal-delay-{{ ($i % 4) + 1 }}">
                        <div class="member-card putri">
                            @if($m->photo)
                                <img class="member-photo" src="{{ $m->photo_url }}" alt="{{ $m->name }}" style="display:block;">
                            @else
                                <div class="member-placeholder">👩</div>
                            @endif
                            <div class="member-name">{{ $m->name }}</div>
                            <div class="member-pos">{{ $m->position }}</div>
                            <a href="{{ route('anggota.show', $m->slug) }}" class="btn btn-outline" style="margin-top:auto;padding:9px 18px;font-size:0.84rem;">
                                <i class="fas fa-id-card"></i> Profil
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif

                @if(!$ketuaPutri && !$wakilPutri && $anggotaPutri->count() === 0)
                <div style="text-align:center;padding:3rem;color:var(--gray-600);">
                    <i class="fas fa-user-slash" style="font-size:2.5rem;margin-bottom:1rem;display:block;opacity:0.4;"></i>
                    Belum ada pengurus putri yang ditambahkan.
                </div>
                @endif
            </div>

        </div>
    </section>
</div>

@section('scripts')
<script>
function switchGender(gender) {
    const btnPutra  = document.getElementById('btnPutra');
    const btnPutri  = document.getElementById('btnPutri');
    const panelPutra = document.getElementById('panelPutra');
    const panelPutri = document.getElementById('panelPutri');

    if (gender === 'putra') {
        btnPutra.classList.add('active-putra');
        btnPutra.classList.remove('active-putri');
        btnPutri.classList.remove('active-putri', 'active-putra');
        panelPutra.style.display = '';
        panelPutri.style.display = 'none';
    } else {
        btnPutri.classList.add('active-putri');
        btnPutri.classList.remove('active-putra');
        btnPutra.classList.remove('active-putra', 'active-putri');
        panelPutri.style.display = '';
        panelPutra.style.display = 'none';
    }
    // Scroll to top of section smoothly
    document.querySelector('.gender-section-header')?.scrollIntoView({ behavior:'smooth', block:'start' });
}
</script>
@endsection
@endsection
