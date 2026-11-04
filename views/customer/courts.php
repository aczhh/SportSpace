<?php
// =============================================
// VIEW: Daftar Lapangan
// Tanggung jawab: Anggota 2
// Variabel dari CourtController:
//   $courts      = array daftar lapangan
//   $sportCounts = ['Futsal' => 4, 'Badminton' => 3, ...]
//   $filterSport = string filter olahraga aktif
//   $filterNama  = string filter nama aktif
// =============================================

$courts      = $courts      ?? [];
$sportCounts = $sportCounts ?? [];
$filterSport = trim($_GET['sport'] ?? '');
$filterNama  = trim($_GET['q']     ?? '');
$sports      = ['Futsal', 'Badminton', 'Basket'];

require __DIR__ . '/../layout/header.php';
?>

<main class="min-h-screen bg-snow pt-28 pb-16">
  <div class="mx-auto max-w-6xl px-4 sm:px-6">

    <!-- Judul halaman -->
    <div class="mb-8">
      <h1 class="text-3xl font-extrabold tracking-tight text-ink">Daftar Lapangan</h1>
      <p class="mt-1 text-steel">Pilih lapangan, cek fasilitas dan harga, lalu langsung pesan.</p>
    </div>

    <!-- Filter & Pencarian -->
    <form action="/courts" method="GET"
          class="mb-8 flex flex-col gap-3 rounded-2xl border border-black/10 bg-white p-5 shadow-sm sm:flex-row sm:items-end">

      <!-- Filter jenis olahraga -->
      <div class="flex flex-col gap-1.5">
        <label for="sport" class="text-xs font-bold uppercase tracking-wider text-steel">
          Jenis Olahraga
        </label>
        <select id="sport" name="sport"
                class="cursor-pointer rounded-xl border border-black/10 bg-snow px-3.5 py-2.5 text-sm font-semibold text-ink outline-none focus:ring-2 focus:ring-brand">
          <option value="">Semua Olahraga</option>
          <?php foreach ($sports as $namaOlahraga): ?>
            <option value="<?= $namaOlahraga ?>"
              <?= $filterSport === $namaOlahraga ? 'selected' : '' ?>>
              <?= $namaOlahraga ?> (<?= (int)($sportCounts[$namaOlahraga] ?? 0) ?>)
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <!-- Input cari nama lapangan -->
      <div class="flex flex-1 flex-col gap-1.5">
        <label for="q" class="text-xs font-bold uppercase tracking-wider text-steel">
          Nama Lapangan
        </label>
        <input id="q" name="q" type="text" value="<?= htmlspecialchars($filterNama) ?>"
               placeholder="Contoh: Arena Garuda..."
               class="w-full rounded-xl border border-black/10 bg-snow px-3.5 py-2.5 text-sm text-ink outline-none focus:ring-2 focus:ring-brand">
      </div>

      <!-- Tombol cari & reset -->
      <div class="flex gap-2">
        <button type="submit"
                class="flex h-10 items-center gap-2 rounded-xl bg-ink px-5 text-sm font-bold text-brand transition hover:bg-brand hover:text-ink">
          <span class="material-symbols-outlined text-[18px]">search</span>
          Cari
        </button>
        <?php if ($filterSport !== '' || $filterNama !== ''): ?>
          <a href="/courts"
             class="flex h-10 items-center gap-1 rounded-xl border border-black/10 bg-snow px-4 text-sm font-semibold text-steel transition hover:bg-black/5">
            Reset
          </a>
        <?php endif; ?>
      </div>
    </form>

    <!-- Tab filter cepat olahraga -->
    <div class="mb-6 flex flex-wrap gap-2">
      <a href="/courts"
         class="rounded-full px-5 py-2 text-sm font-bold transition
                <?= $filterSport === '' ? 'bg-ink text-brand' : 'bg-white text-ink hover:bg-brand' ?>">
        Semua
      </a>
      <?php foreach ($sports as $namaOlahraga): ?>
        <a href="/courts?sport=<?= $namaOlahraga ?>"
           class="rounded-full px-5 py-2 text-sm font-bold transition
                  <?= $filterSport === $namaOlahraga ? 'bg-ink text-brand' : 'bg-white text-ink hover:bg-brand' ?>">
          <?= $namaOlahraga ?>
        </a>
      <?php endforeach; ?>
    </div>

    <!-- Info jumlah hasil -->
    <p class="mb-5 text-sm text-steel">
      Menampilkan <span class="font-bold text-ink"><?= count($courts) ?></span> lapangan
      <?php if ($filterSport !== '' || $filterNama !== ''): ?>
        dari pencarian:
        <?php if ($filterSport !== ''): ?>
          <span class="font-semibold text-ink"><?= htmlspecialchars($filterSport) ?></span>
        <?php endif; ?>
        <?php if ($filterNama !== ''): ?>
          "<?= htmlspecialchars($filterNama) ?>"
        <?php endif; ?>
      <?php endif; ?>
    </p>

    <!-- Grid kartu lapangan -->
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
      <?php if (!empty($courts)): ?>
        <?php foreach ($courts as $lapangan):
          $gambar    = !empty($lapangan['image']) ? $lapangan['image'] : 'court.jpg';
          $fasilitas = array_slice(
            array_filter(array_map('trim', explode(',', (string)$lapangan['facilities']))),
            0, 4
          );
        ?>
          <article class="group flex flex-col overflow-hidden rounded-2xl border border-black/10 bg-white shadow-md transition-all duration-300 hover:border-brand hover:shadow-xl">

            <!-- Gambar lapangan -->
            <a href="/courts/detail?id=<?= (int)$lapangan['id'] ?>"
               class="relative block h-52 w-full overflow-hidden bg-snow">
              <img src="/images/<?= htmlspecialchars($gambar) ?>"
                   alt="<?= htmlspecialchars($lapangan['name']) ?>"
                   class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105">
              <!-- Badge jenis olahraga -->
              <span class="absolute left-3 top-3 rounded-full bg-brand px-3 py-1 text-[11px] font-extrabold uppercase tracking-wide text-ink shadow">
                <?= htmlspecialchars($lapangan['sport_type']) ?>
              </span>
            </a>

            <!-- Info lapangan -->
            <div class="flex flex-1 flex-col justify-between space-y-3 p-5">
              <div>
                <h2 class="text-lg font-bold leading-snug text-ink">
                  <?= htmlspecialchars($lapangan['name']) ?>
                </h2>
                <?php if (!empty($lapangan['description'])): ?>
                  <p class="mt-1 line-clamp-2 text-sm text-steel">
                    <?= htmlspecialchars($lapangan['description']) ?>
                  </p>
                <?php endif; ?>
              </div>

              <!-- Daftar fasilitas (maks 4) -->
              <?php if (!empty($fasilitas)): ?>
                <div class="flex flex-wrap gap-1.5">
                  <?php foreach ($fasilitas as $f): ?>
                    <span class="rounded-md bg-snow px-2 py-0.5 text-[11px] font-semibold text-steel">
                      <?= htmlspecialchars($f) ?>
                    </span>
                  <?php endforeach; ?>
                </div>
              <?php endif; ?>

              <!-- Harga & tombol -->
              <div class="flex items-center justify-between border-t border-black/5 pt-3">
                <div>
                  <span class="text-[11px] font-bold uppercase text-steel">Harga</span>
                  <div class="font-bold text-ink">
                    Rp <?= number_format($lapangan['price_per_hour'], 0, ',', '.') ?>
                    <span class="text-xs font-normal text-steel">/ jam</span>
                  </div>
                </div>
                <div class="flex gap-2">
                  <a href="/courts/detail?id=<?= (int)$lapangan['id'] ?>"
                     class="rounded-xl border border-black/10 bg-snow px-3.5 py-2 text-xs font-bold text-ink transition hover:bg-black/5">
                    Detail
                  </a>
                  <a href="/booking?court_id=<?= (int)$lapangan['id'] ?>"
                     class="rounded-xl bg-ink px-3.5 py-2 text-xs font-bold text-brand shadow-sm transition hover:bg-brand hover:text-ink">
                    Pesan
                  </a>
                </div>
              </div>
            </div>

          </article>
        <?php endforeach; ?>
      <?php else: ?>
        <!-- Jika tidak ada lapangan yang cocok -->
        <div class="col-span-3 flex flex-col items-center justify-center gap-4 rounded-2xl border border-dashed border-black/15 bg-white py-20 text-center">
          <span class="material-symbols-outlined text-[48px] text-steel/40">search_off</span>
          <div>
            <p class="font-bold text-ink">Tidak ada lapangan yang ditemukan.</p>
            <p class="mt-1 text-sm text-steel">Coba ubah filter atau kata pencarian kamu.</p>
          </div>
          <a href="/courts" class="rounded-xl bg-ink px-5 py-2.5 text-sm font-bold text-brand transition hover:bg-brand hover:text-ink">
            Lihat Semua Lapangan
          </a>
        </div>
      <?php endif; ?>
    </div>

  </div>
</main>

<?php require __DIR__ . '/../layout/footer.php'; ?>
