<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<?php
include '../../config/conn.php';
include '../layouts/header.php';
include '../../classes/products.php';
include '../../classes/users.php';

// Inisialisasi Class
$productObj = new Products();
$userObj = new Users();

// Ambil ID dari URL
$id = $_GET['id'] ?? 0;

// Ambil data produk
$productResult = $productObj->getById($conn, $id);

if (!$productResult || mysqli_num_rows($productResult) == 0) {
    echo "<div class='w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6'>
            <p class='text-center text-gray-500'>Produk tidak ditemukan.</p>
        </div>";
    include 'views/layouts/footer.php';
    exit;
}

$product = $productResult->fetch_assoc();

// Ambil seller info
$seller_id = $product['user_id'];
$seller = null;
$sellerResult = $userObj->getById($conn, $seller_id);

if ($sellerResult && $sellerResult->num_rows > 0) {
    $seller = $sellerResult->fetch_assoc();
}
?>

<div class="w-full max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <div class="bg-white shadow-lg rounded-2xl p-6 md:flex gap-8 border border-gray-200">

        <div class="md:w-1/2">
            <img src="../../uploads/products/<?= $product['photo'] ?>" alt="Product Photo"
                class="w-full h-80 object-cover rounded-xl shadow-sm border" />
        </div>

        <div class="md:w-1/2 mt-6 md:mt-0">

            <div class="flex items-center gap-3 mb-3">
                <h1 class="text-3xl font-bold text-slate-800">
                    <?= $product['nama_product'] ?>
                </h1>
                <a href="report_product.php?id=<?= $product['id'] ?>" title="Laporkan Produk"
                    class="text-red-500 hover:text-red-700 transition">
                    <i class="fa-solid fa-flag text-xl"></i>
                </a>
            </div>

            <p class="text-2xl font-black text-[#059669] mb-4">
                Rp <?= number_format($product['harga'], 0, ',', '.') ?>
            </p>

            <p class="text-slate-600 leading-relaxed mb-4">
                <?= $product['description'] ?>
            </p>

            <div class="mb-4">
                <p class="text-sm text-gray-500">
                    Kategori: <span class="font-semibold text-[#1E3A8A]">
                        <?= $product['nama_kategori'] ?>
                    </span>
                </p>
                <p class="text-sm text-gray-500">Stok: <?= $product['stok'] ?></p>
            </div>

            <a href="seller_review.php?id=<?= $seller['id'] ?>" class="flex items-center gap-3 mt-4 group w-fit">
                <img src="../../uploads/profile/<?= $seller['photo'] ?? 'default.png' ?>"
                    class="w-11 h-11 rounded-full border shadow-sm">
                <div>
                    <p class="font-semibold text-slate-800 group-hover:text-[#1E3A8A]">
                        <?= $seller['username'] ?>
                    </p>
                </div>
            </a>

            <div class="flex gap-4 mt-6">
                <?php if ($product['stok'] > 0): ?>
                    <a href="javascript:void(0)" onclick="bukapembayaran()"
                        class="bg-[#059669] hover:bg-[#047857] text-white font-bold px-6 py-3 rounded-xl shadow-md transition">
                        Buy Now
                    </a>
                <?php else: ?>
                    <button class="bg-gray-400 text-white font-bold px-6 py-3 rounded-xl cursor-not-allowed">
                        Stok Habis
                    </button>
                <?php endif; ?>

                <a href="<?= BASE_URL ?>views/user/chat_room.php?partner_id=<?= $product['user_id'] ?>"
                    class="bg-[#1E3A8A] hover:bg-[#1E40AF] text-white font-bold px-6 py-3 rounded-xl shadow-md transition">
                    Chat Seller
                </a>
            </div>
        </div>
    </div>

</div>

<div id="kotakpembayaran" style="display:none;">
    <div class="w-full max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        <div class="bg-white shadow-lg rounded-2xl p-6 md:flex gap-8 border border-gray-200">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                <div class="border-r md:pr-6 flex flex-col h-full">
                    <h3 class="text-xl font-semibold mb-4">Pilih Metode Pembayaran</h3>

                    <form id="checkoutForm" action="../../actions/checkout_process.php" method="POST">
                        <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                        <input type="hidden" name="harga" value="<?= $product['harga'] ?>">

                        <div>
                            <label class="flex items-center gap-3 mb-4 cursor-pointer">
                                <input type="radio" name="jenis_pembayaran" value="transfer"
                                    class="w-5 h-5 text-green-600" required>
                                <div>
                                    <p class="font-semibold">BCA Transfer</p>
                                    <p class="text-sm text-gray-500">No Rek: 1234567890</p>
                                </div>
                            </label>

                            <label class="flex items-center gap-3 mb-4 cursor-pointer">
                                <input type="radio" name="jenis_pembayaran" value="cod" class="w-5 h-5 text-green-600"
                                    required>
                                <div>
                                    <p class="font-semibold">COD (Bayar ditempat)</p>
                                    <p class="text-sm text-gray-500">Biaya admin berlaku</p>
                                </div>
                            </label>

                            <label class="flex items-center gap-3 mb-4 cursor-pointer">
                                <input type="radio" name="jenis_pembayaran" value="ewallet"
                                    class="w-5 h-5 text-green-600" required>
                                <div>
                                    <p class="font-semibold">E-Wallet (OVO / Dana)</p>
                                    <p class="text-sm text-gray-500">No: 081234567890</p>
                                </div>
                            </label>
                        </div>

                        <h3 class="text-xl font-semibold mb-4">Grand Total:</h3>
                        <div id="grand_total_display" class="text-3xl font-bold text-[#059669] mb-6">
                            Rp <?= number_format($product['harga'], 0, ',', '.') ?>
                        </div>
                </div>

                <div class="md:pl-6">
                    <h3 class="text-xl font-semibold mb-4">Informasi Penerima</h3>

                    <div class="mb-4">
                        <label class="text-sm font-semibold">Nama Lengkap</label>
                        <input type="text" name="nama_buyer" class="w-full border p-3 rounded-xl mt-1" required>
                    </div>

                    <div class="mb-4">
                        <label class="text-sm font-semibold">Alamat Lengkap</label>
                        <textarea name="alamat_buyer" class="w-full border p-3 rounded-xl mt-1" rows="3"
                            required></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="text-sm font-semibold">Kota</label>
                        <input type="text" name="kota_buyer" class="w-full border p-3 rounded-xl mt-1" required>
                    </div>

                    <div class="mb-4">
                        <label class="text-sm font-semibold">No. HP</label>
                        <input type="tel" name="phone_buyer" class="w-full border p-3 rounded-xl mt-1" required
                            pattern="[0-9]{10,15}" title="Hanya angka, 10-15 digit">
                    </div>

                    <div class="mb-4">
                        <label class="text-sm font-semibold">Quantity</label>
                        <input type="number" name="qty" class="w-full border p-3 rounded-xl mt-1" value="1" min="1"
                            max="<?= $product['stok'] ?>" required>
                    </div>

                    <div class="mb-6">
                        <label class="text-sm font-semibold">Pilih Kurir</label>
                        <div class="flex gap-4 mt-2">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="jenis_pengiriman" value="jne" class="w-4 h-4" required>
                                JNE
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="jenis_pengiriman" value="lion_parcel" class="w-4 h-4"
                                    required>
                                Lion Parcel
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="jenis_pengiriman" value="instant" class="w-4 h-4" required>
                                Instant
                            </label>
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full py-3 bg-[#059669] hover:bg-[#047857] text-white font-bold rounded-xl transition">
                        Checkout
                    </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery.js"></script>
<script>
    function bukapembayaran() {
        $("#kotakpembayaran").fadeIn();
        // Scroll ke bawah agar form terlihat
        $('html, body').animate({
            scrollTop: $("#kotakpembayaran").offset().top
        }, 1000);
    }

    $(document).ready(function () {
        let harga = <?= $product['harga'] ?>;
        let maxstok = <?= $product['stok'] ?>;

        $("input[name='qty']").on('input', function () {
            let qty = parseInt($(this).val()) || 1;

            if (qty < 1) qty = 1;
            if (qty > maxstok) {
                alert("Stok hanya tersedia " + maxstok);
                qty = maxstok;
            }

            $(this).val(qty);

            let grand_total = harga * qty;
            $("#grand_total_display").text('Rp ' + grand_total.toLocaleString('id-ID'));
        });
    });
</script>

<?php include '../layouts/footer.php'; ?>