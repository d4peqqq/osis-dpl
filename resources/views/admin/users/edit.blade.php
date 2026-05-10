@extends('admin.layouts.sidebar')
@section('title', 'Edit User')
@section('page-title', 'Edit User')

@section('content')
<div class="breadcrumb">
    <a href="{{ route('admin.users.index') }}">Manajemen User</a> / <span style="font-weight:600;color:var(--navy);">Edit</span>
</div>

<div class="form-wrap" style="max-width:600px;">
    <h3 style="margin-bottom:1.5rem;color:var(--navy);font-weight:700;">Edit Data Pengguna</h3>
    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
        @csrf @method('PUT')
        
        <div class="form-group">
            <label>Nama Lengkap</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" required>
            @error('name')<div class="form-error">{{ $message }}</div>@enderror
        </div>
        
        <div class="form-group">
            <label>Email Pengguna</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" required>
            @error('email')<div class="form-error">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label>Password Baru <span style="color:var(--gray-400);font-weight:400;">(Opsional)</span></label>
            <input type="password" name="password" placeholder="Isi hanya jika ingin mengganti password">
            <div class="form-hint">Kosongkan jika tidak ingin mengubah password.</div>
            @error('password')<div class="form-error">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label>Hak Akses (Role)</label>
            <select name="role" required {{ auth()->id() === $user->id ? 'disabled' : '' }}>
                <option value="konten" {{ old('role', $user->role) == 'konten' ? 'selected' : '' }}>Admin Konten (Hanya bisa atur Kegiatan/Galeri/Struktur)</option>
                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin Utama (Akses penuh + Pengaturan & Tambah User)</option>
            </select>
            @if(auth()->id() === $user->id)
                <div class="form-hint" style="color:var(--warning);">Anda tidak bisa mengubah role Anda sendiri.</div>
                <input type="hidden" name="role" value="{{ $user->role }}">
            @endif
            @error('role')<div class="form-error">{{ $message }}</div>@enderror
        </div>

        <div style="margin-top:2rem;">
            <button type="submit" class="btn-sm edit" style="padding:10px 20px;font-size:0.9rem;"><i class="fas fa-save"></i> Update Data</button>
            <a href="{{ route('admin.users.index') }}" class="btn-sm" style="padding:10px 20px;font-size:0.9rem;background:var(--gray-200);color:var(--gray-600);"><i class="fas fa-times"></i> Batal</a>
        </div>
    </form>
</div>
@endsection
