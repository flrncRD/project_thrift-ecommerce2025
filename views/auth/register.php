<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>

    <h2>Register Akun</h2>

    <form action="cek_register.php" method="POST" enctype="multipart/form-data">

        <label for="txtusername">Username:</label><br>
        <input type="text" id="txtusername" name="txtusername" required><br><br>

        <label for="txtemail">Email:</label><br>
        <input type="email" id="txtemail" name="txtemail" required><br><br>

        <label for="txtpass">Password:</label><br>
        <input type="password" id="txtpass" name="txtpass" required><br><br>

        <label for="txtalamat">Alamat:</label><br>
        <input type="text" id="txtalamat" name="txtalamat" required><br><br>

        <label for="txtkota">Kota:</label><br>
        <input type="text" id="txtkota" name="txtkota" required><br><br>

        <label for="txtphone">Nomor Telepon:</label><br>
        <input type="text" id="txtphone" name="txtphone" required><br><br>

        <label for="txtprofile">Foto Profil:</label><br>
        <input type="file" id="txtprofile" name="txtprofile" accept="image/*" required><br><br>

        <input type="submit" value="Register">

        <p>Already have an account? <a href="login.php">Login here</a></p>

    </form>

</body>
</html>
