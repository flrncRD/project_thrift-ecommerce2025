<?php include '../../config/conn.php'; ?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - PindaHand</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        /* Hide scrollbar for clean look */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>

<body class="bg-white h-screen flex overflow-hidden">

    <div class="w-full md:w-1/2 flex flex-col px-12 md:px-24 bg-white h-full overflow-y-auto no-scrollbar pt-10 pb-10">

        <h1 class="text-4xl font-extrabold mb-10 text-[#1E3A8A]">
            PINDA<span class="text-[#059669]">HAND</span>
        </h1>

        <h2 class="text-3xl font-bold mb-8 text-gray-900">Register</h2>

        <form action="<?= BASE_URL ?>actions/auth_register.php" method="POST" enctype="multipart/form-data"
            class="space-y-5">

            <div>
                <label class="block text-sm font-semibold mb-2 text-gray-700">Username</label>
                <input type="text" name="txtusername" required
                    class="w-full h-12 px-4 bg-gray-200 border-none rounded focus:outline-none focus:ring-2 focus:ring-[#1E3A8A]">
            </div>

            <div>
                <label class="block text-sm font-semibold mb-2 text-gray-700">Email</label>
                <input type="email" name="txtemail" required
                    class="w-full h-12 px-4 bg-gray-200 border-none rounded focus:outline-none focus:ring-2 focus:ring-[#1E3A8A]">
            </div>

            <div>
                <label class="block text-sm font-semibold mb-2 text-gray-700">Password</label>
                <input type="password" name="txtpass" required
                    class="w-full h-12 px-4 bg-gray-200 border-none rounded focus:outline-none focus:ring-2 focus:ring-[#1E3A8A]">
            </div>

            <div>
                <label class="block text-sm font-semibold mb-2 text-gray-700">Full Address</label>
                <input type="text" name="txtalamat" required
                    class="w-full h-12 px-4 bg-gray-200 border-none rounded focus:outline-none focus:ring-2 focus:ring-[#1E3A8A]">
            </div>

            <div class="flex gap-4">
                <div class="w-1/2">
                    <label class="block text-sm font-semibold mb-2 text-gray-700">City</label>
                    <input type="text" name="txtkota" required
                        class="w-full h-12 px-4 bg-gray-200 border-none rounded focus:outline-none focus:ring-2 focus:ring-[#1E3A8A]">
                </div>
                <div class="w-1/2">
                    <label class="block text-sm font-semibold mb-2 text-gray-700">Phone</label>
                    <input type="text" name="txtphone" required
                        class="w-full h-12 px-4 bg-gray-200 border-none rounded focus:outline-none focus:ring-2 focus:ring-[#1E3A8A]">
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold mb-2 text-gray-700">Profile Picture</label>
                <input type="file" name="txtprofile" accept="image/*" required
                    class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-gray-200 file:text-gray-700 hover:file:bg-gray-300">
            </div>

            <button type="submit"
                class="w-full h-12 bg-gray-500 text-white font-bold rounded hover:bg-[#059669] transition duration-200 mt-4">
                Sign-Up
            </button>

        </form>

        <p class="mt-6 text-center text-sm text-gray-600">
            Already have an account?
            <a href="login.php" class="text-[#1E3A8A] font-bold hover:underline">Sign In</a>
        </p>

    </div>

    <div class="hidden md:block w-1/2 bg-gray-300 fixed right-0 h-full"></div>

</body>

</html>