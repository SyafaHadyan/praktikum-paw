<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
  header('Location: /php/praktikum-7/login.php');
  exit;
}

require_once __DIR__ . '/db.php';

try {
  $conn = getConnection();
  $stmt = $conn->prepare("SELECT id, username, email, full_name FROM users WHERE id = :id");
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
  <title>Edit Profil — Praktikum 7</title>
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

    .edit-card {
      width: 100%;
      max-width: 480px;
      border: 4px solid var(--color-accent);
      padding: 32px;
      display: flex;
      flex-direction: column;
      gap: 16px;
    }

    .edit-card label {
      font-size: var(--fs-body);
      line-height: var(--lh-body);
      letter-spacing: var(--ls-body);
      font-weight: 500;
      display: flex;
      flex-direction: column;
      gap: 6px;
    }

    .edit-card input[type="text"],
    .edit-card input[type="email"],
    .edit-card input[type="password"] {
      padding: 10px 12px;
      border: 2px solid var(--color-accent);
      background: var(--color-bg);
      font-family: var(--font-family);
      font-size: var(--fs-body);
      color: var(--color-text);
      outline: none;
      width: 100%;
    }

    .edit-card input[type="text"]:focus,
    .edit-card input[type="email"]:focus,
    .edit-card input[type="password"]:focus {
      border-color: var(--color-text);
    }

    .edit-card input[type="submit"] {
      padding: 12px;
      background-color: var(--color-accent);
      color: #fff;
      border: none;
      font-family: var(--font-family);
      font-size: var(--fs-body);
      letter-spacing: var(--ls-body);
      cursor: pointer;
      transition: opacity 0.2s ease;
    }

    .edit-card input[type="submit"]:hover {
      opacity: 0.85;
    }

    .field-hint {
      font-size: 12px;
      opacity: 0.6;
      font-weight: 400;
    }

    .auth-notice {
      font-size: var(--fs-body);
      color: var(--color-accent);
    }
  </style>
</head>

<body>
  <nav class="navbar">
    <a href="/php/praktikum-7/dashboard.php" class="navbar-link">
      <span class="navbar-en">Dashboard</span>
      <span class="navbar-jp">ダッシュボード</span>
    </a>
    <a href="/php/praktikum-7/edit_profile.php" class="navbar-link navbar-link--active">
      <span class="navbar-en">Edit Profile</span>
      <span class="navbar-jp">プロフィール編集</span>
    </a>
    <a href="/php/praktikum-7/logout.php" class="navbar-link">
      <span class="navbar-en">Logout</span>
      <span class="navbar-jp">ログアウト</span>
    </a>
  </nav>

  <main class="content-page">
    <h1 class="content-title">プロフィール編集</h1>

    <?php if (isset($_GET['error'])): ?>
      <?php
      $errors = [
        'duplicate_username' => 'Username is already taken by another account.',
        'duplicate_email'    => 'Email is already in use by another account.',
        'password_mismatch'  => 'New password and confirmation do not match.',
        'wrong_password'     => 'Current password is incorrect.',
        'db'                 => 'A database error occurred.',
      ];
      $msg = $errors[$_GET['error']] ?? 'An error occurred.';
      ?>
      <p class="auth-notice"><?= htmlspecialchars($msg) ?></p>
    <?php endif; ?>

    <?php if ($user): ?>
      <div class="edit-card">
        <form method="post" action="/php/praktikum-7/process_edit.php">
          <div style="display:flex;flex-direction:column;gap:16px;">
            <label>
              Full Name
              <input type="text" name="full_name"
                value="<?= htmlspecialchars($user['full_name']) ?>" required />
            </label>
            <label>
              Username
              <input type="text" name="username"
                value="<?= htmlspecialchars($user['username']) ?>" required />
            </label>
            <label>
              Email
              <input type="email" name="email"
                value="<?= htmlspecialchars($user['email']) ?>" required />
            </label>
            <label>
              Current Password
              <input type="password" name="current_password" required />
            </label>
            <label>
              New Password
              <span class="field-hint">(leave blank to keep current password)</span>
              <input type="password" name="new_password" />
            </label>
            <label>
              Confirm New Password
              <input type="password" name="new_password_confirm" />
            </label>
            <input type="submit" value="Save Changes" />
          </div>
        </form>
      </div>
    <?php else: ?>
      <p>Failed to load user data.</p>
    <?php endif; ?>
  </main>
</body>

</html>
