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
    <title>Register | SportSpace</title>

    <link rel="stylesheet" href="<?= $baseUrl ?>/css/output.css">
</head>

<body class="min-h-screen bg-[#17191A] text-white flex items-center justify-center p-5">

    <div class="w-full max-w-md">

        <!-- Logo -->
        <div class="text-center mb-8">
            <a href="<?= $baseUrl ?>" class="inline-flex items-center gap-2">
                <span class="flex items-center justify-center w-10 h-10 rounded-xl bg-[#B8F500] text-black font-black text-xl">
                    S
                </span>

                <span class="text-2xl font-extrabold tracking-wide">
                    SPORT<span class="text-[#B8F500]">SPACE</span>
                </span>
            </a>

            <p class="text-gray-400 text-sm mt-3">
                Temukan lapangan dan teman main favoritmu!
            </p>
        </div>

        <!-- Register Card -->
        <div class="bg-[#222526] border border-white/10 rounded-2xl p-7 shadow-2xl">

            <div class="mb-6">
                <h1 class="text-2xl font-bold">
                    Buat Akun
                </h1>

                <p class="text-gray-400 text-sm mt-2">
                    Daftar sekarang dan mulai pengalaman olahraga bersama SportSpace.
                </p>
            </div>

            <!-- Pesan Error -->
            <?php if ($error): ?>
                <div class="bg-red-500/10 border border-red-500/30 text-red-400 rounded-lg p-3 mb-5 text-sm">
                    <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
                </div>
            <?php endif; ?>

            <!-- Pesan Berhasil -->
            <?php if ($success): ?>
                <div class="bg-green-500/10 border border-green-500/30 text-green-400 rounded-lg p-3 mb-5 text-sm">
                    <?= htmlspecialchars($success, ENT_QUOTES, 'UTF-8') ?>
                </div>
            <?php endif; ?>

            <!-- Form Register -->
            <form action="<?= $baseUrl ?>/register" method="POST" class="space-y-4">

                <!-- Nama -->
                <div>
                    <label for="name" class="block text-sm font-medium mb-2">
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
                        class="w-full bg-[#17191A] border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-500 outline-none focus:border-[#B8F500] transition"
                    >
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium mb-2">
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
                        class="w-full bg-[#17191A] border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-500 outline-none focus:border-[#B8F500] transition"
                    >
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium mb-2">
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
                        class="w-full bg-[#17191A] border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-500 outline-none focus:border-[#B8F500] transition"
                    >
                </div>

                <!-- Konfirmasi Password -->
                <div>
                    <label for="confirm_password" class="block text-sm font-medium mb-2">
                        Konfirmasi Password
                    </label>

                    <input
                        type="password"
                        id="confirm_password"
                        name="confirm_password"
                        placeholder="Masukkan ulang password"
                        minlength="8"
                        required
                        autocomplete="new-password"
                        class="w-full bg-[#17191A] border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-500 outline-none focus:border-[#B8F500] transition"
                    >
                </div>

                <!-- Tombol Register -->
                <button
                    type="submit"
                    class="w-full bg-[#B8F500] hover:bg-[#a4db00] text-black font-bold py-3 rounded-xl transition duration-200 mt-2"
                >
                    Daftar Sekarang
                </button>

            </form>

            <!-- Link Login -->
            <p class="text-center text-sm text-gray-400 mt-6">
                Sudah punya akun?

                <a href="<?= $baseUrl ?>/login" class="text-[#B8F500] font-semibold hover:underline">
                    Login di sini
                </a>
            </p>

        </div>

        <!-- Kembali -->
        <p class="text-center text-xs text-gray-500 mt-6">
            &copy; <?= date('Y') ?> SportSpace. All rights reserved.
        </p>

    </div>

</body>
</html>