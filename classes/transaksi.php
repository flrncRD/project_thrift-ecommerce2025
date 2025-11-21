<?
class Transaksi {
    public $id;
    public $buyer_id;
    public $product_id;
    public $harga;
    public $qty;
    public $alamat_buyer;
    public $kota_buyer;
    public $phone_buyer;
    public $jenis_pembayaran;
    public $total_harga;
    public $transfer; //file bukti transfer
    public $cod; // 1 = cod, 0 = bukan cod
    public $status; //terbayar, packing, kirim
    public $createdAt;

    public function __construct($buyer_id, $product_id, $harga, $qty, $alamat_buyer, $kota_buyer, $phone_buyer, $jenis_pembayaran, $total_harga, $transfer, $cod, $status = 'terbayar') {
        $this->buyer_id = $buyer_id;
        $this->product_id = $product_id;
        $this->harga = $harga;
        $this->qty = $qty;
        $this->alamat_buyer = $alamat_buyer;
        $this->kota_buyer = $kota_buyer;
        $this->phone_buyer = $phone_buyer;
        $this->jenis_pembayaran = $jenis_pembayaran;
        $this->total_harga = $total_harga;
        $this->transfer = $transfer;
        $this->cod = $cod;
        $this->status = $status;
        $this->createdAt = date("Y-m-d H:i:s");

        // Validasi jenis_pembayaran
        if (!in_array($this->jenis_pembayaran, ['transfer', 'cod'])) {
            throw new Exception("Jenis pembayaran tidak valid. Harus 'transfer' atau 'cod'.");
        }

        //Validasi bukti tf
        if ($this->jenis_pembayaran === 'transfer' && (empty($this->transfer) || $this->transfer['name'] == '')) {
            throw new Exception("Bukti transfer wajib diunggah");
        }

        //Validasi cod
        if ($this->jenis_pembayaran === 'cod') {
            $this->cod = 1;
        } else {
            $this->cod = 0;
    }
}
    public function insert($conn) {
        //ambil nama file
        $buktiTransfer = $this->transfer['name'];
        $tmp   = $this->transfer['tmp_name'];

        //folder tujuan
        $folder = "../uploads/transfer/" . $buktiTransfer;

        //upload file
        move_uploaded_file($tmp, $folder);

        $sql = "INSERT INTO transaksi (buyer_id, product_id, harga, qty, alamat_buyer, kota_buyer, phone_buyer, jenis_pembayaran, total_harga, transfer, cod, status, createdAt)
            VALUES (?,?,?,?,?,?,?,?,?,?,?,?,NOW())";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iiisissisisi", $this->buyer_id, $this->product_id, $this->harga, $this->qty, $this->alamat_buyer, $this->kota_buyer, $this->phone_buyer, $this->jenis_pembayaran, $this->total_harga, $buktiTransfer, $this->cod, $this->status);
        return $stmt->execute();
    }
}
?>