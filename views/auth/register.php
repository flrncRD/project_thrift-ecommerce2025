<?php include '../../config/conn.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Daftar Akun - PindaHand</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen py-10">

    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md border-t-4 border-[#059669]">
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-[#059669]">Gabung PindaHand</h1>
            <p class="text-sm text-gray-500">Mulai jualan atau belanja barang thrift.</p>
        </div>

        <form action="<?= BASE_URL ?>actions/auth_register.php" method="POST" enctype="multipart/form-data">
            
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Username</label>
                <input type="text" name="txtusername" required class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-[#059669]">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                <input type="email" name="txtemail" required class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-[#059669]">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                <input type="password" name="txtpass" required class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-[#059669]">
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Alamat</label>
                    <input type="text" name="txtalamat" required class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-[#059669]">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Kota</label>
                    <input type="text" name="txtkota" required class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-[#059669]">
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">No Handphone</label>
                <input type="text" name="txtphone" required class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-[#059669]">
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2">Foto Profil</label>
                <input type="file" name="txtprofile" accept="image/*" required class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-[#059669] hover:file:bg-green-100">
            </div>

            <button type="submit" class="w-full bg-[#059669] text-white font-bold py-2 px-4 rounded hover:bg-emerald-700 transition">
                DAFTAR SEKARANG
            </button>
        </form>

        <p class="text-center mt-4 text-sm">
            Sudah punya akun? <a href="login.php" class="text-[#1E3A8A] font-bold hover:underline">Masuk Disini</a>
        </p>
    </div>

</body>
</html>