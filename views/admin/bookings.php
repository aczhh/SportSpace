<?php
// Ambil data yang dikirim controller
$daftarBooking = $daftarBooking ?? [];
$sukses        = $sukses        ?? null;

// Label warna badge status
$warnaBadge = [
    'pending'   => 'bg-yellow-100 text-yellow-800',
    'confirmed' => 'bg-green-100 text-green-800',
    'cancelled' => 'bg-red-100 text-red-800',
];

require __DIR__ . '/../layout/header.php';
?>

<main class="min-h-screen bg-snow pt-28 pb-16">
  <div class="mx-auto max-w-6xl px-4 sm:px-6">

    <!-- Judul halaman -->
    <div class="mb-8 flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">
      <div>
        <h1 class="text-3xl font-extrabold tracking-tight text-ink">Kelola Booking</h1>
        <p class="mt-1 text-steel">Lihat dan ubah status semua pemesanan dari customer.</p>
      </div>
      <a href="/admin"
         class="inline-flex items-center gap-1 self-start rounded-xl border border-black/10 bg-white px-4 py-2 text-sm font-bold text-ink shadow-sm transition hover:bg-ink hover:text-brand sm:self-auto">
        <span class="material-symbols-outlined text-[18px]">dashboard</span>
        Dashboard
      </a>
    </div>

    <!-- Pesan sukses setelah update status -->
    <?php if ($sukses): ?>
      <div class="mb-6 flex items-center gap-3 rounded-xl border border-green-200 bg-green-50 p-4 text-sm font-semibold text-green-800">
        <span class="material-symbols-outlined text-[20px]">check_circle</span>
        <?= htmlspecialchars($sukses) ?>
      </div>
    <?php endif; ?>

    <!-- Tabel semua booking -->
    <div class="overflow-hidden rounded-2xl border border-black/10 bg-white shadow-sm">
      <div class="overflow-x-auto">
        <table class="w-full text-sm">
          <thead class="border-b border-black/10 bg-snow text-xs font-extrabold uppercase tracking-wider text-steel">
            <tr>
              <th class="px-5 py-4 text-left">Customer</th>
              <th class="px-5 py-4 text-left">Lapangan</th>
              <th class="px-5 py-4 text-left">Tanggal</th>
              <th class="px-5 py-4 text-left">Jam & Durasi</th>
              <th class="px-5 py-4 text-left">Total Harga</th>
              <th class="px-5 py-4 text-left">Status</th>
              <th class="px-5 py-4 text-left">Ubah Status</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-black/5">
            <?php if (empty($daftarBooking)): ?>
              <tr>
                <td colspan="7" class="px-5 py-12 text-center text-steel">
                  Belum ada data pemesanan.
                </td>
              </tr>
            <?php else: ?>
              <?php foreach ($daftarBooking as $booking): ?>
                <tr class="transition hover:bg-snow/60">

                  <!-- Nama customer -->
                  <td class="px-5 py-4 font-semibold text-ink">
                    <?= htmlspecialchars($booking['nama_customer']) ?>
                  </td>

                  <!-- Nama & jenis lapangan -->
                  <td class="px-5 py-4">
                    <div class="font-semibold text-ink"><?= htmlspecialchars($booking['nama_lapangan']) ?></div>
                    <div class="text-xs text-steel"><?= htmlspecialchars($booking['jenis_olahraga']) ?></div>
                  </td>

                  <!-- Tanggal -->
                  <td class="px-5 py-4 text-steel">
                    <?= date('d M Y', strtotime($booking['booking_date'])) ?>
                  </td>

                  <!-- Jam mulai & durasi -->
                  <td class="px-5 py-4 text-steel">
                    <?= date('H.i', strtotime($booking['start_time'])) ?> WIB
                    <span class="text-xs">(<?= (int)$booking['duration'] ?> jam)</span>
                  </td>

                  <!-- Total harga -->
                  <td class="px-5 py-4 font-bold text-ink">
                    Rp <?= number_format($booking['total_price'], 0, ',', '.') ?>
                  </td>

                  <!-- Badge status saat ini -->
                  <td class="px-5 py-4">
                    <?php $kelasWarna = $warnaBadge[$booking['status']] ?? 'bg-snow text-steel'; ?>
                    <span class="rounded-full px-3 py-1 text-xs font-extrabold capitalize <?= $kelasWarna ?>">
                      <?= htmlspecialchars($booking['status']) ?>
                    </span>
                  </td>

                  <!-- Form ubah status -->
                  <td class="px-5 py-4">
                    <form action="/admin/bookings/update-status" method="POST"
                          class="flex items-center gap-2">
                      <input type="hidden" name="booking_id" value="<?= (int)$booking['id'] ?>">
                      <select
                        name="status"
                        class="cursor-pointer rounded-lg border border-black/10 bg-snow px-2.5 py-1.5 text-xs font-semibold text-ink outline-none focus:ring-2 focus:ring-brand"
                      >
                        <option value="pending"   <?= $booking['status'] === 'pending'   ? 'selected' : '' ?>>Pending</option>
                        <option value="confirmed" <?= $booking['status'] === 'confirmed' ? 'selected' : '' ?>>Confirmed</option>
                        <option value="cancelled" <?= $booking['status'] === 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                      </select>
                      <button type="submit"
                              class="rounded-lg bg-ink px-3 py-1.5 text-xs font-bold text-brand transition hover:bg-brand hover:text-ink">
                        Simpan
                      </button>
                    </form>
                  </td>

                </tr>
              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>

  </div>
</main>

<?php require __DIR__ . '/../layout/footer.php'; ?>

