<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
  header('Location: /php/praktikum-7/login.php');
  exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header('Location: /php/praktikum-7/dashboard.php');
  exit;
}

require_once __DIR__ . '/db.php';

try {
  $conn = getConnection();

  $stmt = $conn->prepare("DELETE FROM users WHERE id = :id");
  $stmt->execute([':id' => $_SESSION['user_id']]);
} catch (PDOException $e) {
  header('Location: /php/praktikum-7/dashboard.php');
  exit;
}

session_destroy();

header('Location: /php/praktikum-7/login.php?deleted=1');
exit;
