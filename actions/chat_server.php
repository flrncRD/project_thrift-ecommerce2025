<?php
session_start();
include '../config/conn.php';
include '../classes/chats.php';

if (!isset($_SESSION['user_id'])) {
    echo "Unauthorized";
    exit();
}

$chatObj = new Chats();
$my_id = $_SESSION['user_id'];
$action = isset($_POST['action']) ? $_POST['action'] : '';

// === FITUR 1: KIRIM PESAN ===
if ($action == 'send_message') {
    $penerima_id = $_POST['penerima_id'];
    $message = $_POST['message'];

    if (!empty($message)) {
        if ($chatObj->insert($conn, $my_id, $penerima_id, $message)) {
            echo "success";
        } else {
            echo "error";
        }
    }
}

// === FITUR 2: AMBIL PESAN (LOAD CHAT) ===
if ($action == 'fetch_chat') {
    $partner_id = $_POST['partner_id'];
    $chats = $chatObj->getConversation($conn, $my_id, $partner_id);

    if (mysqli_num_rows($chats) > 0) {
        while ($row = mysqli_fetch_assoc($chats)) {
            
            $is_me = ($row['pengirim_id'] == $my_id);
            
            // Tampilan Chat Bubble (Kanan = Saya, Kiri = Lawan)
            if ($is_me) {
                // BUBBLE KANAN (SAYA)
                echo '
                <div class="flex justify-end mb-4">
                    <div class="bg-[#1E3A8A] text-white py-2 px-4 rounded-xl rounded-tr-none max-w-[70%] shadow-md">
                        <p class="text-sm">'.htmlspecialchars($row['message']).'</p>
                        <span class="text-[10px] text-blue-200 block text-right mt-1">'.date('H:i', strtotime($row['createdAt'])).'</span>
                    </div>
                </div>';
            } else {
                // BUBBLE KIRI (LAWAN)
                echo '
                <div class="flex justify-start mb-4 gap-2">
                    <img src="'.BASE_URL.'uploads/profile/'.($row['photo'] ? $row['photo'] : 'default.png').'" 
                         class="w-8 h-8 rounded-full object-cover bg-gray-200" 
                         onerror="this.src=\'https://placehold.co/100\'">
                    <div class="bg-white border border-gray-200 text-gray-800 py-2 px-4 rounded-xl rounded-tl-none max-w-[70%] shadow-sm">
                        <p class="text-sm">'.htmlspecialchars($row['message']).'</p>
                        <span class="text-[10px] text-gray-400 block mt-1">'.date('H:i', strtotime($row['createdAt'])).'</span>
                    </div>
                </div>';
            }
        }
    } else {
        echo '<div class="text-center text-gray-400 text-xs mt-10">Belum ada pesan. Sapa duluan yuk! 👋</div>';
    }
}

// === FITUR 3: HITUNG TOTAL NOTIFIKASI (Global untuk Sidebar) ===
if ($action == 'count_unread') {
    // Hitung pesan yang masuk ke SAYA (penerima_id = my_id) dan statusnya 0 (belum baca)
    $sql = "SELECT COUNT(*) as total FROM chat WHERE penerima_id = '$my_id' AND is_read = 0";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    echo $row['total']; // Kembalikan angka (misal: 5)
}

// === FITUR 4: TANDAI PESAN SUDAH DIBACA (Saat buka chat room) ===
if ($action == 'mark_read') {
    $partner_id = $_POST['partner_id'];
    // Update semua pesan dari partner ini ke saya menjadi 1 (Sudah dibaca)
    $sql = "UPDATE chat SET is_read = 1 WHERE pengirim_id = '$partner_id' AND penerima_id = '$my_id'";
    mysqli_query($conn, $sql);
}
?>