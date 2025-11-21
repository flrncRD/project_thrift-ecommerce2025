<?php
include 'config/conn.php';
include 'views/layouts/header.php';
?>

<header class="bg-gradient-to-r from-[#1E3A8A] to-[#059669] text-white py-20">
    <div class="container mx-auto px-6 text-center md:text-left flex flex-col md:flex-row items-center">
        <div class="md:w-1/2">
            <span class="bg-white/20 text-xs font-bold px-3 py-1 rounded-full border border-white/30">SUSTAINABLE
                FASHION</span>
            <h1 class="text-5xl font-extrabold mt-4 mb-6 leading-tight">
                Barang Branded,<br>Harga <span class="text-[#FACC15]">Teman.</span>
            </h1>
            <p class="text-lg mb-8 opacity-90">
                Platform jual beli barang bekas mahasiswa. Temukan hidden gem dengan harga miring sekarang juga.
            </p>
            <a href="#"
                class="bg-[#FACC15] text-[#1E3A8A] px-8 py-3 rounded-lg font-bold hover:bg-yellow-300 transition shadow-lg inline-block">
                Mulai Belanja
            </a>
        </div>
        <div class="md:w-1/2 mt-10 md:mt-0 flex justify-center">
            <div
                class="w-80 h-80 bg-white/10 backdrop-blur rounded-2xl border-2 border-white/20 flex items-center justify-center">
                <span class="text-white/50 font-bold">Ilustrasi Hero</span>
            </div>
        </div>
    </div>
</header>

<main class="container mx-auto px-6 py-16">
    <h2 class="text-2xl font-bold text-[#1E3A8A] mb-6 border-l-4 border-[#FACC15] pl-4">Rekomendasi Terbaru</h2>

    <div class="p-10 text-center bg-white border border-gray-200 rounded-lg shadow-sm">
        <p class="text-gray-500">Belum ada produk yang ditampilkan.</p>
        <p class="text-sm text-[#059669]">Silakan Login dan mulai jual barang di menu "Toko Saya".</p>
    </div>
</main>

<?php include 'views/layouts/footer.php'; ?>