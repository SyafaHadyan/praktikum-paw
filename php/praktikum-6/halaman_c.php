<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Halaman C</title>
  <link rel="stylesheet" href="/style.css" />
  <style>
    .content-page {
      padding: var(--page-padding);
      display: flex;
      flex-direction: column;
      gap: 24px;
    }

    .content-title {
      font-size: var(--fs-display);
      line-height: var(--lh-display);
      letter-spacing: var(--ls-display);
      color: var(--color-accent);
      font-weight: 400;
    }

    .info-box {
      border: 4px solid var(--color-accent);
      padding: 24px;
      max-width: 560px;
      display: flex;
      flex-direction: column;
      gap: 8px;
    }

    .info-box p {
      font-size: var(--fs-body);
      line-height: var(--lh-body);
      letter-spacing: var(--ls-body);
    }
  </style>
</head>

<body>
  <nav class="navbar">
    <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
      <?php if ($_SESSION['role'] === 'admin'): ?>
        <a href="/php/praktikum-6/halaman_a.php" class="navbar-link">
          <span class="navbar-en">Page A</span>
          <span class="navbar-jp">ページA</span>
        </a>
      <?php endif; ?>
      <a href="/php/praktikum-6/halaman_b.php" class="navbar-link">
        <span class="navbar-en">Page B</span>
        <span class="navbar-jp">ページB</span>
      </a>
    <?php else: ?>
      <a href="/php/praktikum-6/login.php" class="navbar-link">
        <span class="navbar-en">Login</span>
        <span class="navbar-jp">ログイン</span>
      </a>
    <?php endif; ?>
    <a href="/php/praktikum-6/halaman_c.php" class="navbar-link navbar-link--active">
      <span class="navbar-en">Page C</span>
      <span class="navbar-jp">ページC</span>
    </a>
    <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
      <a href="/php/praktikum-6/logout.php" class="navbar-link">
        <span class="navbar-en">Logout</span>
        <span class="navbar-jp">ログアウト</span>
      </a>
    <?php endif; ?>
  </nav>

  <main class="content-page">
    <h1 class="content-title">ページC</h1>

    <div class="info-box">
      <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
        <p>Selamat datang, <strong><?= htmlspecialchars($_SESSION['username']) ?></strong>.</p>
        <p>Role: <strong><?= htmlspecialchars($_SESSION['role']) ?></strong></p>
      <?php else: ?>
        <p>Anda mengakses halaman ini sebagai <strong>tamu</strong>.</p>
      <?php endif; ?>
      <p>Halaman ini dapat diakses oleh <strong>semua orang</strong>.</p>
      <?php if (isset($_COOKIE['last_user'])): ?>
        <p>Cookie <code>last_user</code>: <strong><?= htmlspecialchars($_COOKIE['last_user']) ?></strong></p>
      <?php endif; ?>
    </div>
  </main>
</body>

</html>
