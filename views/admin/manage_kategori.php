<?php
session_start();
include '../../config/conn.php';

// Cek Admin
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: " . BASE_URL . "index.php");
    exit();
}

// Ambil Kategori
$kategori = mysqli_query($conn, "SELECT * FROM kategori");
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <title>Kelola Kategori - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body class="bg-gray-100 font-[Inter]">

    <div class="flex">
        <?php include '../../views/layouts/sidebar_admin.php'; ?>

        <main class="flex-1 ml-64 p-8">
            <h2 class="text-2xl font-bold text-slate-800 mb-6">Kategori Produk</h2>

            <div class="bg-white p-6 rounded-lg shadow mb-8 max-w-lg">
                <h3 class="font-bold text-lg mb-4 text-[#1E3A8A]">Tambah Kategori Baru</h3>
                <form action="<?= BASE_URL ?>actions/admin_category.php" method="POST" class="flex gap-4">
                    <input type="text" name="nama_kategori" placeholder="Contoh: Jaket, Sepatu..." required
                        class="flex-1 border border-gray-300 rounded px-4 py-2 focus:ring-2 focus:ring-[#059669] outline-none">
                    <button type="submit" name="add_kategori"
                        class="bg-[#059669] text-white px-6 py-2 rounded font-bold hover:bg-emerald-700 transition">
                        + Simpan
                    </button>
                </form>
            </div>

            <div class="bg-white rounded-lg shadow overflow-hidden max-w-2xl">
                <table class="w-full text-left">
                    <thead class="bg-slate-800 text-white uppercase text-sm">
                        <tr>
                            <th class="p-4 w-16 text-center">ID</th>
                            <th class="p-4">Nama Kategori</th>
                            <th class="p-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        <?php while ($row = mysqli_fetch_assoc($kategori)): ?>
                            <tr class="border-b hover:bg-gray-50">
                                <td class="p-4 text-center font-mono text-sm"><?= $row['id'] ?></td>
                                <td class="p-4 font-bold"><?= $row['nama_kategori'] ?></td>
                                <td class="p-4 text-right">
                                    <a href="<?= BASE_URL ?>actions/admin_category.php?action=delete&id=<?= $row['id'] ?>"
                                        onclick="return confirm('Hapus kategori ini?')"
                                        class="text-red-500 hover:text-red-700 font-bold text-sm">
                                        Hapus 🗑️
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>

</html>