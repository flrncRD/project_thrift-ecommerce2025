// function toggleSidebar() {
//   const sidebar = document.getElementById("sidebar");
//   const mainContent = document.getElementById("main-content");
//   const footer = document.getElementById("main-footer");

//   // LOGIKA BARU:
//   // Kita mainkan class 'translate-x-0' (Posisi Muncul).
//   // Default HTML nanti adalah '-translate-x-full' (Tersembunyi).

//   // 1. Toggle Sidebar
//   // Saat diklik, kita tambahkan/hapus class agar dia geser ke posisi 0 (muncul)
//   sidebar.classList.toggle("translate-x-0");

//   // 2. Toggle Main Content & Footer
//   // Saat sidebar muncul, konten geser ke kanan (ml-64)
//   mainContent.classList.toggle("md:ml-64");

//   if (footer) {
//     footer.classList.toggle("md:ml-64");
//   }
// }

// assets/js/script.js

function toggleSidebar() {
    const sidebar = document.getElementById("sidebar");
    const mainContent = document.getElementById("main-content");
    // const footer = document.getElementById("main-footer");
    const menuWrapper = document.getElementById("menu-wrapper");
    const menuItems = document.querySelectorAll(".menu-item");
    const texts = document.querySelectorAll(".sidebar-text"); // Element teks menu
    const logoText = document.getElementById("logo-text"); // Tulisan PindaHand

    // Cek apakah layar Desktop (Width >= 768px / md di Tailwind)
    if (window.innerWidth >= 768) {
        // --- LOGIKA DESKTOP (Mini <-> Full) ---
        
        // Jika sedang Full (w-64), ubah ke Mini (w-20)
        if (sidebar.classList.contains("md:w-64")) {
            // 1. Kecilkan Sidebar
            sidebar.classList.replace("md:w-64", "md:w-20");
            
            // 2. Sesuaikan Padding Konten Utama & Footer
            mainContent.classList.replace("md:pl-64", "md:pl-20");
            // if (footer) footer.classList.replace("md:pl-64", "md:pl-20");
          
            // 2. HAPUS PADDING PEMBUNGKUS (Agar tombol mepet kiri-kanan)
            menuWrapper.classList.replace("px-3", "px-1");
          
            // 2. Ubah Layout Menu Item: Dari Baris (Row) ke Kolom (Column)
            menuItems.forEach(item => {
              item.classList.replace("flex-row", "flex-col"); // Jadi Vertikal
              item.classList.replace("gap-4", "gap-1");       // Jarak ikon & teks dirapatkan
              item.classList.replace("px-3", "px-0");         // Padding samping dikurangi
              item.classList.add("justify-center", "text-center"); // Rata tengah
            });
          
            // 3. Ubah Style Teks: Jangan di-hidden, tapi dikecilkan
            texts.forEach(text => {
                // Hapus class font normal
                text.classList.remove("text-sm", "whitespace-nowrap");
                // Tambah class font kecil (mirip YouTube)
                text.classList.add("text-[10px]", "text-center", "leading-tight");
            });

            // // 3. Sembunyikan Teks Menu & Logo Text
            // texts.forEach(text => text.classList.add("hidden"));
            // if(logoText) logoText.classList.add("hidden");

            // 4. Centerkan Ikon (Opsional, agar rapi saat mini)
            sidebar.classList.add("items-center");
            
        } else {
            // Jika sedang Mini (w-20), kembalikan ke Full (w-64)
            
            // 1. Besarkan Sidebar
            sidebar.classList.replace("md:w-20", "md:w-64");
            
            // 2. Balikkan Padding Konten
            mainContent.classList.replace("md:pl-20", "md:pl-64");
          // if (footer) footer.classList.replace("md:pl-20", "md:pl-64");

          // 2. KEMBALIKAN PADDING PEMBUNGKUS
            menuWrapper.classList.replace("px-1", "px-3");
          
          menuItems.forEach(item => {
                item.classList.replace("flex-col", "flex-row"); // Jadi Horizontal
                item.classList.replace("gap-1", "gap-4");       // Jarak normal
                item.classList.replace("px-0", "px-3");         // Padding normal
                item.classList.remove("justify-center", "text-center");
            });

            // 3. Kembalikan Style Teks Normal
            texts.forEach(text => {
                text.classList.remove("text-[10px]", "text-center", "leading-tight");
                text.classList.add("text-sm", "whitespace-nowrap");
            });

            // 3. Munculkan Teks
            texts.forEach(text => text.classList.remove("hidden"));
            if(logoText) logoText.classList.remove("hidden");
            
            // 4. Hapus centering paksa
            sidebar.classList.remove("items-center");
        }

    } else {
        // --- LOGIKA MOBILE (Hide <-> Show) ---
        // Di HP, sidebar defaultnya tersembunyi (-translate-x-full)
        sidebar.classList.toggle("-translate-x-full");
    }
}


// === FUNGSI LOGOUT GLOBAL ===
function confirmLogout(event) {
  event.preventDefault(); // Stop link agar tidak langsung pindah
  const logoutUrl = event.currentTarget.getAttribute('href'); // Ambil link tujuan

  // Cek apakah SweetAlert sudah terload
  if (typeof Swal !== 'undefined') {
    Swal.fire({
      title: 'Yakin ingin keluar?',
      text: "Anda harus login kembali untuk masuk.",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6',
      confirmButtonText: 'Ya, Keluar!',
      cancelButtonText: 'Batal',
      reverseButtons: true
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = logoutUrl;
      }
    });
  } else {
    // Fallback jika SweetAlert error/belum load
    if (confirm("Yakin ingin keluar?")) {
      window.location.href = logoutUrl;
    }
  }
}

// === SYSTEM NOTIFIKASI CHAT (AJAX POLLING) ===
function updateUnreadCount() {
    // Pastikan user login (Cek apakah badge ada di halaman)
    const badge = document.getElementById('unread-badge');
    
    // Jika elemen badge tidak ditemukan (berarti belum login / bukan user), stop script
    if (!badge) return; 

    // Panggil Server
    // Karena script.js ada di root, kita perlu cara dinamis ambil BASE_URL
    // Trik: Kita ambil dari atribut href logo atau link logout
    // Tapi karena Anda sudah define BASE_URL di PHP header, kita asumsikan path relative aman
    
    // Sesuaikan path ini jika folder project Anda berbeda
    const apiUrl = window.location.origin + window.location.pathname.split('/').slice(0, 2).join('/') + '/actions/chat_server.php';
    
    // Atau cara lebih aman: Gunakan variabel global jika ada, kalau tidak pakai relative path dari root view
    // Kita coba fetch dengan FormData
    const formData = new FormData();
    formData.append('action', 'count_unread');

    fetch(apiUrl, {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(count => {
        const total = parseInt(count);

        if (total > 0) {
            badge.innerText = total > 99 ? '99+' : total; // Jika > 99 tampilkan 99+
            badge.classList.remove('hidden'); // Munculkan badge
            
            // Efek 'Denyut' sedikit jika ada notif
            badge.classList.add('scale-110');
            setTimeout(() => badge.classList.remove('scale-110'), 200);
            
        } else {
            badge.classList.add('hidden'); // Sembunyikan jika 0
        }
    })
    .catch(err => console.log('Polling Error: ', err)); // Silent fail biar gak ganggu console
}

// Jalankan fungsi saat halaman dimuat
document.addEventListener('DOMContentLoaded', function() {
    updateUnreadCount(); // Cek sekali saat load
    setInterval(updateUnreadCount, 3000); // Cek ulang setiap 3 detik
});

// === SYSTEM TANDAI PESAN DIBACA (Global Function) ===
function markChatRead() {
    // 1. Cek apakah kita sedang berada di halaman Chat Room?
    // Caranya dengan mencari input hidden 'partner_id'
    const partnerInput = document.getElementById('partner_id');

    // Jika tidak ada element ini, berarti bukan di chat room. Stop fungsi.
    if (!partnerInput) return;

    const partnerId = partnerInput.value;

    // 2. Tentukan URL API (Dynamic Path)
    // Mengambil path root project secara otomatis
    const apiUrl = window.location.origin + window.location.pathname.split('/').slice(0, 2).join('/') + '/actions/chat_server.php';

    // 3. Kirim Request ke Server
    const formData = new FormData();
    formData.append('action', 'mark_read');
    formData.append('partner_id', partnerId);

    // Kita gunakan navigator.sendBeacon jika tersedia (lebih handal saat page unload)
    // Atau fetch biasa
    fetch(apiUrl, {
        method: 'POST',
        body: formData
    }).then(() => {
        // Opsional: Setelah ditandai baca, kita bisa update badge notifikasi di sidebar sekalian
        // Supaya badge langsung hilang tanpa nunggu 3 detik polling berikutnya
        if (typeof updateUnreadCount === 'function') {
            updateUnreadCount();
        }
    }).catch(err => console.log('Mark Read Error:', err));
}