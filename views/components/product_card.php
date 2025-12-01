<?php
// Cek stok habis
$is_oos = ($row['stok'] <= 0);
$oos_class = $is_oos ? "opacity-60 grayscale cursor-not-allowed" : "hover:-translate-y-1 hover:shadow-lg cursor-pointer";
?>

<div class="bg-white rounded-none md:rounded-lg overflow-hidden group transition duration-300 <?= $oos_class ?>">

    <?php if (!$is_oos): ?>
        <a href="../../views/market/detail.php?id=<?= $row['id'] ?>" class="block">
        <?php endif; ?>

        <div class="aspect-square bg-gray-300 w-full overflow-hidden relative">
            <img src="<?= BASE_URL ?>uploads/products/<?= $row['photo'] ?>" alt="<?= $row['nama_product'] ?>"
                class="w-full h-full object-cover">

            <?php if ($is_oos): ?>
                <div class="absolute inset-0 bg-black/50 flex items-center justify-center">
                    <span class="text-white font-bold border-2 border-white px-2 py-1">SOLD OUT</span>
                </div>
            <?php endif; ?>
        </div>

        <div class="px-4 py-4">
            <h3 class="font-bold text-slate-800 text-lg truncate"><?= $row['nama_product'] ?></h3>
            <p class="text-sm text-gray-500 mb-1 truncate"><?= $row['description'] ?></p>
            <p class="font-black text-slate-900">Rp <?= number_format($row['harga'], 0, ',', '.') ?></p>
        </div>

        <?php if (!$is_oos): ?>
        </a>
    <?php endif; ?>
</div>