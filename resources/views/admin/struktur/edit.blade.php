@extends('admin.layouts.sidebar')
@section('title', 'Edit Anggota')
@section('page-title', 'Edit Anggota OSIS')
@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css">
@endsection
@section('content')
<div class="breadcrumb"><a href="{{ route('admin.dashboard') }}">Dashboard</a> <i class="fas fa-chevron-right" style="font-size:0.7rem;"></i> <a href="{{ route('admin.struktur.index') }}">Struktur</a> <i class="fas fa-chevron-right" style="font-size:0.7rem;"></i> Edit</div>
<div class="form-wrap" style="max-width:700px;">
    <form method="POST" action="{{ route('admin.struktur.update', $struktur) }}" enctype="multipart/form-data">
        @csrf @method('PUT')
        <input type="hidden" name="cropped_photo" id="cropped_photo">
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
            <div class="form-group">
                <label>Nama Lengkap *</label>
                <input type="text" name="name" value="{{ old('name', $struktur->name) }}" required>
            </div>
            <div class="form-group">
                <label>Jabatan *</label>
                <input type="text" name="position" value="{{ old('position', $struktur->position) }}" required>
            </div>
        </div>
        <div class="form-group">
            <label>Jenis Kelamin / Divisi *</label>
            <div style="display:flex;gap:1rem;margin-top:6px;">
                <label style="display:flex;align-items:center;gap:8px;cursor:pointer;padding:10px 20px;border:2px solid var(--gray-200);border-radius:10px;flex:1;transition:all .2s;"
                    id="lbl-putra">
                    <input type="radio" name="gender" value="putra" {{ old('gender', $struktur->gender ?? 'putra') == 'putra' ? 'checked' : '' }} onchange="highlightGender()" style="display:none;">
                    <span style="font-size:1.4rem;">🧑</span>
                    <div>
                        <div style="font-weight:700;color:#1e40af;">Putra</div>
                        <div style="font-size:0.75rem;color:var(--gray-600);">Pengurus pria</div>
                    </div>
                </label>
                <label style="display:flex;align-items:center;gap:8px;cursor:pointer;padding:10px 20px;border:2px solid var(--gray-200);border-radius:10px;flex:1;transition:all .2s;"
                    id="lbl-putri">
                    <input type="radio" name="gender" value="putri" {{ old('gender', $struktur->gender) == 'putri' ? 'checked' : '' }} onchange="highlightGender()" style="display:none;">
                    <span style="font-size:1.4rem;">👩</span>
                    <div>
                        <div style="font-weight:700;color:#be185d;">Putri</div>
                        <div style="font-size:0.75rem;color:var(--gray-600);">Pengurus wanita</div>
                    </div>
                </label>
            </div>
            @error('gender')<div class="form-error">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label>Deskripsi</label>
            <textarea name="description">{{ old('description', $struktur->description) }}</textarea>
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
            <div class="form-group">
                <label>Foto Profil</label>
                @if($struktur->photo)
                    <img src="{{ $struktur->photo_url }}" style="width:80px;height:80px;border-radius:50%;object-fit:cover;border:3px solid var(--gold);margin-bottom:8px;display:block;">
                @endif
                <input type="file" name="photo" accept="image/*" onchange="previewImg(this,'prev1')">
                <div class="form-hint">Biarkan kosong jika tidak ingin mengubah.</div>
                
                <div id="cropBox" style="display:none; margin-top:10px; background:var(--gray-100); padding:10px; border-radius:8px;">
                    <div style="max-width:300px; max-height:250px; margin-bottom:10px; overflow:hidden;">
                        <img id="imageToCrop" style="max-width:100%; display:block;">
                    </div>
                    <button type="button" id="cropBtn" class="topbar-btn btn-gold" style="padding:6px 14px; font-size:0.8rem;"><i class="fas fa-crop"></i> Terapkan Potongan</button>
                    <div class="form-hint" style="margin-top:6px;">Geser dan sesuaikan kotak pada bagian foto yang ingin digunakan.</div>
                </div>

                <img id="prev1" class="img-preview" style="display:none;width:120px;height:120px;object-fit:cover;border-radius:50%;border:4px solid var(--gold);margin-top:12px;">
            </div>
            <div class="form-group">
                <label>Urutan Tampil</label>
                <input type="number" name="order" value="{{ old('order', $struktur->order) }}" min="0">
                <div class="form-hint">Slug: <code>{{ $struktur->slug }}</code></div>
            </div>
        </div>
        <div class="form-group">
            <label>Status Keanggotaan</label>
            <select name="is_active" required>
                <option value="1" {{ old('is_active', $struktur->is_active) ? 'selected' : '' }}>Aktif (Tampil di Website)</option>
                <option value="0" {{ old('is_active', $struktur->is_active) == false ? 'selected' : '' }}>Tidak Aktif (Sembunyikan)</option>
            </select>
        </div>
        <div style="display:flex;gap:1rem;">
            <button type="submit" class="topbar-btn btn-gold"><i class="fas fa-save"></i> Simpan Perubahan</button>
            <a href="{{ route('admin.struktur.index') }}" class="topbar-btn" style="background:var(--gray-100);color:var(--text);">Batal</a>
        </div>
    </form>
</div>
@endsection
@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>
<script>
let cropper;
function previewImg(input, id){
    if(input.files && input.files[0]){
        document.getElementById('cropped_photo').value = ''; 
        document.getElementById(id).style.display = 'none';

        var r = new FileReader();
        r.onload = function(e){
            let img = document.getElementById('imageToCrop');
            img.src = e.target.result;
            document.getElementById('cropBox').style.display = 'block';
            
            if(cropper) cropper.destroy();
            cropper = new Cropper(img, {
                aspectRatio: 1,
                viewMode: 1,
                autoCropArea: 1,
            });
        };
        r.readAsDataURL(input.files[0]);
    }
}
document.getElementById('cropBtn').addEventListener('click', function() {
    if(cropper){
        let canvas = cropper.getCroppedCanvas({ width: 400, height: 400 });
        let dataURL = canvas.toDataURL('image/png');
        document.getElementById('cropped_photo').value = dataURL;
        document.getElementById('prev1').src = dataURL;
        document.getElementById('prev1').style.display = 'block';
        document.getElementById('cropBox').style.display = 'none';
        cropper.destroy();
        cropper = null;
    }
});
function highlightGender(){
    const putraChecked = document.querySelector('input[name="gender"][value="putra"]').checked;
    const lp = document.getElementById('lbl-putra');
    const lpt = document.getElementById('lbl-putri');
    if(putraChecked){
        lp.style.borderColor='#3b82f6'; lp.style.background='#eff6ff';
        lpt.style.borderColor='var(--gray-200)'; lpt.style.background='';
    } else {
        lpt.style.borderColor='#ec4899'; lpt.style.background='#fdf2f8';
        lp.style.borderColor='var(--gray-200)'; lp.style.background='';
    }
}
highlightGender(); // init on load
</script>
@endsection
