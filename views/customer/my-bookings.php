<?php
// Ambil data yang dikirim controller
$daftarBooking = $daftarBooking ?? [];
$sukses        = $sukses        ?? null;

// Label warna badge berdasarkan status booking
$warnaBadge = [
    'pending'   => 'bg-yellow-100 text-yellow-800',
    'confirmed' => 'bg-green-100 text-green-800',
    'cancelled' => 'bg-red-100 text-red-800',
];

require __DIR__ . '/../layout/header.php';
?>

<main class="min-h-screen bg-snow pt-28 pb-16">
  <div class="mx-auto max-w-5xl px-4 sm:px-6">

    <!-- Judul halaman -->
    <div class="mb-8">
      <h1 class="text-3xl font-extrabold tracking-tight text-ink">My Booking</h1>
      <p class="mt-1 text-steel">Riwayat semua pemesanan lapangan yang sudah kamu buat.</p>
    </div>

    <!-- Pesan sukses setelah booking berhasil -->
    <?php if ($sukses): ?>
      <div class="mb-6 flex items-center gap-3 rounded-xl border border-green-200 bg-green-50 p-4 text-sm font-semibold text-green-800">
        <span class="material-symbols-outlined text-[20px]">check_circle</span>
        <?= htmlspecialchars($sukses) ?>
      </div>
    <?php endif; ?>

    <!-- Kalau tidak ada booking -->
    <?php if (empty($daftarBooking)): ?>
      <div class="flex flex-col items-center gap-4 rounded-2xl border border-black/10 bg-white py-20 text-center shadow-sm">
        <span class="material-symbols-outlined text-[56px] text-steel/40">receipt_long</span>
        <div>
          <p class="text-lg font-bold text-ink">Belum ada pemesanan</p>
          <p class="text-sm text-steel">Kamu belum pernah memesan lapangan.</p>
        </div>
        <a href="/courts"
           class="inline-flex items-center gap-2 rounded-xl bg-brand px-6 py-3 text-sm font-bold text-ink transition hover:bg-brand-hover">
          <span class="material-symbols-outlined text-[18px]">search</span>
          Cari Lapangan
        </a>
      </div>

    <?php else: ?>

      <!-- Tabel daftar booking -->
      <div class="overflow-hidden rounded-2xl border border-black/10 bg-white shadow-sm">
        <div class="overflow-x-auto">
          <table class="w-full text-sm">
            <thead class="border-b border-black/10 bg-snow text-xs font-extrabold uppercase tracking-wider text-steel">
              <tr>
                <th class="px-5 py-4 text-left">Lapangan</th>
                <th class="px-5 py-4 text-left">Jenis</th>
                <th class="px-5 py-4 text-left">Tanggal</th>
                <th class="px-5 py-4 text-left">Jam Mulai</th>
                <th class="px-5 py-4 text-left">Durasi</th>
                <th class="px-5 py-4 text-left">Total Harga</th>
                <th class="px-5 py-4 text-left">Status</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-black/5">
              <?php foreach ($daftarBooking as $booking): ?>
                <tr class="transition hover:bg-snow/60">

                  <!-- Nama lapangan -->
                  <td class="px-5 py-4 font-semibold text-ink">
                    <?= htmlspecialchars($booking['nama_lapangan']) ?>
                  </td>

                  <!-- Jenis olahraga -->
                  <td class="px-5 py-4 text-steel">
                    <?= htmlspecialchars($booking['jenis_olahraga']) ?>
                  </td>

                  <!-- Tanggal main -->
                  <td class="px-5 py-4 text-steel">
                    <?= date('d M Y', strtotime($booking['booking_date'])) ?>
                  </td>

                  <!-- Jam mulai -->
                  <td class="px-5 py-4 text-steel">
                    <?= date('H.i', strtotime($booking['start_time'])) ?> WIB
                  </td>

                  <!-- Durasi -->
                  <td class="px-5 py-4 text-steel">
                    <?= (int)$booking['duration'] ?> jam
                  </td>

                  <!-- Total harga -->
                  <td class="px-5 py-4 font-bold text-ink">
                    Rp <?= number_format($booking['total_price'], 0, ',', '.') ?>
                  </td>

                  <!-- Status badge -->
                  <td class="px-5 py-4">
                    <?php $kelasWarna = $warnaBadge[$booking['status']] ?? 'bg-snow text-steel'; ?>
                    <span class="rounded-full px-3 py-1 text-xs font-extrabold capitalize <?= $kelasWarna ?>">
                      <?= htmlspecialchars($booking['status']) ?>
                    </span>
                  </td>

                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Tombol booking lagi -->
      <div class="mt-6">
        <a href="/courts"
           class="inline-flex items-center gap-2 rounded-xl bg-brand px-6 py-3 text-sm font-bold text-ink shadow-md transition hover:bg-brand-hover">
          <span class="material-symbols-outlined text-[18px]">add_circle</span>
          Booking Lapangan Lagi
        </a>
      </div>

    <?php endif; ?>

  </div>
</main>

<?php require __DIR__ . '/../layout/footer.php'; ?>

