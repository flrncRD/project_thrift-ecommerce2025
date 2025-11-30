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

    // FUNGSI CARI PRODUK
    public static function search($conn, $keyword) 
    {
        $keyword = "%$keyword%";
        $sql = "
            SELECT p.*, u.username, u.photo AS user_photo
            FROM products p
            JOIN user u ON p.user_id = u.id
            WHERE p.status = 'active'
            AND (p.nama_product LIKE ? OR p.deskripsi LIKE ?)
            ORDER BY p.createdAt DESC
        ";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $keyword, $keyword);
        $stmt->execute();
        $result = $stmt->get_result();

        $products = [];
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }

        return $products;
    }

    //FUNGSI LMIT KATEGORI
    public function getCategories($conn, $limit = 6) {
        $sql = "SELECT * FROM kategori LIMIT $limit";
        return mysqli_query($conn, $sql);
    }

    //FUNGSI GET BEST PRODUCTS
    public function getBestProducts($conn, $limit = 8) {
    $sql = "SELECT p.*, u.kota 
            FROM product p 
            JOIN user u ON p.user_id = u.id 
            WHERE p.status = 'active'
            ORDER BY p.harga DESC 
            LIMIT $limit";
    return mysqli_query($conn, $sql);
}
    //FUNGSI GET POPULAR PRODUCTS
    public function getPopularProducts($conn, $limit = 4) {
        $sql = "SELECT p.*, u.kota 
                FROM product p 
                JOIN user u ON p.user_id = u.id 
                WHERE p.status = 'active'
                ORDER BY RAND() 
                LIMIT $limit";
        return mysqli_query($conn, $sql);
    }
    // 1. HITUNG TOTAL DATA (Untuk Pagination Seller)
    public function countByUser($conn, $user_id)
    {
        $stmt = $conn->prepare("SELECT COUNT(*) as total FROM product WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        return $row['total'];
    }

    // 2. AMBIL DATA PER USER DENGAN LIMIT (Pagination Seller)
    public function getByUserPaginated($conn, $user_id, $start, $limit)
    {
        $sql = "SELECT p.*, k.nama_kategori 
                FROM product p 
                JOIN kategori k ON p.kategori_id = k.id 
                WHERE p.user_id = ? 
                ORDER BY p.createdAt DESC 
                LIMIT ?, ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iii", $user_id, $start, $limit);
        $stmt->execute();
        return $stmt->get_result();
    }

    // 3. HITUNG TOTAL (Support Multi Kategori)
    public function countSearch($conn, $keyword, $kategori_ids = [])
    {
        $key = "%" . $keyword . "%";
        $sql = "SELECT COUNT(*) as total FROM product WHERE status = 'active' AND nama_product LIKE ?";

        // Logic Multi Filter: Menggunakan SQL 'IN'
        if (!empty($kategori_ids)) {
            // Ubah array [1, 2] menjadi string "1,2"
            // Pastikan isinya integer biar aman (Sanitization)
            $ids = implode(',', array_map('intval', (array) $kategori_ids));
            if (!empty($ids)) {
                $sql .= " AND kategori_id IN ($ids)";
            }
        }

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $key);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc()['total'];
    }

    // 4. CARI BARANG (Support Multi Kategori)
    public function searchProducts($conn, $keyword, $start, $limit, $kategori_ids = [])
    {
        $key = "%" . $keyword . "%";

        $sql = "SELECT p.*, u.username, u.kota, k.nama_kategori 
                FROM product p 
                JOIN user u ON p.user_id = u.id 
                JOIN kategori k ON p.kategori_id = k.id
                WHERE p.status = 'active' AND p.nama_product LIKE ?";

        // Logic Multi Filter
        if (!empty($kategori_ids)) {
            $ids = implode(',', array_map('intval', (array) $kategori_ids));
            if (!empty($ids)) {
                $sql .= " AND p.kategori_id IN ($ids)";
            }
        }

        // Sorting
        $sql .= " ORDER BY (p.stok = 0) ASC, p.createdAt DESC LIMIT ?, ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sii", $key, $start, $limit);
        $stmt->execute();
        return $stmt->get_result();
    }
}
?>