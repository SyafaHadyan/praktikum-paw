<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
  header('Location: /php/praktikum-7/login.php');
  exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header('Location: /php/praktikum-7/edit_profile.php');
  exit;
}

require_once __DIR__ . '/db.php';

$full_name           = trim($_POST['full_name']           ?? '');
$username            = trim($_POST['username']            ?? '');
$email               = trim($_POST['email']               ?? '');
$current_password    = $_POST['current_password']         ?? '';
$new_password        = $_POST['new_password']             ?? '';
$new_password_confirm = $_POST['new_password_confirm']    ?? '';

try {
  $conn = getConnection();

  $stmt = $conn->prepare("SELECT password FROM users WHERE id = :id");
  $stmt->execute([':id' => $_SESSION['user_id']]);
  $user = $stmt->fetch();

  if (!$user || !password_verify($current_password, $user['password'])) {
    header('Location: /php/praktikum-7/edit_profile.php?error=wrong_password');
    exit;
  }

  if ($new_password !== '' && $new_password !== $new_password_confirm) {
    header('Location: /php/praktikum-7/edit_profile.php?error=password_mismatch');
    exit;
  }

  $stmt = $conn->prepare(
    "SELECT id FROM users WHERE (username = :username OR email = :email) AND id != :id"
  );
  $stmt->execute([':username' => $username, ':email' => $email, ':id' => $_SESSION['user_id']]);
  $conflict = $stmt->fetch();

  if ($conflict) {
    $stmt2 = $conn->prepare("SELECT id FROM users WHERE username = :username AND id != :id");
    $stmt2->execute([':username' => $username, ':id' => $_SESSION['user_id']]);
    if ($stmt2->fetch()) {
      header('Location: /php/praktikum-7/edit_profile.php?error=duplicate_username');
    } else {
      header('Location: /php/praktikum-7/edit_profile.php?error=duplicate_email');
    }
    exit;
  }

  if ($new_password !== '') {
    $hashed = password_hash($new_password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare(
      "UPDATE users SET full_name = :full_name, username = :username, email = :email, password = :password WHERE id = :id"
    );
    $stmt->execute([
      ':full_name' => $full_name,
      ':username'  => $username,
      ':email'     => $email,
      ':password'  => $hashed,
      ':id'        => $_SESSION['user_id'],
    ]);
  } else {
    $stmt = $conn->prepare(
      "UPDATE users SET full_name = :full_name, username = :username, email = :email WHERE id = :id"
    );
    $stmt->execute([
      ':full_name' => $full_name,
      ':username'  => $username,
      ':email'     => $email,
      ':id'        => $_SESSION['user_id'],
    ]);
  }

  $_SESSION['username']  = $username;
  $_SESSION['full_name'] = $full_name;
  $_SESSION['email']     = $email;

  header('Location: /php/praktikum-7/dashboard.php?updated=1');
  exit;
} catch (PDOException $e) {
  header('Location: /php/praktikum-7/edit_profile.php?error=db');
  exit;
}
