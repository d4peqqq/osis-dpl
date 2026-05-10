@extends('admin.layouts.sidebar')
@section('title', 'Kegiatan')
@section('page-title', 'Manajemen Kegiatan')
@section('content')
<div class="breadcrumb"><a href="{{ route('admin.dashboard') }}">Dashboard</a> <i class="fas fa-chevron-right" style="font-size:0.7rem;"></i> Kegiatan</div>
<div class="table-wrap">
    <div class="table-header">
        <h3>Daftar Kegiatan ({{ $kegiatan->total() }})</h3>
        <a href="{{ route('admin.kegiatan.create') }}" class="topbar-btn btn-gold"><i class="fas fa-plus"></i> Tambah Kegiatan</a>
    </div>
    <table>
        <thead><tr><th>Foto</th><th>Judul</th><th>Tanggal</th><th>Status</th><th>Aksi</th></tr></thead>
        <tbody>
            @forelse($kegiatan as $k)
            <tr>
                <td>
                    @if($k->photo)
                        <img src="{{ $k->photo_url }}" style="width:60px;height:40px;object-fit:cover;border-radius:6px;">
                    @else
                        <div style="width:60px;height:40px;background:var(--gray-100);border-radius:6px;display:flex;align-items:center;justify-content:center;color:var(--gray-600);"><i class="fas fa-image"></i></div>
                    @endif
                </td>
                <td style="font-weight:600;max-width:250px;">{{ $k->title }}</td>
                <td>{{ $k->date->format('d M Y') }}</td>
                <td>
                    <span class="badge {{ $k->gender == 'putra' ? 'badge-primary' : 'badge-danger' }}" style="margin-right:4px;">{{ ucfirst($k->gender) }}</span>
                    <span class="badge {{ $k->is_published ? 'badge-success' : 'badge-danger' }}">{{ $k->is_published ? 'Publik' : 'Draft' }}</span>
                </td>
                <td>
                    <div class="action-btns">
                        <a href="{{ route('kegiatan.show', $k->id) }}" target="_blank" class="btn-sm view"><i class="fas fa-eye"></i></a>
                        <a href="{{ route('admin.kegiatan.edit', $k) }}" class="btn-sm edit"><i class="fas fa-edit"></i> Edit</a>
                        <form method="POST" action="{{ route('admin.kegiatan.destroy', $k) }}" onsubmit="return confirm('Hapus kegiatan ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-sm delete"><i class="fas fa-trash"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" style="text-align:center;padding:3rem;color:var(--gray-600);">Belum ada kegiatan</td></tr>
            @endforelse
        </tbody>
    </table>
    {{ $kegiatan->links() }}
</div>
@endsection
