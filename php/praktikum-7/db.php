<?php
function getConnection(): PDO
{
  $host   = getenv('DB_HOST') ?: 'db';
  $dbname = getenv('DB_NAME') ?: 'praktikum_paw';
  $user   = getenv('DB_USER') ?: 'paw_user';
  $pass   = getenv('DB_PASS') ?: 'paw_pass';

  $dsn  = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
  $conn = new PDO($dsn, $user, $pass);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
  return $conn;
}
