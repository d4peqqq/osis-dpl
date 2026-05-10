@extends('admin.layouts.sidebar')
@section('title', 'Edit Kegiatan')
@section('page-title', 'Edit Kegiatan')
@section('content')
<div class="breadcrumb"><a href="{{ route('admin.dashboard') }}">Dashboard</a> <i class="fas fa-chevron-right" style="font-size:0.7rem;"></i> <a href="{{ route('admin.kegiatan.index') }}">Kegiatan</a> <i class="fas fa-chevron-right" style="font-size:0.7rem;"></i> Edit</div>
<div class="form-wrap" style="max-width:700px;">
    <form method="POST" action="{{ route('admin.kegiatan.update', $kegiatan) }}" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div class="form-group">
            <label>Judul Kegiatan *</label>
            <input type="text" name="title" value="{{ old('title', $kegiatan->title) }}" required>
            @error('title')<div class="form-error">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label>Pilih Kategori Kepengurusan *</label>
            <select name="gender" required>
                <option value="putra" {{ old('gender', $kegiatan->gender) == 'putra' ? 'selected' : '' }}>Kepengurusan Putra</option>
                <option value="putri" {{ old('gender', $kegiatan->gender) == 'putri' ? 'selected' : '' }}>Kepengurusan Putri</option>
            </select>
            @error('gender')<div class="form-error">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label>Tanggal Kegiatan *</label>
            <input type="date" name="date" value="{{ old('date', $kegiatan->date->format('Y-m-d')) }}" required>
        </div>
        <div class="form-group">
            <label>Deskripsi / Isi *</label>
            <textarea name="body" required>{{ old('body', $kegiatan->body) }}</textarea>
        </div>
        <div class="form-group">
            <label>Foto Kegiatan</label>
            @if($kegiatan->photo)
                <img src="{{ $kegiatan->photo_url }}" class="img-preview" style="margin-bottom:8px;">
            @endif
            <input type="file" name="photo" accept="image/*" onchange="previewImg(this,'prev1')">
            <div class="form-hint">Biarkan kosong jika tidak ingin mengubah foto.</div>
            <img id="prev1" class="img-preview" style="display:none;">
        </div>
        <div class="form-group">
            <div class="form-check">
                <input type="checkbox" name="is_published" id="is_pub" {{ old('is_published', $kegiatan->is_published) ? 'checked' : '' }}>
                <label for="is_pub" style="margin-bottom:0;">Publikasikan</label>
            </div>
        </div>
        <div style="display:flex;gap:1rem;">
            <button type="submit" class="topbar-btn btn-gold"><i class="fas fa-save"></i> Simpan Perubahan</button>
            <a href="{{ route('admin.kegiatan.index') }}" class="topbar-btn" style="background:var(--gray-100);color:var(--text);">Batal</a>
        </div>
    </form>
</div>
@endsection
@section('scripts')
<script>function previewImg(input,id){if(input.files&&input.files[0]){var r=new FileReader();r.onload=function(e){var el=document.getElementById(id);el.src=e.target.result;el.style.display='block';};r.readAsDataURL(input.files[0]);}}</script>
@endsection
