<?php include '../../config/conn.php'; ?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In - PindaHand</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-white h-screen flex overflow-hidden">

    <div class="w-full md:w-1/2 flex flex-col justify-center px-12 md:px-24 bg-white">

        <h1 class="text-4xl font-extrabold mb-16 text-[#1E3A8A]">
            PINDA<span class="text-[#059669]">HAND</span>
        </h1>

        <h2 class="text-3xl font-bold mb-8 text-gray-900">Sign In</h2>

        <form action="<?= BASE_URL ?>actions/auth_login.php" method="POST">

            <div class="mb-6">
                <label class="block text-sm font-semibold mb-2 text-gray-700">Email / Username</label>
                <input type="text" name="username" required
                    class="w-full h-12 px-4 bg-gray-200 border-none rounded focus:outline-none focus:ring-2 focus:ring-[#1E3A8A]">
            </div>

            <div class="mb-2">
                <label class="block text-sm font-semibold mb-2 text-gray-700">Password</label>
                <input type="password" name="password" required
                    class="w-full h-12 px-4 bg-gray-200 border-none rounded focus:outline-none focus:ring-2 focus:ring-[#1E3A8A]">
            </div>

            <div class="flex justify-end mb-8">
                <a href="#" class="text-sm text-gray-600 hover:text-[#1E3A8A]">Forgot Password?</a>
            </div>

            <button type="submit"
                class="w-full h-12 bg-gray-500 text-white font-bold rounded hover:bg-[#1E3A8A] transition duration-200">
                Sign-In
            </button>

        </form>

        <p class="mt-6 text-sm text-gray-600">
            Don't have an account?
            <a href="register.php" class="text-[#1E3A8A] font-bold hover:underline">Register Here</a>
        </p>

    </div>

    <div class="hidden md:block w-1/2 bg-gray-300"></div>

</body>

</html>