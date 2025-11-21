<?

class Reviews {
    public $transaksi_id;
    public $rating;
    public $review;
    public $createdAt;

    public function __construct($transaksi_id, $rating, $review) {
        $this->transaksi_id = $transaksi_id;
        $this->rating = $rating;
        $this->review = $review;
        $this->createdAt = date("Y-m-d H:i:s");
    }

    public function insert($conn) {
        // Insert Review baru ke database
        $sql = "INSERT INTO review (transaksi_id, rating, review, createdAt)
            VALUES ('$this->transaksi_id', '$this->rating', '$this->review', NOW())";
    }
}

?>