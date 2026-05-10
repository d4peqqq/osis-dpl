<?php
/**
 * Script untuk membuat symlink storage di cPanel
 * Upload file ini ke dalam folder public_html Anda,
 * lalu jalankan dengan mengakses: namadomain.com/symlink.php
 */

$targetFolder = $_SERVER['DOCUMENT_ROOT'] . '/../osis_app/storage/app/public';
$linkFolder = $_SERVER['DOCUMENT_ROOT'] . '/storage';

echo "Mencoba membuat symlink...<br>";
echo "Target Asli: $targetFolder<br>";
echo "Link Baru: $linkFolder<br><br>";

if (file_exists($linkFolder)) {
    echo "Gagal: Folder 'storage' sudah ada di public_html. Silakan hapus terlebih dahulu (jika ada).";
} else {
    // Membuat symlink
    if (symlink($targetFolder, $linkFolder)) {
        echo "<b style='color:green;'>SUCCESS: Symlink berhasil dibuat!</b><br>";
        echo "Sekarang foto-foto Anda bisa diakses secara publik.";
    } else {
        echo "<b style='color:red;'>ERROR: Gagal membuat Symlink!</b><br>";
        echo "Pastikan fungsi symlink() tidak di-disable di konfigurasi PHP cPanel Anda.";
    }
}
?>
