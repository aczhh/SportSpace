<?php
// =============================================
// PARTIAL VIEW: Form Tambah Lapangan
// Tanggung jawab: Anggota 2
// File ini di-include oleh views/admin/courts.php
// =============================================

if (!isset($pilihanSport)) {
    $pilihanSport = ['Futsal', 'Badminton', 'Basket'];
}
?>

<form action="/admin/courts/store" method="POST" enctype="multipart/form-data" class="space-y-4">

  <!-- Baris 1: Nama + Jenis Olahraga -->
  <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
    <div class="flex flex-col gap-1.5">
      <label for="tambah-name" class="text-sm font-bold text-ink">
        Nama Lapangan <span class="text-red-500">*</span>
      </label>
      <input id="tambah-name" name="name" type="text" required
             placeholder="Contoh: Arena Garuda A"
             class="w-full rounded-xl border border-black/10 bg-snow px-4 py-2.5 text-sm text-ink outline-none focus:ring-2 focus:ring-brand">
    </div>

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
  </div>

  <!-- Baris 2: Harga + Upload Foto -->
  <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
    <div class="flex flex-col gap-1.5">
      <label for="tambah-price" class="text-sm font-bold text-ink">
        Harga per Jam (Rp) <span class="text-red-500">*</span>
      </label>
      <input id="tambah-price" name="price_per_hour" type="number" min="1" required
             placeholder="Contoh: 100000"
             class="w-full rounded-xl border border-black/10 bg-snow px-4 py-2.5 text-sm text-ink outline-none focus:ring-2 focus:ring-brand">
    </div>

    <!-- Upload Foto -->
    <div class="flex flex-col gap-1.5">
      <label for="tambah-image" class="text-sm font-bold text-ink">
        Foto Lapangan <span class="font-normal text-steel">(jpg/png/webp, maks 2MB)</span>
      </label>
      <label for="tambah-image"
             class="flex cursor-pointer items-center gap-3 rounded-xl border-2 border-dashed border-black/15 bg-snow px-4 py-3 text-sm text-steel transition hover:border-brand hover:bg-brand/5"
             id="tambah-upload-label">
        <span class="material-symbols-outlined text-[22px] text-steel/60">upload_file</span>
        <span id="tambah-file-name">Pilih foto lapangan...</span>
      </label>
      <input id="tambah-image" name="image" type="file" accept="image/jpeg,image/png,image/webp"
             class="sr-only"
             onchange="previewFileName('tambah-image','tambah-file-name','tambah-preview')">
      <!-- Preview thumbnail -->
      <img id="tambah-preview" src="" alt="Preview" class="hidden mt-2 h-24 w-full rounded-xl object-cover border border-black/10">
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

<script>
  // Preview nama file + thumbnail gambar
  function previewFileName(inputId, labelId, previewId) {
    const input   = document.getElementById(inputId);
    const label   = document.getElementById(labelId);
    const preview = document.getElementById(previewId);
    if (!input || !input.files || !input.files[0]) return;
    const file = input.files[0];
    if (label)   label.textContent = file.name;
    if (preview) {
      const url = URL.createObjectURL(file);
      preview.src = url;
      preview.classList.remove('hidden');
    }
  }
</script>
