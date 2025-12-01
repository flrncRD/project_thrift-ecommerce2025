<?php
class Products
{
    public function insert($conn, $data, $files, $user_id)
    {
        $nama = $data['nama_product'];
        $kategori = $data['kategori_id'];
        $harga = $data['harga'];
        $stok = $data['stok'];
        $desc = $data['description'];

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

    public function getById($conn, $id)
    {
        $sql = "SELECT p.*, k.nama_kategori 
                FROM product p 
                JOIN kategori k ON p.kategori_id = k.id 
                WHERE p.id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result();
    }

    // Produk Filter
    public function getAll($conn)
    {
        $sql = "SELECT p.*, u.username, u.kota 
                FROM product p 
                JOIN user u ON p.user_id = u.id 
                WHERE p.status = 'active' 
                AND u.status = 'active' 
                AND p.stok > 0  
                ORDER BY p.createdAt DESC";
        $result = mysqli_query($conn, $sql);
        return $result;
    }

    public function getCategories($conn, $limit = 6)
    {
        $sql = "SELECT * FROM kategori LIMIT $limit";
        return mysqli_query($conn, $sql);
    }

    // Filter Best Products
    public function getBestProducts($conn, $limit = 8)
    {
        $sql = "SELECT p.*, u.kota 
                FROM product p 
                JOIN user u ON p.user_id = u.id 
                WHERE p.status = 'active' 
                AND u.status = 'active'
                AND p.stok > 0
                ORDER BY p.harga DESC 
                LIMIT $limit";
        return mysqli_query($conn, $sql);
    }

    public function getPopularProducts($conn, $limit = 4)
    {
        $sql = "SELECT p.*, u.kota 
                FROM product p 
                JOIN user u ON p.user_id = u.id 
                WHERE p.status = 'active' 
                AND u.status = 'active'
                AND p.stok > 0
                ORDER BY RAND() 
                LIMIT $limit";
        return mysqli_query($conn, $sql);
    }

    public function countByUser($conn, $user_id)
    {
        $stmt = $conn->prepare("SELECT COUNT(*) as total FROM product WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        return $row['total'];
    }

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

    public function countSearch($conn, $keyword, $kategori_ids = [])
    {
        $key = "%" . $keyword . "%";
        
        $sql = "SELECT COUNT(*) as total 
                FROM product p 
                JOIN user u ON p.user_id = u.id 
                WHERE p.status = 'active' 
                AND u.status = 'active' 
                AND p.stok > 0
                AND p.nama_product LIKE ?";

        if (!empty($kategori_ids)) {
            $ids = implode(',', array_map('intval', (array) $kategori_ids));
            if (!empty($ids)) {
                $sql .= " AND p.kategori_id IN ($ids)";
            }
        }

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $key);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc()['total'];
    }

    public function searchProducts($conn, $keyword, $start, $limit, $kategori_ids = [])
    {
        $key = "%" . $keyword . "%";
         
        $sql = "SELECT p.*, u.username, u.kota, k.nama_kategori 
                FROM product p 
                JOIN user u ON p.user_id = u.id 
                JOIN kategori k ON p.kategori_id = k.id
                WHERE p.status = 'active' 
                AND u.status = 'active' 
                AND p.stok > 0
                AND p.nama_product LIKE ?";

        if (!empty($kategori_ids)) {
            $ids = implode(',', array_map('intval', (array) $kategori_ids));
            if (!empty($ids)) {
                $sql .= " AND p.kategori_id IN ($ids)";
            }
        }

        $sql .= " ORDER BY p.createdAt DESC LIMIT ?, ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sii", $key, $start, $limit);
        $stmt->execute();
        return $stmt->get_result();
    }
}
?>