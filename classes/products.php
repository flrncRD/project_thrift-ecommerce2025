<?php

class Products {
    public $user_id;
    public $kategori_id;
    public $nama_product;
    public $harga;
    public $stok;
    public $description;
    public $photo;
    public $status;
    public $createdAt;

    public function __construct($user_id, $kategori_id,$nama_product, $harga, $stok, $description, $photo, $status = 'active') {
        $this->user_id = $user_id;
        $this->kategori_id = $kategori_id;
        $this->nama_product = $nama_product;
        $this->harga = $harga;
        $this->stok = $stok;
        $this->description = $description;
        $this->photo = $photo;
        $this->status = $status;
        $this->createdAt = date("Y-m-d H:i:s");

    }
    //INSERT PRODUCT
    public function insert($conn) {
        //ambil nama file
        $photoProduct = $this->photo['name'];
        $tmp   = $this->photo['tmp_name'];

        //folder tujuan
        $folder = "../uploads/products/" . $photoProduct;

        //upload file
        move_uploaded_file($tmp, $folder);

        $sql = "INSERT INTO product (user_id, kategori_id, nama_product, harga, stok, description, photo, status, createdAt)
            VALUES (?,?,?,?,?,?,?,?,NOW())";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iisdisis", $this->user_id, $this->kategori_id, $this->nama_product, $this->harga, $this->stok, $this->description, $photoProduct, $this->status);
        return $stmt->execute();
    }

    //SEARCH PRODUCT
    public function search ($conn, $searchKeyword) {
        $searchKeyword = "%$searchKeyword%";
        $sql = "SELECT * FROM product WHERE nama_product LIKE ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $searchKeyword);
        $stmt->execute();
        return $stmt->get_result();

    }

    //UPDATE PRODUCT
    public function update ($conn, $id, $kategori_id, $nama_product, $harga, $stok, $description, $photo = null, $status) {
        if ($photo && $photo['name'] != '') {
            //upload foto baru
            $newPhoto = $photo['name'];
            $tmp   = $photo['tmp_name'];

            //folder tujuan
            $folder = "../uploads/products/" . $newPhoto;

            //upload file
            move_uploaded_file($tmp, $folder);

            $sql = "UPDATE product SET kategori_id='?', nama_product='?', harga ='?', stok='?', description='?', photo='?', status='?' WHERE id='?'";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("isdisisi", $kategori_id, $nama_product, $harga, $stok, $description, $newPhoto, $status, $id);
        } else {
            $sql = "UPDATE product SET kategori_id='$kategori_id', nama_product='$nama_product', harga ='$harga', stok='$stok', description='$description', status='$status' WHERE id='$id'";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("isdisi", $kategori_id, $nama_product, $harga, $stok, $description, $status, $id);
        }
        return $stmt->execute();
    }

    //DELETE PRODUCT
    public function delete ($conn, $id) {
        $sql = "DELETE FROM product WHERE id='?'";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);

        return $stmt->execute();
    }

    //GET ALL PRODUCTS
    public function getAll ($conn) {
        $sql = "SELECT * FROM product";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->get_result();
    }

    //GET PRODUCT BY ID = DETAIL PRODUCT
    public function detailProduct ($conn, $id) {
        $sql = "SELECT * FROM product WHERE id='?'";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result();
    }

}

?>