<?php
// =============================================
// VIEW: Detail Lapangan
// Tanggung jawab: Anggota 2
// Variabel dari CourtController:
//   $lapangan = array data satu lapangan
// =============================================

$lapangan  = $lapangan ?? [];
$gambar    = !empty($lapangan['image']) ? $lapangan['image'] : 'court.jpg';

// Fasilitas disimpan sebagai string pisah koma → ubah jadi array
$fasilitas = array_filter(array_map('trim', explode(',', (string)($lapangan['facilities'] ?? ''))));

require __DIR__ . '/../layout/header.php';
?>

<main class="flex-1 bg-snow pt-28 pb-16">
  <div class="mx-auto max-w-5xl px-4 sm:px-6">

    <!-- Tombol kembali -->
    <a href="/courts"
       class="mb-6 inline-flex items-center gap-1 text-sm font-semibold text-steel transition hover:text-ink">
      <span class="material-symbols-outlined text-[18px]">arrow_back</span>
      Kembali ke Daftar Lapangan
    </a>

    <div class="grid grid-cols-1 gap-8 lg:grid-cols-5">

      <!-- ========== Kolom Kiri: Gambar ========== -->
      <div class="lg:col-span-3">
        <div class="overflow-hidden rounded-2xl border border-black/10 bg-white shadow-md">
          <div class="relative h-72 w-full overflow-hidden sm:h-96">
            <img src="/images/<?= htmlspecialchars($gambar) ?>"
                 alt="<?= htmlspecialchars($lapangan['name']) ?>"
                 class="h-full w-full object-cover">
            <!-- Badge jenis olahraga -->
            <span class="absolute left-4 top-4 rounded-full bg-brand px-4 py-1.5 text-sm font-extrabold uppercase tracking-wide text-ink shadow">
              <?= htmlspecialchars($lapangan['sport_type']) ?>
            </span>
          </div>

          <!-- Deskripsi -->
          <?php if (!empty($lapangan['description'])): ?>
            <div class="p-6">
              <h2 class="mb-2 text-sm font-extrabold uppercase tracking-wider text-steel">Tentang Lapangan</h2>
              <p class="leading-relaxed text-steel">
                <?= nl2br(htmlspecialchars($lapangan['description'])) ?>
              </p>
            </div>
          <?php endif; ?>
        </div>

        <!-- Fasilitas -->
        <?php if (!empty($fasilitas)): ?>
          <div class="mt-6 rounded-2xl border border-black/10 bg-white p-6 shadow-sm">
            <h2 class="mb-4 text-sm font-extrabold uppercase tracking-wider text-steel">
              <span class="material-symbols-outlined align-middle text-[18px] text-brand">verified</span>
              Fasilitas
            </h2>
            <div class="grid grid-cols-2 gap-3 sm:grid-cols-3">
              <?php foreach ($fasilitas as $f): ?>
                <div class="flex items-center gap-2 rounded-xl bg-snow px-3 py-2.5">
                  <span class="material-symbols-outlined text-[16px] text-brand">check_circle</span>
                  <span class="text-sm font-semibold text-ink"><?= htmlspecialchars($f) ?></span>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        <?php endif; ?>
      </div>

      <!-- ========== Kolom Kanan: Info & Tombol ========== -->
      <div class="lg:col-span-2">
        <div class="sticky top-28 space-y-5">

          <!-- Kartu nama & harga -->
          <div class="rounded-2xl border border-black/10 bg-white p-6 shadow-md">
            <p class="text-xs font-bold uppercase tracking-wider text-steel">Lapangan Olahraga</p>
            <h1 class="mt-1 text-2xl font-extrabold leading-snug tracking-tight text-ink">
              <?= htmlspecialchars($lapangan['name']) ?>
            </h1>

            <!-- Harga -->
            <div class="mt-5 rounded-xl border border-brand/30 bg-brand/10 px-5 py-4">
              <p class="text-xs font-bold uppercase tracking-wider text-steel">Harga Sewa</p>
              <p class="mt-1 text-3xl font-extrabold text-ink">
                Rp <?= number_format($lapangan['price_per_hour'], 0, ',', '.') ?>
                <span class="text-base font-normal text-steel">/ jam</span>
              </p>
              <p class="mt-1 text-xs text-steel">Total harga dihitung otomatis saat booking</p>
            </div>

            <!-- Tombol Pesan -->
            <?php
              $isLoggedIn = isset($_SESSION['user']);
              $userRole   = $_SESSION['user']['role'] ?? null;
            ?>
            <?php if ($isLoggedIn && $userRole === 'customer'): ?>
              <!-- Sudah login sebagai customer → langsung ke halaman booking -->
              <a href="/booking?court_id=<?= (int)$lapangan['id'] ?>"
                 class="mt-5 flex w-full items-center justify-center gap-2 rounded-xl bg-brand py-4 text-base font-bold text-ink shadow-md transition hover:scale-[1.01] hover:bg-brand-hover">
                <span class="material-symbols-outlined text-[22px]">receipt_long</span>
                Pesan Lapangan Ini
              </a>
            <?php elseif ($isLoggedIn && $userRole === 'admin'): ?>
              <!-- Admin → tombol Edit Lapangan -->
              <a href="/admin/courts"
                 class="mt-5 flex w-full items-center justify-center gap-2 rounded-xl bg-ink py-4 text-base font-bold text-brand shadow-md transition hover:scale-[1.01] hover:bg-brand hover:text-ink">
                <span class="material-symbols-outlined text-[20px]">edit</span>
                Edit Lapangan Ini
              </a>
              <p class="mt-2 text-center text-xs text-steel">
                Kamu masuk sebagai <span class="font-bold text-ink">Admin</span>
              </p>
            <?php else: ?>
              <!-- Belum login → tombol tetap "Pesan", tapi redirect ke login -->
              <a href="/login"
                 class="mt-5 flex w-full items-center justify-center gap-2 rounded-xl bg-brand py-4 text-base font-bold text-ink shadow-md transition hover:scale-[1.01] hover:bg-brand-hover">
                <span class="material-symbols-outlined text-[22px]">receipt_long</span>
                Pesan Lapangan Ini
              </a>
              <p class="mt-2 text-center text-xs text-steel">
                Kamu perlu
                <a href="/login" class="font-bold text-ink hover:underline">login</a>
                atau
                <a href="/register" class="font-bold text-ink hover:underline">daftar gratis</a>
                untuk memesan.
              </p>
            <?php endif; ?>
          </div>

          <!-- Info singkat -->
          <div class="rounded-2xl border border-black/10 bg-white p-5 shadow-sm">
            <h2 class="mb-3 text-sm font-extrabold uppercase tracking-wider text-steel">Info Singkat</h2>
            <ul class="space-y-3">
              <li class="flex items-center gap-3 text-sm">
                <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-snow text-ink">
                  <span class="material-symbols-outlined text-[18px] text-brand">sports_score</span>
                </span>
                <div>
                  <p class="text-xs text-steel">Jenis Olahraga</p>
                  <p class="font-semibold text-ink"><?= htmlspecialchars($lapangan['sport_type']) ?></p>
                </div>
              </li>
              <li class="flex items-center gap-3 text-sm">
                <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-snow">
                  <span class="material-symbols-outlined text-[18px] text-brand">schedule</span>
                </span>
                <div>
                  <p class="text-xs text-steel">Jam Operasional</p>
                  <p class="font-semibold text-ink">07.00 – 22.00 WIB</p>
                </div>
              </li>
              <li class="flex items-center gap-3 text-sm">
                <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-snow">
                  <span class="material-symbols-outlined text-[18px] text-brand">timer</span>
                </span>
                <div>
                  <p class="text-xs text-steel">Minimum Sewa</p>
                  <p class="font-semibold text-ink">1 jam</p>
                </div>
              </li>
            </ul>
          </div>

        </div>
      </div>
    </div>

  </div>
</main>

<?php require __DIR__ . '/../layout/footer.php'; ?>
