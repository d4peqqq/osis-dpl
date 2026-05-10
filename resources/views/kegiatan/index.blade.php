@extends('layouts.app')
@section('title', 'Kegiatan')

@section('styles')
<style>
.kegiatan-card .card-img-wrap {
    position: relative; overflow: hidden; height: 210px;
}
.kegiatan-card .card-img-wrap img,
.kegiatan-card .card-img-wrap .placeholder {
    width: 100%; height: 100%; object-fit: cover;
    transition: transform 0.5s cubic-bezier(0.4,0,0.2,1);
    display: block;
}
.kegiatan-card:hover .card-img-wrap img { transform: scale(1.06); }
.kegiatan-card .card-img-wrap .placeholder {
    background: linear-gradient(135deg, var(--navy-mid), var(--navy));
    display: flex; align-items: center; justify-content: center;
}
.kegiatan-card .card-img-wrap .img-overlay {
    position: absolute; inset: 0;
    background: linear-gradient(to top, rgba(5,13,26,0.5) 0%, transparent 60%);
    opacity: 0; transition: opacity 0.35s;
}
.kegiatan-card:hover .img-overlay { opacity: 1; }
</style>
@endsection

@section('content')
<div class="page-offset">
    <!-- Page Hero -->
    <div class="page-hero">
        <div class="hero-breadcrumb">
            <a href="{{ route('home') }}">Beranda</a>
            <span><i class="fas fa-chevron-right" style="font-size:0.7em;"></i></span>
            <span style="color:var(--gold);">Kegiatan</span>
        </div>
        <h1><i class="fas fa-calendar-check" style="font-size:0.75em;margin-right:12px;"></i>Kegiatan {{ request()->has('gender') ? 'Kepengurusan ' . ucfirst(request('gender')) : 'OSIS' }}</h1>
        <p>Program dan kegiatan yang telah kami laksanakan</p>
    </div>

    <!-- Content -->
    <section class="section" style="background:var(--gray-50);">
        <div class="container">
            @if($kegiatan->count() > 0)
            <div class="grid-3">
                @foreach($kegiatan as $i => $k)
                <div class="card kegiatan-card reveal reveal-delay-{{ ($i % 3) + 1 }}">
                    <div class="card-img-wrap">
                        @if($k->photo)
                            <img src="{{ $k->photo_url }}" alt="{{ $k->title }}">
                        @else
                            <div class="placeholder">
                                <i class="fas fa-calendar-check" style="font-size:3rem;color:rgba(245,166,35,0.25);"></i>
                            </div>
                        @endif
                        <div class="img-overlay"></div>
                    </div>
                    <div class="card-body">
                        <span class="card-badge"><i class="fas fa-calendar-alt"></i> {{ $k->date->format('d M Y') }}</span>
                        <div class="card-title">{{ $k->title }}</div>
                        <div class="card-text">{{ Str::limit(strip_tags($k->body), 120) }}</div>
                        <a href="{{ route('kegiatan.show', $k->id) }}" class="card-footer-link">
                            Baca Selengkapnya <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="pagination">{{ $kegiatan->links() }}</div>
            @else
            <div style="text-align:center;padding:5rem;color:var(--gray-600);" class="reveal">
                <div style="width:80px;height:80px;background:var(--gray-100);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 1.5rem;">
                    <i class="fas fa-calendar-times" style="font-size:2rem;color:var(--gray-400);"></i>
                </div>
                <h3 style="color:var(--navy);font-weight:700;margin-bottom:0.5rem;">Belum Ada Kegiatan</h3>
                <p>Kegiatan akan segera dipublikasikan.</p>
            </div>
            @endif
        </div>
    </section>
</div>
@endsection
