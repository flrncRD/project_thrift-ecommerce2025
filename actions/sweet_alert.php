<?php
// Fungsi reusable untuk menampilkan SweetAlert di file Action
function showSweetAlert($icon, $title, $text, $redirectUrl) {
    echo '<!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Loading...</title>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
        <style> body { font-family: "Inter", sans-serif; background-color: #f3f4f6; } </style>
    </head>
    <body>
        <script>
            Swal.fire({
                icon: "' . $icon . '",     // success, error, warning, info
                title: "' . $title . '",
                text: "' . $text . '",
                confirmButtonColor: "#1E3A8A", // Warna tombol OK (Biru Navy)
                confirmButtonText: "OK"
            }).then((result) => {
                // Redirect setelah klik OK atau tutup
                window.location.href = "' . $redirectUrl . '";
            });
        </script>
    </body>
    </html>';
    exit(); // Matikan script php agar tidak lanjut eksekusi
}
?>