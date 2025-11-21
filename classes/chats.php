<?php

class Chats {
    public $pengirim_id;
    public $penerima_id;
    public $message;
    public $createdAt;

    public function __construct($pengirim_id, $penerima_id, $message)
    {
        $this->pengirim_id = $pengirim_id;
        $this->penerima_id = $penerima_id;
        $this->message = $message;
        $this->createdAt = date("Y-m-d H:i:s");
    }

    public function insert($conn)
    {
        // Insert Chat baru ke database
        $sql = "INSERT INTO chat (pengirim_id, penerima_id, message, createdAt)
            VALUES ('$this->pengirim_id', '$this->penerima_id', '$this->message', NOW())";

        if (mysqli_query($conn, $sql)) {
            return true;
        } else {
            return false;
        }
    }
}
?>