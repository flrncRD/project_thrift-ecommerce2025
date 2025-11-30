<?php
include '../../config/conn.php';
include '../../views/layouts/header.php';
include '../../classes/products.php';

$productObj = new Products();

// 1. Ambil Keyword
$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';

// 2. Ambil Kategori (Bisa Array, Bisa String, Bisa Kosong)
$kategori_ids = [];
if (isset($_GET['kategori'])) {
    // Pastikan formatnya selalu array
    $kategori_ids = is_array($_GET['kategori']) ? $_GET['kategori'] : [$_GET['kategori']];
}

// 2. Pagination
$limit = 12;
$pageActive = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$start = ($pageActive > 1) ? ($pageActive * $limit) - $limit : 0;

// 3. Ambil Data (Kirim Array)
$totalData = $productObj->countSearch($conn, $keyword, $kategori_ids);
$totalPages = ceil($totalData / $limit);
$products = $productObj->searchProducts($conn, $keyword, $start, $limit, $kategori_ids);

// Helper function untuk membuat Link Pagination yang support Array
function buildUrl($page, $keyword, $kategori_ids)
{
    $params = [
        'keyword' => $keyword,
        'page' => $page
    ];
    // Gabungkan dengan array kategori
    if (!empty($kategori_ids)) {
        $params['kategori'] = $kategori_ids;
    }
    // http_build_query otomatis menangani array menjadi &kategori[0]=1&kategori[1]=2
    return '?' . http_build_query($params);
}
?>

<div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <div class="flex items-center gap-2 mb-6">
        <h2 class="text-2xl font-bold text-[#1E3A8A]">Hasil Pencarian</h2>
        <?php if (!empty($kategori_ids)): ?>
            <span class="bg-[#FACC15] text-[#1E3A8A] px-3 py-1 rounded-full text-xs font-bold">
                <?= count($kategori_ids) ?> Kategori Dipilih
            </span>
        <?php endif; ?>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        <?php if (mysqli_num_rows($products) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($products)): ?>
                <?php include '../../views/components/product_card.php'; ?>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="col-span-full py-20 text-center bg-white rounded-xl border border-dashed border-gray-300">
                <p class="text-gray-500 text-lg font-medium">Barang tidak ditemukan.</p>
            </div>
        <?php endif; ?>
    </div>

    <?php if ($totalPages > 1): ?>
        <div class="flex justify-center mt-10 space-x-2">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="<?= buildUrl($i, $keyword, $kategori_ids) ?>"
                    class="px-4 py-2 border rounded <?= $i == $pageActive ? 'bg-[#1E3A8A] text-white' : 'bg-white text-gray-700 hover:bg-gray-100' ?>">
                    <?= $i ?>
                </a>
            <?php endfor; ?>
        </div>
    <?php endif; ?>

</div>

<?php include '../../views/layouts/footer.php'; ?>