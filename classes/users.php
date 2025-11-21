<?php

class Users
{
    // data field
    public $username;
    public $email;
    public $password;
    public $hashed_password;
    public $photo;
    public $alamat;
    public $kota;
    public $phone;
    public $status;
    public $role;
    public $createdAt;

    public function __construct($username, $email, $password, $photo, $alamat, $kota, $phone, $status = 'active', $role = 'user')
    {
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $this->photo = $photo;
        $this->alamat = $alamat;
        $this->kota = $kota;
        $this->phone = $phone;
        $this->status = $status;
        $this->role = $role;
        $this->createdAt = date("Y-m-d H:i:s");
    }

    public function insert($conn)
    {
        // ambil nama file
        $photoName = $this->photo['name'];
        $tmp   = $this->photo['tmp_name'];

        //folder tujuan
        $folder = "../uploads/profile/" . $photoName;

        //upload file
        move_uploaded_file($tmp, $folder);

        // Insert User baru ke database
        $stmt = $conn->prepare("INSERT INTO user (username, email, password, photo, alamat, kota, phone, status, role, createdAt) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");

        $status = 'active';
        $role = 'user';

        $stmt->bind_param(
            "sssssssss",
            $this->username,
            $this->email,
            $this->hashed_password,
            $photoName,
            $this->alamat,
            $this->kota,
            $this->phone,
            $status,
            $role
        );

        return $stmt->execute();
    }
}
?>
