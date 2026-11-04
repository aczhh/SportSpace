<?php
// Ambil data yang dikirim controller (dengan nilai default kalau belum ada)
$courts      = $courts      ?? [];
$sportCounts = $sportCounts ?? [];
$sports      = ['Futsal', 'Badminton', 'Basket'];
$totalLapangan = array_sum($sportCounts);

require __DIR__ . '/../layout/header.php';
?>

<main class="w-full">

  <!-- ==========================================
       SEKSI HERO
       Latar foto lapangan + overlay gelap + lime
       ========================================== -->
  <section class="relative flex min-h-[780px] items-center justify-center overflow-hidden bg-ink px-4 pb-20 pt-32">

    <!-- Latar belakang: foto + overlay gelap -->
    <div class="absolute inset-0">
      <img src="/images/bg.jpg" alt="Lapangan olahraga" class="h-full w-full object-cover object-center">
      <div class="absolute inset-0 bg-gradient-to-b from-ink/90 via-ink/70 to-ink/95"></div>
      <!-- Efek cahaya hijau di tengah atas -->
      <div class="pointer-events-none absolute -top-40 left-1/2 h-[500px] w-[700px] -translate-x-1/2 rounded-full bg-brand/15 blur-3xl"></div>
    </div>

    <!-- Konten hero -->
    <div class="relative z-10 mx-auto flex max-w-5xl flex-col items-center space-y-7 text-center">

      <!-- Tagline kecil di atas judul -->
      <span class="inline-block rounded-full border border-brand/30 bg-brand/10 px-4 py-1.5 text-xs font-extrabold uppercase tracking-widest text-brand">
        Platform Booking Lapangan Olahraga
      </span>

      <!-- Judul utama -->
      <h1 class="max-w-4xl text-4xl font-extrabold leading-[1.1] tracking-tight text-white drop-shadow-md sm:text-5xl md:text-6xl">
        Temukan Lapangan,
        <span class="text-brand underline decoration-brand decoration-[6px] underline-offset-4">Booking Langsung</span>
        di SportSpace
      </h1>

      <!-- Deskripsi singkat -->
      <p class="max-w-3xl text-base leading-relaxed text-snow/85 drop-shadow sm:text-lg md:text-xl">
        Lihat fasilitas dan harga lapangan futsal, badminton, atau basket.
        Pilih tanggal, jam, dan durasi main — pesan dalam hitungan menit, tanpa perlu chat admin.
      </p>

      <!-- Tombol CTA -->
      <div class="flex flex-wrap items-center justify-center gap-4 pt-1">
        <a href="/courts"
           class="inline-flex items-center gap-2 rounded-xl bg-brand px-8 py-4 text-base font-bold text-ink shadow-xl shadow-brand/25 transition hover:scale-[1.02] hover:bg-brand-hover">
          Lihat Semua Lapangan
          <span class="material-symbols-outlined text-[20px]">arrow_forward</span>
        </a>
        <a href="#cara-booking"
           class="inline-flex items-center gap-2 rounded-xl border border-white/20 bg-black/40 px-7 py-4 text-base font-bold text-white shadow-lg backdrop-blur-md transition hover:scale-[1.02] hover:bg-black/60">
          <span class="material-symbols-outlined text-[20px] text-brand">menu_book</span>
          Cara Booking
        </a>
      </div>

      <!-- Form pencarian cepat -->
      <div id="quick-search" class="mt-4 w-full max-w-4xl scroll-mt-28 rounded-2xl border border-white/40 bg-white/95 p-5 text-left shadow-2xl backdrop-blur-md sm:p-6">
        <form action="/courts" method="GET" class="grid grid-cols-1 items-end gap-3 md:grid-cols-4">

          <!-- Filter jenis olahraga -->
          <div class="flex flex-col gap-1.5">
            <label for="sport" class="flex items-center gap-1.5 text-[11px] font-bold uppercase tracking-wider text-steel">
              <span class="material-symbols-outlined text-[17px] text-ink">sports_tennis</span> Jenis Olahraga
            </label>
            <select id="sport" name="sport"
                    class="w-full cursor-pointer rounded-xl bg-snow px-3.5 py-3 text-sm font-semibold text-ink outline-none focus:ring-2 focus:ring-brand">
              <option value="">Semua olahraga</option>
              <?php foreach ($sports as $namaOlahraga): ?>
                <option value="<?= $namaOlahraga ?>"><?= $namaOlahraga ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <!-- Input nama lapangan -->
          <div class="flex flex-col gap-1.5">
            <label for="q" class="flex items-center gap-1.5 text-[11px] font-bold uppercase tracking-wider text-steel">
              <span class="material-symbols-outlined text-[17px] text-ink">search</span> Nama Lapangan
            </label>
            <input id="q" name="q" type="text" placeholder="Contoh: Arena Garuda"
                   class="w-full rounded-xl bg-snow px-3.5 py-3 text-sm font-semibold text-ink outline-none placeholder:font-normal placeholder:text-steel/60 focus:ring-2 focus:ring-brand">
          </div>

          <!-- Input tanggal main -->
          <div class="flex flex-col gap-1.5">
            <label for="date" class="flex items-center gap-1.5 text-[11px] font-bold uppercase tracking-wider text-steel">
              <span class="material-symbols-outlined text-[17px] text-ink">calendar_month</span> Tanggal Main
            </label>
            <input id="date" name="date" type="date" min="<?= date('Y-m-d') ?>"
                   class="w-full rounded-xl bg-snow px-3.5 py-2.5 text-sm font-semibold text-ink outline-none focus:ring-2 focus:ring-brand">
          </div>

          <!-- Tombol cari -->
          <button type="submit"
                  class="group flex h-12 w-full items-center justify-center gap-2 rounded-xl bg-brand text-sm font-bold text-ink shadow-md transition hover:scale-[1.02] hover:bg-brand-hover">
            <span class="material-symbols-outlined text-[20px] transition group-hover:rotate-12">search</span>
            Cari Lapangan
          </button>
        </form>

        <!-- Shortcut jenis olahraga & info total harga otomatis -->
        <div class="mt-4 flex flex-wrap items-center justify-between gap-2 border-t border-black/5 pt-3">
          <div class="flex flex-wrap items-center gap-2 text-xs text-steel">
            <span class="font-bold text-ink">Pilihan Cepat:</span>
            <?php foreach ($sports as $namaOlahraga): ?>
              <a href="/courts?sport=<?= $namaOlahraga ?>"
                 class="rounded-full bg-snow px-2.5 py-1 font-semibold text-ink transition hover:bg-brand">
                <?= $namaOlahraga ?>
              </a>
            <?php endforeach; ?>
          </div>
          <div class="flex items-center gap-1 text-xs font-bold text-ink">
            <span class="material-symbols-outlined rounded-full bg-ink p-0.5 text-[17px] text-brand">verified</span>
            Total harga dihitung otomatis
          </div>
        </div>
      </div>

      <!-- Statistik singkat: lapangan, cabang, booking online -->
      <div class="grid w-full max-w-4xl grid-cols-1 gap-4 pt-2 sm:grid-cols-3">
        <?php
        $statistik = [
          ['stadium',       (int)$totalLapangan, 'Lapangan Tersedia'],
          ['sports_score',  count($sports),       'Cabang Olahraga'],
          ['schedule',      '24 Jam',             'Booking Online'],
        ];
        foreach ($statistik as [$icon, $nilai, $label]):
        ?>
          <div class="flex items-center gap-3.5 rounded-2xl border border-white/10 bg-black/45 p-4 text-left shadow-lg backdrop-blur-md">
            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-brand text-ink shadow">
              <span class="material-symbols-outlined text-[22px]"><?= $icon ?></span>
            </div>
            <div>
              <div class="text-2xl font-extrabold tracking-tight text-white"><?= $nilai ?></div>
              <div class="text-xs font-semibold text-snow/80"><?= $label ?></div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>

    </div>
  </section>

  <!-- ==========================================
       SEKSI LAPANGAN TERBARU
       Menampilkan beberapa lapangan dari database
       ========================================== -->
  <section id="lapangan" class="w-full scroll-mt-20 border-y border-black/5 bg-white py-16 sm:py-24">
    <div class="mx-auto max-w-6xl space-y-10 px-4 sm:px-6">

      <!-- Filter cabang olahraga (tab) -->
      <div class="flex items-center gap-3 overflow-x-auto pb-2">
        <a href="/courts"
           class="flex shrink-0 items-center gap-2 rounded-full bg-ink px-5 py-2.5 text-sm font-bold text-brand shadow-sm">
          <span class="material-symbols-outlined text-[18px]">apps</span> Semua Cabang
        </a>
        <?php foreach ($sports as $namaOlahraga): ?>
          <a href="/courts?sport=<?= $namaOlahraga ?>"
             class="shrink-0 rounded-full bg-snow px-5 py-2.5 text-sm font-bold text-ink transition-colors hover:bg-brand">
            <?= $namaOlahraga ?>
            <span class="font-normal text-steel">(<?= (int)($sportCounts[$namaOlahraga] ?? 0) ?>)</span>
          </a>
        <?php endforeach; ?>
      </div>

      <!-- Judul seksi & link lihat semua -->
      <div class="flex flex-col justify-between gap-4 pt-2 md:flex-row md:items-end">
        <div>
          <div class="flex items-center gap-1.5 text-xs font-extrabold uppercase tracking-widest text-ink">
            <span class="h-2 w-2 rounded-full bg-brand"></span> Booking Online
          </div>
          <h2 class="mt-1 text-3xl font-extrabold tracking-tight text-ink sm:text-4xl">Lapangan Terbaru</h2>
          <p class="mt-1 text-steel">Pilih lapangan, cek fasilitas dan harga, lalu langsung pesan.</p>
        </div>
        <a href="/courts"
           class="inline-flex items-center gap-1 self-start rounded-xl bg-snow px-4 py-2 text-sm font-bold text-ink transition hover:bg-ink hover:text-brand md:self-auto">
          Jelajahi Semua Lapangan
          <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
        </a>
      </div>

      <!-- Grid kartu lapangan -->
      <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
        <?php if (!empty($courts)): ?>
          <?php foreach ($courts as $lapangan):
            $gambar    = !empty($lapangan['image']) ? $lapangan['image'] : 'court.jpg';
            $fasilitas = array_slice(
              array_filter(array_map('trim', explode(',', (string)$lapangan['facilities']))),
              0, 3
            );
          ?>
            <article class="group flex flex-col overflow-hidden rounded-2xl border border-black/10 bg-white shadow-md transition-all duration-300 hover:border-brand hover:shadow-xl">

              <!-- Gambar lapangan -->
              <a href="/courts/detail?id=<?= (int)$lapangan['id'] ?>"
                 class="relative block h-48 w-full overflow-hidden bg-snow">
                <img src="/images/<?= htmlspecialchars($gambar) ?>"
                     alt="<?= htmlspecialchars($lapangan['name']) ?>"
                     class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105">
                <!-- Badge jenis olahraga -->
                <span class="absolute left-3 top-3 rounded-full bg-brand px-2.5 py-1 text-[11px] font-extrabold uppercase tracking-wide text-ink shadow">
                  <?= htmlspecialchars($lapangan['sport_type']) ?>
                </span>
              </a>

              <!-- Info lapangan -->
              <div class="flex flex-1 flex-col justify-between space-y-3 p-4">
                <h3 class="text-lg font-bold leading-snug text-ink">
                  <?= htmlspecialchars($lapangan['name']) ?>
                </h3>

                <!-- Daftar fasilitas (maksimal 3) -->
                <div class="flex flex-wrap gap-1.5">
                  <?php foreach ($fasilitas as $f): ?>
                    <span class="rounded-md bg-snow px-2 py-0.5 text-[11px] font-semibold text-steel">
                      <?= htmlspecialchars($f) ?>
                    </span>
                  <?php endforeach; ?>
                </div>

                <!-- Harga & tombol pesan -->
                <div class="flex items-center justify-between border-t border-black/5 pt-3">
                  <div>
                    <span class="text-[11px] font-bold uppercase text-steel">Mulai dari</span>
                    <div class="font-bold text-ink">
                      Rp <?= number_format($lapangan['price_per_hour'], 0, ',', '.') ?>
                      <span class="text-xs font-normal text-steel">/ jam</span>
                    </div>
                  </div>
                  <a href="/booking?court_id=<?= (int)$lapangan['id'] ?>"
                     class="rounded-xl bg-ink px-3.5 py-2 text-xs font-bold text-brand shadow-sm transition hover:bg-brand hover:text-ink">
                    Pesan
                  </a>
                </div>
              </div>

            </article>
          <?php endforeach; ?>
        <?php else: ?>
          <p class="col-span-4 py-10 text-center text-steel">
            Belum ada lapangan yang tersedia.
          </p>
        <?php endif; ?>
      </div>

    </div>
  </section>

  <!-- ==========================================
       SEKSI CARA BOOKING (3 langkah)
       Sesuai alur penggunaan customer di README
       ========================================== -->
  <section id="cara-booking" class="relative w-full scroll-mt-20 overflow-hidden bg-ink py-16 text-white sm:py-24">

    <!-- Efek cahaya dekoratif -->
    <div class="pointer-events-none absolute -left-32 -top-32 h-96 w-96 rounded-full bg-brand/10 blur-3xl"></div>
    <div class="pointer-events-none absolute -bottom-32 -right-32 h-96 w-96 rounded-full bg-brand/8 blur-3xl"></div>

    <div class="relative z-10 mx-auto max-w-6xl space-y-12 px-4 sm:px-6">

      <!-- Judul seksi -->
      <div class="space-y-2">
        <span class="inline-block rounded-full border border-brand/30 bg-brand/15 px-3 py-1 text-[11px] font-extrabold uppercase tracking-wider text-brand">
          Gampang &amp; Cepat
        </span>
        <h2 class="text-3xl font-extrabold tracking-tight sm:text-4xl">Booking dalam 4 Langkah</h2>
        <p class="max-w-xl text-[#A2A6B0]">Dari cari lapangan sampai pesananmu tersimpan, semuanya selesai dalam beberapa menit.</p>
      </div>

      <!-- Langkah-langkah booking (sesuai alur customer di README) -->
      <ol class="grid grid-cols-1 gap-6 md:grid-cols-4">
        <?php
        // Data langkah booking: [icon, judul, deskripsi]
        $langkahBooking = [
          ['stadium',           'Lihat Lapangan',   'Buka SportSpace dan jelajahi daftar lapangan futsal, badminton, atau basket. Cek fasilitas dan harga per jam sebelum memutuskan.'],
          ['person_add',        'Daftar & Masuk',   'Sudah ketemu lapangan yang cocok? Buat akun customer gratis, lalu login untuk bisa melakukan pemesanan.'],
          ['event_available',   'Tentukan Jadwal',  'Pilih tanggal, jam mulai, dan durasi bermain. Total harga langsung dihitung otomatis — tidak perlu tanya admin.'],
          ['receipt_long',      'Pantau Pesanan',   'Pesananmu langsung tersimpan. Pantau statusnya — pending, confirmed, atau cancelled — kapan saja di halaman My Booking.'],
        ];
        foreach ($langkahBooking as $urutan => [$icon, $judul, $deskripsi]):
        ?>
          <li class="flex flex-col space-y-4 rounded-2xl border border-brand/30 bg-[#181B20] p-6 shadow-xl transition hover:border-brand">
            <div class="flex items-center justify-between">
              <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-brand text-ink">
                <span class="material-symbols-outlined text-[26px]"><?= $icon ?></span>
              </span>
              <!-- Nomor langkah besar di kanan (dekoratif) -->
              <span class="text-5xl font-extrabold text-white/10"><?= $urutan + 1 ?></span>
            </div>
            <h3 class="text-xl font-bold"><?= $judul ?></h3>
            <p class="text-sm leading-relaxed text-[#A2A6B0]"><?= $deskripsi ?></p>
          </li>
        <?php endforeach; ?>
      </ol>

      <!-- CTA di bawah langkah -->
      <div class="flex flex-wrap items-center gap-4">
        <a href="/courts"
           class="inline-flex items-center gap-2 rounded-xl bg-brand px-6 py-3.5 text-sm font-bold text-ink shadow-lg shadow-brand/20 transition hover:scale-[1.02] hover:bg-brand-hover">
          <span class="material-symbols-outlined text-[20px]">stadium</span>
          Lihat Lapangan Sekarang
        </a>
        <a href="/register"
           class="inline-flex items-center gap-2 rounded-xl border border-white/20 bg-white/10 px-6 py-3.5 text-sm font-bold text-white backdrop-blur-sm transition hover:bg-white/20">
          <span class="material-symbols-outlined text-[20px]">person_add</span>
          Daftar Gratis
        </a>
      </div>

    </div>
  </section>

  <!-- ==========================================
       SEKSI KEUNGGULAN
       Alasan kenapa pakai SportSpace
       ========================================== -->
  <section id="keunggulan" class="w-full scroll-mt-20 bg-snow py-16 sm:py-24">
    <div class="mx-auto max-w-6xl space-y-12 px-4 sm:px-6">

      <!-- Judul seksi -->
      <div class="mx-auto max-w-2xl space-y-2 text-center">
        <div class="flex items-center justify-center gap-1.5 text-xs font-extrabold uppercase tracking-widest text-ink">
          <span class="h-2 w-2 rounded-full bg-brand"></span> Keunggulan Kami
        </div>
        <h2 class="text-3xl font-extrabold tracking-tight text-ink sm:text-4xl">Kenapa Booking di SportSpace?</h2>
        <p class="font-medium leading-relaxed text-steel">
          Semua kebutuhan booking lapangan olahraga ada dalam satu website.
        </p>
      </div>

      <!-- Kartu keunggulan -->
      <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
        <?php
        // Data keunggulan: [icon, judul, deskripsi, badge]
        $keunggulan = [
          [
            'bolt',
            'Pesan Tanpa Chat Admin',
            'Pilih lapangan, tentukan jadwal, dan kirim formulir — semua langsung dari website tanpa perlu WhatsApp admin.',
            'Booking mandiri & cepat',
          ],
          [
            'payments',
            'Harga Transparan',
            'Harga per jam tertera jelas di halaman detail lapangan. Total biaya langsung dihitung otomatis saat kamu mengisi durasi.',
            'Total harga otomatis',
          ],
          [
            'history',
            'Riwayat Tersimpan',
            'Semua pesananmu tercatat rapi di halaman My Booking lengkap dengan status: pending, confirmed, atau cancelled.',
            'Pantau status real-time',
          ],
        ];
        foreach ($keunggulan as [$icon, $judul, $deskripsi, $badge]):
        ?>
          <div class="flex flex-col justify-between space-y-5 rounded-2xl border border-black/5 bg-white p-7 shadow-md transition hover:border-brand hover:shadow-xl">
            <div class="space-y-4">
              <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-brand text-ink shadow-md">
                <span class="material-symbols-outlined text-[28px]"><?= $icon ?></span>
              </div>
              <h3 class="text-xl font-bold text-ink"><?= $judul ?></h3>
              <p class="text-sm leading-relaxed text-steel"><?= $deskripsi ?></p>
            </div>
            <div class="flex items-center gap-2 border-t border-black/5 pt-3 text-xs font-bold text-ink">
              <span class="material-symbols-outlined text-[18px] text-brand">check_circle</span>
              <?= $badge ?>
            </div>
          </div>
        <?php endforeach; ?>
      </div>

    </div>
  </section>

</main>

<?php require __DIR__ . '/../layout/footer.php'; ?>
