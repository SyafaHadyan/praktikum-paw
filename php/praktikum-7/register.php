<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Register — Praktikum 7</title>
  <link rel="stylesheet" href="/style.css" />
  <style>
    .auth-page {
      display: flex;
      flex-direction: column;
      align-items: center;
      padding: var(--page-padding);
      gap: 24px;
    }

    .auth-title {
      font-size: var(--fs-display);
      line-height: var(--lh-display);
      letter-spacing: var(--ls-display);
      color: var(--color-accent);
      font-weight: 400;
    }

    .auth-card {
      width: 100%;
      max-width: 420px;
      border: 4px solid var(--color-accent);
      padding: 32px;
      display: flex;
      flex-direction: column;
      gap: 16px;
    }

    .auth-card label {
      font-size: var(--fs-body);
      line-height: var(--lh-body);
      letter-spacing: var(--ls-body);
      font-weight: 500;
      display: flex;
      flex-direction: column;
      gap: 6px;
    }

    .auth-card input[type="text"],
    .auth-card input[type="email"],
    .auth-card input[type="password"] {
      padding: 10px 12px;
      border: 2px solid var(--color-accent);
      background: var(--color-bg);
      font-family: var(--font-family);
      font-size: var(--fs-body);
      color: var(--color-text);
      outline: none;
      width: 100%;
    }

    .auth-card input[type="text"]:focus,
    .auth-card input[type="email"]:focus,
    .auth-card input[type="password"]:focus {
      border-color: var(--color-text);
    }

    .auth-card input[type="submit"] {
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

    .auth-card input[type="submit"]:hover {
      opacity: 0.85;
    }

    .auth-notice {
      font-size: var(--fs-body);
      line-height: var(--lh-body);
      letter-spacing: var(--ls-body);
      color: var(--color-accent);
      text-align: center;
    }

    .auth-link {
      font-size: var(--fs-body);
      line-height: var(--lh-body);
      color: var(--color-accent);
      text-align: center;
    }

    .auth-link a {
      color: var(--color-accent);
      font-weight: 700;
    }
  </style>
</head>

<body>
  <nav class="navbar">
    <a href="/php/praktikum-7/login.php" class="navbar-link">
      <span class="navbar-en">Login</span>
      <span class="navbar-jp">ログイン</span>
    </a>
    <a href="/php/praktikum-7/register.php" class="navbar-link navbar-link--active">
      <span class="navbar-en">Register</span>
      <span class="navbar-jp">登録</span>
    </a>
  </nav>

  <main class="auth-page">
    <h1 class="auth-title">登録</h1>

    <?php if (isset($_GET['error'])): ?>
      <?php
      $errors = [
        'duplicate_username' => 'Username is already taken.',
        'duplicate_email'    => 'Email is already in use.',
        'password_mismatch'  => 'Password and confirmation do not match.',
        'db'                 => 'A database error occurred.',
      ];
      $msg = $errors[$_GET['error']] ?? 'An error occurred.';
      ?>
      <p class="auth-notice"><?= htmlspecialchars($msg) ?></p>
    <?php endif; ?>

    <div class="auth-card">
      <form method="post" action="/php/praktikum-7/process_register.php">
        <div style="display:flex;flex-direction:column;gap:16px;">
          <label>
            Full Name
            <input type="text" name="full_name" value="<?= htmlspecialchars($_GET['full_name'] ?? '') ?>" required />
          </label>
          <label>
            Username
            <input type="text" name="username" value="<?= htmlspecialchars($_GET['username'] ?? '') ?>" required />
          </label>
          <label>
            Email
            <input type="email" name="email" value="<?= htmlspecialchars($_GET['email'] ?? '') ?>" required />
          </label>
          <label>
            Password
            <input type="password" name="password" required />
          </label>
          <label>
            Confirm Password
            <input type="password" name="password_confirm" required />
          </label>
          <input type="submit" value="Register" />
        </div>
      </form>
    </div>

    <p class="auth-link">Already have an account? <a href="/php/praktikum-7/login.php">Log in here</a></p>
  </main>
</body>

</html>
