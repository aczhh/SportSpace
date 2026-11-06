<?php
$jumlahLapangan   = $jumlahLapangan   ?? 0;
$jumlahBooking    = $jumlahBooking    ?? 0;
$bookingPerStatus = $bookingPerStatus ?? ['pending' => 0, 'confirmed' => 0, 'cancelled' => 0];
$lapanganTerbaru  = $lapanganTerbaru  ?? [];
$bookingTerbaru   = $bookingTerbaru   ?? [];
$pilihanSport     = ['Futsal', 'Badminton', 'Basket'];

$warnaBadge = [
    'pending'   => 'bg-yellow-100 text-yellow-800 border border-yellow-200',
    'confirmed' => 'bg-green-100  text-green-800  border border-green-200',
    'cancelled' => 'bg-red-100    text-red-800    border border-red-200',
];

require __DIR__ . '/../layout/header.php';
?>

<main class="flex-1 bg-snow pt-28 pb-20">
  <div class="mx-auto max-w-6xl px-4 sm:px-6">

    <!-- ========== Judul ========== -->
    <div class="mb-8 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
      <div>
        <h1 class="text-3xl font-extrabold tracking-tight text-ink">Dashboard Admin</h1>
        <p class="mt-1 text-steel">
          Selamat datang, <span class="font-bold text-ink"><?= htmlspecialchars($_SESSION['user']['name'] ?? 'Admin') ?></span>.
          Ini ringkasan data SportSpace hari ini.
        </p>
      </div>
      <span class="inline-flex items-center gap-1.5 self-start rounded-full bg-green-100 border border-green-200 px-3 py-1 text-xs font-bold text-green-700 sm:self-auto">
        <span class="h-2 w-2 rounded-full bg-green-500 animate-pulse"></span>
        Live
      </span>
    </div>

    <!-- ========== Kartu Statistik ========== -->
    <?php
    $kartu = [
      ['stadium',         $jumlahLapangan,                'Total Lapangan',    'bg-brand',      '/admin/courts'],
      ['receipt_long',    $jumlahBooking,                 'Total Booking',     'bg-blue-400',   '/admin/bookings'],
      ['pending_actions', $bookingPerStatus['pending'],   'Booking Pending',   'bg-yellow-400', '/admin/bookings'],
      ['check_circle',    $bookingPerStatus['confirmed'], 'Booking Confirmed', 'bg-green-400',  '/admin/bookings'],
    ];
    ?>
    <div class="mb-10 grid grid-cols-2 gap-4 sm:grid-cols-4">
      <?php foreach ($kartu as [$icon, $jumlah, $label, $bg, $link]): ?>
        <a href="<?= $link ?>"
           class="group flex flex-col gap-3 rounded-2xl border border-black/10 bg-white p-5 shadow-sm transition hover:border-brand hover:shadow-md">
          <div class="flex h-11 w-11 items-center justify-center rounded-xl <?= $bg ?> text-ink shadow">
            <span class="material-symbols-outlined text-[22px]"><?= $icon ?></span>
          </div>
          <div>
            <div class="text-3xl font-extrabold tracking-tight text-ink group-hover:text-brand transition"><?= $jumlah ?></div>
            <div class="text-xs font-semibold text-steel"><?= $label ?></div>
          </div>
        </a>
      <?php endforeach; ?>
    </div>

    <!-- ========== Booking Terbaru ========== -->
    <div class="mb-10">
      <!-- Header section -->
      <div class="mb-4 flex items-center justify-between">
        <h2 class="text-xl font-extrabold text-ink flex items-center gap-2">
          <span class="material-symbols-outlined text-[22px] text-blue-500">receipt_long</span>
          Booking Terbaru
        </h2>
        <a href="/admin/bookings"
           class="inline-flex items-center gap-1 rounded-xl border border-black/10 bg-white px-4 py-2 text-sm font-bold text-ink shadow-sm transition hover:bg-ink hover:text-brand">
          Kelola Booking
          <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
        </a>
      </div>

      <div class="overflow-hidden rounded-2xl border border-black/10 bg-white shadow-sm">
        <?php if (empty($bookingTerbaru)): ?>
          <div class="flex flex-col items-center justify-center py-14 text-steel">
            <span class="material-symbols-outlined mb-2 text-[42px] text-steel/30">receipt_long</span>
            <p class="text-sm font-medium">Belum ada booking.</p>
          </div>
        <?php else: ?>
          <!-- Desktop: tabel | Mobile: list card -->
          <div class="hidden sm:block overflow-x-auto">
            <table class="w-full text-sm">
              <thead class="border-b border-black/5 bg-snow text-xs font-extrabold uppercase tracking-wider text-steel">
                <tr>
                  <th class="px-5 py-3.5 text-left">Customer</th>
                  <th class="px-5 py-3.5 text-left">Lapangan</th>
                  <th class="px-5 py-3.5 text-left">Tanggal</th>
                  <th class="px-5 py-3.5 text-left">Jam</th>
                  <th class="px-5 py-3.5 text-left">Total</th>
                  <th class="px-5 py-3.5 text-left">Status</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-black/5">
                <?php foreach ($bookingTerbaru as $b):
                  $kelas = $warnaBadge[$b['status']] ?? 'bg-snow text-steel border border-black/10';
                ?>
                  <tr class="hover:bg-snow/60 transition">
                    <td class="px-5 py-3.5">
                      <div class="flex items-center gap-2">
                        <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-brand/20 text-xs font-extrabold text-ink">
                          <?= mb_strtoupper(mb_substr($b['nama_customer'], 0, 1)) ?>
                        </span>
                        <span class="font-semibold text-ink"><?= htmlspecialchars($b['nama_customer']) ?></span>
                      </div>
                    </td>
                    <td class="px-5 py-3.5">
                      <div class="font-semibold text-ink"><?= htmlspecialchars($b['nama_lapangan']) ?></div>
                      <div class="text-xs text-steel"><?= htmlspecialchars($b['jenis_olahraga']) ?></div>
                    </td>
                    <td class="px-5 py-3.5 text-steel"><?= date('d M Y', strtotime($b['booking_date'])) ?></td>
                    <td class="px-5 py-3.5 text-steel">
                      <?= date('H.i', strtotime($b['start_time'])) ?> WIB
                      <span class="text-xs">(<?= (int)$b['duration'] ?>j)</span>
                    </td>
                    <td class="px-5 py-3.5 font-bold text-ink">Rp <?= number_format($b['total_price'], 0, ',', '.') ?></td>
                    <td class="px-5 py-3.5">
                      <span class="rounded-full px-2.5 py-1 text-[11px] font-extrabold capitalize <?= $kelas ?>">
                        <?= $b['status'] ?>
                      </span>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>

          <!-- Mobile: list card -->
          <ul class="divide-y divide-black/5 sm:hidden">
            <?php foreach ($bookingTerbaru as $b):
              $kelas = $warnaBadge[$b['status']] ?? 'bg-snow text-steel border border-black/10';
            ?>
              <li class="flex items-center gap-3 px-4 py-3">
                <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-brand/20 text-xs font-extrabold text-ink">
                  <?= mb_strtoupper(mb_substr($b['nama_customer'], 0, 1)) ?>
                </span>
                <div class="flex-1 min-w-0">
                  <p class="font-bold text-ink text-sm truncate"><?= htmlspecialchars($b['nama_customer']) ?></p>
                  <p class="text-xs text-steel truncate">
                    <?= htmlspecialchars($b['nama_lapangan']) ?> · <?= date('d M Y', strtotime($b['booking_date'])) ?>
                  </p>
                </div>
                <div class="flex flex-col items-end gap-1 shrink-0">
                  <span class="rounded-full px-2 py-0.5 text-[10px] font-extrabold capitalize <?= $kelas ?>"><?= $b['status'] ?></span>
                  <span class="text-xs font-bold text-ink">Rp <?= number_format($b['total_price'], 0, ',', '.') ?></span>
                </div>
              </li>
            <?php endforeach; ?>
          </ul>
        <?php endif; ?>
      </div>
    </div>

    <!-- ========== Daftar Lapangan ========== -->
    <div>
      <!-- Header section -->
      <div class="mb-5 flex items-center justify-between">
        <h2 class="text-xl font-extrabold text-ink flex items-center gap-2">
          <span class="material-symbols-outlined text-[22px] text-brand">stadium</span>
          Daftar Lapangan
        </h2>
        <a href="/admin/courts"
           class="inline-flex items-center gap-1 rounded-xl border border-black/10 bg-white px-4 py-2 text-sm font-bold text-ink shadow-sm transition hover:bg-ink hover:text-brand">
          Kelola Lapangan
          <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
        </a>
      </div>

      <?php if (empty($lapanganTerbaru)): ?>
        <div class="flex flex-col items-center justify-center rounded-2xl border border-black/10 bg-white py-16 text-steel shadow-sm">
          <span class="material-symbols-outlined mb-2 text-[42px] text-steel/30">stadium</span>
          <p class="text-sm font-medium">Belum ada lapangan. Tambah lapangan pertamamu!</p>
          <a href="/admin/courts"
             class="mt-4 inline-flex items-center gap-1 rounded-xl bg-brand px-5 py-2.5 text-sm font-bold text-ink transition hover:bg-brand-hover">
            <span class="material-symbols-outlined text-[18px]">add_circle</span>
            Tambah Lapangan
          </a>
        </div>
      <?php else: ?>
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
          <?php foreach ($lapanganTerbaru as $lap):
            $gambar    = !empty($lap['image']) ? $lap['image'] : 'court.jpg';
            $fasilitas = array_slice(
              array_filter(array_map('trim', explode(',', (string)$lap['facilities']))),
              0, 3
            );
          ?>
            <article class="group flex flex-col overflow-hidden rounded-2xl border border-black/10 bg-white shadow-sm transition hover:border-brand hover:shadow-lg">

              <!-- Gambar penuh -->
              <div class="relative h-44 w-full overflow-hidden bg-snow shrink-0">
                <img src="/images/<?= htmlspecialchars($gambar) ?>"
                     alt="<?= htmlspecialchars($lap['name']) ?>"
                     class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105">
                <!-- Badge jenis olahraga -->
                <span class="absolute left-3 top-3 rounded-full bg-brand px-3 py-1 text-[11px] font-extrabold uppercase tracking-wide text-ink shadow">
                  <?= htmlspecialchars($lap['sport_type']) ?>
                </span>
              </div>

              <!-- Konten bawah -->
              <div class="flex flex-1 flex-col justify-between p-4 gap-3">

                <!-- Nama -->
                <h3 class="font-bold text-ink text-base leading-snug"><?= htmlspecialchars($lap['name']) ?></h3>

                <!-- Fasilitas -->
                <?php if (!empty($fasilitas)): ?>
                  <div class="flex flex-wrap gap-1.5">
                    <?php foreach ($fasilitas as $f): ?>
                      <span class="rounded-full border border-black/10 bg-snow px-2.5 py-0.5 text-[11px] font-semibold text-steel">
                        <?= htmlspecialchars($f) ?>
                      </span>
                    <?php endforeach; ?>
                  </div>
                <?php endif; ?>

                <!-- Harga + Tombol -->
                <div class="border-t border-black/5 pt-3">
                  <p class="text-[10px] font-extrabold uppercase tracking-wider text-steel mb-0.5">Harga</p>
                  <div class="flex items-center justify-between gap-2">
                    <div>
                      <span class="text-lg font-extrabold text-ink">Rp <?= number_format($lap['price_per_hour'], 0, ',', '.') ?></span>
                      <span class="text-xs text-steel"> / jam</span>
                    </div>
                    <div class="flex gap-2 shrink-0">
                      <a href="/courts/detail?id=<?= (int)$lap['id'] ?>"
                         class="rounded-xl border border-black/10 bg-snow px-3 py-1.5 text-xs font-bold text-ink transition hover:bg-black/5">
                        Detail
                      </a>
                      <a href="/admin/courts"
                         class="rounded-xl bg-ink px-3 py-1.5 text-xs font-bold text-brand transition hover:bg-brand hover:text-ink">
                        Edit
                      </a>
                    </div>
                  </div>
                </div>

              </div>
            </article>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>

  </div>
</main>

<!-- =====================================================
     MODAL EDIT LAPANGAN (dari dashboard)
     ===================================================== -->
<div id="modal-edit"
     class="fixed inset-0 z-50 hidden items-start justify-center overflow-y-auto bg-black/60 px-4 py-6 backdrop-blur-sm sm:items-center sm:py-10"
     onclick="tutupModalEdit(event)">

  <div class="relative mx-auto w-full max-w-2xl rounded-2xl border border-black/10 bg-white shadow-2xl"
       onclick="event.stopPropagation()">

    <!-- Header -->
    <div class="flex items-center justify-between border-b border-black/10 px-5 py-4 sm:px-6">
      <h2 class="flex items-center gap-2 text-base font-extrabold text-ink sm:text-lg">
        <span class="material-symbols-outlined text-[20px] text-brand">edit</span>
        Edit Lapangan
      </h2>
      <button type="button" onclick="tutupModalEdit()"
              class="rounded-full p-1 text-steel transition hover:bg-snow hover:text-ink">
        <span class="material-symbols-outlined text-[22px]">close</span>
      </button>
    </div>

    <!-- Form -->
    <form action="/admin/courts/update" method="POST" enctype="multipart/form-data" class="space-y-4 p-5 sm:p-6">
      <input type="hidden" name="id" id="edit-id">
      <input type="hidden" name="image_existing" id="edit-image-existing">

      <!-- Nama + Jenis -->
      <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
        <div class="flex flex-col gap-1.5">
          <label for="edit-name" class="text-sm font-bold text-ink">Nama Lapangan</label>
          <input id="edit-name" name="name" type="text" required placeholder="Contoh: Arena Garuda A"
                 class="w-full rounded-xl border border-black/10 bg-snow px-4 py-2.5 text-sm text-ink outline-none focus:ring-2 focus:ring-brand">
        </div>
        <div class="flex flex-col gap-1.5">
          <label for="edit-sport" class="text-sm font-bold text-ink">Jenis Olahraga</label>
          <select id="edit-sport" name="sport_type" required
                  class="w-full cursor-pointer rounded-xl border border-black/10 bg-snow px-4 py-2.5 text-sm text-ink outline-none focus:ring-2 focus:ring-brand">
            <option value="">-- Pilih --</option>
            <?php foreach ($pilihanSport as $s): ?>
              <option value="<?= $s ?>"><?= $s ?></option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>

      <!-- Deskripsi -->
      <div class="flex flex-col gap-1.5">
        <label for="edit-desc" class="text-sm font-bold text-ink">Deskripsi <span class="font-normal text-steel">(opsional)</span></label>
        <textarea id="edit-desc" name="description" rows="2" placeholder="Deskripsikan lapangan..."
                  class="w-full resize-none rounded-xl border border-black/10 bg-snow px-4 py-2.5 text-sm text-ink outline-none focus:ring-2 focus:ring-brand"></textarea>
      </div>

      <!-- Fasilitas -->
      <div class="flex flex-col gap-1.5">
        <label for="edit-facilities" class="text-sm font-bold text-ink">Fasilitas <span class="font-normal text-steel">(pisahkan koma)</span></label>
        <input id="edit-facilities" name="facilities" type="text" placeholder="Contoh: Parkir, Toilet, Kantin"
               class="w-full rounded-xl border border-black/10 bg-snow px-4 py-2.5 text-sm text-ink outline-none focus:ring-2 focus:ring-brand">
      </div>

      <!-- Harga + Upload foto -->
      <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
        <div class="flex flex-col gap-1.5">
          <label for="edit-price" class="text-sm font-bold text-ink">Harga per Jam (Rp)</label>
          <input id="edit-price" name="price_per_hour" type="number" min="1" required placeholder="Contoh: 100000"
                 class="w-full rounded-xl border border-black/10 bg-snow px-4 py-2.5 text-sm text-ink outline-none focus:ring-2 focus:ring-brand">
        </div>
        <div class="flex flex-col gap-1.5">
          <label class="text-sm font-bold text-ink">Foto <span class="font-normal text-steel">(kosongkan jika tidak diganti)</span></label>
          <div class="flex items-center gap-2">
            <img id="edit-current-preview" src="" alt="Foto saat ini"
                 class="h-10 w-14 shrink-0 rounded-lg object-cover border border-black/10 bg-snow">
            <span class="truncate text-xs text-steel" id="edit-current-filename"></span>
          </div>
          <label for="edit-image"
                 class="flex cursor-pointer items-center gap-2 rounded-xl border-2 border-dashed border-black/15 bg-snow px-3 py-2.5 text-sm text-steel transition hover:border-brand hover:bg-brand/5">
            <span class="material-symbols-outlined text-[20px] text-steel/60">upload_file</span>
            <span id="edit-file-name" class="truncate">Pilih foto baru...</span>
          </label>
          <input id="edit-image" name="image" type="file" accept="image/jpeg,image/png,image/webp"
                 class="sr-only" onchange="previewFileNameEdit()">
          <img id="edit-new-preview" src="" alt="Preview baru"
               class="hidden mt-1 h-20 w-full rounded-xl object-cover border border-black/10">
        </div>
      </div>

      <!-- Tombol aksi -->
      <div class="flex flex-col-reverse gap-2 border-t border-black/5 pt-4 sm:flex-row">
        <button type="button" onclick="tutupModalEdit()"
                class="w-full rounded-xl border border-black/10 bg-snow py-2.5 text-sm font-bold text-steel transition hover:bg-black/5 sm:w-auto sm:px-6">
          Batal
        </button>
        <button type="submit"
                class="flex flex-1 items-center justify-center gap-2 rounded-xl bg-brand py-2.5 text-sm font-bold text-ink transition hover:bg-brand-hover">
          <span class="material-symbols-outlined text-[18px]">save</span>
          Simpan Perubahan
        </button>
      </div>
    </form>
  </div>
</div>

<script>
  function bukaDalogEdit(lapangan) {
    document.getElementById('edit-id').value             = lapangan.id;
    document.getElementById('edit-image-existing').value = lapangan.image ?? 'court.jpg';
    document.getElementById('edit-name').value           = lapangan.name;
    document.getElementById('edit-desc').value           = lapangan.description  ?? '';
    document.getElementById('edit-facilities').value     = lapangan.facilities   ?? '';
    document.getElementById('edit-price').value          = lapangan.price_per_hour;

    const currentPreview  = document.getElementById('edit-current-preview');
    const currentFilename = document.getElementById('edit-current-filename');
    if (currentPreview)  currentPreview.src        = '/images/' + (lapangan.image || 'court.jpg');
    if (currentFilename) currentFilename.textContent = lapangan.image || 'court.jpg';

    const newPreview = document.getElementById('edit-new-preview');
    const fileInput  = document.getElementById('edit-image');
    const fnLabel    = document.getElementById('edit-file-name');
    if (newPreview) { newPreview.src = ''; newPreview.classList.add('hidden'); }
    if (fileInput)    fileInput.value = '';
    if (fnLabel)      fnLabel.textContent = 'Pilih foto baru...';

    const sel = document.getElementById('edit-sport');
    for (let i = 0; i < sel.options.length; i++) {
      if (sel.options[i].value === lapangan.sport_type) { sel.selectedIndex = i; break; }
    }

    const modal = document.getElementById('modal-edit');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.style.overflow = 'hidden';
  }

  function tutupModalEdit(e) {
    if (e && e.target !== document.getElementById('modal-edit')) return;
    const modal = document.getElementById('modal-edit');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    document.body.style.overflow = '';
  }

  function previewFileNameEdit() {
    const input   = document.getElementById('edit-image');
    const label   = document.getElementById('edit-file-name');
    const preview = document.getElementById('edit-new-preview');
    if (!input?.files?.[0]) return;
    const file = input.files[0];
    if (label)   label.textContent = file.name;
    if (preview) { preview.src = URL.createObjectURL(file); preview.classList.remove('hidden'); }
  }
</script>

<?php require __DIR__ . '/../layout/footer.php'; ?>