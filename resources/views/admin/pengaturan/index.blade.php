@extends('admin.layouts.sidebar')
@section('title', 'Pengaturan Website')
@section('page-title', 'Pengaturan Website')
@section('content')
<div class="breadcrumb"><a href="{{ route('admin.dashboard') }}">Dashboard</a> <i class="fas fa-chevron-right" style="font-size:0.7rem;"></i> Pengaturan</div>
<div class="form-wrap">
    <form method="POST" action="{{ route('admin.pengaturan.update') }}" enctype="multipart/form-data">
        @csrf @method('PUT')

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:2rem;">
            <div>
                <h3 style="font-size:1rem;font-weight:700;color:var(--navy);margin-bottom:1.25rem;padding-bottom:0.5rem;border-bottom:2px solid var(--gold);">Identitas Sekolah</h3>
                <div class="form-group">
                    <label>Nama Sekolah *</label>
                    <input type="text" name="nama_sekolah" value="{{ old('nama_sekolah', $settings['nama_sekolah'] ?? '') }}" required>
                </div>
                <div class="form-group">
                    <label>Nama OSIS *</label>
                    <input type="text" name="nama_osis" value="{{ old('nama_osis', $settings['nama_osis'] ?? '') }}" required>
                </div>
                <div class="form-group">
                    <label>Alamat</label>
                    <textarea name="alamat" rows="2">{{ old('alamat', $settings['alamat'] ?? '') }}</textarea>
                </div>
                <div class="form-group">
                    <label>Telepon</label>
                    <input type="text" name="telepon" value="{{ old('telepon', $settings['telepon'] ?? '') }}">
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" value="{{ old('email', $settings['email'] ?? '') }}">
                </div>
                <div class="form-group">
                    <label>Logo Sekolah</label>
                    @if(!empty($settings['logo']))
                        <img src="{{ asset('storage/'.$settings['logo']) }}" style="max-height:60px;display:block;margin-bottom:8px;">
                    @endif
                    <input type="file" name="logo" accept="image/*">
                </div>
            </div>

            <div>
                <h3 style="font-size:1rem;font-weight:700;color:var(--navy);margin-bottom:1.25rem;padding-bottom:0.5rem;border-bottom:2px solid var(--gold);">Sambutan & Profil Ketua</h3>
                <div class="form-group">
                    <label>Nama Ketua OSIS</label>
                    <input type="text" name="nama_ketua" value="{{ old('nama_ketua', $settings['nama_ketua'] ?? '') }}">
                </div>
                <div class="form-group">
                    <label>Jabatan</label>
                    <input type="text" name="jabatan_ketua" value="{{ old('jabatan_ketua', $settings['jabatan_ketua'] ?? 'Ketua OSIS') }}">
                </div>
                <div class="form-group">
                    <label>Foto Ketua</label>
                    @if(!empty($settings['foto_ketua']))
                        <img src="{{ asset('storage/'.$settings['foto_ketua']) }}" style="width:60px;height:60px;border-radius:50%;object-fit:cover;display:block;margin-bottom:8px;border:2px solid var(--gold);">
                    @endif
                    <input type="file" name="foto_ketua" accept="image/*">
                </div>
                <div class="form-group">
                    <label>Kata Sambutan (Ditampilkan di homepage)</label>
                    <textarea name="kata_sambutan" rows="3">{{ old('kata_sambutan', $settings['kata_sambutan'] ?? '') }}</textarea>
                </div>
                <div class="form-group">
                    <label>Kutipan Ketua</label>
                    <textarea name="sambutan_ketua" rows="2">{{ old('sambutan_ketua', $settings['sambutan_ketua'] ?? '') }}</textarea>
                </div>
            </div>
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:2rem;margin-top:1.5rem;">
            <div>
                <h3 style="font-size:1rem;font-weight:700;color:var(--navy);margin-bottom:1.25rem;padding-bottom:0.5rem;border-bottom:2px solid var(--gold);">Visi & Misi</h3>
                
                <label style="display:block;margin-bottom:8px;font-weight:600;color:var(--navy);">Visi</label>
                <div style="border:1px solid var(--gray-200);border-radius:var(--radius-sm);padding:1rem;margin-bottom:1.5rem;background:var(--gray-50);">
                    <div class="form-group" style="margin-bottom:1rem;">
                        <label style="font-size:0.85rem;"><i class="fas fa-male" style="color:var(--gold);"></i> Putra</label>
                        <textarea name="visi_putra" rows="2" style="background:#fff;">{{ old('visi_putra', $settings['visi_putra'] ?? '') }}</textarea>
                    </div>
                    <div class="form-group" style="margin-bottom:0;">
                        <label style="font-size:0.85rem;"><i class="fas fa-female" style="color:var(--gold);"></i> Putri</label>
                        <textarea name="visi_putri" rows="2" style="background:#fff;">{{ old('visi_putri', $settings['visi_putri'] ?? '') }}</textarea>
                    </div>
                </div>

                <label style="display:block;margin-bottom:8px;font-weight:600;color:var(--navy);">Misi</label>
                <div style="border:1px solid var(--gray-200);border-radius:var(--radius-sm);padding:1rem;background:var(--gray-50);">
                    <div class="form-group" style="margin-bottom:1rem;">
                        <label style="font-size:0.85rem;"><i class="fas fa-male" style="color:var(--gold);"></i> Putra</label>
                        <textarea name="misi_putra" rows="3" style="background:#fff;">{{ old('misi_putra', $settings['misi_putra'] ?? '') }}</textarea>
                    </div>
                    <div class="form-group" style="margin-bottom:0;">
                        <label style="font-size:0.85rem;"><i class="fas fa-female" style="color:var(--gold);"></i> Putri</label>
                        <textarea name="misi_putri" rows="3" style="background:#fff;">{{ old('misi_putri', $settings['misi_putri'] ?? '') }}</textarea>
                    </div>
                </div>
            </div>
            <div>
                <h3 style="font-size:1rem;font-weight:700;color:var(--navy);margin-bottom:1.25rem;padding-bottom:0.5rem;border-bottom:2px solid var(--gold);">Media Sosial & Kontak</h3>
                <div class="form-group">
                    <label><i class="fab fa-instagram" style="color:#e1306c;"></i> Instagram</label>
                    <input type="text" name="instagram" value="{{ old('instagram', $settings['instagram'] ?? '') }}" placeholder="https://instagram.com/osis_sma">
                </div>
                <div class="form-group">
                    <label><i class="fab fa-facebook-f" style="color:#1d4ed8;"></i> Facebook</label>
                    <input type="text" name="facebook" value="{{ old('facebook', $settings['facebook'] ?? '') }}">
                </div>
                <div class="form-group">
                    <label><i class="fab fa-twitter" style="color:#0ea5e9;"></i> Twitter</label>
                    <input type="text" name="twitter" value="{{ old('twitter', $settings['twitter'] ?? '') }}">
                </div>
                <div class="form-group">
                    <label><i class="fab fa-tiktok" style="color:#000000;"></i> TikTok</label>
                    <input type="text" name="tiktok" value="{{ old('tiktok', $settings['tiktok'] ?? '') }}">
                </div>
                <div class="form-group">
                    <label>Google Maps Embed Code</label>
                    <textarea name="maps_embed" rows="3" placeholder="&lt;iframe src='...'&gt;&lt;/iframe&gt;">{{ old('maps_embed', $settings['maps_embed'] ?? '') }}</textarea>
                </div>
            </div>
        </div>

        <div style="margin-top:1.5rem;padding-top:1.5rem;border-top:1px solid var(--gray-200);">
            <button type="submit" class="topbar-btn btn-gold" style="font-size:1rem;padding:12px 28px;">
                <i class="fas fa-save"></i> Simpan Semua Pengaturan
            </button>
        </div>
    </form>
</div>
@endsection
