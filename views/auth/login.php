<?php
$error = $_SESSION['error'] ?? null;
$success = $_SESSION['success'] ?? null;
unset($_SESSION['error'], $_SESSION['success']);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SportSpace</title>

    <link rel="stylesheet" href="<?= $baseUrl ?>/css/output.css">
</head>

<body class="min-h-screen bg-[#17191A] text-white flex flex-col items-center justify-center px-5 py-10">

    <div class="w-full max-w-md">

        <!-- Logo dan Judul -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-extrabold tracking-tight">
                Sport<span class="text-[#B8F500]">Space</span>
            </h1>

            <p class="text-gray-400 mt-3">
                Masuk dan mulai pengalaman olahraga bersama kami.
            </p>
        </div>

        <!-- Card Login -->
        <div class="bg-[#222526] border border-[#41443C] rounded-3xl p-8 shadow-xl">

            <h2 class="text-2xl font-bold mb-2">
                Selamat Datang!
            </h2>

            <p class="text-gray-400 mb-7">
                Silakan masuk menggunakan akun SportSpace.
            </p>

            <!-- Pesan Error -->
            <?php if ($error): ?>
                <div class="bg-red-500/10 border border-red-500/30 text-red-400 p-3 rounded-xl mb-5">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <!-- Pesan Berhasil -->
            <?php if ($success): ?>
                <div class="bg-green-500/10 border border-green-500/30 text-green-400 p-3 rounded-xl mb-5">
                    <?= htmlspecialchars($success) ?>
                </div>
            <?php endif; ?>

            <!-- Form Login -->
            <form action="<?= $baseUrl ?>/login" method="POST">

                <div class="mb-5">
                    <label class="block font-medium mb-2">
                        Email
                    </label>

                    <input
                        type="email"
                        name="email"
                        placeholder="contoh@email.com"
                        required
                        autocomplete="email"
                        class="w-full bg-[#17191A] border border-[#41443C] rounded-2xl px-5 py-4 outline-none focus:border-[#B8F500] transition"
                    >
                </div>

                <div class="mb-7">
                    <label class="block font-medium mb-2">
                        Password
                    </label>

                    <input
                        type="password"
                        name="password"
                        placeholder="Masukkan password"
                        required
                        autocomplete="current-password"
                        class="w-full bg-[#17191A] border border-[#41443C] rounded-2xl px-5 py-4 outline-none focus:border-[#B8F500] transition"
                    >
                </div>

                <button
                    type="submit"
                    class="w-full bg-[#B8F500] text-black font-bold text-lg py-4 rounded-2xl hover:bg-[#a5dc00] transition"
                >
                    Masuk Sekarang
                </button>

            </form>

            <!-- Link Register -->
            <p class="text-center text-gray-400 mt-7">
                Belum punya akun?

                <a
                    href="<?= $baseUrl ?>/register"
                    class="text-[#B8F500] font-bold hover:underline"
                >
                    Daftar di sini
                </a>
            </p>

        </div>

        <!-- Footer -->
        <p class="text-center text-gray-500 text-sm mt-8">
            &copy; 2026 SportSpace. All rights reserved.
        </p>

    </div>

</body>
</html>
