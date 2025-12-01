<?php
include '../../config/conn.php';
include '../layouts/header.php';

// Cek Login
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Silakan login dulu!'); window.location.href='../auth/login.php';</script>";
    exit();
}

$pelapor_id = $_SESSION['user_id'];

// Cek ID User
if (!isset($_GET['id'])) {
    echo "<script>alert('User tidak ditemukan!'); window.history.back();</script>";
    exit();
}
$reported_id = $_GET['id'];

// Ambil Data User
$q = mysqli_query($conn, "SELECT * FROM user WHERE id='$reported_id'");
$reportedUser = mysqli_fetch_assoc($q);

if (!$reportedUser) {
    echo "<script>alert('User tidak ditemukan!'); window.history.back();</script>";
    exit();
}
?>

<div class="max-w-xl mx-auto mt-10 bg-white shadow-lg p-6 rounded-2xl border">
    <h2 class="text-2xl font-bold text-slate-800 mb-6">Laporkan User</h2>

    <div class="flex gap-4 items-center mb-6">
        <img src="<?= BASE_URL ?>uploads/profile/<?= $reportedUser['photo'] ?>"
            class="w-20 h-20 rounded object-cover border">
        <div>
            <p class="font-bold text-slate-900"><?= $reportedUser['username'] ?></p>
        </div>
    </div>

    <form action="../../actions/report_process.php" method="POST">
        <input type="hidden" name="jenis_report" value="user">
        <input type="hidden" name="reference_id" value="<?= $reportedUser['id'] ?>">
        <input type="hidden" name="pelapor_id" value="<?= $pelapor_id ?>">

        <label class="font-semibold">Alasan Laporan</label>
        <textarea name="alasan" required class="w-full border p-3 rounded-xl mt-1 mb-6" rows="4"
            placeholder="Mengapa user ini perlu dilaporkan..."></textarea>

        <button class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-3 rounded-xl">
            Kirim Laporan
        </button>
    </form>
</div>

<?php include '../layouts/footer.php'; ?>