<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Print Kartu — {{ $anggota->name }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        * { margin:0;padding:0;box-sizing:border-box; }
        body { font-family:'Inter',Arial,sans-serif; background:#f1f5f9; display:flex; flex-direction:column; align-items:center; justify-content:center; min-height:100vh; padding:2rem; }
        .print-wrap { background:white; border-radius:16px; padding:2rem; box-shadow:0 8px 40px rgba(0,0,0,0.1); max-width:600px; width:100%; }
        h1 { font-size:1.2rem; font-weight:700; color:#0a1628; margin-bottom:0.5rem; text-align:center; }
        p { color:#64748b; font-size:0.85rem; text-align:center; margin-bottom:2rem; }
        .card-container { display:flex; justify-content:center; }
        .id-card {
            width:340px; background:linear-gradient(135deg,#0a1628 0%,#1e3a5f 100%);
            border-radius:16px; overflow:hidden; box-shadow:0 10px 40px rgba(0,0,0,0.3);
        }
        .id-card-header { background:#f0a500; padding:12px 20px; display:flex; align-items:center; justify-content:space-between; }
        .id-card-header .school { color:#0a1628; font-weight:800; font-size:0.85rem; }
        .id-card-header .osis-label { color:#132040; font-size:0.65rem; }
        .id-card-header .osis-big { font-size:1.5rem; font-weight:900; color:#0a1628; }
        .id-card-body { padding:16px 20px; display:flex; gap:14px; align-items:flex-start; }
        .member-photo { width:90px; height:90px; border-radius:10px; object-fit:cover; border:3px solid #f0a500; flex-shrink:0; }
        .photo-placeholder { width:90px; height:90px; border-radius:10px; background:rgba(255,255,255,0.1); border:3px solid #f0a500; flex-shrink:0; display:flex; align-items:center; justify-content:center; color:rgba(255,255,255,0.3); font-size:2.5rem; }
        .member-info { flex:1; }
        .member-info .pos { color:#f0a500; font-size:0.7rem; font-weight:700; text-transform:uppercase; letter-spacing:1px; }
        .member-info .name { color:white; font-size:1.1rem; font-weight:800; margin-top:4px; line-height:1.2; }
        .member-info .school { color:rgba(255,255,255,0.5); font-size:0.72rem; margin-top:8px; }
        .id-card-footer { padding:10px 20px 16px; display:flex; align-items:center; justify-content:space-between; border-top:1px solid rgba(255,255,255,0.1); }
        .url-info { }
        .url-info .label { color:rgba(255,255,255,0.4); font-size:0.68rem; }
        .qr-wrap { width:70px; height:70px; background:white; border-radius:6px; padding:4px; }
        .qr-wrap img { width:100%; height:100%; }
        .actions { display:flex; gap:1rem; justify-content:center; margin-top:2rem; flex-wrap:wrap; }
        .btn { padding:10px 24px; border-radius:8px; font-size:0.9rem; font-weight:600; cursor:pointer; border:none; font-family:inherit; display:inline-flex; align-items:center; gap:8px; text-decoration:none; }
        .btn-print { background:#0a1628; color:white; }
        .btn-back { background:#f1f5f9; color:#1e293b; }
        @media print {
            body { background:white; padding:0; }
            .print-wrap { box-shadow:none; border-radius:0; }
            .actions { display:none; }
            h1, p { display:none; }
        }
    </style>
</head>
<body>
    <div class="print-wrap">
        <h1><i style="color:#f0a500;">&#128196;</i> Kartu Anggota OSIS</h1>
        <p>Kartu identitas resmi untuk <strong>{{ $anggota->name }}</strong></p>
        <div class="card-container">
            <div class="id-card">
                <div class="id-card-header">
                    <div>
                        <div class="school">{{ $settings['nama_sekolah'] ?? 'SMA Contoh Bangsa' }}</div>
                        <div class="osis-label">{{ $settings['nama_osis'] ?? 'OSIS SMA' }}</div>
                    </div>
                    <div class="osis-big">OSIS</div>
                </div>
                <div class="id-card-body">
                    @if($anggota->photo && file_exists(public_path('storage/'.$anggota->photo)))
                        <img class="member-photo" src="{{ $anggota->photo_url }}" alt="{{ $anggota->name }}">
                    @else
                        <div class="photo-placeholder">&#128100;</div>
                    @endif
                    <div class="member-info">
                        <div class="pos">{{ $anggota->position }}</div>
                        <div class="name">{{ $anggota->name }}</div>
                        <div class="school">{{ $settings['nama_sekolah'] ?? 'SMA Contoh Bangsa' }}</div>
                    </div>
                </div>
                <div class="id-card-footer">
                    <div class="url-info">
                        <div class="label">Pindai QR untuk profil lengkap</div>
                        <div class="label" style="margin-top:2px;font-size:0.6rem;opacity:0.6;">/anggota/{{ $anggota->slug }}</div>
                    </div>
                    <div class="qr-wrap">
                        <img src="{{ $qrCode }}" alt="QR Code">
                    </div>
                </div>
            </div>
        </div>
        <div class="actions">
            <button class="btn btn-print" onclick="window.print()">&#128438; Cetak Kartu</button>
            <a href="{{ route('admin.kartu-anggota.pdf', $anggota->id) }}" class="btn" style="background:#15803d;color:white;" target="_blank">&#128196; Download PDF</a>
            <a href="{{ route('admin.kartu-anggota.index') }}" class="btn btn-back">&#8592; Kembali</a>
        </div>
    </div>
</body>
</html>
