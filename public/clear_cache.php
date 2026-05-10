<?php
/**
 * PERINGATAN: Hapus file ini dari hosting setelah digunakan!
 * Cache Cleaner - Untuk membersihkan view cache Laravel
 */

// Keamanan sederhana - ganti dengan password Anda
$secret = 'osis2024clear';
if (!isset($_GET['key']) || $_GET['key'] !== $secret) {
    die('<h2 style="color:red;font-family:sans-serif;">❌ Akses ditolak. Tambahkan ?key=osis2024clear di URL</h2>');
}

$basePath = dirname(__DIR__);
$cleared  = [];
$errors   = [];

// Direktori yang perlu dibersihkan
$targets = [
    'View Cache'      => $basePath . '/storage/framework/views',
    'Config Cache'    => $basePath . '/bootstrap/cache',
];

foreach ($targets as $label => $dir) {
    if (!is_dir($dir)) {
        $errors[] = "$label: direktori tidak ditemukan ($dir)";
        continue;
    }
    $files = glob($dir . '/*');
    $count = 0;
    foreach ($files as $file) {
        if (is_file($file) && basename($file) !== '.gitignore') {
            if (unlink($file)) {
                $count++;
            } else {
                $errors[] = "Gagal hapus: " . basename($file);
            }
        }
    }
    $cleared[] = "$label: $count file dihapus";
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Cache Cleaner</title>
<style>
  body { font-family: 'Segoe UI', sans-serif; background: #f0f4f8; display:flex; align-items:center; justify-content:center; min-height:100vh; margin:0; }
  .card { background:white; border-radius:12px; padding:2rem 2.5rem; box-shadow:0 4px 20px rgba(0,0,0,0.1); max-width:480px; width:100%; }
  h2 { color: #050d1a; margin-bottom:1.5rem; }
  .ok   { background:#d1fae5; color:#065f46; border:1px solid #a7f3d0; padding:10px 14px; border-radius:8px; margin:6px 0; font-size:0.9rem; }
  .err  { background:#fee2e2; color:#991b1b; border:1px solid #fca5a5; padding:10px 14px; border-radius:8px; margin:6px 0; font-size:0.9rem; }
  .warn { background:#fef9c3; color:#854d0e; border:1px solid #fde047; padding:12px 14px; border-radius:8px; margin-top:1.5rem; font-size:0.85rem; }
</style>
</head>
<body>
<div class="card">
  <h2>🧹 Laravel Cache Cleaner</h2>
  <?php foreach ($cleared as $msg): ?>
    <div class="ok">✅ <?= htmlspecialchars($msg) ?></div>
  <?php endforeach; ?>
  <?php foreach ($errors as $err): ?>
    <div class="err">❌ <?= htmlspecialchars($err) ?></div>
  <?php endforeach; ?>
  <?php if (empty($errors)): ?>
    <div class="ok" style="margin-top:1rem;font-weight:600;">🎉 Semua cache berhasil dibersihkan!</div>
  <?php endif; ?>
  <div class="warn">
    ⚠️ <strong>Penting:</strong> Segera hapus file <code>clear_cache.php</code> dari folder <code>public/</code> hosting Anda setelah selesai!
  </div>
</div>
</body>
</html>
