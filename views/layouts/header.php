<?php
// Pastikan session start hanya ada di sini
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Pastikan file ini punya akses ke conn.php untuk baca BASE_URL
// (Biasanya index.php atau file induk yang include conn.php)
?>

<nav class="bg-white border-b border-gray-200 fixed w-full z-20 top-0 start-0">
    <a href="<?= BASE_URL ?>index.php" class="...">Home</a>

    <?php if (isset($_SESSION['username'])): ?>
        <a href="<?= BASE_URL ?>views/user/dashboard.php" class="...">Dashboard</a>
        <a href="<?= BASE_URL ?>actions/auth_logout.php" class="text-red-600 ...">Logout</a>
    <?php else: ?>
        <a href="<?= BASE_URL ?>views/auth/login.php" class="...">Login</a>
    <?php endif; ?>

</nav>