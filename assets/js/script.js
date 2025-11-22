function toggleSidebar() {
  const sidebar = document.getElementById("sidebar");
  const mainContent = document.getElementById("main-content");
  const footer = document.getElementById("main-footer");

  // LOGIKA BARU:
  // Kita mainkan class 'translate-x-0' (Posisi Muncul).
  // Default HTML nanti adalah '-translate-x-full' (Tersembunyi).

  // 1. Toggle Sidebar
  // Saat diklik, kita tambahkan/hapus class agar dia geser ke posisi 0 (muncul)
  sidebar.classList.toggle("translate-x-0");

  // 2. Toggle Main Content & Footer
  // Saat sidebar muncul, konten geser ke kanan (ml-64)
  mainContent.classList.toggle("md:ml-64");

  if (footer) {
    footer.classList.toggle("md:ml-64");
  }
}
