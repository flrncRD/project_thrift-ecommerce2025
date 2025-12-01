<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Helper function untuk set menu aktif
function isActive($page)
{
    // Active State: Background Emerald, Teks Putih, Shadow
    return strpos($_SERVER['REQUEST_URI'], $page) !== false ? 'bg-[#059669] text-white shadow-lg ring-2 ring-white/20' : 'hover:bg-white/10 text-blue-100';
}

$cats_header = mysqli_query($conn, "SELECT * FROM kategori");
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PindaHand - Thrift Shop</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
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

        <div class="flex items-center gap-4 md:gap-6 w-auto md:w-64">
            <button onclick="toggleSidebar()"
                class="p-2 rounded-full hover:bg-gray-100 text-[#1E3A8A] focus:outline-none transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16">
                    </path>
                </svg>
            </button>

            <a href="<?= BASE_URL ?>index.php"
                class="text-2xl md:text-3xl font-black flex items-center gap-1 text-[#1E3A8A] tracking-tight hover:scale-105 transition">
                Pinda<span class="text-[#059669]">Hand</span>
                <div class="w-3 h-3 md:w-4 md:h-4 rounded-full bg-[#FACC15] ml-1"></div>
            </a>
        </div>

        <div class="hidden md:flex flex-1 max-w-3xl mx-4 relative z-50">
            <form action="<?= BASE_URL ?>views/market/search.php" method="GET" class="relative w-full flex" x-data="{ 
                        catOpen: false, 
                        selectedCats: <?= isset($_GET['kategori']) ? htmlspecialchars(json_encode((array) $_GET['kategori']), ENT_QUOTES, 'UTF-8') : '[]' ?>,
                        
                        toggleCat(id) {
                            if (this.selectedCats.includes(id)) {
                                this.selectedCats = this.selectedCats.filter(c => c != id);
                            } else {
                                this.selectedCats.push(id);
                            }
                        },
                        
                        get label() {
                            if (this.selectedCats.length === 0) return 'Semua Kategori';
                            if (this.selectedCats.length === 1) return '1 Kategori';
                            return this.selectedCats.length + ' Kategori';
                        }
                    }">

                <div class="relative">
                    <button type="button" @click="catOpen = !catOpen"
                        class="h-full bg-gray-100 border-r border-gray-300 text-gray-700 text-sm rounded-l-full pl-5 pr-8 py-3 focus:outline-none hover:bg-gray-200 transition font-bold flex items-center gap-2 whitespace-nowrap w-40 justify-between">
                        <span x-text="label"></span>
                        <svg class="w-4 h-4 text-gray-500 transform transition-transform duration-200"
                            :class="{'rotate-180': catOpen}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </button>

                    <div x-show="catOpen" @click.away="catOpen = false" x-transition
                        class="absolute top-full left-0 mt-2 w-64 bg-white rounded-xl shadow-xl border border-gray-100 py-2 z-50 overflow-hidden"
                        style="display: none;">
                        <div class="px-4 py-2 text-xs font-bold text-gray-400 uppercase tracking-wider">Pilih Kategori
                        </div>
                        <?php
                        if (isset($conn)) {
                            mysqli_data_seek($cats_header, 0);
                            while ($c = mysqli_fetch_assoc($cats_header)):
                                ?>
                                <div @click="toggleCat('<?= $c['id'] ?>')"
                                    class="px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 cursor-pointer flex items-center gap-3 transition select-none">
                                    <div class="w-4 h-4 border border-gray-300 rounded flex items-center justify-center transition"
                                        :class="selectedCats.includes('<?= $c['id'] ?>') ? 'bg-[#059669] border-[#059669]' : 'bg-white'">
                                        <svg x-show="selectedCats.includes('<?= $c['id'] ?>')" class="w-3 h-3 text-white"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>
                                    <span
                                        :class="selectedCats.includes('<?= $c['id'] ?>') ? 'font-bold text-[#1E3A8A]' : ''"><?= $c['nama_kategori'] ?></span>
                                </div>
                            <?php endwhile;
                        } ?>
                        <div x-show="selectedCats.length > 0" @click="selectedCats = []"
                            class="border-t mt-2 pt-2 pb-1 px-4 text-xs text-red-500 hover:underline cursor-pointer text-center">
                            Reset Filter</div>
                    </div>
                </div>

                <template x-for="id in selectedCats"><input type="hidden" name="kategori[]" :value="id"></template>

                <input type="text" name="keyword" placeholder="Cari barang disini..."
                    class="w-full bg-gray-100 border-2 border-transparent text-gray-800 text-base font-medium py-3 pl-4 pr-12 focus:outline-none focus:bg-white focus:border-[#1E3A8A] focus:ring-0 transition placeholder-gray-500 shadow-inner rounded-r-full"
                    value="<?= isset($_GET['keyword']) ? htmlspecialchars($_GET['keyword']) : '' ?>">

                <button type="submit"
                    class="absolute right-0 top-0 h-full bg-[#1E3A8A] text-white rounded-r-full px-6 hover:bg-blue-900 transition flex items-center justify-center z-10">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </button>
            </form>
        </div>

        <div class="flex items-center gap-4 md:gap-6">
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
                                <div class="flex-shrink-0 w-6 text-center mr-4">
                                    <i class="fa-solid fa-user text-lg"></i>
                                </div>Profil Saya
                            </a>
                            <a href="<?= BASE_URL ?>views/transaction/history.php"
                                class="flex items-center px-6 py-4 text-base font-bold text-gray-700 hover:bg-blue-50 transition">
                                <div class="flex-shrink-0 w-6 text-center mr-4">
                                    <i class="fa-solid fa-clock-rotate-left text-lg"></i>
                                </div>Riwayat Pesanan
                            </a>
                        </div>
                        <div class="border-t border-gray-200 my-1"></div>
                        <a href="<?= BASE_URL ?>actions/auth_logout.php" onclick="confirmLogout(event)"
                            class="flex items-center px-6 py-4 text-base font-bold text-red-600 hover:bg-red-50 transition">
                            <div class="flex-shrink-0 w-6 text-center mr-4">
                                <i class="fa-solid fa-right-from-bracket text-lg"></i>
                            </div>Keluar (Logout)
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

    <div class="fixed top-20 left-0 w-full bg-white border-b border-gray-200 p-3 z-30 md:hidden shadow-sm">

        <form action="<?= BASE_URL ?>views/market/search.php" method="GET" class="relative w-full flex" x-data="{ 
                        catOpen: false, 
                        selectedCats: <?= isset($_GET['kategori']) ? htmlspecialchars(json_encode((array) $_GET['kategori']), ENT_QUOTES, 'UTF-8') : '[]' ?>,
                        toggleCat(id) { if (this.selectedCats.includes(id)) { this.selectedCats = this.selectedCats.filter(c => c != id); } else { this.selectedCats.push(id); } },
                        get label() { if (this.selectedCats.length === 0) return 'Kategori'; return this.selectedCats.length; }
                    }">

            <div class="relative">
                <button type="button" @click="catOpen = !catOpen"
                    class="h-full bg-gray-100 border-r border-gray-300 text-gray-700 text-xs rounded-l-lg pl-3 pr-6 py-3 focus:outline-none font-bold flex items-center gap-1 whitespace-nowrap min-w-[90px] justify-between">
                    <span x-text="label"></span>
                    <svg class="w-3 h-3 text-gray-500 transform transition-transform duration-200"
                        :class="{'rotate-180': catOpen}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div x-show="catOpen" @click.away="catOpen = false" x-transition
                    class="absolute top-full left-0 mt-1 w-56 bg-white rounded-lg shadow-xl border border-gray-100 py-2 z-50 max-h-60 overflow-y-auto"
                    style="display: none;">
                    <?php
                    if (isset($conn)) {
                        // PENTING: Reset pointer query agar bisa dipakai lagi
                        mysqli_data_seek($cats_header, 0);
                        while ($c = mysqli_fetch_assoc($cats_header)):
                            ?>
                            <div @click="toggleCat('<?= $c['id'] ?>')"
                                class="px-4 py-3 text-sm text-gray-700 border-b border-gray-50 flex items-center gap-3 active:bg-gray-100">
                                <div class="w-4 h-4 border border-gray-300 rounded flex items-center justify-center"
                                    :class="selectedCats.includes('<?= $c['id'] ?>') ? 'bg-[#059669] border-[#059669]' : 'bg-white'">
                                    <svg x-show="selectedCats.includes('<?= $c['id'] ?>')" class="w-3 h-3 text-white"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                            d="M5 13l4 4L19 7">
                                        </path>
                                    </svg>
                                </div>
                                <span
                                    :class="selectedCats.includes('<?= $c['id'] ?>') ? 'font-bold text-[#1E3A8A]' : ''"><?= $c['nama_kategori'] ?></span>
                            </div>
                        <?php endwhile;
                    } ?>
                </div>
            </div>

            <template x-for="id in selectedCats"><input type="hidden" name="kategori[]" :value="id"></template>
            <input type="text" name="keyword" placeholder="Cari barang..."
                class="w-full bg-gray-100 border-none text-gray-800 text-sm font-medium py-3 pl-3 pr-10 focus:outline-none focus:bg-white focus:ring-1 focus:ring-[#1E3A8A] transition shadow-inner rounded-r-lg"
                value="<?= isset($_GET['keyword']) ? htmlspecialchars($_GET['keyword']) : '' ?>">
            <button type="submit"
                class="absolute right-0 top-0 h-full bg-[#1E3A8A] text-white rounded-r-lg px-4 flex items-center justify-center"><svg
                    class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg></button>
        </form>
    </div>

    <div class="flex items-center gap-4 md:gap-6">

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
                            <div class="flex-shrink-0 w-6 text-center mr-4">
                                <i class="fa-solid fa-user text-lg"></i>
                            </div>Profil Saya
                        </a>
                        <a href="<?= BASE_URL ?>views/transaction/history.php"
                            class="flex items-center px-6 py-4 text-base font-bold text-gray-700 hover:bg-blue-50 transition">
                            <div class="flex-shrink-0 w-6 text-center mr-4">
                                <i class="fa-solid fa-clock-rotate-left text-lg"></i>
                            </div>Riwayat Pesanan
                        </a>
                    </div>

                    <div class="border-t border-gray-200 my-1"></div>

                    <a href="<?= BASE_URL ?>actions/auth_logout.php" onclick="confirmLogout(event)"
                        class="flex items-center px-6 py-4 text-base font-bold text-red-600 hover:bg-red-50 transition">
                        <div class="flex-shrink-0 w-6 text-center mr-4">
                            <i class="fa-solid fa-right-from-bracket text-lg"></i>
                        </div>Keluar (Logout)
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

            <a href="<?= BASE_URL ?>index.php"
                class="menu-item flex flex-row items-center gap-4 px-3 py-3 rounded-xl hover:bg-[#059669]/50 transition-all group w-full <?= isActive('index.php') ? 'bg-[#1E3A8A]' : '' ?>">
                <div class="flex-shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                        </path>
                    </svg>
                </div>
                <span
                    class="sidebar-text font-semibold text-sm whitespace-nowrap overflow-hidden transition-all duration-300">Beranda</span>
            </a>

            <?php if (isset($_SESSION['username'])): ?>

                <a href="<?= BASE_URL ?>views/store/my_products.php"
                    class="menu-item flex flex-row items-center gap-4 px-3 py-3 rounded-xl hover:bg-[#059669]/50 transition-all group w-full <?= isActive('my_products.php') ? 'bg-[#1E3A8A]' : '' ?>">
                    <div class="flex-shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m8-2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <span
                        class="sidebar-text font-semibold text-sm whitespace-nowrap overflow-hidden transition-all duration-300">Toko
                        Saya</span>
                </a>

                <a href="<?= BASE_URL ?>views/user/chat_list.php"
                    class="menu-item flex flex-row items-center gap-4 px-3 py-3 rounded-xl hover:bg-[#059669]/50 transition-all group w-full <?= isActive('chat') ? 'bg-[#1E3A8A]' : '' ?>">
                    <div class="flex-shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                            </path>
                        </svg>
                    </div>
                    <span
                        class="sidebar-text text-sm font-semibold whitespace-nowrap overflow-hidden transition-all duration-300">Pesan</span>
                    <span id="unread-badge"
                        class="hidden ml-auto bg-red-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full border border-[#1E3A8A] shadow-sm transform scale-100 transition-transform duration-200">0</span>
                </a>

                <a href="<?= BASE_URL ?>views/transaction/history.php"
                    class="menu-item flex flex-row items-center gap-4 px-3 py-3 rounded-xl hover:bg-[#059669]/50 transition-all group w-full <?= isActive('history.php') ? 'bg-[#1E3A8A]' : '' ?>">
                    <div class="flex-shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                            </path>
                        </svg>
                    </div>
                    <span
                        class="sidebar-text font-semibold text-sm whitespace-nowrap overflow-hidden transition-all duration-300">Riwayat</span>
                </a>

                <div class="border-t border-white/20 my-2"></div>

                <a href="<?= BASE_URL ?>views/user/profile.php"
                    class="menu-item flex flex-row items-center gap-4 px-3 py-3 rounded-xl hover:bg-[#059669]/50 transition-all group w-full <?= isActive('profile.php') ? 'bg-[#1E3A8A]' : '' ?>">
                    <div class="flex-shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <span
                        class="sidebar-text font-semibold text-sm whitespace-nowrap overflow-hidden transition-all duration-300">Profil
                        Saya</span>
                </a>

            <?php endif; ?>
        </div>
    </aside>

    <div id="main-content"
        class="pt-20 px-6 min-h-screen w-full md:pl-64 transition-all duration-300 ease-in-out flex flex-col">