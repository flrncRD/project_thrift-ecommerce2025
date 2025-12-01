<?php
class Chats
{
    public $pengirim_id;
    public $penerima_id;
    public $message;
    public $createdAt;

    // Kirim Pesan
    public function insert($conn, $pengirim_id, $penerima_id, $message)
    {
        $msg = mysqli_real_escape_string($conn, $message);
        $sql = "INSERT INTO chat (pengirim_id, penerima_id, message, createdAt) 
                VALUES ('$pengirim_id', '$penerima_id', '$msg', NOW())";
        return mysqli_query($conn, $sql);
    }

    // Ambil History Chat (2 Arah)
    public function getConversation($conn, $my_id, $partner_id)
    {
        $sql = "SELECT c.*, u.username, u.photo 
                FROM chat c 
                JOIN user u ON c.pengirim_id = u.id
                WHERE (c.pengirim_id = '$my_id' AND c.penerima_id = '$partner_id') 
                   OR (c.pengirim_id = '$partner_id' AND c.penerima_id = '$my_id')
                ORDER BY c.createdAt ASC";
        return mysqli_query($conn, $sql);
    }

    // Ambil Daftar Chat (Last Message & Unread)
    public function getChatList($conn, $my_id)
    {
        $sql = "SELECT 
                    u.id, 
                    u.username, 
                    u.photo,
                    (SELECT message FROM chat c2 
                     WHERE (c2.pengirim_id = u.id AND c2.penerima_id = '$my_id') 
                        OR (c2.pengirim_id = '$my_id' AND c2.penerima_id = u.id) 
                     ORDER BY c2.createdAt DESC LIMIT 1) as last_message,
                     
                    (SELECT createdAt FROM chat c3 
                     WHERE (c3.pengirim_id = u.id AND c3.penerima_id = '$my_id') 
                        OR (c3.pengirim_id = '$my_id' AND c3.penerima_id = u.id) 
                     ORDER BY c3.createdAt DESC LIMIT 1) as last_time,
                     
                    (SELECT COUNT(*) FROM chat c4 
                     WHERE c4.pengirim_id = u.id AND c4.penerima_id = '$my_id' AND c4.is_read = 0) as unread
                FROM user u
                WHERE u.id IN (
                    SELECT DISTINCT IF(pengirim_id = '$my_id', penerima_id, pengirim_id)
                    FROM chat
                    WHERE pengirim_id = '$my_id' OR penerima_id = '$my_id'
                )
                ORDER BY last_time DESC";

        return mysqli_query($conn, $sql);
    }
}
?>