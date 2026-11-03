<?php
require __DIR__ . '/../layout/header.php';

$sportCounts = $sportCounts ?? [];
$sports      = ['Futsal', 'Badminton', 'Basket'];
$totalCourts = array_sum($sportCounts);
?>

<main>
  <!-- HERO -->
  <section class="relative -mt-20 overflow-hidden bg-ink bg-cover bg-center pt-20"
           style="background-image:url('/images/hero.jpg')">
    <div class="absolute inset-0 bg-gradient-to-b from-ink/80 via-ink/75 to-ink"></div>
    <div class="absolute inset-0 bg-[radial-gradient(800px_320px_at_50%_0%,rgba(191,255,26,0.18),transparent_70%)]"></div>

    <div class="relative mx-auto max-w-6xl px-4 pb-16 pt-16 text-center md:pt-24">
      <span class="inline-flex items-center gap-2 rounded-full border border-brand/40 bg-ink/60 px-4 py-1.5 text-xs font-semibold uppercase tracking-wide">
        <span class="h-2 w-2 rounded-full bg-brand"></span>
        Booking lapangan futsal, badminton &amp; basket
      </span>

      <h1 class="mx-auto mt-6 max-w-3xl text-4xl font-extrabold leading-tight sm:text-5xl md:text-6xl">
        Cari Lapangan, <span class="text-brand">Booking Langsung</span> di SportSpace
      </h1>

      <p class="mx-auto mt-5 max-w-2xl text-base text-snow/75 md:text-lg">
        Lihat fasilitas dan harga, pilih tanggal dan jam main, lalu pesan lapangan dalam hitungan menit.
      </p>

      <div class="mt-8 flex flex-wrap justify-center gap-3">
        <a href="/courts" class="rounded-xl bg-brand px-7 py-3.5 font-bold text-ink transition hover:bg-brand-hover">Mulai Cari Lapangan</a>
        <a href="#cara-booking" class="rounded-xl border border-white/15 bg-ink/60 px-7 py-3.5 font-semibold transition hover:border-brand hover:text-brand">Lihat Cara Booking</a>
      </div>

      <!-- Kotak pencarian -->
      <form action="/courts" method="GET"
            class="mx-auto mt-12 max-w-5xl rounded-3xl bg-snow p-5 text-left text-ink shadow-2xl">
        <div class="grid gap-4 md:grid-cols-[1fr_1.2fr_1fr_auto] md:items-end">
          <div>
            <label for="sport" class="mb-1.5 block text-xs font-bold uppercase tracking-wide text-steel">Pilih olahraga</label>
            <select id="sport" name="sport" class="w-full rounded-xl border border-steel/30 bg-white px-4 py-3 outline-none focus:border-ink focus:ring-2 focus:ring-brand">
              <option value="">Semua olahraga</option>
              <?php foreach ($sports as $s): ?>
                <option value="<?= $s ?>"><?= $s ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div>
            <label for="q" class="mb-1.5 block text-xs font-bold uppercase tracking-wide text-steel">Nama lapangan</label>
            <input id="q" name="q" type="text" placeholder="Contoh: Arena Garuda"
                   class="w-full rounded-xl border border-steel/30 bg-white px-4 py-3 outline-none focus:border-ink focus:ring-2 focus:ring-brand">
          </div>
          <div>
            <label for="date" class="mb-1.5 block text-xs font-bold uppercase tracking-wide text-steel">Tanggal main</label>
            <input id="date" name="date" type="date" min="<?= date('Y-m-d') ?>"
                   class="w-full rounded-xl border border-steel/30 bg-white px-4 py-3 outline-none focus:border-ink focus:ring-2 focus:ring-brand">
          </div>
          <button type="submit" class="rounded-xl bg-brand px-8 py-3 font-bold text-ink transition hover:bg-brand-hover">Cari Lapangan</button>
        </div>

        <div class="mt-4 flex flex-wrap items-center justify-between gap-3 border-t border-steel/15 pt-4 text-sm">
          <div class="flex flex-wrap items-center gap-2">
            <span class="font-semibold">Pilihan cepat:</span>
            <?php foreach ($sports as $s): ?>
              <a href="/courts?sport=<?= $s ?>" class="rounded-full bg-white px-3 py-1 font-medium ring-1 ring-steel/20 transition hover:bg-brand"><?= $s ?></a>
            <?php endforeach; ?>
          </div>
          <span class="font-semibold">Harga jelas, total dihitung otomatis</span>
        </div>
      </form>

      <!-- Statistik -->
      <div class="mx-auto mt-8 grid max-w-5xl gap-4 text-left sm:grid-cols-3">
        <div class="rounded-2xl border border-white/10 bg-ink/70 p-5 backdrop-blur">
          <p class="text-3xl font-extrabold text-brand"><?= (int)$totalCourts ?></p>
          <p class="text-sm text-snow/70">Lapangan terdaftar</p>
        </div>
        <div class="rounded-2xl border border-white/10 bg-ink/70 p-5 backdrop-blur">
          <p class="text-3xl font-extrabold text-brand"><?= count($sports) ?></p>
          <p class="text-sm text-snow/70">Cabang olahraga</p>
        </div>
        <div class="rounded-2xl border border-white/10 bg-ink/70 p-5 backdrop-blur">
          <p class="text-3xl font-extrabold text-brand">24 jam</p>
          <p class="text-sm text-snow/70">Booking online kapan saja</p>
        </div>
      </div>
    </div>
  </section>

  <!-- CABANG OLAHRAGA -->
  <section class="mx-auto max-w-6xl px-4 py-16">
    <h2 class="text-3xl font-extrabold md:text-4xl">Mau main apa hari ini?</h2>
    <div class="mt-8 grid gap-4 md:grid-cols-3">
      <?php foreach ($sports as $s): ?>
        <a href="/courts?sport=<?= $s ?>"
           class="group rounded-2xl border-2 border-steel p-6 transition hover:border-brand hover:bg-white/5">
          <p class="text-5xl font-extrabold text-brand"><?= (int)($sportCounts[$s] ?? 0) ?></p>
          <h3 class="mt-2 text-2xl font-bold"><?= $s ?></h3>
          <p class="text-snow/60">lapangan tersedia</p>
        </a>
      <?php endforeach; ?>
    </div>
  </section>

  <!-- LAPANGAN TERBARU -->
  <section class="bg-white/[0.03] py-16">
    <div class="mx-auto max-w-6xl px-4">
      <div class="flex items-end justify-between">
        <h2 class="text-3xl font-extrabold md:text-4xl">Lapangan terbaru</h2>
        <a href="/courts" class="font-bold text-brand hover:underline">Lihat semua</a>
      </div>

      <div class="mt-8 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
        <?php if (!empty($courts)): ?>
          <?php foreach ($courts as $court): ?>
            <article class="overflow-hidden rounded-2xl border border-white/10 bg-steel/40">
              <a href="/courts/detail?id=<?= (int)$court['id'] ?>"
                 class="block h-44 bg-ink bg-cover bg-center"
                 style="background-image:url('/images/<?= htmlspecialchars($court['image']) ?>')"
                 aria-label="Lihat <?= htmlspecialchars($court['name']) ?>"></a>
              <div class="space-y-2 p-5">
                <span class="inline-block rounded-full bg-brand px-3 py-0.5 text-xs font-bold text-ink"><?= htmlspecialchars($court['sport_type']) ?></span>
                <h3 class="text-xl font-bold"><?= htmlspecialchars($court['name']) ?></h3>
                <p class="line-clamp-2 text-sm text-snow/65"><?= htmlspecialchars($court['facilities']) ?></p>
                <div class="flex items-center justify-between pt-2">
                  <p class="font-bold">
                    <span class="text-xs font-normal text-snow/60">Mulai</span>
                    Rp <?= number_format($court['price_per_hour'], 0, ',', '.') ?>
                    <span class="text-xs font-normal text-snow/60">/ jam</span>
                  </p>
                  <a href="/booking?court_id=<?= (int)$court['id'] ?>" class="rounded-lg bg-brand px-4 py-2 text-sm font-bold text-ink transition hover:bg-brand-hover">Booking</a>
                </div>
              </div>
            </article>
          <?php endforeach; ?>
        <?php else: ?>
          <p class="text-snow/60">Belum ada lapangan yang tersedia.</p>
        <?php endif; ?>
      </div>
    </div>
  </section>

  <!-- CARA BOOKING -->
  <section id="cara-booking" class="mx-auto max-w-6xl scroll-mt-24 px-4 py-16">
    <h2 class="text-3xl font-extrabold md:text-4xl">Booking dalam 3 langkah</h2>
    <ol class="mt-8 grid gap-8 md:grid-cols-3">
      <?php
      $steps = [
        ['Pilih lapangan', 'Lihat fasilitas dan harga per jam di halaman detail.'],
        ['Tentukan jadwal', 'Isi tanggal, jam mulai, dan durasi. Total harga langsung dihitung.'],
        ['Pantau pesanan', 'Cek status pending, confirmed, atau cancelled di My Booking.'],
      ];
      foreach ($steps as $i => [$title, $desc]): ?>
        <li>
          <span class="grid h-11 w-11 place-items-center rounded-full bg-brand text-xl font-extrabold text-ink"><?= $i + 1 ?></span>
          <h3 class="mt-4 text-xl font-bold"><?= $title ?></h3>
          <p class="mt-1 text-snow/65"><?= $desc ?></p>
        </li>
      <?php endforeach; ?>
    </ol>
  </section>

  <!-- KEUNGGULAN -->
  <section id="keunggulan" class="scroll-mt-24 bg-white/[0.03] py-16">
    <div class="mx-auto max-w-6xl px-4">
      <h2 class="text-3xl font-extrabold md:text-4xl">Kenapa SportSpace?</h2>
      <div class="mt-8 grid gap-4 md:grid-cols-3">
        <?php
        $perks = [
          ['Tanpa chat admin', 'Semua proses booking dilakukan langsung dari website.'],
          ['Harga transparan', 'Harga per jam terlihat jelas sebelum kamu memesan.'],
          ['Riwayat tersimpan', 'Semua pesananmu rapi di satu halaman, kapan pun dibutuhkan.'],
        ];
        foreach ($perks as [$title, $desc]): ?>
          <div class="rounded-2xl border-l-4 border-brand bg-ink p-6">
            <h3 class="text-xl font-bold"><?= $title ?></h3>
            <p class="mt-1 text-snow/65"><?= $desc ?></p>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- BANNER -->
  <section class="bg-brand py-14 text-ink">
    <div class="mx-auto flex max-w-6xl flex-wrap items-center justify-between gap-6 px-4">
      <div>
        <h2 class="text-3xl font-extrabold md:text-4xl">Lapangan sudah menunggu.</h2>
        <p class="mt-1 text-lg">Buat akun gratis dan booking jadwal main pertamamu.</p>
      </div>
      <?php if (!isset($_SESSION['user_id'])): ?>
        <a href="/register" class="rounded-xl bg-ink px-8 py-4 font-bold text-brand transition hover:bg-steel">Daftar sekarang</a>
      <?php else: ?>
        <a href="/courts" class="rounded-xl bg-ink px-8 py-4 font-bold text-brand transition hover:bg-steel">Cari lapangan</a>
      <?php endif; ?>
    </div>
  </section>
</main>

<?php require __DIR__ . '/../layout/footer.php'; ?>