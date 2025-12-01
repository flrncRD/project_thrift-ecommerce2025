<?php

class Transaksi
{

    public $buyer_id;
    public $product_id;
    public $total_harga;
    public $qty;
    public $nama_buyer;
    public $alamat_buyer;
    public $kota_buyer;
    public $phone_buyer;
    public $jenis_pembayaran;
    public $jenis_pengiriman;
    public $status;
    public $createdAt;

    public function __construct(
        $buyer_id,
        $product_id,
        $total_harga,
        $qty,
        $nama_buyer,
        $alamat_buyer,
        $kota_buyer,
        $phone_buyer,
        $jenis_pembayaran,
        $jenis_pengiriman,
        $status = 'terbayar'
    ) {
        $this->buyer_id = $buyer_id;
        $this->product_id = $product_id;
        $this->total_harga = $total_harga;
        $this->qty = $qty;
        $this->nama_buyer = $nama_buyer;
        $this->alamat_buyer = $alamat_buyer;
        $this->kota_buyer = $kota_buyer;
        $this->phone_buyer = $phone_buyer;
        $this->jenis_pembayaran = $jenis_pembayaran;
        $this->jenis_pengiriman = $jenis_pengiriman;
        $this->status = $status;
        $this->createdAt = date("Y-m-d H:i:s");

        // Validasi
        $allowed_payment = ['transfer', 'cod', 'ewallet'];
        if (!in_array($this->jenis_pembayaran, $allowed_payment)) {
            throw new Exception("Jenis pembayaran tidak valid");
        }
    }

    public function insert($conn)
    {
        $sql = "INSERT INTO transaksi 
            (buyer_id, product_id, total_harga, qty, nama_buyer, alamat_buyer, kota_buyer,
            phone_buyer, jenis_pembayaran, jenis_pengiriman, status, createdAt)
            VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";

        $stmt = $conn->prepare($sql);

        $stmt->bind_param(
            "iiisssssssss",
            $this->buyer_id,
            $this->product_id,
            $this->total_harga,
            $this->qty,
            $this->nama_buyer,
            $this->alamat_buyer,
            $this->kota_buyer,
            $this->phone_buyer,
            $this->jenis_pembayaran,
            $this->jenis_pengiriman,
            $this->status,
            $this->createdAt
        );

        return $stmt->execute();
    }
}
?>