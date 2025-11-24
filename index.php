<?php
include 'config/conn.php';
include 'views/layouts/header.php';
include 'classes/products.php';

// Inisialisasi Class
$productObj = new Products();

// 1. Ambil Data Kategori (Untuk Section Categories)
$kategoriQuery = mysqli_query($conn, "SELECT * FROM kategori LIMIT 6");

// 2. Ambil Produk "Best Quality" (Kita asumsikan barang termahal/terbaru)
// Limit 8 barang
$bestProducts = mysqli_query($conn, "SELECT p.*, u.kota FROM product p JOIN user u ON p.user_id = u.id WHERE p.status = 'active' ORDER BY p.harga DESC LIMIT 8");

// 3. Ambil Produk "Popular" (Kita asumsikan barang Random)
// Limit 4 barang
$popProducts = mysqli_query($conn, "SELECT p.*, u.kota FROM product p JOIN user u ON p.user_id = u.id WHERE p.status = 'active' ORDER BY RAND() LIMIT 4");
?>

<div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

    <div
        class="bg-gray-200 rounded-xl overflow-hidden shadow-sm mb-10 relative h-64 md:h-80 flex items-center justify-center bg-gradient-to-r from-[#1E3A8A] to-[#059669]">
        <div class="text-center px-4">
            <h1 class="text-4xl md:text-5xl font-black text-white mb-2 tracking-tight">HERO SECTION</h1>
            <p class="text-blue-100 text-lg">Temukan barang thrift berkualitas dengan harga miring.</p>
        </div>
    </div>

    <div class="mb-12">
        <h2 class="text-2xl font-bold text-slate-800 mb-6">Categories</h2>
        <div class="grid grid-cols-3 md:grid-cols-6 gap-4">
            <?php while ($kat = mysqli_fetch_assoc($kategoriQuery)): ?>
                <a href="#" class="group block">
                    <div
                        class="bg-gray-200 h-32 rounded-lg flex items-center justify-center mb-2 group-hover:bg-[#1E3A8A] transition duration-300">
                        <span class="text-4xl grayscale group-hover:grayscale-0 transition">📦</span>
                    </div>
                    <p class="text-center font-bold text-slate-700 group-hover:text-[#1E3A8A]">
                        <?= $kat['nama_kategori'] ?>
                    </p>
                </a>
            <?php endwhile; ?>
        </div>
    </div>

    <div class="mb-12">
        <h2 class="text-2xl font-bold text-slate-800 mb-6">Best Second Hand Quality</h2>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <?php if (mysqli_num_rows($bestProducts) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($bestProducts)): ?>
                    <?php include 'views/components/product_card.php'; ?>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="col-span-4 text-center text-gray-400 py-10">Belum ada produk.</p>
            <?php endif; ?>
        </div>

        <div class="text-center mt-8">
            <a href="#" class="text-[#1E3A8A] font-bold hover:underline">See More Products</a>
        </div>
    </div>

    <div class="mb-12">
        <h2 class="text-2xl font-bold text-slate-800 mb-6">Popular Product</h2>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <?php if (mysqli_num_rows($popProducts) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($popProducts)): ?>
                    <?php include 'views/components/product_card.php'; ?>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="col-span-4 text-center text-gray-400 py-10">Belum ada produk populer.</p>
            <?php endif; ?>
        </div>

        <div class="text-center mt-8">
            <a href="#" class="text-[#1E3A8A] font-bold hover:underline">See More Products</a>
        </div>
    </div>

</div>

<?php include 'views/layouts/footer.php'; ?>