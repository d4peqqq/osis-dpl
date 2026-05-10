@extends('admin.layouts.sidebar')
@section('title', 'Upload Foto')
@section('page-title', 'Upload Foto Galeri')
@section('content')
<div class="breadcrumb"><a href="{{ route('admin.dashboard') }}">Dashboard</a> <i class="fas fa-chevron-right" style="font-size:0.7rem;"></i> <a href="{{ route('admin.galeri.index') }}">Galeri</a> <i class="fas fa-chevron-right" style="font-size:0.7rem;"></i> Upload</div>
<div class="form-wrap" style="max-width:600px;">
    <form method="POST" action="{{ route('admin.galeri.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label>Judul Foto *</label>
            <input type="text" name="title" value="{{ old('title') }}" required placeholder="Contoh: Foto Pentas Seni 2024">
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
            <label>Foto *</label>
            <input type="file" name="photo" accept="image/*" required onchange="previewImg(this,'prev1')">
            <div class="form-hint">Format: JPG, PNG, WEBP. Maks 10MB.</div>
            <img id="prev1" class="img-preview" style="display:none;width:100%;max-height:200px;object-fit:cover;">
            @error('photo')<div class="form-error">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label>Kegiatan Terkait (Opsional)</label>
            <select name="kegiatan_id">
                <option value="">-- Pilih Kegiatan --</option>
                @foreach($kegiatan as $k)
                    <option value="{{ $k->id }}" {{ old('kegiatan_id') == $k->id ? 'selected' : '' }}>{{ $k->title }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Urutan Tampil</label>
            <input type="number" name="order" value="{{ old('order', 0) }}" min="0">
        </div>
        <div style="display:flex;gap:1rem;">
            <button type="submit" class="topbar-btn btn-gold"><i class="fas fa-upload"></i> Upload Foto</button>
            <a href="{{ route('admin.galeri.index') }}" class="topbar-btn" style="background:var(--gray-100);color:var(--text);">Batal</a>
        </div>
    </form>
</div>
@endsection
@section('scripts')
<script>function previewImg(input,id){if(input.files&&input.files[0]){var r=new FileReader();r.onload=function(e){var el=document.getElementById(id);el.src=e.target.result;el.style.display='block';};r.readAsDataURL(input.files[0]);}}</script>
@endsection
