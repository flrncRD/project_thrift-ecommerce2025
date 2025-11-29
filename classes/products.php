<?php
class Products
{
    // FUNGSI TAMBAH PRODUK
    public function insert($conn, $data, $files, $user_id)
    {
        $nama = $data['nama_product'];
        $kategori = $data['kategori_id'];
        $harga = $data['harga'];
        $stok = $data['stok'];
        $desc = $data['description'];

        // Upload Foto
        $photoName = time() . '_' . $files['photo']['name'];
        $tmp = $files['photo']['tmp_name'];
        $folder = "../uploads/products/" . $photoName;

        if (move_uploaded_file($tmp, $folder)) {
            $sql = "INSERT INTO product (user_id, kategori_id, nama_product, harga, stok, description, photo, status, createdAt) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, 'active', NOW())";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iisdiss", $user_id, $kategori, $nama, $harga, $stok, $desc, $photoName);
            return $stmt->execute();
        }
        return false;
    }

    // FUNGSI AMBIL PRODUK PER USER (Untuk halaman Toko Saya)
    public function getByUser($conn, $user_id)
    {
        $sql = "SELECT p.*, k.nama_kategori 
                FROM product p 
                JOIN kategori k ON p.kategori_id = k.id 
                WHERE p.user_id = ? ORDER BY p.createdAt DESC";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        return $stmt->get_result();
    }

    // FUNGSI AMBIL PRODUK UNTUK DETAIL PRODUK
    public function getById($conn, $id)
    {
        $sql = "SELECT p.*, k.nama_kategori 
                FROM product p 
                JOIN kategori k ON p.kategori_id = k.id 
                WHERE p.id = ? ORDER BY p.createdAt DESC";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result();
    }

    // FUNGSI AMBIL SEMUA PRODUK (Untuk Halaman Depan/Home)
    public function getAll($conn)
    {
        // Logika: Barang Habis (stok=0) ditaruh paling belakang (stok = 0 ASC)
        // Barang ready ditaruh paling atas berdasarkan waktu terbaru
        $sql = "SELECT p.*, u.username, u.kota 
                FROM product p 
                JOIN user u ON p.user_id = u.id 
                WHERE p.status = 'active'
                ORDER BY (p.stok = 0) ASC, p.createdAt DESC";
        $result = mysqli_query($conn, $sql);
        return $result;
    }
}
?>