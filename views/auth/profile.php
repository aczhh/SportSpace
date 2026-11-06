<?php
$userData = $userData ?? $_SESSION['user'] ?? [];
$success  = $success  ?? null;
$error    = $error    ?? null;
$baseUrl  = $baseUrl  ?? '';

require __DIR__ . '/../layout/header.php';
?>

<main class="flex-1 bg-snow pt-28 pb-16">
  <div class="mx-auto max-w-xl px-4 sm:px-6">

    <!-- Header -->
    <div class="mb-8">
      <h1 class="text-3xl font-extrabold tracking-tight text-ink">Pengaturan Profil</h1>
      <p class="mt-1 text-steel">Kelola informasi akun SportSpace kamu.</p>
    </div>

    <!-- Pesan -->
    <?php if ($success): ?>
      <div class="mb-6 flex items-center gap-3 rounded-xl border border-green-200 bg-green-50 p-4 text-sm font-semibold text-green-800">
        <span class="material-symbols-outlined text-[20px]">check_circle</span>
        <?= htmlspecialchars($success) ?>
      </div>
    <?php endif; ?>
    <?php if ($error): ?>
      <div class="mb-6 flex items-center gap-3 rounded-xl border border-red-200 bg-red-50 p-4 text-sm font-semibold text-red-700">
        <span class="material-symbols-outlined text-[20px]">error</span>
        <?= htmlspecialchars($error) ?>
      </div>
    <?php endif; ?>

    <!-- Card Info Akun -->
    <div class="mb-6 rounded-2xl border border-black/10 bg-white p-6 shadow-sm">
      <div class="flex items-center gap-4 mb-6">
        <span class="flex h-16 w-16 items-center justify-center rounded-full bg-brand text-ink text-2xl font-extrabold shadow">
          <?= htmlspecialchars(mb_strtoupper(mb_substr($userData['name'] ?? 'U', 0, 1))) ?>
        </span>
        <div>
          <p class="text-xl font-extrabold text-ink"><?= htmlspecialchars($userData['name'] ?? '') ?></p>
          <p class="text-sm text-steel"><?= htmlspecialchars($userData['email'] ?? '') ?></p>
          <span class="inline-block mt-1 rounded-full bg-brand/15 px-3 py-0.5 text-xs font-bold text-ink uppercase">
            <?= htmlspecialchars($userData['role'] ?? 'customer') ?>
          </span>
        </div>
      </div>

      <!-- Form Update Nama -->
      <form action="<?= $baseUrl ?>/profile" method="POST">
        <div class="flex flex-col gap-1.5 mb-4">
          <label for="profile-name" class="text-sm font-bold text-ink">Nama Lengkap</label>
          <input id="profile-name" name="name" type="text" required
                 value="<?= htmlspecialchars($userData['name'] ?? '') ?>"
                 maxlength="100"
                 class="w-full rounded-xl border border-black/10 bg-snow px-4 py-3 text-sm text-ink outline-none focus:ring-2 focus:ring-brand">
        </div>

        <div class="flex flex-col gap-1.5 mb-6">
          <label class="text-sm font-bold text-ink">Email</label>
          <input type="email" disabled
                 value="<?= htmlspecialchars($userData['email'] ?? '') ?>"
                 class="w-full rounded-xl border border-black/10 bg-black/5 px-4 py-3 text-sm text-steel cursor-not-allowed">
          <p class="text-xs text-steel">Email tidak dapat diubah.</p>
        </div>

        <button type="submit"
                class="flex items-center justify-center gap-2 rounded-xl bg-brand px-6 py-3 text-sm font-bold text-ink shadow-md transition hover:bg-brand-hover">
          <span class="material-symbols-outlined text-[18px]">save</span>
          Simpan Perubahan
        </button>
      </form>
    </div>

    <!-- Logout -->
    <div class="rounded-2xl border border-red-200 bg-red-50 p-5">
      <h3 class="font-bold text-red-700 mb-1 flex items-center gap-2">
        <span class="material-symbols-outlined text-[18px]">logout</span>
        Keluar dari Akun
      </h3>
      <p class="text-sm text-red-600 mb-4">Sesi kamu akan diakhiri dan kamu perlu login kembali.</p>
      <form action="<?= $baseUrl ?>/logout" method="POST">
        <button type="submit"
                class="rounded-xl bg-red-500 px-5 py-2.5 text-sm font-bold text-white transition hover:bg-red-600">
          Logout Sekarang
        </button>
      </form>
    </div>

  </div>
</main>

<?php require __DIR__ . '/../layout/footer.php'; ?>

