<?php
include '../../config/conn.php';
include '../../views/layouts/header.php';

// Cek Login
if (!isset($_SESSION['user_id'])) {
    echo "<script>window.location.href='" . BASE_URL . "views/auth/login.php';</script>";
    exit();
}

// Ambil Data User Terbaru dari Database
$id = $_SESSION['user_id'];
$query = mysqli_query($conn, "SELECT * FROM user WHERE id = '$id'");
$userData = mysqli_fetch_assoc($query);
?>

<div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <h1 class="text-3xl font-bold text-[#1E3A8A] mb-8">Pengaturan Akun</h1>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 text-center sticky top-24">
                <div class="w-32 h-32 mx-auto bg-gray-200 rounded-full overflow-hidden border-4 border-[#FACC15] mb-4 relative group">
                    <?php if (!empty($userData['photo'])): ?>
                        <img src="<?= BASE_URL ?>uploads/profile/<?= $userData['photo'] ?>" class="w-full h-full object-cover">
                    <?php else: ?>
                        <div class="w-full h-full flex items-center justify-center bg-[#1E3A8A] text-white text-4xl font-bold">
                            <?= substr($userData['username'], 0, 1) ?>
                        </div>
                    <?php endif; ?>
                </div>

                <h2 class="text-xl font-bold text-slate-800"><?= $userData['username'] ?></h2>
                <p class="text-sm text-gray-500 mb-4"><?= $userData['email'] ?></p>

                <div class="bg-blue-50 rounded-lg p-3 text-left mb-4">
                    <p class="text-xs font-bold text-[#1E3A8A] uppercase mb-1">Status Member</p>
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-green-500"></span>
                        <span class="text-sm font-semibold text-gray-700">Aktif</span>
                    </div>
                </div>

                <div class="text-xs text-gray-400">
                    Bergabung sejak <?= date('d M Y', strtotime($userData['createdAt'])) ?>
                </div>
            </div>
        </div>

        <div class="lg:col-span-2 space-y-8">

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 sm:p-8">
                <h3 class="text-xl font-bold text-[#1E3A8A] mb-6 border-b pb-2">Edit Profil</h3>
                
                <form action="<?= BASE_URL ?>actions/user_profile_update.php" method="POST" enctype="multipart/form-data">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                        <div>
                            <label class="block text-gray-700 font-bold mb-2 text-sm">Username (Tidak bisa diubah)</label>
                            <input type="text" value="<?= $userData['username'] ?>" disabled 
                                class="w-full px-4 py-2 bg-gray-100 border border-gray-300 rounded text-gray-500 cursor-not-allowed">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-bold mb-2 text-sm">Email (Tidak bisa diubah)</label>
                            <input type="email" value="<?= $userData['email'] ?>" disabled 
                                class="w-full px-4 py-2 bg-gray-100 border border-gray-300 rounded text-gray-500 cursor-not-allowed">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                        <div>
                            <label class="block text-gray-700 font-bold mb-2 text-sm">Kota Domisili</label>
                            <input type="text" name="kota" value="<?= $userData['kota'] ?>" required
                                class="w-full px-4 py-2 border border-gray-300 rounded focus:ring-2 focus:ring-[#059669] outline-none transition">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-bold mb-2 text-sm">No. WhatsApp / HP</label>
                            <input type="number" name="phone" value="<?= $userData['phone'] ?>" required
                                class="w-full px-4 py-2 border border-gray-300 rounded focus:ring-2 focus:ring-[#059669] outline-none transition">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2 text-sm">Alamat Lengkap</label>
                        <textarea name="alamat" rows="3" required
                            class="w-full px-4 py-2 border border-gray-300 rounded focus:ring-2 focus:ring-[#059669] outline-none transition"><?= $userData['alamat'] ?></textarea>
                    </div>

                    <div class="mb-6">
                        <label class="block text-gray-700 font-bold mb-2 text-sm">Ganti Foto Profil</label>
                        <input type="file" name="photo" accept="image/*"
                            class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer border border-gray-200 rounded-lg">
                        <p class="text-xs text-gray-400 mt-1">*Kosongkan jika tidak ingin mengganti foto.</p>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" name="update_profile" 
                            class="bg-[#1E3A8A] text-white px-6 py-2.5 rounded-lg font-bold hover:bg-blue-900 transition shadow-lg flex items-center gap-2">
                            <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 sm:p-8">
                <h3 class="text-xl font-bold text-red-600 mb-6 border-b pb-2 flex items-center gap-2">
                    Ganti Password
                </h3>

                <form action="<?= BASE_URL ?>actions/user_profile_update.php" method="POST">
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2 text-sm">Password Lama</label>
                        <input type="password" name="old_password" required placeholder="Masukkan password saat ini"
                            class="w-full px-4 py-2 border border-gray-300 rounded focus:ring-2 focus:ring-red-500 outline-none transition">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-gray-700 font-bold mb-2 text-sm">Password Baru</label>
                            <input type="password" name="new_password" required placeholder="Minimal 6 karakter" minlength="6"
                                class="w-full px-4 py-2 border border-gray-300 rounded focus:ring-2 focus:ring-red-500 outline-none transition">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-bold mb-2 text-sm">Konfirmasi Password Baru</label>
                            <input type="password" name="confirm_password" required placeholder="Ulangi password baru" minlength="6"
                                class="w-full px-4 py-2 border border-gray-300 rounded focus:ring-2 focus:ring-red-500 outline-none transition">
                        </div>
                    </div>

                    <div class="bg-yellow-50 text-yellow-800 text-sm p-3 rounded mb-6">
                        ⚠️ Setelah mengganti password, Anda akan otomatis logout dan harus login kembali.
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" name="change_password" 
                            class="bg-red-600 text-white px-6 py-2.5 rounded-lg font-bold hover:bg-red-700 transition shadow-lg">
                            Update Password
                        </button>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>

<?php include '../../views/layouts/footer.php'; ?>