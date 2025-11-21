<?php 
include '../conn.php';
include '../class/users.php';

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $username = $_POST['txtusername'];
    $email    = $_POST['txtemail'];
    $password = $_POST['txtpass'];
    $alamat   = $_POST['txtalamat'];
    $kota     = $_POST['txtkota'];
    $phone    = $_POST['txtphone'];

    // HASH PASSWORD
    // $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    // password flo: 12345

    // Cek username sudah ada atau belum
    $check = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");
    if(mysqli_num_rows($check) > 0){
        echo "Username sudah digunakan. <a href='register.php'>Kembali</a>";
        exit();
    }

    //Buat object user baru
    $u = new Users($username, $email, $password, $_FILES['txtprofile'], $alamat, $kota, $phone);
    
    if ($u->insert($conn)) {
    echo "Registrasi berhasil! <a href='login.php'>Login sekarang</a>";
    } else {
        echo "Terjadi kesalahan: " . mysqli_error($conn);
    }
}

//     // Simpan profile foto
//     $photo = $_FILES['txtprofile']['name'];
//     $tmp = $_FILES['txtprofile']['tmp_name'];

//     $folder = "../uploads/profile/" . $photo;

//     move_uploaded_file($tmp, $folder);
    
//     // Insert User baru
//     $sql = "INSERT INTO user (username, email, password, photo, alamat, kota, phone, status, role, createdAt)
//             VALUES ('$username', '$email', '$hashed_password', '$photo', '$alamat', '$kota', '$phone', 
//                     'active', 'user', NOW())";

//     if(mysqli_query($conn, $sql)){
//         echo "Registrasi berhasil! <a href='login.php'>Login sekarang</a>";
//     } else {
//         echo "Terjadi kesalahan: " . mysqli_error($conn);
//     }
// }
?>
