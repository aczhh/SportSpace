<?php
require __DIR__ . '/../layout/header.php';

$courts      = $courts ?? [];
$sportCounts = $sportCounts ?? [];
$sports      = ['Futsal', 'Badminton', 'Basket'];
$totalCourts = array_sum($sportCounts);
?>

<main class="w-full">

  <!-- ============ HERO (foto + overlay lime) ============ -->
  <section class="relative flex min-h-[780px] items-center justify-center overflow-hidden bg-ink px-4 pb-20 pt-32">
    <div class="absolute inset-0">
      <img src="/images/bg.jpeg" alt="" class="h-full w-full object-cover object-center">
      <div class="absolute inset-0 bg-gradient-to-b from-ink/90 via-ink/70 to-ink/95"></div>
      <div class="pointer-events-none absolute inset-0 bg-brand/20 mix-blend-color-dodge"></div>
      <div class="pointer-events-none absolute -top-40 left-1/2 h-[500px] w-[700px] -translate-x-1/2 rounded-full bg-brand/15 blur-3xl"></div>
    </div>

    <div class="relative z-10 mx-auto flex max-w-5xl flex-col items-center space-y-7 text-center">

      <h1 class="max-w-4xl text-4xl font-extrabold leading-[1.1] tracking-tight text-white drop-shadow-md sm:text-5xl md:text-6xl">
        Cari Lapangan, <span class="text-brand underline decoration-brand decoration-[6px] underline-offset-4">Booking Langsung</span> di SportSpace
      </h1>

      <p class="max-w-3xl text-base leading-relaxed text-snow/90 drop-shadow sm:text-lg md:text-xl">
        Lihat fasilitas dan harga, pilih tanggal, jam, dan durasi main, lalu pesan lapangan dalam hitungan menit tanpa chat admin.
      </p>

      <div class="flex flex-wrap items-center justify-center gap-4 pt-1">
        <a href="#quick-search" class="inline-flex items-center gap-2 rounded-xl bg-brand px-8 py-4 text-base font-bold text-ink shadow-xl shadow-brand/25 transition hover:scale-[1.02] hover:bg-brand-hover">
          Mulai Main Sekarang
          <span class="material-symbols-outlined text-[20px]">sports_soccer</span>
        </a>
        <a href="#cara-booking" class="inline-flex items-center gap-2 rounded-xl border border-white/20 bg-black/40 px-7 py-4 text-base font-bold text-white shadow-lg backdrop-blur-md transition hover:scale-[1.02] hover:bg-black/60">
          <span class="material-symbols-outlined text-[20px] text-brand">menu_book</span>
          Lihat Cara Booking
        </a>
      </div>

      <!-- Kotak pencarian -->
      <div id="quick-search" class="mt-4 w-full max-w-4xl scroll-mt-28 rounded-2xl border border-white/40 bg-white/95 p-5 text-left shadow-2xl backdrop-blur-md sm:p-6">
        <form action="/courts" method="GET" class="grid grid-cols-1 items-end gap-3 md:grid-cols-4">
          <div class="flex flex-col gap-1.5">
            <label for="sport" class="flex items-center gap-1.5 text-[11px] font-bold uppercase tracking-wider text-steel">
              <span class="material-symbols-outlined text-[17px] text-ink">sports_tennis</span> Pilih Olahraga
            </label>
            <select id="sport" name="sport" class="w-full cursor-pointer rounded-xl bg-snow px-3.5 py-3 text-sm font-semibold text-ink outline-none focus:ring-2 focus:ring-brand-hover">
              <option value="">Semua olahraga</option>
              <?php foreach ($sports as $s): ?>
                <option value="<?= $s ?>"><?= $s ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="flex flex-col gap-1.5">
            <label for="q" class="flex items-center gap-1.5 text-[11px] font-bold uppercase tracking-wider text-steel">
              <span class="material-symbols-outlined text-[17px] text-ink">search</span> Nama Lapangan
            </label>
            <input id="q" name="q" type="text" placeholder="Contoh: Arena Garuda"
                   class="w-full rounded-xl bg-snow px-3.5 py-3 text-sm font-semibold text-ink outline-none placeholder:font-normal placeholder:text-steel/60 focus:ring-2 focus:ring-brand-hover">
          </div>

          <div class="flex flex-col gap-1.5">
            <label for="date" class="flex items-center gap-1.5 text-[11px] font-bold uppercase tracking-wider text-steel">
              <span class="material-symbols-outlined text-[17px] text-ink">calendar_month</span> Tanggal Main
            </label>
            <input id="date" name="date" type="date" min="<?= date('Y-m-d') ?>"
                   class="w-full rounded-xl bg-snow px-3.5 py-2.5 text-sm font-semibold text-ink outline-none focus:ring-2 focus:ring-brand-hover">
          </div>

          <button type="submit" class="group flex h-12 w-full items-center justify-center gap-2 rounded-xl bg-brand text-sm font-bold text-ink shadow-md transition hover:scale-[1.02] hover:bg-brand-hover">
            <span class="material-symbols-outlined text-[20px] transition group-hover:rotate-12">search</span>
            Cari Lapangan
          </button>
        </form>

        <div class="mt-4 flex flex-wrap items-center justify-between gap-2 border-t border-black/5 pt-3">
          <div class="flex flex-wrap items-center gap-2 text-xs text-steel">
            <span class="font-bold text-ink">Pilihan Cepat:</span>
            <?php foreach ($sports as $s): ?>
              <a href="/courts?sport=<?= $s ?>" class="rounded-full bg-snow px-2.5 py-1 font-semibold text-ink transition hover:bg-brand"><?= $s ?></a>
            <?php endforeach; ?>
          </div>
          <div class="flex items-center gap-1 text-xs font-bold text-ink">
            <span class="material-symbols-outlined rounded-full bg-ink p-0.5 text-[17px] text-brand-hover">verified</span>
            Total harga dihitung otomatis
          </div>
        </div>
      </div>

      <!-- Statistik -->
      <div class="grid w-full max-w-4xl grid-cols-1 gap-4 pt-2 sm:grid-cols-3">
        <?php
        $metrics = [
          ['stadium', (int)$totalCourts, 'Lapangan Terdaftar'],
          ['sports_score', count($sports), 'Cabang Olahraga'],
          ['schedule', '24 Jam', 'Booking Online Kapan Saja'],
        ];
        foreach ($metrics as [$icon, $value, $label]): ?>
          <div class="flex items-center gap-3.5 rounded-2xl border border-white/10 bg-black/45 p-4 text-left shadow-lg backdrop-blur-md">
            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-brand text-ink shadow">
              <span class="material-symbols-outlined text-[22px]"><?= $icon ?></span>
            </div>
            <div>
              <div class="text-2xl font-extrabold tracking-tight text-white"><?= $value ?></div>
              <div class="text-xs font-semibold text-snow/80"><?= $label ?></div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- ============ LAPANGAN TERBARU (putih) ============ -->
  <section id="sewa-lapangan" class="w-full scroll-mt-20 border-y border-black/5 bg-white py-16 sm:py-24">
    <div class="mx-auto max-w-6xl space-y-10 px-4 sm:px-6">

      <div class="flex items-center gap-3 overflow-x-auto pb-2">
        <a href="/courts" class="flex shrink-0 items-center gap-2 rounded-full bg-ink px-5 py-2.5 text-sm font-bold text-brand shadow-sm">
          <span class="material-symbols-outlined text-[18px]">apps</span> Semua Cabang
        </a>
        <?php foreach ($sports as $s): ?>
          <a href="/courts?sport=<?= $s ?>" class="shrink-0 rounded-full bg-snow px-5 py-2.5 text-sm font-bold text-ink transition-colors hover:bg-brand">
            <?= $s ?> <span class="font-normal text-steel">(<?= (int)($sportCounts[$s] ?? 0) ?>)</span>
          </a>
        <?php endforeach; ?>
      </div>

      <div class="flex flex-col justify-between gap-4 pt-2 md:flex-row md:items-end">
        <div>
          <div class="flex items-center gap-1.5 text-xs font-extrabold uppercase tracking-widest text-ink">
            <span class="h-2 w-2 rounded-full bg-brand-hover"></span> Booking Online
          </div>
          <h2 class="mt-1 text-3xl font-extrabold tracking-tight text-ink sm:text-4xl">Lapangan Terbaru</h2>
          <p class="mt-1 text-steel">Pilih lapangan, lihat fasilitas dan harganya, lalu booking langsung.</p>
        </div>
        <a href="/courts" class="inline-flex items-center gap-1 self-start rounded-xl bg-snow px-4 py-2 text-sm font-bold text-ink transition hover:bg-ink hover:text-brand md:self-auto">
          Jelajahi Semua Lapangan
          <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
        </a>
      </div>

      <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
        <?php if (!empty($courts)): ?>
          <?php foreach ($courts as $court):
            $img = !empty($court['image']) ? $court['image'] : 'court.jpg';
            $facilities = array_slice(array_filter(array_map('trim', explode(',', (string)$court['facilities']))), 0, 3);
          ?>
            <article class="group flex flex-col overflow-hidden rounded-2xl border border-black/10 bg-white shadow-md transition-all duration-300 hover:border-brand-hover hover:shadow-xl">
              <a href="/courts/detail?id=<?= (int)$court['id'] ?>" class="relative block h-48 w-full overflow-hidden bg-snow">
                <img src="/images/<?= htmlspecialchars($img) ?>" alt="<?= htmlspecialchars($court['name']) ?>"
                     class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105">
                <span class="absolute left-3 top-3 rounded-full bg-brand px-2.5 py-1 text-[11px] font-extrabold uppercase tracking-wide text-ink shadow">
                  <?= htmlspecialchars($court['sport_type']) ?>
                </span>
              </a>

              <div class="flex flex-1 flex-col justify-between space-y-3 p-4">
                <h3 class="text-lg font-bold leading-snug text-ink"><?= htmlspecialchars($court['name']) ?></h3>

                <div class="flex flex-wrap gap-1.5">
                  <?php foreach ($facilities as $f): ?>
                    <span class="rounded-md bg-snow px-2 py-0.5 text-[11px] font-semibold text-steel"><?= htmlspecialchars($f) ?></span>
                  <?php endforeach; ?>
                </div>

                <div class="flex items-center justify-between border-t border-black/5 pt-3">
                  <div>
                    <span class="text-[11px] font-bold uppercase text-steel">Mulai dari</span>
                    <div class="font-bold text-ink">
                      Rp <?= number_format($court['price_per_hour'], 0, ',', '.') ?>
                      <span class="text-xs font-normal text-steel">/ jam</span>
                    </div>
                  </div>
                  <a href="/booking?court_id=<?= (int)$court['id'] ?>"
                     class="rounded-xl bg-ink px-3.5 py-2 text-xs font-bold text-brand shadow-sm transition hover:bg-brand-hover hover:text-ink">Pesan</a>
                </div>
              </div>
            </article>
          <?php endforeach; ?>
        <?php else: ?>
          <p class="text-steel">Belum ada lapangan yang tersedia.</p>
        <?php endif; ?>
      </div>
    </div>
  </section>

  <!-- ============ CARA BOOKING (gelap) ============ -->
  <section id="cara-booking" class="relative w-full scroll-mt-20 overflow-hidden bg-ink py-16 text-white sm:py-24">
    <div class="pointer-events-none absolute -left-32 -top-32 h-96 w-96 rounded-full bg-brand-hover/10 blur-3xl"></div>
    <div class="pointer-events-none absolute -bottom-32 -right-32 h-96 w-96 rounded-full bg-brand/10 blur-3xl"></div>

    <div class="relative z-10 mx-auto max-w-6xl space-y-12 px-4 sm:px-6">
      <div class="space-y-2">
        <span class="inline-block rounded-full border border-brand-hover/30 bg-brand-hover/20 px-3 py-1 text-[11px] font-extrabold uppercase tracking-wider text-brand-hover">
          Gampang &amp; Cepat
        </span>
        <h2 class="text-3xl font-extrabold tracking-tight sm:text-4xl">Booking dalam 3 Langkah</h2>
        <p class="max-w-xl text-[#A2A6B0]">Dari cari lapangan sampai pesanan tersimpan, semuanya selesai dalam beberapa menit.</p>
      </div>

      <ol class="grid grid-cols-1 gap-6 md:grid-cols-3">
        <?php
        $steps = [
          ['search', 'Pilih Lapangan', 'Cari berdasarkan olahraga, lihat fasilitas dan harga per jam di halaman detail.'],
          ['event_available', 'Tentukan Jadwal', 'Isi tanggal, jam mulai, dan durasi bermain. Total harga langsung dihitung.'],
          ['receipt_long', 'Pantau Pesanan', 'Lihat status pending, confirmed, atau cancelled kapan saja di My Booking.'],
        ];
        foreach ($steps as $i => [$icon, $title, $desc]): ?>
          <li class="flex flex-col space-y-4 rounded-2xl border border-brand-hover/40 bg-[#181B20] p-6 shadow-xl transition hover:border-brand-hover">
            <div class="flex items-center justify-between">
              <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-brand text-ink">
                <span class="material-symbols-outlined text-[26px]"><?= $icon ?></span>
              </span>
              <span class="text-5xl font-extrabold text-white/10"><?= $i + 1 ?></span>
            </div>
            <h3 class="text-xl font-bold"><?= $title ?></h3>
            <p class="text-sm leading-relaxed text-[#A2A6B0]"><?= $desc ?></p>
          </li>
        <?php endforeach; ?>
      </ol>

      <div>
        <a href="/courts" class="inline-flex items-center gap-2 rounded-xl bg-brand px-6 py-3.5 text-sm font-bold text-ink shadow-lg shadow-brand/20 transition hover:scale-[1.02] hover:bg-brand-hover">
          <span class="material-symbols-outlined text-[20px]">add_circle</span>
          Booking Sekarang
        </a>
      </div>
    </div>
  </section>

  <!-- ============ KEUNGGULAN (abu terang) ============ -->
  <section id="keunggulan" class="w-full scroll-mt-20 bg-snow py-16 sm:py-24">
    <div class="mx-auto max-w-6xl space-y-12 px-4 sm:px-6">
      <div class="mx-auto max-w-2xl space-y-2 text-center">
        <div class="flex items-center justify-center gap-1.5 text-xs font-extrabold uppercase tracking-widest text-ink">
          <span class="h-2 w-2 rounded-full bg-brand-hover"></span> Keunggulan Kami
        </div>
        <h2 class="text-3xl font-extrabold tracking-tight text-ink sm:text-4xl">Kenapa Booking di SportSpace?</h2>
        <p class="font-medium leading-relaxed text-steel">Semua kebutuhan booking lapangan ada dalam satu website.</p>
      </div>

      <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
        <?php
        $perks = [
          ['bolt', 'Booking Mudah', 'Pesan lapangan langsung dari website tanpa perlu chat admin satu per satu.', 'Tanpa chat admin'],
          ['payments', 'Harga Transparan', 'Harga per jam terlihat jelas dan total biaya dihitung otomatis sebelum kamu memesan.', 'Total harga otomatis'],
          ['history', 'Riwayat Tersimpan', 'Semua pesananmu tercatat rapi di halaman My Booking beserta statusnya.', 'Status pesanan real-time'],
        ];
        foreach ($perks as [$icon, $title, $desc, $badge]): ?>
          <div class="flex flex-col justify-between space-y-5 rounded-2xl border border-black/5 bg-white p-7 shadow-md transition hover:border-brand-hover hover:shadow-xl">
            <div class="space-y-4">
              <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-brand text-ink shadow-md">
                <span class="material-symbols-outlined text-[28px]"><?= $icon ?></span>
              </div>
              <h3 class="text-xl font-bold text-ink"><?= $title ?></h3>
              <p class="text-sm leading-relaxed text-steel"><?= $desc ?></p>
            </div>
            <div class="flex items-center gap-2 border-t border-black/5 pt-3 text-xs font-bold text-ink">
              <span class="material-symbols-outlined text-[18px] text-brand-hover">check_circle</span>
              <?= $badge ?>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>
</main>

<?php require __DIR__ . '/../layout/footer.php'; ?>