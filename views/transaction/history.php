<?php
include '../../config/conn.php';
include '../../views/layouts/header.php';

// 1. Cek Login
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Silakan login dulu!'); window.location.href='" . BASE_URL . "views/auth/login.php';</script>";
    exit();
}

$user_id = $_SESSION['user_id'];

// 2. Logika Tab (Default: Pembelian)
$view = isset($_GET['view']) ? $_GET['view'] : 'pembelian';

// 3. Query Data (Sesuai Tab)
if ($view == 'pembelian') {
    // Ambil barang yang SAYA BELI
    // Join ke tabel product (untuk nama barang) dan user (untuk nama penjual)
    $sql = "SELECT t.*, p.nama_product, p.photo, u.username AS nama_penjual 
            FROM transaksi t 
            JOIN product p ON t.product_id = p.id 
            JOIN user u ON p.user_id = u.id 
            WHERE t.buyer_id = '$user_id' 
            ORDER BY t.createdAt DESC";
} else {
    // Ambil barang saya yang DIBELI ORANG (Penjualan)
    // Join ke tabel product (pastikan itu barang saya) dan user (nama pembeli)
    $sql = "SELECT t.*, p.nama_product, p.photo, u.username AS nama_pembeli 
            FROM transaksi t 
            JOIN product p ON t.product_id = p.id 
            JOIN user u ON t.buyer_id = u.id 
            WHERE p.user_id = '$user_id' 
            ORDER BY t.createdAt DESC";
}

$result = mysqli_query($conn, $sql);
?>

<div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <h1 class="text-3xl font-bold text-[#1E3A8A] mb-6">Riwayat Transaksi</h1>

    <div class="flex border-b border-gray-200 mb-6">
        <a href="?view=pembelian"
            class="px-6 py-3 text-sm font-bold <?= $view == 'pembelian' ? 'border-b-4 border-[#1E3A8A] text-[#1E3A8A]' : 'text-gray-500 hover:text-[#1E3A8A]' ?>">
            🛍️ Pembelian Saya
        </a>
        <a href="?view=penjualan"
            class="px-6 py-3 text-sm font-bold <?= $view == 'penjualan' ? 'border-b-4 border-[#1E3A8A] text-[#1E3A8A]' : 'text-gray-500 hover:text-[#1E3A8A]' ?>">
            💰 Penjualan Saya
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead class="bg-[#1E3A8A] text-white text-sm uppercase">
                <tr>
                    <th class="p-4">No. Transaksi</th>
                    <th class="p-4">Produk</th>
                    <th class="p-4">Total Harga</th>
                    <th class="p-4">Status</th>
                    <th class="p-4">Tanggal</th>
                    <th class="p-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-sm text-gray-700">

                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr class="border-b hover:bg-gray-50 transition">

                            <td class="p-4 font-mono">#TRX-<?= $row['id'] ?></td>

                            <td class="p-4">
                                <div class="flex items-center gap-3">
                                    <img src="<?= BASE_URL ?>uploads/products/<?= $row['photo'] ?>"
                                        class="w-12 h-12 rounded object-cover border border-gray-200"
                                        onerror="this.src='https://placehold.co/100x100?text=No+Img'">
                                    <div>
                                        <p class="font-bold text-slate-800"><?= $row['nama_product'] ?></p>
                                        <p class="text-xs text-gray-500">
                                            <?= $view == 'pembelian' ? 'Penjual: ' . $row['nama_penjual'] : 'Pembeli: ' . $row['nama_pembeli'] ?>
                                        </p>
                                        <p class="text-xs text-gray-500">Qty: <?= $row['qty'] ?></p>
                                    </div>
                                </div>
                            </td>

                            <td class="p-4 font-bold text-[#059669]">
                                Rp <?= number_format($row['total_harga'], 0, ',', '.') ?>
                            </td>

                            <td class="p-4">
                                <?php
                                $status = $row['status'];
                                $badgeColor = 'bg-gray-100 text-gray-600'; // Default
                        
                                if ($status == 'terbayar')
                                    $badgeColor = 'bg-yellow-100 text-yellow-700';
                                if ($status == 'packing')
                                    $badgeColor = 'bg-blue-100 text-blue-700';
                                if ($status == 'kirim')
                                    $badgeColor = 'bg-indigo-100 text-indigo-700';
                                if ($status == 'selesai')
                                    $badgeColor = 'bg-green-100 text-green-700';
                                if ($status == 'batal')
                                    $badgeColor = 'bg-red-100 text-red-700';
                                ?>
                                <span class="px-3 py-1 rounded-full text-xs font-bold uppercase <?= $badgeColor ?>">
                                    <?= $status ?>
                                </span>
                            </td>

                            <td class="p-4 text-gray-500">
                                <?= date('d M Y', strtotime($row['createdAt'])) ?>
                            </td>

                            <td class="p-4 text-center">
                                <?php if ($view == 'pembelian'): ?>
                                    <?php if ($status == 'kirim'): ?>
                                        <a href="#" class="bg-[#059669] text-white px-3 py-1 rounded text-xs hover:bg-green-700">
                                            Terima Barang
                                        </a>
                                    <?php elseif ($status == 'selesai'): ?>
                                        <a href="#"
                                            class="bg-[#FACC15] text-[#1E3A8A] px-3 py-1 rounded text-xs hover:bg-yellow-300 font-bold">
                                            Review
                                        </a>
                                    <?php else: ?>
                                        <a href="detail_transaksi.php?id=<?= $row['id'] ?>"
                                            class="text-[#1E3A8A] underline hover:text-blue-700">Detail</a>
                                    <?php endif; ?>

                                <?php else: ?>
                                    <?php if ($status == 'terbayar'): ?>
                                        <a href="#" class="bg-[#1E3A8A] text-white px-3 py-1 rounded text-xs hover:bg-blue-900">
                                            Proses (Packing)
                                        </a>
                                    <?php elseif ($status == 'packing'): ?>
                                        <a href="#" class="bg-blue-500 text-white px-3 py-1 rounded text-xs hover:bg-blue-600">
                                            Kirim Barang
                                        </a>
                                    <?php else: ?>
                                        <a href="detail_transaksi.php?id=<?= $row['id'] ?>" class="text-gray-500 underline">Lihat</a>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </td>

                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="p-10 text-center text-gray-400">
                            Belum ada riwayat <?= $view ?>.
                        </td>
                    </tr>
                <?php endif; ?>

            </tbody>
        </table>
    </div>
</div>

<?php include '../../views/layouts/footer.php'; ?>