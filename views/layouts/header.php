<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Helper function
function isActive($page)
{
    // Active State: Background Emerald, Teks Putih, Shadow
    return strpos($_SERVER['REQUEST_URI'], $page) !== false ? 'bg-[#059669] text-white shadow-lg ring-2 ring-white/20' : 'hover:bg-white/10 text-blue-100';
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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@500;600;700;800&display=swap" rel="stylesheet">
    <script src="<?= BASE_URL ?>assets/js/script.js" defer></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-[#F8FAFC] font-[Inter] text-slate-800 overflow-x-hidden">

    <nav
        class="fixed top-0 z-50 w-full bg-white border-b-2 border-gray-200 h-20 flex items-center px-6 justify-between shadow-sm">
        <button onclick="toggleSidebar()"
            class="p-2 rounded-full hover:bg-gray-100 text-[#1E3A8A] focus:outline-none transition">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16">
                </path>
            </svg>
        </button>

        <div class="flex items-center gap-6 w-28 md:w-64">
            <a href="<?= BASE_URL ?>index.php"
                class="text-2xl md:text-3xl font-black flex items-center gap-1 text-[#1E3A8A] tracking-tight hover:scale-105 transition">
                Pinda<span class="text-[#059669]">Hand</span>
                <div class="w-3 h-3 md:w-4 md:h-4 rounded-full bg-[#FACC15] ml-1"></div>
            </a>
        </div>

        <div class="hidden md:flex flex-1 max-w-3xl mx-4">
            <div class="relative w-full">
                <span class="absolute inset-y-0 left-0 flex items-center pl-5 text-[#1E3A8A]">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </span>
                <input type="text" placeholder="Cari barang disini..."
                    class="w-full bg-gray-100 border-2 border-transparent text-gray-800 text-base font-medium rounded-full py-3 pl-14 pr-6 focus:outline-none focus:bg-white focus:border-[#1E3A8A] focus:ring-0 transition placeholder-gray-500 shadow-inner">
            </div>
        </div>

        <div class="flex items-center gap-4 md:gap-8">

            <?php if (isset($_SESSION['username'])): ?>
                <a href="<?= BASE_URL ?>views/store/add.php"
                    class="hidden md:flex items-center gap-2 bg-[#FACC15] text-[#1E3A8A] px-5 py-2.5 rounded-full font-bold text-base hover:bg-yellow-300 transition shadow-md border-2 border-[#1E3A8A]/10">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span>Jual</span>
                </a>

                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" class="flex items-center gap-3 focus:outline-none group">
                        <div class="text-right hidden md:block">
                            <p class="text-base font-bold text-[#1E3A8A] leading-tight"><?= $_SESSION['username'] ?></p>
                            <p class="text-xs font-bold text-[#059669] uppercase tracking-wide"><?= $_SESSION['role'] ?></p>
                        </div>
                        <div
                            class="w-10 h-10 md:w-11 md:h-11 rounded-full bg-[#1E3A8A] border-2 border-[#FACC15] flex items-center justify-center text-white font-bold text-lg shadow-md group-hover:scale-105 transition">
                            <?= strtoupper(substr($_SESSION['username'], 0, 1)) ?>
                        </div>
                    </button>

                    <div x-show="open" @click.away="open = false" x-transition
                        class="absolute right-0 mt-4 w-80 bg-white rounded-xl shadow-2xl border-2 border-gray-100 py-2 z-50"
                        style="display: none;">
                        <div class="py-2">
                            <a href="<?= BASE_URL ?>views/user/profile.php"
                                class="flex items-center px-6 py-4 text-base font-bold text-gray-700 hover:bg-blue-50 transition">
                                <span class="w-8 text-xl text-center">👤</span> Profil Saya
                            </a>
                            <a href="<?= BASE_URL ?>views/transaction/history.php"
                                class="flex items-center px-6 py-4 text-base font-bold text-gray-700 hover:bg-blue-50 transition">
                                <span class="w-8 text-xl text-center">📦</span> Riwayat Pesanan
                            </a>
                        </div>
                        <div class="border-t border-gray-200 my-1"></div>
                        <a href="<?= BASE_URL ?>actions/auth_logout.php" onclick="confirmLogout(event)"
                            class="flex items-center px-6 py-4 text-base font-bold text-red-600 hover:bg-red-50 transition">
                            <span class="w-8 text-xl text-center">🚪</span> Keluar (Logout)
                        </a>
                    </div>
                </div>
            <?php else: ?>
                <div class="flex items-center gap-4 text-base font-bold text-gray-600">
                    <a href="<?= BASE_URL ?>views/auth/login.php"
                        class="text-[#1E3A8A] hover:underline decoration-2 underline-offset-4">Masuk</a>
                    <a href="<?= BASE_URL ?>views/auth/register.php"
                        class="bg-[#1E3A8A] text-white px-6 py-2.5 rounded-full hover:bg-blue-900 shadow-lg transition">Daftar</a>
                </div>
            <?php endif; ?>
        </div>
    </nav>

    <aside id="sidebar" class="fixed top-16 left-0 z-40 h-[calc(100vh-4rem)] bg-[#1E3A8A] text-white 
                  w-64 -translate-x-full md:translate-x-0 md:w-64 
                  flex flex-col py-4 shadow-xl border-r border-blue-900 
                  transition-all duration-300 ease-in-out">

        <div id="menu-wrapper" class="flex flex-col gap-2 px-3 w-full mt-6">

            <a href="<?= BASE_URL ?>index.php" class="menu-item flex flex-row items-center gap-4 px-3 py-3 rounded-xl hover:bg-[#059669]/50 transition-all group w-full 
               <?= isActive('index.php') ? 'bg-[#1E3A8A]' : '' ?>">

                <div class="flex-shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                        </path>
                    </svg>
                </div>

                <span
                    class="sidebar-text font-semibold text-sm whitespace-nowrap overflow-hidden transition-all duration-300">
                    Beranda
                </span>
            </a>

            <?php if (isset($_SESSION['username'])): ?>
                <a href="<?= BASE_URL ?>views/store/my_products.php" class="menu-item flex flex-row items-center gap-4 px-3 py-3 rounded-xl hover:bg-[#059669]/50 transition-all group w-full 
                   <?= isActive('my_products.php') ? 'bg-[#1E3A8A]' : '' ?>">

                    <div class="flex-shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m8-2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>

                    <span
                        class="sidebar-text font-semibold text-sm whitespace-nowrap overflow-hidden transition-all duration-300">
                        Toko Saya
                    </span>
                </a>

                <a href="<?= BASE_URL ?>views/user/chat_list.php" class="menu-item flex flex-row items-center gap-4 px-3 py-3 rounded-xl hover:bg-[#059669]/50 transition-all group w-full
                   <?= isActive('chat') ? 'bg-[#1E3A8A]' : '' ?>">

                    <div class="flex-shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                            </path>
                        </svg>
                    </div>

                    <span
                        class="sidebar-text text-sm font-semibold whitespace-nowrap overflow-hidden transition-all duration-300">
                        Pesan
                    </span>

                    <span id="unread-badge"
                        class="hidden ml-auto bg-red-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full border border-[#1E3A8A] shadow-sm transform scale-100 transition-transform duration-200">
                        0
                    </span>
                </a>

                <a href="<?= BASE_URL ?>views/transaction/history.php" class="menu-item flex flex-row items-center gap-4 px-3 py-3 rounded-xl hover:bg-[#059669]/50 transition-all group w-full 
                   <?= isActive('history.php') ? 'bg-[#1E3A8A]' : '' ?>">

                    <div class="flex-shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                            </path>
                        </svg>
                    </div>

                    <span
                        class="sidebar-text font-semibold text-sm whitespace-nowrap overflow-hidden transition-all duration-300">
                        Riwayat
                    </span>
                </a>

                <div class="border-t border-white/20 my-2"></div>

                <a href="<?= BASE_URL ?>views/user/profile.php" class="menu-item flex flex-row items-center gap-4 px-3 py-3 rounded-xl hover:bg-[#059669]/50 transition-all group w-full 
                   <?= isActive('profile.php') ? 'bg-[#1E3A8A]' : '' ?>">

                    <div class="flex-shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>

                    <span
                        class="sidebar-text font-semibold text-sm whitespace-nowrap overflow-hidden transition-all duration-300">
                        Profil Saya
                    </span>
                </a>

            <?php endif; ?>
        </div>
    </aside>

    <div id="main-content"
        class="pt-20 px-6 min-h-screen w-full md:pl-64 transition-all duration-300 ease-in-out flex flex-col">