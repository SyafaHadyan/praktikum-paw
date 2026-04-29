<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
  header('Location: /php/praktikum-7/login.php');
  exit;
}

require_once __DIR__ . '/db.php';

try {
  $conn = getConnection();
  $stmt = $conn->prepare("SELECT id, username, email, full_name, created_at FROM users WHERE id = :id");
  $stmt->execute([':id' => $_SESSION['user_id']]);
  $user = $stmt->fetch();
} catch (PDOException $e) {
  $user = null;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard — Praktikum 7</title>
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

    .profile-card {
      border: 4px solid var(--color-accent);
      padding: 28px;
      max-width: 520px;
      display: flex;
      flex-direction: column;
      gap: 12px;
    }

    .profile-row {
      display: flex;
      flex-direction: column;
      gap: 2px;
    }

    .profile-label {
      font-size: 12px;
      letter-spacing: 1px;
      text-transform: uppercase;
      opacity: 0.6;
    }

    .profile-value {
      font-size: var(--fs-body);
      line-height: var(--lh-body);
      font-weight: 500;
    }

    .action-group {
      display: flex;
      gap: 12px;
      flex-wrap: wrap;
    }

    .btn {
      padding: 10px 24px;
      font-family: var(--font-family);
      font-size: var(--fs-body);
      letter-spacing: var(--ls-body);
      cursor: pointer;
      border: none;
      transition: opacity 0.2s ease;
      text-decoration: none;
      display: inline-block;
    }

    .btn:hover {
      opacity: 0.85;
    }

    .btn--primary {
      background-color: var(--color-accent);
      color: #fff;
    }

    .btn--danger {
      background-color: transparent;
      color: var(--color-accent);
      border: 2px solid var(--color-accent);
    }

    .notice-success {
      font-size: var(--fs-body);
      color: var(--color-accent);
      font-weight: 500;
    }
  </style>
</head>

<body>
  <nav class="navbar">
    <a href="/php/praktikum-7/dashboard.php" class="navbar-link navbar-link--active">
      <span class="navbar-en">Dashboard</span>
      <span class="navbar-jp">ダッシュボード</span>
    </a>
    <a href="/php/praktikum-7/edit_profile.php" class="navbar-link">
      <span class="navbar-en">Edit Profile</span>
      <span class="navbar-jp">プロフィール編集</span>
    </a>
    <a href="/php/praktikum-7/logout.php" class="navbar-link">
      <span class="navbar-en">Logout</span>
      <span class="navbar-jp">ログアウト</span>
    </a>
  </nav>

  <main class="content-page">
    <h1 class="content-title">ダッシュボード</h1>

    <?php if (isset($_GET['updated'])): ?>
      <p class="notice-success">Profile updated successfully.</p>
    <?php endif; ?>

    <?php if ($user): ?>
      <div class="profile-card">
        <div class="profile-row">
          <span class="profile-label">Full Name</span>
          <span class="profile-value"><?= htmlspecialchars($user['full_name'] ?: '—') ?></span>
        </div>
        <div class="profile-row">
          <span class="profile-label">Username</span>
          <span class="profile-value"><?= htmlspecialchars($user['username']) ?></span>
        </div>
        <div class="profile-row">
          <span class="profile-label">Email</span>
          <span class="profile-value"><?= htmlspecialchars($user['email']) ?></span>
        </div>
        <div class="profile-row">
          <span class="profile-label">Member Since</span>
          <span class="profile-value"><?= htmlspecialchars($user['created_at']) ?></span>
        </div>
      </div>

      <div class="action-group">
        <a href="/php/praktikum-7/edit_profile.php" class="btn btn--primary">Edit Profile</a>
        <form method="post" action="/php/praktikum-7/delete_account.php"
          onsubmit="return confirm('Delete account? This action cannot be undone.');">
          <button type="submit" class="btn btn--danger">Delete Account</button>
        </form>
      </div>
    <?php else: ?>
      <p>Failed to load user data.</p>
    <?php endif; ?>
  </main>
</body>

</html>
