<?php
include '../../config/conn.php';
include '../../views/layouts/header.php';

// Cek Login
if (!isset($_SESSION['user_id'])) {
    echo "<script>window.location.href='" . BASE_URL . "views/auth/login.php';</script>";
    exit();
}

// Cek Keranjang Kosong
if (empty($_SESSION['cart'])) {
    echo "<script>alert('Keranjang kosong!'); window.location.href='" . BASE_URL . "index.php';</script>";
    exit();
}

// Ambil Data User untuk Auto-Fill Form
$id = $_SESSION['user_id'];
$query = mysqli_query($conn, "SELECT * FROM user WHERE id = '$id'");
$user = mysqli_fetch_assoc($query);

// Hitung Total
$grandTotal = 0;
foreach ($_SESSION['cart'] as $item) {
    $grandTotal += $item['price'] * $item['qty'];
}
?>

<div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <h1 class="text-3xl font-bold text-[#1E3A8A] mb-8">Checkout Pengiriman</h1>

    <form action="<?= BASE_URL ?>actions/checkout_process.php" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-2 space-y-6">
            
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <h2 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                    <span class="w-6 h-6 bg-[#1E3A8A] text-white rounded-full flex items-center justify-center text-xs">1</span>
                    Alamat Pengiriman
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-gray-600 text-sm font-bold mb-2">No. WhatsApp</label>
                        <input type="text" name="phone" value="<?= $user['phone'] ?>" required 
                            class="w-full px-4 py-2 border rounded focus:ring-2 focus:ring-[#1E3A8A] outline-none bg-gray-50">
                    </div>
                    <div>
                        <label class="block text-gray-600 text-sm font-bold mb-2">Kota</label>
                        <input type="text" name="kota" value="<?= $user['kota'] ?>" required 
                            class="w-full px-4 py-2 border rounded focus:ring-2 focus:ring-[#1E3A8A] outline-none bg-gray-50">
                    </div>
                </div>
                
                <div>
                    <label class="block text-gray-600 text-sm font-bold mb-2">Alamat Lengkap</label>
                    <textarea name="alamat" rows="3" required placeholder="Nama Jalan, No. Rumah, RT/RW..."
                        class="w-full px-4 py-2 border rounded focus:ring-2 focus:ring-[#1E3A8A] outline-none bg-gray-50"><?= $user['alamat'] ?></textarea>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <h2 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                    <span class="w-6 h-6 bg-[#1E3A8A] text-white rounded-full flex items-center justify-center text-xs">2</span>
                    Metode Pembayaran
                </h2>

                <div class="space-y-3">
                    <label class="flex items-center gap-4 p-4 border rounded-lg cursor-pointer hover:bg-blue-50 transition has-[:checked]:border-[#1E3A8A] has-[:checked]:bg-blue-50">
                        <input type="radio" name="payment_method" value="transfer" class="w-5 h-5 text-[#1E3A8A]" onchange="togglePayment('transfer')" checked>
                        <div class="flex-1">
                            <span class="font-bold text-slate-800 block">Transfer Bank</span>
                            <span class="text-xs text-gray-500">Perlu upload bukti transfer</span>
                        </div>
                        <span class="text-2xl">🏦</span>
                    </label>

                    <div id="transfer-info" class="bg-blue-50 p-4 rounded-lg border border-blue-100 text-sm text-blue-900 ml-9">
                        <p class="font-bold mb-1">Silakan transfer ke:</p>
                        <ul class="list-disc list-inside">
                            <li>BCA: <span class="font-mono font-bold">123-456-7890</span> (a.n PindaHand)</li>
                            <li>Mandiri: <span class="font-mono font-bold">000-111-222-33</span></li>
                        </ul>
                        <div class="mt-3">
                            <label class="block font-bold mb-1 text-xs uppercase">Upload Bukti Transfer</label>
                            <input type="file" name="bukti_transfer" accept="image/*" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-blue-200 file:text-blue-700 hover:file:bg-blue-300">
                        </div>
                    </div>

                    <label class="flex items-center gap-4 p-4 border rounded-lg cursor-pointer hover:bg-green-50 transition has-[:checked]:border-green-600 has-[:checked]:bg-green-50">
                        <input type="radio" name="payment_method" value="cod" class="w-5 h-5 text-green-600" onchange="togglePayment('cod')">
                        <div class="flex-1">
                            <span class="font-bold text-slate-800 block">COD (Bayar di Tempat)</span>
                            <span class="text-xs text-gray-500">Bayar tunai saat kurir datang</span>
                        </div>
                        <span class="text-2xl">🚚</span>
                    </label>
                </div>
            </div>

        </div>

        <div class="lg:col-span-1">
            <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-200 sticky top-24">
                <h3 class="font-bold text-lg text-slate-800 mb-4">Ringkasan Pesanan</h3>
                
                <div class="space-y-3 mb-6 max-h-60 overflow-y-auto pr-2 custom-scrollbar">
                    <?php foreach ($_SESSION['cart'] as $item): ?>
                        <div class="flex gap-3 text-sm">
                            <img src="<?= BASE_URL ?>uploads/products/<?= $item['photo'] ?>" class="w-12 h-12 rounded object-cover bg-gray-100">
                            <div class="flex-1">
                                <p class="font-bold text-slate-700 truncate w-32"><?= $item['name'] ?></p>
                                <p class="text-gray-500"><?= $item['qty'] ?> x Rp <?= number_format($item['price'],0,',','.') ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="border-t border-dashed border-gray-300 my-4"></div>

                <div class="flex justify-between items-center mb-2 text-sm">
                    <span class="text-gray-600">Subtotal</span>
                    <span class="font-bold">Rp <?= number_format($grandTotal, 0, ',', '.') ?></span>
                </div>
                <div class="flex justify-between items-center mb-4 text-sm">
                    <span class="text-gray-600">Biaya Layanan</span>
                    <span class="font-bold text-green-600">Gratis</span>
                </div>

                <div class="border-t border-gray-200 my-4"></div>

                <div class="flex justify-between items-center mb-6">
                    <span class="font-bold text-lg">Total Bayar</span>
                    <span class="font-black text-xl text-[#1E3A8A]">Rp <?= number_format($grandTotal, 0, ',', '.') ?></span>
                </div>

                <button type="submit" class="w-full bg-[#FACC15] text-[#1E3A8A] font-bold py-3 rounded-lg shadow-md hover:bg-yellow-400 transition transform active:scale-95">
                    BUAT PESANAN
                </button>
                <p class="text-xs text-center text-gray-400 mt-3">Pastikan data sudah benar sebelum lanjut.</p>
            </div>
        </div>

    </form>
</div>

<script>
    // Script Toggle Tampilan Upload Bukti Transfer
    function togglePayment(method) {
        const info = document.getElementById('transfer-info');
        const fileInput = document.querySelector('input[name="bukti_transfer"]');
        
        if (method === 'transfer') {
            info.classList.remove('hidden');
            fileInput.required = true; // Wajib upload jika transfer
        } else {
            info.classList.add('hidden');
            fileInput.required = false; // Tidak wajib jika COD
        }
    }
</script>

<?php include '../../views/layouts/footer.php'; ?>