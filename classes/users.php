<?php
class Users
{
    public $username;
    public $email;
    public $password;

    // LOGIN FUNCTION
    public function login($conn, $username, $password)
    {
        $stmt = $conn->prepare("SELECT * FROM user WHERE username = ? OR email = ?");
        $stmt->bind_param("ss", $username, $username); // Bisa login pake email/username
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                return $row;
            }
        }
        return false;
    }

    // REGISTER FUNCTION (YANG DIPERBAIKI)
    public function register($conn, $data, $files)
    {
        $username = htmlspecialchars($data['txtusername']);
        $email = htmlspecialchars($data['txtemail']);
        $password = password_hash($data['txtpass'], PASSWORD_DEFAULT);
        $alamat = htmlspecialchars($data['txtalamat']);
        $kota = htmlspecialchars($data['txtkota']);
        $phone = htmlspecialchars($data['txtphone']);

        // Upload Foto
        $photoName = time() . '_' . $files['txtprofile']['name'];
        $tmp = $files['txtprofile']['tmp_name'];

        // Pindahkan file foto
        if (move_uploaded_file($tmp, "../uploads/profile/" . $photoName)) {

            // Query Insert
            $sql = "INSERT INTO user (username, email, password, photo, alamat, kota, phone, status, role, createdAt) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, 'active', 'user', NOW())";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssssss", $username, $email, $password, $photoName, $alamat, $kota, $phone);

            return $stmt->execute();
        }

        return false; // Gagal upload
    }

    // GET USER BY ID
    public function getById($conn, $id)
    {
        $stmt = $conn->prepare("SELECT * FROM user WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result();
    }
}
?>