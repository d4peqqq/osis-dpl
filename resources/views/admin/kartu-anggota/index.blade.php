@extends('admin.layouts.sidebar')
@section('title', 'Kartu Anggota')
@section('page-title', 'Kartu Anggota OSIS')
@section('content')
<div class="breadcrumb"><a href="{{ route('admin.dashboard') }}">Dashboard</a> <i class="fas fa-chevron-right" style="font-size:0.7rem;"></i> Kartu Anggota</div>
<div style="background:linear-gradient(135deg,var(--navy),var(--navy-mid));border-radius:16px;padding:2rem;margin-bottom:2rem;color:white;">
    <div style="display:flex;align-items:center;gap:1rem;">
        <div style="width:56px;height:56px;background:rgba(240,165,0,0.2);border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.5rem;color:var(--gold);"><i class="fas fa-id-card"></i></div>
        <div>
            <h2 style="font-size:1.2rem;font-weight:700;">Generator Kartu Anggota</h2>
            <p style="color:rgba(255,255,255,0.6);font-size:0.9rem;margin-top:4px;">Buat kartu identitas anggota OSIS lengkap dengan QR Code. Klik anggota untuk melihat preview kartu.</p>
        </div>
    </div>
</div>
<div class="table-wrap">
    <div class="table-header">
        <h3>Daftar Anggota ({{ $anggota->count() }})</h3>
        <a href="{{ route('admin.struktur.create') }}" class="topbar-btn btn-gold"><i class="fas fa-user-plus"></i> Tambah Anggota</a>
    </div>
    <table>
        <thead><tr><th>Photo</th><th>Nama</th><th>Jabatan</th><th>QR Target URL</th><th>Aksi Kartu</th></tr></thead>
        <tbody>
            @forelse($anggota as $m)
            <tr>
                <td>
                    @if($m->photo)
                        <img src="{{ $m->photo_url }}" style="width:44px;height:44px;border-radius:50%;object-fit:cover;border:2px solid var(--gold);">
                    @else
                        <div style="width:44px;height:44px;border-radius:50%;background:var(--navy-mid);display:flex;align-items:center;justify-content:center;color:var(--gold);"><i class="fas fa-user"></i></div>
                    @endif
                </td>
                <td style="font-weight:600;">{{ $m->name }}</td>
                <td><span class="badge badge-gold">{{ $m->position }}</span></td>
                <td><code style="font-size:0.75rem;color:var(--gray-600);">/anggota/{{ $m->slug }}</code></td>
                <td>
                    <div class="action-btns">
                        <a href="{{ route('admin.kartu-anggota.preview', $m->id) }}" class="btn-sm view"><i class="fas fa-eye"></i> Preview</a>
                        <a href="{{ route('admin.kartu-anggota.pdf', $m->id) }}" class="btn-sm pdf" target="_blank"><i class="fas fa-file-pdf"></i> PDF</a>
                        <a href="{{ route('admin.kartu-anggota.print', $m->id) }}" class="btn-sm print" target="_blank"><i class="fas fa-print"></i> Print</a>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" style="text-align:center;padding:3rem;color:var(--gray-600);">Belum ada anggota. <a href="{{ route('admin.struktur.create') }}" style="color:var(--gold-dark);">Tambah anggota</a></td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
