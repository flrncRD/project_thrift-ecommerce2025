<?php
include '../../config/conn.php';
include '../../views/layouts/header.php';
include '../../classes/products.php';

// Ambil Kategori untuk Dropdown
$kategoriData = mysqli_query($conn, "SELECT * FROM kategori");
?>

<div class="container mx-auto px-6 py-10 flex justify-center">
    <div class="w-full max-w-2xl bg-white p-8 rounded-lg shadow-lg border-t-4 border-[#FACC15]">
        <h2 class="text-2xl font-bold text-[#1E3A8A] mb-6">Edit Barang</h2>

        <form action="<?= BASE_URL ?>actions/product_edit.php" method="POST" enctype="multipart/form-data">

            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Nama Barang</label>
                <input type="text" name="nama_product" required
                    class="w-full px-4 py-2 border rounded focus:ring-2 focus:ring-[#FACC15] outline-none">
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-gray-700 font-bold mb-2">Kategori</label>
                    <select name="kategori_id" required
                        class="w-full px-4 py-2 border rounded focus:ring-2 focus:ring-[#FACC15] outline-none bg-white">
                        <option value="">Pilih Kategori</option>
                        <?php while ($k = mysqli_fetch_assoc($kategoriData)): ?>
                            <option value="<?= $k['id'] ?>"><?= $k['nama_kategori'] ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div>
                    <label class="block text-gray-700 font-bold mb-2">Harga (Rp)</label>
                    <input type="number" name="harga" required
                        class="w-full px-4 py-2 border rounded focus:ring-2 focus:ring-[#FACC15] outline-none">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-gray-700 font-bold mb-2">Stok</label>
                    <input type="number" name="stok" value="1" required
                        class="w-full px-4 py-2 border rounded focus:ring-2 focus:ring-[#FACC15] outline-none">
                </div>
                <div>
                    <label class="block text-gray-700 font-bold mb-2">Foto Barang</label>
                    <input type="file" name="photo" accept="image/*" required
                        class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-yellow-50 file:text-yellow-700 hover:file:bg-yellow-100">
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-bold mb-2">Deskripsi Kondisi & Minus</label>
                <textarea name="description" rows="4" required
                    class="w-full px-4 py-2 border rounded focus:ring-2 focus:ring-[#FACC15] outline-none"></textarea>
            </div>

            <div class="flex gap-4">
                <a href="my_products.php"
                    class="px-6 py-2 border border-gray-300 rounded text-gray-600 hover:bg-gray-50">Batal</a>
                <button type="submit"
                    class="flex-1 bg-[#1E3A8A] text-white font-bold py-2 px-4 rounded hover:bg-blue-900 transition">
                    UPDATE
                </button>
            </div>
        </form>
    </div>
</div>

<?php include '../../views/layouts/footer.php'; ?>