<?php
session_start();
include '../conn.php';

//jika ws login, masuk ke dashboard
if (isset($_SESSION['username'])) {
    header("Location: ../dashboard.php");
    exit();
}
$username = $_POST['txtusername'];
$password = $_POST['txtpass'];

//ambil user berdasarkan username
$stmt = $conn->prepare("SELECT * FROM user WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();

    if (password_verify($password, $row['password'])) {
        $_SESSION['username'] = $row['username'];
        $_SESSION['email'] = $row['email'];
        $_SESSION['role'] = $row['role'];
        // pindah ke dashboard
        header("Location: ../dashboard.php");
        exit();
        
    } else {
        echo "Password salah";
    }
} else {
    echo "Username tidak ditemukan";
}

$stmt->close();
$conn->close();
?>
