<?php
include '../../config/conn.php';
include '../../views/layouts/header.php';
include '../../classes/chats.php';

if (!isset($_SESSION['user_id'])) {
    echo "<script>window.location.href='" . BASE_URL . "views/auth/login.php';</script>";
    exit();
}

$chatObj = new Chats();
$chatList = $chatObj->getChatList($conn, $_SESSION['user_id']);
?>

<div class="w-full max-w-4xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-[#1E3A8A] mb-6">Pesan Masuk</h1>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <?php if (mysqli_num_rows($chatList) > 0): ?>
            <ul class="divide-y divide-gray-100">
                <?php while ($row = mysqli_fetch_assoc($chatList)): ?>
                    <li>
                        <a href="chat_room.php?partner_id=<?= $row['id'] ?>" class="flex items-center gap-4 p-4 hover:bg-gray-50 transition group">
                            
                            <div class="relative w-12 h-12 flex-shrink-0">
                                <div class="w-12 h-12 rounded-full overflow-hidden bg-gray-200 border border-gray-300">
                                    <?php if ($row['photo']): ?>
                                        <img src="<?= BASE_URL ?>uploads/profile/<?= $row['photo'] ?>" class="w-full h-full object-cover">
                                    <?php else: ?>
                                        <div class="w-full h-full flex items-center justify-center font-bold text-gray-500"><?= substr($row['username'], 0, 1) ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="flex-1 min-w-0"> <div class="flex justify-between items-baseline mb-1">
                                    <h3 class="font-bold text-slate-800 truncate text-base"><?= $row['username'] ?></h3>
                                    
                                    <span class="text-[11px] text-gray-400 flex-shrink-0 ml-2">
                                        <?= date('H:i', strtotime($row['last_time'])) ?>
                                        <?php if(date('Y-m-d') != date('Y-m-d', strtotime($row['last_time']))) echo date(' d/m', strtotime($row['last_time'])); ?>
                                    </span>
                                </div>

                                <div class="flex justify-between items-center">
                                    <p class="text-sm text-gray-500 truncate pr-4 <?= $row['unread'] > 0 ? 'font-semibold text-gray-800' : '' ?>">
                                        <?= $row['last_message'] ?>
                                    </p>

                                    <?php if ($row['unread'] > 0): ?>
                                        <div class="flex-shrink-0 bg-red-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full shadow-sm min-w-[20px] text-center">
                                            <?= $row['unread'] > 99 ? '99+' : $row['unread'] ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                        </a>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php else: ?>
            <div class="p-10 text-center text-gray-500">
                <div class="mb-4 text-6xl opacity-20">💬</div>
                <p>Belum ada riwayat chat.</p>
                <a href="<?= BASE_URL ?>index.php" class="text-[#1E3A8A] font-bold hover:underline mt-2 inline-block">Cari Barang & Chat Penjual</a>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php include '../../views/layouts/footer.php'; ?>