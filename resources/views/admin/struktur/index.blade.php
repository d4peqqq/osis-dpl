@extends('admin.layouts.sidebar')
@section('title', 'Struktur Organisasi')
@section('page-title', 'Manajemen Struktur Organisasi')
@section('styles')
<style>
.gender-tabs { display:flex; gap:0.5rem; margin-bottom:1rem; }
.gender-tab {
    padding:7px 20px; border-radius:30px; font-size:0.82rem; font-weight:700;
    cursor:pointer; border:2px solid var(--gray-200); background:white;
    transition:all .2s; color:var(--gray-600);
}
.gender-tab.active-putra { border-color:#3b82f6; background:#eff6ff; color:#1e40af; }
.gender-tab.active-putri { border-color:#ec4899; background:#fdf2f8; color:#be185d; }
.gender-tab.active-all   { border-color:var(--gold); background:var(--gold-light,#fffbeb); color:var(--navy); }
.badge-putra { background:#dbeafe; color:#1e40af; border-radius:30px; padding:3px 12px; font-size:0.75rem; font-weight:700; white-space:nowrap; }
.badge-putri { background:#fce7f3; color:#be185d; border-radius:30px; padding:3px 12px; font-size:0.75rem; font-weight:700; white-space:nowrap; }
tr.row-putra td:first-child { border-left:3px solid #3b82f6; }
tr.row-putri td:first-child { border-left:3px solid #ec4899; }
</style>
@endsection
@section('content')
<div class="breadcrumb"><a href="{{ route('admin.dashboard') }}">Dashboard</a> <i class="fas fa-chevron-right" style="font-size:0.7rem;"></i> Struktur Organisasi</div>
<div class="table-wrap">
    <div class="table-header">
        <h3>Daftar Anggota ({{ $struktur->total() }})</h3>
        <a href="{{ route('admin.struktur.create') }}" class="topbar-btn btn-gold"><i class="fas fa-user-plus"></i> Tambah Anggota</a>
    </div>

    {{-- Gender filter tabs --}}
    <div style="padding:0 1rem 0.5rem;">
        <div class="gender-tabs" id="genderTabs">
            <button class="gender-tab active-all" onclick="filterGender('all',this)">
                <i class="fas fa-users"></i> Semua
            </button>
            <button class="gender-tab" onclick="filterGender('putra',this)">
                🧑 Putra
            </button>
            <button class="gender-tab" onclick="filterGender('putri',this)">
                👩 Putri
            </button>
        </div>
    </div>

    <table id="anggotaTable">
        <thead><tr><th>Foto</th><th>Nama</th><th>Jabatan</th><th>Gender</th><th>Urutan</th><th>Status</th><th>Aksi</th></tr></thead>
        <tbody>
            @forelse($struktur as $m)
            <tr class="row-{{ $m->gender ?? 'putra' }}" data-gender="{{ $m->gender ?? 'putra' }}">
                <td>
                    @if($m->photo)
                        <img src="{{ $m->photo_url }}" style="width:44px;height:44px;border-radius:50%;object-fit:cover;border:2px solid {{ ($m->gender ?? 'putra') == 'putri' ? '#ec4899' : '#3b82f6' }};">
                    @else
                        <div style="width:44px;height:44px;border-radius:50%;background:{{ ($m->gender ?? 'putra') == 'putri' ? '#fce7f3' : '#dbeafe' }};display:flex;align-items:center;justify-content:center;color:{{ ($m->gender ?? 'putra') == 'putri' ? '#be185d' : '#1e40af' }};font-size:1.2rem;">
                            {{ ($m->gender ?? 'putra') == 'putri' ? '👩' : '🧑' }}
                        </div>
                    @endif
                </td>
                <td style="font-weight:600;">{{ $m->name }}</td>
                <td><span class="badge badge-gold">{{ $m->position }}</span></td>
                <td>
                    @if(($m->gender ?? 'putra') == 'putri')
                        <span class="badge-putri">👩 Putri</span>
                    @else
                        <span class="badge-putra">🧑 Putra</span>
                    @endif
                </td>
                <td>{{ $m->order }}</td>
                <td><span class="badge {{ $m->is_active ? 'badge-success' : 'badge-danger' }}">{{ $m->is_active ? 'Aktif' : 'Non-aktif' }}</span></td>
                <td>
                    <div class="action-btns">
                        <a href="{{ route('anggota.show', $m->slug) }}" target="_blank" class="btn-sm view"><i class="fas fa-eye"></i></a>
                        <a href="{{ route('admin.kartu-anggota.preview', $m->id) }}" class="btn-sm view" title="Kartu Anggota"><i class="fas fa-id-card"></i></a>
                        <a href="{{ route('admin.struktur.edit', $m) }}" class="btn-sm edit"><i class="fas fa-edit"></i> Edit</a>
                        <form method="POST" action="{{ route('admin.struktur.destroy', $m) }}" onsubmit="return confirm('Hapus anggota ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-sm delete"><i class="fas fa-trash"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" style="text-align:center;padding:3rem;color:var(--gray-600);">Belum ada anggota</td></tr>
            @endforelse
        </tbody>
    </table>
    {{ $struktur->links() }}
</div>
@endsection
@section('scripts')
<script>
function filterGender(gender, btn){
    // Update active tab styling
    document.querySelectorAll('.gender-tab').forEach(t => {
        t.classList.remove('active-all','active-putra','active-putri');
    });
    if(gender === 'all') btn.classList.add('active-all');
    else if(gender === 'putra') btn.classList.add('active-putra');
    else btn.classList.add('active-putri');

    // Filter rows
    document.querySelectorAll('#anggotaTable tbody tr[data-gender]').forEach(row => {
        if(gender === 'all' || row.dataset.gender === gender){
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}
</script>
@endsection
