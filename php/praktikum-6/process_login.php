<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST["username"] ?? '';
  $password = $_POST["password"] ?? '';

  $users = [
    'admin'  => ['password' => 'admin123',  'role' => 'admin'],
    'member' => ['password' => 'member123', 'role' => 'member'],
  ];

  if (isset($users[$username]) && $users[$username]['password'] === $password) {
    $_SESSION["loggedin"] = true;
    $_SESSION["username"] = $username;
    $_SESSION["role"]     = $users[$username]['role'];

    setcookie('last_user', $username, time() + 86400, '/');

    header("Location: halaman_b.php");
    exit;
  } else {
    header("Location: login.php?error=1");
    exit;
  }
} else {
  header("Location: login.php");
  exit;
}
