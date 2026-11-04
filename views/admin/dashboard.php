<?php
// Ambil data yang dikirim controller
$jumlahLapangan   = $jumlahLapangan   ?? 0;
$jumlahBooking    = $jumlahBooking    ?? 0;
$bookingPerStatus = $bookingPerStatus ?? ['pending' => 0, 'confirmed' => 0, 'cancelled' => 0];

require __DIR__ . '/../layout/header.php';
?>

<main class="min-h-screen bg-snow pt-28 pb-16">
  <div class="mx-auto max-w-5xl px-4 sm:px-6">

    <!-- Judul halaman -->
    <div class="mb-10">
      <h1 class="text-3xl font-extrabold tracking-tight text-ink">Dashboard Admin</h1>
      <p class="mt-1 text-steel">Selamat datang, Admin. Ini ringkasan data SportSpace.</p>
    </div>

    <!-- ========== Kartu ringkasan data ========== -->
    <?php
    // Data kartu ringkasan: [icon, jumlah, label, warna_bg_icon]
    $kartuRingkasan = [
      ['stadium',       $jumlahLapangan,                'Total Lapangan',      'bg-brand'],
      ['receipt_long',  $jumlahBooking,                  'Total Booking',        'bg-blue-400'],
      ['pending_actions',$bookingPerStatus['pending'],   'Booking Pending',     'bg-yellow-400'],
      ['check_circle',  $bookingPerStatus['confirmed'],  'Booking Confirmed',   'bg-green-400'],
    ];
    ?>

    <div class="mb-10 grid grid-cols-2 gap-4 sm:grid-cols-4">
      <?php foreach ($kartuRingkasan as [$icon, $jumlah, $label, $warnaBg]): ?>
        <div class="flex flex-col gap-3 rounded-2xl border border-black/10 bg-white p-5 shadow-sm">
          <div class="flex h-11 w-11 items-center justify-center rounded-xl <?= $warnaBg ?> text-ink shadow">
            <span class="material-symbols-outlined text-[22px]"><?= $icon ?></span>
          </div>
          <div>
            <div class="text-3xl font-extrabold tracking-tight text-ink"><?= $jumlah ?></div>
            <div class="text-xs font-semibold text-steel"><?= $label ?></div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

    <!-- ========== Menu navigasi admin ========== -->
    <h2 class="mb-4 text-lg font-extrabold text-ink">Menu Pengelolaan</h2>

    <?php
    // Daftar menu admin: [icon, judul, deskripsi, link, warna_icon]
    $menuAdmin = [
      [
        'icon'  => 'stadium',
        'judul' => 'Kelola Lapangan',
        'desc'  => 'Tambah, ubah, dan hapus data lapangan olahraga.',
        'link'  => '/admin/courts',
        'warna' => 'text-brand',
      ],
      [
        'icon'  => 'receipt_long',
        'judul' => 'Kelola Booking',
        'desc'  => 'Lihat semua pemesanan dan ubah statusnya.',
        'link'  => '/admin/bookings',
        'warna' => 'text-blue-500',
      ],
    ];
    ?>

    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
      <?php foreach ($menuAdmin as $menu): ?>
        <a href="<?= $menu['link'] ?>"
           class="group flex items-center gap-5 rounded-2xl border border-black/10 bg-white p-6 shadow-sm transition hover:border-brand hover:shadow-md">

          <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-snow shadow-inner">
            <span class="material-symbols-outlined text-[30px] <?= $menu['warna'] ?>"><?= $menu['icon'] ?></span>
          </div>

          <div class="flex-1">
            <h3 class="font-extrabold text-ink transition group-hover:text-brand"><?= $menu['judul'] ?></h3>
            <p class="text-sm text-steel"><?= $menu['desc'] ?></p>
          </div>

          <span class="material-symbols-outlined text-[22px] text-steel/40 transition group-hover:text-brand">
            arrow_forward
          </span>
        </a>
      <?php endforeach; ?>
    </div>

  </div>
</main>

<?php require __DIR__ . '/../layout/footer.php'; ?>

