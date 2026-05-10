@extends('admin.layouts.sidebar')
@section('title', 'Preview Kartu — ' . $anggota->name)
@section('page-title', 'Preview Kartu Anggota')
@section('content')
<div class="breadcrumb"><a href="{{ route('admin.dashboard') }}">Dashboard</a> <i class="fas fa-chevron-right" style="font-size:0.7rem;"></i> <a href="{{ route('admin.kartu-anggota.index') }}">Kartu Anggota</a> <i class="fas fa-chevron-right" style="font-size:0.7rem;"></i> Preview</div>

<div style="display:flex;gap:3rem;align-items:flex-start;flex-wrap:wrap;">
    <!-- Card Preview -->
    <div>
        <h3 style="font-weight:700;color:var(--navy);margin-bottom:1.5rem;">Preview Kartu</h3>
        <div class="id-card">
            <div class="id-card-header">
                <div>
                    <div class="school">{{ $settings['nama_sekolah'] ?? 'SMA Contoh Bangsa' }}</div>
                    <div class="osis-label">{{ $settings['nama_osis'] ?? 'OSIS SMA' }}</div>
                </div>
                <div style="margin-left:auto;font-size:1.5rem;font-weight:900;color:var(--navy-mid);">OSIS</div>
            </div>
            <div class="id-card-body">
                @if($anggota->photo && file_exists(public_path('storage/'.$anggota->photo)))
                    <img class="id-card-photo" src="{{ $anggota->photo_url }}" alt="{{ $anggota->name }}" style="width:90px;height:90px;border-radius:10px;object-fit:cover;border:3px solid var(--gold);">
                @else
                    <div class="id-card-photo"><i class="fas fa-user"></i></div>
                @endif
                <div class="id-card-info">
                    <div class="pos">{{ $anggota->position }}</div>
                    <div class="name">{{ $anggota->name }}</div>
                    <div class="school" style="margin-top:8px;">{{ $settings['nama_sekolah'] ?? 'SMA Contoh Bangsa' }}</div>
                    @if($anggota->description)
                        <div style="color:rgba(255,255,255,0.5);font-size:0.7rem;margin-top:6px;line-height:1.4;">{{ Str::limit($anggota->description, 60) }}</div>
                    @endif
                </div>
            </div>
            <div class="id-card-footer">
                <div>
                    <div class="url">Pindai QR untuk profil lengkap</div>
                    <div style="color:rgba(255,255,255,0.3);font-size:0.65rem;margin-top:2px;">{{ url('/anggota/'.$anggota->slug) }}</div>
                </div>
                <div class="qr-box">
                    <img src="{{ $qrCode }}" alt="QR Code">
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div style="display:flex;gap:0.75rem;margin-top:1.5rem;flex-wrap:wrap;">
            <a href="{{ route('admin.kartu-anggota.pdf', $anggota->id) }}" target="_blank" class="topbar-btn" style="background:#15803d;color:white;">
                <i class="fas fa-file-pdf"></i> Download PDF
            </a>
            <a href="{{ route('admin.kartu-anggota.print', $anggota->id) }}" target="_blank" class="topbar-btn btn-gold">
                <i class="fas fa-print"></i> Print Kartu
            </a>
            <a href="{{ route('admin.kartu-anggota.index') }}" class="topbar-btn" style="background:var(--gray-100);color:var(--text);">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <!-- Info Panel -->
    <div style="flex:1;min-width:280px;">
        <h3 style="font-weight:700;color:var(--navy);margin-bottom:1.5rem;">Informasi QR Code</h3>
        <div style="background:white;border-radius:16px;padding:1.5rem;box-shadow:0 1px 8px rgba(0,0,0,0.05);">
            <div style="margin-bottom:1rem;">
                <div style="font-size:0.8rem;font-weight:600;color:var(--gray-600);margin-bottom:4px;">URL QR Code mengarah ke:</div>
                <code style="background:var(--gray-100);padding:8px 12px;border-radius:8px;font-size:0.85rem;display:block;word-break:break-all;">{{ $qrUrl }}</code>
            </div>
            <div style="margin-bottom:1rem;">
                <div style="font-size:0.8rem;font-weight:600;color:var(--gray-600);margin-bottom:4px;">Ketika dipindai:</div>
                <p style="font-size:0.85rem;color:var(--text);line-height:1.6;">Kamera HP akan membuka halaman profil anggota <strong>{{ $anggota->name }}</strong> di browser.</p>
            </div>
            <div style="background:rgba(240,165,0,0.1);border:1px solid rgba(240,165,0,0.3);border-radius:8px;padding:12px;">
                <div style="font-size:0.8rem;font-weight:700;color:var(--gold-dark);"><i class="fas fa-lightbulb"></i> Tips</div>
                <p style="font-size:0.8rem;color:var(--text);margin-top:6px;line-height:1.5;">Cetak kartu di kertas tebal (190gsm) dan laminating untuk hasil terbaik. Ukuran kartu: 85.6 × 54 mm (standar kartu kredit).</p>
            </div>
        </div>
    </div>
</div>
@endsection
