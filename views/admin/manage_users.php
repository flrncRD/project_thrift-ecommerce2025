<?php
session_start();
include '../../config/conn.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: " . BASE_URL . "index.php");
    exit();
}

// Ambil Data User
$users = mysqli_query($conn, "SELECT * FROM user ORDER BY createdAt DESC");
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <title>Kelola User - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
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

                            <tr
                                class="border-b transition hover:bg-gray-50 <?= $row['status'] == 'inactive' ? 'bg-red-50' : '' ?>">

                                <td class="p-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-gray-200 overflow-hidden shadow-sm">
                                            <?php if (!empty($row['photo'])): ?>
                                                <img src="<?= BASE_URL ?>uploads/profile/<?= $row['photo'] ?>"
                                                    class="w-full h-full object-cover">
                                            <?php else: ?>
                                                <div class="flex items-center justify-center h-full font-bold text-gray-500">
                                                    <?= strtoupper(substr($row['username'], 0, 1)) ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>

                                        <div>
                                            <p class="font-bold text-slate-800 flex items-center gap-2">
                                                <?= $row['username'] ?>
                                                <?php if ($row['status'] == 'inactive'): ?>
                                                    <span
                                                        class="text-[10px] text-red-600 border border-red-600 px-1 rounded">BANNED</span>
                                                <?php endif; ?>
                                            </p>
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
                                    <?php if ($row['status'] == 'active'): ?>
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <span class="w-2 h-2 mr-1 bg-green-500 rounded-full"></span>
                                            Active
                                        </span>
                                    <?php else: ?>
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            <span class="w-2 h-2 mr-1 bg-red-500 rounded-full"></span>
                                            Inactive
                                        </span>
                                    <?php endif; ?>
                                </td>

                                <td class="p-4 text-sm text-gray-500">
                                    <?= date('d M Y', strtotime($row['createdAt'])) ?>
                                </td>

                                <td class="p-4 flex justify-center gap-2">
                                    <form action="<?= BASE_URL ?>actions/admin_users.php" method="POST"
                                        onsubmit="return confirm('Apakah Anda yakin ingin mengubah role user ini?');">
                                        <input type="hidden" name="user_id" value="<?= $row['id'] ?>">
                                        <input type="hidden" name="current_role" value="<?= $row['role'] ?>">
                                        <button type="submit" name="toggle_role"
                                            class="bg-yellow-400 text-white w-8 h-8 rounded hover:bg-yellow-500 transition shadow-sm flex items-center justify-center"
                                            title="Ubah Role (Admin/User)">
                                            <i class="fa-solid fa-crown text-sm"></i>
                                        </button>
                                    </form>

                                    <?php if ($row['status'] == 'active'): ?>
                                        <a href="<?= BASE_URL ?>actions/admin_users.php?action=delete&id=<?= $row['id'] ?>"
                                            onclick="return confirm('Yakin ingin menonaktifkan user ini? User tidak akan bisa login, tapi data chat aman.');"
                                            class="bg-red-500 text-white w-8 h-8 rounded hover:bg-red-600 transition shadow-sm flex items-center justify-center"
                                            title="Nonaktifkan User">
                                            <i class="fa-solid fa-ban text-sm"></i>
                                        </a>
                                    <?php else: ?>
                                        <a href="<?= BASE_URL ?>actions/admin_users.php?action=restore&id=<?= $row['id'] ?>"
                                            onclick="return confirm('Aktifkan kembali user ini?');"
                                            class="bg-emerald-500 text-white w-8 h-8 rounded hover:bg-emerald-600 transition shadow-sm flex items-center justify-center"
                                            title="Aktifkan Kembali User">
                                            <i class="fa-solid fa-check text-sm"></i>
                                        </a>
                                    <?php endif; ?>
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