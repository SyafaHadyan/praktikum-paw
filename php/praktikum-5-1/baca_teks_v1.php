<?php
$filename = "data.txt";

$content = file_get_contents($filename);

if ($content !== false) {
  echo "<pre>" . htmlspecialchars($content) . "</pre>";
} else {
  echo "Failed to read file.";
}
