<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
  header('Location: /php/praktikum-6/login.php');
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Halaman B</title>
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
    <?php if ($_SESSION['role'] === 'admin'): ?>
      <a href="/php/praktikum-6/halaman_a.php" class="navbar-link">
        <span class="navbar-en">Page A</span>
        <span class="navbar-jp">ページA</span>
      </a>
    <?php endif; ?>
    <a href="/php/praktikum-6/halaman_b.php" class="navbar-link navbar-link--active">
      <span class="navbar-en">Page B</span>
      <span class="navbar-jp">ページB</span>
    </a>
    <a href="/php/praktikum-6/halaman_c.php" class="navbar-link">
      <span class="navbar-en">Page C</span>
      <span class="navbar-jp">ページC</span>
    </a>
    <a href="/php/praktikum-6/logout.php" class="navbar-link">
      <span class="navbar-en">Logout</span>
      <span class="navbar-jp">ログアウト</span>
    </a>
  </nav>

  <main class="content-page">
    <h1 class="content-title">ページB</h1>

    <div class="info-box">
      <p>Selamat datang, <strong><?= htmlspecialchars($_SESSION['username']) ?></strong>.</p>
      <p>Role: <strong><?= htmlspecialchars($_SESSION['role']) ?></strong></p>
      <p>Halaman ini dapat diakses oleh <strong>admin</strong> dan <strong>member</strong>.</p>
      <?php if (isset($_COOKIE['last_user'])): ?>
        <p>Cookie <code>last_user</code>: <strong><?= htmlspecialchars($_COOKIE['last_user']) ?></strong></p>
      <?php endif; ?>
    </div>
  </main>
</body>

</html>
