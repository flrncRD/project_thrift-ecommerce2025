<?php
include '../../config/conn.php';
include '../../views/layouts/header.php';
include '../../classes/products.php';

// Validasi ID
if (!isset($_GET['id'])) {
    echo "<script>alert('Produk tidak ditemukan!'); window.location='my_products.php';</script>";
    exit;
}

$product_id = $_GET['id'];

$Product = new Products();
$data = $Product->getById($conn, $product_id)->fetch_assoc();

// Cek Hak Akses
if ($data['user_id'] != $_SESSION['user_id']) {
    echo "<script>alert('Anda tidak berhak mengedit produk ini!'); window.location='my_products.php';</script>";
    exit;
}

// Ambil Kategori
$kategoriData = mysqli_query($conn, "SELECT * FROM kategori");
?>

<div class="container mx-auto px-6 py-10 flex justify-center">
    <div class="w-full max-w-2xl bg-white p-8 rounded-lg shadow-lg border-t-4 border-[#FACC15]">
        <h2 class="text-2xl font-bold text-[#1E3A8A] mb-6">Edit Barang</h2>

        <form action="<?= BASE_URL ?>actions/product_edit.php" method="POST" enctype="multipart/form-data">

            <input type="hidden" name="product_id" value="<?= $data['id'] ?>">

            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Nama Barang</label>
                <input type="text" name="nama_product" value="<?= $data['nama_product'] ?>" required
                    class="w-full px-4 py-2 border rounded focus:ring-2 focus:ring-[#FACC15] outline-none">
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-gray-700 font-bold mb-2">Kategori</label>
                    <select name="kategori_id" required
                        class="w-full px-4 py-2 border rounded focus:ring-2 focus:ring-[#FACC15] outline-none bg-white">
                        <option value="">Pilih Kategori</option>

                        <?php while ($k = mysqli_fetch_assoc($kategoriData)): ?>
                            <option value="<?= $k['id'] ?>" <?= $k['id'] == $data['kategori_id'] ? 'selected' : '' ?>>
                                <?= $k['nama_kategori'] ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div>
                    <label class="block text-gray-700 font-bold mb-2">Harga (Rp)</label>
                    <input type="number" name="harga" value="<?= $data['harga'] ?>" required min="1000"
                        class="w-full px-4 py-2 border rounded focus:ring-2 focus:ring-[#FACC15] outline-none">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-gray-700 font-bold mb-2">Stok</label>
                    <input type="number" name="stok" value="<?= $data['stok'] ?>" required min="0"
                        class="w-full px-4 py-2 border rounded focus:ring-2 focus:ring-[#FACC15] outline-none">
                </div>

                <div>
                    <label class="block text-gray-700 font-bold mb-2">Foto Barang (Opsional)</label>
                    <input type="file" name="photo" accept="image/*"
                        class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-yellow-50 file:text-yellow-700 hover:file:bg-yellow-100">
                    <p class="text-xs text-gray-500 mt-1">Biarkan kosong jika tidak ganti foto</p>
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-bold mb-2">Deskripsi Kondisi & Minus</label>
                <textarea name="description" rows="4" required
                    class="w-full px-4 py-2 border rounded focus:ring-2 focus:ring-[#FACC15] outline-none"><?= $data['description'] ?></textarea>
            </div>

            <div class="flex gap-4">
                <a href="my_products.php"
                    class="px-6 py-2 border border-gray-300 rounded text-gray-600 hover:bg-gray-50">Batal</a>

                <button type="submit"
                    class="flex-1 bg-[#1E3A8A] text-white font-bold py-2 px-4 rounded hover:bg-blue-900 transition">
                    SIMPAN PERUBAHAN
                </button>
            </div>

        </form>
    </div>
</div>

<script>
    document.querySelector("form").addEventListener("submit", function (e) {
        let harga = document.querySelector("input[name='harga']").value;
        let stok = document.querySelector("input[name='stok']").value;

        if (parseInt(harga) < 1000) {
            alert("Harga minimal adalah Rp 1.000");
            e.preventDefault();
            return;
        }

        if (parseInt(stok) < 0) {
            alert("Stok tidak boleh negatif!");
            e.preventDefault();
            return;
        }
    });
</script>

<?php include '../../views/layouts/footer.php'; ?>