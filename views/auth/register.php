<?php include '../../config/conn.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - PindaHand</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        /* Custom scrollbar untuk form yang panjang */
        .hide-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .hide-scrollbar::-webkit-scrollbar-thumb {
            background-color: #CBD5E1;
            border-radius: 4px;
        }
    </style>
</head>

<body class="bg-white">

    <div class="flex min-h-screen">

        <div
            class="w-full md:w-1/2 flex flex-col justify-center px-8 md:px-12 lg:px-20 bg-white z-10 py-10 overflow-y-auto h-screen hide-scrollbar">

            <div class="mb-8">
                <a href="<?= BASE_URL ?>index.php"
                    class="text-3xl font-extrabold flex items-center gap-1 text-[#1E3A8A]">
                    Pinda<span class="text-[#059669]">Hand</span>
                    <div class="w-3 h-3 rounded-full bg-[#FACC15] ml-1"></div>
                </a>
            </div>

            <h2 class="text-3xl font-bold text-[#1E3A8A] mb-2">Create Account</h2>
            <p class="text-gray-500 mb-8">Join the sustainable fashion community.</p>

            <form action="<?= BASE_URL ?>actions/auth_register.php" method="POST" enctype="multipart/form-data"
                class="space-y-4">

                <div>
                    <label class="block text-gray-700 text-xs font-bold uppercase tracking-wide mb-2">Username</label>
                    <input type="text" name="txtusername" placeholder="Choose a unique username" required
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#059669] focus:border-transparent transition text-gray-900 text-sm">
                </div>

                <div>
                    <label class="block text-gray-700 text-xs font-bold uppercase tracking-wide mb-2">Email
                        Address</label>
                    <input type="email" name="txtemail" placeholder="name@example.com" required
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#059669] focus:border-transparent transition text-gray-900 text-sm">
                </div>

                <div>
                    <label class="block text-gray-700 text-xs font-bold uppercase tracking-wide mb-2">Password</label>
                    <input type="password" name="txtpass" placeholder="Create a strong password" required
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#059669] focus:border-transparent transition text-gray-900 text-sm">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 text-xs font-bold uppercase tracking-wide mb-2">City</label>
                        <input type="text" name="txtkota" placeholder="Surabaya" required 
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#059669] focus:border-transparent transition text-gray-900 text-sm">
                    </div>
                    <div>
                        <label class="block text-gray-700 text-xs font-bold uppercase tracking-wide mb-2">Phone</label>
                        <input type="tel" name="txtphone" placeholder="0812xxxx (Angka Saja)" required 
                            pattern="[0-9]{8,15}"
                            title="Nomor HP harus berupa angka, minimal 8-15 digit (Contoh: 08123456789)"
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#059669] focus:border-transparent transition text-gray-900 text-sm">
                    </div>
                </div>

                <div>
                    <label class="block text-gray-700 text-xs font-bold uppercase tracking-wide mb-2">Full
                        Address</label>
                    <input type="text" name="txtalamat" placeholder="Street name, House number..." required
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#059669] focus:border-transparent transition text-gray-900 text-sm">
                </div>

                <div>
                    <label class="block text-gray-700 text-xs font-bold uppercase tracking-wide mb-2">Profile
                        Picture</label>
                    <input type="file" name="txtprofile" accept="image/*" required
                        class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-[#059669]/10 file:text-[#059669] hover:file:bg-[#059669]/20 cursor-pointer border border-gray-300 rounded-lg">
                </div>

                <button type="submit"
                    class="w-full bg-[#1E3A8A] text-white font-bold py-3.5 rounded-lg hover:bg-blue-900 transition duration-300 shadow-lg transform active:scale-95 mt-6">
                    Sign Up
                </button>
            </form>

            <p class="mt-6 text-center text-sm text-gray-600">
                Already have an account?
                <a href="login.php" class="text-[#059669] font-bold hover:underline ml-1">Sign In</a>
            </p>
        </div>

        <div class="hidden md:block w-1/2 relative fixed h-screen">
            <img src="https://images.unsplash.com/photo-1556905055-8f358a7a47b2?q=80&w=2070&auto=format&fit=crop"
                alt="Thrift Community" class="absolute inset-0 w-full h-full object-cover">

            <div class="absolute inset-0 bg-gradient-to-br from-[#1E3A8A]/80 to-[#059669]/40 mix-blend-multiply"></div>

            <div class="absolute bottom-10 left-10 right-10 text-white">
                <h3 class="text-4xl font-bold mb-2">Join the Movement.</h3>
                <p class="text-lg opacity-90">Give your clothes a second life and find your unique style.</p>
            </div>
        </div>

    </div>

</body>

</html>