<?php
$filename = "data.txt";

$file = fopen($filename, "r");

if ($file) {
  echo "<pre>";
  while (!feof($file)) {
    $line = fgets($file);
    echo htmlspecialchars($line);
  }
  echo "</pre>";
  fclose($file);
} else {
  echo "Failed opening file.";
}
