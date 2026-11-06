<?php
$error   = $_SESSION['error']   ?? null;
$success = $_SESSION['success'] ?? null;
unset($_SESSION['error'], $_SESSION['success']);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin – SportSpace</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200">
    <link rel="stylesheet" href="<?= $baseUrl ?>/css/output.css">
</head>

<body class="min-h-screen bg-[#0D0F10] text-white flex flex-col items-center justify-center px-5 py-10">

    <div class="w-full max-w-md">

        <!-- Badge Admin -->
        <div class="flex justify-center mb-6">
            <span class="inline-flex items-center gap-2 rounded-full bg-[#B8F500]/10 border border-[#B8F500]/30 px-4 py-1.5 text-sm font-bold text-[#B8F500]">
                <span class="material-symbols-outlined text-[16px]">admin_panel_settings</span>
                Admin Panel
            </span>
        </div>

        <!-- Logo -->
        <div class="text-center mb-8">
            <a href="/" class="inline-flex items-center gap-2 group">
                <span class="flex h-10 w-10 items-center justify-center rounded-full bg-[#B8F500] text-black shadow-lg transition group-hover:scale-105">
                    <span class="material-symbols-outlined text-[22px]">bolt</span>
                </span>
                <h1 class="text-3xl font-extrabold tracking-tight">
                    Sport<span class="text-[#B8F500]">Space</span>
                </h1>
            </a>
            <p class="text-gray-400 mt-3 text-sm">
                Masuk sebagai administrator untuk mengelola sistem.
            </p>
        </div>

        <!-- Card Login -->
        <div class="bg-[#1A1D1E] border border-[#2E3133] rounded-3xl p-8 shadow-2xl">

            <h2 class="text-xl font-bold mb-1 flex items-center gap-2">
                <span class="material-symbols-outlined text-[#B8F500] text-[20px]">lock</span>
                Masuk Admin
            </h2>
            <p class="text-gray-500 text-sm mb-7">
                Hanya akun dengan role <span class="text-[#B8F500] font-semibold">admin</span> yang dapat mengakses panel ini.
            </p>

            <!-- Pesan Error -->
            <?php if ($error): ?>
                <div class="bg-red-500/10 border border-red-500/30 text-red-400 p-3 rounded-xl mb-5 flex items-start gap-2 text-sm">
                    <span class="material-symbols-outlined text-[18px] mt-0.5">error</span>
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <!-- Pesan Sukses -->
            <?php if ($success): ?>
                <div class="bg-green-500/10 border border-green-500/30 text-green-400 p-3 rounded-xl mb-5 flex items-start gap-2 text-sm">
                    <span class="material-symbols-outlined text-[18px] mt-0.5">check_circle</span>
                    <?= htmlspecialchars($success) ?>
                </div>
            <?php endif; ?>

            <!-- Form Login Admin -->
            <form action="<?= $baseUrl ?>/admin/login" method="POST">

                <div class="mb-5">
                    <label class="block text-sm font-semibold mb-2 text-gray-300">Email Admin</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 text-[20px]">email</span>
                        <input
                            type="email"
                            name="email"
                            placeholder="admin@sportspace.com"
                            required
                            autocomplete="email"
                            class="w-full bg-[#0D0F10] border border-[#2E3133] rounded-2xl pl-11 pr-5 py-4 outline-none focus:border-[#B8F500] transition text-sm"
                        >
                    </div>
                </div>

                <div class="mb-7">
                    <label class="block text-sm font-semibold mb-2 text-gray-300">Password</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 text-[20px]">key</span>
                        <input
                            type="password"
                            name="password"
                            id="password-field"
                            placeholder="Masukkan password admin"
                            required
                            autocomplete="current-password"
                            class="w-full bg-[#0D0F10] border border-[#2E3133] rounded-2xl pl-11 pr-12 py-4 outline-none focus:border-[#B8F500] transition text-sm"
                        >
                        <button type="button"
                                onclick="togglePassword()"
                                class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-300 transition">
                            <span class="material-symbols-outlined text-[20px]" id="eye-icon">visibility</span>
                        </button>
                    </div>
                </div>

                <button
                    type="submit"
                    class="w-full bg-[#B8F500] text-black font-bold text-sm py-4 rounded-2xl hover:bg-[#a5dc00] transition flex items-center justify-center gap-2"
                >
                    <span class="material-symbols-outlined text-[18px]">login</span>
                    Masuk ke Panel Admin
                </button>

            </form>
        </div>

        <!-- Link kembali -->
        <p class="text-center text-gray-600 text-sm mt-6">
            <a href="<?= $baseUrl ?>/login" class="text-gray-400 hover:text-[#B8F500] transition">
                ← Kembali ke Login Customer
            </a>
        </p>

        <!-- Footer -->
        <p class="text-center text-gray-700 text-xs mt-4">
            &copy; <?= date('Y') ?> SportSpace. All rights reserved.
        </p>
    </div>

    <script>
        function togglePassword() {
            const field = document.getElementById('password-field');
            const icon  = document.getElementById('eye-icon');
            if (field.type === 'password') {
                field.type = 'text';
                icon.textContent = 'visibility_off';
            } else {
                field.type = 'password';
                icon.textContent = 'visibility';
            }
        }
    </script>
</body>
</html>

