<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>

    <h2>Login Akun</h2>

    <form action="cek_login.php" method="POST">
        <label for="txtusername">Username:</label><br>
        <input type="email" id="txtusername" name="txtusername" required><br><br>

        <label for="txtpass">Password:</label><br>
        <input type="password" id="txtpass" name="txtpass" required><br><br>

        <input type="submit" value="Login">

        <p>Don't have an account? <a href="register.php">Register here</a></p>

    </form>

</body>
</html>
