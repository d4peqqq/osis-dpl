@extends('layouts.app')
@section('title', 'Galeri')

@section('styles')
<style>
.gallery-masonry {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 14px;
}
.gm-item {
    border-radius: 14px; overflow: hidden;
    position: relative; cursor: pointer;
    aspect-ratio: 1;
    background: var(--gray-100);
}
.gm-item img {
    width: 100%; height: 100%; object-fit: cover; display: block;
    transition: transform 0.5s cubic-bezier(0.4,0,0.2,1);
}
.gm-item:hover img { transform: scale(1.08); }
.gm-overlay {
    position: absolute; inset: 0;
    background: linear-gradient(to top, rgba(5,13,26,0.75) 0%, rgba(5,13,26,0.1) 50%, transparent 100%);
    opacity: 0; transition: opacity 0.35s;
    display: flex; flex-direction: column; justify-content: flex-end; padding: 1.1rem;
}
.gm-item:hover .gm-overlay { opacity: 1; }
.gm-overlay .gm-icon {
    position: absolute; top: 50%; left: 50%;
    transform: translate(-50%, -60%) scale(0.8);
    transition: all 0.3s;
    width: 44px; height: 44px; border-radius: 50%;
    background: rgba(245,166,35,0.9); display: flex; align-items: center; justify-content: center;
    color: var(--navy); font-size: 1.1rem;
}
.gm-item:hover .gm-icon { transform: translate(-50%, -50%) scale(1); }
.gm-title { color: white; font-size: 0.85rem; font-weight: 700; }

/* Lightbox */
.lightbox-backdrop {
    display: none; position: fixed; inset: 0;
    background: rgba(0,0,0,0.94); z-index: 9999;
    align-items: center; justify-content: center;
    backdrop-filter: blur(8px);
    animation: lbFadeIn 0.25s ease;
}
.lightbox-backdrop.active { display: flex; }
@keyframes lbFadeIn { from { opacity: 0; } to { opacity: 1; } }
.lb-content {
    position: relative; max-width: 92vw; max-height: 90vh;
    animation: lbZoom 0.3s cubic-bezier(0.4,0,0.2,1);
}
@keyframes lbZoom { from { transform: scale(0.9); opacity: 0.5; } to { transform: scale(1); opacity: 1; } }
.lb-content img { max-width: 90vw; max-height: 85vh; border-radius: 16px; display: block; box-shadow: 0 24px 80px rgba(0,0,0,0.6); }
.lb-close {
    position: fixed; top: 20px; right: 24px;
    background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2);
    color: white; width: 44px; height: 44px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; font-size: 1.1rem; transition: all 0.2s; border: none;
}
.lb-close:hover { background: rgba(255,255,255,0.2); transform: scale(1.1); }
.lb-caption {
    text-align: center; color: rgba(255,255,255,0.8);
    margin-top: 1rem; font-size: 0.9rem; font-weight: 600;
}
@media(max-width: 768px) {
    .gallery-masonry { grid-template-columns: repeat(2, 1fr); }
}
</style>
@endsection

@section('content')
<div class="page-offset">
    <!-- Page Hero -->
    <div class="page-hero">
        <div class="hero-breadcrumb">
            <a href="{{ route('home') }}">Beranda</a>
            <span><i class="fas fa-chevron-right" style="font-size:0.7em;"></i></span>
            <span style="color:var(--gold);">Galeri</span>
        </div>
        <h1><i class="fas fa-images" style="font-size:0.75em;margin-right:12px;"></i>Galeri Foto {{ request()->has('gender') ? ' ' . ucfirst(request('gender')) : '' }}</h1>
        <p>Dokumentasi kegiatan dan momen berharga OSIS</p>
    </div>

    <!-- Gallery -->
    <section class="section page-hero-dark" style="background:var(--gray-50);">
        <div class="container">
            @if($galeri->count() > 0)
            <div class="gallery-masonry reveal">
                @foreach($galeri as $foto)
                <div class="gm-item" onclick="openLb('{{ $foto->photo_url }}', '{{ addslashes($foto->title) }}')">
                    <img src="{{ $foto->photo_url }}" alt="{{ $foto->title }}" loading="lazy">
                    <div class="gm-overlay">
                        <div class="gm-icon"><i class="fas fa-expand"></i></div>
                        <div class="gm-title">{{ $foto->title }}</div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="pagination">{{ $galeri->links() }}</div>
            @else
            <div style="text-align:center;padding:5rem;color:var(--gray-600);" class="reveal">
                <div style="width:80px;height:80px;background:var(--gray-100);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 1.5rem;">
                    <i class="fas fa-images" style="font-size:2rem;color:var(--gray-400);"></i>
                </div>
                <h3 style="color:var(--navy);font-weight:700;margin-bottom:0.5rem;">Galeri Kosong</h3>
                <p>Foto akan segera ditambahkan.</p>
            </div>
            @endif
        </div>
    </section>
</div>

<!-- Lightbox -->
<div class="lightbox-backdrop" id="lightbox" onclick="closeLb(event)">
    <button class="lb-close" onclick="closeLb()"><i class="fas fa-times"></i></button>
    <div class="lb-content" onclick="event.stopPropagation()">
        <img id="lbImg" src="" alt="">
        <div class="lb-caption" id="lbCaption"></div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function openLb(src, caption) {
    document.getElementById('lbImg').src = src;
    document.getElementById('lbCaption').textContent = caption;
    document.getElementById('lightbox').classList.add('active');
    document.body.style.overflow = 'hidden';
}
function closeLb(e) {
    if (!e || e.target === document.getElementById('lightbox') || e.currentTarget === document.querySelector('.lb-close')) {
        document.getElementById('lightbox').classList.remove('active');
        document.body.style.overflow = '';
    }
}
document.addEventListener('keydown', e => { if (e.key === 'Escape') closeLb(); });
</script>
@endsection
