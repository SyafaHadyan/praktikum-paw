<?php
require_once __DIR__ . '/db.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header('Location: /php/praktikum-7/login.php');
  exit;
}

$username = trim($_POST['username'] ?? '');
$password = $_POST['password']      ?? '';

try {
  $conn = getConnection();

  $stmt = $conn->prepare("SELECT id, username, password, full_name, email FROM users WHERE username = :username");
  $stmt->execute([':username' => $username]);
  $user = $stmt->fetch();

  if ($user && password_verify($password, $user['password'])) {
    $_SESSION['loggedin']  = true;
    $_SESSION['user_id']   = $user['id'];
    $_SESSION['username']  = $user['username'];
    $_SESSION['full_name'] = $user['full_name'];
    $_SESSION['email']     = $user['email'];

    header('Location: /php/praktikum-7/dashboard.php');
    exit;
  }

  header('Location: /php/praktikum-7/login.php?error=1');
  exit;
} catch (PDOException $e) {
  header('Location: /php/praktikum-7/login.php?error=1');
  exit;
}
