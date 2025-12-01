<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<?php
include '../../config/conn.php';
include '../layouts/header.php';
include '../../classes/users.php';
include '../../classes/reviews.php';

$userObj = new Users();

// Ambil ID Seller
$seller_id = $_GET['id'] ?? 0;

// Cek Seller
$sellerResult = $userObj->getById($conn, $seller_id);
if (!$sellerResult || $sellerResult->num_rows == 0) {
    echo "<div class='text-center py-10 text-gray-500'>Seller tidak ditemukan</div>";
    include '../layouts/footer.php';
    exit;
}
$seller = $sellerResult->fetch_assoc();

// Ambil Review & Rating
$reviewList = Reviews::getBySellerId($conn, $seller_id);
$avgRating = Reviews::getAverageRating($conn, $seller_id);
?>

<div class="max-w-4xl mx-auto px-6 py-10">

    <div class="bg-white shadow-lg p-6 rounded-2xl border border-gray-200 mb-8 flex items-center gap-5">
        <img src="../../uploads/profile/<?= $seller['photo'] ?? 'default.png' ?>"
            class="w-20 h-20 rounded-full border shadow">

        <div class="flex-1">
            <div class="flex items-center gap-3">
                <h2 class="text-2xl font-bold text-slate-800"><?= $seller['username'] ?></h2>
                <a href="report_user.php?id=<?= $seller['id'] ?>" title="Laporkan Seller"
                    class="text-red-500 hover:text-red-700 transition">
                    <i class="fa-solid fa-flag text-xl"></i>
                </a>
            </div>

            <p class="text-yellow-500 text-lg font-semibold">
                ⭐ <?= $avgRating ?> / 5.0
            </p>

            <p class="text-gray-500 text-sm">
                Total Reviews: <?= $reviewList->num_rows ?>
            </p>
        </div>
    </div>

    <h3 class="text-xl font-bold mb-4 text-slate-800">Seller Reviews</h3>

    <?php if ($reviewList->num_rows == 0): ?>
        <p class="text-gray-500">Belum ada review untuk seller ini.</p>
    <?php else: ?>
        <div class="space-y-6">
            <?php while ($r = $reviewList->fetch_assoc()): ?>
                <div class="bg-white border border-gray-200 shadow p-5 rounded-2xl">
                    <div class="flex items-center gap-3 mb-3">
                        <img src="../../uploads/profile/<?= $r['buyer_photo'] ?? 'default.png' ?>"
                            class="w-12 h-12 rounded-full border">
                        <div>
                            <p class="font-bold text-slate-700"><?= $r['buyer_name'] ?></p>
                            <p class="text-yellow-500 font-semibold">⭐ <?= $r['rating'] ?></p>
                        </div>
                    </div>

                    <p class="text-gray-700 mb-3">"<?= $r['review'] ?>"</p>

                    <div class="flex items-center gap-3">
                        <img src="../../uploads/products/<?= $r['product_photo'] ?>"
                            class="w-16 h-16 rounded-xl border object-cover">
                        <p class="text-sm text-gray-600">
                            Review untuk produk:
                            <span class="font-semibold text-slate-800"><?= $r['nama_product'] ?></span>
                        </p>
                    </div>

                    <p class="text-xs text-gray-500 mt-2">
                        <?= date("d M Y H:i", strtotime($r['createdAt'])) ?>
                    </p>
                </div>
            <?php endwhile; ?>
        </div>
    <?php endif; ?>

</div>

<?php include '../layouts/footer.php'; ?>