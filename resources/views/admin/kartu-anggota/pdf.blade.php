<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kartu Anggota — {{ $anggota->name }}</title>
    <style>
        * { margin:0;padding:0;box-sizing:border-box; }
        body { font-family: DejaVu Sans, Arial, sans-serif; background: white; }
        .card-wrap {
            width: 85.6mm; height: 54mm;
            background: linear-gradient(135deg, #0a1628 0%, #1e3a5f 100%);
            border-radius: 6px; overflow: hidden;
            page-break-inside: avoid;
        }
        .card-header {
            background: #f0a500; padding: 4mm 5mm;
            display: flex; align-items: center; justify-content: space-between;
        }
        .card-header .school { font-size: 7pt; font-weight: bold; color: #0a1628; }
        .card-header .osis-label { font-size: 5pt; color: #132040; margin-top: 1pt; }
        .card-header .osis-big { font-size: 12pt; font-weight: 900; color: #0a1628; }
        .card-body { padding: 4mm 5mm; display: flex; gap: 4mm; align-items: flex-start; height: 36mm; }
        .photo-wrap { width: 24mm; height: 28mm; flex-shrink: 0; }
        .photo-wrap img { width: 100%; height: 100%; object-fit: cover; border-radius: 4px; border: 2pt solid #f0a500; }
        .photo-placeholder { width: 100%; height: 100%; background: #1e3a5f; border-radius: 4px; border: 2pt solid #f0a500; display: flex; align-items: center; justify-content: center; }
        .info { flex: 1; }
        .info .pos { font-size: 5.5pt; color: #f0a500; text-transform: uppercase; letter-spacing: 0.5pt; font-weight: bold; }
        .info .name { font-size: 9pt; color: white; font-weight: bold; margin-top: 1pt; line-height: 1.2; }
        .info .school-name { font-size: 5pt; color: rgba(255,255,255,0.5); margin-top: 3pt; }
        .info .desc { font-size: 5pt; color: rgba(255,255,255,0.4); margin-top: 4pt; line-height: 1.4; }
        .card-footer {
            padding: 2mm 5mm; border-top: 0.5pt solid rgba(255,255,255,0.1);
            display: flex; align-items: center; justify-content: space-between;
            height: 14mm;
        }
        .url-text { font-size: 4.5pt; color: rgba(255,255,255,0.4); }
        .qr-box { width: 18mm; height: 18mm; background: white; border-radius: 2px; padding: 1mm; }
        .qr-box img { width: 100%; height: 100%; }
    </style>
</head>
<body>
    <div class="card-wrap">
        <div class="card-header">
            <div>
                <div class="school">{{ $settings['nama_sekolah'] ?? 'SMA Contoh Bangsa' }}</div>
                <div class="osis-label">{{ $settings['nama_osis'] ?? 'OSIS SMA' }}</div>
            </div>
            <div class="osis-big">OSIS</div>
        </div>
        <div class="card-body">
            <div class="photo-wrap">
                @if($anggota->photo && file_exists(public_path('storage/'.$anggota->photo)))
                    <img src="{{ public_path('storage/'.$anggota->photo) }}" alt="{{ $anggota->name }}">
                @else
                    <div class="photo-placeholder"></div>
                @endif
            </div>
            <div class="info">
                <div class="pos">{{ $anggota->position }}</div>
                <div class="name">{{ $anggota->name }}</div>
                <div class="school-name">{{ $settings['nama_sekolah'] ?? 'SMA Contoh Bangsa' }}</div>
                @if($anggota->description)
                    <div class="desc">{{ \Illuminate\Support\Str::limit($anggota->description, 80) }}</div>
                @endif
            </div>
        </div>
        <div class="card-footer">
            <div>
                <div class="url-text">Pindai QR untuk profil</div>
                <div class="url-text" style="margin-top:1pt;">{{ $qrUrl }}</div>
            </div>
            <div class="qr-box">
                <img src="{{ $qrCode }}" alt="QR">
            </div>
        </div>
    </div>
</body>
</html>
