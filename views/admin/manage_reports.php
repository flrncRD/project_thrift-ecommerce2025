<?php
session_start();
include '../../config/conn.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: " . BASE_URL . "index.php");
    exit();
}

// Hanya Ambil Data
$query = "SELECT r.*, u.username 
          FROM report r 
          JOIN user u ON r.user_id = u.id 
          ORDER BY r.createdAt DESC";
$reports = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Laporan Masuk - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
</head>
<body class="bg-gray-100 font-[Inter]">

    <div class="flex">
        <?php include '../../views/layouts/sidebar_admin.php'; ?>

        <main class="flex-1 ml-64 p-8">
            <h2 class="text-2xl font-bold text-slate-800 mb-6">Laporan Masuk</h2>

            <div class="bg-white rounded-lg shadow overflow-hidden">
                <table class="w-full text-left">
                    <thead class="bg-red-700 text-white uppercase text-sm">
                        <tr>
                            <th class="p-4">Pelapor</th>
                            <th class="p-4">Jenis</th>
                            <th class="p-4">Alasan</th>
                            <th class="p-4">Status</th>
                            <th class="p-4">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        <?php if(mysqli_num_rows($reports) > 0): ?>
                            <?php while ($row = mysqli_fetch_assoc($reports)): ?>
                            <tr class="border-b hover:bg-gray-50">
                                <td class="p-4 font-bold"><?= $row['username'] ?></td>
                                <td class="p-4">
                                    <span class="px-2 py-1 text-xs font-bold bg-gray-200 rounded">
                                        <?= $row['jenis_report'] ?> (ID: <?= $row['reference_id'] ?>)
                                    </span>
                                </td>
                                <td class="p-4 text-sm text-gray-600 max-w-xs truncate">
                                    <?= $row['alasan'] ?>
                                </td>
                                <td class="p-4">
                                    <?php 
                                        $color = 'bg-yellow-100 text-yellow-800';
                                        if($row['status'] == 'Accepted') $color = 'bg-green-100 text-green-800';
                                        if($row['status'] == 'Rejected') $color = 'bg-red-100 text-red-800';
                                    ?>
                                    <span class="px-2 py-1 text-xs font-bold rounded <?= $color ?>">
                                        <?= $row['status'] ?>
                                    </span>
                                </td>
                                <td class="p-4 flex gap-2">
                                    <?php if($row['status'] == 'Reported'): ?>
                                        <form action="<?= BASE_URL ?>actions/admin_reports.php" method="POST">
                                            <input type="hidden" name="report_id" value="<?= $row['id'] ?>">
                                            <input type="hidden" name="update_status" value="1">
                                            <button type="submit" name="status" value="Accepted" class="bg-green-600 text-white px-3 py-1 rounded text-xs hover:bg-green-700 mr-1">Terima</button>
                                            <button type="submit" name="status" value="Rejected" class="bg-red-600 text-white px-3 py-1 rounded text-xs hover:bg-red-700">Tolak</button>
                                        </form>
                                    <?php else: ?>
                                        <span class="text-xs text-gray-400">Selesai</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr><td colspan="5" class="p-6 text-center text-gray-500">Tidak ada laporan baru.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>
</html>