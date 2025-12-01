<?php

class Reviews
{
    public $transaksi_id;
    public $rating;
    public $review;
    public $createdAt;

    public function __construct($transaksi_id, $rating, $review)
    {
        $this->transaksi_id = $transaksi_id;
        $this->rating = $rating;
        $this->review = $review;
        $this->createdAt = date("Y-m-d H:i:s");
    }

    public function insert($conn)
    {
        $sql = "INSERT INTO review (transaksi_id, rating, review, createdAt)
                VALUES (?, ?, ?, NOW())";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iis", $this->transaksi_id, $this->rating, $this->review);
        return $stmt->execute();
    }

    // Ambil Review Seller
    public static function getBySellerId($conn, $seller_id)
    {
        $sql = "
            SELECT r.*,
                   t.id AS transaksi_id,
                   p.nama_product,
                   p.photo AS product_photo,
                   u.username AS buyer_name,
                   u.photo AS buyer_photo
            FROM review r
            JOIN transaksi t ON r.transaksi_id = t.id
            JOIN product p ON t.product_id = p.id
            JOIN user u ON t.buyer_id = u.id
            WHERE p.user_id = ?
            ORDER BY r.createdAt DESC
        ";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $seller_id);
        $stmt->execute();
        return $stmt->get_result();
    }

    // Hitung Rata-Rata Rating
    public static function getAverageRating($conn, $seller_id)
    {
        $sql = "
            SELECT AVG(r.rating) AS avg_rating
            FROM review r
            JOIN transaksi t ON r.transaksi_id = t.id
            JOIN product p ON t.product_id = p.id
            WHERE p.user_id = ?
        ";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $seller_id);
        $stmt->execute();

        $result = $stmt->get_result()->fetch_assoc();
        return $result['avg_rating'] ? round($result['avg_rating'], 1) : 0;
    }
}
?>