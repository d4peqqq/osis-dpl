@extends('admin.layouts.sidebar')
@section('title', 'Tambah Kegiatan')
@section('page-title', 'Tambah Kegiatan Baru')
@section('content')
<div class="breadcrumb"><a href="{{ route('admin.dashboard') }}">Dashboard</a> <i class="fas fa-chevron-right" style="font-size:0.7rem;"></i> <a href="{{ route('admin.kegiatan.index') }}">Kegiatan</a> <i class="fas fa-chevron-right" style="font-size:0.7rem;"></i> Tambah</div>
<div class="form-wrap" style="max-width:700px;">
    <form method="POST" action="{{ route('admin.kegiatan.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label>Judul Kegiatan *</label>
            <input type="text" name="title" value="{{ old('title') }}" required placeholder="Contoh: Pentas Seni Tahunan 2024">
            @error('title')<div class="form-error">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label>Pilih Kategori Kepengurusan *</label>
            <select name="gender" required>
                <option value="putra" {{ old('gender') == 'putra' ? 'selected' : '' }}>Kepengurusan Putra</option>
                <option value="putri" {{ old('gender') == 'putri' ? 'selected' : '' }}>Kepengurusan Putri</option>
            </select>
            @error('gender')<div class="form-error">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label>Tanggal Kegiatan *</label>
            <input type="date" name="date" value="{{ old('date', date('Y-m-d')) }}" required>
            @error('date')<div class="form-error">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label>Deskripsi / Isi *</label>
            <textarea name="body" required placeholder="Tulis deskripsi lengkap kegiatan di sini...">{{ old('body') }}</textarea>
            @error('body')<div class="form-error">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label>Foto Kegiatan</label>
            <input type="file" name="photo" accept="image/*" onchange="previewImg(this,'prev1')">
            <div class="form-hint">Format: JPG, PNG, WEBP. Maks 10MB.</div>
            <img id="prev1" class="img-preview" style="display:none;">
            @error('photo')<div class="form-error">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <div class="form-check">
                <input type="checkbox" name="is_published" id="is_pub" {{ old('is_published', true) ? 'checked' : '' }}>
                <label for="is_pub" style="margin-bottom:0;">Publikasikan langsung</label>
            </div>
        </div>
        <div style="display:flex;gap:1rem;">
            <button type="submit" class="topbar-btn btn-gold"><i class="fas fa-save"></i> Simpan Kegiatan</button>
            <a href="{{ route('admin.kegiatan.index') }}" class="topbar-btn" style="background:var(--gray-100);color:var(--text);">Batal</a>
        </div>
    </form>
</div>
@endsection
@section('scripts')
<script>function previewImg(input,id){if(input.files&&input.files[0]){var r=new FileReader();r.onload=function(e){var el=document.getElementById(id);el.src=e.target.result;el.style.display='block';};r.readAsDataURL(input.files[0]);}}</script>
@endsection
