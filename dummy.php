<?php
// Mock Data PindaHand (Tetap sama)
$products = [
    [
        "name" => "Vintage Varsity Jacket 'Bull 98'",
        "category" => "Outerwear",
        "price" => "Rp 285.000",
        "condition" => "Rare Item",
        "image" => "https://placehold.co/400x400/1e293b/FFF?text=Varsity+Jacket"
    ],
    [
        "name" => "Sepatu Dr. Martens 1460 (Cherry Red)",
        "category" => "Shoes",
        "price" => "Rp 850.000",
        "condition" => "Like New",
        "image" => "https://placehold.co/400x400/9f1239/FFF?text=Dr.+Martens"
    ],
    [
        "name" => "Kemeja Flanel Uniqlo Kotak-Kotak",
        "category" => "Kemeja",
        "price" => "Rp 120.000",
        "condition" => "Good",
        "image" => "https://placehold.co/400x400/059669/FFF?text=Flannel"
    ],
    [
        "name" => "Levi's 501 Original Fit Jeans",
        "category" => "Denim",
        "price" => "Rp 350.000",
        "condition" => "Faded",
        "image" => "https://placehold.co/400x400/1e3a8a/FFF?text=Levis+501"
    ],
];
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PindaHand - Eco Style</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        :root {
            /* 1. BACKGROUND
               Tetap bersih menggunakan Slate/Gray yang sangat muda.
            */
            --bg-body: #F8FAFC;
            --text-main: #0F172A;
            /* Slate 900 */
            --text-muted: #64748B;
            /* Slate 500 */

            /* 2. PRIMARY BRAND COLOR (GREEN - ECO)
               Kita ganti Teal sebelumnya menjadi "Emerald Green".
               Ini warna utama untuk Logo dan Elemen identitas.
            */
            --brand-primary: #059669;
            /* Emerald 600 */
            --brand-dark: #047857;
            /* Emerald 700 (Hover) */

            /* 3. BASE COLOR (BLUE - DENIM)
               Warna pendukung untuk memberikan kesan kokoh/profesional.
               Digunakan di Gradient header dan Footer.
            */
            --base-blue: #1E3A8A;
            /* Blue 900 (Navy) */

            /* 4. ACCENT & CTA (YELLOW - POP)
               Digunakan untuk Tombol "Beli" dan "Harga".
               Kuning menarik mata, teksnya hitam agar terbaca jelas.
            */
            --accent-pop: #FACC15;
            /* Yellow 400 */
            --accent-hover: #EAB308;
            /* Yellow 500 */
            --accent-soft: #FEF9C3;
            /* Yellow 100 (Background badge) */
        }

        body {
            background-color: var(--bg-body);
            color: var(--text-main);
            font-family: 'Inter', sans-serif;
        }

        /* Utility Classes Custom */
        .bg-brand {
            background-color: var(--brand-primary);
        }

        .bg-brand:hover {
            background-color: var(--brand-dark);
        }

        .text-brand {
            color: var(--brand-primary);
        }

        /* Custom Button Style for Yellow (Text must be dark) */
        .bg-accent {
            background-color: var(--accent-pop);
            color: #0F172A;
            /* Slate 900 text for contrast */
        }

        .bg-accent:hover {
            background-color: var(--accent-hover);
        }

        .text-accent {
            color: #D97706;
            /* Amber 600 for text elements (darker yellow) */
        }

        .bg-accent-soft {
            background-color: var(--accent-soft);
            color: #B45309;
            /* Amber 700 text */
        }

        .border-brand {
            border-color: var(--brand-primary);
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
</head>

<body class="antialiased">

    <nav class="bg-white sticky top-0 z-50 border-b border-slate-200 shadow-sm">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <div class="text-2xl font-extrabold tracking-tight flex items-center gap-1">
                <span style="color: var(--base-blue);">Pinda</span><span class="text-brand">Hand</span>
                <div class="w-2 h-2 rounded-full bg-accent ml-1"></div>
            </div>

            <div class="hidden md:flex flex-1 mx-12 relative">
                <input type="text" placeholder="Cari barang bekas berkualitas..."
                    class="w-full bg-slate-100 border-none rounded-full px-6 py-2.5 text-sm focus:ring-2 focus:ring-[var(--brand-primary)] outline-none transition-all">
                <button
                    class="absolute right-2 top-1.5 bg-brand text-white p-1.5 rounded-full hover:scale-105 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </button>
            </div>

            <div class="flex items-center gap-5">
                <button class="relative text-slate-600 hover:text-brand transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                        </path>
                    </svg>
                    <span
                        class="absolute -top-1 -right-1 w-2.5 h-2.5 bg-accent rounded-full border border-white"></span>
                </button>
                <a href="#"
                    class="bg-slate-900 text-white px-5 py-2 rounded-full text-sm font-bold hover:bg-slate-700 transition shadow-lg shadow-slate-200">
                    Jual Barang
                </a>
            </div>
        </div>
    </nav>

    <header class="relative overflow-hidden bg-gradient-to-r from-blue-900 to-emerald-600 text-white">
        <div class="container mx-auto px-6 py-16 md:py-20 relative z-10 flex flex-col md:flex-row items-center">
            <div class="md:w-1/2 mb-10 md:mb-0">
                <span
                    class="inline-block bg-white/10 backdrop-blur-md border border-white/20 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider mb-6 text-emerald-100">
                    ♻️ Save Earth, Shop Thrift
                </span>
                <h1 class="text-5xl md:text-6xl font-extrabold leading-tight mb-6">
                    Gaya Unik,<br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-300 to-green-300">Dompet
                        Asik.</span>
                </h1>
                <p class="text-lg text-slate-100 mb-8 max-w-lg leading-relaxed">
                    Platform thrift PindaHand kurasi item fashion terbaik. Temukan gaya 90s, Y2K, hingga basic wear
                    dengan harga mahasiswa.
                </p>
                <div class="flex gap-4">
                    <button
                        class="bg-accent text-slate-900 font-bold px-8 py-3.5 rounded-xl shadow-xl shadow-emerald-900/20 hover:-translate-y-1 transition duration-300 border border-yellow-500">
                        Belanja Sekarang
                    </button>
                    <button
                        class="bg-white/10 backdrop-blur-sm border border-white/30 text-white font-semibold px-8 py-3.5 rounded-xl hover:bg-white/20 transition">
                        Lihat Kategori
                    </button>
                </div>
            </div>

            <div class="md:w-1/2 flex justify-center relative">
                <div class="absolute w-96 h-96 bg-emerald-500 blur-[100px] opacity-30 rounded-full -z-10"></div>
                <div
                    class="bg-white text-slate-800 p-4 rounded-2xl shadow-2xl rotate-3 hover:rotate-0 transition duration-500 w-72 border border-white/20">
                    <img src="https://placehold.co/300x300/1e3a8a/FFF?text=Denim+Jacket"
                        class="rounded-xl mb-4 w-full object-cover h-56">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-xs text-slate-500 font-bold uppercase">Trending Now</p>
                            <p class="font-bold text-lg">Vintage Denim</p>
                        </div>
                        <span class="bg-accent-soft text-xs font-bold px-2 py-1 rounded">Rp 150rb</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]">
        </div>
    </header>

    <main class="container mx-auto px-6 py-16">
        <div class="flex justify-between items-end mb-10 border-b border-slate-200 pb-4">
            <div>
                <h2 class="text-3xl font-extrabold text-slate-900">Baru Mendarat 🚀</h2>
                <p class="text-slate-500 mt-1">Item pilihan editor yang baru saja diupload seller.</p>
            </div>
            <a href="#" class="text-brand font-bold hover:text-emerald-700 transition flex items-center gap-1">
                Lihat Semua &rarr;
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            <?php foreach ($products as $product): ?>
                <div
                    class="group bg-white rounded-2xl shadow-sm border border-slate-100 hover:shadow-xl hover:border-emerald-200 transition duration-300 overflow-hidden flex flex-col">
                    <div class="relative overflow-hidden aspect-square bg-slate-100">
                        <img src="<?= $product['image'] ?>" alt="<?= $product['name'] ?>"
                            class="w-full h-full object-cover group-hover:scale-105 transition duration-500">

                        <div
                            class="absolute top-3 left-3 bg-white/90 backdrop-blur-sm text-slate-800 text-[10px] font-bold px-2.5 py-1 rounded-md border border-slate-200 uppercase tracking-wide">
                            <?= $product['condition'] ?>
                        </div>

                        <button
                            class="absolute top-3 right-3 bg-white p-2 rounded-full shadow-md opacity-0 group-hover:opacity-100 translate-y-2 group-hover:translate-y-0 transition duration-300 text-slate-400 hover:text-yellow-500">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                </path>
                            </svg>
                        </button>
                    </div>

                    <div class="p-5 flex flex-col flex-1">
                        <p class="text-xs font-bold text-brand mb-1 uppercase tracking-wide"><?= $product['category'] ?></p>
                        <h3 class="font-bold text-slate-800 text-lg mb-2 leading-snug line-clamp-2"><?= $product['name'] ?>
                        </h3>

                        <div class="mt-auto pt-3 flex justify-between items-center">
                            <div class="flex flex-col">
                                <span class="text-[10px] text-slate-400 line-through">Rp 999.000</span>
                                <span class="text-emerald-700 font-extrabold text-xl"><?= $product['price'] ?></span>
                            </div>
                            <button
                                class="bg-accent text-slate-900 w-10 h-10 rounded-xl flex items-center justify-center hover:bg-yellow-500 transition shadow-md">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </main>

    <footer style="background-color: var(--base-blue);" class="text-slate-300 py-12 border-t border-blue-800">
        <div class="container mx-auto px-6 text-center">
            <div class="text-2xl font-extrabold text-white mb-4 tracking-tight">
                Pinda<span class="text-brand">Hand</span>
            </div>
            <p class="text-sm mb-8 max-w-md mx-auto opacity-80">
                Project Teknologi Web Team 7. Dibuat dengan ❤️, PHP Native, dan Tailwind CSS.
            </p>
            <div class="flex justify-center gap-6 text-sm font-semibold">
                <a href="#" class="hover:text-white transition">Tentang Kami</a>
                <a href="#" class="hover:text-white transition">Syarat & Ketentuan</a>
                <a href="#" class="hover:text-white transition">Kebijakan Privasi</a>
            </div>
            <p class="text-xs text-slate-400 mt-10">&copy; 2025 Team 7 PindaHand. All rights reserved.</p>
        </div>
    </footer>

</body>

</html>