@extends('admin.layouts.sidebar')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon gold"><i class="fas fa-calendar-alt"></i></div>
        <div>
            <div class="stat-num">{{ $stats['kegiatan'] }}</div>
            <div class="stat-label">Total Kegiatan</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon navy"><i class="fas fa-images"></i></div>
        <div>
            <div class="stat-num">{{ $stats['galeri'] }}</div>
            <div class="stat-label">Foto Galeri</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green"><i class="fas fa-users"></i></div>
        <div>
            <div class="stat-num">{{ $stats['anggota'] }}</div>
            <div class="stat-label">Anggota OSIS</div>
        </div>
    </div>
</div>

<div style="display:grid;grid-template-columns:2fr 1fr;gap:1.5rem;">
    <div class="table-wrap">
        <div class="table-header">
            <h3><i class="fas fa-calendar-alt" style="color:var(--gold);margin-right:8px;"></i>Kegiatan Terbaru</h3>
            <a href="{{ route('admin.kegiatan.create') }}" class="topbar-btn btn-gold" style="font-size:0.8rem;padding:6px 12px;">+ Tambah</a>
        </div>
        <table>
            <thead><tr><th>Kegiatan</th><th>Tanggal</th><th>Status</th><th>Aksi</th></tr></thead>
            <tbody>
                @forelse($latestKegiatan as $k)
                <tr>
                    <td style="font-weight:600;">{{ Str::limit($k->title, 40) }}</td>
                    <td>{{ $k->date->format('d M Y') }}</td>
                    <td><span class="badge {{ $k->is_published ? 'badge-success' : 'badge-danger' }}">{{ $k->is_published ? 'Publik' : 'Draft' }}</span></td>
                    <td>
                        <div class="action-btns">
                            <a href="{{ route('admin.kegiatan.edit', $k) }}" class="btn-sm edit"><i class="fas fa-edit"></i></a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" style="text-align:center;color:var(--gray-600);padding:2rem;">Belum ada kegiatan</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="display:flex;flex-direction:column;gap:1rem;">
        <div style="background:linear-gradient(135deg,var(--navy),var(--navy-mid));border-radius:16px;padding:1.5rem;color:white;">
            <h3 style="font-size:1rem;font-weight:700;margin-bottom:1rem;"><i class="fas fa-bolt" style="color:var(--gold);margin-right:8px;"></i>Aksi Cepat</h3>
            <div style="display:flex;flex-direction:column;gap:8px;">
                <a href="{{ route('admin.kegiatan.create') }}" style="background:rgba(255,255,255,0.08);color:white;padding:10px 14px;border-radius:8px;text-decoration:none;font-size:0.85rem;display:flex;align-items:center;gap:8px;transition:all 0.2s;" onmouseover="this.style.background='rgba(240,165,0,0.2)'" onmouseout="this.style.background='rgba(255,255,255,0.08)'">
                    <i class="fas fa-plus" style="color:var(--gold);"></i> Tambah Kegiatan
                </a>
                <a href="{{ route('admin.galeri.create') }}" style="background:rgba(255,255,255,0.08);color:white;padding:10px 14px;border-radius:8px;text-decoration:none;font-size:0.85rem;display:flex;align-items:center;gap:8px;transition:all 0.2s;" onmouseover="this.style.background='rgba(240,165,0,0.2)'" onmouseout="this.style.background='rgba(255,255,255,0.08)'">
                    <i class="fas fa-image" style="color:var(--gold);"></i> Upload Foto Galeri
                </a>
                <a href="{{ route('admin.struktur.create') }}" style="background:rgba(255,255,255,0.08);color:white;padding:10px 14px;border-radius:8px;text-decoration:none;font-size:0.85rem;display:flex;align-items:center;gap:8px;transition:all 0.2s;" onmouseover="this.style.background='rgba(240,165,0,0.2)'" onmouseout="this.style.background='rgba(255,255,255,0.08)'">
                    <i class="fas fa-user-plus" style="color:var(--gold);"></i> Tambah Anggota
                </a>
                <a href="{{ route('admin.kartu-anggota.index') }}" style="background:rgba(255,255,255,0.08);color:white;padding:10px 14px;border-radius:8px;text-decoration:none;font-size:0.85rem;display:flex;align-items:center;gap:8px;transition:all 0.2s;" onmouseover="this.style.background='rgba(240,165,0,0.2)'" onmouseout="this.style.background='rgba(255,255,255,0.08)'">
                    <i class="fas fa-id-card" style="color:var(--gold);"></i> Kartu Anggota
                </a>
                <a href="{{ route('admin.pengaturan.index') }}" style="background:rgba(255,255,255,0.08);color:white;padding:10px 14px;border-radius:8px;text-decoration:none;font-size:0.85rem;display:flex;align-items:center;gap:8px;transition:all 0.2s;" onmouseover="this.style.background='rgba(240,165,0,0.2)'" onmouseout="this.style.background='rgba(255,255,255,0.08)'">
                    <i class="fas fa-cog" style="color:var(--gold);"></i> Pengaturan Website
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
