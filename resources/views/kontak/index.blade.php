@extends('layouts.app')
@section('title', 'Kontak')

@section('styles')
<style>
.contact-item {
    display: flex; gap: 1.25rem; align-items: flex-start;
    padding: 1.5rem; background: white; border-radius: 16px;
    border: 1px solid var(--gray-200);
    box-shadow: var(--shadow-sm);
    transition: var(--transition);
}
.contact-item:hover {
    transform: translateY(-3px);
    box-shadow: var(--shadow-md);
    border-color: rgba(245,166,35,0.25);
}
.contact-icon {
    width: 52px; height: 52px; border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.1rem; flex-shrink: 0;
    background: linear-gradient(135deg, var(--gold), var(--gold-dark));
    color: var(--navy);
    box-shadow: 0 6px 16px var(--gold-glow);
}
.contact-icon.ig { background: linear-gradient(135deg, #f77737, #e1306c, #833ab4); color: white; }
.contact-label { font-weight: 800; color: var(--navy); margin-bottom: 4px; font-size: 0.95rem; }
.contact-value { color: var(--gray-600); font-size: 0.9rem; line-height: 1.65; }

.visi-card {
    background: linear-gradient(145deg, var(--navy), var(--navy-mid));
    border-radius: 20px; padding: 2rem; color: white;
    position: relative; overflow: hidden;
}
.visi-card::before {
    content: ''; position: absolute; top: -40px; right: -40px;
    width: 160px; height: 160px;
    background: radial-gradient(circle, rgba(245,166,35,0.15), transparent 70%);
    border-radius: 50%;
}
.misi-card {
    background: var(--gray-50); border-radius: 20px; padding: 2rem;
    border: 1px solid var(--gray-200);
}

.maps-wrap { border-radius: 20px; overflow: hidden; box-shadow: var(--shadow-lg); margin-top: 3rem; }
.maps-wrap iframe { display: block; width: 100%; border: 0; }
</style>
@endsection

@section('content')
<div class="page-offset">
    <!-- Page Hero -->
    <div class="page-hero">
        <div class="hero-breadcrumb">
            <a href="{{ route('home') }}">Beranda</a>
            <span><i class="fas fa-chevron-right" style="font-size:0.7em;"></i></span>
            <span style="color:var(--gold);">Kontak</span>
        </div>
        <h1><i class="fas fa-envelope" style="font-size:0.75em;margin-right:12px;"></i>Kontak Kami</h1>
        <p>Hubungi kami untuk informasi lebih lanjut</p>
    </div>

    <section class="section" style="background:var(--gray-50);">
        <div class="container">
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:3rem;align-items:start;">
                <!-- Contact Info -->
                <div class="reveal">
                    <div class="section-title" style="text-align:left;margin-bottom:2rem;">
                        <div class="section-label"><i class="fas fa-address-card"></i> Informasi</div>
                        <h2 style="font-size:1.8rem;">Hubungi <span class="highlight">Kami</span></h2>
                    </div>
                    <div style="display:flex;flex-direction:column;gap:14px;">
                        <div class="contact-item">
                            <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode(($settings['nama_sekolah'] ?? 'SMA Insan Cendekia Al Kausar') . ' ' . ($settings['alamat'] ?? '')) }}" target="_blank" class="contact-icon" style="text-decoration:none;"><i class="fas fa-map-marker-alt"></i></a>
                            <div>
                                <div class="contact-label">Alamat</div>
                                <div class="contact-value">{{ $settings['alamat'] ?? '-' }}</div>
                            </div>
                        </div>
                        <div class="contact-item">
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings['telepon'] ?? '') }}" target="_blank" class="contact-icon" style="text-decoration:none; background: #25D366; color: white;"><i class="fab fa-whatsapp"></i></a>
                            <div>
                                <div class="contact-label">Telepon</div>
                                <div class="contact-value">{{ $settings['telepon'] ?? '-' }}</div>
                            </div>
                        </div>
                        <div class="contact-item">
                            <a href="mailto:{{ $settings['email'] ?? '' }}" class="contact-icon" style="text-decoration:none;"><i class="fas fa-envelope"></i></a>
                            <div>
                                <div class="contact-label">Email</div>
                                <div class="contact-value">{{ $settings['email'] ?? '-' }}</div>
                            </div>
                        </div>
                        @if(!empty($settings['instagram']))
                        <div class="contact-item">
                            <a href="{{ $settings['instagram'] }}" target="_blank" class="contact-icon ig" style="text-decoration:none;"><i class="fab fa-instagram"></i></a>
                            <div>
                                <div class="contact-label">Instagram</div>
                                <div class="contact-value" style="word-break: break-word;">{{ $settings['instagram'] }}</div>
                            </div>
                        </div>
                        @endif
                        @if(!empty($settings['tiktok']))
                        <div class="contact-item">
                            <a href="{{ $settings['tiktok'] }}" target="_blank" class="contact-icon" style="text-decoration:none; background: #000000; color: white;"><i class="fab fa-tiktok"></i></a>
                            <div>
                                <div class="contact-label">TikTok</div>
                                <div class="contact-value" style="word-break: break-word;">{{ $settings['tiktok'] }}</div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Visi Misi -->
                <div class="reveal reveal-delay-2">
                    <div class="section-title" style="text-align:left;margin-bottom:2rem;">
                        <div class="section-label"><i class="fas fa-bullseye"></i> Tujuan</div>
                        <h2 style="font-size:1.8rem;">Visi & <span class="highlight">Misi</span></h2>
                    </div>
                    
                    <div class="visi-card" style="margin-bottom:14px;">
                        <div style="color:var(--gold);font-size:0.78rem;font-weight:800;letter-spacing:0.08em;text-transform:uppercase;margin-bottom:0.75rem;"><i class="fas fa-eye"></i> Visi</div>
                        <div style="position:relative;z-index:1;">
                            <div style="margin-bottom:12px;">
                                <span style="display:inline-block;background:rgba(245,166,35,0.2);color:var(--gold-light);padding:2px 8px;border-radius:4px;font-size:0.75rem;font-weight:700;margin-bottom:4px;"><i class="fas fa-male"></i> Putra</span>
                                <p style="color:rgba(255,255,255,0.85);font-size:0.95rem;line-height:1.7;margin:0;">{{ $settings['visi_putra'] ?? '-' }}</p>
                            </div>
                            <div>
                                <span style="display:inline-block;background:rgba(245,166,35,0.2);color:var(--gold-light);padding:2px 8px;border-radius:4px;font-size:0.75rem;font-weight:700;margin-bottom:4px;"><i class="fas fa-female"></i> Putri</span>
                                <p style="color:rgba(255,255,255,0.85);font-size:0.95rem;line-height:1.7;margin:0;">{{ $settings['visi_putri'] ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="misi-card">
                        <div style="color:var(--navy);font-size:0.78rem;font-weight:800;letter-spacing:0.08em;text-transform:uppercase;margin-bottom:0.75rem;"><i class="fas fa-rocket"></i> Misi</div>
                        <div>
                            <div style="margin-bottom:12px;">
                                <span style="display:inline-block;background:var(--navy);color:white;padding:2px 8px;border-radius:4px;font-size:0.75rem;font-weight:700;margin-bottom:4px;"><i class="fas fa-male"></i> Putra</span>
                                <div style="color:var(--gray-600);font-size:0.9rem;line-height:1.7;">{!! nl2br(e($settings['misi_putra'] ?? '-')) !!}</div>
                            </div>
                            <div>
                                <span style="display:inline-block;background:var(--navy);color:white;padding:2px 8px;border-radius:4px;font-size:0.75rem;font-weight:700;margin-bottom:4px;"><i class="fas fa-female"></i> Putri</span>
                                <div style="color:var(--gray-600);font-size:0.9rem;line-height:1.7;">{!! nl2br(e($settings['misi_putri'] ?? '-')) !!}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if(!empty($settings['maps_embed']))
            <div class="maps-wrap reveal">
                {!! $settings['maps_embed'] !!}
            </div>
            @endif
        </div>
    </section>
</div>
@endsection
