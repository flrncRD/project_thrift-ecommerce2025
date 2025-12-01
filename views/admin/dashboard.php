<?php
session_start();
include '../../config/conn.php';

// Cek Admin
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: " . BASE_URL . "index.php");
    exit();
}

// Data Dummy (Untuk Demo)
$totalUser = 15;
$totalReport = 3;
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <title>Admin Panel - PindaHand</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body class="bg-gray-100 font-[Inter]">

    <div class="flex">

        <?php include '../../views/layouts/sidebar_admin.php'; ?>

        <main class="flex-1 ml-64 p-8">

            <header class="flex justify-between items-center mb-8 bg-white p-4 rounded-lg shadow-sm">
                <h2 class="text-2xl font-bold text-slate-800">Overview Sistem</h2>
                <div class="flex items-center gap-2">
                    <span class="text-sm font-semibold text-gray-500">Halo, Admin</span>
                    <div class="w-8 h-8 bg-[#059669] rounded-full"></div>
                </div>
            </header>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                <div class="bg-white p-6 rounded-lg shadow border-l-4 border-blue-500">
                    <p class="text-gray-500 text-sm uppercase font-bold">Total Pengguna</p>
                    <p class="text-3xl font-bold text-slate-800 mt-2"><?= $totalUser ?></p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow border-l-4 border-red-500">
                    <p class="text-gray-500 text-sm uppercase font-bold">Laporan Masuk</p>
                    <p class="text-3xl font-bold text-red-600 mt-2"><?= $totalReport ?></p>
                    <p class="text-xs text-red-400 mt-1">Butuh tindakan segera</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow border-l-4 border-emerald-500">
                    <p class="text-gray-500 text-sm uppercase font-bold">Produk Aktif</p>
                    <p class="text-3xl font-bold text-emerald-600 mt-2">120</p>
                </div>
            </div>

            <div
                class="bg-white rounded-lg shadow p-6 h-64 flex items-center justify-center text-gray-400 border-2 border-dashed border-gray-200">
                Area Grafik / Tabel Terbaru akan muncul di sini.
            </div>

        </main>
    </div>

</body>

</html>