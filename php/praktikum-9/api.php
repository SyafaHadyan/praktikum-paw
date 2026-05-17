<?php
require_once __DIR__ . '/../praktikum-7/db.php';

header('Content-Type: application/json; charset=utf-8');

function respondJson(int $statusCode, array $payload): void
{
  http_response_code($statusCode);
  echo json_encode($payload);
  exit;
}

function postInt(string $key): ?int
{
  if (!isset($_POST[$key])) {
    return null;
  }

  $value = filter_var($_POST[$key], FILTER_VALIDATE_INT);
  if ($value === false || $value < 1) {
    return null;
  }

  return $value;
}

$action = $_GET['action'] ?? '';

if ($action === '') {
  respondJson(400, ['error' => 'Action is required.']);
}

try {
  $conn = getConnection();

  switch ($action) {
    case 'get':
      if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        respondJson(405, ['error' => 'Method not allowed.']);
      }

      $stmt = $conn->query('SELECT id, task, completed FROM tasks ORDER BY id DESC');
      $tasks = $stmt->fetchAll();

      foreach ($tasks as &$task) {
        $task['id'] = (int) $task['id'];
        $task['completed'] = (bool) $task['completed'];
      }
      unset($task);

      respondJson(200, ['tasks' => $tasks]);

    case 'add':
      if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        respondJson(405, ['error' => 'Method not allowed.']);
      }

      $task = trim($_POST['task'] ?? '');
      if ($task === '') {
        respondJson(422, ['error' => 'Task tidak boleh kosong.']);
      }

      $stmt = $conn->prepare('INSERT INTO tasks (task) VALUES (:task)');
      $stmt->execute([':task' => $task]);

      respondJson(201, ['success' => true, 'id' => (int) $conn->lastInsertId()]);

    case 'delete':
      if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        respondJson(405, ['error' => 'Method not allowed.']);
      }

      $id = postInt('id');
      if ($id === null) {
        respondJson(422, ['error' => 'ID task tidak valid.']);
      }

      $stmt = $conn->prepare('DELETE FROM tasks WHERE id = :id');
      $stmt->execute([':id' => $id]);

      if ($stmt->rowCount() === 0) {
        respondJson(404, ['error' => 'Task tidak ditemukan.']);
      }

      respondJson(200, ['success' => true]);

    case 'toggle':
      if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        respondJson(405, ['error' => 'Method not allowed.']);
      }

      $id = postInt('id');
      if ($id === null) {
        respondJson(422, ['error' => 'ID task tidak valid.']);
      }

      $completedRaw = $_POST['completed'] ?? null;
      if ($completedRaw !== '0' && $completedRaw !== '1') {
        respondJson(422, ['error' => 'Status task tidak valid.']);
      }

      $stmt = $conn->prepare('UPDATE tasks SET completed = :completed WHERE id = :id');
      $stmt->execute([
        ':completed' => (int) $completedRaw,
        ':id' => $id,
      ]);

      if ($stmt->rowCount() === 0) {
        $checkStmt = $conn->prepare('SELECT id FROM tasks WHERE id = :id LIMIT 1');
        $checkStmt->execute([':id' => $id]);

        if ($checkStmt->fetch() === false) {
          respondJson(404, ['error' => 'Task tidak ditemukan.']);
        }
      }

      respondJson(200, ['success' => true]);

    default:
      respondJson(400, ['error' => 'Invalid action.']);
  }
} catch (PDOException $e) {
  respondJson(500, ['error' => 'Database error.']);
}
