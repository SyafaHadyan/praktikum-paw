<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login</title>
  <link rel="stylesheet" href="/style.css" />
  <style>
    .login-page {
      display: flex;
      flex-direction: column;
      align-items: center;
      padding: var(--page-padding);
      gap: 24px;
    }

    .login-title {
      font-size: var(--fs-display);
      line-height: var(--lh-display);
      letter-spacing: var(--ls-display);
      color: var(--color-accent);
      font-weight: 400;
    }

    .login-card {
      width: 100%;
      max-width: 400px;
      border: 4px solid var(--color-accent);
      padding: 32px;
      display: flex;
      flex-direction: column;
      gap: 16px;
    }

    .login-card label {
      font-size: var(--fs-body);
      line-height: var(--lh-body);
      letter-spacing: var(--ls-body);
      font-weight: 500;
      display: flex;
      flex-direction: column;
      gap: 6px;
    }

    .login-card input[type="text"],
    .login-card input[type="password"] {
      padding: 10px 12px;
      border: 2px solid var(--color-accent);
      background: var(--color-bg);
      font-family: var(--font-family);
      font-size: var(--fs-body);
      color: var(--color-text);
      outline: none;
      width: 100%;
    }

    .login-card input[type="text"]:focus,
    .login-card input[type="password"]:focus {
      border-color: var(--color-text);
    }

    .login-card input[type="submit"] {
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

    .login-card input[type="submit"]:hover {
      opacity: 0.85;
    }

    .login-notice {
      font-size: var(--fs-body);
      line-height: var(--lh-body);
      letter-spacing: var(--ls-body);
      color: var(--color-accent);
      text-align: center;
    }

    .login-hint {
      font-size: 13px;
      color: var(--color-text);
      opacity: 0.7;
      text-align: center;
      line-height: 1.8;
    }
  </style>
</head>

<body>
  <nav class="navbar">
    <a href="/php/praktikum-6/login.php" class="navbar-link navbar-link--active">
      <span class="navbar-en">Login</span>
      <span class="navbar-jp">ログイン</span>
    </a>
    <a href="/php/praktikum-6/halaman_c.php" class="navbar-link">
      <span class="navbar-en">Page C</span>
      <span class="navbar-jp">ページC</span>
    </a>
  </nav>

  <main class="login-page">
    <h1 class="login-title">ログイン</h1>

    <?php if (isset($_GET['error'])): ?>
      <p class="login-notice">Username atau password salah.</p>
    <?php endif; ?>
    <?php if (isset($_GET['logout'])): ?>
      <p class="login-notice">Berhasil logout.</p>
    <?php endif; ?>

    <div class="login-card">
      <form method="post" action="/php/praktikum-6/process_login.php">
        <div style="display:flex;flex-direction:column;gap:16px;">
          <label>
            Username
            <input type="text" name="username" required />
          </label>
          <label>
            Password
            <input type="password" name="password" required />
          </label>
          <input type="submit" value="Login" />
        </div>
      </form>
    </div>

    <p class="login-hint">
      admin &nbsp;/&nbsp; admin123<br />
      member &nbsp;/&nbsp; member123
    </p>
  </main>
</body>

</html>
