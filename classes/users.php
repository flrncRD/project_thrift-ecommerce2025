<?php
class Users
{
    public $username;
    public $email;
    public $password;

    // LOGIN FUNCTION (OOP)
    public function login($conn, $username, $password)
    {
        // 1. Siapkan Query (Cegah SQL Injection)
        $stmt = $conn->prepare("SELECT * FROM user WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        // 2. Cek apakah user ada
        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();

            // 3. Cek Password Hash
            if (password_verify($password, $row['password'])) {
                return $row; // Login Sukses, kembalikan data user
            }
        }
        return false; // Gagal
    }

    // REGISTER FUNCTION (Yang kamu kirim sebelumnya, dirapikan dikit)
    public function register($conn, $data, $files)
    {
        $username = $data['txtusername'];
        $email = $data['txtemail'];
        $password = password_hash($data['txtpass'], PASSWORD_DEFAULT); // Hash disini
        $alamat = $data['txtalamat'];
        $kota = $data['txtkota'];
        $phone = $data['txtphone'];

        // Upload Foto
        $photoName = time() . '_' . $files['txtprofile']['name']; // Kasih time biar unik
        move_uploaded_file($files['txtprofile']['tmp_name'], "../uploads/profile/" . $photoName);

        $stmt = $conn->prepare("INSERT INTO user (username, email, password, photo, alamat, kota, phone, status, role, createdAt) VALUES (?, ?, ?, ?, ?, ?, ?, 'active', 'user', NOW())");

        $stmt->bind_param("sssssss", $username, $email, $password, $photoName, $alamat, $kota, $phone);
        return $stmt->execute();
    }
}
?>