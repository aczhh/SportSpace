<?php
// Gunakan $_SESSION['user'] (array) sebagai sumber data user
$loggedIn  = isset($_SESSION['user']);
$role      = $_SESSION['user']['role']  ?? null;
$userName  = $_SESSION['user']['name']  ?? '';
$userEmail = $_SESSION['user']['email'] ?? '';
$current   = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Daftar nav berdasarkan role
if ($role === 'admin') {
    $navLinks = [
        ['/admin',          'Dashboard'],
        ['/admin/courts',   'Kelola Lapangan'],
        ['/admin/bookings', 'Kelola Booking'],
    ];
} else {
    $navLinks = [['/', 'Home'], ['/courts', 'Lapangan']];
    if ($loggedIn) $navLinks[] = ['/my-bookings', 'My Booking'];
    $navLinks[] = ['/#keunggulan', 'Keunggulan'];
}

// Inisial nama untuk avatar
$inisial = $loggedIn ? mb_strtoupper(mb_substr($userName, 0, 1)) : '?';
?>
<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="/css/output.css">

  <title>SportSpace – Find Your Court, Book Your Game</title>

  <!-- Material Symbols -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200">

  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            brand: { DEFAULT: '#BFFF1A', hover: '#7CFF00' },
            steel: '#3D3F44',
            ink: '#121418',
            snow: '#EDEFF2'
          }
        }
      }
    }
  </script>
  <link rel="stylesheet" href="/css/style.css">
</head>
<body class="flex min-h-screen flex-col bg-snow text-ink antialiased overscroll-y-none">

<header class="pointer-events-none fixed left-0 right-0 top-5 z-50 px-4">
  <div class="pointer-events-auto mx-auto max-w-6xl">
    <div class="flex h-16 items-center justify-between rounded-full border border-white/15 bg-ink/70 px-4 shadow-2xl backdrop-blur-md sm:px-6">

      <!-- Logo -->
      <a href="/" class="group flex items-center gap-2">
        <span class="flex h-9 w-9 items-center justify-center rounded-full bg-brand text-ink shadow-md transition group-hover:scale-105">
          <span class="material-symbols-outlined text-[20px]">bolt</span>
        </span>
        <span class="text-xl font-extrabold uppercase tracking-tight text-brand">SportSpace</span>
      </a>

      <!-- Nav Desktop -->
      <nav class="hidden items-center gap-1 text-sm font-bold lg:flex">
        <?php foreach ($navLinks as [$href, $label]): ?>
          <a href="<?= $href ?>"
             class="rounded-full px-4 py-1.5 text-white/90 transition hover:text-brand <?= $current === $href ? 'bg-white/15 text-white' : '' ?>">
            <?= $label ?>
          </a>
        <?php endforeach; ?>
      </nav>

      <!-- Kanan: User Icon atau Masuk -->
      <div class="flex items-center gap-3">
        <?php if ($loggedIn): ?>

          <!-- User Dropdown -->
          <div class="relative" id="user-menu-wrapper">
            <button id="user-menu-btn"
                    type="button"
                    onclick="toggleUserMenu()"
                    class="flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-3 py-1.5 text-sm font-semibold text-white transition hover:bg-white/20">
              <!-- Avatar inisial -->
              <span class="flex h-7 w-7 items-center justify-center rounded-full bg-brand text-ink text-xs font-extrabold select-none">
                <?= htmlspecialchars($inisial) ?>
              </span>
              <span class="hidden sm:inline max-w-[100px] truncate"><?= htmlspecialchars($userName) ?></span>
              <span class="material-symbols-outlined text-[16px] text-white/60" id="user-chevron">expand_more</span>
            </button>

            <!-- Dropdown Panel -->
            <div id="user-dropdown"
                 class="absolute right-0 top-full mt-2 hidden w-64 rounded-2xl border border-white/10 bg-ink shadow-2xl overflow-hidden z-50">

              <!-- Info Akun -->
              <div class="px-4 py-4 border-b border-white/10">
                <div class="flex items-center gap-3">
                  <span class="flex h-10 w-10 items-center justify-center rounded-full bg-brand text-ink text-sm font-extrabold shrink-0">
                    <?= htmlspecialchars($inisial) ?>
                  </span>
                  <div class="min-w-0">
                    <p class="font-bold text-white text-sm truncate"><?= htmlspecialchars($userName) ?></p>
                    <p class="text-xs text-white/50 truncate"><?= htmlspecialchars($userEmail) ?></p>
                    <?php if ($role === 'admin'): ?>
                      <span class="inline-block mt-1 rounded-full bg-brand/20 px-2 py-0.5 text-[10px] font-bold text-brand uppercase tracking-wide">Admin</span>
                    <?php endif; ?>
                  </div>
                </div>
              </div>

              <!-- Menu Item -->
              <div class="py-2">
                <?php if ($role !== 'admin'): ?>
                  <a href="/profile"
                     class="flex items-center gap-3 px-4 py-2.5 text-sm text-white/80 hover:bg-white/10 hover:text-white transition">
                    <span class="material-symbols-outlined text-[18px]">manage_accounts</span>
                    Pengaturan Profil
                  </a>
                  <a href="/my-bookings"
                     class="flex items-center gap-3 px-4 py-2.5 text-sm text-white/80 hover:bg-white/10 hover:text-white transition">
                    <span class="material-symbols-outlined text-[18px]">receipt_long</span>
                    My Booking
                  </a>
                <?php else: ?>
                  <a href="/admin"
                     class="flex items-center gap-3 px-4 py-2.5 text-sm text-white/80 hover:bg-white/10 hover:text-white transition">
                    <span class="material-symbols-outlined text-[18px]">dashboard</span>
                    Dashboard Admin
                  </a>
                <?php endif; ?>
              </div>

              <!-- Logout -->
              <div class="border-t border-white/10 p-2">
                <form action="/logout" method="POST">
                  <button type="submit"
                          class="flex w-full items-center gap-3 rounded-xl px-4 py-2.5 text-sm font-semibold text-red-400 hover:bg-red-500/10 transition">
                    <span class="material-symbols-outlined text-[18px]">logout</span>
                    Logout
                  </button>
                </form>
              </div>
            </div>
          </div>

        <?php else: ?>
          <a href="/login"
             class="hidden rounded-full bg-brand px-5 py-2 text-[13px] font-bold text-ink shadow-md transition hover:bg-brand-hover sm:inline-flex">
            Masuk / Daftar
          </a>
        <?php endif; ?>

        <!-- Tombol menu mobile -->
        <button id="menu-btn" type="button" aria-expanded="false" aria-controls="mobile-menu"
                class="rounded-full border border-white/20 px-4 py-2 text-sm font-semibold text-white lg:hidden">Menu</button>
      </div>
    </div>

    <!-- Menu Mobile -->
    <div id="mobile-menu" class="mt-2 hidden rounded-2xl border border-white/10 bg-ink p-3 text-white lg:hidden">
      <?php foreach ($navLinks as [$href, $label]): ?>
        <a href="<?= $href ?>" class="block rounded-xl px-4 py-3 font-medium hover:bg-white/10"><?= $label ?></a>
      <?php endforeach; ?>
      <div class="mt-2 border-t border-white/10 pt-3">
        <?php if ($loggedIn): ?>
          <?php if ($role !== 'admin'): ?>
            <a href="/profile" class="block rounded-xl px-4 py-3 text-sm font-medium hover:bg-white/10">
              👤 <?= htmlspecialchars($userName) ?> – Pengaturan Profil
            </a>
          <?php endif; ?>
          <form action="/logout" method="POST">
            <button type="submit" class="mt-1 w-full rounded-xl bg-red-500/10 border border-red-500/20 px-4 py-3 text-left font-bold text-red-400 hover:bg-red-500/20 transition text-sm">
              Logout
            </button>
          </form>
        <?php else: ?>
          <a href="/login" class="block rounded-xl bg-brand px-4 py-3 text-center font-bold text-ink">Masuk / Daftar</a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</header>

<script>
  // ── Toggle mobile menu ──
  const menuBtn    = document.getElementById('menu-btn');
  const mobileMenu = document.getElementById('mobile-menu');
  if (menuBtn && mobileMenu) {
    menuBtn.addEventListener('click', () => {
      mobileMenu.classList.toggle('hidden');
      menuBtn.setAttribute('aria-expanded', !mobileMenu.classList.contains('hidden'));
    });
  }

  // ── Toggle user dropdown ──
  function toggleUserMenu() {
    const dropdown = document.getElementById('user-dropdown');
    const chevron  = document.getElementById('user-chevron');
    if (!dropdown) return;
    const isOpen = !dropdown.classList.contains('hidden');
    dropdown.classList.toggle('hidden', isOpen);
    if (chevron) chevron.textContent = isOpen ? 'expand_more' : 'expand_less';
  }

  // Klik di luar dropdown → tutup
  document.addEventListener('click', function(e) {
    const wrapper  = document.getElementById('user-menu-wrapper');
    const dropdown = document.getElementById('user-dropdown');
    const chevron  = document.getElementById('user-chevron');
    if (wrapper && dropdown && !wrapper.contains(e.target)) {
      dropdown.classList.add('hidden');
      if (chevron) chevron.textContent = 'expand_more';
    }
  });
</script>
