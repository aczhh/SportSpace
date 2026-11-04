<?php
// =============================================
// PARTIAL VIEW: Form Tambah Lapangan
// Tanggung jawab: Anggota 2
// File ini di-include oleh views/admin/courts.php
// Variabel yang dipakai: $pilihanSport
// =============================================

// Jenis olahraga (sudah didefinisikan di courts.php,
// tapi kita tambahkan default agar file ini bisa berdiri sendiri)
if (!isset($pilihanSport)) {
    $pilihanSport = ['Futsal', 'Badminton', 'Basket'];
}
?>

<form action="/admin/courts/store" method="POST" class="space-y-4">

  <!-- Nama lapangan -->
  <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
    <div class="flex flex-col gap-1.5">
      <label for="tambah-name" class="text-sm font-bold text-ink">
        Nama Lapangan <span class="text-red-500">*</span>
      </label>
      <input id="tambah-name" name="name" type="text" required
             placeholder="Contoh: Arena Garuda A"
             class="w-full rounded-xl border border-black/10 bg-snow px-4 py-2.5 text-sm text-ink outline-none focus:ring-2 focus:ring-brand">
    </div>

    <!-- Jenis olahraga -->
    <div class="flex flex-col gap-1.5">
      <label for="tambah-sport" class="text-sm font-bold text-ink">
        Jenis Olahraga <span class="text-red-500">*</span>
      </label>
      <select id="tambah-sport" name="sport_type" required
              class="w-full cursor-pointer rounded-xl border border-black/10 bg-snow px-4 py-2.5 text-sm text-ink outline-none focus:ring-2 focus:ring-brand">
        <option value="">-- Pilih Olahraga --</option>
        <?php foreach ($pilihanSport as $s): ?>
          <option value="<?= $s ?>"><?= $s ?></option>
        <?php endforeach; ?>
      </select>
    </div>
  </div>

  <!-- Deskripsi -->
  <div class="flex flex-col gap-1.5">
    <label for="tambah-desc" class="text-sm font-bold text-ink">
      Deskripsi <span class="font-normal text-steel">(opsional)</span>
    </label>
    <textarea id="tambah-desc" name="description" rows="3"
              placeholder="Deskripsikan lapangan ini secara singkat..."
              class="w-full resize-none rounded-xl border border-black/10 bg-snow px-4 py-2.5 text-sm text-ink outline-none focus:ring-2 focus:ring-brand"></textarea>
  </div>

  <!-- Fasilitas -->
  <div class="flex flex-col gap-1.5">
    <label for="tambah-facilities" class="text-sm font-bold text-ink">
      Fasilitas <span class="font-normal text-steel">(pisahkan dengan koma)</span>
    </label>
    <input id="tambah-facilities" name="facilities" type="text"
           placeholder="Contoh: Parkir, Toilet, Kantin, Ruang Ganti"
           class="w-full rounded-xl border border-black/10 bg-snow px-4 py-2.5 text-sm text-ink outline-none focus:ring-2 focus:ring-brand">
    <p class="text-xs text-steel">Fasilitas akan ditampilkan sebagai label pada halaman lapangan.</p>
  </div>

  <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
    <!-- Harga per jam -->
    <div class="flex flex-col gap-1.5">
      <label for="tambah-price" class="text-sm font-bold text-ink">
        Harga per Jam (Rp) <span class="text-red-500">*</span>
      </label>
      <input id="tambah-price" name="price_per_hour" type="number" min="1" required
             placeholder="Contoh: 100000"
             class="w-full rounded-xl border border-black/10 bg-snow px-4 py-2.5 text-sm text-ink outline-none focus:ring-2 focus:ring-brand">
    </div>

    <!-- Nama file gambar -->
    <div class="flex flex-col gap-1.5">
      <label for="tambah-image" class="text-sm font-bold text-ink">
        Nama File Gambar <span class="font-normal text-steel">(di folder public/images/)</span>
      </label>
      <input id="tambah-image" name="image" type="text"
             placeholder="Contoh: court.jpg"
             value="court.jpg"
             class="w-full rounded-xl border border-black/10 bg-snow px-4 py-2.5 text-sm text-ink outline-none focus:ring-2 focus:ring-brand">
    </div>
  </div>

  <!-- Tombol submit -->
  <div class="flex gap-3 border-t border-black/5 pt-4">
    <button type="submit"
            class="flex flex-1 items-center justify-center gap-2 rounded-xl bg-brand py-3 text-sm font-bold text-ink shadow-md transition hover:bg-brand-hover">
      <span class="material-symbols-outlined text-[20px]">add_circle</span>
      Simpan Lapangan Baru
    </button>
    <button type="button" onclick="tutupFormTambah()"
            class="rounded-xl border border-black/10 bg-snow px-5 py-3 text-sm font-bold text-steel transition hover:bg-black/5">
      Batal
    </button>
  </div>

</form>
