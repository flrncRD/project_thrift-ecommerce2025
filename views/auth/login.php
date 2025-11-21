<?php include '../../config/conn.php'; ?>
<!DOCTYPE html>
<html lang="id">

<head>
    <title>Login - PindaHand</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex items-center justify-center h-screen">

    <div class="bg-white p-8 rounded-lg shadow-lg w-96 border-t-4 border-[#1E3A8A]">
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-[#1E3A8A]">Selamat Datang</h1>
            <p class="text-sm text-gray-500">Silakan masuk ke akun PindaHand</p>
        </div>

        <form action="<?= BASE_URL ?>actions/auth_login.php" method="POST">
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Username</label>
                <input type="text" name="username" required
                    class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-[#059669]">
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                <input type="password" name="password" required
                    class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-[#059669]">
            </div>

            <button type="submit"
                class="w-full bg-[#FACC15] text-[#1E3A8A] font-bold py-2 px-4 rounded hover:bg-yellow-400 transition">
                MASUK
            </button>
        </form>

        <p class="text-center mt-4 text-sm">
            Belum punya akun? <a href="register.php" class="text-[#059669] font-bold hover:underline">Daftar Disini</a>
        </p>
    </div>

</body>

</html>