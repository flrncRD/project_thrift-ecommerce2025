<?php
    
    class Kategori {
    public $id;
    public $nama_kategori;

    public function __construct($id, $nama_kategori)
    {
        $this->id = $id;
        $this->nama_kategori = $nama_kategori;
    }

    public function insert($conn) {
        $sql = "INSERT INTO kategori (nama_kategori) VALUES ('$this->nama_kategori')";
        return mysqli_query($conn, $sql);
    }
}

?>