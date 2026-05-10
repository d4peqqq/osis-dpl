@extends('admin.layouts.sidebar')
@section('title', 'Manajemen User')
@section('page-title', 'Manajemen User')

@section('content')
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.5rem;">
    <h2 style="font-size:1.4rem;color:var(--navy);font-weight:800;">Daftar Pengguna Sistem</h2>
    <a href="{{ route('admin.users.create') }}" class="btn-sm" style="background:var(--gold);color:var(--navy);padding:8px 16px;">
        <i class="fas fa-plus"></i> Tambah User Baru
    </a>
</div>

<div class="table-wrap">
    <div class="table-header">
        <h3>Daftar Pengguna dan Hak Akses</h3>
    </div>
    <div style="overflow-x:auto;">
        <table>
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role (Akses)</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td style="font-weight:600;">{{ $user->name }}</td>
                    <td style="color:var(--gray-600);">{{ $user->email }}</td>
                    <td>
                        @if($user->role === 'admin')
                            <span class="badge badge-success"><i class="fas fa-shield-alt"></i> Admin Utama</span>
                        @else
                            <span class="badge badge-gold"><i class="fas fa-edit"></i> Admin Konten</span>
                        @endif
                    </td>
                    <td>
                        <div class="action-btns">
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn-sm edit"><i class="fas fa-edit"></i> Edit</a>
                            @if(auth()->id() !== $user->id)
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-sm delete"><i class="fas fa-trash"></i> Hapus</button>
                            </form>
                            @else
                                <span class="badge" style="background:rgba(255,255,255,0.5);color:var(--gray-400);border:1px solid var(--gray-200);">Akun Anda</span>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
