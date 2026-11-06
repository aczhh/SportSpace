<?php
// Ambil data yang dikirim controller
$lapangan    = $lapangan    ?? [];
$pesan_error = $pesan_error ?? null;

require __DIR__ . '/../layout/header.php';
?>

<main class="flex-1 bg-snow pt-28 pb-16">
  <div class="mx-auto max-w-2xl px-4 sm:px-6">

    <!-- Judul halaman -->
    <div class="mb-8">
      <a href="/courts/detail?id=<?= (int)$lapangan['id'] ?>"
         class="mb-3 inline-flex items-center gap-1 text-sm font-semibold text-steel transition hover:text-ink">
        <span class="material-symbols-outlined text-[18px]">arrow_back</span>
        Kembali ke Detail Lapangan
      </a>
      <h1 class="text-3xl font-extrabold tracking-tight text-ink">Form Pemesanan</h1>
      <p class="mt-1 text-steel">Isi data di bawah untuk memesan lapangan.</p>
    </div>

    <!-- Info lapangan yang dipilih -->
    <div class="mb-6 flex items-center gap-4 rounded-2xl border border-black/10 bg-white p-5 shadow-sm">
      <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-xl bg-brand text-ink shadow">
        <span class="material-symbols-outlined text-[28px]">stadium</span>
      </div>
      <div>
        <p class="text-xs font-bold uppercase tracking-wider text-steel">Lapangan yang dipesan</p>
        <h2 class="text-lg font-extrabold text-ink"><?= htmlspecialchars($lapangan['name']) ?></h2>
        <div class="flex items-center gap-3 text-sm text-steel">
          <span><?= htmlspecialchars($lapangan['sport_type']) ?></span>
          <span>·</span>
          <span class="font-semibold text-ink">
            Rp <?= number_format($lapangan['price_per_hour'], 0, ',', '.') ?> / jam
          </span>
        </div>
      </div>
    </div>

    <!-- Tampilkan pesan error kalau ada -->
    <?php if ($pesan_error): ?>
      <div class="mb-5 flex items-start gap-3 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
        <span class="material-symbols-outlined shrink-0 text-[20px]">error</span>
        <?= htmlspecialchars($pesan_error) ?>
      </div>
    <?php endif; ?>

    <!-- Form booking -->
    <form action="/booking/store" method="POST"
          class="space-y-5 rounded-2xl border border-black/10 bg-white p-6 shadow-md sm:p-8">

      <!-- Field tersembunyi: id lapangan -->
      <input type="hidden" name="court_id" value="<?= (int)$lapangan['id'] ?>">

      <!-- Tanggal main -->
      <div class="flex flex-col gap-1.5">
        <label for="booking_date" class="flex items-center gap-1.5 text-sm font-bold text-ink">
          <span class="material-symbols-outlined text-[20px] text-brand">calendar_month</span>
          Tanggal Main
        </label>
        <input
          id="booking_date"
          type="date"
          name="booking_date"
          min="<?= date('Y-m-d') ?>"
          required
          class="w-full rounded-xl border border-black/10 bg-snow px-4 py-3 text-sm text-ink outline-none focus:ring-2 focus:ring-brand"
        >
      </div>

      <!-- Jam mulai -->
      <div class="flex flex-col gap-1.5">
        <label for="start_time" class="flex items-center gap-1.5 text-sm font-bold text-ink">
          <span class="material-symbols-outlined text-[20px] text-brand">schedule</span>
          Jam Mulai
        </label>
        <select
          id="start_time"
          name="start_time"
          required
          class="w-full cursor-pointer rounded-xl border border-black/10 bg-snow px-4 py-3 text-sm text-ink outline-none focus:ring-2 focus:ring-brand"
        >
          <option value="">-- Pilih jam mulai --</option>
          <?php
          // Buat pilihan jam dari 07:00 sampai 21:00
          for ($jam = 7; $jam <= 21; $jam++):
            $nilai = sprintf('%02d:00', $jam);
            $label = sprintf('%02d.00', $jam);
          ?>
            <option value="<?= $nilai ?>"><?= $label ?> WIB</option>
          <?php endfor; ?>
        </select>
      </div>

      <!-- Durasi main -->
      <div class="flex flex-col gap-1.5">
        <label for="duration" class="flex items-center gap-1.5 text-sm font-bold text-ink">
          <span class="material-symbols-outlined text-[20px] text-brand">timer</span>
          Durasi Main
        </label>
        <select
          id="duration"
          name="duration"
          required
          class="w-full cursor-pointer rounded-xl border border-black/10 bg-snow px-4 py-3 text-sm text-ink outline-none focus:ring-2 focus:ring-brand"
        >
          <option value="">-- Pilih durasi --</option>
          <?php for ($jam = 1; $jam <= 8; $jam++): ?>
            <option value="<?= $jam ?>"><?= $jam ?> jam</option>
          <?php endfor; ?>
        </select>
      </div>

      <!-- Preview total harga (dihitung otomatis via JS) -->
      <div class="rounded-xl border border-brand/30 bg-brand/10 p-4">
        <p class="text-xs font-bold uppercase tracking-wider text-steel">Estimasi Total Harga</p>
        <p id="preview-harga" class="mt-1 text-2xl font-extrabold text-ink">
          Rp —
        </p>
        <p class="text-xs text-steel">Harga dihitung: harga/jam × durasi</p>
      </div>

      <!-- Tombol submit -->
      <button type="submit"
              class="flex w-full items-center justify-center gap-2 rounded-xl bg-brand py-4 text-base font-bold text-ink shadow-md transition hover:scale-[1.01] hover:bg-brand-hover">
        <span class="material-symbols-outlined text-[22px]">receipt_long</span>
        Pesan Sekarang
      </button>
    </form>

  </div>
</main>

<!-- Script: hitung total harga otomatis saat pilih durasi -->
<script>
  const hargaPerJam = <?= (int)$lapangan['price_per_hour'] ?>;

  const selectDurasi = document.getElementById('duration');
  const elPreview    = document.getElementById('preview-harga');

  selectDurasi.addEventListener('change', function () {
    const durasi = parseInt(this.value);

    if (isNaN(durasi) || durasi < 1) {
      elPreview.textContent = 'Rp —';
      return;
    }

    const total = hargaPerJam * durasi;

    // Format angka ke format Rupiah (pakai toLocaleString)
    elPreview.textContent = 'Rp ' + total.toLocaleString('id-ID');
  });
</script>

<?php require __DIR__ . '/../layout/footer.php'; ?>

