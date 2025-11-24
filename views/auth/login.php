<?php include '../../config/conn.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In - PindaHand</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-white">

    <div class="flex min-h-screen">

        <div class="w-full md:w-1/2 flex flex-col justify-center px-8 md:px-16 lg:px-24 bg-white z-10">

            <div class="mb-10">
                <a href="<?= BASE_URL ?>index.php"
                    class="text-3xl font-extrabold flex items-center gap-1 text-[#1E3A8A]">
                    Pinda<span class="text-[#059669]">Hand</span>
                    <div class="w-3 h-3 rounded-full bg-[#FACC15] ml-1"></div>
                </a>
            </div>

            <h2 class="text-4xl font-bold text-[#1E3A8A] mb-2">Sign In</h2>
            <p class="text-gray-500 mb-10">Welcome back! Please enter your details.</p>

            <form action="<?= BASE_URL ?>actions/auth_login.php" method="POST">

                <div class="mb-5">
                    <label class="block text-gray-700 text-sm font-semibold mb-2">Username / Email</label>
                    <input type="text" name="username" placeholder="Enter your username" required
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#059669] focus:border-transparent transition text-gray-900">
                </div>

                <div class="mb-2">
                    <label class="block text-gray-700 text-sm font-semibold mb-2">Password</label>
                    <input type="password" name="password" placeholder="••••••••" required
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#059669] focus:border-transparent transition text-gray-900">
                </div>

                <div class="flex justify-end mb-8">
                    <a href="#" class="text-sm text-[#059669] font-semibold hover:underline">Forgot Password?</a>
                </div>

                <button type="submit"
                    class="w-full bg-[#1E3A8A] text-white font-bold py-3.5 rounded-lg hover:bg-blue-900 transition duration-300 shadow-lg transform active:scale-95">
                    Sign In
                </button>
            </form>

            <p class="mt-8 text-center text-sm text-gray-600">
                Don't have an account?
                <a href="register.php" class="text-[#059669] font-bold hover:underline ml-1">Register Here</a>
            </p>
        </div>

        <div class="hidden md:block w-1/2 relative">
            <img src="https://images.unsplash.com/photo-1483985988355-763728e1935b?q=80&w=2070&auto=format&fit=crop"
                alt="Thrift Fashion Background" class="absolute inset-0 w-full h-full object-cover">

            <div class="absolute inset-0 bg-[#1E3A8A]/20 mix-blend-multiply"></div>
        </div>

    </div>

</body>

</html>