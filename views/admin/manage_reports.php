<?php
session_start();
include '../../config/conn.php';

// Cek Admin
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: " . BASE_URL . "index.php");
    exit();
}

// Ambil Data
$users = mysqli_query($conn, "SELECT * FROM user ORDER BY createdAt DESC");
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <title>Kelola User - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
</head>

<body class="bg-gray-100 font-[Inter]">

    <div class="flex">
        <?php include '../../views/layouts/sidebar_admin.php'; ?>

        <main class="flex-1 ml-64 p-8">
            <h2 class="text-2xl font-bold text-slate-800 mb-6">Manajemen Pengguna</h2>

            <div class="bg-white rounded-lg shadow overflow-hidden">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-slate-800 text-white uppercase text-sm">
                        <tr>
                            <th class="p-4">User Info</th>
                            <th class="p-4">Role</th>
                            <th class="p-4">Status</th>
                            <th class="p-4">Bergabung</th>
                            <th class="p-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        <?php while ($row = mysqli_fetch_assoc($users)): ?>
                            <tr class="border-b hover:bg-gray-50">
                                <td class="p-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-gray-200 overflow-hidden">
                                            <?php if ($row['photo']): ?>
                                                <img src="<?= BASE_URL ?>uploads/profile/<?= $row['photo'] ?>"
                                                    class="w-full h-full object-cover">
                                            <?php else: ?>
                                                <div class="flex items-center justify-center h-full font-bold text-gray-500">
                                                    <?= substr($row['username'], 0, 1) ?></div>
                                            <?php endif; ?>
                                        </div>
                                        <div>
                                            <p class="font-bold text-slate-800"><?= $row['username'] ?></p>
                                            <p class="text-xs text-gray-500"><?= $row['email'] ?></p>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-4">
                                    <span
                                        class="px-2 py-1 text-xs font-bold rounded <?= $row['role'] == 'admin' ? 'bg-purple-100 text-purple-700' : 'bg-blue-100 text-blue-700' ?>">
                                        <?= strtoupper($row['role']) ?>
                                    </span>
                                </td>
                                <td class="p-4">
                                    <span class="text-xs font-semibold text-green-600">Active</span>
                                </td>
                                <td class="p-4 text-sm text-gray-500">
                                    <?= date('d M Y', strtotime($row['createdAt'])) ?>
                                </td>
                                <td class="p-4 flex justify-center gap-2">
                                    <form action="<?= BASE_URL ?>actions/admin_users.php" method="POST"
                                        onsubmit="return confirm('Ubah role user ini?');">
                                        <input type="hidden" name="user_id" value="<?= $row['id'] ?>">
                                        <input type="hidden" name="current_role" value="<?= $row['role'] ?>">
                                        <button type="submit" name="toggle_role"
                                            class="bg-yellow-400 text-white p-2 rounded hover:bg-yellow-500"
                                            title="Ubah Role">
                                            👑
                                        </button>
                                    </form>

                                    <a href="<?= BASE_URL ?>actions/admin_users.php?action=delete&id=<?= $row['id'] ?>"
                                        onclick="return confirm('Yakin ingin menghapus user ini secara permanen?');"
                                        class="bg-red-500 text-white p-2 rounded hover:bg-red-600" title="Hapus User">
                                        🗑️
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