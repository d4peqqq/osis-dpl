@extends('layouts.app')
@section('title', $item->title)

@section('styles')
<style>
.article-img {
    width: 100%; border-radius: 20px; object-fit: cover;
    max-height: 480px; display: block; margin-bottom: 2.5rem;
    box-shadow: var(--shadow-lg);
}
.article-body {
    font-size: 1.02rem; line-height: 1.95; color: var(--text);
}
.article-body p { margin-bottom: 1.25rem; }
.sidebar-related-title {
    font-size: 0.85rem; font-weight: 800; color: var(--navy);
    text-transform: uppercase; letter-spacing: 0.07em;
    margin-bottom: 1.25rem; padding-bottom: 0.75rem;
    border-bottom: 3px solid var(--gold);
    display: flex; align-items: center; gap: 8px;
}
.related-item {
    padding: 1.1rem 1rem; background: var(--gray-50);
    border-radius: 12px; border: 1px solid var(--gray-200);
    margin-bottom: 12px; transition: var(--transition);
    text-decoration: none; display: block;
}
.related-item:hover {
    background: white; border-color: rgba(245,166,35,0.3);
    transform: translateX(4px); box-shadow: var(--shadow-sm);
}
.related-date { font-size: 0.72rem; color: var(--gold-dark); font-weight: 700; margin-bottom: 5px; }
.related-title { font-weight: 700; color: var(--navy); font-size: 0.9rem; line-height: 1.45; }
</style>
@endsection

@section('content')
<div class="page-offset">
    <!-- Article Hero -->
    <div class="page-hero" style="padding-bottom:5rem;">
        <div class="hero-breadcrumb">
            <a href="{{ route('home') }}">Beranda</a>
            <span><i class="fas fa-chevron-right" style="font-size:0.7em;"></i></span>
            <a href="{{ route('kegiatan.index') }}">Kegiatan</a>
            <span><i class="fas fa-chevron-right" style="font-size:0.7em;"></i></span>
            <span style="color:var(--gold);">Detail</span>
        </div>
        <div style="display:inline-flex;align-items:center;gap:8px;background:rgba(245,166,35,0.15);border:1px solid rgba(245,166,35,0.3);color:var(--gold-light);padding:7px 18px;border-radius:20px;font-size:0.82rem;font-weight:700;margin-bottom:1rem;">
            <i class="fas fa-calendar-alt"></i> {{ $item->date->format('d F Y') }}
        </div>
        <h1 style="font-size:clamp(1.6rem,4vw,2.4rem);max-width:760px;margin:0.5rem auto 0;color:white;letter-spacing:-0.02em;">{{ $item->title }}</h1>
    </div>

    <!-- Content -->
    <section class="section" style="background:var(--gray-50);padding-top:4rem;">
        <div class="container">
            <div style="display:grid;grid-template-columns:2fr 1fr;gap:3.5rem;align-items:start;">
                <!-- Main Article -->
                <div class="reveal">
                    @if($item->photo)
                        <img class="article-img" src="{{ $item->photo_url }}" alt="{{ $item->title }}">
                    @endif
                    <div class="article-body">{!! nl2br(e($item->body)) !!}</div>
                    <div style="margin-top:2.5rem;">
                        <a href="{{ route('kegiatan.index') }}" class="btn btn-primary" style="background:var(--navy);color:white;box-shadow:none;">
                            <i class="fas fa-arrow-left"></i> Kembali ke Kegiatan
                        </a>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="reveal reveal-delay-2">
                    <div class="sidebar-related-title">
                        <i class="fas fa-layer-group"></i> Kegiatan Lainnya
                    </div>
                    @forelse($related as $r)
                    <a href="{{ route('kegiatan.show', $r->id) }}" class="related-item">
                        <div class="related-date"><i class="fas fa-calendar-alt"></i> {{ $r->date->format('d M Y') }}</div>
                        <div class="related-title">{{ $r->title }}</div>
                    </a>
                    @empty
                    <p style="color:var(--gray-600);font-size:0.9rem;">Tidak ada kegiatan lain.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
