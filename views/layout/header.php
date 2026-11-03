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
  <link rel="stylesheet" href="/css/output.css">

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
  <link rel="stylesheet" href="/css/style.css">
</head>
<body class="bg-ink font-sans text-snow antialiased">

<header class="sticky top-0 z-30 px-4 pt-4">
  <div class="mx-auto max-w-6xl">
    <div class="flex h-16 items-center justify-between rounded-full border border-white/10 bg-ink/80 px-4 shadow-lg backdrop-blur">

      <a href="/" class="flex items-center gap-2 text-lg font-bold">
        <span class="grid h-9 w-9 place-items-center rounded-full bg-brand text-ink">
          <svg viewBox="0 0 24 24" class="h-5 w-5" fill="currentColor"><path d="M13 2 4 14h6l-1 8 9-12h-6z"/></svg>
        </span>
        Sport<span class="text-brand">Space</span>
      </a>

      <nav class="hidden items-center gap-1 text-sm font-medium md:flex">
        <?php foreach ($navLinks as [$href, $label]): ?>
          <a href="<?= $href ?>"
             class="rounded-full px-4 py-2 transition hover:bg-white/10 <?= $current === $href ? 'bg-white/10' : '' ?>">
            <?= $label ?>
          </a>
        <?php endforeach; ?>
      </nav>

      <div class="hidden items-center gap-2 md:flex">
        <?php if ($loggedIn): ?>
          <form action="/logout" method="POST">
            <button type="submit" class="rounded-full bg-brand px-5 py-2 text-sm font-bold text-ink transition hover:bg-brand-hover">Logout</button>
          </form>
        <?php else: ?>
          <a href="/login" class="rounded-full bg-brand px-5 py-2 text-sm font-bold text-ink transition hover:bg-brand-hover">Masuk / Daftar</a>
        <?php endif; ?>
      </div>

      <button id="menu-btn" type="button" aria-expanded="false" aria-controls="mobile-menu"
              class="rounded-full border border-white/20 px-4 py-2 text-sm font-semibold md:hidden">Menu</button>
    </div>

    <!-- Menu mobile -->
    <div id="mobile-menu" class="mt-2 hidden rounded-2xl border border-white/10 bg-ink p-3 md:hidden">
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