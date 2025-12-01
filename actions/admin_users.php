<?php
session_start();
include '../config/conn.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: " . BASE_URL . "index.php");
    exit();
}

// Change Role
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['toggle_role'])) {
    $id = $_POST['user_id'];
    $current_role = $_POST['current_role'];

    if ($id == $_SESSION['user_id']) {
        echo "<script>
                alert('Anda tidak bisa mengubah role akun sendiri!'); 
                window.location.href='" . BASE_URL . "views/admin/manage_users.php';
              </script>";
        exit();
    }

    $new_role = ($current_role == 'admin') ? 'user' : 'admin';

    $query = "UPDATE user SET role='$new_role' WHERE id='$id'";
    if (mysqli_query($conn, $query)) {
        echo "<script>
                alert('Role user berhasil diubah menjadi $new_role!'); 
                window.location.href='" . BASE_URL . "views/admin/manage_users.php';
              </script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// Soft Ban
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $id = $_GET['id'];

    if ($id == $_SESSION['user_id']) {
        echo "<script>
                alert('Anda tidak bisa menonaktifkan akun sendiri!'); 
                window.location.href='" . BASE_URL . "views/admin/manage_users.php';
              </script>";
        exit();
    }

    $query = "UPDATE user SET status='inactive' WHERE id='$id'";

    if (mysqli_query($conn, $query)) {
        echo "<script>
                alert('User berhasil dinonaktifkan (Status: Inactive)!'); 
                window.location.href='" . BASE_URL . "views/admin/manage_users.php';
              </script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// Restore
if (isset($_GET['action']) && $_GET['action'] == 'restore' && isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = "UPDATE user SET status='active' WHERE id='$id'";

    if (mysqli_query($conn, $query)) {
        echo "<script>
                alert('User berhasil diaktifkan kembali (Status: Active)!'); 
                window.location.href='" . BASE_URL . "views/admin/manage_users.php';
              </script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>