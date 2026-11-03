<footer class="w-full border-t border-black/10 bg-steel pb-10 pt-14 text-white">
  <div class="mx-auto max-w-6xl px-4 sm:px-6">
    <div class="grid grid-cols-1 gap-8 border-b border-white/10 pb-10 md:grid-cols-3">

      <div class="space-y-4">
        <a href="/" class="flex items-center gap-2">
          <span class="flex h-9 w-9 items-center justify-center rounded-full bg-brand text-ink">
            <span class="material-symbols-outlined text-[20px]">bolt</span>
          </span>
          <span class="text-xl font-extrabold uppercase tracking-tight text-brand">SportSpace</span>
        </a>
        <p class="text-sm leading-relaxed text-snow/80">
          Find Your Court, Book Your Game. Platform booking lapangan futsal, badminton, dan basket.
        </p>
      </div>

      <div class="space-y-3">
        <h4 class="font-bold text-brand">Menu</h4>
        <ul class="space-y-2 text-sm text-snow/80">
          <li><a href="/" class="transition hover:text-brand">Home</a></li>
          <li><a href="/courts" class="transition hover:text-brand">Daftar Lapangan</a></li>
          <li><a href="/my-bookings" class="transition hover:text-brand">My Booking</a></li>
        </ul>
      </div>

      <div class="space-y-3">
        <h4 class="font-bold text-brand">Akun</h4>
        <ul class="space-y-2 text-sm text-snow/80">
          <li><a href="/login" class="transition hover:text-brand">Masuk</a></li>
          <li><a href="/register" class="transition hover:text-brand">Daftar</a></li>
        </ul>
      </div>
    </div>

    <p class="pt-8 text-sm text-snow/70">&copy; <?= date('Y') ?> SportSpace. Proyek Pemrograman Web.</p>
  </div>
</footer>

<script src="/js/script.js"></script>
</body>
</html>