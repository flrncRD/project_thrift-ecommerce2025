<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="<?= BASE_URL ?>assets/js/script.js"></script>

<aside class="w-64 bg-[#0F172A] text-white h-screen fixed top-0 left-0 overflow-y-auto border-r border-gray-800">

    <div class="h-16 flex items-center justify-center border-b border-gray-800">
        <h1 class="text-xl font-bold tracking-wider">ADMIN <span class="text-[#059669]">PANEL</span></h1>
    </div>

    <nav class="p-4 space-y-2">
        <p class="text-xs font-bold text-gray-500 uppercase mb-2">Utama</p>

        <a href="<?= BASE_URL ?>views/admin/dashboard.php"
            class="flex items-center p-3 rounded hover:bg-[#1E3A8A] transition">
            <span>📊</span>
            <span class="ml-3 font-medium">Dashboard</span>
        </a>

        <p class="text-xs font-bold text-gray-500 uppercase mt-6 mb-2">Manajemen</p>

        <a href="<?= BASE_URL ?>views/admin/manage_users.php"
            class="flex items-center p-3 rounded hover:bg-[#1E3A8A] transition">
            <span>👥</span>
            <span class="ml-3 font-medium">Kelola User</span>
        </a>

        <a href="<?= BASE_URL ?>views/admin/manage_reports.php"
            class="flex items-center p-3 rounded hover:bg-[#1E3A8A] transition">
            <span>🚨</span>
            <span class="ml-3 font-medium">Laporan Masuk</span>
        </a>

        <a href="<?= BASE_URL ?>views/admin/manage_kategori.php"
            class="flex items-center p-3 rounded hover:bg-[#1E3A8A] transition">
            <span>🏷️</span>
            <span class="ml-3 font-medium">Kategori Produk</span>
        </a>

        <div class="border-t border-gray-800 my-4"></div>

        <a href="<?= BASE_URL ?>actions/auth_logout.php" onclick="confirmLogout(event)"
            class="flex items-center p-3 rounded hover:bg-red-900 text-red-300 transition">
            <span>🚪</span>
            <span class="ml-3 font-medium">Logout Admin</span>
        </a>
    </nav>
</aside>