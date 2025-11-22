<?php
include '../../config/conn.php';
include '../../views/layouts/header.php';
include '../../classes/products.php';

// Cek Login
if (!isset($_SESSION['user_id'])) {
    header("Location: " . BASE_URL . "views/auth/login.php");
    exit();
}

$productObj = new Products();
$myProducts = $productObj->getByUser($conn, $_SESSION['user_id']);
?>

<div class="container mx-auto px-6 py-10">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-[#1E3A8A]">Toko Saya</h1>
        <a href="add.php"
            class="bg-[#059669] text-white px-6 py-2 rounded-lg font-bold hover:bg-emerald-700 transition shadow-lg">
            + Tambah Barang
        </a>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-100 text-gray-600 uppercase text-sm">
                <tr>
                    <th class="py-4 px-6">Foto</th>
                    <th class="py-4 px-6">Nama Produk</th>
                    <th class="py-4 px-6">Harga</th>
                    <th class="py-4 px-6">Stok</th>
                    <th class="py-4 px-6">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                <?php if (mysqli_num_rows($myProducts) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($myProducts)): ?>
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-4 px-6">
                                <img src="<?= BASE_URL ?>uploads/products/<?= $row['photo'] ?>"
                                    class="w-16 h-16 object-cover rounded border">
                            </td>
                            <td class="py-4 px-6">
                                <div class="font-bold"><?= $row['nama_product'] ?></div>
                                <div class="text-xs text-gray-500"><?= $row['nama_kategori'] ?></div>
                            </td>
                            <td class="py-4 px-6 font-semibold text-[#059669]">
                                Rp <?= number_format($row['harga'], 0, ',', '.') ?>
                            </td>
                            <td class="py-4 px-6">
                                <?php if ($row['stok'] > 0): ?>
                                    <span
                                        class="bg-green-100 text-green-800 text-xs font-bold px-2 py-1 rounded"><?= $row['stok'] ?></span>
                                <?php else: ?>
                                    <span class="bg-red-100 text-red-800 text-xs font-bold px-2 py-1 rounded">Habis</span>
                                <?php endif; ?>
                            </td>
                            <td class="py-4 px-6">
                                <a href="#" class="text-blue-600 hover:underline mr-3">Edit</a>
                                <a href="#" class="text-red-600 hover:underline">Hapus</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="py-8 text-center text-gray-500">
                            Belum ada barang yang dijual. Yuk tambah sekarang!
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include '../../views/layouts/footer.php'; ?>