<?php
// Session start hanya disini untuk seluruh halaman
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PindaHand - Thrift Shop</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
</head>

<body class="bg-[#F8FAFC] font-[Inter] text-slate-800 flex flex-col min-h-screen">

    <nav class="bg-[#1E3A8A] text-white sticky top-0 z-50 shadow-md">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">

            <a href="<?= BASE_URL ?>index.php" class="text-2xl font-extrabold flex items-center gap-1">
                Pinda<span class="text-[#34D399]">Hand</span>
                <div class="w-2 h-2 rounded-full bg-[#FACC15] ml-1"></div>
            </a>

            <div class="hidden md:block w-1/3 relative">
                <input type="text" placeholder="Cari barang thrift..."
                    class="w-full px-4 py-2 rounded-full text-slate-900 focus:outline-none focus:ring-2 focus:ring-[#059669]">
            </div>

            <div class="flex items-center gap-6 text-sm font-medium">
                <?php if (isset($_SESSION['username'])): ?>

                    <?php if ($_SESSION['role'] == 'admin'): ?>
                        <a href="<?= BASE_URL ?>views/admin/dashboard.php" class="hover:text-[#FACC15]">Dashboard Admin</a>
                    <?php else: ?>
                        <a href="<?= BASE_URL ?>views/store/my_products.php" class="hover:text-[#FACC15]">Toko Saya</a>
                        <a href="<?= BASE_URL ?>views/transaction/cart.php" class="hover:text-[#FACC15]">Keranjang</a>
                        <a href="<?= BASE_URL ?>views/user/profile.php" class="hover:text-[#FACC15]">Profil</a>
                    <?php endif; ?>

                    <a href="<?= BASE_URL ?>actions/auth_logout.php"
                        class="bg-red-600/80 hover:bg-red-600 px-4 py-2 rounded text-white transition">Logout</a>

                <?php else: ?>

                    <a href="<?= BASE_URL ?>views/auth/login.php" class="hover:text-gray-300">Masuk</a>
                    <a href="<?= BASE_URL ?>views/auth/register.php"
                        class="bg-[#FACC15] text-[#1E3A8A] px-5 py-2 rounded font-bold hover:bg-yellow-300 transition">Daftar</a>

                <?php endif; ?>
            </div>
        </div>
    </nav>

    <div class="flex-grow">