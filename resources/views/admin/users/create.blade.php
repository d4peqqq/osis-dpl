@extends('admin.layouts.sidebar')
@section('title', 'Tambah User')
@section('page-title', 'Tambah User')

@section('content')
<div class="breadcrumb">
    <a href="{{ route('admin.users.index') }}">Manajemen User</a> / <span style="font-weight:600;color:var(--navy);">Tambah</span>
</div>

<div class="form-wrap" style="max-width:600px;">
    <h3 style="margin-bottom:1.5rem;color:var(--navy);font-weight:700;">Data Pengguna Baru</h3>
    <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Nama Lengkap</label>
            <input type="text" name="name" value="{{ old('name') }}" placeholder="Contoh: Budi Santoso" required autofocus>
            @error('name')<div class="form-error">{{ $message }}</div>@enderror
        </div>
        
        <div class="form-group">
            <label>Email Pengguna</label>
            <input type="email" name="email" value="{{ old('email') }}" placeholder="Contoh: admin@sekolah.com" required>
            @error('email')<div class="form-error">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label>Password Akun</label>
            <input type="password" name="password" placeholder="Minimal 6 karakter" required>
            @error('password')<div class="form-error">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label>Hak Akses (Role)</label>
            <select name="role" required>
                <option value="">Pilih Hak Akses...</option>
                <option value="konten" {{ old('role') == 'konten' ? 'selected' : '' }}>Admin Konten (Hanya bisa atur Kegiatan/Galeri/Struktur)</option>
                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin Utama (Akses penuh + Pengaturan & Tambah User)</option>
            </select>
            @error('role')<div class="form-error">{{ $message }}</div>@enderror
        </div>

        <div style="margin-top:2rem;">
            <button type="submit" class="btn-sm edit" style="padding:10px 20px;font-size:0.9rem;"><i class="fas fa-save"></i> Simpan Pengguna</button>
            <a href="{{ route('admin.users.index') }}" class="btn-sm" style="padding:10px 20px;font-size:0.9rem;background:var(--gray-200);color:var(--gray-600);"><i class="fas fa-times"></i> Batal</a>
        </div>
    </form>
</div>
@endsection
