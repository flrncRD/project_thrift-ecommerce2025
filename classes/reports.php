<?php

class Reports
{
    public $user_id;
    public $jenis_report;
    public $reference_id;
    public $alasan;
    public $status;
    public $createdAt;

    private $opsiJenisReport = ['product', 'user', 'transaction'];

    public function __construct($user_id, $jenis_report, $reference_id, $alasan, $status = 'reported')
    {
        // Validasi
        if (!in_array($jenis_report, $this->opsiJenisReport)) {
            throw new Exception("Jenis report tidak valid.");
        }

        if (empty($alasan)) {
            throw new Exception("Alasan report tidak boleh kosong.");
        }

        $this->user_id = $user_id;
        $this->jenis_report = $jenis_report;
        $this->reference_id = $reference_id;
        $this->alasan = $alasan;
        $this->status = 'reported';
        $this->createdAt = date("Y-m-d H:i:s");
    }

    public function insert($conn)
    {
        $stmt = $conn->prepare("
            INSERT INTO report (user_id, jenis_report, reference_id, alasan, status, createdAt)
            VALUES (?, ?, ?, ?, ?, ?)
        ");

        $stmt->bind_param(
            "isisss",
            $this->user_id,
            $this->jenis_report,
            $this->reference_id,
            $this->alasan,
            $this->status,
            $this->createdAt
        );

        if ($stmt->execute()) {
            return true;
        } else {
            return "Error: " . $stmt->error;
        }
    }
}
?>