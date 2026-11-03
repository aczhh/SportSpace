<?php
$loggedIn = isset($_SESSION['user_id']);
$role     = $_SESSION['role'] ?? null;
$current  = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$navLinks = [['/', 'Home'], ['/courts', 'Lapangan']];
if ($loggedIn && $role === 'customer') $navLinks[] = ['/my-bookings', 'My Booking'];
if ($loggedIn && $role === 'admin')    $navLinks[] = ['/admin', 'Dashboard'];
$navLinks[] = ['/#keunggulan', 'Keunggulan'];
?>
<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="/SportSpace/public/css/output.css">

  <title>SportSpace – Find Your Court, Book Your Game</title>

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
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">
  <link rel="stylesheet" href="/css/style.css">
</head>
<body class="bg-snow text-ink antialiased">

<header class="pointer-events-none fixed left-0 right-0 top-5 z-50 px-4">
  <div class="pointer-events-auto mx-auto max-w-6xl">
    <div class="flex h-16 items-center justify-between rounded-full border border-white/15 bg-ink/70 px-4 shadow-2xl backdrop-blur-md sm:px-6">

      <a href="/" class="group flex items-center gap-2">
        <span class="flex h-9 w-9 items-center justify-center rounded-full bg-brand text-ink shadow-md transition group-hover:scale-105">
          <span class="material-symbols-outlined text-[20px]">bolt</span>
        </span>
        <span class="text-xl font-extrabold uppercase tracking-tight text-brand">SportSpace</span>
      </a>

      <nav class="hidden items-center gap-1 text-sm font-bold lg:flex">
        <?php foreach ($navLinks as [$href, $label]): ?>
          <a href="<?= $href ?>"
             class="rounded-full px-4 py-1.5 text-white/90 transition hover:text-brand <?= $current === $href ? 'bg-white/15 text-white' : '' ?>">
            <?= $label ?>
          </a>
        <?php endforeach; ?>
      </nav>

      <div class="flex items-center gap-3">
        <?php if ($loggedIn): ?>
          <form action="/logout" method="POST" class="hidden sm:block">
            <button type="submit" class="rounded-full bg-brand px-5 py-2 text-[13px] font-bold text-ink shadow-md transition hover:bg-brand-hover">Logout</button>
          </form>
        <?php else: ?>
          <a href="/login" class="hidden rounded-full bg-brand px-5 py-2 text-[13px] font-bold text-ink shadow-md transition hover:bg-brand-hover sm:inline-flex">Masuk / Daftar</a>
        <?php endif; ?>

        <button id="menu-btn" type="button" aria-expanded="false" aria-controls="mobile-menu"
                class="rounded-full border border-white/20 px-4 py-2 text-sm font-semibold text-white lg:hidden">Menu</button>
      </div>
    </div>

    <!-- Menu mobile -->
    <div id="mobile-menu" class="mt-2 hidden rounded-2xl border border-white/10 bg-ink p-3 text-white lg:hidden">
      <?php foreach ($navLinks as [$href, $label]): ?>
        <a href="<?= $href ?>" class="block rounded-xl px-4 py-3 font-medium hover:bg-white/10"><?= $label ?></a>
      <?php endforeach; ?>
      <div class="mt-2 border-t border-white/10 pt-3">
        <?php if ($loggedIn): ?>
          <form action="/logout" method="POST">
            <button type="submit" class="w-full rounded-xl bg-brand px-4 py-3 font-bold text-ink">Logout</button>
          </form>
        <?php else: ?>
          <a href="/login" class="block rounded-xl bg-brand px-4 py-3 text-center font-bold text-ink">Masuk / Daftar</a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</header>