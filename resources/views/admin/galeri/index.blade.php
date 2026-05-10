@extends('admin.layouts.sidebar')
@section('title', 'Galeri')
@section('page-title', 'Manajemen Galeri')
@section('content')
<div class="breadcrumb"><a href="{{ route('admin.dashboard') }}">Dashboard</a> <i class="fas fa-chevron-right" style="font-size:0.7rem;"></i> Galeri</div>
<div style="display:flex;justify-content:flex-end;margin-bottom:1.25rem;">
    <a href="{{ route('admin.galeri.create') }}" class="topbar-btn btn-gold"><i class="fas fa-plus"></i> Upload Foto</a>
</div>
<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:12px;">
    @forelse($galeri as $foto)
    <div style="position:relative;border-radius:12px;overflow:hidden;aspect-ratio:1;background:var(--gray-100);">
        <img src="{{ $foto->photo_url }}" alt="{{ $foto->title }}" style="width:100%;height:100%;object-fit:cover;">
        <div style="position:absolute;inset:0;background:rgba(10,22,40,0.6);opacity:0;transition:0.3s;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:8px;" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0'">
            <div style="color:white;font-size:0.8rem;font-weight:600;text-align:center;padding:0 8px;">{{ $foto->title }}</div>
            <span class="badge {{ $foto->gender == 'putra' ? 'badge-primary' : 'badge-danger' }}" style="font-size:0.7rem;padding:2px 8px;">{{ ucfirst($foto->gender) }}</span>
            <form method="POST" action="{{ route('admin.galeri.destroy', $foto) }}" onsubmit="return confirm('Hapus foto ini?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn-sm delete"><i class="fas fa-trash"></i> Hapus</button>
            </form>
        </div>
    </div>
    @empty
    <div style="grid-column:span 4;text-align:center;padding:4rem;color:var(--gray-600);">
        <i class="fas fa-images" style="font-size:3rem;margin-bottom:1rem;display:block;color:var(--gray-200);"></i>
        Belum ada foto. <a href="{{ route('admin.galeri.create') }}" style="color:var(--gold-dark);">Upload sekarang</a>
    </div>
    @endforelse
</div>
<div class="table-wrap" style="margin-top:1rem;">{{ $galeri->links() }}</div>
@endsection
