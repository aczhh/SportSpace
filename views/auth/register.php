<?php
$baseUrl = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');

// Mengambil pesan dari session
$error = $_SESSION['error'] ?? null;
$success = $_SESSION['success'] ?? null;

// Menghapus pesan setelah ditampilkan
unset($_SESSION['error'], $_SESSION['success']);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - SportSpace</title>

    <link rel="stylesheet" href="<?= $baseUrl ?>/css/output.css">
</head>

<body class="min-h-screen bg-[#17191A] text-white flex flex-col items-center justify-center px-5 py-10">

    <div class="w-full max-w-md">

        <!-- Logo dan Judul -->
        <div class="text-center mb-8">
            <a href="/" class="inline-block group">
                <h1 class="text-4xl font-extrabold tracking-tight transition group-hover:opacity-85">
                    Sport<span class="text-[#B8F500]">Space</span>
                </h1>
            </a>

            <p class="text-gray-400 mt-3">
                Daftar dan mulai pengalaman olahraga bersama kami.
            </p>
        </div>

        <!-- Card Register -->
        <div class="bg-[#222526] border border-[#41443C] rounded-3xl p-8 shadow-xl">

            <h2 class="text-2xl font-bold mb-2">
                Buat Akun Baru
            </h2>

            <p class="text-gray-400 mb-7">
                Silakan isi data diri untuk mendaftar akun SportSpace.
            </p>

            <!-- Pesan Error -->
            <?php if ($error): ?>
                <div class="bg-red-500/10 border border-red-500/30 text-red-400 p-3 rounded-xl mb-5">
                    <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
                </div>
            <?php endif; ?>

            <!-- Pesan Berhasil -->
            <?php if ($success): ?>
                <div class="bg-green-500/10 border border-green-500/30 text-green-400 p-3 rounded-xl mb-5">
                    <?= htmlspecialchars($success, ENT_QUOTES, 'UTF-8') ?>
                </div>
            <?php endif; ?>

            <!-- Form Register -->
            <form action="<?= $baseUrl ?>/register" method="POST">

                <!-- Nama -->
                <div class="mb-5">
                    <label for="name" class="block font-medium mb-2">
                        Nama Lengkap
                    </label>

                    <input
                        type="text"
                        id="name"
                        name="name"
                        placeholder="Masukkan nama lengkap"
                        maxlength="100"
                        required
                        autocomplete="name"
                        class="w-full bg-[#17191A] border border-[#41443C] rounded-2xl px-5 py-4 outline-none focus:border-[#B8F500] transition"
                    >
                </div>

                <!-- Email -->
                <div class="mb-5">
                    <label for="email" class="block font-medium mb-2">
                        Email
                    </label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        placeholder="contoh@email.com"
                        maxlength="100"
                        required
                        autocomplete="email"
                        class="w-full bg-[#17191A] border border-[#41443C] rounded-2xl px-5 py-4 outline-none focus:border-[#B8F500] transition"
                    >
                </div>

                <!-- Password -->
                <div class="mb-5">
                    <label for="password" class="block font-medium mb-2">
                        Password
                    </label>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Minimal 8 karakter"
                        minlength="8"
                        required
                        autocomplete="new-password"
                        class="w-full bg-[#17191A] border border-[#41443C] rounded-2xl px-5 py-4 outline-none focus:border-[#B8F500] transition"
                    >
                </div>

                <!-- Konfirmasi Password -->
                <div class="mb-7">
                    <label for="confirm_password" class="block font-medium mb-2">
                        Konfirmasi Password
                    </label>

                    <input
                        type="password"
                        id="confirm_password"
                        name="confirm_password"
                        placeholder="Ulangi password"
                        minlength="8"
                        required
                        autocomplete="new-password"
                        class="w-full bg-[#17191A] border border-[#41443C] rounded-2xl px-5 py-4 outline-none focus:border-[#B8F500] transition"
                    >
                </div>

                <!-- Tombol Register -->
                <button
                    type="submit"
                    class="w-full bg-[#B8F500] text-black font-bold text-lg py-4 rounded-2xl hover:bg-[#a5dc00] transition"
                >
                    Daftar Sekarang
                </button>

            </form>

            <!-- Link Login -->
            <p class="text-center text-gray-400 mt-7">
                Sudah punya akun?

                <a
                    href="<?= $baseUrl ?>/login"
                    class="text-[#B8F500] font-bold hover:underline"
                >
                    Login di sini
                </a>
            </p>

        </div>

        <!-- Footer -->
        <p class="text-center text-gray-500 text-sm mt-8">
            &copy; <?= date('Y') ?> SportSpace. All rights reserved.
        </p>

    </div>

</body>
</html>
