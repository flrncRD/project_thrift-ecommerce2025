<?php
include '../../config/conn.php';
include '../../views/layouts/header.php';

// Cek Login (Wajib Login kalau mau lihat keranjang)
if (!isset($_SESSION['username'])) {
    echo "<script>alert('Silakan login terlebih dahulu!'); window.location.href='" . BASE_URL . "views/auth/login.php';</script>";
    exit();
}

// Dummy Data Session (UNCOMMENT INI JIKA INGIN TEST TAMPILAN TAPI BELUM ADA FITUR ADD TO CART)
/*
if(!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [
        [
            'id' => 1,
            'name' => 'Jaket Denim Vintage',
            'price' => 150000,
            'qty' => 1,
            'photo' => 'default.jpg' // Pastikan ada file gambar dummy
        ],
        [
            'id' => 2,
            'name' => 'Sepatu Converse Bekas',
            'price' => 250000,
            'qty' => 1,
            'photo' => 'default.jpg'
        ]
    ];
}
*/

// Hitung Total
$grandTotal = 0;
?>

<div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <h1 class="text-3xl font-bold text-[#1E3A8A] mb-8 flex items-center gap-2">
        Keranjang Belanja
    </h1>

    <?php if (empty($_SESSION['cart'])): ?>

        <div class="bg-white rounded-xl shadow-sm border-2 border-dashed border-gray-300 p-12 text-center">
            <div class="inline-flex items-center justify-center w-24 h-24 rounded-full bg-blue-50 text-blue-400 mb-4">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
            </div>
            <h2 class="text-xl font-bold text-slate-700">Keranjangmu masih kosong</h2>
            <p class="text-gray-500 mt-2 mb-6">Yuk cari barang thrift keren sebelum diambil orang!</p>
            <a href="<?= BASE_URL ?>index.php"
                class="inline-block bg-[#1E3A8A] text-white font-bold py-3 px-8 rounded-lg hover:bg-blue-900 transition">
                Mulai Belanja
            </a>
        </div>

    <?php else: ?>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <table class="w-full text-left">
                        <thead class="bg-[#1E3A8A] text-white">
                            <tr>
                                <th class="p-4 font-bold text-sm uppercase">Produk</th>
                                <th class="p-4 font-bold text-sm uppercase text-center">Jumlah</th>
                                <th class="p-4 font-bold text-sm uppercase text-right">Subtotal</th>
                                <th class="p-4 font-bold text-sm uppercase text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <?php foreach ($_SESSION['cart'] as $id => $item):
                                $subtotal = $item['price'] * $item['qty'];
                                $grandTotal += $subtotal;
                                ?>
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="p-4">
                                        <div class="flex items-center gap-4">
                                            <div
                                                class="w-16 h-16 bg-gray-200 rounded-md overflow-hidden flex-shrink-0 border border-gray-300">
                                                <img src="<?= BASE_URL ?>uploads/products/<?= $item['photo'] ?>"
                                                    alt="<?= $item['name'] ?>" class="w-full h-full object-cover"
                                                    onerror="this.src='https://placehold.co/100x100?text=No+Image'">
                                            </div>
                                            <div>
                                                <h3 class="font-bold text-slate-800 text-base"><?= $item['name'] ?></h3>
                                                <p class="text-sm text-gray-500">Rp
                                                    <?= number_format($item['price'], 0, ',', '.') ?></p>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="p-4 text-center">
                                        <div class="inline-flex items-center border border-gray-300 rounded-md">
                                            <span
                                                class="px-3 py-1 bg-gray-100 text-gray-600 font-bold"><?= $item['qty'] ?></span>
                                        </div>
                                    </td>

                                    <td class="p-4 text-right">
                                        <span class="font-bold text-[#059669] text-base">
                                            Rp <?= number_format($subtotal, 0, ',', '.') ?>
                                        </span>
                                    </td>

                                    <td class="p-4 text-center align-middle">
                                        <a href="<?= BASE_URL ?>actions/cart_remove.php?id=<?= $id ?>"
                                            class="inline-flex items-center justify-center text-red-500 hover:text-red-700 p-2 rounded-full hover:bg-red-50 transition"
                                            onclick="return confirm('Hapus barang ini?')">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                </path>
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    <a href="<?= BASE_URL ?>index.php" class="text-[#1E3A8A] font-bold hover:underline text-sm">
                        &larr; Lanjut Belanja
                    </a>
                </div>
            </div>

            <div class="lg:col-span-1">
                <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-200 sticky top-24">
                    <h3 class="text-lg font-bold text-slate-800 mb-4 border-b border-gray-100 pb-2">Ringkasan Belanja</h3>

                    <div class="flex justify-between items-center mb-2 text-sm text-gray-600">
                        <span>Total Barang</span>
                        <span><?= count($_SESSION['cart']) ?> Item</span>
                    </div>

                    <div class="flex justify-between items-center mb-6 text-sm text-gray-600">
                        <span>Biaya Admin</span>
                        <span class="text-green-600 font-bold">Gratis</span>
                    </div>

                    <div class="border-t border-dashed border-gray-300 my-4"></div>

                    <div class="flex justify-between items-center mb-6">
                        <span class="font-bold text-slate-800 text-lg">Total Harga</span>
                        <span class="font-black text-[#1E3A8A] text-xl">
                            Rp <?= number_format($grandTotal, 0, ',', '.') ?>
                        </span>
                    </div>

                    <a href="checkout.php"
                        class="block w-full bg-[#FACC15] text-[#1E3A8A] text-center font-bold py-3 rounded-lg shadow-md hover:bg-yellow-400 transform hover:-translate-y-1 transition duration-200">
                        CHECKOUT SEKARANG
                    </a>

                    <p class="text-xs text-center text-gray-400 mt-4">
                        Transaksi aman dengan PindaHand Escrow.
                    </p>
                </div>
            </div>

        </div>

    <?php endif; ?>

</div>

<?php include '../../views/layouts/footer.php'; ?>