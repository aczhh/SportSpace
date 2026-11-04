<?php
// =============================================
// VIEW: Kelola Lapangan (Admin)
// Tanggung jawab: Anggota 2
// Variabel dari AdminController:
//   $daftarLapangan = array semua lapangan
//   $sukses         = string pesan sukses (opsional)
//   $error          = string pesan error (opsional)
// =============================================

$daftarLapangan = $daftarLapangan ?? [];
$sukses         = $sukses         ?? null;
$error          = $error          ?? null;

// Jenis olahraga yang tersedia
$pilihanSport = ['Futsal', 'Badminton', 'Basket'];

// Jika ada data edit yang dikirim balik (misalnya setelah error update),
// ambil dari session supaya form edit tidak kosong
$dataEdit = $_SESSION['form_edit_lapangan'] ?? null;
unset($_SESSION['form_edit_lapangan']);

require __DIR__ . '/../layout/header.php';
?>

<main class="min-h-screen bg-snow pt-28 pb-16">
  <div class="mx-auto max-w-6xl px-4 sm:px-6">

    <!-- ========== Header Halaman ========== -->
    <div class="mb-8 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
      <div>
        <h1 class="text-3xl font-extrabold tracking-tight text-ink">Kelola Lapangan</h1>
        <p class="mt-1 text-steel">Tambah, ubah, dan hapus data lapangan olahraga.</p>
      </div>
      <!-- Tombol kembali ke dashboard -->
      <a href="/admin"
         class="inline-flex items-center gap-1 self-start rounded-xl border border-black/10 bg-white px-4 py-2 text-sm font-bold text-ink shadow-sm transition hover:bg-ink hover:text-brand sm:self-auto">
        <span class="material-symbols-outlined text-[18px]">dashboard</span>
        Dashboard
      </a>
    </div>

    <!-- ========== Pesan Sukses / Error ========== -->
    <?php if ($sukses): ?>
      <div class="mb-6 flex items-center gap-3 rounded-xl border border-green-200 bg-green-50 p-4 text-sm font-semibold text-green-800">
        <span class="material-symbols-outlined text-[20px]">check_circle</span>
        <?= htmlspecialchars($sukses) ?>
      </div>
    <?php endif; ?>

    <?php if ($error): ?>
      <div class="mb-6 flex items-center gap-3 rounded-xl border border-red-200 bg-red-50 p-4 text-sm font-semibold text-red-700">
        <span class="material-symbols-outlined text-[20px]">error</span>
        <?= htmlspecialchars($error) ?>
      </div>
    <?php endif; ?>

    <!-- ========== Tombol Buka Form Tambah ========== -->
    <div class="mb-5">
      <button id="btn-buka-form-tambah" type="button"
              onclick="tampilFormTambah()"
              class="inline-flex items-center gap-2 rounded-xl bg-brand px-5 py-2.5 text-sm font-bold text-ink shadow-md transition hover:bg-brand-hover">
        <span class="material-symbols-outlined text-[20px]">add_circle</span>
        Tambah Lapangan
      </button>
    </div>

    <!-- ========== Form Tambah Lapangan (tersembunyi default) ========== -->
    <div id="form-tambah" class="mb-8 hidden">
      <div class="rounded-2xl border border-black/10 bg-white p-6 shadow-md">
        <div class="mb-5 flex items-center justify-between">
          <h2 class="text-lg font-extrabold text-ink">
            <span class="material-symbols-outlined align-middle text-[22px] text-brand">add_circle</span>
            Tambah Lapangan Baru
          </h2>
          <button type="button" onclick="tutupFormTambah()"
                  class="rounded-full p-1 text-steel transition hover:bg-snow hover:text-ink">
            <span class="material-symbols-outlined text-[22px]">close</span>
          </button>
        </div>
        <?php include __DIR__ . '/court-form.php'; // Gunakan form yang sama ?>
      </div>
    </div>

    <!-- ========== Tabel Daftar Lapangan ========== -->
    <div class="overflow-hidden rounded-2xl border border-black/10 bg-white shadow-sm">
      <div class="overflow-x-auto">
        <table class="w-full text-sm">
          <thead class="border-b border-black/10 bg-snow text-xs font-extrabold uppercase tracking-wider text-steel">
            <tr>
              <th class="px-5 py-4 text-left">Lapangan</th>
              <th class="px-5 py-4 text-left">Jenis</th>
              <th class="px-5 py-4 text-left">Fasilitas</th>
              <th class="px-5 py-4 text-left">Harga / Jam</th>
              <th class="px-5 py-4 text-left">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-black/5">
            <?php if (empty($daftarLapangan)): ?>
              <tr>
                <td colspan="5" class="px-5 py-16 text-center text-steel">
                  <span class="material-symbols-outlined mb-2 block text-[40px] text-steel/40">stadium</span>
                  Belum ada data lapangan. Tambah lapangan pertamamu!
                </td>
              </tr>
            <?php else: ?>
              <?php foreach ($daftarLapangan as $lapangan):
                $gambar    = !empty($lapangan['image']) ? $lapangan['image'] : 'court.jpg';
                $fasilitas = array_slice(
                  array_filter(array_map('trim', explode(',', (string)$lapangan['facilities']))),
                  0, 3
                );
              ?>
                <tr class="transition hover:bg-snow/60">

                  <!-- Gambar + nama lapangan -->
                  <td class="px-5 py-4">
                    <div class="flex items-center gap-3">
                      <img src="/images/<?= htmlspecialchars($gambar) ?>"
                           alt="<?= htmlspecialchars($lapangan['name']) ?>"
                           class="h-12 w-16 shrink-0 rounded-xl object-cover border border-black/5">
                      <span class="font-bold text-ink"><?= htmlspecialchars($lapangan['name']) ?></span>
                    </div>
                  </td>

                  <!-- Jenis olahraga -->
                  <td class="px-5 py-4">
                    <span class="rounded-full bg-brand/15 px-3 py-1 text-xs font-extrabold text-ink">
                      <?= htmlspecialchars($lapangan['sport_type']) ?>
                    </span>
                  </td>

                  <!-- Fasilitas (maks 3) -->
                  <td class="px-5 py-4">
                    <div class="flex flex-wrap gap-1">
                      <?php if (!empty($fasilitas)): ?>
                        <?php foreach ($fasilitas as $f): ?>
                          <span class="rounded-md bg-snow px-2 py-0.5 text-[11px] font-semibold text-steel">
                            <?= htmlspecialchars($f) ?>
                          </span>
                        <?php endforeach; ?>
                      <?php else: ?>
                        <span class="text-xs text-steel">—</span>
                      <?php endif; ?>
                    </div>
                  </td>

                  <!-- Harga per jam -->
                  <td class="px-5 py-4 font-bold text-ink">
                    Rp <?= number_format($lapangan['price_per_hour'], 0, ',', '.') ?>
                  </td>

                  <!-- Tombol aksi Edit & Hapus -->
                  <td class="px-5 py-4">
                    <div class="flex items-center gap-2">

                      <!-- Tombol Edit – membuka modal edit -->
                      <button type="button"
                              onclick="bukaDalogEdit(<?= htmlspecialchars(json_encode($lapangan)) ?>)"
                              class="inline-flex items-center gap-1 rounded-lg border border-black/10 bg-snow px-3 py-1.5 text-xs font-bold text-ink transition hover:bg-ink hover:text-brand">
                        <span class="material-symbols-outlined text-[15px]">edit</span>
                        Edit
                      </button>

                      <!-- Form Hapus -->
                      <form action="/admin/courts/delete" method="POST"
                            onsubmit="return confirm('Yakin ingin menghapus lapangan ini? Tindakan ini tidak bisa dibatalkan.')">
                        <input type="hidden" name="id" value="<?= (int)$lapangan['id'] ?>">
                        <button type="submit"
                                class="inline-flex items-center gap-1 rounded-lg border border-red-200 bg-red-50 px-3 py-1.5 text-xs font-bold text-red-700 transition hover:bg-red-600 hover:text-white">
                          <span class="material-symbols-outlined text-[15px]">delete</span>
                          Hapus
                        </button>
                      </form>

                    </div>
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

<!-- ========================================================
     MODAL EDIT LAPANGAN
     Muncul saat tombol Edit diklik
     ======================================================== -->
<div id="modal-edit"
     class="fixed inset-0 z-50 hidden items-center justify-center bg-black/60 px-4 backdrop-blur-sm"
     onclick="tutupModalEdit(event)">

  <div class="relative w-full max-w-2xl rounded-2xl border border-black/10 bg-white shadow-2xl"
       onclick="event.stopPropagation()">

    <!-- Header modal -->
    <div class="flex items-center justify-between border-b border-black/10 px-6 py-4">
      <h2 class="text-lg font-extrabold text-ink">
        <span class="material-symbols-outlined align-middle text-[22px] text-brand">edit</span>
        Edit Lapangan
      </h2>
      <button type="button" onclick="tutupModalEdit()"
              class="rounded-full p-1 text-steel transition hover:bg-snow hover:text-ink">
        <span class="material-symbols-outlined text-[22px]">close</span>
      </button>
    </div>

    <!-- Form edit di dalam modal -->
    <form action="/admin/courts/update" method="POST" class="space-y-4 p-6">
      <input type="hidden" name="id" id="edit-id">

      <!-- Nama lapangan -->
      <div class="flex flex-col gap-1.5">
        <label for="edit-name" class="text-sm font-bold text-ink">Nama Lapangan</label>
        <input id="edit-name" name="name" type="text" required
               placeholder="Contoh: Arena Garuda A"
               class="w-full rounded-xl border border-black/10 bg-snow px-4 py-2.5 text-sm text-ink outline-none focus:ring-2 focus:ring-brand">
      </div>

      <!-- Jenis olahraga -->
      <div class="flex flex-col gap-1.5">
        <label for="edit-sport" class="text-sm font-bold text-ink">Jenis Olahraga</label>
        <select id="edit-sport" name="sport_type" required
                class="w-full cursor-pointer rounded-xl border border-black/10 bg-snow px-4 py-2.5 text-sm text-ink outline-none focus:ring-2 focus:ring-brand">
          <option value="">-- Pilih Olahraga --</option>
          <?php foreach ($pilihanSport as $s): ?>
            <option value="<?= $s ?>"><?= $s ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <!-- Deskripsi -->
      <div class="flex flex-col gap-1.5">
        <label for="edit-desc" class="text-sm font-bold text-ink">Deskripsi <span class="font-normal text-steel">(opsional)</span></label>
        <textarea id="edit-desc" name="description" rows="3"
                  placeholder="Deskripsikan lapangan ini..."
                  class="w-full resize-none rounded-xl border border-black/10 bg-snow px-4 py-2.5 text-sm text-ink outline-none focus:ring-2 focus:ring-brand"></textarea>
      </div>

      <!-- Fasilitas -->
      <div class="flex flex-col gap-1.5">
        <label for="edit-facilities" class="text-sm font-bold text-ink">
          Fasilitas <span class="font-normal text-steel">(pisahkan dengan koma)</span>
        </label>
        <input id="edit-facilities" name="facilities" type="text"
               placeholder="Contoh: Parkir, Toilet, Kantin"
               class="w-full rounded-xl border border-black/10 bg-snow px-4 py-2.5 text-sm text-ink outline-none focus:ring-2 focus:ring-brand">
      </div>

      <!-- Harga per jam -->
      <div class="flex flex-col gap-1.5">
        <label for="edit-price" class="text-sm font-bold text-ink">Harga per Jam (Rp)</label>
        <input id="edit-price" name="price_per_hour" type="number" min="1" required
               placeholder="Contoh: 100000"
               class="w-full rounded-xl border border-black/10 bg-snow px-4 py-2.5 text-sm text-ink outline-none focus:ring-2 focus:ring-brand">
      </div>

      <!-- Nama file gambar -->
      <div class="flex flex-col gap-1.5">
        <label for="edit-image" class="text-sm font-bold text-ink">
          Nama File Gambar <span class="font-normal text-steel">(di folder public/images/)</span>
        </label>
        <input id="edit-image" name="image" type="text"
               placeholder="Contoh: court.jpg"
               class="w-full rounded-xl border border-black/10 bg-snow px-4 py-2.5 text-sm text-ink outline-none focus:ring-2 focus:ring-brand">
      </div>

      <!-- Tombol aksi -->
      <div class="flex gap-3 border-t border-black/5 pt-4">
        <button type="submit"
                class="flex flex-1 items-center justify-center gap-2 rounded-xl bg-brand py-2.5 text-sm font-bold text-ink transition hover:bg-brand-hover">
          <span class="material-symbols-outlined text-[18px]">save</span>
          Simpan Perubahan
        </button>
        <button type="button" onclick="tutupModalEdit()"
                class="rounded-xl border border-black/10 bg-snow px-5 py-2.5 text-sm font-bold text-steel transition hover:bg-black/5">
          Batal
        </button>
      </div>
    </form>
  </div>
</div>

<script>
  // ── Tampil / tutup form tambah ──
  function tampilFormTambah() {
    document.getElementById('form-tambah').classList.remove('hidden');
    document.getElementById('btn-buka-form-tambah').classList.add('hidden');
    document.getElementById('form-tambah').scrollIntoView({ behavior: 'smooth', block: 'start' });
  }
  function tutupFormTambah() {
    document.getElementById('form-tambah').classList.add('hidden');
    document.getElementById('btn-buka-form-tambah').classList.remove('hidden');
  }

  // ── Buka modal edit & isi data lapangan yang dipilih ──
  function bukaDalogEdit(lapangan) {
    document.getElementById('edit-id').value          = lapangan.id;
    document.getElementById('edit-name').value        = lapangan.name;
    document.getElementById('edit-desc').value        = lapangan.description  ?? '';
    document.getElementById('edit-facilities').value  = lapangan.facilities   ?? '';
    document.getElementById('edit-price').value       = lapangan.price_per_hour;
    document.getElementById('edit-image').value       = lapangan.image        ?? 'court.jpg';

    // Set selected option jenis olahraga
    const selectSport = document.getElementById('edit-sport');
    for (let i = 0; i < selectSport.options.length; i++) {
      if (selectSport.options[i].value === lapangan.sport_type) {
        selectSport.selectedIndex = i;
        break;
      }
    }

    document.getElementById('modal-edit').classList.remove('hidden');
    document.getElementById('modal-edit').classList.add('flex');
  }

  // ── Tutup modal edit ──
  function tutupModalEdit(e) {
    // Jika diklik di dalam konten modal, jangan tutup
    if (e && e.target !== document.getElementById('modal-edit')) return;
    document.getElementById('modal-edit').classList.add('hidden');
    document.getElementById('modal-edit').classList.remove('flex');
  }
</script>

<?php require __DIR__ . '/../layout/footer.php'; ?>
