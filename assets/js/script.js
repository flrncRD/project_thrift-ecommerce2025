function toggleSidebar() {
  const sidebar = document.getElementById("sidebar");
  const mainContent = document.getElementById("main-content");
  const menuWrapper = document.getElementById("menu-wrapper");
  const menuItems = document.querySelectorAll(".menu-item");
  const texts = document.querySelectorAll(".sidebar-text");
  const logoText = document.getElementById("logo-text");

  // Mode Desktop (Mini <-> Full)
  if (window.innerWidth >= 768) {
    if (sidebar.classList.contains("md:w-64")) {
      // Kecilkan Sidebar
      sidebar.classList.replace("md:w-64", "md:w-20");
      mainContent.classList.replace("md:pl-64", "md:pl-20");
      menuWrapper.classList.replace("px-3", "px-1");

      menuItems.forEach((item) => {
        item.classList.replace("flex-row", "flex-col");
        item.classList.replace("gap-4", "gap-1");
        item.classList.replace("px-3", "px-0");
        item.classList.add("justify-center", "text-center");
      });

      texts.forEach((text) => {
        text.classList.remove("text-sm", "whitespace-nowrap");
        text.classList.add("text-[10px]", "text-center", "leading-tight");
      });

      sidebar.classList.add("items-center");
    } else {
      // Besarkan Sidebar
      sidebar.classList.replace("md:w-20", "md:w-64");
      mainContent.classList.replace("md:pl-20", "md:pl-64");
      menuWrapper.classList.replace("px-1", "px-3");

      menuItems.forEach((item) => {
        item.classList.replace("flex-col", "flex-row");
        item.classList.replace("gap-1", "gap-4");
        item.classList.replace("px-0", "px-3");
        item.classList.remove("justify-center", "text-center");
      });

      texts.forEach((text) => {
        text.classList.remove("text-[10px]", "text-center", "leading-tight");
        text.classList.add("text-sm", "whitespace-nowrap");
      });

      if (logoText) logoText.classList.remove("hidden");
      sidebar.classList.remove("items-center");
    }
  } else {
    // Mode Mobile (Hide <-> Show)
    sidebar.classList.toggle("-translate-x-full");
  }
}

// Konfirmasi Logout
function confirmLogout(event) {
  event.preventDefault();
  const logoutUrl = event.currentTarget.getAttribute("href");

  if (typeof Swal !== "undefined") {
    Swal.fire({
      title: "Yakin ingin keluar?",
      text: "Anda harus login kembali untuk masuk.",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#d33",
      cancelButtonColor: "#3085d6",
      confirmButtonText: "Ya, Keluar!",
      cancelButtonText: "Batal",
      reverseButtons: true,
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = logoutUrl;
      }
    });
  } else {
    if (confirm("Yakin ingin keluar?")) {
      window.location.href = logoutUrl;
    }
  }
}

// Polling Notifikasi Chat
function updateUnreadCount() {
  const badge = document.getElementById("unread-badge");
  if (!badge) return;

  // Sesuaikan path jika berbeda
  const apiUrl =
    window.location.origin +
    window.location.pathname.split("/").slice(0, 2).join("/") +
    "/actions/chat_server.php";

  const formData = new FormData();
  formData.append("action", "count_unread");

  fetch(apiUrl, { method: "POST", body: formData })
    .then((response) => response.text())
    .then((count) => {
      const total = parseInt(count);
      if (total > 0) {
        badge.innerText = total > 99 ? "99+" : total;
        badge.classList.remove("hidden");
        badge.classList.add("scale-110");
        setTimeout(() => badge.classList.remove("scale-110"), 200);
      } else {
        badge.classList.add("hidden");
      }
    })
    .catch((err) => console.log("Polling Error: ", err));
}

// Tandai Chat Dibaca
function markChatRead() {
  const partnerInput = document.getElementById("partner_id");
  if (!partnerInput) return;

  const partnerId = partnerInput.value;
  const apiUrl =
    window.location.origin +
    window.location.pathname.split("/").slice(0, 2).join("/") +
    "/actions/chat_server.php";

  const formData = new FormData();
  formData.append("action", "mark_read");
  formData.append("partner_id", partnerId);

  fetch(apiUrl, { method: "POST", body: formData })
    .then(() => {
      if (typeof updateUnreadCount === "function") {
        updateUnreadCount();
      }
    })
    .catch((err) => console.log("Mark Read Error:", err));
}

// Jalankan Polling
document.addEventListener("DOMContentLoaded", function () {
  updateUnreadCount();
  setInterval(updateUnreadCount, 3000);
});
