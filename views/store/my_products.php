<?php
include '../../config/conn.php';
include '../../views/layouts/header.php';
include '../../classes/products.php';

if (!isset($_SESSION['user_id'])) {
    echo "<script>window.location.href='" . BASE_URL . "views/auth/login.php';</script>";
    exit();
}

$productObj = new Products();
$user_id = $_SESSION['user_id'];

// PAGINATION CONFIG
$limit = 10; // Tampilkan 10 barang per halaman tabel
$pageActive = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$start = ($pageActive > 1) ? ($pageActive * $limit) - $limit : 0;

// AMBIL DATA
$totalData = $productObj->countByUser($conn, $user_id);
$totalPages = ceil($totalData / $limit);
$myProducts = $productObj->getByUserPaginated($conn, $user_id, $start, $limit);
?>

<div class="container mx-auto px-6 py-10">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-[#1E3A8A]">Kelola Toko</h1>
        <a href="add.php"
            class="bg-[#059669] text-white px-6 py-2 rounded-lg font-bold hover:bg-emerald-700 transition shadow-lg flex items-center gap-2">
            <span>+</span> Jual Barang
        </a>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden border border-gray-200">
        <table class="w-full text-left border-collapse">
            <thead class="bg-[#1E3A8A] text-white uppercase text-sm">
                <tr>
                    <th class="py-4 px-6">Foto</th>
                    <th class="py-4 px-6">Produk</th>
                    <th class="py-4 px-6">Harga</th>
                    <th class="py-4 px-6">Stok</th>
                    <th class="py-4 px-6 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-700 text-sm">
                <?php if (mysqli_num_rows($myProducts) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($myProducts)): ?>
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="py-4 px-6">
                                <img src="<?= BASE_URL ?>uploads/products/<?= $row['photo'] ?>"
                                    class="w-12 h-12 object-cover rounded border bg-gray-100">
                            </td>
                            <td class="py-4 px-6">
                                <div class="font-bold text-slate-800"><?= $row['nama_product'] ?></div>
                                <div class="text-xs text-gray-500 bg-gray-100 px-2 py-0.5 rounded inline-block mt-1">
                                    <?= $row['nama_kategori'] ?>
                                </div>
                            </td>
                            <td class="py-4 px-6 font-bold text-[#059669]">
                                Rp <?= number_format($row['harga'], 0, ',', '.') ?>
                            </td>
                            <td class="py-4 px-6">
                                <?php if ($row['stok'] > 0): ?>
                                    <span class="text-green-600 font-bold"><?= $row['stok'] ?></span>
                                <?php else: ?>
                                    <span class="bg-red-100 text-red-600 text-xs px-2 py-1 rounded font-bold">Habis</span>
                                <?php endif; ?>
                            </td>
                            <td class="py-4 px-6 text-center">
                                <div class="flex justify-center gap-3">
                                    <a href="edit.php?id=<?= $row['id'] ?>"
                                        class="text-blue-600 hover:text-blue-800 font-semibold text-xs border border-blue-200 px-3 py-1 rounded hover:bg-blue-50 transition">
                                        Edit
                                    </a>

                                    <a href="<?= BASE_URL ?>actions/product_delete.php?id=<?= $row['id'] ?>"
                                        onclick="confirmDelete(event)"
                                        class="text-red-500 hover:text-red-700 font-semibold text-xs border border-red-200 px-3 py-1 rounded hover:bg-red-50 transition">
                                        Hapus
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="py-10 text-center text-gray-500">
                            Belum ada barang. Yuk mulai jualan!
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php if ($totalPages > 1): ?>
        <div class="flex justify-end mt-6 space-x-2">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="?page=<?= $i ?>"
                    class="px-3 py-1 border rounded text-sm <?= $i == $pageActive ? 'bg-[#1E3A8A] text-white' : 'bg-white text-gray-600 hover:bg-gray-100' ?>">
                    <?= $i ?>
                </a>
            <?php endfor; ?>
        </div>
    <?php endif; ?>
</div>

<?php include '../../views/layouts/footer.php'; ?>