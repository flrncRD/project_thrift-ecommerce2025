<?php
include 'config/conn.php';
include 'views/layouts/header.php';
include 'classes/products.php';

// Ambil Data Produk untuk Etalase
$productObj = new Products();
$products = $productObj->getAll($conn);
?>

<div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <div class="relative bg-gradient-to-r from-[#1E3A8A] to-[#059669] rounded-3xl shadow-2xl overflow-hidden mb-12">

        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 bg-white/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-80 h-80 bg-[#FACC15]/20 rounded-full blur-3xl"></div>

        <div class="relative z-10 flex flex-col md:flex-row items-center justify-between p-8 md:p-16">
            <div class="md:w-3/5 text-center md:text-left mb-8 md:mb-0">
                <span
                    class="inline-block bg-[#FACC15] text-[#1E3A8A] text-xs font-black px-3 py-1 rounded-full uppercase tracking-wider mb-4 shadow-md">
                    Sustainable Fashion
                </span>
                <h1 class="text-4xl md:text-6xl font-black text-white leading-tight mb-4 drop-shadow-sm">
                    Barang Branded,<br>
                    Harga <span class="text-[#FACC15] underline decoration-4 decoration-[#FACC15]/30">Teman.</span>
                </h1>
                <p class="text-lg text-blue-100 mb-8 max-w-xl mx-auto md:mx-0 font-medium">
                    Platform jual beli barang bekas mahasiswa. Temukan hidden gem dengan harga miring sekarang juga.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center md:justify-start">
                    <a href="#etalase"
                        class="bg-[#FACC15] text-[#1E3A8A] px-8 py-3.5 rounded-xl font-bold hover:bg-yellow-300 transition shadow-lg transform hover:-translate-y-1">
                        Mulai Belanja
                    </a>
                    <a href="views/store/add.php"
                        class="bg-white/10 backdrop-blur-md border border-white/30 text-white px-8 py-3.5 rounded-xl font-bold hover:bg-white/20 transition">
                        Jual Barang
                    </a>
                </div>
            </div>

            <div class="md:w-2/5 flex justify-center">
                <div
                    class="relative w-72 h-72 md:w-96 md:h-96 bg-white/10 backdrop-blur-sm rounded-2xl border border-white/20 flex items-center justify-center shadow-2xl transform rotate-3 hover:rotate-0 transition duration-500">
                    <div class="text-center">
                        <p class="text-6xl mb-2">🛍️</p>
                        <p class="text-white/80 font-bold text-lg">Thrift Zone</p>
                        <p class="text-white/50 text-sm">Best Deals Today</p>
                    </div>
                    <div
                        class="absolute -top-6 -right-6 bg-white text-[#1E3A8A] p-4 rounded-xl shadow-xl animate-bounce">
                        <p class="font-black text-xl">50%</p>
                        <p class="text-xs font-bold uppercase">Off</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="etalase" class="mb-8 flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-bold text-slate-800 flex items-center gap-2">
                <span class="w-2 h-8 bg-[#059669] rounded-full"></span>
                Rekomendasi Terbaru
            </h2>
            <p class="text-slate-500 mt-1 ml-4">Item pilihan yang baru saja diupload.</p>
        </div>
        <div class="hidden md:flex gap-2">
            <button
                class="px-4 py-2 bg-white border border-gray-200 rounded-full text-sm font-bold text-slate-600 hover:border-[#1E3A8A] hover:text-[#1E3A8A] transition">Semua</button>
            <button
                class="px-4 py-2 bg-white border border-gray-200 rounded-full text-sm font-medium text-slate-500 hover:border-[#1E3A8A] hover:text-[#1E3A8A] transition">Pakaian</button>
            <button
                class="px-4 py-2 bg-white border border-gray-200 rounded-full text-sm font-medium text-slate-500 hover:border-[#1E3A8A] hover:text-[#1E3A8A] transition">Sepatu</button>
        </div>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        <?php if (mysqli_num_rows($products) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($products)): ?>

                <?php
                $is_oos = ($row['stok'] <= 0);
                $oos_class = $is_oos ? "opacity-60 grayscale cursor-not-allowed" : "hover:-translate-y-2 hover:shadow-2xl cursor-pointer";
                ?>

                <div
                    class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden group transition duration-300 relative <?= $oos_class ?>">

                    <?php if (!$is_oos): ?>
                        <a href="views/market/detail.php?id=<?= $row['id'] ?>" class="absolute inset-0 z-10"></a>
                    <?php endif; ?>

                    <div class="relative h-64 overflow-hidden bg-gray-100">
                        <img src="<?= BASE_URL ?>uploads/products/<?= $row['photo'] ?>" alt="<?= $row['nama_product'] ?>"
                            class="w-full h-full object-cover group-hover:scale-110 transition duration-700">

                        <?php if ($is_oos): ?>
                            <div class="absolute inset-0 bg-black/50 flex items-center justify-center z-20">
                                <span
                                    class="bg-red-600 text-white px-4 py-2 rounded-lg font-black tracking-widest text-sm border-2 border-white shadow-lg transform -rotate-12">SOLD
                                    OUT</span>
                            </div>
                        <?php endif; ?>

                        <div
                            class="absolute bottom-2 left-2 bg-white/90 backdrop-blur text-xs font-bold px-2 py-1 rounded flex items-center gap-1 text-slate-700 shadow-sm">
                            <span>📍</span> <?= $row['kota'] ?>
                        </div>
                    </div>

                    <div class="p-5">
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <p class="text-[10px] font-bold text-[#059669] uppercase tracking-wide mb-1">Thrift</p>
                                <h3 class="font-bold text-slate-800 text-lg leading-tight line-clamp-1">
                                    <?= $row['nama_product'] ?></h3>
                            </div>
                        </div>

                        <div class="flex items-end justify-between mt-4">
                            <div class="flex flex-col">
                                <span class="text-xs text-gray-400 line-through">Rp
                                    <?= number_format($row['harga'] * 1.5, 0, ',', '.') ?></span>
                                <span class="text-[#1E3A8A] font-black text-xl">Rp
                                    <?= number_format($row['harga'], 0, ',', '.') ?></span>
                            </div>
                            <button
                                class="w-10 h-10 rounded-full bg-gray-50 flex items-center justify-center text-slate-400 group-hover:bg-[#FACC15] group-hover:text-[#1E3A8A] transition shadow-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

            <?php endwhile; ?>
        <?php else: ?>

            <div class="col-span-full py-16 text-center bg-white rounded-2xl border-2 border-dashed border-gray-200">
                <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-blue-50 text-blue-500 mb-4">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                        </path>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-slate-700">Belum ada produk saat ini</h3>
                <p class="text-slate-500 text-sm mt-2 mb-6">Jadilah penjual pertama di PindaHand!</p>
                <a href="views/store/add.php"
                    class="inline-flex items-center px-6 py-3 bg-[#059669] text-white font-bold rounded-lg hover:bg-emerald-700 transition shadow-lg">
                    + Mulai Jualan
                </a>
            </div>

        <?php endif; ?>
    </div>
</div>

<?php include 'views/layouts/footer.php'; ?>