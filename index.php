<?php
include 'config/conn.php';
include 'views/layouts/header.php';
include 'classes/products.php';

// Inisialisasi Class
$productObj = new Products();

// 1. Ambil Data Kategori (Untuk Section Categories)
$kategoriQuery = $productObj->getCategories($conn);

// 2. Ambil Produk "Best Quality" (Kita asumsikan barang termahal/terbaru)
// Limit 8 barang
$bestProducts = $productObj->getBestProducts($conn);

// 3. Ambil Produk "Popular" (Kita asumsikan barang Random)
// Limit 4 barang
$popProducts = $productObj->getPopularProducts($conn);
?>

<div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

    <!-- <div
        class="bg-gray-200 rounded-xl overflow-hidden shadow-sm mb-10 relative h-64 md:h-80 flex items-center justify-center bg-gradient-to-r from-[#1E3A8A] to-[#059669]">
        <div class="text-center px-4">
            <h1 class="text-4xl md:text-5xl font-black text-white mb-2 tracking-tight">HERO SECTION</h1>
            <p class="text-blue-100 text-lg">Temukan barang thrift berkualitas dengan harga miring.</p>
        </div>
    </div> -->

    <div x-data="{
            activeSlide: 0,
            slides: [
                'https://images.unsplash.com/photo-1483985988355-763728e1935b?q=80&w=2070&auto=format&fit=crop', // Gambar 1 (Fashion)
                'https://images.unsplash.com/photo-1556905055-8f358a7a47b2?q=80&w=2070&auto=format&fit=crop', // Gambar 2 (Thrift Store)
                'https://images.unsplash.com/photo-1441986300917-64674bd600d8?q=80&w=2070&auto=format&fit=crop'  // Gambar 3 (Clothing Rack)
            ],
            loop() {
                setInterval(() => {
                    this.activeSlide = (this.activeSlide === this.slides.length - 1) ? 0 : this.activeSlide + 1;
                }, 5000); // Bergerak setiap 5000ms (5 detik)
            }
        }" x-init="loop()" class="relative w-full rounded-xl overflow-hidden shadow-lg mb-10 group h-64 md:h-[400px]">

        <div class="absolute inset-0 flex transition-transform duration-700 ease-in-out h-full"
            :style="'transform: translateX(-' + (activeSlide * 100) + '%)'">

            <template x-for="slide in slides" :key="slide">
                <div class="min-w-full h-full relative">
                    <img :src="slide" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                </div>
            </template>

        </div>

        <button @click="activeSlide = activeSlide === 0 ? slides.length - 1 : activeSlide - 1"
            class="absolute top-1/2 left-4 -translate-y-1/2 bg-white/30 hover:bg-white text-white hover:text-[#1E3A8A] p-2 rounded-full backdrop-blur-sm transition opacity-0 group-hover:opacity-100">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
        </button>

        <button @click="activeSlide = activeSlide === slides.length - 1 ? 0 : activeSlide + 1"
            class="absolute top-1/2 right-4 -translate-y-1/2 bg-white/30 hover:bg-white text-white hover:text-[#1E3A8A] p-2 rounded-full backdrop-blur-sm transition opacity-0 group-hover:opacity-100">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
        </button>

        <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex space-x-2">
            <template x-for="(slide, index) in slides" :key="index">
                <button @click="activeSlide = index"
                    class="w-3 h-3 rounded-full transition-all duration-300 border border-white"
                    :class="activeSlide === index ? 'bg-[#FACC15] scale-110' : 'bg-white/50 hover:bg-white'">
                </button>
            </template>
        </div>

    </div>

    <!-- ### Penjelasan Perubahan:

1.  **Alpine JS (`x-data`)**:
    * `slides`: Array yang berisi link gambar (saya pakai gambar dari Unsplash sebagai contoh). Kamu bisa menggantinya dengan path gambar lokal nanti.
    * `loop()`: Fungsi `setInterval` yang berjalan setiap **5000ms (5 detik)** untuk mengubah `activeSlide` ke slide berikutnya secara otomatis.
2.  **Transisi (`transition-transform`)**:
    * Kita menggunakan CSS Transform untuk menggeser gambar ke kiri/kanan dengan mulus (`duration-700`).
3.  **Responsif**:
    * Saya ubah tinggi containernya: `h-64` (untuk HP) dan `md:h-[400px]` (untuk Laptop/PC) agar gambar terlihat lebih besar dan jelas.
4.  **Kontrol (Panah & Dots)**:
    * Saya tambahkan tombol Next/Prev yang hanya muncul saat mouse diarahkan ke banner (`group-hover:opacity-100`).
    * Ada indikator titik-titik di bawah untuk menunjukkan sedang di slide ke berapa.

Silakan simpan dan refresh halaman index kamu. Banner Hero Section sekarang sudah berubah menjadi slideshow gambar yang bergerak! -->

    <!-- <div class="mb-12">
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
    </div> -->

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