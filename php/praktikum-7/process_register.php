<?php
require_once __DIR__ . '/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header('Location: /php/praktikum-7/register.php');
  exit;
}

$full_name        = trim($_POST['full_name']        ?? '');
$username         = trim($_POST['username']         ?? '');
$email            = trim($_POST['email']            ?? '');
$password         = $_POST['password']              ?? '';
$password_confirm = $_POST['password_confirm']      ?? '';

$query_back = '&full_name=' . urlencode($full_name)
  . '&username=' . urlencode($username)
  . '&email='    . urlencode($email);

if ($password !== $password_confirm) {
  header('Location: /php/praktikum-7/register.php?error=password_mismatch' . $query_back);
  exit;
}

try {
  $conn = getConnection();

  $stmt = $conn->prepare("SELECT id FROM users WHERE username = :username OR email = :email");
  $stmt->execute([':username' => $username, ':email' => $email]);
  $existing = $stmt->fetch();

  if ($existing) {
    $stmt2 = $conn->prepare("SELECT id FROM users WHERE username = :username");
    $stmt2->execute([':username' => $username]);
    if ($stmt2->fetch()) {
      header('Location: /php/praktikum-7/register.php?error=duplicate_username' . $query_back);
    } else {
      header('Location: /php/praktikum-7/register.php?error=duplicate_email' . $query_back);
    }
    exit;
  }

  $hashed = password_hash($password, PASSWORD_DEFAULT);

  $stmt = $conn->prepare(
    "INSERT INTO users (username, email, password, full_name) VALUES (:username, :email, :password, :full_name)"
  );
  $stmt->execute([
    ':username'  => $username,
    ':email'     => $email,
    ':password'  => $hashed,
    ':full_name' => $full_name,
  ]);

  header('Location: /php/praktikum-7/login.php?registered=1');
  exit;
} catch (PDOException $e) {
  header('Location: /php/praktikum-7/register.php?error=db' . $query_back);
  exit;
}
