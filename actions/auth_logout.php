<?php
// 1. Mulai Session (Wajib, supaya server tahu session mana yang mau dihapus)
session_start();

// 2. Panggil Konfigurasi (Untuk ambil BASE_URL)
include '../config/conn.php';

// 3. Hapus Semua Variabel Session
// Ini akan menghapus $_SESSION['username'], $_SESSION['role'], dll.
session_unset();

// 4. Hancurkan Session sepenuhnya dari server
session_destroy();

// 5. Redirect (Tendang) user kembali ke Homepage
// Menggunakan BASE_URL agar arahnya pasti benar ke halaman depan
header("Location: " . BASE_URL . "index.php");

// 6. Hentikan script agar tidak ada kode lain yang jalan
exit();
?>