<?php
session_start();
include '../config/conn.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: " . BASE_URL . "views/auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// --- Update Biodata & Foto ---
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_profile'])) {

    $kota = htmlspecialchars($_POST['kota']);
    $alamat = htmlspecialchars($_POST['alamat']);
    $phone = htmlspecialchars($_POST['phone']);

    if (!empty($_FILES['photo']['name'])) {
        $photoName = time() . '_' . $_FILES['photo']['name'];
        $tmp = $_FILES['photo']['tmp_name'];
        $folder = "../uploads/profile/";

        if (move_uploaded_file($tmp, $folder . $photoName)) {
            $sql = "UPDATE user SET kota=?, alamat=?, phone=?, photo=? WHERE id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssi", $kota, $alamat, $phone, $photoName, $user_id);
        } else {
            echo "<script>alert('Gagal upload foto!'); window.location.href='" . BASE_URL . "views/user/profile.php';</script>";
            exit();
        }
    } else {
        $sql = "UPDATE user SET kota=?, alamat=?, phone=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $kota, $alamat, $phone, $user_id);
    }

    if ($stmt->execute()) {
        echo "<script>alert('Profil berhasil diperbarui!'); window.location.href='" . BASE_URL . "views/user/profile.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}

// --- Ganti Password ---
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['change_password'])) {

    $old_pass = $_POST['old_password'];
    $new_pass = $_POST['new_password'];
    $confirm_pass = $_POST['confirm_password'];

    $query = mysqli_query($conn, "SELECT password FROM user WHERE id='$user_id'");
    $data = mysqli_fetch_assoc($query);

    if (password_verify($old_pass, $data['password'])) {

        if ($new_pass === $confirm_pass) {
            $new_hash = password_hash($new_pass, PASSWORD_DEFAULT);
            mysqli_query($conn, "UPDATE user SET password='$new_hash' WHERE id='$user_id'");
            echo "<script>alert('Password berhasil diganti! Silakan login ulang.'); window.location.href='" . BASE_URL . "actions/auth_logout.php';</script>";
        } else {
            echo "<script>alert('Password baru dan Konfirmasi tidak cocok!'); window.location.href='" . BASE_URL . "views/user/profile.php';</script>";
        }

    } else {
        echo "<script>alert('Password Lama Salah!'); window.location.href='" . BASE_URL . "views/user/profile.php';</script>";
    }
}
?>