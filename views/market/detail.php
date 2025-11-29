<?php
session_start();
include '../../config/conn.php';
include '../../views/layouts/header.php';

// 1. Ambil ID dari URL
if (!isset($_GET['id'])) {
    echo "<script>alert('Produk tidak ditemukan!'); window.location.href='" . BASE_URL . "index.php';</script>";
    exit();
}

$id = $_GET['id'];

// 2. Query Detail Produk + Info Penjual + Kategori
$sql = "SELECT p.*, u.username, u.photo as user_photo, u.kota, k.nama_kategori 
        FROM product p 
        JOIN user u ON p.user_id = u.id 
        JOIN kategori k ON p.kategori_id = k.id 
        WHERE p.id = '$id'";

$result = mysqli_query($conn, $sql);
$data = mysqli_fetch_assoc($result);

// Jika produk tidak ada di database
if (!$data) {
    echo "<div class='min-h-screen flex items-center justify-center font-bold text-xl'>Produk tidak ditemukan :(</div>";
    include '../../views/layouts/footer.php';
    exit();
}

// Cek apakah ini produk sendiri? (Supaya tidak beli barang sendiri)
$is_own_product = isset($_SESSION['user_id']) && $_SESSION['user_id'] == $data['user_id'];
?>

<div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <a href="javascript:history.back()" class="inline-flex items-center gap-2 text-gray-500 hover:text-[#1E3A8A] mb-6 transition">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        <span>Kembali</span>
    </a>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="grid grid-cols-1 md:grid-cols-2">
            
            <div class="h-96 md:h-[600px] bg-gray-100 relative group overflow-hidden">
                <img src="<?= BASE_URL ?>uploads/products/<?= $data['photo'] ?>" 
                     alt="<?= $data['nama_product'] ?>" 
                     class="w-full h-full object-cover transition duration-500 group-hover:scale-105">
                
                <?php if($data['stok'] <= 0): ?>
                    <div class="absolute inset-0 bg-black/60 flex items-center justify-center">
                        <span class="text-white font-black text-3xl border-4 border-white px-6 py-2 tracking-widest uppercase">Sold Out</span>
                    </div>
                <?php endif; ?>
            </div>

            <div class="p-8 md:p-10 flex flex-col">
                
                <div class="flex justify-between items-start mb-4">
                    <span class="bg-blue-100 text-[#1E3A8A] px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide">
                        <?= $data['nama_kategori'] ?>
                    </span>
                    <?php if($data['stok'] > 0): ?>
                        <span class="text-sm font-semibold text-gray-500">Stok: <span class="text-slate-800"><?= $data['stok'] ?></span></span>
                    <?php else: ?>
                        <span class="text-sm font-bold text-red-500">Stok Habis</span>
                    <?php endif; ?>
                </div>

                <h1 class="text-3xl md:text-4xl font-black text-slate-800 mb-2 leading-tight">
                    <?= $data['nama_product'] ?>
                </h1>

                <div class="flex items-center gap-2 text-gray-500 mb-6">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    <span class="text-sm"><?= $data['kota'] ?></span>
                </div>

                <div class="text-4xl font-black text-[#059669] mb-8">
                    Rp <?= number_format($data['harga'], 0, ',', '.') ?>
                </div>

                <div class="bg-gray-50 p-4 rounded-xl flex items-center justify-between mb-8 border border-gray-100">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-full overflow-hidden bg-gray-300">
                             <?php if($data['user_photo']): ?>
                                <img src="<?= BASE_URL ?>uploads/profile/<?= $data['user_photo'] ?>" class="w-full h-full object-cover">
                            <?php else: ?>
                                <div class="w-full h-full flex items-center justify-center font-bold text-gray-500 bg-gray-200"><?= substr($data['username'], 0, 1) ?></div>
                            <?php endif; ?>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 font-bold uppercase">Penjual</p>
                            <p class="font-bold text-slate-800"><?= $data['username'] ?></p>
                        </div>
                    </div>
                    
                    <?php if(!$is_own_product): ?>
                        <a href="<?= BASE_URL ?>views/user/chat_room.php?partner_id=<?= $data['user_id'] ?>" 
                           class="text-[#1E3A8A] font-bold text-sm hover:underline flex items-center gap-1">
                           <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                           Chat Penjual
                        </a>
                    <?php endif; ?>
                </div>

                <div class="mb-8">
                    <h3 class="font-bold text-slate-800 mb-2">Deskripsi Barang</h3>
                    <p class="text-gray-600 leading-relaxed whitespace-pre-line"><?= $data['description'] ?></p>
                </div>

                <div class="mt-auto pt-6 border-t border-gray-100 flex gap-4">
                    <?php if($data['stok'] > 0 && !$is_own_product): ?>
                        
                        <form action="<?= BASE_URL ?>actions/cart_add.php" method="POST" class="w-full flex gap-4">
                            <input type="hidden" name="product_id" value="<?= $data['id'] ?>">
                            <input type="hidden" name="harga" value="<?= $data['harga'] ?>">
                            
                            <button type="submit" name="add_to_cart" 
                                class="flex-1 bg-white border-2 border-[#1E3A8A] text-[#1E3A8A] font-bold py-3.5 rounded-xl hover:bg-blue-50 transition flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                + Keranjang
                            </button>

                            <button type="button" onclick="alert('Fitur Checkout Langsung belum dibuat, silakan masuk keranjang dulu!')"
                                class="flex-1 bg-[#1E3A8A] text-white font-bold py-3.5 rounded-xl hover:bg-blue-900 transition shadow-lg shadow-blue-900/20">
                                Beli Sekarang
                            </button>
                        </form>

                    <?php elseif($is_own_product): ?>
                         <div class="w-full bg-gray-100 text-gray-500 text-center py-3 rounded-xl font-bold border-2 border-dashed border-gray-300">
                            Ini produk Anda sendiri
                        </div>
                    <?php else: ?>
                        <div class="w-full bg-gray-200 text-gray-500 text-center py-3 rounded-xl font-bold cursor-not-allowed">
                            Stok Habis
                        </div>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </div>

    <div class="mt-16">
        <h2 class="text-2xl font-bold text-slate-800 mb-6">Produk Lainnya</h2>
        <p class="text-gray-400">Belum ada produk terkait.</p>
    </div>

</div>

<?php include '../../views/layouts/footer.php'; ?>