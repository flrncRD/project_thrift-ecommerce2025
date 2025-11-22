<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Helper function untuk set menu aktif
function isActive($page)
{
    // Cek apakah URL saat ini mengandung kata kunci halaman
    return strpos($_SERVER['REQUEST_URI'], $page) !== false ? 'bg-[#059669] text-white shadow-md' : 'hover:bg-blue-800 text-blue-100';
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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="<?= BASE_URL ?>assets/js/script.js" defer></script>
</head>

<body class="bg-[#F8FAFC] font-[Inter] text-slate-800 overflow-x-hidden">

    <nav
        class="fixed top-0 z-50 w-full bg-white border-b border-gray-200 shadow-sm h-16 flex items-center px-4 justify-between transition-all duration-300">

        <div class="flex items-center gap-4">
            <button onclick="toggleSidebar()"
                class="p-2 rounded-lg hover:bg-gray-100 text-[#1E3A8A] focus:outline-none transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h7">
                    </path>
                </svg>
            </button>

            <a href="<?= BASE_URL ?>index.php"
                class="text-xl font-extrabold flex items-center gap-1 text-[#1E3A8A] tracking-tight">
                Pinda<span class="text-[#059669]">Hand</span>
                <div class="w-2 h-2 rounded-full bg-[#FACC15] ml-1 animate-pulse"></div>
            </a>
        </div>

        <div class="hidden md:flex flex-1 max-w-2xl mx-8">
            <div class="relative w-full group">
                <input type="text" placeholder="Cari jaket vintage, sneakers..."
                    class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-full focus:ring-2 focus:ring-[#1E3A8A] focus:border-[#1E3A8A] block w-full pl-5 p-2.5 transition-all">
                <button class="absolute right-0 top-0 h-full px-4 text-gray-500 hover:text-[#1E3A8A] transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </button>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <?php if (isset($_SESSION['username'])): ?>
                <a href="<?= BASE_URL ?>views/store/add.php"
                    class="hidden md:flex items-center gap-2 bg-gray-100 hover:bg-gray-200 text-[#1E3A8A] px-4 py-2 rounded-full font-bold text-sm transition-all hover:shadow-md">
                    <span>+ Jual</span>
                </a>

                <div class="flex items-center gap-3 border-l border-gray-300 pl-4 ml-2">
                    <div class="text-right hidden md:block leading-tight">
                        <p class="text-sm font-bold text-[#1E3A8A]"><?= $_SESSION['username'] ?></p>
                        <p class="text-[10px] text-gray-500 font-semibold uppercase tracking-wide"><?= $_SESSION['role'] ?>
                        </p>
                    </div>
                    <div
                        class="w-9 h-9 rounded-full bg-gradient-to-br from-[#1E3A8A] to-blue-700 text-white flex items-center justify-center font-bold shadow-sm border-2 border-white">
                        <?= strtoupper(substr($_SESSION['username'], 0, 1)) ?>
                    </div>
                </div>
            <?php else: ?>
                <a href="<?= BASE_URL ?>views/auth/login.php"
                    class="text-sm font-bold text-white bg-[#1E3A8A] px-5 py-2 rounded-full hover:bg-blue-900 shadow-lg shadow-blue-900/30 transition transform hover:-translate-y-0.5">
                    Login
                </a>
            <?php endif; ?>
        </div>
    </nav>

    <aside id="sidebar"
        class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform duration-300 ease-in-out -translate-x-full bg-[#1E3A8A] border-r border-blue-800 shadow-2xl transform">
        <div class="h-full px-4 pb-4 overflow-y-auto flex flex-col justify-between">

            <div>
                <ul class="space-y-1 font-medium mt-4">
                    <li>
                        <a href="<?= BASE_URL ?>index.php"
                            class="flex items-center p-3 rounded-lg group transition-all <?= isActive('index.php') ?>">
                            <span class="text-xl">🏠</span>
                            <span class="ml-3">Beranda</span>
                        </a>
                    </li>
                </ul>

                <div class="border-t border-blue-700/50 my-4"></div>

                <?php if (isset($_SESSION['username'])): ?>
                    <p class="px-3 text-xs font-bold text-blue-400 uppercase mb-2 tracking-wider">Menu Saya</p>
                    <ul class="space-y-1 font-medium">
                        <li>
                            <a href="<?= BASE_URL ?>views/transaction/cart.php"
                                class="flex items-center p-3 rounded-lg group transition-all <?= isActive('cart.php') ?>">
                                <span class="text-xl">🛒</span>
                                <span class="ml-3">Keranjang</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= BASE_URL ?>views/store/my_products.php"
                                class="flex items-center p-3 rounded-lg group transition-all <?= isActive('my_products.php') ?>">
                                <span class="text-xl">🏪</span>
                                <span class="ml-3">Toko Saya</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= BASE_URL ?>views/transaction/history.php"
                                class="flex items-center p-3 rounded-lg group transition-all <?= isActive('history.php') ?>">
                                <span class="text-xl">📜</span>
                                <span class="ml-3">Riwayat Transaksi</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= BASE_URL ?>views/user/profile.php"
                                class="flex items-center p-3 rounded-lg group transition-all <?= isActive('profile.php') ?>">
                                <span class="text-xl">⚙️</span>
                                <span class="ml-3">Pengaturan Profil</span>
                            </a>
                        </li>
                    </ul>
                <?php endif; ?>
            </div>

            <?php if (isset($_SESSION['username'])): ?>
                <div class="mb-20 md:mb-4">
                    <a href="<?= BASE_URL ?>actions/auth_logout.php"
                        class="flex items-center p-3 rounded-lg bg-blue-900/50 text-red-300 hover:bg-red-600 hover:text-white group transition-all border border-blue-800 hover:border-red-500">
                        <span class="text-xl">🚪</span>
                        <span class="ml-3 font-bold">Logout</span>
                    </a>
                </div>
            <?php endif; ?>

        </div>
    </aside>

    <div id="main-content" class="p-6 transition-all duration-300 pt-24 min-h-screen w-full">

        <div id="main-content" class="p-6 transition-all duration-300 pt-24 min-h-screen">