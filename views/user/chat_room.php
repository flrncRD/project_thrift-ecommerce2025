<?php
include '../../config/conn.php';
include '../../views/layouts/header.php';

// Validasi Login & Partner
if (!isset($_SESSION['user_id']) || !isset($_GET['partner_id'])) {
    echo "<script>window.location.href='" . BASE_URL . "index.php';</script>";
    exit();
}

$my_id = $_SESSION['user_id'];
$partner_id = $_GET['partner_id'];

// Ambil data Partner
$partnerQuery = mysqli_query($conn, "SELECT username, photo, role FROM user WHERE id = '$partner_id'");
$partner = mysqli_fetch_assoc($partnerQuery);

if (!$partner)
    die("User tidak ditemukan.");
?>

<div class="flex flex-col w-full h-[calc(100vh-5rem)] bg-gray-100">

    <div
        class="bg-white px-6 py-3 border-b border-gray-200 flex items-center justify-between shadow-sm sticky top-0 z-10">
        <div class="flex items-center gap-4">
            <a href="chat_list.php"
                class="text-gray-500 hover:text-[#1E3A8A] p-1 rounded-full hover:bg-gray-100 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>

            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-gray-200 overflow-hidden border border-gray-200">
                    <img src="<?= BASE_URL ?>uploads/profile/<?= $partner['photo'] ?? 'default.png' ?>"
                        class="w-full h-full object-cover" onerror="this.src='https://placehold.co/100'">
                </div>
                <div>
                    <h2 class="font-bold text-slate-800 text-base leading-tight"><?= $partner['username'] ?></h2>
                    <div class="flex items-center gap-1.5">
                        <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                        <p class="text-xs text-green-600 font-semibold">Online</p>
                    </div>
                </div>
            </div>
        </div>

        <button class="text-gray-400 hover:text-gray-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z">
                </path>
            </svg>
        </button>
    </div>

    <div id="chat-container" class="flex-1 overflow-y-auto p-6 space-y-4 scroll-smooth">
        <div class="text-center mt-10">
            <span class="loading-spinner text-gray-400 text-sm">Memuat percakapan...</span>
        </div>
    </div>

    <div class="bg-white p-4 border-t border-gray-200">
        <form id="chat-form" class="max-w-4xl mx-auto flex gap-3 items-center">

            <input type="hidden" id="partner_id" value="<?= $partner_id ?>">

            <button type="button" class="text-gray-400 hover:text-[#1E3A8A] transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13">
                    </path>
                </svg>
            </button>

            <input type="text" id="message-input" autocomplete="off" placeholder="Tulis pesan..."
                class="flex-1 bg-gray-100 text-gray-800 border-0 rounded-full px-5 py-3 focus:ring-2 focus:ring-[#1E3A8A] focus:bg-white transition outline-none shadow-inner">

            <button type="submit"
                class="bg-[#1E3A8A] text-white p-3 rounded-full hover:bg-blue-900 transition shadow-lg hover:shadow-xl transform active:scale-95">
                <svg class="w-6 h-6 transform rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                </svg>
            </button>
        </form>
    </div>

</div>

<script>
    const chatContainer = document.getElementById('chat-container');
    const chatForm = document.getElementById('chat-form');
    const messageInput = document.getElementById('message-input');
    const partnerId = document.getElementById('partner_id').value;
    const baseUrl = "<?= BASE_URL ?>";

    // Auto scroll ke bawah
    function scrollToBottom() {
        chatContainer.scrollTop = chatContainer.scrollHeight;
    }

    // Ambil pesan (AJAX)
    function fetchMessages() {
        const formData = new FormData();
        formData.append('action', 'fetch_chat');
        formData.append('partner_id', partnerId);

        fetch(baseUrl + 'actions/chat_server.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.text())
            .then(data => {
                // Update hanya jika ada pesan baru
                if (chatContainer.innerHTML !== data) {
                    chatContainer.innerHTML = data;
                    markChatRead(); // Tandai sudah dibaca
                }
            })
            .catch(error => console.error('Error:', error));
    }

    // Kirim pesan
    chatForm.addEventListener('submit', function (e) {
        e.preventDefault();
        const message = messageInput.value.trim();

        if (message === "") return;

        const formData = new FormData();
        formData.append('action', 'send_message');
        formData.append('penerima_id', partnerId);
        formData.append('message', message);

        fetch(baseUrl + 'actions/chat_server.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.text())
            .then(data => {
                if (data === "success") {
                    messageInput.value = "";
                    fetchMessages(); // Refresh chat
                    setTimeout(scrollToBottom, 200);
                }
            });
    });

    // Jalankan pertama kali & Interval
    fetchMessages();
    setInterval(fetchMessages, 2000); // Cek pesan tiap 2 detik
    markChatRead();
</script>