<?php
session_start();
include '../../config/conn.php';
include '../../views/layouts/header.php';

// Validasi ID
if (!isset($_GET['id']) || !isset($_SESSION['user_id'])) {
    echo "<script>window.location.href='" . BASE_URL . "views/transaction/history.php';</script>";
    exit();
}

$trx_id = $_GET['id'];
$user_id = $_SESSION['user_id'];

// Query Detail Transaksi
// Kita perlu info produk, pembeli, dan penjual
$sql = "SELECT t.*, p.nama_product, p.photo as product_photo, p.user_id as seller_id,
               u_buyer.username as buyer_name, u_seller.username as seller_name,
               u_seller.phone as seller_phone
        FROM transaksi t
        JOIN product p ON t.product_id = p.id
        JOIN user u_buyer ON t.buyer_id = u_buyer.id
        JOIN user u_seller ON p.user_id = u_seller.id
        WHERE t.id = '$trx_id'";

$result = mysqli_query($conn, $sql);
$data = mysqli_fetch_assoc($result);

// Security: Hanya Pembeli atau Penjual yang boleh lihat
if (!$data || ($data['buyer_id'] != $user_id && $data['seller_id'] != $user_id)) {
    echo "<script>alert('Akses ditolak!'); window.location.href='" . BASE_URL . "index.php';</script>";
    exit();
}

// Tentukan Peran (Buyer/Seller)
$is_seller = ($data['seller_id'] == $user_id);
?>

<div class="w-full max-w-4xl mx-auto px-4 py-8">

    <div class="flex items-center gap-4 mb-6">
        <a href="history.php" class="p-2 bg-white rounded-full shadow hover:bg-gray-50 transition text-gray-600">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                </path>
            </svg>
        </a>
        <h1 class="text-2xl font-bold text-[#1E3A8A]">Detail Pesanan #TRX-<?= $data['id'] ?></h1>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <div class="md:col-span-2 space-y-6">

            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <div class="flex justify-between items-center mb-4">
                    <span class="text-gray-500 text-sm">Status Pesanan</span>
                    <span class="font-bold text-[#1E3A8A] text-lg uppercase tracking-wide"><?= $data['status'] ?></span>
                </div>

                <div class="w-full bg-gray-200 rounded-full h-2.5 mb-2">
                    <?php
                    $width = '0%';
                    if ($data['status'] == 'terbayar' || $data['status'] == 'packing')
                        $width = '25%';
                    if ($data['status'] == 'kirim')
                        $width = '50%';
                    if ($data['status'] == 'selesai')
                        $width = '100%';
                    ?>
                    <div class="bg-[#059669] h-2.5 rounded-full transition-all duration-500"
                        style="width: <?= $width ?>"></div>
                </div>
                <p class="text-xs text-gray-400 text-right">Update terakhir:
                    <?= date('d M Y H:i', strtotime($data['createdAt'])) ?>
                </p>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <h3 class="font-bold text-slate-800 mb-4 border-b pb-2">Produk Dibeli</h3>
                <div class="flex gap-4">
                    <img src="<?= BASE_URL ?>uploads/products/<?= $data['product_photo'] ?>" class="w-20 h-20 rounded-lg object-cover border">
                    <div>
                        <h4 class="font-bold text-lg text-slate-800"><?= $data['nama_product'] ?></h4>
                        
                        <?php 
                            // REVISI LOGIKA HARGA
                            // Ambil Total Harga Langsung dari Database (Karena sudah benar)
                            // Kolom di DB bisa bernama 'total_harga' atau 'harga', sesuaikan
                            $total_fix = isset($data['total_harga']) ? $data['total_harga'] : $data['harga'];
                            
                            $qty = $data['qty'];
                            
                            // Hitung Harga Satuan (Total / Qty)
                            $harga_satuan = $total_fix / $qty; 
                        ?>

                        <p class="text-gray-500 text-sm">
                            <?= $qty ?> x Rp <?= number_format($harga_satuan, 0, ',', '.') ?>
                        </p>
                        
                        <p class="text-[#059669] font-bold mt-1 text-lg">
                            Total: Rp <?= number_format($total_fix, 0, ',', '.') ?>
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <h3 class="font-bold text-slate-800 mb-4 border-b pb-2">Info Pengiriman</h3>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-gray-500">Penerima</p>
                        <p class="font-bold text-slate-800"><?= $data['buyer_name'] ?></p>
                    </div>
                    <div>
                        <p class="text-gray-500">No. HP</p>
                        <p class="font-bold text-slate-800"><?= $data['phone_buyer'] ?></p>
                    </div>
                    <div class="col-span-2">
                        <p class="text-gray-500">Alamat</p>
                        <p class="font-bold text-slate-800"><?= $data['alamat_buyer'] ?>, <?= $data['kota_buyer'] ?></p>
                    </div>
                </div>
            </div>

        </div>

        <div class="space-y-6">

            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <h3 class="font-bold text-slate-800 mb-4 border-b pb-2">Pembayaran</h3>
                <p class="text-sm text-gray-500 mb-1">Metode</p>
                <p class="font-bold text-slate-800 uppercase mb-4"><?= $data['jenis_pembayaran'] ?></p>

                <?php if ($data['jenis_pembayaran'] == 'transfer' && $data['transfer']): ?>
                    <p class="text-sm text-gray-500 mb-1">Bukti Transfer</p>
                    <a href="<?= BASE_URL ?>uploads/transfer/<?= $data['transfer'] ?>" target="_blank" class="block w-full">
                        <img src="<?= BASE_URL ?>uploads/transfer/<?= $data['transfer'] ?>"
                            class="w-full h-32 object-cover rounded border hover:opacity-80 transition">
                    </a>
                    <p class="text-xs text-center text-blue-500 mt-1">Klik gambar untuk memperbesar</p>
                <?php endif; ?>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <h3 class="font-bold text-slate-800 mb-4 border-b pb-2">Aksi Pesanan</h3>

                <form action="<?= BASE_URL ?>actions/transaksi_update.php" method="POST">
                    <input type="hidden" name="trx_id" value="<?= $data['id'] ?>">

                    <?php if ($is_seller): ?>
                        <?php if ($data['status'] == 'Terbayar' || $data['status'] == 'Packing'): ?>
                            <p class="text-sm text-gray-600 mb-3">Pesanan siap dikirim?</p>
                            <button type="submit" name="action" value="kirim"
                                class="w-full bg-blue-600 text-white font-bold py-2 rounded hover:bg-blue-700 transition shadow-lg">
                                🚚 Kirim Barang
                            </button>
                        <?php elseif ($data['status'] == 'Kirim'): ?>
                            <div class="text-center text-blue-600 font-bold bg-blue-50 p-3 rounded">
                                Menunggu Konfirmasi Pembeli
                            </div>
                        <?php else: ?>
                            <div class="text-center text-green-600 font-bold bg-green-50 p-3 rounded">
                                Transaksi Selesai
                            </div>
                        <?php endif; ?>

                    <?php else: ?>
                        <?php if ($data['status'] == 'Kirim'): ?>
                            <p class="text-sm text-gray-600 mb-3">Sudah terima barang?</p>
                            <button type="submit" name="action" value="selesai"
                                onclick="return confirm('Yakin barang sudah sesuai? Transaksi akan diselesaikan.')"
                                class="w-full bg-green-600 text-white font-bold py-2 rounded hover:bg-green-700 transition shadow-lg">
                                ✅ Pesanan Diterima
                            </button>
                        <?php elseif ($data['status'] == 'Packing'): ?>
                            <div class="text-center text-gray-500 bg-gray-100 p-3 rounded text-sm">
                                Menunggu Penjual Mengirim
                            </div>
                        <?php else: ?>
                            <div class="text-center text-green-600 font-bold bg-green-50 p-3 rounded">
                                Transaksi Selesai
                            </div>
                        <?php endif; ?>

                    <?php endif; ?>
                </form>
            </div>

        </div>
    </div>
</div>

<?php include '../../views/layouts/footer.php'; ?>